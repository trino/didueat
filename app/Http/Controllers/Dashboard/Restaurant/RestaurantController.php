<?php

namespace App\Http\Controllers\Dashboard\Restaurant;

use App\Http\Controllers\Controller;

/**
 * Restaurant
 * @package    Laravel 5.1.11
 * @subpackage Controller
 * @author     Skp Software Technologies
 * @developer  Waqar Javed
 * @date       15 September, 2015
 */
class RestaurantController extends Controller {

    /**
     * Constructor
     * @param null
     * @return redirect
     */
    public function __construct() {
        $this->beforeFilter(function() {
            if (!\Session::has('is_logged_in')) {
                return \Redirect::to('auth/login')->with('message', 'Session expired please relogin!');
            }
        });
    }

    /**
     * Dashboard
     * @param null
     * @return view
     */
    public function restaurantInfo() {
        $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {
            if (!isset($post['Name']) || empty($post['Name'])) {
                return \Redirect::to('restaurant/info')->with('message', "[Restaurant Name] field is missing!");
            }
            if (!isset($post['Email']) || empty($post['Email'])) {
                return \Redirect::to('restaurant/info')->with('message', "[Restaurant Email] field is missing!");
            }
            if (!isset($post['Country']) || empty($post['Country'])) {
                return \Redirect::to('restaurant/info')->with('message', "[Country] field is missing!");
            }
            if (!isset($post['City']) || empty($post['City'])) {
                return \Redirect::to('restaurant/info')->with('message', "[City] field is missing!");
            }
            if (!isset($post['PostalCode']) || empty($post['PostalCode'])) {
                return \Redirect::to('restaurant/info')->with('message', "[Postal Code] field is missing!");
            }
            if (!isset($post['DeliveryFee']) || empty($post['DeliveryFee'])) {
                return \Redirect::to('restaurant/info')->with('message', "[Delivery Fee] field is missing!");
            }
            if (!isset($post['Minimum']) || empty($post['Minimum'])) {
                return \Redirect::to('restaurant/info')->with('message', "[Minimum Sub Total For Delivery] field is missing!");
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
                $ob = \App\Http\Models\Restaurants::findOrNew($post['ID']);
                $ob->populate($post);
                $ob->save();

                foreach ($post['Open'] as $key => $value) {
                    if (!empty($value)) {
                        $hour['Open'] = $value;
                        $hour['RestaurantID'] = $ob->ID;
                        $hour['Close'] = $post['Close'][$key];
                        $hour['DayOfWeek'] = $post['DayOfWeek'][$key];
                        $hour['ID'] = $post['IDD'][$key];
                        $ob2 = \App\Http\Models\Hours::findOrNew($hour['ID']);
                        $ob2->populate($hour);
                        $ob2->save();
                    }
                }

                return \Redirect::to('restaurant/info')->with('message', "Resturant Info updated successfully");
            } catch (\Exception $e) {
                return \Redirect::to('restaurant/info')->with('message', $e->getMessage());
            }
        } else {
            $data['title'] = "Resturant Manage";
            $data['countries_list'] = \App\Http\Models\Countries::get();
            $data['genre_list'] = \App\Http\Models\Genres::get();
            $data['resturant'] = \App\Http\Models\Restaurants::find(\Session::get('session_restaurantId'));
            return view('dashboard.restaurant.info', $data);
        }
    }

    /**
     * Addresses
     * @param null
     * @return view
     */
    public function addresses() {
        $data['title'] = 'Addresses List';
        $data['addresses_list'] = \App\Http\Models\NotificationAddresses::where('restaurantId', \Session::get('session_restaurantId'))->get();
        return view('dashboard.restaurant.addresses', $data);
    }

