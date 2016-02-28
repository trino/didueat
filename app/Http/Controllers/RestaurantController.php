<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Models\Profiles;
use App\Http\Models\Restaurants;

class RestaurantController extends Controller {

    /**
     * Constructor
     * @param null
     * @return redirect
     */
    public function __construct() {
        date_default_timezone_set('America/Toronto');
        $this->beforeFilter(function () {
            initialize("restaurants");
        });
    }

    /**
     * Restaurants List
     * @param null
     * @return view
     */
    public function index() {
        $data['title'] = 'Restaurants List';
        return view('dashboard.restaurant.index', $data);
    }
    
    /**
     * Listing Ajax
     * @return Response
     */
    public function listingAjax() {
        $per_page = \Input::get('showEntries');
        $page = \Input::get('page');
        $cur_page = $page;
        $page -= 1;
        $start = $page * $per_page;

        $data = array(
            'page' => $page,
            'cur_page' => $cur_page,
            'per_page' => $per_page,
            'start' => $start,
            'meta' => (\Input::get('meta')) ? \Input::get('meta') : 'id',
            'order' => (\Input::get('order')) ? \Input::get('order') : 'DESC',
            'searchResults' => \Input::get('searchResults'),
            'incomplete' => false
        );

        if(isset($_GET["incomplete"])){
            $data["incomplete"] = true;
        }
        
        $Query = \App\Http\Models\Restaurants::listing($data, "list")->get();
        $recCount = \App\Http\Models\Restaurants::listing($data)->count();
        $no_of_paginations = ceil($recCount / $per_page);
        
        $data['Query'] = $Query;
        $data['recCount'] = $recCount;
        $data['Pagination'] = getPagination($recCount, $no_of_paginations, $cur_page, TRUE, TRUE, TRUE, TRUE);
        $data["_GET"] = $_GET;
        
        \Session::flash('message', \Input::get('message'));
        return view('dashboard.restaurant.ajax.list', $data);
    }

    /**
     * Restaurant Delete
     * @param $id (which restaurant to delete)
     * @return redirect
     */
    public function restaurantDelete($id = 0) {
        if (!isset($id) || empty($id) || $id == 0) {//check for missing data
            return $this->failure("[Restaurant Id] field is missing!", 'restaurant/list');
        }

        try {
            $ob = \App\Http\Models\Restaurants::find($id);
            $ob->delete();
            
            event(new \App\Events\AppEvents($ob, "Restaurant Deleted"));

            //delete it's menus
            $menus = \App\Http\Models\Menus::where('restaurant_id', $id)->get();
            foreach ($menus as $menu) {
                \App\Http\Models\Menus::where('id', $menu->id)->delete();
                if ($menu->parent == '0') {
                    $dir = public_path('assets/images/restaurants/' . $id . "/menus/" . $menu->id);
                    $this->deleteDir($dir);
                }
            }
            //delete it's images
            $dir = public_path('assets/images/restaurants/' . $id);
            $this->deleteDir($dir);
            return $this->success("Restaurant has been deleted successfully!",'restaurant/list');
        } catch (\Exception $e) {
            return $this->failure(handleexception($e), 'restaurant/list');
        }
    }

    /**
     * Toggle Restaurant $id's Status
     * @param $id
     * @return redirect
     */
    public function restaurantStatus($id = 0) {
        if (!isset($id) || empty($id) || $id == 0) {//check for missing data
            return $this->failure("[Restaurant Id] is missing!", 'restaurant/list');
        }

        try {
            $ob = \App\Http\Models\Restaurants::find($id);
            if ($ob->open == 1) {
                $ob->populate(array('open' => 0));
            } else {
                $ob->populate(array('open' => 1));
            }
            $ob->save();
            
            event(new \App\Events\AppEvents($ob, "Restaurant Status Changed"));
            return $this->success('Restaurant status has been changed to: ' . iif($ob->open, "open", "closed"), 'restaurant/list');
        } catch (\Exception $e) {
            return $this->failure(handleexception($e), 'restaurant/list');
        }
    }

