<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

/**
 * Home
 * @package    Laravel 5.1.11
 * @subpackage Controller
 * @author     Skp Software Technologies
 * @developer  Waqar Javed
 * @date       10 September, 2015
 */
class HomeController extends Controller {
    public function __construct() {
        $this->beforeFilter(function() {
            initialize("home");
        });
    }
    /**
     * Home Page
     * @param null
     * @return view
     */
    public function index() {
        $data['title'] = 'Home Page';
        $data['menus_list'] = \App\Http\Models\Menus::where('parent', 0)->orderBy('display_order', 'ASC')->paginate(10);
        if(isset($_GET['page'])) {
            return view('menus', $data);
        }else {
            return view('home', $data);
        }
       
    }
    
    /**
     * All Restaurants Lists
     * @param null
     * @return view
     */
    public function allRestaurants() {
        $data['title'] = 'All Restaurants Page';
        $data['restaurants_list'] = \App\Http\Models\Restaurants::paginate(4);
        
        if(isset($_GET['page'])) {
            return view('loadrestaurants', $data);
        }else {
            return view('restaurants', $data);
        }
       
    }
    
    /**
     * Signup Restaurants
     * @param null
     * @return view
     */
    public function signupRestaurants() {
         $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {
            if (!isset($post['name']) || empty($post['name'])) {
                \Session::flash('message', "[Restaurant Name] field is missing!"); 
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('/restaurants/signup')->withInput();
            }
            if (!isset($post['email']) || empty($post['email'])) {
                \Session::flash('message', "[Restaurant Email] field is missing!"); 
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('/restaurants/signup')->withInput();
            }
            $is_email = \App\Http\Models\Profiles::where('email', '=', $post['email'])->count();
            if ($is_email > 0) {
                \Session::flash('message', trans('messages.user_email_already_exist.message')); 
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('restaurants/signup')->withInput();
            }
            if (!isset($post['country']) || empty($post['country'])) {
                \Session::flash('message', "[Country] field is missing!"); 
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
            if (!isset($post['postal_code']) || empty($post['postal_code'])) {
                \Session::flash('message', "[Postal Code] field is missing!"); 
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('/restaurants/signup')->withInput();
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
                if (\Input::hasFile('logo')) {
                    $image = \Input::file('logo');
                    $ext = $image->getClientOriginalExtension();
                    $newName = substr(md5(uniqid(rand())), 0, 8) . '.' . $ext;
                    $destinationPath = public_path('assets/images/restaurants');
                    $image->move($destinationPath, $newName);
                    $post['logo'] = $newName;
                }
                
                $update['name'] = $post['name'];
                $update['slug']= $this->createslug($post['name']);
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
                
                foreach ($post['open'] as $key => $value) {
                    if(!empty($value)){
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
                $data['profile_type'] = 1;
                $data['name'] = $post['full_name'];
                $data['email'] = $post['email'];
                $data['password'] = $post['password'];
                $data['subscribed'] = $post['subscribed'];
                $data['phone'] = $post['phone'];

                $user = new \App\Http\Models\Profiles();
                $user->populate($data);
                $user->save();

                $userArray = $user->toArray();
                $userArray['mail_subject'] = 'Thank you for registration.';
                $this->sendEMail("emails.registration_welcome", $userArray);
                \DB::commit();

                $message['title'] = "Registration Success";
                $message['msg_type'] = "success";
                $message['msg_desc'] = "Thank you for creating account with didueat.com. An confirmation email has been sent to your email address [$user->email]. Please verify the link. If you did't find the email from us then <a href='" . url('auth/resend_email/' . base64_encode($user->email)) . "'><b>click here</b></a> to resent confirmation email. thanks";
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
            $data['genre_list'] = \App\Http\Models\Genres::get();
            //$data['resturant'] = \App\Http\Models\Restaurants::find(\Session::get('session_restaurant_id'));
            return view('restaurants-signup', $data);
        }
    }
    
    public function cleanTime($time)
    {
        if(!$time)
        return $time;
        if(str_replace('AM','',$time) != $time)
        {
            $suffix = 'AM';
        }
        else
        $suffix = 'PM';
        $time = str_replace(array(' AM',' PM'),array('',''),$time);
        
        $arr_time = explode(':',$time);
        $hour = $arr_time[0];
        $min = $arr_time[1];
        $sec = '00';
        
        if($hour<12 && $suffix=='PM')
        $hour = $hour+12;
        
        return $hour.':'.$min.':'.$sec;
        
    }

    /**
     * Menus Restaurants
     * @param null
     * @return view
     */
    public function menusRestaurants($slug) {
        $res_slug = \App\Http\Models\Restaurants::where('slug', $slug)->first();
        $menus = \App\Http\Models\Menus::where('restaurant_id', $res_slug->id)->where('parent', 0)->orderBy('display_order', 'ASC')->paginate(4);
        
        $data['title'] = 'Menus Restaurant Page';
        $data['slug'] = $slug;
        $data['res_detail'] = $res_slug;
        $data['menus_list'] = $menus;
        if(isset($_GET['page'])) {
            return view('menus', $data);
        }else {
            return view('restaurants-menus', $data);
        }
    }
    
    function test() {
        if(isset($_POST)) {
            var_dump($_POST);
        }
         return view('test');
    }
    
    function createslug($text) {
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
    
    function chkSlug($txt) {
        if(\App\Http\Models\Restaurants::where('slug',$txt)->first()) {
            $txt = $txt.rand(0,9);
        }
        return $txt;
    }

}
