<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Models\Newsletter;
use App\Http\Models\PageViews;

/**
 * Home
 * @package    Laravel 5.1.11
 * @subpackage Controller
 * @author     Skp Software Technologies
 * @developer  Waqar Javed
 * @date       10 September, 2015
 */
class HomeController extends Controller
{
    public function __construct()
    {
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
    public function index()
    {
        $data['title'] = 'Home Page';
        $data['query'] = \App\Http\Models\Menus::searchMenus('', 8, 0, 'list')->get();
        $data['count'] = \App\Http\Models\Menus::searchMenus('', 8, 0, 'count')->count();
        $data['start'] = $data['query']->count();
        $data['term'] = '';

        return view('home', $data);
    }

    /**
     * Search Menus
     * @param $term
     * @param $per_page
     * @param $start
     * @return view
     */
    public function searchMenus($term = '')
    {
        $data['query'] = \App\Http\Models\Menus::searchMenus($term, 8, 0, 'list')->get();
        $data['count'] = \App\Http\Models\Menus::searchMenus($term, 8, 0, 'count')->count();
        $data['start'] = $data['query']->count();
        $data['term'] = $term;
        $data['title'] = "Search Menus";

        return view('home', $data);
    }

    /**
     * Search Menus Ajax
     * @param null
     * @return view
     */
    public function searchMenusAjax()
    {
        $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {
            try {
                $data['query'] = \App\Http\Models\Menus::searchMenus($post['term'], 8, $post['start'], 'list', $post['sortType'], $post['sortBy'], $post['priceFrom'], $post['priceTo'], $post['hasAddon'], $post['hasImage'])->get();
                $data['count'] = \App\Http\Models\Menus::searchMenus($post['term'], 8, $post['start'], 'count', $post['sortType'], $post['sortBy'], $post['priceFrom'], $post['priceTo'], $post['hasAddon'], $post['hasImage'])->count();
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
     * Search Restaurants
     * @param $term
     * @param $per_page
     * @param $start
     * @return view
     */
    public function searchRestaurants($term = '')
    {
        $data['query'] = \App\Http\Models\Restaurants::searchRestaurants($term, 8, 0, 'list')->get();
        $data['count'] = \App\Http\Models\Restaurants::searchRestaurants($term, 8, 0, 'count')->count();
        $data['cities'] = \App\Http\Models\Restaurants::distinct()->select('city')->where('open', 1)->get();
        $data['provinces'] = \App\Http\Models\Restaurants::distinct()->select('province')->where('open', 1)->get();
        $data['countries'] = \App\Http\Models\Countries::get();
        $data['start'] = $data['query']->count();
        $data['term'] = $term;
        $data['title'] = "Search Menus";

        return view('restaurants', $data);
    }


    /**
     * Search Restaurants Ajax
     * @param null
     * @return view
     */
    public function searchRestaurantsAjax()
    {
        $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {
            try {
                $data['query'] = \App\Http\Models\Restaurants::searchRestaurants($post['term'], 8, $post['start'], 'list', $post['sortType'], $post['sortBy'], $post['city'], $post['province'], $post['country'])->get();
                $data['count'] = \App\Http\Models\Restaurants::searchRestaurants($post['term'], 8, $post['start'], 'count', $post['sortType'], $post['sortBy'], $post['city'], $post['province'], $post['country'])->count();
                $data['start'] = $data['query']->count() + $post['start'];
                $data['term'] = $post['term'];

                if (!is_null($data['query']) && count($data['query']) > 0) {
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
     * All Restaurants Lists
     * @param null
     * @return view
     */
    public function allRestaurants()
    {
        $data['title'] = 'All Restaurants Page';
        $data['query'] = \App\Http\Models\Restaurants::where('open', 1)->paginate(8);
        $data['count'] = \App\Http\Models\Restaurants::where('open', 1)->count();
        $data['cities'] = \App\Http\Models\Restaurants::distinct()->select('city')->where('open', 1)->get();
        $data['provinces'] = \App\Http\Models\Restaurants::distinct()->select('province')->where('open', 1)->get();
        $data['countries'] = \App\Http\Models\Countries::get();
        $data['start'] = $data['query']->count();
        $data['term'] = '';
        
        return view('restaurants', $data);
    }
   
    /**
     * Subscriber Newsletter
     * @param null
     * @return response
     */
    public function newsletterSubscribe()
    {
        $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {
            if (!isset($post['email']) || empty($post['email'])) {
                return \Response::json(array('type' => 'error', 'message' => '[Email] field is required!'), 200);
            }
            $count = \App\Http\Models\Newsletter::where('email', $post['email'])->count();
            if ($count > 0) {
                return \Response::json(array('type' => 'error', 'message' => '['.$post['email'].'] already subscribed!'), 200);
            }

            $post['status'] = 1;
            try {
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
     * Signup Restaurants
     * @param null
     * @return view
     */
    public function signupRestaurants()
    {
        $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {
            if (!isset($post['restname']) || empty($post['restname'])) {
                \Session::flash('message', "[Restaurant Name] field is missing!");
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('/restaurants/signup')->withInput();
            }
            if (!isset($post['full_name']) || empty($post['full_name'])) {
                \Session::flash('message', "[Full Name] field is missing!");
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('/restaurants/signup')->withInput();
            }
            if (!isset($post['email']) || empty($post['email'])) {
                \Session::flash('message', "[Email] field is missing!");
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('/restaurants/signup')->withInput();
            }
            $is_email = \App\Http\Models\Profiles::where('email', '=', $post['email'])->count();
            if ($is_email > 0) {
                \Session::flash('message', "Email address [".$post['email']."] already exists!");
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('restaurants/signup')->withInput();
            }
            if (!isset($post['delivery_fee']) || empty($post['delivery_fee'])) {
                \Session::flash('message', "[Delivery Fee] field is missing!");
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('/restaurants/signup')->withInput();
            }
            if (!isset($post['minimum']) || empty($post['minimum'])) {
                \Session::flash('message', "[Minimum Sub Total For Delivery] field is missing!");
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('/restaurants/signup')->withInput();
            }
            if (!isset($post['address']) || empty($post['address'])) {
                \Session::flash('message', "[Address] field is missing!");
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('/restaurants/signup')->withInput();
            }
            if (!isset($post['city']) || empty($post['city'])) {
                \Session::flash('message', "[City] field is missing!");
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('/restaurants/signup')->withInput();
            }
            if (!isset($post['province']) || empty($post['province'])) {
                \Session::flash('message', "[Province] field is missing!");
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('/restaurants/signup')->withInput();
            }
            if (!isset($post['postal_code']) || empty($post['postal_code'])) {
                \Session::flash('message', "[Postal Code] field is missing!");
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('/restaurants/signup')->withInput();
            }
            if (!isset($post['phone']) || empty($post['phone'])) {
                \Session::flash('message', "[Phone] field is missing!");
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('/restaurants/signup')->withInput();
            }
            if (!isset($post['country']) || empty($post['country'])) {
                \Session::flash('message', "[Country] field is missing!");
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('/restaurants/signup')->withInput();
            }
            if (!isset($post['password']) || empty($post['password'])) {
                \Session::flash('message', trans('messages.user_pass_field_missing.message'));
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('/restaurants/signup')->withInput();
            }
            if (!isset($post['confirm_password']) || empty($post['confirm_password'])) {
                \Session::flash('message', trans('messages.user_confim_pass_field_missing.message'));
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('/restaurants/signup')->withInput();
            }
            if ($post['password'] != $post['confirm_password']) {
                \Session::flash('message', trans('messages.user_passwords_mismatched.message'));
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('/restaurants/signup')->withInput();
            }
            try {
                /*
                if (\Input::hasFile('logo')) {
                   
                    $image = \Input::file('logo');
                    $ext = $image->getClientOriginalExtension();
                    $newName = substr(md5(uniqid(rand())), 0, 8) . '.' . $ext;
                    $destinationPath = public_path('assets/images/restaurants');
                    $image->move($destinationPath, $newName);
                    $update['logo'] = $newName;
                }*/
                if ($post['logo'] != '') {
                    $update['logo'] = $post['logo'];
                }
                $update['name'] = $post['restname'];
                $update['slug'] = $this->createslug($post['restname']);
                $update['email'] = $post['email'];
                $update['phone'] = $post['phone'];
                $update['description'] = $post['description'];
                $update['country'] = $post['country'];
                $update['genre'] = $post['genre'];
                $update['province'] = $post['province'];
                $update['address'] = $post['address'];
                $update['city'] = $post['city'];
                $update['postal_code'] = $post['postal_code'];
                $update['delivery_fee'] = $post['delivery_fee'];
                $update['minimum'] = $post['minimum'];

                $ob = new \App\Http\Models\Restaurants();
                $ob->populate($update);
                $ob->save();
                
                event(new \App\Events\RestaurantEvent($ob, "Restaurant Created"));

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
                $data['status'] = 0;
                $data['profile_type'] = 2;
                $data['name'] = $post['full_name'];
                $data['email'] = $post['email'];
                $data['password'] = $post['password'];
                $data['subscribed'] = (isset($post['subscribed'])) ? $post['subscribed'] : 0;

                $user = new \App\Http\Models\Profiles();
                $user->populate($data);
                $user->save();
                
                event(new \App\Events\UserEvent($user, "User Created"));

                $nd1 = new \App\Http\Models\NotificationAddresses();
                $nd1->populate(array("is_default" => 1, 'type' => "Email", 'user_id' => $user->id, 'address' => $user->email));
                $nd1->save();

                if($user->id){
                    $add = new \App\Http\Models\ProfilesAddresses();
                    $update['user_id'] = $user->id;
                    $update['phone_no'] = $post['phone'];
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
                \Session::flash('message', $e->getMessage());
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('/restaurants/signup');
            }
        } else {
            $data['title'] = "Signup Restaurants Page";
            $data['countries_list'] = \App\Http\Models\Countries::get();
            $data['states_list'] = \App\Http\Models\States::get();
            $data['genre_list'] = \App\Http\Models\Genres::get();
            //$data['resturant'] = \App\Http\Models\Restaurants::find(\Session::get('session_restaurant_id'));
            return view('restaurants-signup', $data);
        }
    }

    public function cleanTime($time)
    {
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
    public function menusRestaurants($slug)
    {
        $res_slug = \App\Http\Models\Restaurants::where('slug', $slug)->first();
        $category = \App\Http\Models\Category::get();
        $data['category'] = $category;
        $data['title'] = 'Menus Restaurant Page';
        $data['slug'] = $slug;
        $data['restaurant'] = $res_slug;
        \App\Http\Models\PageViews::insertView($res_slug->id, "restaurant");
        $data['total_restaurant_views'] = \App\Http\Models\PageViews::getView($res_slug->id, "restaurant");
        $data['states_list'] = \App\Http\Models\States::get();
        //$data['menus_list'] = $menus;
        //echo '<pre>'; print_r($data['restaurant']); die;
        if (isset($_GET['page'])) {
            return view('menus', $data);
        } else {
            return view('restaurants-menus', $data);
        }
    }

    function contactus()
    {
        $data['title'] = 'Contact';
        //   $data['menus_list'] = \App\Http\Models\Menus::where('parent', 0)->orderBy('display_order', 'ASC')->paginate(10);
        return view('contactus', $data);

    }

    function createslug($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        if (empty($text)) {
            return 'n-a';
        }
        //test for same slug in db
        $text = $this->chkSlug($text);


        return $text;
    }

    function chkSlug($txt)
    {
        if (\App\Http\Models\Restaurants::where('slug', $txt)->first()) {
            $txt = $txt . rand(0, 9);
        }
        return $txt;
    }

    public function uploadimg($type = '')
    {
        if (isset($_FILES['myfile']['name']) && $_FILES['myfile']['name']) {
            $name = $_FILES['myfile']['name'];
            $arr = explode('.', $name);
            $ext = end($arr);
            $file = date('YmdHis') . '.' . $ext;
            if ($type == 'restaurant') {
                move_uploaded_file($_FILES['myfile']['tmp_name'], public_path('assets/images/restaurants') . '/' . $file);
                $file_path = url() . '/assets/images/restaurants/' . $file;
            } else {
                move_uploaded_file($_FILES['myfile']['tmp_name'], public_path('assets/images/products') . '/' . $file);
                $file_path = url() . '/assets/images/products/' . $file;
            }
            //$this->loadComponent("Image"); $this->Image->resize($file, array("300x300", "150x150"), true);
            echo $file_path . '___' . $file;
        }
        die();
    }

    function loadmenus($catid, $resid)
    {
        $res_slug = \App\Http\Models\Restaurants::where('id', $resid)->first();
        $data['restaurant'] = $res_slug;
        $menus_list = \App\Http\Models\Menus::where('restaurant_id', $resid)->where('parent', 0)->orderBy('display_order', 'ASC')->where('cat_id', $catid)->paginate(2);
        $data['menus_list'] = $menus_list;
        $data['catid'] = $catid;

        return view('menus', $data);
    }

    function countStatus($id=0)
    {
        \App\Http\Models\PageViews::insertView($id, 'menu');
        return \App\Http\Models\PageViews::getView($id, "menu");
    }


    function ajax(){
        if (!isset($_POST["type"])) {$_POST = $_GET;}
        if (isset($_POST["type"])) {
            switch (strtolower($_POST["type"])) {
                case "provinces":
                    $Provinces = select_field_where("states", array("country_id" => $_POST["country"]), false, "name", "ASC");
                    foreach($Provinces as $Province){
                        $HasProvinces = true;
                        echo '<OPTION VALUE="' . $Province->id . '"';
                        if ( $Province->id == $_POST["value"] || $Province->abbreviation == $_POST["value"]){
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

                default:
                    echo $_POST["type"] . " is not handled";
            }
        } else {
            echo "type not specified";
        }
        die();
    }
}