    /**
     * create a New Restaurant
     * @param null
     * @return view
     */
    public function addRestaurants() {
// Note: HomeController.php is what is actually used to add new restaurant, not this file, which is used to update/edit a restaurant
        $post = \Input::all();//check for missing data
        if (isset($post) && count($post) > 0 && !is_null($post)) {
            try {//populate data array from the post
                $ob = \App\Http\Models\Restaurants::findOrNew(0);
                $ob->populate(array(),false);
                $ob->save();

                $this->restaurantInfo($ob->id);
                return $this->success('Restaurant created successfully!', '/restaurant/list');
            } catch (\Exception $e) {
                return $this->failure("RestaurantController/addRestaurants:" . handleexception($e), '/restaurant/add/new');
            }
        } else {
            $data['title'] = "Add New Restaurants";
//            $data['countries_list'] = \App\Http\Models\Countries::get();
//            $data['cuisine_list'] = \App\Http\Models\Cuisine::get();
            
//            $data['cuisine_list'] = array('Canadian','American','Italian','Italian/Pizza','Chinese','Vietnamese','Japanese','Thai','French','Greek','Pizza','Desserts','Pub','Sports','Burgers','Vegan','German','Fish and Chips');
            $data['cuisine_list'] = cuisinelist();
            return view('dashboard.restaurant.addrestaurant', $data);
        }
    }

