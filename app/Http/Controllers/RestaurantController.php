<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Models\Restaurants;

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
            initialize("restaurants");
            if (!\Session::has('is_logged_in')) {
                \Session::flash('message', trans('messages.user_session_exp.message')); 
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('auth/login');
            }
        });
    }

    /**
     * Restaurants List
     * @param null
     * @return view
     */
    public function restaurants() {
        $data['title'] = 'Restaurants List';
        $data['restaurants_list'] = \App\Http\Models\Restaurants::get();
        return view('dashboard.administrator.restaurants', $data);
    }

    /**
     * Restaurant Delete
     * @param $id
     * @return redirect
     */
    public function restaurantDelete($id = 0) {
        if (!isset($id) || empty($id) || $id == 0) {
            \Session::flash('message', "[Restaurant Id] field is missing!");
            \Session::flash('message-type', 'alert-danger');
            \Session::flash('message-short', 'Oops!');
            return \Redirect::to('restaurant/restaurants');
        }

        try {
            $ob = \App\Http\Models\Restaurants::find($id);
            $ob->delete();
            
            \Session::flash('message', "Restaurant has been deleted successfully!");
            \Session::flash('message-type', 'alert-success');
            \Session::flash('message-short', 'Oops!');
            return \Redirect::to('restaurant/restaurants');
        } catch (\Exception $e) {
            
            \Session::flash('message', $e->getMessage());
            \Session::flash('message-type', 'alert-danger');
            \Session::flash('message-short', 'Oops!');
            return \Redirect::to('restaurant/restaurants'); 
        }
    }

    /**
     * Restaurant Status
     * @param $id
     * @return redirect
     */
    public function restaurantStatus($id = 0) {
        if (!isset($id) || empty($id) || $id == 0) {
            
            \Session::flash('message', "[Restaurant Id] is missing!");
            \Session::flash('message-type', 'alert-danger');
            \Session::flash('message-short', 'Oops!');
            return \Redirect::to('restaurant/restaurants');
        }

        try {
            $ob = \App\Http\Models\Restaurants::find($id);
            if ($ob->Status == "Open") {
                $ob->populate(array('Status' => 'Close'));
            } else {
                $ob->populate(array('Status' => 'Open'));
            }
            $ob->save();
            
            \Session::flash('message', 'Restaurant status has been changed successfully!');
            \Session::flash('message-type', 'alert-success');
            \Session::flash('message-short', 'Oops!');
            return \Redirect::to('restaurant/restaurants');
        } catch (\Exception $e) {
            
            \Session::flash('message', $e->getMessage());
            \Session::flash('message-type', 'alert-danger');
            \Session::flash('message-short', 'Oops!');
            return \Redirect::to('restaurant/restaurants');
        }
    }

    /**
     * Dashboard
     * @param null
     * @return view
     */
    public function restaurantInfo($id = 0) {
        $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {
            if (!isset($post['Name']) || empty($post['Name'])) {
                \Session::flash('message', "[Restaurant Name] field is missing!");
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('restaurant/info/' . $post['ID']);
            }
            if (!isset($post['Email']) || empty($post['Email'])) {
                \Session::flash('message', "[Restaurant Email] field is missing!");
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('restaurant/info/' . $post['ID']);
            }
            if (!isset($post['Country']) || empty($post['Country'])) {
                \Session::flash('message', "[Country] field is missing!");
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('restaurant/info/' . $post['ID']);
            }
            if (!isset($post['City']) || empty($post['City'])) {
                \Session::flash('message', "[City] field is missing!");
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('restaurant/info/' . $post['ID']);
            }
            if (!isset($post['PostalCode']) || empty($post['PostalCode'])) {
                \Session::flash('message', "[Postal Code] field is missing!");
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('restaurant/info/' . $post['ID']);
            }
            if (!isset($post['DeliveryFee']) || empty($post['DeliveryFee'])) {
                \Session::flash('message', "[Delivery Fee] field is missing!");
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('restaurant/info/' . $post['ID']);
            }
            if (!isset($post['Minimum']) || empty($post['Minimum'])) {
                \Session::flash('message', "[Minimum Sub Total For Delivery] field is missing!");
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('restaurant/info/' . $post['ID']);
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
                        $hour['Open'] = $this->cleanTime($value);
                        $hour['RestaurantID'] = $ob->ID;
                        $hour['Close'] = $this->cleanTime($post['Close'][$key]);
                        $hour['DayOfWeek'] = $post['DayOfWeek'][$key];
                        $hour['ID'] = $post['IDD'][$key];
                        $ob2 = \App\Http\Models\Hours::findOrNew($hour['ID']);
                        $ob2->populate($hour);
                        $ob2->save();
                    }
                }
                
                \Session::flash('message', "Resturant Info updated successfully");
                \Session::flash('message-type', 'alert-success');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('restaurant/info/' . $post['ID']);
            } catch (\Exception $e) {
                \Session::flash('message', $e->getMessage());
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('restaurant/info/' . $post['ID']);
            }
        } else {
            $data['title'] = "Resturant Manage";
            $data['countries_list'] = \App\Http\Models\Countries::get();
            $data['genre_list'] = \App\Http\Models\Genres::get();
            $data['resturant'] = \App\Http\Models\Restaurants::find(($id > 0) ? $id : \Session::get('session_restaurantId'));
            return view('dashboard.restaurant.info', $data);
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
     * Addresses
     * @param null
     * @return view
     */
    public function addresses() {
        $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {
            try {
                $post['RestaurantID'] = \Session::get('session_restaurantId');
                $ob = new \App\Http\Models\NotificationAddresses();
                $ob->populate($post);
                $ob->save();
                
                \Session::flash('message', "Address added successfully!");
                \Session::flash('message-type', 'alert-success');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('restaurant/addresses');
            } catch (Exception $e) {
                
                \Session::flash('message', $e->getMessage());
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('restaurant/addresses');
            }
        } else {
            $data['title'] = 'Addresses List';
            $data['addresses_list'] = \App\Http\Models\NotificationAddresses::where('restaurantId', \Session::get('session_restaurantId'))->get();
            return view('dashboard.restaurant.addresses', $data);
        }
    }

    /**
     * Delete Addresses
     * @param $id
     * @return redirect
     */
    public function deleteAddresses($id = 0) {
        if (!isset($id) || empty($id) || $id == 0) {
            \Session::flash('message', "[Address Id] is missing!");
            \Session::flash('message-type', 'alert-danger');
            \Session::flash('message-short', 'Oops!');
            return \Redirect::to('restaurant/addresses');
        }

        try {
            $ob = \App\Http\Models\NotificationAddresses::find($id);
            $ob->delete();
            
            \Session::flash('message', "Address has been deleted successfully!");
            \Session::flash('message-type', 'alert-success');
            \Session::flash('message-short', 'Oops!');
            return \Redirect::to('restaurant/addresses');
        } catch (\Exception $e) {
            \Session::flash('message', $e->getMessage());
            \Session::flash('message-type', 'alert-danger');
            \Session::flash('message-short', 'Oops!');
            return \Redirect::to('restaurant/addresses');
        }
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
                \Session::flash('message', "[Menu Item] field is missing!");
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('restaurant/menus-manager');
            }
            if (!isset($post['price']) || empty($post['price'])) {
                \Session::flash('message', "[Price] field is missing!");
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('restaurant/menus-manager');
            }
            if (!isset($post['description']) || empty($post['description'])) {
                \Session::flash('message', "[Description] field is missing!");
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('restaurant/menus-manager');
            }
            if (!\Input::hasFile('menu_image')) {
                \Session::flash('message', "[Image] field is missing!");
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('restaurant/menus-manager');
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
                
                \Session::flash('message', "Item menus added successfully");
                \Session::flash('message-type', 'alert-success');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('restaurant/menus-manager');
            } catch (\Exception $e) {
                \Session::flash('message', $e->getMessage());
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('restaurant/menus-manager');
            }
        } else {
            $data['title'] = 'Manus Listing';
            $data['menus_list'] = \App\Http\Models\Menus::where('restaurantId', \Session::get('session_restaurantId'))->where('parent', 0)->orderBy('display_order', 'ASC')->get();
            return view('dashboard.restaurant.manus', $data);
        }
    }

    public function displayAddon($parent) {
        $data['menus_list'] = \App\Http\Models\Menus::where('parent', $parent)->orderBy('display_order', 'ASC')->get();
        if ($data['menus_list']) {
            return $data['menus_list'];
        }
        return false;
    }

    /**
     * Pending Orders
     * @param null
     * @return view
     */
    public function pendingOrders() {
        $data['title'] = 'Pending History';
        $data['type'] = 'Pending';
        $data['orders_list'] = \App\Http\Models\Reservations::where('restaurantId', \Session::get('session_restaurantId'))->where('status', 'pending')->orderBy('order_time', 'DESC')->get();
        return view('dashboard.restaurant.orders_pending', $data);
    }

    public function history() {
        $data['title'] = 'Orders History';
        $data['type'] = 'History';
        $data['orders_list'] = \App\Http\Models\Reservations::where('restaurantId', \Session::get('session_restaurantId'))->orderBy('order_time', 'DESC')->get();
        return view('dashboard.restaurant.orders_pending', $data);
    }

    /**
     * Change Order Status to Cancel
     * @param $id
     * @return redirect
     */
    public function changeOrderCancel($id = 0) {
        if (!isset($id) || empty($id) || $id == 0) {
            \Session::flash('message', "[Order Id] is missing!");
            \Session::flash('message-type', 'alert-danger');
            \Session::flash('message-short', 'Oops!');
            return \Redirect::to('restaurant/orders/pending');
        }
        try {
            $ob = \App\Http\Models\Reservations::find($id);
            $ob->populate(array('status' => 'cancelled'));
            $ob->save();
            
            \Session::flash('message', 'Order status has been cancelled successfully!');
            \Session::flash('message-type', 'alert-success');
            \Session::flash('message-short', 'Oops!');
            return \Redirect::to('restaurant/orders/pending');
        } catch (\Exception $e) {
            \Session::flash('message', $e->getMessage());
            \Session::flash('message-type', 'alert-danger');
            \Session::flash('message-short', 'Oops!');
            return \Redirect::to('restaurant/orders/pending');
        }
    }

    /**
     * Change Order Status to Approved
     * @param $id
     * @return redirect
     */
    public function changeOrderApprove($id = 0) {
        if (!isset($id) || empty($id) || $id == 0) {
            \Session::flash('message', "[Order Id] is missing!");
            \Session::flash('message-type', 'alert-danger');
            \Session::flash('message-short', 'Oops!');
            return \Redirect::to('restaurant/orders/pending');
        }
        try {
            $ob = \App\Http\Models\Reservations::find($id);
            $ob->populate(array('status' => 'approved'));
            $ob->save();
            
            \Session::flash('message', 'Order status has been approved successfully!');
            \Session::flash('message-type', 'alert-success');
            \Session::flash('message-short', 'Oops!');
            return \Redirect::to('restaurant/orders/pending');
        } catch (\Exception $e) {
            \Session::flash('message', $e->getMessage());
            \Session::flash('message-type', 'alert-danger');
            \Session::flash('message-short', 'Oops!');
            return \Redirect::to('restaurant/orders/pending');
        }
    }

    /**
     * Order Delete
     * @param $id
     * @return redirect
     */
    public function deleteOrder($id = 0) {
        if (!isset($id) || empty($id) || $id == 0) {
            \Session::flash('message', "[Order Id] is missing!");
            \Session::flash('message-type', 'alert-danger');
            \Session::flash('message-short', 'Oops!');
            return \Redirect::to('restaurant/orders/pending');
        }

        try {
            $ob = \App\Http\Models\Reservations::find($id);
            $ob->delete();
            
            \Session::flash('message', 'Order has been deleted successfully!');
            \Session::flash('message-type', 'alert-danger');
            \Session::flash('message-short', 'Oops!');
            return \Redirect::to('restaurant/orders/pending');
        } catch (\Exception $e) {
            \Session::flash('message', $e->getMessage());
            \Session::flash('message-type', 'alert-danger');
            \Session::flash('message-short', 'Oops!');
            return \Redirect::to('restaurant/orders/pending');
        }
    }

    /**
     * Pending Orders
     * @param null
     * @return view
     */
    public function historyOrders($id = 0) {
        $resId = ($id > 0) ? $id : \Session::get('session_restaurantId');
        $data['title'] = 'Orders History';
        $data['orders_list'] = \App\Http\Models\Reservations::where('restaurantId', $resId)->orderBy('order_time', 'DESC')->get();
        return view('dashboard.restaurant.orders_history', $data);
    }

    /**
     * Evens Log
     * @param null
     * @return view
     */
    public function eventsLog() {
        $data['title'] = 'Events Log';
        $data['logs_list'] = \App\Http\Models\Eventlog::where('restaurantId', \Session::get('session_restaurantId'))->orderBy('Date', 'DESC')->get();
        return view('dashboard.restaurant.events_log', $data);
    }

    /**
     * Report Detail
     * @param null
     * @return view
     */
    public function report() {
        $order = \App\Http\Models\Reservations::where('restaurantId', \Session::get('session_restaurantId'))->leftJoin('Restaurants', 'Reservations.restaurantId', '=', 'Restaurants.ID');
        if (isset($_GET['from'])) {
            $order = $order->where('order_till', '>=', $_GET['from']);
        }
        if (isset($_GET['to'])) {
            $order = $order->where('order_till', '<=', $_GET['to']);
        }

        $data['orders'] = $order->get();
        $data['title'] = 'Report';
        return view('dashboard.restaurant.report', $data);
    }

    public function menu_form($id) {
        //$this->layout = 'blank';
        $data['menu_id'] = $id;
        if ($id != 0) {
            //$id = $_GET['menu_id'];
            //$table = TableRegistry::get('menus');
            $data['model'] = \App\Http\Models\Menus::where('ID', $id)->get()[0];
            $data['cmodel'] = \App\Http\Models\Menus::where('parent', $id)->orderBy('display_order', 'ASC')->get();
            $data['ccount'] = \App\Http\Models\Menus::where('parent', $id)->count();

            return view('dashboard.restaurant.menu_form', $data);
        }
        return view('dashboard.restaurant.menu_form', $data);
    }

    public function getMore($id) {
        //$table = TableRegistry::get('menus');
        return $cchild = \App\Http\Models\Menus::where('parent', $id)->orderBy('display_order', 'ASC')->get();
    }

    public function additional() {
        return view('dashboard.restaurant.additional');
    }

    public function uploadimg() {
        if (isset($_FILES['myfile']['name']) && $_FILES['myfile']['name']) {
            $name = $_FILES['myfile']['name'];
            $arr = explode('.', $name);
            $ext = end($arr);
            $file = date('YmdHis') . '.' . $ext;
            //echo url();die();

            move_uploaded_file($_FILES['myfile']['tmp_name'], public_path('assets/images/products') . '/' . $file);
            $file_path = url() . '/assets/images/products/' . $file;
            //$this->loadComponent("Image"); $this->Image->resize($file, array("300x300", "150x150"), true);
            echo $file_path . '___' . $file;
        }
        die();
    }

    public function getToken() {
        echo csrf_token();
        die();
    }

    public function menuadd() {

        //echo '<pre>';print_r($_POST); die;
        //$this->loadModel("Menus");
        //$this->loadComponent('Manager');
        $arr['restaurantId'] = \Session::get('session_restaurantId');

        $Copy = array('menu_item', 'price', 'description', 'image', 'parent', 'has_addon', 'sing_mul', 'exact_upto', 'exact_upto_qty', 'req_opt', 'has_addon','display_order');
        foreach ($Copy as $Key) {
            if (isset($_POST[$Key])) {
                $arr[$Key] = $_POST[$Key];
            }
        }

        if (isset($_GET['id']) && $_GET['id']) {
            //die('update');
            $id = $_GET['id'];
            \App\Http\Models\Menus::where('ID', $id)->update($arr);


            $child = \App\Http\Models\Menus::where('parent', $id)->get();
            foreach ($child as $c) {
                \App\Http\Models\Menus::where('parent', $c->ID)->delete();
            }
            \App\Http\Models\Menus::where('parent', $id)->delete();
            echo $id;
            die();
        } else {
            //die('add');
            //$cchild = \App\Http\Models\Menus::where(['res_id'=>$this->Manager->read('ID'),'parent'=>0])->get(); 
            $orders_mod = \App\Http\Models\Menus::where('restaurantId', \Session::get('session_restaurantId'))->where('parent', 0)->orderBy('display_order', 'desc')->get();
            if (is_array($orders_mod) && count($orders_mod)) {
                $orders = $orders_mod[0];
                if(!isset($arr['display_order']))
                $arr['display_order'] = $orders->display_order + 1;
            }
            
            $ob2 = new \App\Http\Models\Menus();
            $ob2->populate($arr);
            $ob2->save();

            echo $ob2->ID;
            die();
        }
    }

    public function orderCat() {
        $_POST['ids'] = explode(',', $_POST['ids']);
        foreach ($_POST['ids'] as $k => $id) {
            \App\Http\Models\Menus::where('ID', $id)->update(array('display_order' => ($k + 1)));
        }
        die();
    }

    public function deleteMenu($id) {
        \App\Http\Models\Menus::where('ID', $id)->delete();
        $child = \App\Http\Models\Menus::where('parent', $id)->get();
        foreach ($child as $c) {
            \App\Http\Models\Menus::where('parent', $c->ID)->delete();
        }
        \App\Http\Models\Menus::where('parent', $id)->delete();
        
        \Session::flash('message', 'Item deleted successfully');
        \Session::flash('message-type', 'alert-success');
        \Session::flash('message-short', 'Oops!');
        return \Redirect::to('restaurant/menus-manager');
    }

    public function order_detail($ID) {
        if ($data['order'] = \App\Http\Models\Reservations::where('Reservations.id', $ID)->leftJoin('Restaurants', 'Reservations.restaurantId', '=', 'Restaurants.ID')->first()) {
            if (is_null($data['order']['restaurantId'])) {
                return back()->with('status', 'Restaurant Not Found!');
            } else {
                $data['title'] = 'Orders Detail';
                return view('dashboard.restaurant.orders_detail', $data);
            }
        }
    }
    public function red($path)
    {
        return \Redirect::to('restaurant/'.$path)->with('message', 'Restaurant menu successfully updated');
    }

}
