<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class UsersController extends Controller {
    
    /**
     * Constructor
     * @param null
     * @return redirect
     */
    public function __construct() {
        $this->beforeFilter(function () {
            $act = str_replace('user.', '', \Route::currentRouteName());
            $act = str_replace('.store', '', $act);
            initialize("users");
        });
    }
    
    /**
     * Users List
     * @param null
     * @return view
     */
    public function index() {
        $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {
            //check for missing data
            if (!isset($post['name']) || empty($post['name'])) {
                return $this->failure('[Name] field is missing','users/list', true);
            }
            if (!isset($post['email']) || empty($post['email'])) {
                return $this->failure(trans('messages.user_missing_email.message'),'users/list', true);
            }
            $is_email = \App\Http\Models\Profiles::where('email', '=', $post['email'])->count();
            if ($is_email > 0) {
                return $this->failure( trans('messages.user_email_already_exist.message'),'users/list', true);
            }
            if (!isset($post['password']) || empty($post['password'])) {
                return $this->failure( trans('messages.user_pass_field_missing.message') . " (0x03)",'users/list', true);
            }
            /*if (!isset($post['confirm_password']) || empty($post['confirm_password'])) {
                return $this->failure(trans('messages.user_confim_pass_field_missing.message'),'users/list', true);
            }
            if ($post['password'] != $post['confirm_password']) {
                return $this->failure(trans('messages.user_passwords_mismatched.message'),'users/list', true);
            }
            */
            \DB::beginTransaction();
            try {
                $this->registeruser("Users@index", $post, 2, 0, false, true);
                return $this->success('User has been added successfully. A confirmation email has been sent to the selected email address for verification.', 'users/list', true);
            } catch (\Illuminate\Database\QueryException $e) {
                \DB::rollback();
                return $this->failure(trans('messages.user_email_already_exist.message'), 'users/list', true);
            } catch (\Exception $e) {
                \DB::rollback();
                return $this->failure( handleexception($e), 'users/list', true);
            }
        } else {//get data to load the page
            $data['title'] = 'Users List';
            //$data['states_list'] = \App\Http\Models\States::get();
            $data['restaurants_list'] = \App\Http\Models\Restaurants::where('open', 1)->orderBy('name', 'ASC')->get();
            return view('dashboard.user.index', $data);
        }
    }
    
    /**
     * Listing Ajax
     * @return Response
     */
    public function listingAjax() {
        $per_page = \Input::get('showEntries', 20);//if(!$per_page){$per_page=20;}
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
            'searchResults' => \Input::get('searchResults')
        );
        
        $Query = \App\Http\Models\Profiles::listing($data, "list", $recCount)->get();

        $no_of_paginations = ceil($recCount / $per_page);
        
        $data['Query'] = $Query;
        $data['recCount'] = $recCount;
        $data['Pagination'] = getPagination($recCount, $no_of_paginations, $cur_page, TRUE, TRUE, TRUE, TRUE);
        $data["_GET"] = $_GET;

        \Session::flash('message', \Input::get('message'));
        return view('dashboard.user.ajax.list', $data);
    }

    
    /**
     * Edit User Form
     * @param $id
     * @return view
     */
    public function ajaxEditUserForm($id=0) {
        if($id) {
            $data['user_detail'] = \App\Http\Models\Profiles::find($id);
            $data['address_detail'] = \App\Http\Models\ProfilesAddresses::where('user_id', $data['user_detail']->id)->orderBy('id', 'DESC')->first();
        }
        $data['restaurants_list'] = \App\Http\Models\Restaurants::where('open', 1)->orderBy('name', 'ASC')->get();
//        $data['states_list'] = \App\Http\Models\States::get();
        //echo '<pre>'; print_r($data['address_detail']); die;
        return view('common.edituser', $data);
    }


    /**
     * Users List
     * @param null
     * @return view
     */
    public function userUpdate() {
        $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {//check for missing or duplicate data
            if (!isset($post['id']) || empty($post['id'])) {
                return $this->failure('[ID] field is missing', 'users/list', true);
            }
            if (!isset($post['name']) || empty($post['name'])) {
                return $this->failure('[Name] field is missing','users/list', true);
            }
            if (!isset($post['email']) || empty($post['email'])) {
                return $this->failure(trans('messages.user_missing_email.message'),'users/list', true);
            }
            $is_email = \App\Http\Models\Profiles::where('email', '=', $post['email'])->where('id', '!=', $post['id'])->count();
            if ($is_email > 0) {
                return $this->failure(trans('messages.user_email_already_exist.message'),'users/list', true);
            }
            /*
            if (!isset($post['password']) || empty($post['password'])) {
                return $this->failure( trans('messages.user_pass_field_missing.message') . "(0x02)",'users/list', true);
            }
            if (!isset($post['confirm_password']) || empty($post['confirm_password'])) {
                return $this->failure(trans('messages.user_confim_pass_field_missing.message'),'users/list', true);
            }
            */
            if (isset($post['password'])){// && isset($post['confirm_password']) && $post['password'] != $post['confirm_password']) {
                return $this->failure(trans('messages.user_passwords_mismatched.message'),'users/list', true);
            }
            \DB::beginTransaction();
            try {//save user's browser/OS info
                $browser_info = getBrowser();
                $post['ip_address'] = get_client_ip_server();
                $post['browser_name'] = $browser_info['name'];
                $post['browser_version'] = $browser_info['version'];
                $post['browser_platform'] = $browser_info['platform'];

                $user = \App\Http\Models\Profiles::find($post['id']);
                $user->populate(array_filter($post));
                $user->save();
                
                event(new \App\Events\AppEvents($user, "User Updated"));

                if(isset($post['adid']) && !empty($post['adid'])){
                    $add = \App\Http\Models\ProfilesAddresses::find($post['adid']);
                    $add->populate(array_filter($post));
                    $add->save();

                    \DB::commit();
                }

                return $this->success( 'User has been updated successfully.', 'users/list', true);
            } catch (\Illuminate\Database\QueryException $e) {
                \DB::rollback();
                return $this->failure( trans('messages.user_email_already_exist.message'), 'users/list', true);
            } catch (\Exception $e) {
                \DB::rollback();
                return $this->failure(handleexception($e),'users/list', true);
            }
        } else {
            return $this->failure( "Invalid parsed data!",'users/list', true);
        }
    }
    
    /**
     * Users Action
     * @param $type
     * @param $id
     * @return redirect
     */
    public function usersAction($type = '', $id = 0) {
        //check for missing type/id
        if (!isset($type) || empty($type)) {
            return $this->failure("[Type] is missing!", 'users/list');
        }
        if (!isset($id) || empty($id) || $id == 0) {
            return $this->failure("[Profile Id] is missing!", 'users/list');
        }
        try {
            $ob = \App\Http\Models\Profiles::find($id);//search for user $id
            event(new \App\Events\AppEvents($ob, "User Status Changed"));//log event
            switch ($type){
                case "user_fire"://fire user by deleting them
                    $ob->delete();
                    return $this->listingAjax();
                    break;
                case "user_hire"://hire user by changing the profile type to employee
                    $ob->populate(array('profile_type' => 1));
                    $ob->save();
                    break;
                case "user_possess":
                    login($id, true);
                    break;
                case "user_depossess":
                    login(read("oldid"));
                    break;
                default:
                    return $this->failure("'" . $type . "' is not handled", 'users/list');
            }
            return $this->success("message:" . $type, 'users/list');
        } catch (\Exception $e) {
            return $this->failure( handleexception($e), 'users/list');
        }
    }

    //handle updating a profile image
    public function save_profile_image($Keyname = "image", $UserID = false){
        if(!$UserID){
            $UserID= \Session::get('session_id');
        }

        if (\Input::hasFile($Keyname)) {
            $image = \Input::file($Keyname);
            $ext = $image->getClientOriginalExtension();
            $newName = substr(md5(uniqid(rand())), 0, 8) . '.' . $ext;
            $destinationPath = public_path('assets/images/users/' . $UserID);
            mkdir($destinationPath);
            $image->move($destinationPath, $newName);

            edit_database("profiles", "id", $UserID, array("photo" => $newName));
        }
    }

    /**
     * change a profile image
     * @param null
     * @return view
     */
    public function images() {
        $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {//check for missing data
            if (!isset($post['restaurant_id']) || empty($post['restaurant_id'])) {
                return $this->failure("[Restaurant] field is missing!", 'user/images');
            }
            if (!isset($post['title']) || empty($post['title'])) {
                return $this->failure( "[Title] field is missing!",'user/images');
            }
            if (!\Input::hasFile('image')) {
                return $this->failure( "[Image] field is missing!",'user/images');
            }
            try {
                $this->save_profile_image();
                return $this->success( "Image uploaded successfully", 'user/images');
            }
            catch(\Exception $e) {
                return $this->failure(handleexception($e),'user/images');
            }
        } 
        else {
            $data['title'] = 'Images Manage';
            $data['restaurants_list'] = \App\Http\Models\Restaurants::get();//get all restaurants
            //$data['images_list'] = \App\Http\Models\ProfilesImages::get();//get all profile images
            return view('dashboard.user.manage_image', $data);
        }
    }

    //create a new order via AJAX
    public function ajax_register() {
        $post = \Input::all();
        //echo '<pre>'.print_r($post); die;
        if (isset($post) && count($post) > 0 && !is_null($post)) {
            \DB::beginTransaction();
            $Stage = 1;
            try {//populate data array
                $msg = "";
                if(!isset($post['listid'])){
                    die("There are no items in your cart");
                }

                if( (!isset($post["cardid"]) || !$post["cardid"]) && isset($post["savecard"]) && $post["savecard"]){
                    $creditinfo = array();
                    foreach(array("cardnumber" => "card_number", "cardcvc" => "ccv", "cardmonth" => "expiry_month", "cardyear" => "expiry_year") as $source => $destination){
                        $creditinfo[$destination] = $post[$source];
                    }
                    \App\Http\Models\CreditCard::makenew($creditinfo);
                }
                $Stage=2;
                $post['name'] = $post['ordered_by'];
                $res['restaurant_id'] = $post['hidden_rest_id'];
                $res['user_id'] = $post['user_id'];
                $res['order_type'] = $post['order_type'];
                $res['order_time'] = date('Y-m-d H:i:s');
                $res['delivery_fee'] = $post['delivery_fee'];
                $res['res_id'] = $post['res_id'];
                $res['subtotal'] = $post['subtotal'];
                $res['g_total'] = $post['g_total'];
                $res['tax'] = $post['tax'];
                $res['listid'] = implode(',', $post['listid']);
                $res['prs'] = implode(',', $post['prs']);
                $res['qtys'] = implode(',', $post['qtys']);
                $res['extras'] = implode(',', $post['extras']);
                $res['menu_ids'] = implode(',', $post['menu_ids']);
                $res['restaurant_id'] = $post['res_id'];
                $res['order_till'] = $post['order_till'];
                if(isset($post['contact'])) {$res['contact'] = $post['contact'];}
                $Stage=3;
                if(isset($post["reservation_address_dropdown"]) && $post["reservation_address_dropdown"]){
                    $Address = select_field("profiles_addresses", "id", $post["reservation_address_dropdown"]);
                    $res['address2'] = $Address->address;
                    $res['city'] = $Address->city;
                    $res['province'] = $Address->province;
                    $res['country'] = $Address->country;
                    $res['postal_code'] = $Address->postal_code;
                } else {
                    if (\Input::has('address')) {
                        $res['address2'] = $post['address'];
                    }
                    if ($post['added_address'] != '') {
                        $res['address2'] = $post['added_address'];
                    }
                    if (\Input::has('city')) {
                        $res['city'] = $post['city'];
                    }
                    if (\Input::has('province')) {
                        $res['province'] = $post['province'];
                    }
                    if (\Input::has('country')) {
                        $res['country'] = $post['country'];
                    }
                    if (\Input::has('postal_code')) {
                        $res['postal_code'] = $post['postal_code'];
                    }
                }
                //echo '<pre>';print_r($res); die;
                $Stage=4;
                
                $res['name'] = trim($post['ordered_by']);

                //if the user is not logged in and specified a password, make a new user
                if (!\Session::has('session_id') && (isset($post['password']) && $post['password'] != '')) {
                    if (\App\Http\Models\Profiles::where('email', $post['email'])->first()) {
                       // echo '1yyb';
                        die();
                    } else {
                        $uid = $this->registeruser("Users@ajax_register", $post, 2, 0);
                        $res['user_id'] = $uid->id;
                        $msg = "78";
                        
                    }
                }
                $Stage=5;
                $ob2 = new \App\Http\Models\Reservations();
                $ob2->populate($res, "guid");
                $ob2->save();
                $oid = $ob2->id;
                $Stage=6;
                /*
                if($post['payment_type']=='cc')
                {
                    
                    if(isset($post["stripeToken"]) && $post["stripeToken"]){
                        if (app('App\Http\Controllers\CreditCardsController')->stripepayment($oid, $post["stripeToken"], $ob2->guid, $post['g_total'])) {
                            $this->success("Your order has been paid.");
                         //   $data['order']->paid = 1;
                        }else {
                            $this->failure("Your order has <B>NOT</B> been paid.");
                        }
                    }
                    
                }*/

                $res['ordered_by'] = $post['ordered_by'];
                
                //$res_data = array('email' => $post['email'], /*'address2' => $post['address2'], 'city' => $post['city'], 'ordered_by' => $post['postal_code'],*/ 'remarks' => $post['remarks'], 'order_till' => $post['order_till'], 'contact' => $phone);
                $res1 = \App\Http\Models\Reservations::find($oid);
                $res1->populate($res);
                $res1->save();
                $Stage=7;

                //echo '<pre>';print_r($res); die;
                event(new \App\Events\AppEvents($res, "Order Created"));

                if ($res1->user_id) {
                    $u2 = \App\Http\Models\Profiles::find($res1->user_id);
                    $userArray3 = $u2->toArray();
                } else {
                    $userArray3["name"] = $post["ordered_by"];
                    $userArray3["email"] = $post["email"];
                }
                $Stage=8;

                $userArray3['mail_subject'] = 'Your ' . DIDUEAT . ' order has been received!';
                $userArray3["guid"] = $ob2->guid;
                $userArray3["orderid"] = $oid;
                $userArray3["profile_type"] = "user";

                $this->sendEMail("emails.receipt", $userArray3);
                $Stage=9;

                $userArray3["profile_type"] = "restaurant";
                $userArray3['mail_subject'] = '[' . $userArray3["name"] . '] placed a new order. Please log in to ' . DIDUEAT. ' for more details. Thank you.';
                //notifystore($RestaurantID, $Message, $EmailParameters = [], $EmailTemplate = "emails.newsletter", $IncludeVan = false, $Emails = true, $Calls = true, $SMS = true) {
                $ret = app('App\Http\Controllers\OrdersController')->notifystore($res1->restaurant_id, $userArray3['mail_subject'], $userArray3, "emails.receipt");
                //debugprint( var_export($ret, true) );
                $Stage=10;
                //CC
                if($post['payment_type']=='cc') {
                    if(isset($post["stripeToken"]) && $post["stripeToken"]){
                        if (app('App\Http\Controllers\CreditCardsController')->stripepayment($oid, $post["stripeToken"], $ob2->guid, $post['g_total'])) {
                        //    $this->success("Your order has been paid.");
                            //$data['order']->paid = 1;
                        }else {
                     //       $this->failure("Your order has <B>NOT</B> been paid.");
                        }
                    }
                    
                }
                $Stage=11;
                echo '6';

                \DB::commit();
            } catch(\Illuminate\Database\QueryException $e) {
                \DB::rollback();
                var_dump($e);
                echo handleexception($e, true);
                die();
            } catch(\Exception $e) {
                \DB::rollback();
                echo handleexception($e);
                die();
            }
        } else {
            echo "Invalid request!";
        }
        die();
    }

    //converts the current profile to JSON
    function json_data() {
        $id = $_POST['id'];
        $user = \App\Http\Models\Profiles::select('profiles.id as user_id', 'profiles.name', 'profiles.email', 'profiles.phone as phone', 'profiles_addresses.address as street', 'profiles_addresses.postal_code', 'profiles_addresses.city', 'profiles_addresses.province', 'profiles_addresses.notes as notes', "profiles.restaurant_id as restaurant_id")->where('profiles.id', \Session::get('session_id'))->LeftJoin('profiles_addresses', 'profiles.id', '=', 'profiles_addresses.user_id')->first();
        $user->token = csrf_token();
        /*
        $user->restaurant_slug = "";
        if($user->restaurant_id){
            $user->restaurant_slug = select_field("restaurants", "id", $user->restaurant_id, "slug");
        }
        //$user = \DB::table('profiles')->select('profiles.name', 'profiles.phone', 'profiles.email', 'profiles_addresses.street as street', 'profiles_addresses.postal_code', 'profiles_addresses.city', 'profiles_addresses.province')->where('profiles.id', \Session::get('session_id'))->LeftJoin('profiles_addresses', 'profiles.id', '=', 'profiles_addresses.user_id')->first();
        */
        return json_encode($user);
    }

    function uploads($UserID = false){
        if(!$UserID){$UserID = read("id");}
        return view('dashboard.user.uploads', array("userid" => $UserID));
    }

    function uploadsajax($UserID = false){
        if(!$UserID){$UserID = read("id");}

        $per_page = \Input::get('showEntries', 20);
        if(!is_numeric($per_page)){$per_page = 20;}
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
            'order' => (\Input::get('order')) ? \Input::get('order') : 'ASC',
            'searchResults' => \Input::get('searchResults')
        );

        $recCount = select_field_where("menus", array("uploaded_by" => $UserID, "parent" => 0), "COUNT()");
        $Query = select_field_where("menus", array("uploaded_by" => $UserID, "parent" => 0), false, "", "ASC", "", $per_page, $cur_page);
        $no_of_paginations = ceil($recCount / $per_page);

        $data["userid"] = $UserID;
        $data['Query'] = $Query;
        $data['recCount'] = $recCount;
        $data['Pagination'] = getPagination($recCount, $no_of_paginations, $cur_page, TRUE, TRUE, TRUE, TRUE);
        $data["_GET"] = $_GET;

        \Session::flash('message', \Input::get('message'));
        return view('dashboard.user.ajax.uploads', $data);
    }
}