    /**
     * edits restaurant data
     * @param null
     * @return view
     */
    public function restaurantInfo($id = 0, $DoProfile = false) {
        $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {//check for missing data
            if(!isset($post['id'])){$post['id']=$id;}
            if (!isset($post['restname']) || empty($post['restname'])) {
                return $this->failure("[Restaurant Name] field is missing!", 'restaurant/info/' . $post['id']);
            }
            /*if (!isset($post['country']) || empty($post['country'])) {
                return $this->failure("[Country] field is missing!", 'restaurant/info/' . $post['id']);
            }
            if (!isset($post['postal_code']) || empty(clean_postalcode($post['postal_code']))) {
                return $this->failure("[Postal Code] field is missing or invalid!", 'restaurant/info/' . $post['id']);
            }
            if (!isset($post['city']) || empty($post['city'])) {
                return $this->failure("[City] field is missing!", 'restaurant/info/' . $post['id']);
            }
            */
            try {
                $update=$post;
                $addlogo='';
                $ob = \App\Http\Models\Restaurants::findOrNew($post['id']);

                // logo update will not work until after a restaurant is signed up
                
                if (isset($post['restLogoTemp']) && $post['restLogoTemp'] != '') {
                    $im = explode('.', urldecode($post['logo']));
                    $ext = end($im);
                    $newName=$ob->slug.".".$ext;
    
                    $destinationPath = public_path('assets/images/restaurants/'.urldecode($post['id']));
                    
                    $imgVs=getimagesize($destinationPath."/".$post['logo']);
    
                    if (!file_exists($destinationPath)) {
                        mkdir('assets/images/restaurants/' . $post['id'], 0777, true);
                    }
                    else{
                     // rename existing images with timestamp, if they exist,
                     
                        $oldImgExpl=explode(".",$ob->logo);
                        $todaytime = date("Ymdhis");
                        foreach(array("/icon-", "/small-", "/big-") as $file){ 
                          if(file_exists($destinationPath.$file.$ob->logo)){
                            rename($destinationPath.$file.$ob->logo, $destinationPath.$file.$oldImgExpl[0] . "_" . $todaytime . "." . $oldImgExpl[1]);
                          }
                        }
                       if(file_exists($destinationPath.$file.$ob->logo)){ // for original file with no prefix
                         rename($destinationPath."/".$ob->logo, $destinationPath."/".$oldImgExpl[0] . "_" . $todaytime . "." . $oldImgExpl[1]);
                       }
                    }
                    

                    $filename = $destinationPath . "/" . $newName;
                    // use for copying and saving (can't use move_uploaded_file() because jQuery uploads it before php is called)
                    $thisresult=copy($post['restLogoTemp'],$destinationPath.'/'.$newName);
                    
                    $sizes = ['assets/images/restaurants/' . urldecode($post['id']) . '/icon-' => TINY_THUMB, 'assets/images/restaurants/' . urldecode($post['id']) . '/small-' => MED_THUMB, 'assets/images/restaurants/' . urldecode($post['id']) . '/big-' => BIG_SQ];


/*

                    // decide if img size is too small to make larger img size, and to determine if the largest size will be portrait or landscape
                    ($imgVs[0] > $imgVs[1])? $largImg=MAX_IMG_SIZE_L : $largImg=MAX_IMG_SIZE_P;
                    
                    ($imgVs[0] > 362)? $sizes['assets/images/restaurants/' . urldecode($post['id']) . '/med-']=BIG_SQ : $sizes['assets/images/restaurants/' . urldecode($post['id']) . '/med-']=$imgVs[0].'x'.$imgVs[1];
                    ($imgVs[0] < 800 && $imgVs[1] < 800)? $sizes['assets/images/restaurants/' . urldecode($post['id']) . '/big-']=$imgVs[0].'x'.$imgVs[1] : $sizes['assets/images/restaurants/' . urldecode($post['id']) . '/big-']=$largImg;

*/




                    copyimages($sizes, $filename, $newName, true);

                    @unlink($destinationPath.'/'.$post['logo']); // delete temp upload image
                    $update['logo'] = $newName; // db needs updating, in case img type changed - eg. png to jpg
                    $addlogo=true;
                }

/*
<!--                 
                    if (isset($post['logo']) && $post['logo'] && $id) {
                    $im = explode('.', $post['logo']);
                    $ext = end($im);
                    $res = \App\Http\Models\Restaurants::findOrNew($post['id']);
                    $newName = $res->logo;
                    if ($newName != $post['logo']){
                        $newName = $res->slug . '.' . $ext;
                        if(file_exists(public_path('assets/images/restaurants/'.$post['id'].'/'.$newName))){
                            @unlink(public_path('assets/images/restaurants/'.$post['id'].'/'.$newName));
                        }
                    }
                    if (!file_exists(public_path('assets/images/restaurants/' . $post['id']))) {
                        mkdir('assets/images/restaurants/' . $post['id'], 0777, true);
                    }
                    $destinationPath = public_path('assets/images/restaurants/' . $post['id']);
                    $filename = $destinationPath . "/" . $newName;
                    copy(public_path('assets/images/restaurants/' . $post['logo']), $filename);
                    @unlink(public_path('assets/images/restaurants/' . $post['logo']));
                    $sizes = ['assets/images/restaurants/' . $post['id'] . '/thumb_' => MED_THUMB, 'assets/images/restaurants/' . $post['id'] . '/thumb1_' => SMALL_THUMB];
                    copyimages($sizes, $filename, $newName);
                    $update['logo'] = $newName;
                    $addlogo=true;
                }
 -->
*/

                $update['name'] = $post['restname'];
                if (!$post['id']){
                    $update['slug'] = $this->createslug($post['restname']);
                }

                $Fields = array("email", "apartment", "phone", "description", "city", "country", "tags", "postal_code", "cuisine" => "cuisines", "province", "address" => "formatted_address", "formatted_address" => "formatted_addressForDB");
                foreach($Fields as $key => $value){
                    if(is_numeric($key)){
                        $key = $value;
                    }
                    if(isset($post[$value])) {$update[$key] = $post[$value];}
                }
                $update['is_pickup'] = (isset($post['is_pickup']))?1:0;
                $update['is_delivery'] = (isset($post['is_delivery']))?1:0;
                $update['delivery_fee'] = (isset($post['is_delivery']))?$post['delivery_fee']:0;
                $update['minimum'] = (isset($post['is_delivery']))?$post['minimum']:0;
                $update['max_delivery_distance'] = (isset($post['is_delivery']))?$post['max_delivery_distance']:0;
                $update['initialReg'] = 0; // only true after initial registration

                if(isset($update["claim"]) && $update["claim"]){
                    $update = array_filter($update);
                }

                $ob->populate($update,$addlogo);
                $isnowopen = $ob->save();

                if(!$post['id']){
                    $post['id'] = $ob->id;
                }

                // first delete all existing cuisines for this restaurant in cuisines table, then add new ones
                $restCuisine_ids = \App\Http\Models\Cuisines::where('restID', $post['id'])->get();
                foreach ($restCuisine_ids as $c) {
                    \App\Http\Models\Cuisines::where('id', $c->id)->delete();
                }
                
                // add cuisines separately to table, with foreign key restID
                $cuisinesExpl = explode(",",$post['cuisines']);
                $cuisinesExplCnt=count($cuisinesExpl);
                for($i=0;$i<$cuisinesExplCnt;$i++){
                    \App\Http\Models\Cuisines::makenew(array('restID' => $post['id'], 'cuisine' => $cuisinesExpl[$i]));
                }

                if($DoProfile){
                    $update=$post;
                    $restaurant_id = $post['id'];
                    unset($update["id"]);
                    //$update = \App\Http\Models\Profiles::makenew($update); $update = login($update);
                    $this->registeruser("RestaurantController@restaurantInfo", $update, 2, $restaurant_id, false, read("id"), true);
                }

                event(new \App\Events\AppEvents($ob, "Restaurant " . iif($id, "Updated", "Created")));
                (!isset($id))? $upCr=" Profile Has Been Updated" : $upCr=" Registration Completed";
                return $this->success(iif($isnowopen, "Your restaurant is now open", "Restaurant".$upCr), 'restaurant/info/' . $post['id']);
            } catch (\Exception $e) {
                return $this->failure(handleexception($e), 'restaurant/info/' . $post['id']);
            }
        } else {
// not from submit, so load data
            $data['title'] = "Resturant Manage";
//            $data['countries_list'] = \App\Http\Models\Countries::get();
//            $data['cuisine_list'] = \App\Http\Models\Cuisine::get();

//            $data['cuisine_list'] = array('Canadian','American','Italian','Italian/Pizza','Chinese','Vietnamese','Japanese','Thai','French','Greek','Pizza','Desserts','Pub','Sports','Burgers','Vegan','German','Fish and Chips');
            $data['cuisine_list'] = cuisinelist();
            $data['resturant'] = \App\Http\Models\Restaurants::find(($id > 0) ? $id : \Session::get('session_restaurant_id'));
            $data["route"] = \Route::getCurrentRoute()->getPath();
            return view('dashboard.restaurant.info', $data);
        }
    }

