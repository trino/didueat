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

    /**
     * Home Page
     * @param null
     * @return view
     */
    public function index() {


        $data['title'] = 'Home Page';
        $data['menus_list'] = \App\Http\Models\Menus::where('parent', 0)->orderBy('display_order', 'ASC')->get();
        return view('home', $data);
    }

    /**
     * All Restaurants Lists
     * @param null
     * @return view
     */
    public function allRestaurants() {
        $data['title'] = 'All Restaurants Page';
        $data['restaurants_list'] = \App\Http\Models\Restaurants::get();
        return view('restaurants', $data);
    }

    /**
     * Signup Restaurants
     * @param null
     * @return view
     */
    public function signupRestaurants() {
        $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {
            if (!isset($post['Name']) || empty($post['Name'])) {
                return \Redirect::to('/restaurants/signup')->with('message', "[Restaurant Name] field is missing!")->withInput();
            }
            if (!isset($post['Country']) || empty($post['Country'])) {
                return \Redirect::to('/restaurants/signup')->with('message', "[Country] field is missing!")->withInput();
            }
            if (!isset($post['City']) || empty($post['City'])) {
                return \Redirect::to('/restaurants/signup')->with('message', "[City] field is missing!")->withInput();
            }
            if (!isset($post['PostalCode']) || empty($post['PostalCode'])) {
                return \Redirect::to('/restaurants/signup')->with('message', "[Postal Code] field is missing!")->withInput();
            }
            if (!isset($post['DeliveryFee']) || empty($post['DeliveryFee'])) {
                return \Redirect::to('/restaurants/signup')->with('message', "[Delivery Fee] field is missing!")->withInput();
            }
            if (!isset($post['Minimum']) || empty($post['Minimum'])) {
                return \Redirect::to('/restaurants/signup')->with('message', "[Minimum Sub Total For Delivery] field is missing!")->withInput();
            }
            
            if (!isset($post['full_name']) || empty($post['full_name'])) {
                return \Redirect::to('restaurants/signup')->with('message', '[Full Name] field is missing!')->withInput();
            }
            if (!isset($post['email']) || empty($post['email'])) {
                return \Redirect::to('restaurants/signup')->with('message', trans('messages.user_missing_email.message'))->withInput();
            }

            $is_email = \App\Http\Models\Profiles::where('email', '=', $post['email'])->count();
            if ($is_email > 0) {
                return \Redirect::to('restaurants/signup')->with('message', trans('messages.user_email_already_exist.message'))->withInput();
            }
            if (!isset($post['password']) || empty($post['password'])) {
                return \Redirect::to('restaurants/signup')->with('message', trans('messages.user_pass_field_missing.message'))->withInput();
            }
            if (!isset($post['confirm_password']) || empty($post['confirm_password'])) {
                return \Redirect::to('restaurants/signup')->with('message', trans('messages.user_confim_pass_field_missing.message'))->withInput();
            }
            if ($post['password'] != $post['confirm_password']) {
                return \Redirect::to('restaurants/signup')->with('message', trans('messages.user_passwords_mismatched.message'))->withInput();
            } else {
                \DB::beginTransaction();
                try {
                    $post1['Name'] = $post['Name'];
                    $post1['Slug'] = str_replace('&nbsp;', '-', strtolower($post['Name']));
                    $post1['Phone'] = $post['Phone'];
                    $post1['Description'] = $post['Description'];
                    $post1['Country'] = $post['Country'];
                    $post1['Province'] = $post['Province'];
                    $post1['Address'] = $post['Address'];
                    $post1['City'] = $post['City'];
                    $post1['PostalCode'] = $post['PostalCode'];
                    $post1['Genre'] = $post['Genre'];
                    $post1['DeliveryFee'] = $post['DeliveryFee'];
                    $post1['Minimum'] = $post['Minimum'];
                    
                    if (\Input::hasFile('logo')) {
                        $image = \Input::file('logo');
                        $ext = $image->getClientOriginalExtension();
                        $newName = substr(md5(uniqid(rand())), 0, 8) . '.' . $ext;
                        $destinationPath = public_path('assets/images/restaurants');
                        $image->move($destinationPath, $newName);
                        $post1['Logo'] = $newName;
                    }

                    $ob = new \App\Http\Models\Restaurants();
                    $ob->populate($post1);
                    $ob->save();

                    foreach ($post['Open'] as $key => $value) {
                        if (!empty($value)) {
                            $hour['RestaurantID'] = $ob->ID;
                            $hour['Open'] = $value;
                            $hour['Close'] = $post['Close'][$key];
                            $hour['DayOfWeek'] = $post['DayOfWeek'][$key];
                            $ob2 = new \App\Http\Models\Hours();
                            $ob2->populate($hour);
                            $ob2->save();
                        }
                    }

                    $post2['status'] = 0;
                    $post2['profileType'] = 1;
                    $post2['restaurantId'] = $ob->ID;
                    $post2['name'] = $post['full_name'];
                    $post2['email'] = $post['email'];
                    $post2['phone'] = $post['Phone'];
                    $post2['password'] = $post['password'];
                    $post2['subscribed'] = $post['subscribed'];

                    $user = new \App\Http\Models\Profiles();
                    $user->populate($post2);
                    $user->save();

                    $userArray = $user->toArray();
                    $userArray['mail_subject'] = 'Thank you for registration.';
                    $this->sendEMail("emails.registration_welcome", $userArray);
                    \DB::commit();

                    $message['title'] = "Registration Success";
                    $message['msg_type'] = "success";
                    $message['msg_desc'] = "Thank you for creating account with didueat.com. An confirmation email has been sent to your email address [$user->email]. Please verify the link. If you did't find the email from us then <a href='" . url('auth/resend_email/' . base64_encode($user->email)) . "'><b>click here</b></a> to resent confirmation email. thanks";
                    return view('messages.message', $message);
                } catch (\Illuminate\Database\QueryException $e) {
                    \DB::rollback();
                    return \Redirect::to('restaurants/signup')->with('message', trans('messages.user_email_already_exist.message'))->withInput();
                } catch (\Exception $e) {
                    \DB::rollback();
                    return \Redirect::to('restaurants/signup')->with('message', $e->getMessage())->withInput();
                }
            }
        } else {
            $data['title'] = "Signup Restaurants Page";
            $data['countries_list'] = \App\Http\Models\Countries::get();
            $data['genre_list'] = \App\Http\Models\Genres::get();
            //$data['resturant'] = \App\Http\Models\Restaurants::find(\Session::get('session_restaurantId'));
            return view('restaurants-signup', $data);
        }
    }

    /**
     * Menus Restaurants
     * @param null
     * @return view
     */
    public function menusRestaurants($slug) { 
        $res_slug = \App\Http\Models\Restaurants::where('Slug', $slug)->first();
        $menus = \App\Http\Models\Menus::where('restaurantId', $res_slug->ID)->where('parent', 0)->paginate(8);
        
        $data['title'] = 'Menus Restaurant Page';
        $data['slug'] = $slug;
        $data['res_detail'] = $res_slug;
        $data['menus_list'] = $menus;
        if(isset($_GET['page']))
            return view('menus', $data);
        else
            return view('restaurants-menus', $data);
    }

    function test() {
        if (isset($_POST)) {
            var_dump($_POST);
        }
        return view('test');
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
        
          if (empty($text))
          {
            return 'n-a';
          }
          //test for same slug in db
          $text = $this->chkSlug($text);
          
    
      return $text;
    }
    
    function chkSlug($txt)
    {
        if(\App\Http\Models\Restaurants::where('slug',$txt)->first())
        {
            $txt = $txt.rand(0,9);
        }
        
            return $txt;
    }

}
