<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Models\Newsletter;
use App\Http\Models\PageViews;

class HomeController extends Controller {
    public function __construct() {
        date_default_timezone_set('America/Toronto');
        $this->beforeFilter(function () {
            initialize("home");
        });
    }

    //toggle debug mode
    public function debugmode(){
        $message = "You do not have authorization to use that feature";
        //if(\Session::get('session_type_user') == "super") {
            $filename = getcwd() . "/debugmode.ip";
            if (debugmode()) {
                @unlink($filename);
                $message = "Debug mode disabled";
            } else {
                file_put_contents($filename, $_SERVER['REMOTE_ADDR']);
                $message = "Debug mode enabled";
            }
        //}
        return $this->success($message, $_GET["url"]);
    }

    public function index() {
        $data['title'] = 'Home';
        $data['keyword'] = 'Didueat,didueat.ca,Online food,Online food order,Canada online food,Canada Restaurants,Ontario Restaurants,Hamilton Restaurants';
        $data['cuisine'] = cuisinelist();
        $data['meta_description'] = "Having great local food delivered helps us all keep up with our busy lives. By connecting you to local restaurants, Didueat makes great food more accessible, opening up more possibilities for food lovers and more business for local small business owners. ";
        $data['tags'] = \App\Http\Models\Tag::where('is_active', 1)->get();
       // $data['top_ten'] = $this->getTopTen();
        $data['query'] = 0;
        $data['count'] = 0;
        $data['start'] = 0;
        $data['hasMorePage'] = 0;
        return view('restaurants', $data);
    }

    //does something with restaurant tags, can't tell what
    public function getTopTen() {
        $tags = \App\Http\Models\Tag::where('is_active', 1)->get();
        $restaurants = \App\Http\Models\Restaurants::get();
        $tag = '0';
        foreach($tags as $t) {
            $tag = $tag.','.$t->name;
        }
        $used_tag = '';
        foreach($restaurants as $t) {
            if($used_tag) {
                $used_tag = $used_tag . ',' . $t->tags;
            }else {
                $used_tag = $t->tags;
            }
        }

        $used_tag = str_replace(' ','',$used_tag);
        $all_tags = explode(',',$tag);
        $all_used_tags = explode(',',$used_tag);
        $arr_final = array();
        $arr_count = array();
        foreach($all_used_tags as $aut) {
            if(in_array($aut,$all_tags)) {
                  if(!in_array($aut,$arr_final)) {
                    $arr_final[] = $aut;
                    $arr_count[] = 1;
                  } else {
                    $k = array_search($aut,$arr_final);
                    $arr_count[$k]++;
                  }
            }
        }

        $keys = '';
        $key_final = array();
        for($i=0;$i<count($arr_count);$i++) {
            foreach($arr_count as $k=>$ac) {
                $check = 0;
                if(in_array($k,$key_final)){
                    continue;
                }
                $check = 1;
                //$c++;
                if($keys=='') {
                    $keys=$k;
                    $temp = $ac;
                } else{
                    if($ac>$temp) {
                        $keys = $k;
                    }
                }

            }
            if($check) {
                $key_final[] = $keys;
            }
        }
        die();
    }