    /**
     * Manu Manager
     * @param null
     * @return view
     */
    public function menuManager() {
        $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {//check for missing data
            //echo '<pre>'; print_r($post); die;
            if (!isset($post['menu_item']) || empty($post['menu_item'])) {
                return $this->failure("[Menu Item] field is missing!", 'restaurant/menus-manager');
            }
            if (!isset($post['price']) || empty($post['price'])) {
                return $this->failure("[Price] field is missing!", 'restaurant/menus-manager');
            }
            if (!isset($post['description']) || empty($post['description'])) {
                //return $this->failure("[Description] field is missing!", 'restaurant/menus-manager');
            }
            if (!\Input::hasFile('menu_image')) {
                return $this->failure("[Image] field is missing!", 'restaurant/menus-manager');
            }

            try {
                
                if (\Input::hasFile('menu_image')) {//handle uploading of image
                    $image = \Input::file('menu_image');
                    $ext = $image->getClientOriginalExtension();
                    $newName = substr(md5(uniqid(rand())), 0, 8) . '.' . $ext;
                    $destinationPath = public_path('assets/images/products');
                    $image->move($destinationPath, $newName);
                    $post['image'] = $newName;
                }

                //populate data array with $_POST
                $item['restaurant_id'] = \Session::get('session_restaurant_id');
                $item['menu_item'] = $post['menu_item'];
                $item['price'] = $post['price'];
                if(isset($post['description'])){$item['description'] = $post['description'];}
                $item['image'] = $post['image'];
                $item['has_addon'] = (count($post['addon_menu_item']) > 0) ? 1 : 0;
                $item['parent'] = 0;
                $item['display_order'] = \App\Http\Models\Menus::count();

                $ob = new \App\Http\Models\Menus();
                $ob->populate($item);
                $ob->save();

                //save each addon and sub item
                foreach ($post['addon_menu_item'] as $key => $value) {
                    $addon['restaurant_id'] = \Session::get('session_restaurant_id');
                    $addon['menu_item'] = $value;
                    $addon['description'] = $post['addon_description'][$key];
                    $addon['req_opt'] = $post['req_opt'][$key];
                    $addon['sing_mul'] = $post['sing_mul'][$key];
                    $addon['exact_upto'] = $post['exact_upto'][$key];
                    $addon['exact_upto_qty'] = $post['exact_upto_qty'][$key];
                    $addon['has_addon'] = 0;
                    $addon['parent'] = $ob->id;
                    $addon['display_order'] = $ob->display_order + 1;

                    $ob2 = new \App\Http\Models\Menus();
                    $ob2->populate($addon);
                    $ob2->save();

                    foreach ($post['sub_menu_item'][$key] as $key2 => $value2) {
                        $subitem['restaurant_id'] = \Session::get('session_restaurant_id');
                        $subitem['menu_item'] = $value2;
                        $subitem['price'] = $post['sub_price'][$key][$key2];
                        $subitem['has_addon'] = 0;
                        $subitem['parent'] = $ob2->id;
                        $subitem['display_order'] = $ob2->display_order + 1;

                        $ob3 = new \App\Http\Models\Menus();
                        $ob3->populate($subitem);
                        $ob3->save();
                    }
                }

                return $this->success("Item menus added successfully", 'restaurant/menus-manager');
            } catch (\Exception $e) {
                return $this->failure(handleexception($e), 'restaurant/menus-manager');
            }
        } else {
            $data['title'] = 'Menus';
            $data['menus_list'] = \App\Http\Models\Menus::where('restaurant_id', \Session::get('session_restaurant_id'))->where('parent', 0)->orderBy('display_order', 'ASC')->get();
            return view('dashboard.restaurant.menus', $data);
        }
    }

    //returns addons for $parent, or false if it doesn't have any
    public function displayAddon($parent) {
        $data = \App\Http\Models\Menus::where('parent', $parent)->orderBy('display_order', 'ASC')->get();
        if ($data) {
            return $data;
        }
        return false;
    }

