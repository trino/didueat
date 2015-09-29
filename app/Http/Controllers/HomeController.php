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
            if (!isset($post['Email']) || empty($post['Email'])) {
                return \Redirect::to('/restaurants/signup')->with('message', "[Restaurant Email] field is missing!")->withInput();
            }
            $is_email = \App\Http\Models\Restaurants::where('Email', '=', $post['Email'])->count();
            if ($is_email > 0) {
                return \Redirect::to('restaurants/signup')->with('message', trans('messages.user_email_already_exist.message'))->withInput();
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
            try {
                if (\Input::hasFile('logo')) {
                    $image = \Input::file('logo');
                    $ext = $image->getClientOriginalExtension();
                    $newName = substr(md5(uniqid(rand())), 0, 8) . '.' . $ext;
                    $destinationPath = public_path('assets/images/restaurants');
                    $image->move($destinationPath, $newName);
                    $post['Logo'] = $newName;
                }
                
                $ob = new \App\Http\Models\Restaurants();
                $ob->populate($post);
                $ob->save();
                
                foreach ($post['Open'] as $key => $value) {
                    if(!empty($value)){
                        $hour['RestaurantID'] = $ob->ID;
                        $hour['Open'] = $value;
                        $hour['Close'] = $post['Close'][$key];
                        $hour['DayOfWeek'] = $post['DayOfWeek'][$key];
                        $ob2 = new \App\Http\Models\Hours();
                        $ob2->populate($hour);
                        $ob2->save();
                    }
                }
                
                \Session::put('TempRestaurantID', $ob->ID);

                return \Redirect::to('/auth/register')->with('message', "Resturant created successfully");
            } catch (\Exception $e) {
                return \Redirect::to('/restaurants/signup')->with('message', $e->getMessage());
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
        $menus = \App\Http\Models\Menus::where('res_id', $res_slug->ID)->where('parent', 0)->get();
        
        $data['title'] = 'Menus Restaurant Page';
        $data['slug'] = $slug;
        $data['res_detail'] = $res_slug;
        $data['menus_list'] = $menus;
        return view('restaurants-menus', $data);
    }
    
    function test()
    {
        if(isset($_POST))
        {
            var_dump($_POST);
        }
         return view('test');
    }

}