    /**
     * Search Restaurants Ajax
     * @param null
     * @return view
     */
    public function searchRestaurantsAjax() {
        $post = \Input::all();
        $start = (isset($post['start']))?$post['start']:0;
        $data = array();
        parse_str($post['data'], $data);
        if (isset($post) && count($post) > 0 && !is_null($post)) {
            try {
                $data['data'] = $post;
                $data['query'] = \App\Http\Models\Restaurants::searchRestaurants($data, 10, $start, false);//search for restaurants matching the data in the post["data"]
                $data['sql'] = \App\Http\Models\Restaurants::searchRestaurants($data, 10, $start, true);//SQL, does not do db call
                $data['count'] = count($data['query']);//count the previous results
                $data['start'] = $start+10;
                $data['hasMorePage'] = count(\App\Http\Models\Restaurants::searchRestaurants($data, 10, $data['start']));//count remaining results
                $data['loadmore'] = (isset($post['loadmore']))?$post['loadmore']:0;
                $data['ajaxcall'] = (isset($post['ajaxcall']))?$post['ajaxcall']:0;
                $SQL = "";
                if (debugmode()) {$SQL = "SQL=" . $data['sql'] . "<BR>" . str_replace("&", "<BR>", print_r($post["data"], true));}

                if(read("id")) {
                    $hasaddress = true;
                    foreach (array("latitude", "longitude", "formatted_address", "city", "province", "postal_code", "country") as $field) {
                        if (!isset($data) || empty($data[$field])) {
                            $hasaddress = false;
                        }
                    }
                    if ($hasaddress) {
                        $searchname = "Last search";
                        $ID = select_field_where("profiles_addresses", array("user_id" => read("id"), "location" => $searchname));
                        if(!$ID){$ID = 0;} else {$ID = $ID->id;}
                        $add = \App\Http\Models\ProfilesAddresses::findOrNew($ID);
                        $data["user_id"] = read("id");
                        $data["location"] = $searchname;
                        $data["phone"] = read("phone");
                        $add->populate($data);
                        $add->save();
                    }
                }

                if (!is_null($data['query']) && count($data['query']) > 0){
                    return view('ajax.search_restaurants', $data);
                } else {
                    return view('dashboard.restaurant.ajax.noresults', array("SQL" => $SQL));
                }
            } catch (Exception $e) {
                return \Response::json(array('type' => 'error', 'response' => handleexception($e)), 500);
            }
        } else {
            return \Response::json(array('type' => 'error', 'response' => 'Invalid request made!'), 400);
        }

    }

    /**
     * Search Restaurants
     * @param $term
     * @param $per_page
     * @param $start
     * @return view
     */
    public function searchRestaurants($searchTerm = '') {
        $data['title'] = 'All Restaurants Page';
        $data['cuisine'] = cuisinelist();//search active cousines
        $data['tags'] = \App\Http\Models\Tag::where('is_active', 1)->get();//search active tags
        $data['query'] = \App\Http\Models\Restaurants::searchRestaurants('', 10, 0);//search 10 restaurants
        $data['sql'] = \App\Http\Models\Restaurants::searchRestaurants('', 10, 0, true);//SQL
        $data['count'] = \App\Http\Models\Restaurants::get();//count restaurants
        $data['start'] = count($data['query']);
        $data['searchTerm'] = $searchTerm;
        $data['hasMorePage'] = 10;
        if(is_iterable($data['query'])){
            $data['hasMorePage'] = count(\App\Http\Models\Restaurants::searchRestaurants('', 10, $data['start']));//remaining restauramts
        }
        return view('restaurants', $data);
    }

    /**
     * All Restaurants Lists
     * @param null
     * @return view
     */
    public function allRestaurants() {
        $data['title'] = 'All Restaurants Page';
        $data['query'] = \App\Http\Models\Restaurants::where('open', 1)->paginate(8);//load all open restaurants
        $data['count'] = \App\Http\Models\Restaurants::where('open', 1)->count();//count all open restaurants
        $data['cities'] = \App\Http\Models\Restaurants::distinct()->select('city')->where('open', 1)->get();//load all cities with an open restaurant
        $data['provinces'] = \App\Http\Models\Restaurants::distinct()->select('province')->where('open', 1)->get();//enum all provinces with an open restaurant
        //$data['countries'] = \App\Http\Models\Countries::get();//load all countries
        $data['cuisine'] = cuisinelist();
        $data['tags'] = \App\Http\Models\Tag::where('is_active', 1)->get();//load all active tags
        $data['start'] = $data['query']->count();//start at the end of the list of restaurants?
        $data['term'] = '';

        return view('restaurants', $data);
    }

    //GET request, returns any template so you can put it in a modal popup
    public function simplemodal($page = false){
        $post = \Input::all();
        if(!$page && isset($post["page"])){$page = $post["page"];}
        return view($page, $post);
    }

    /**
     * Search Menus
     * @param $term
     * @param $per_page
     * @param $start
     * @return view
     */
    public function searchMenus($term = '') {
        $data['query'] = \App\Http\Models\Menus::searchMenus($term, 10, 0, 'list', 'display_order', 'ASC', '', '', '', '', $reccount)->get();//search all menus for $term
        $data['count'] = $reccount;//\App\Http\Models\Menus::searchMenus($term, 10, 0, 'count')->count();//count previous results
        $data['start'] = $data['query']->count();//count previous results
        $data['term'] = $term;
        $data['title'] = "Search Menus";
        return view('home', $data);
    }