    //return a menu item and it's child items
    public function menu_form($id, $res_id = 0) {
        $data['menu_id'] = $id;
        if(!$res_id){
            $res_id = \Session::get('session_restaurant_id');
        }

        $data['res_id'] = $res_id;
        $data['res_slug'] = select_field('restaurants', 'id', $res_id, 'slug');
        $data['category'] = \App\Http\Models\Category::orderBy('display_order', 'ASC')->get();

        if ($id != 0) {
            $data['model'] = \App\Http\Models\Menus::where('id', $id)->get()[0];
            $data['cmodel'] = \App\Http\Models\Menus::where('parent', $id)->orderBy('display_order', 'ASC')->get();
            $data['ccount'] = \App\Http\Models\Menus::where('parent', $id)->count();
        }

        return view('dashboard.restaurant.menu_form', $data);
    }

    //get more menu items
    public function getMore($id) {
        return $cchild = \App\Http\Models\Menus::where('parent', $id)->orderBy('display_order', 'ASC')->get();
    }

    public function additional() {
        return view('dashboard.restaurant.additional');
    }

    //handle image uploading and thumbnail generation
    public function uploadimg($type = '', $setSize = true) {
        //echo "test";die();
        
        if(isset($_REQUEST['setSize']) && $_REQUEST['setSize'] == "No"){
           $setSize=false;
        }

        
        if (isset($_FILES['myfile']['name']) && $_FILES['myfile']['name']) {
            $name = $_FILES['myfile']['name'];
            $arr = explode('.', $name);
            $ext = end($arr);
            $file = date('YmdHis') . '.' . $ext;
            $MakeCornerTransparent = false;
            
            ($setSize)? $sizes=true : $sizes=false; // use false if thumbs will be created when page is saved
            
            if ($type == 'restaurant') {
                $RestaurantID = read("restaurant_id");
                $path = 'assets/images/restaurants/' . $RestaurantID;
//                edit_database("restaurants", "id", $RestaurantID, array("logo" => $file));  // added in restaurantInfo()
            } else if ($type == 'user') {
                $path = 'assets/images/users/' . read("id");
//                \App\Http\Models\ProfilesImages::makenew(array('filename' => $file, 'user_id' => read("id")));  // added in dashboard()
            } else {
                $path = 'assets/images/products';
                $sizes=false;//where do these go? Shouldn't there be a product ID? -> temp img uploaded into /products, and deleted after rendering sizes
            }
            if(!is_dir(public_path($path))){
                mkdir(public_path($path));
            }
            move_uploaded_file($_FILES['myfile']['tmp_name'], public_path($path) . '/' . $file);
            if($sizes){
                $sizes = [$path . '/icon-' => TINY_THUMB, $path . '/small-' => MED_THUMB];
                copyimages($sizes, public_path($path) . '/' . $file, $file, false, true);
            }
            $file_path = url() . "/" . $path . "/" . $file;
            echo $file_path . '___' . $file;
        }
        die();
    }