    /**
     * Manu Manager
     * @param null
     * @return view
     */
    public function menuManager() {
        $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {
            //echo '<pre>'; print_r($post); die;
            if (!isset($post['menu_item']) || empty($post['menu_item'])) {
                return \Redirect::to('restaurant/menus-manager')->with('message', "[Menu Item] field is missing!");
            }
            if (!isset($post['price']) || empty($post['price'])) {
                return \Redirect::to('restaurant/menus-manager')->with('message', "[Price] field is missing!");
            }
            if (!isset($post['description']) || empty($post['description'])) {
                return \Redirect::to('restaurant/menus-manager')->with('message', "[Description] field is missing!");
            }
            if (!\Input::hasFile('menu_image')) {
                return \Redirect::to('restaurant/menus-manager')->with('message', "[Image] field is missing!");
            }

            try {
                $post['image'] = "";
                if (\Input::hasFile('menu_image')) {
                    $image = \Input::file('menu_image');
                    $ext = $image->getClientOriginalExtension();
                    $newName = substr(md5(uniqid(rand())), 0, 8) . '.' . $ext;
                    $destinationPath = public_path('assets/images/products');
                    $image->move($destinationPath, $newName);
                    $post['image'] = $newName;
                }
                
                $item['restaurantId'] = \Session::get('session_restaurantId');
                $item['menu_item'] = $post['menu_item'];
                $item['price'] = $post['price'];
                $item['description'] = $post['description'];
                $item['image'] = $post['image'];
                $item['has_addon'] = (count($post['addon_menu_item']) > 0) ? 1 : 0;
                $item['parent'] = 0;
                $item['display_order'] = \App\Http\Models\Menus::count();
                
                $ob = new \App\Http\Models\Menus();
                $ob->populate($item);
                $ob->save();

                foreach ($post['addon_menu_item'] as $key => $value) {
                    $addon['restaurantId'] = \Session::get('session_restaurantId');
                    $addon['menu_item'] = $value;
                    $addon['description'] = $post['addon_description'][$key];
                    $addon['req_opt'] = $post['req_opt'][$key];
                    $addon['sing_mul'] = $post['sing_mul'][$key];
                    $addon['exact_upto'] = $post['exact_upto'][$key];
                    $addon['exact_upto_qty'] = $post['exact_upto_qty'][$key];
                    $addon['has_addon'] = 0;
                    $addon['parent'] = $ob->ID;
                    $addon['display_order'] = $ob->display_order + 1;

                    $ob2 = new \App\Http\Models\Menus();
                    $ob2->populate($addon);
                    $ob2->save();
                    
                    foreach ($post['sub_menu_item'][$key] as $key2 => $value2) {
                        $subitem['restaurantId'] = \Session::get('session_restaurantId');
                        $subitem['menu_item'] = $value2;
                        $subitem['price'] = $post['sub_price'][$key][$key2];
                        $subitem['has_addon'] = 0;
                        $subitem['parent'] = $ob2->ID;
                        $subitem['display_order'] = $ob2->display_order + 1;
                        
                        $ob3 = new \App\Http\Models\Menus();
                        $ob3->populate($subitem);
                        $ob3->save();
                    }
                }

                return \Redirect::to('restaurant/menus-manager')->with('message', "Item menus added successfully");
            } catch (\Exception $e) {
                return \Redirect::to('restaurant/menus-manager')->with('message', $e->getMessage());
            }
        } else {
            $data['title'] = 'Manus Listing';
            $data['menus_list'] = \App\Http\Models\Menus::where('restaurantId', \Session::get('session_restaurantId'))->orderBy('display_order', 'ASC')->get();
            return view('dashboard.restaurant.manus', $data);
        }
    }

    /**
     * Pending Orders
     * @param null
     * @return view
     */
    public function pendingOrders() {
        $data['title'] = 'Pending History';
        $data['orders_list'] = \App\Http\Models\Reservations::where('restaurantId', \Session::get('session_restaurantId'))->where('status', 'pending')->orderBy('order_time', 'DESC')->get();
        return view('dashboard.restaurant.orders_pending', $data);
    }

    /**
     * Pending Orders
     * @param null
     * @return view
     */
    public function historyOrders() {
        $data['title'] = 'Orders History';
        $data['orders_list'] = \App\Http\Models\Reservations::where('restaurantId', \Session::get('session_restaurantId'))->where('status', '!=', 'pending')->orderBy('order_time', 'DESC')->get();
        return view('dashboard.restaurant.orders_history', $data);
    }

    /**
     * Evens Log
     * @param null
     * @return view
     */
    public function eventsLog() {
        $data['title'] = 'Evens Log';
        $data['logs_list'] = \App\Http\Models\Eventlog::where('restaurantId', \Session::get('session_restaurantId'))->orderBy('Date', 'DESC')->get();
        return view('dashboard.restaurant.events_log', $data);
    }

    /**
     * Report Detail
     * @param null
     * @return view
     */
    public function report() {
        return view('dashboard.restaurant.report', array('title' => 'Report'));
    }

}