    //fast testing url
    public function test(){
        //app('App\Http\Controllers\OrdersController')->notifystore(1, "TEST");
        /*
        $array['mail_subject'] = "TEST EMAIL";
        $array['message'] = "TEST MESSAGE";
        $array["email"] = read("email");
        $array["orderid"] = $_GET["orderid"];
        $this->sendEMail("emails.receipt", $array);
        die("Test email sent");
        return view('test');
        */
        return view('test');
    }

    /**
     * Search Menus Ajax
     * @param null
     * @return view
     */
    public function searchMenusAjax() {
        $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {
            try {
                $results = \App\Http\Models\Menus::searchMenus($post['term'], 8, $post['start'], 'list', $post['sortType'], $post['sortBy'], $post['priceFrom'], $post['priceTo'], $post['hasAddon'], $post['hasImage']);//search menus using post parameters
                $data['query'] = $results->get();
                $data['count'] = $results->count();//count results
                $data['start'] = $data['query']->count() + $post['start'];
                $data['term'] = $post['term'];
                if (!is_null($data['query']) && count($data['query']) > 0) {
                    return view('ajax.search_menus', $data);
                }
            } catch (Exception $e) {
                return \Response::json(array('type' => 'error', 'response' => handleexception($e)), 500);
            }
        } else {
            return \Response::json(array('type' => 'error', 'response' => 'Invalid request made!'), 400);
        }

    }

    /**
     * Subscribe to the Newsletter
     * @param null
     * @return response
     */
    public function newsletterSubscribe() {
        $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {//check for missing/duplicate data
            if (!isset($post['email']) || empty($post['email'])) {
                return \Response::json(array('type' => 'error', 'message' => '[Email] field is required!'), 200);
            }
            $count = \App\Http\Models\Newsletter::where('email', $post['email'])->count();
            if ($count > 0) {
                return \Response::json(array('type' => 'error', 'message' => '['.$post['email'].'] already subscribed!'), 200);
            }

            $post['status'] = 1;
            try {//save the email address to the newsletter table
                $ob = new \App\Http\Models\Newsletter();
                $ob->populate($post);
                $ob->save();

                return \Response::json(array('type' => 'success', 'message' => "You are subscribed successfully!"), 200);
            } catch (Exception $e) {
                return \Response::json(array('type' => 'error', 'message' => handleexception($e)), 200);
            }
        } else {
            return \Response::json(array('type' => 'error', 'message' => 'Invalid request made!'), 200);
        }
    }