    //add a menu item
    public function menuadd() {
    // for editing too
        \Session::flash('message', \Input::get('message'));
        $arr['uploaded_by'] = \Session::get('session_ID');

        //copy these keys to the $arr
        $Copy = array('menu_item', 'price', 'description', 'image', 'parent', 'has_addon', 'sing_mul', 'exact_upto', 'exact_upto_qty', 'req_opt', 'has_addon', 'display_order', 'cat_id','has_discount','days_discount','discount_per','is_active','restaurant_id','cat_name');
             
        foreach ($Copy as $Key) {
            if (isset($_POST[$Key])) {
                $arr[$Key] = $_POST[$Key];
                if($Key=='cat_id')
                $arr[$Key] = 1;
            }
        }
        if (!is_numeric($arr['cat_id'])) {
            $arrs['title'] = $arr['cat_id'];
            $arrs['res_id'] = $arr['restaurant_id'];
            $ob2 = new \App\Http\Models\Category();
            $ob2->populate($arrs);
            $ob2->save();
            $arr['cat_id'] = $ob2->id;
        }

        if (isset($_GET['id']) && $_GET['id']) { // modifying existing menu item with new image
            $id = $_GET['id'];
            
            $existingImg=\App\Http\Models\Menus::where('id', $id)->pluck('image');
            
            \App\Http\Models\Menus::where('id', $id)->update($arr);
            
           //var_dump($arr);
            //delete all child items
            $child = \App\Http\Models\Menus::where('parent', $id)->get();
            foreach ($child as $c) {
                \App\Http\Models\Menus::where('parent', $c->id)->delete();
            }
            \App\Http\Models\Menus::where('parent', $id)->delete();
            echo $id;
            // upload, rename, and resize images
            $mns = \App\Http\Models\Menus::where('id', $id)->get()[0];
            if ($mns->parent == '0') {
                $image_file = $mns->image;
                $destinationPath = public_path('assets/images/products');
		              $filename = $destinationPath . "/" . $image_file;	  
                $oldImgExpl=explode(".",$existingImg);

                    $uploadedImgExpl = explode('.', $image_file);
                    $ext = end($uploadedImgExpl);
                    $newName = $id . '.' . $ext;
                    
                    if (isset($arr['image']) && $arr['image'] != '') {
                    // means image is being uploaded, not just changes to the menu text and options

	                     $imgVs=getimagesize($destinationPath."/".$arr['image']);
                      
                      $destinationPathMenu = public_path('assets/images/restaurants/' . $mns->restaurant_id . '/menus/' . $id);

			                    if (!file_exists($destinationPathMenu)) {
			                        mkdir('assets/images/restaurants/' . $mns->restaurant_id . '/menus/' . $id, 0777, true);
			                    }

		                     // rename existing images with timestamp, if they exist,
		                     $todaytime = date("Ymdhis");
		                     foreach(array("icon-", "small-", "big-") as $file){
                            if(file_exists($destinationPathMenu . '/' . $file . $existingImg)){
                                rename($destinationPathMenu.'/' . $file . $existingImg, $destinationPathMenu.'/' . $file . $oldImgExpl[0] . "_" . $todaytime . "." . $oldImgExpl[1]);
                            }
                        }
                     
                       if(file_exists($destinationPathMenu . '/' . $file . $existingImg)){ // for original file with no prefix
                           rename($destinationPathMenu.'/'.$existingImg, $destinationPathMenu.'/'.$oldImgExpl[0] . "_" . $todaytime . "." . $oldImgExpl[1]);
                       }

                       $thisresult=copy($filename,$destinationPathMenu.'/'.$newName);// use for copying and naming, then rename with big- prefix
                    
                    $sizes = ['assets/images/restaurants/' . $mns->restaurant_id . '/menus/' . $id . '/icon-' => TINY_THUMB, 'assets/images/restaurants/' . $mns->restaurant_id . '/menus/' . $id . '/small-' => MED_THUMB, 'assets/images/restaurants/' . $mns->restaurant_id . '/menus/' . $id . '/big-' => BIG_SQ];


/*
                    // decide if img size is too small to make larger img size, and to determine if the largest size will be portrait or landscape
                    ($imgVs[0] > $imgVs[1])? $largImg=MAX_IMG_SIZE_L : $largImg=MAX_IMG_SIZE_P;
                    
                    ($imgVs[0] > 362)? $sizes['assets/images/restaurants/' . $mns->restaurant_id . '/menus/' . $id . '/med-']=BIG_SQ : $sizes['assets/images/restaurants/' . $mns->restaurant_id . '/menus/' . $id . '/med-']=$imgVs[0].'x'.$imgVs[1];
                    ($imgVs[0] < 800 && $imgVs[1] < 800)? $sizes['assets/images/restaurants/' . $mns->restaurant_id . '/menus/' . $id . '/big-']=$imgVs[0].'x'.$imgVs[1] : $sizes['assets/images/restaurants/' . $mns->restaurant_id . '/menus/' . $id . '/big-']=$largImg;
                    
*/


                    copyimages($sizes, $filename, $newName, true);

                    @unlink($destinationPath.'/'.$arr['image']); // delete temp upload image
                    
			                 $men = new \App\Http\Models\Menus();
                    // as with logo upload, this step should be incorporated with the rest of the db call in this fn, so as not to overuse db
			                 $men->where('id', $id)->update(['image' => $newName]); // same menu # but filetype may have changed
			                    
                  }
                   
            }
            die();
        } else { // new menu item image upload
            $arr['uploaded_on'] = date('Y-m-d H:i:s');
            $orders_mod = \App\Http\Models\Menus::where('restaurant_id', \Session::get('session_restaurant_id'))->where('parent', 0)->orderBy('display_order', 'desc')->get();
            if (is_array($orders_mod) && count($orders_mod)) {//if the restaurant has more than 0 menus, get the first one
                $orders = $orders_mod[0];
                if (!isset($arr['display_order'])) {
                    $arr['display_order'] = $orders->display_order + 1;//if it doesn't have a display order, make them sequential
                }
            }

            $ob2 = new \App\Http\Models\Menus();
            $ob2->populate($arr);
            $ob2->save();//save changes

            echo $id = $ob2->id;
            

            $mns = \App\Http\Models\Menus::where('id', $id)->get()[0];
            if ($mns->parent == '0') {//handle image uploading and thumbnail generation                
                $image_file = $mns->image; // use for naming and renaming
                $destinationPath = public_path('assets/images/products');
                $existingImg = $destinationPath . "/" . $image_file;
                
                if (isset($arr['image']) && $arr['image'] != '') {
                    // means image is being uploaded, not just changes to the menu text and options

	                   $imgVs=getimagesize($destinationPath."/".$arr['image']);
   
                    $imgExp = explode('.', $arr['image']);
                    $ext = end($imgExp);
                    $newName = $id . '.' . $ext;

                   if($image_file != "" && $image_file != "undefined"){

                    if (!file_exists(public_path('assets/images/restaurants/' . $mns->restaurant_id . '/menus/' . $id))) {
			                        mkdir('assets/images/restaurants/' . $mns->restaurant_id . '/menus/' . $id, 0777, true);
			                    }
                    
                    $destinationPathMenu = public_path('assets/images/restaurants/' . $mns->restaurant_id . '/menus/' . $id);
			                 $filename = $destinationPathMenu . '/' . $newName;

                     // rename existing images with timestamp, if they exist,
                     
                        $oldImgExpl=explode(".",$image_file);
                     
                        $todaytime = date("Ymdhis");                        
	 	                     foreach(array("icon-", "small-", "big-") as $file){
                            if(file_exists($destinationPathMenu . '/' . $file . $image_file)){
                                rename($destinationPathMenu.'/' . $file . $image_file, $destinationPathMenu.'/' . $file . $oldImgExpl[0] . "_" . $todaytime . "." . $oldImgExpl[1]);
                            }
                        }
                      if(file_exists($destinationPathMenu . '/' . $file . $image_file)){ // for original file with no prefix
                          rename($destinationPathMenu.'/'.$image_file, $destinationPathMenu.'/'. $oldImgExpl[0] . "_" . $todaytime . "." . $oldImgExpl[1]);
                      }
                                            
                    }
                    
                       $thisresult=copy($destinationPath.'/'.$arr['image'],$destinationPathMenu.'/'.$newName);// use for copying and saving original file
                    
                    $sizes = ['assets/images/restaurants/' . $mns->restaurant_id . '/menus/' . $id . '/icon-' => TINY_THUMB, 'assets/images/restaurants/' . $mns->restaurant_id . '/menus/' . $id . '/small-' => MED_THUMB, 'assets/images/restaurants/' . $mns->restaurant_id . '/menus/' . $id . '/big-' => BIG_SQ];

/*
                    // decide if img size is too small to make larger img size, and to determine if the largest size will be portrait or landscape
                    ($imgVs[0] > $imgVs[1])? $largImg=MAX_IMG_SIZE_L : $largImg=MAX_IMG_SIZE_P;
                    
                    ($imgVs[0] > 362)? $sizes['assets/images/restaurants/' . $mns->restaurant_id . '/menus/' . $id . '/med-']=BIG_SQ : $sizes['assets/images/restaurants/' . $mns->restaurant_id . '/menus/' . $id . '/med-']=$imgVs[0].'x'.$imgVs[1];
                    ($imgVs[0] < 800 && $imgVs[1] < 800)? $sizes['assets/images/restaurants/' . $mns->restaurant_id . '/menus/' . $id . '/big-']=$imgVs[0].'x'.$imgVs[1] : $sizes['assets/images/restaurants/' . $mns->restaurant_id . '/menus/' . $id . '/big-']=$largImg;

*/

                    copyimages($sizes, $filename, $newName, true);

                    @unlink($destinationPath.'/'.$arr['image']); // delete temp upload image
                    
			                 $men = new \App\Http\Models\Menus();
                    // as with logo upload, this step should be incorporated with the rest of the db call in this fn, so as not to overuse db
			                 $men->where('id', $id)->update(['image' => $newName]); // same menu # but filetype may have changed
			                    
                  }
            }
            die();
        }
    }

