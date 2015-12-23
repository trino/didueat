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

    /**
     * Home Page
     * @param null
     * @return view
     */
    public function index() {
        $data['title'] = 'All Restaurants Page';
        $data['cuisine'] = \App\Http\Models\Cuisine::where('is_active', 1)->get();//load all active cousine types
        $data['tags'] = \App\Http\Models\Tag::where('is_active', 1)->get();//load all active tages
        $data['query'] = 0;
        $data['count'] = 0;
        $data['start'] = 0;
        $data['hasMorePage'] = 0;
        return view('restaurants', $data);
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
                $data['query'] = \App\Http\Models\Restaurants::searchRestaurants($data, 10, $start);//search for restaurants matching the data in the post["data"]
                $data['count'] = count($data['query']);//count the previous results
                $data['start'] = $start+10;
                $data['hasMorePage'] = count(\App\Http\Models\Restaurants::searchRestaurants($data, 10, $data['start']));//count remaining results
                $data['loadmore'] = (isset($post['loadmore']))?$post['loadmore']:0;
                $data['ajaxcall'] = (isset($post['ajaxcall']))?$post['ajaxcall']:0;
                if (!is_null($data['query']) && count($data['query']) > 0){
                    return view('ajax.search_restaurants', $data);
                }
            } catch (Exception $e) {
                return \Response::json(array('type' => 'error', 'response' => $e->getMessage()), 500);
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
        $data['cuisine'] = \App\Http\Models\Cuisine::where('is_active', 1)->get();//search active cousines
        $data['tags'] = \App\Http\Models\Tag::where('is_active', 1)->get();//search active tags
        $data['query'] = \App\Http\Models\Restaurants::searchRestaurants('', 10, 0);//search 10 restaurants
        $data['count'] = \App\Http\Models\Restaurants::get();//count restaurants
        $data['start'] = count($data['query']);
        $data['searchTerm'] = $searchTerm;
        $data['hasMorePage'] = count(\App\Http\Models\Restaurants::searchRestaurants('', 10, $data['start']));//remaining restauramts

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
        $data['countries'] = \App\Http\Models\Countries::get();//load all countries
        $data['cuisine'] = \App\Http\Models\Cuisine::where('is_active', 1)->get();//load all active cousines
        $data['tags'] = \App\Http\Models\Tag::where('is_active', 1)->get();//load all active tags
        $data['start'] = $data['query']->count();//start at the end of the list of restaurants?
        $data['term'] = '';

        return view('restaurants', $data);
    }

    /**
     * Search Menus
     * @param $term
     * @param $per_page
     * @param $start
     * @return view
     */
    public function searchMenus($term = '') {
        $data['query'] = \App\Http\Models\Menus::searchMenus($term, 10, 0, 'list')->get();//search all menus for $term
        $data['count'] = \App\Http\Models\Menus::searchMenus($term, 10, 0, 'count')->count();//count previous results
        $data['start'] = $data['query']->count();//count previous results
        $data['term'] = $term;
        $data['title'] = "Search Menus";

        return view('home', $data);
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
                return \Response::json(array('type' => 'error', 'response' => $e->getMessage()), 500);
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
                return \Response::json(array('type' => 'error', 'message' => $e->getMessage()), 200);
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
        $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {//check for missing data
            if (!isset($post['restname']) || empty($post['restname'])) {
                return $this->failure("[Restaurant Name] field is missing!",'/restaurants/signup', true);
            }
            if (!isset($post['full_name']) || empty($post['full_name'])) {
                return $this->failure("[Full Name] field is missing!",'/restaurants/signup', true);
            }
            if (!isset($post['email']) || empty($post['email'])) {
                return $this->failure("[Email] field is missing!",'/restaurants/signup', true);
            }
            $is_email = \App\Http\Models\Profiles::where('email', '=', $post['email'])->count();
            if ($is_email > 0) {
                return $this->failure("Email address [".$post['email']."] already exists!",'restaurants/signup', true);
            }
            if (!isset($post['address']) || empty($post['address'])) {
                return $this->failure("[Address] field is missing!",'/restaurants/signup', true);
            }
            if (!isset($post['city']) || empty($post['city'])) {
                return $this->failure("[City] field is missing!",'/restaurants/signup', true);
            }
            if (!isset($post['province']) || empty($post['province'])) {
                return $this->failure("[Province] field is missing!",'/restaurants/signup', true);
            }
            if (!isset($post['postal_code']) || empty($post['postal_code'])) {
                return $this->failure("[Postal Code] field is missing!",'/restaurants/signup', true);
            }
            if (!isset($post['phone']) || empty($post['phone'])) {
                return $this->failure("[Phone] field is missing!",'/restaurants/signup', true);
            }
            if (!isset($post['country']) || empty($post['country'])) {
                return $this->failure("[Country] field is missing!",'/restaurants/signup', true);
            }
            if (!isset($post['password1']) || empty($post['password1'])) {
                return $this->failure(trans('messages.user_pass_field_missing.message'),'/restaurants/signup', true);
            }
            if (!isset($post['confirm_password1']) || empty($post['confirm_password1'])) {
                return $this->failure( trans('messages.user_confim_pass_field_missing.message'),'/restaurants/signup', true);
            }
            if ($post['password1'] != $post['confirm_password1']) {
                return $this->failure(trans('messages.user_passwords_mismatched.message'),'/restaurants/signup', true);
            }
            try {//populate data array
                if ($post['logo'] != '') {
                    $update['logo'] = $post['logo'];
                }
                $update['name'] = $post['restname'];
                $update['slug'] = $this->createslug($post['restname']);
                $update['email'] = $post['email'];
                $update['phone'] = $post['phone'];
                $update['mobile'] = $post['mobile'];
                $update['description'] = $post['description'];
                $update['country'] = $post['country'];
                $update['cuisine'] = $post['cuisine'];
                $update['province'] = $post['province'];
                $update['address'] = $post['address'];
                $update['city'] = $post['city'];
                $update['postal_code'] = $post['postal_code'];
                $update['is_pickup'] = (isset($post['is_pickup']))?1:0;
                $update['is_delivery'] = (isset($post['is_delivery']))?1:0;
                $update['delivery_fee'] = (isset($post['is_delivery']))?$post['delivery_fee']:0;
                $update['minimum'] = (isset($post['is_delivery']))?$post['minimum']:0;
                $update['max_delivery_distance'] = (isset($post['is_delivery']))?$post['max_delivery_distance']:0;
                $update['tags'] = $post['tags'];
                $update['lat'] = $post['lat'];
                $update['lng'] = $post['lng'];
                $update['formatted_address'] = $post['formatted_address'];
                $update['open'] = 1;
                $update['status'] = 1;
                $browser_info = getBrowser();
                $update['ip_address'] = get_client_ip_server();
                $update['browser_name'] = $browser_info['name'];
                $update['browser_version'] = $browser_info['version'];
                $update['browser_platform'] = $browser_info['platform'];

                $ob = new \App\Http\Models\Restaurants();
                $ob->populate($update);
                $ob->save();
                
                event(new \App\Events\AppEvents($ob, "Restaurant Created"));

                $image_file = \App\Http\Models\Restaurants::select('logo')->where('id', $ob->id)->get()[0]->logo;
                if ($image_file != '') {
                    $arr = explode('.', $image_file);
                    $ext = end($arr);
                    $newName = $ob->slug . '.' . $ext;

                    if (!file_exists(public_path('assets/images/restaurants/' . $ob->id))) {
                        mkdir('assets/images/restaurants/' . $ob->id, 0777, true);
                    }
                    $destinationPath = public_path('assets/images/restaurants/' . $ob->id);
                    $filename = $destinationPath . "/" . $newName;
                    copy(public_path('assets/images/restaurants/' . $image_file), $filename);
                    @unlink(public_path('assets/images/restaurants/' . $image_file));
                    $sizes = ['assets/images/restaurants/' . $ob->id . '/thumb_' => '145x100', 'assets/images/restaurants/' . $ob->id . '/thumb1_' => '120x85'];
                    copyimages($sizes, $filename, $newName);
                    $res = new \App\Http\Models\Restaurants();
                    $res->where('id', $ob->id)->update(['logo' => $newName]);
                }

                foreach ($post['open'] as $key => $value) {
                    if (!empty($value)) {
                        $hour['restaurant_id'] = $ob->id;
                        $hour['open'] = $this->cleanTime($value);
                        $hour['close'] = $this->cleanTime($post['close'][$key]);
                        $hour['day_of_week'] = $post['day_of_week'][$key];
                        $ob2 = new \App\Http\Models\Hours();
                        $ob2->populate($hour);
                        $ob2->save();
                    }
                }

                $data['restaurant_id'] = $ob->id;
                $data['status'] = 1;
                $data['is_email_varified'] = 0;
                $data['profile_type'] = 2;
                $data['name'] = $post['full_name'];
                $data['email'] = $post['email'];
                $data['password'] = $post['password1'];
                $data['subscribed'] = (isset($post['subscribed'])) ? $post['subscribed'] : 0;
                
                $browser_info = getBrowser();
                $data['ip_address'] = get_client_ip_server();
                $data['browser_name'] = $browser_info['name'];
                $data['browser_version'] = $browser_info['version'];
                $data['browser_platform'] = $browser_info['platform'];

                $user = new \App\Http\Models\Profiles();
                $user->populate($data);
                $user->save();
                
                event(new \App\Events\AppEvents($user, "User Created"));

                $nd1 = new \App\Http\Models\NotificationAddresses();
                $nd1->populate(array("is_default" => 1, 'type' => "Email", 'user_id' => $user->id, 'address' => $user->email));
                $nd1->save();

                if($user->id){
                    $add = new \App\Http\Models\ProfilesAddresses();
                    $update['user_id'] = $user->id;
                    $update['phone_no'] = $post['phone'];
                    $update['mobile'] = $post['mobile'];
                    $update['post_code'] = $post['postal_code'];
                    $add->populate(array_filter($update));
                    $add->save();

                    $nd2 = new \App\Http\Models\NotificationAddresses();
                    $nd2->populate(array("is_default" => 1, 'type' => "Phone", 'user_id' => $user->id, 'address' => $add->phone_no));
                    $nd2->save();
                }

                $userArray = $user->toArray();
                $userArray['mail_subject'] = 'Thank you for registration.';
                $this->sendEMail("emails.registration_welcome", $userArray);
                \DB::commit();

                $message['title'] = "Registration Success";
                $message['msg_type'] = "success";
                $message['msg_desc'] = "Thank you for creating account with DidUEat.com. A confirmation email has been sent to your email address [$user->email]. Please verify the link. If you didn't find the email from us then <a href='" . url('auth/resend_email/' . base64_encode($user->email)) . "'><b>click here</b></a> to resend the confirmation email. Thank you.";
                return view('messages.message', $message);
                //return \Redirect::to('/auth/register');
            } catch (\Exception $e) {
                return $this->failure( $e->getMessage(),'/restaurants/signup');
            }
        } else {
            $data['title'] = "Signup Restaurants Page";
            $data['countries_list'] = \App\Http\Models\Countries::get();
            $data['states_list'] = \App\Http\Models\States::get();
            $data['cuisine_list'] = \App\Http\Models\Cuisine::get();
            //$data['resturant'] = \App\Http\Models\Restaurants::find(\Session::get('session_restaurant_id'));
            return view('restaurants-signup', $data);
        }
    }

    //sanitize time data
    public function cleanTime($time) {
        if (!$time)
            return $time;
        if (str_replace('AM', '', $time) != $time) {
            $suffix = 'AM';
        } else
            $suffix = 'PM';
        $time = str_replace(array(' AM', ' PM'), array('', ''), $time);

        $arr_time = explode(':', $time);
        $hour = $arr_time[0];
        $min = $arr_time[1];
        $sec = '00';

        if ($hour < 12 && $suffix == 'PM')
            $hour = $hour + 12;

        return $hour . ':' . $min . ':' . $sec;

    }

    /**
     * Menus Restaurants
     * @param null
     * @return view
     */
    public function menusRestaurants($slug) {
        $res_slug = \App\Http\Models\Restaurants::where('slug', $slug)->first();//load restaurant by it's slug
        $category = \App\Http\Models\Category::get();//gets a category, I don't know which one
        $data['category'] = $category;
        $data['title'] = $res_slug->name;
        $data['meta_description'] = $res_slug->description;
        $data['slug'] = $slug;
        $data['restaurant'] = $res_slug;
        \App\Http\Models\PageViews::insertView($res_slug->id, "restaurant");//update it's page views
        $data['total_restaurant_views'] = \App\Http\Models\PageViews::getView($res_slug->id, "restaurant");
        $data['states_list'] = \App\Http\Models\States::get();//load all states/provinces
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
        $menus_list = \App\Http\Models\Menus::where('restaurant_id', $resid)->where('parent', 0)->orderBy('display_order', 'ASC')->where('cat_id', $catid)->paginate(5);
        $data['menus_list'] = $menus_list;
        $data['catid'] = $catid;

        return view('menus', $data);
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
            $ext = end($arr);
            $file = date('YmdHis') . '.' . $ext;
            if ($type == 'restaurant') {
                $path = 'assets/images/restaurants';
            } else {
                $path = 'assets/images/products';
            }
            move_uploaded_file($_FILES['myfile']['tmp_name'], public_path($path) . '/' . $file);
            $file_path = url() . '/' . $path . '/' . $file;
            //handle image resizing
            foreach(array(150,300) as $size){
                $this->make_thumb(public_path($path) . '/' . $file, $size, $size, false);
            }
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
            switch (strtolower($_POST["type"])) {
                case "provinces":
                    $Provinces = select_field_where("states", array("country_id" => $_POST["country"]), false, "name", "ASC");
                    echo '<OPTION VALUE="">-select one-</OPTION>';
                    foreach($Provinces as $Province){
                        $HasProvinces = true;
                        echo '<OPTION VALUE="' . $Province->id . '"';
                        if (!empty($_POST["value"])){
                            if($Province->id == $_POST["value"]){ echo ' SELECTED'; }
                        }elseif($Province->id == 7){
                            echo ' SELECTED';
                        }
                        echo '>' . $Province->name . '</OPTION>' . "\r\n";
                    }
                    if(!isset($HasProvinces)){
                        $Provinces = get_entry("countries", $_POST["country"]);
                        if($Provinces) {
                            echo '<OPTION SELECTED DISABLED VALUE="">' . $Provinces->name . ' has no provinces/states</OPTION>';
                        } else {
                            echo '<OPTION SELECTED DISABLED VALUE="">Country: ' . $_POST["country"] . ' not found</OPTION>';
                        }
                    }
                    break;
                case "cities":
                    $city_where = (isset($_POST["province"]) && $_POST["province"] > 0)?array("state_id" => $_POST["province"]):"";
                    $Cities = select_field_where("cities", $city_where, false, "city", "ASC");
                    echo '<OPTION VALUE="">-select one-</OPTION>';
                    foreach($Cities as $City){
                        $HasCities = true;
                        echo '<OPTION VALUE="' . $City->id . '"';
                        if ( $City->id == $_POST["value"]){
                            echo ' SELECTED';
                        }
                        echo '>' . $City->city . '</OPTION>' . "\r\n";
                    }
                    if(!isset($HasCities)){
                        $Cities = get_entry("cities", $_POST["province"]);
                        if($Cities){
                            echo '<OPTION SELECTED DISABLED VALUE="">' . $Cities->city . ' has no provinces/states</OPTION>';
                        } else {
                            echo '<OPTION SELECTED DISABLED VALUE="">Province: ' . $_POST["province"] . ' not found</OPTION>';
                        }
                    }
                    break;

                default:
                    echo $_POST["type"] . " is not handled";
            }
        } else {
            echo "type not specified";
        }
        die();
    }

    //save a ratings change
    public function ratingSave() {
        $post = \Input::all();
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
                    
                    return \Response::json(array('type' => 'success', 'response' => "Thank you! for your rating."), 200);
                } else {
                    return \Response::json(array('type' => 'error', 'response' => "You already rated on this!"), 200);
                }
            } catch (Exception $e) {
                return \Response::json(array('type' => 'error', 'response' => $e->getMessage()), 500);
            }
        } else {
            return \Response::json(array('type' => 'error', 'response' => 'Invalid request made!'), 400);
        }
    }
    
    public function getToken() {
        echo csrf_token();
        die();
    }
    
}