    /**
     * Signup Restaurants, seems to be a duplicate of RestaurantController/addRestaurants
     * @param null
     * @return view
     */
    public function signupRestaurants() {
        $data['title'] = 'Signup';
        $data['keyword'] = 'Signup, Join Didueat,Register your Restaurant, didueat.ca,Online food,Online food order,Canada online food,Canada Restaurants,Ontario Restaurants,Hamilton Restaurants';
        $data['cuisine'] = cuisinelist();
        $data['meta_description'] = "Didueat prides itself on its easy ordering system. Helping customers spend less time searching for and ordering their meals! Improving on the emerging trend towards centralized meal ordering apps, Didueat makes the process easier and faster than ever before. Don't miss out on the next big thing in restaurant ordering";
        $Redirect = 'restaurants/signup';
        $post = \Input::all();
        $email_verification = false;
        if (isset($post) && count($post) > 0 && !is_null($post)) {//check for missing data
            if (!isset($post['restname']) || empty($post['restname'])) {
                return $this->failure("[Restaurant Name] field is missing!",$Redirect, true);
            }
            if (!isset($post['name']) || empty($post['name'])) {
                return $this->failure("[Name] field is missing!",$Redirect, true);
            }
            if (!isset($post['email']) || empty($post['email'])) {
                return $this->failure("[Email] field is missing!",$Redirect, true);
            }
            $is_email = \App\Http\Models\Profiles::where('email', '=', $post['email'])->count();
            if ($is_email > 0) {
                return $this->failure("Email address [".$post['email']."] already exists!",$Redirect, true);
            }

            if(!isset($post["id"])) {
                if ((!isset($post['formatted_address']) || empty($post['formatted_address'])) && isset($post['formatted_addressForDB']) && $post['formatted_addressForDB']) {
                    $post['formatted_address'] = $post["formatted_addressForDB"];
                }
                if (!isset($post['formatted_address']) || empty($post['formatted_address'])) {
                    return $this->failure("[Address] field is missing!", $Redirect, true);
                }
                if (!isset($post['city']) || empty($post['city'])) {
                    return $this->failure("[City] field is missing!", $Redirect, true);
                }
                if (!isset($post['province']) || empty($post['province'])) {
                    return $this->failure("[Province] field is missing!", $Redirect, true);
                }
            }

            if (!isset($post['phone']) || empty($post['phone'])){
                return $this->failure("[Phone] field is missing or invalid!",$Redirect, true);
            }

            if (!isset($post['password']) || empty($post['password'])) {
                return $this->failure(trans('messages.user_pass_field_missing.message') . " (0x01)",$Redirect, true);
            }
            /* if (!isset($post['confirm_password']) || empty($post['confirm_password'])) {
                return $this->failure( trans('messages.user_confim_pass_field_missing.message'),$Redirect, true);
            }
            if ($post['password'] != $post['confirm_password']) {
                return $this->failure(trans('messages.user_passwords_mismatched.message'),$Redirect, true);
            }*/

            return app('App\Http\Controllers\RestaurantController')->restaurantInfo(0,true);
        } else {
            //$data['title'] = "Signup Restaurants Page";
//            $data['countries_list'] = \App\Http\Models\Countries::get();
//            $data['states_list'] = \App\Http\Models\States::get();
//            $data['cuisine_list'] = \App\Http\Models\Cuisine::get();
//            $data['resturant'] = \App\Http\Models\Restaurants::find(\Session::get('session_restaurant_id'));

            $data['cuisine_list'] = cuisinelist();

            return view('restaurants-signup', $data);
        }
    }

    /**
     * Menus Restaurants
     * @param null
     * @return view
     */
    public function menusRestaurants($slug) {
        //echo $slug;die();
        $res_slug = \App\Http\Models\Restaurants::where('slug', $slug)->first();//load restaurant by its slug
        if(!$res_slug){return $this->failure("Restaurant not found", "/");}
        $category = \App\Http\Models\Category::where('res_id',$res_slug->id)->orderBy('display_order','ASC')->get();//gets a category, I don't know which one
        if(!$res_slug){return $this->failure("Restaurant '" . $slug . "' not found", "/");}
        $data['category'] = $category;
        $data['title'] = $res_slug->name;
        $data['keyword'] = $res_slug->name.','.$res_slug->cuisine.' Cuisine'.','.$res_slug->phone.','.$res_slug->formatted_address.',Didueat,didueat.ca,Online food,Online food order,Canada online food';
        while(strpos($data['keyword'], ",,") !== false ) {
            $data['keyword'] = str_replace(',,', ',', $data['keyword']);
        }
        $data['meta_description'] = $res_slug->description;
        if(!$data['meta_description']) {
            $data['meta_description'] = "Having great local food delivered helps us all keep up with our busy lives. By connecting you to local restaurants, Didueat makes great food more accessible, opening up more possibilities for food lovers and more business for local small business owners. ";
        }
        $data['slug'] = $slug;
        $data['restaurant'] = $res_slug;
        \App\Http\Models\PageViews::insertView($res_slug->id, "restaurant");//update it's page views
        $data['total_restaurant_views'] = \App\Http\Models\PageViews::getView($res_slug->id, "restaurant");
        //$data['states_list'] = \App\Http\Models\States::get();//load all states/provinces

        if (isset($_GET['page'])) {
            return view('menus', $data);
        } else {
            return view('restaurants-menus', $data);
        }
    }