    //unknown
    public function orderCat($cid, $sort) {
        $_POST['ids'] = explode(',', $_POST['ids']);
        $key = array_search($cid, $_POST['ids']);
        if (($key == 0 && $sort == 'up') || ($key == (count($_POST['ids']) - 1) && $sort == 'down')) {
            //do nothing
        } else {
            if ($sort == 'down') {
                $new = $key + 1;
            }else {
                $new = $key - 1;
            }
            $temp = $_POST['ids'][$new];
            $_POST['ids'][$new] = $cid;
            $_POST['ids'][$key] = $temp;
        }
        $child = \App\Http\Models\Menus::where('id', $cid)->get()[0];
        echo $child->parent;
        foreach ($_POST['ids'] as $k => $id) {
            \App\Http\Models\Menus::where('id', $id)->update(array('display_order' => ($k + 1)));
        }
        die();
    }


    //delete a menu item ($id)
    //if $slug is given, return to that restaurant's menu
    //otherwise return to the menu-manager
    public function deleteMenu($id, $slug = '') {
        $res_id = \App\Http\Models\Menus::where('id', $id)->get()[0]->restaurant_id;

        \App\Http\Models\Menus::where('id', $id)->delete();
        $child = \App\Http\Models\Menus::where('parent', $id)->get();
        foreach ($child as $c) {
            \App\Http\Models\Menus::where('parent', $c->id)->delete();
        }
        \App\Http\Models\Menus::where('parent', $id)->delete();
        $dir = public_path('assets/images/restaurants/' . $res_id . "/menus/" . $id);
        $this->deleteDir($dir);
        \Session::flash('message', 'Item deleted successfully');
        \Session::flash('message-type', 'alert-success');
        \Session::flash('message-short', '');
        
        if (!$slug) {
            return $this->success('Item has been deleted successfully!', 'restaurant/menus-manager');
        }else {
            return $this->success('Item has been deleted successfully!', 'restaurants/' . $slug . '/menus');
        }
    }