    //loads menus view, containing menus of restaurant = $resid where category = $catid
    function loadmenus($catid, $resid) {
        $res_slug = \App\Http\Models\Restaurants::where('id', $resid)->first();
        $data['restaurant'] = $res_slug;
        if(read('restaurant_id') == $resid || read("profiletype") != 2) {//is yours, doesn't need to be active
            $menus_list = \App\Http\Models\Menus::where('restaurant_id', $resid)->where('parent', 0)->where('cat_id', $catid)->orderBy('display_order', 'ASC')->get();//->paginate(5);
        }else {//is not yours, needs to be active
            $menus_list = \App\Http\Models\Menus::where('restaurant_id', $resid)->where('parent', 0)->where('is_active', 1)->where('cat_id', $catid)->orderBy('display_order', 'ASC')->get();//->paginate(5);
        }
        $data['menus_list'] = $menus_list;
        $data['catid'] = $catid;
        if(count($menus_list)) {
            return view('menus', $data);
        }else {
            //return '<div class="alert alert-danger " style="margin-bottom:1rem !important;" role="alert">No menu items yet<br><div class="clearfix"></div></div>';
        }
    }

    //loads contact us view
    function contactus() {
        $data['title'] = 'Contact';
        //   $data['menus_list'] = \App\Http\Models\Menus::where('parent', 0)->orderBy('display_order', 'ASC')->paginate(10);
        return view('contactus', $data);

    }



    //handle image uploading
    public function uploadimg($type = '') {
        if (isset($_FILES['myfile']['name']) && $_FILES['myfile']['name']) {
            $name = $_FILES['myfile']['name'];
            $arr = explode('.', $name);
            $ext = strtolower(end($arr));
            $file = date('YmdHis') . '.' . $ext;
            if ($type == 'restaurant') {
                $path = 'assets/images/restaurants';
            } else {
                $path = 'assets/images/products';
            }
            if(!is_dir(public_path($path))) {
                mkdir(public_path($path), 0777, true);
            }
            move_uploaded_file($_FILES['myfile']['tmp_name'], public_path($path) . '/' . $file);
            $file_path = url() . '/' . $path . '/' . $file;
            /*handle image resizing, which didn't get used...
            foreach(array(150,300) as $size){
                $this->make_thumb(public_path($path) . '/' . $file, $size, $size, false);
            }*/
            echo $file_path . '___' . $file;
        }
        die();
    }

    //update pageviews
    function countStatus($id=0) {
        \App\Http\Models\PageViews::insertView($id, 'menu');
        return \App\Http\Models\PageViews::getView($id, "menu");
    }

    //handle all ajax requests here
    function ajax(){
        if (!isset($_POST["type"])) {$_POST = $_GET;}
        if (isset($_POST["type"])) {
            $this->statusmode = true;
            switch (strtolower($_POST["type"])) {
                case "restsearch":
                    //name and phone
                    $restaurants = \App\Http\Models\Restaurants::where('name', 'LIKE', '%' .  $_POST["name"] . '%')
                        ->where("is_complete", 0)
                        //->orWhere(function($query) {$query->where('phone', $_POST["phone"])->where('mobile', $_POST["phone"]);})
                        ->get();
                    return view('dashboard.restaurant.ajax.search', array("restaurants" => $restaurants));
                    break;

                case "add_enable"://enable/disable a restaurant notification address
                    $doit = true;
                    if(!$_POST["value"]) {
                        $restaurantID = $this->get_notification_restaurant($_POST["id"]);
                        $notification_address_count = $this->enum_notification_addresses($restaurantID);
                        $doit = $notification_address_count > 1 && read("restaurant_id") == $restaurantID;
                    }
                    if($doit) {
                        \App\Http\Models\NotificationAddresses::where('id', $_POST["id"])->update(array('enabled' => $_POST["value"]));
                    } else {
                        echo "You must have a minimum of 1 notification set";
                    }
                    break;
                case "change_note"://change note for a notification address
                    \App\Http\Models\NotificationAddresses::where('id', $_POST["id"])->update(array('note' => $_POST["value"]));
                    break;

                case "updatereview"://update a review star, returns the new HTML
                    //$type = "rating", $load_type = "", $target_id = 0, $TwoLines = false, $class_name = 'update-rating', $add_rate_brn = true, $starts = false, $Color = "", $NeedsVARs = true
                    echo rating_initialize($_POST["rating_type"], $_POST["rating_loadtype"], $_POST["targetid"], $_POST["rating_twolines"], $_POST["rating_class"], $_POST["rating_button"], $_POST["rating_starts"], $_POST["rating_color"], false);
                    break;

                case "login":
                    $this->ismissing($_POST, array("email", "password"));
                    $user = \App\Http\Models\Profiles::where('email', '=', $_POST["email"])->first();
                    if($user) {
                        $password = encryptpassword($_POST["password"]);
                        if ($password == $user->password) {
                            login($user);
                            $this->status(true, csrf_token(), "_token");
                        }
                    }
                    $this->status(false, "User not found or password mismatch");
                    break;

                //api required: restaurant creation
                case "createuser":
                    $this->ismissing($_POST, array("name", "email", "password"));
                    if(is_email_in_use($_POST["email"])) {$this->status(false, "email is in use");}
                    $this->status(true, $this->registeruser("HomeController@Ajax", $_POST, 2)->id, "id");
                    break;

                case "checkaddress":
                    $this->ismissing($_POST, array("address"));
                    echo file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($_POST["address"]));
                    break;

                case "createrestaurant":
                    $this->ismissing($_POST, array("restname", "name", "email" => "email", "password" => "password", "phone" => "phone", "mobile" => "phone", "cuisines", "city", "province", "country", "postal_code" => "postalcode", "latitude" => "number", "longitude" => "number"));
                    if(is_email_in_use($_POST["email"])) {$this->status(false, "email is in use");}

                    //make sure the genres are correct
                    $genres = explode(",", $_POST["cuisines"]);
                    $genrelist = cuisinelist();
                    foreach($genres as $ID => $genre){
                        $Found = false;
                        foreach($genrelist as $genreitem){
                            if (strcasecmp($genreitem, $genre) == 0){
                                $genres[$ID] = $genreitem;
                                $Found = true;
                            }
                        }
                        if(!$Found){$this->status(false, $genre . " is not a recognized genre"); }
                    }
                    if(!count($genres) || count($genres) > 3){$this->status(false, "1-3 genres are required");}
                    $_POST["cuisines"]=implode(",", $genres);
                    $Data = app('App\Http\Controllers\RestaurantController')->restaurantInfo(0, true, true);
                    $this->status(true, $Data, "id");
                    break;

                case "promoteuser":
                    update_database("profiles", "id", $_POST["id"], array("profile_type" => iif($_POST["checked"] == "true", 3, 2) ));
                    echo "Profile type of profile ID # " . $_POST["id"] . " was changed to " . iif($_POST["checked"] == "true", "3 (userplus)", "2 (user)");
                    break;

                case "deletepic":
                    if(read("profiletype") == 1 || read("id") == $_POST["userid"]){
                        @unlink(public_path("assets/images/users/" . $_POST["userid"] . "/" . $_POST["filename"]));
                    }
                    break;

                default:
                    echo $_POST["type"] . " is not handled";
                    if(debugmode()){ echo "\r\n" . var_export($_POST, true);}
            }
        } else {
            echo "type not specified";
        }
        die();
    }

    function ismissing($Data, $Fields){
        foreach($Fields as $ID => $Field){
            $IsValid = false;
            if(is_numeric($ID)) {
                $IsValid = isset($Data[$Field]) && $Data[$Field];
            } else {
                if (isset($Data[$ID]) && $Data[$ID]) {
                    switch (strtolower($Field)){
                        case "password":
                            $IsValid = strlen($Data[$ID]) > 3;
                            break;
                        case "email":
                            $Data[$ID] = str_replace(" ", "+", $Data[$ID]);
                            $IsValid = is_valid_email($Data[$ID]);
                            break;
                        case "phone":
                            $IsValid = phonenumber($Data[$ID]);
                            break;
                        case "postalcode":
                            $IsValid = clean_postalcode($Data[$ID]);
                            break;
                        case "number":
                            $IsValid = is_numeric($Data[$ID]);
                            break;
                    }
                }
            }
            if($IsValid){unset($Fields[$ID]);}
        }
        if(count($Fields)){
            $this->status(false, "[" . implode(", ", $Fields) . "] missing or invalid");
        }
    }

    //check which restaurant a notification address belongs to
    public function get_notification_restaurant($notificationID){
        $ob = \App\Http\Models\NotificationAddresses::find($notificationID);
        $userID = $ob->user_id;
        $ob = \App\Http\Models\Profiles::find($userID);
        return $ob->restaurant_id;
    }

    //get all restaurant notification addresses
    public function enum_notification_addresses($restaurantID, $Get = false){
        $order = \App\Http\Models\NotificationAddresses::where('enabled', 1)->leftJoin('profiles', 'notification_addresses.user_id', '=', 'profiles.id')->where( 'profiles.restaurant_id', $restaurantID);
        if($Get){return $order->get();}
        return $order->count();
    }

    //save a ratings change
    public function ratingSave() {
        $post = \Input::all();
        $response = 200;
        if (isset($post) && count($post) > 0 && !is_null($post)) {
            try {//rating_id:rating_id, target_id:target_id, type:type
                $post['user_id'] = (\Session::has('session_id'))?\Session::get('session_id'):0;
                $exist = \App\Http\Models\RatingUsers::where('user_id', $post['user_id'])->where('rating_id', $post['rating_id'])->where('target_id', $post['target_id'])->where('type', $post['type'])->count();
                if($exist == 0){
                    $ob = new \App\Http\Models\RatingUsers();
                    $ob->populate($post);
                    $ob->save();
                    
                    $rating = rating_get($post['target_id'], $post['rating_id'], $post['type']);
                    if($post['type'] == "menu"){
                        $ob = \App\Http\Models\Menus::find($post['target_id']);
                        $ob->populate(array('rating' => $rating));
                        $ob->update();
                    } else {
                        $ob = \App\Http\Models\Restaurants::find($post['target_id']);
                        $ob->populate(array('rating' => $rating));
                        $ob->update();
                    }
                    
                    return \Response::json(array('type' => 'success', 'response' => "Thank you for your review"), $response);
                } else {
                    return \Response::json(array('type' => 'error', 'response' => "You already reviewed"), $response);
                }
            } catch (Exception $e) {
                return \Response::json(array('type' => 'error', 'response' => $e->getMessage()), $response);
            }
        } else {
            return \Response::json(array('type' => 'error', 'response' => 'Invalid request made!'), $response);
        }
    }

    public function home($Type){
        $data= array();
        if($Type=='about') {
            $data['meta_description'] = "Having great local food delivered helps us all keep up with our busy lives. By connecting you to local restaurants, Didueat makes great food more accessible, opening up more possibilities for food lovers and more business for local small business owners. ";
            $data['keyword'] = 'Didueat,didueat.ca,Online food,Online food order,Canada online food,Canada Restaurants,Ontario Restaurants,Hamilton Restaurants';
            $data['title'] = ucfirst($Type);
        }
        if($Type=='terms') {
            $data['meta_description'] = "These terms of use apply to all users of the Website including users who upload any materials to the Website, users who use services provided through this Website, and users who simply view the content on or available through this website. Please read these terms carefully before ordering any products through the Website. ";
            $data['keyword'] = 'Terms and Conditions,Didueat Terms,Didueat Conditions,didueat.ca,Online food,Online food order,Canada online food,Canada Restaurants,Ontario Restaurants,Hamilton Restaurants';
            $data['title'] = ucfirst($Type);
        }
        if($Type != "faq"){
            return view("home." . $Type, $data);
        }
    }

    public function home2(){//deals with payment
        $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {
            $data['title'] = 'Thank you for your payment';
            $dataSupp['paymsg'] = 'Thank you for your payment';
            $dataSupp['paid'] = true;
        } else {
            $data['title'] = 'FAQ';
            $data['keyword'] = 'FAQ,Questions,Didueat,didueat.ca,Online food,Online food order,Canada online food,Canada Restaurants,Ontario Restaurants,Hamilton Restaurants';
            $data['meta_description'] = "Having great local food delivered helps us all keep up with our busy lives. By connecting you to local restaurants, Didueat makes great food more accessible, opening up more possibilities for food lovers and more business for local small business owners. ";
            $dataSupp['paymsg'] = 'Please confirm your payment';
            $dataSupp['paid'] = false;
        }

        $data['user_detail'] = \App\Http\Models\Profiles::find(\Session::get('session_id'));
        $data['user_detail']['paymsg']=$dataSupp['paymsg'];
        $data['user_detail']['paid']=$dataSupp['paid'];

        $charged = app('App\Http\Controllers\CreditCardsController')->stripepayment();

        if($charged){
            \Session::flash('paymentMade', true); // store for just next pg
            return $this->success("Payment made successfully", 'home/faq');
        } else {
            return view('home.faq', $data);
        }

  }
  
}