    //delete a directory and all it's files
    function deleteDir($dirPath) {
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        @rmdir($dirPath);
    }

    //loads an order
    public function order_detail($ID) {
        $data['order'] = \App\Http\Models\Reservations::select('reservations.*')->where('reservations.id', $ID)->leftJoin('restaurants', 'reservations.restaurant_id', '=', 'restaurants.id')->first();
        if(is_null($data['order']['restaurant_id'])) {//check for a valid restaurant $ID
            return back()->with('status', 'Restaurant Not Found!');
        } else {
            $data['title'] = 'Orders Detail';
            $data['restaurant'] = \App\Http\Models\Restaurants::find($data['order']->restaurant_id);//load the restaurant the order was placed for
            $data['user_detail'] = \App\Http\Models\Profiles::find($data['order']->user_id);//load user that placed the order
//            $data['states_list'] = \App\Http\Models\States::get();//load provinces/states
            return view('dashboard.restaurant.orders_detail', $data);
        }
    }

    //quick redirect to a restaurant's page
    public function red($path) {
        return \Redirect::to('restaurant/' . $path)->with('message', 'Restaurant menu successfully updated');
    }

    //quick redirect to a restaurant's page using it's slug, and it's subpage ($path2)
    public function redfront($path, $slug, $path2) {
        if(isset($_GET['menuadd']))
        $query = '?menuadd';
        else
        if(isset($_GET['sorted']))
        $query = '?sorted';
        return \Redirect::to($path . '/' . $slug . '/' . $path2.$query);
    }

    //load orders
    public function orderslist($type = '') {
        $data['title'] = 'Orders';
        $data['type'] = ucfirst($type);
        $orders = new \App\Http\Models\Reservations();
        if ($type == 'user') {
            $data['orders_list'] = $orders->where('user_id', \Session::get('session_id'))->orderBy('order_time', 'DESC')->get();//load orders placed by the current user
        }elseif ($type == 'restaurant') {
            $data['orders_list'] = $orders->where('restaurant_id', \Session::get('session_restaurant_id'))->orderBy('order_time', 'DESC')->get();//load orders for the current restaurant
        }else {
            $data['orders_list'] = $orders->orderBy('order_time', 'DESC')->get();//load all orders
        }
        return view('dashboard.restaurant.orders_pending', $data);
    }

    //load child/addon items for $id
    public function loadChild($id, $isaddon = false) {
        $data['child'] = \App\Http\Models\Menus::where('parent', $id)->orderBy('display_order', 'ASC')->get();
        if ($isaddon) {
            return view('dashboard.restaurant.load_addon', $data);
        }else {
            return view('dashboard.restaurant.load_child', $data);
        }
    }

    //save a category change
    public function saveCat() {
        $arr['title'] = $_POST['title'];
        $arr['res_id'] = $_POST['res_id'];
        $ob2 = new \App\Http\Models\Category();
        $ob2->populate($arr);
        $ob2->save();
        echo $ob2->id;
        die();
    }
    
    public function check_enable($menu_id,$cat_id,$limit,$enable) {
        $is_active = 0;
        $count =  \App\Http\Models\Menus::where(['restaurant_id'=>\Session::get('session_restaurant_id'),'is_active'=>1])->count();
        if($count<$limit || $enable==0) {
                echo '1';
                if($enable==1)
                $is_active = 1;
        }
        else
        echo '0';
        if($menu_id)
        \App\Http\Models\Menus::where('id', $menu_id)->update(array('is_active' => $is_active));
        die();
    }
}
