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
            /*if (!\Session::has('is_logged_in')) {
                \Session::flash('message', trans('messages.user_session_exp.message'));
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('/restaurants');
                return \Redirect::to('auth/login');
            }*/
        });
    }

    /**
     * Restaurants List
     * @param null
     * @return view
     */
    public function restaurants() {
        $data['title'] = 'Restaurants List';
        $data['restaurants_list'] = \App\Http\Models\Restaurants::get();//get all restaurants
        return view('dashboard.administrator.restaurants', $data);
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
            return $this->success('Restaurant status has been changed successfully!', 'restaurant/list');
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
        $post = \Input::all();//check for missing data
        if (isset($post) && count($post) > 0 && !is_null($post)) {
            if (!isset($post['restname']) || empty($post['restname'])) {
                return $this->failure("[Restaurant Name] field is missing!", '/restaurant/add/new', true);
            }
            if (!isset($post['delivery_fee']) || empty($post['delivery_fee'])) {
                return $this->failure("[Delivery Fee] field is missing!", '/restaurant/add/new', true);
            }
            if (!isset($post['minimum']) || empty($post['minimum'])) {
                return $this->failure("[Minimum Sub Total For Delivery] field is missing!",'/restaurant/add/new', true);
            }
            if (!isset($post['address']) || empty($post['address'])) {
                return $this->failure("[Address] field is missing!",'/restaurant/add/new', true);
            }
            if (!isset($post['city']) || empty($post['city'])) {
                return $this->failure( "[City] field is missing!",'/restaurant/add/new', true);
            }
            if (!isset($post['province']) || empty($post['province'])) {
                return $this->failure("[Province] field is missing!",'/restaurant/add/new', true);
            }
            if (!isset($post['postal_code']) || empty($post['postal_code'])) {
                return $this->failure("[Postal Code] field is missing!", '/restaurant/add/new', true);
            }
            if (!isset($post['phone']) || empty($post['phone'])) {
                return $this->failure("[Phone] field is missing!",'/restaurant/add/new', true);
            }
            if (!isset($post['country']) || empty($post['country'])) {
                return $this->failure("[Country] field is missing!", '/restaurant/add/new', true);
            }
            try {//populate data array from the post
                if ($post['logo'] != '') {
                    $update['logo'] = $post['logo'];
                }
                $update['name'] = $post['restname'];
                $update['slug'] = $this->createslug($post['restname']);
                $update['email'] = $post['email'];
                $update['phone'] = $post['phone'];
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
                $update['open'] = 1;
                $update['status'] = 1;

                $browser_info = getBrowser();
                $update['ip_address'] = get_client_ip_server();
                $update['browser_name'] = $browser_info['name'];
                $update['browser_version'] = $browser_info['version'];
                $update['browser_platform'] = $browser_info['platform'];

                $ob = new \App\Http\Models\Restaurants();
                $ob->populate(array_filter($update));
                $ob->save();
                
                event(new \App\Events\AppEvents($ob, "Restaurant Created"));

                //handle resizing of it's logo
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

                //save hours of operation
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

                return $this->success('Restaurant created successfully!', '/restaurant/list');
            } catch (\Exception $e) {
                return $this->failure("RestaurantController/addRestaurants:" . $e->getMessage(), '/restaurant/add/new');
            }
        } else {
            $data['title'] = "Add New Restaurants";
            $data['countries_list'] = \App\Http\Models\Countries::get();
            $data['cuisine_list'] = \App\Http\Models\Cuisine::get();
            return view('dashboard.restaurant.addrestaurant', $data);
        }
    }

    /**
     * seems to be a duplicate of addRestaurants
     * @param null
     * @return view
     */
    public function restaurantInfo($id = 0) {
        $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {//check for missing data
            if (!isset($post['name']) || empty($post['name'])) {
                return $this->failure("[Restaurant Name] field is missing!", 'restaurant/info/' . $post['id']);
            }
            if (!isset($post['country']) || empty($post['country'])) {
                return $this->failure("[Country] field is missing!", 'restaurant/info/' . $post['id']);
            }
            if (!isset($post['city']) || empty($post['city'])) {
                return $this->failure("[City] field is missing!", 'restaurant/info/' . $post['id']);
            }
            if (!isset($post['postal_code']) || empty($post['postal_code'])) {
                return $this->failure("[Postal Code] field is missing!", 'restaurant/info/' . $post['id']);
            }
            try {
                if ($post['logo'] != '') {
                    $im = explode('.', $post['logo']);
                    $ext = end($im);
                    $res = \App\Http\Models\Restaurants::find($post['id']);
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
                    $sizes = ['assets/images/restaurants/' . $post['id'] . '/thumb_' => '145x100', 'assets/images/restaurants/' . $post['id'] . '/thumb1_' => '120x85'];
                    copyimages($sizes, $filename, $newName);
                    $update['logo'] = $newName;
                }

                $update['name'] = $post['name'];
                if ($post['id'] == ''){
                    $update['slug'] = $this->createslug($post['name']);
                }
                $update['email'] = $post['email'];
                $update['phone'] = $post['phone'];
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
                
                $ob = \App\Http\Models\Restaurants::findOrNew($post['id']);
                $ob->populate($update);
                $ob->save();
                
                event(new \App\Events\AppEvents($ob, "Restaurant Updated"));

                foreach ($post['open'] as $key => $value) {
                    if (!empty($value)) {
                        $hour['open'] = $this->cleanTime($value);
                        $hour['restaurant_id'] = $ob->id;
                        $hour['close'] = $this->cleanTime($post['close'][$key]);
                        $hour['day_of_week'] = $post['day_of_week'][$key];

                        $hour['id'] = $post['idd'][$key];
                        $ob2 = \App\Http\Models\Hours::findOrNew($hour['id']);
                        $ob2->populate($hour);
                        $ob2->save();
                    }
                }

                return $this->success("Resturant Info updated successfully", 'restaurant/info/' . $post['id']);
            } catch (\Exception $e) {
                return $this->failure(handleexception($e), 'restaurant/info/' . $post['id']);
            }
        } else {
            $data['title'] = "Resturant Manage";
            $data['countries_list'] = \App\Http\Models\Countries::get();
            $data['cuisine_list'] = \App\Http\Models\Cuisine::get();
            $data['resturant'] = \App\Http\Models\Restaurants::find(($id > 0) ? $id : \Session::get('session_restaurant_id'));
            return view('dashboard.restaurant.info', $data);
        }
    }

    /**
     * Addresses for editing and creating notification addresses
     * @param null
     * @return view
     */
    public function addresses() {
        $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {
            try {
                $post['user_id'] = \Session::get('session_id');
                $post['type'] = "Phone";
                $post['is_default'] = 1;
                if(isset($post['is_contact_type']) && trim($post['is_contact_type']) > 0) {
                    $post['is_call'] = (isset($post['is_call']) && $post['is_call'] > 0)?1:0;
                    $post['is_sms'] = (isset($post['is_sms']) && $post['is_sms'] > 0)?1:0;
                }
                if(filter_var($post['address'], FILTER_VALIDATE_EMAIL)) {
                    $post['type'] = "Email";
                }
                $update_id = (isset($post['id']))?$post['id']:0;
                $ob = \App\Http\Models\NotificationAddresses::findOrNew($update_id);
                $ob->populate($post);
                $ob->save();

                $ob2 = \App\Http\Models\NotificationAddresses::where('user_id', \Session::get('session_id'))->where('id', '!=', $ob->id)->where('type', $ob->type)->get();
                foreach($ob2 as $value1){
                    $in2 = \App\Http\Models\NotificationAddresses::find($value1->id);
                    $in2->populate(array("is_default" => 0));
                    $in2->save();
                }

                return $this->success("Notification address saved successfully!", 'restaurant/addresses');
            } catch (Exception $e) {
                return $this->failure( $e->getMessage(), 'restaurant/addresses');
            }
        } else {
            $data['title'] = 'Addresses List';
            $data['addresses_list'] = \App\Http\Models\NotificationAddresses::where('user_id', \Session::get('session_id'))->orderBy('order', 'ASC')->get();
            return view('dashboard.restaurant.addresses', $data);
        }
    }
    
    /**
     * Credit Card Sequance Change
     * @param none
     * @return response
     */
    public function addressesSequence() {
        $this->saveCreditCardsSequance();
    }

    /**
     * Edit Address Form
     * @param $id
     * @return view
     */
    public function ajaxEditAddressForm( $id=0 ) {
        $data['address_detail'] = \App\Http\Models\NotificationAddresses::find($id);
        return view('ajax.editaddress', $data);
    }



    /**
     * Delete a notification Address
     * @param $id of the address to delete
     * @return redirect
     */
    public function deleteAddresses($id = 0) {
        if (!isset($id) || empty($id) || $id == 0) {//check for missing data
            return $this->failure("[Address Id] is missing!", 'restaurant/addresses');
        }
        try {
            $ob = \App\Http\Models\NotificationAddresses::find($id);
            $ob->delete();
            return $this->success("Address has been deleted successfully!", 'restaurant/addresses');
        } catch (\Exception $e) {
            return $this->failure( $e->getMessage(), 'restaurant/addresses');
        }
    }

    /**
     * sets a Default notification Address, and sets all others to not the default
     * @param $id
     * @return redirect
     */
    public function defaultAddresses($id = 0) {
        if (!isset($id) || empty($id) || $id == 0) {
            return $this->failure("[Address Id] is missing!", 'restaurant/addresses');
        }

        try {
            $ob = \App\Http\Models\NotificationAddresses::find($id);
            $ob->populate(array("is_default" => 1));
            $ob->save();

            $ob2 = \App\Http\Models\NotificationAddresses::where('user_id', \Session::get('session_id'))->where('id', '!=', $ob->id)->where('type', $ob->type)->get();
            foreach($ob2 as $value1){
                $in2 = \App\Http\Models\NotificationAddresses::find($value1->id);
                $in2->populate(array("is_default" => 0));
                $in2->save();
            }

            return $this->success("Address has been default successfully!", 'restaurant/addresses');
        } catch (\Exception $e) {
            return $this->failure(handleexception($e), 'restaurant/addresses');
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
                return $this->failure("[Description] field is missing!", 'restaurant/menus-manager');
            }
            if (!\Input::hasFile('menu_image')) {
                return $this->failure("[Image] field is missing!", 'restaurant/menus-manager');
            }

            try {
                $post['image'] = "";
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
                $item['description'] = $post['description'];
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
            return view('dashboard.restaurant.manus', $data);
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

    /**
     * Pending Orders
     * @param null
     * @return view
     */
    public function pendingOrders($id=0) {
        $data['title'] = 'Orders History';
        $data['type'] = 'Pending';
        $data['orders_list'] = \App\Http\Models\Reservations::where('restaurant_id', ($id > 0)?$id:\Session::get('session_restaurant_id'))->orderBy('order_time', 'DESC')->get();
        return view('dashboard.restaurant.orders_pending', $data);
    }

    //gets all orders for this restaurant
    public function history($id=0) {
        $data['title'] = 'Orders History';
        $data['type'] = 'History';
        $data['orders_list'] = \App\Http\Models\Reservations::where('restaurant_id', ($id > 0)?$id:\Session::get('session_restaurant_id'))->orderBy('order_time', 'DESC')->get();
        return view('dashboard.restaurant.orders_pending', $data);
    }

    /**
     * Change Order Status to Cancel
     * @param $id
     * @return redirect
     */
    public function changeOrderCancel() {
        return $this->changeOrderStatus('cancelled', 'Your order has been cancelled.', "emails.order_cancel", 'Order has been cancelled successfully!');
    }


    /**
     * Change Order Status to $status, send email (using $subject/$email) and $flash
     * @param $id (POST)
     * @return redirect
     */
    public function changeOrderStatus($status, $subject, $email, $flash){
        $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {
            if (!isset($post['id']) || empty($post['id'])) {
                return $this->failure("[Order Id] is missing!", 'restaurant/orders/admin');
            }
            if (!isset($post['note']) || empty($post['note'])) {
                return $this->failure("[Note Field] is missing!", 'restaurant/orders/admin');
            }

            try {
                $ob = \App\Http\Models\Reservations::find($post['id']);
                $ob->populate(array('status' => $status, 'note' => $post['note']));
                $ob->save();

                if ($ob->user_id) {
                    $userArray = \App\Http\Models\Profiles::find($ob->user_id)->toArray();
                    $userArray['mail_subject'] = $subject;
                    $userArray['note'] = $post['note'];
                    $this->sendEMail($email, $userArray);
                }
                return $this->success($flash, 'restaurant/orders/admin');
            } catch (\Exception $e) {
                return $this->failure(handleexception($e), 'restaurant/orders/admin');
            }
        } else {
            return $this->failure("Invalid request made!", 'restaurant/orders/admin');
        }
    }

    /**
     * Change Order Status to Approved
     * @param $id
     * @return redirect
     */
    public function changeOrderApprove() {
        return $this->changeOrderStatus('approved', 'Your order has been approved.', "emails.order_approve", 'Order has been approved successfully!');
    }

    /**
     * Change Order Status to Disapproved
     * @param $id
     * @return redirect
     */
    public function changeOrderDisapprove() {
        return $this->changeOrderStatus('pending', 'Your order has been disapproved.', "emails.order_disapprove", 'Order has been disapproved successfully!');
    }

    /**
     * Delete Order $id
     * @param $id
     * @return redirect
     */
    public function deleteOrder($id = 0) {
        if (!isset($id) || empty($id) || $id == 0) {
            return $this->failure("[Order Id] is missing!", 'restaurant/orders/admin');
        }
        try {
            $ob = \App\Http\Models\Reservations::find($id);
            $ob->delete();
            return $this->success('Order has been deleted successfully!', 'restaurant/orders/admin');
        } catch (\Exception $e) {
            return $this->failure(handleexception($e), 'restaurant/orders/admin');
        }
    }

    /**
     * gets orders placed for this restaurant
     * @param null
     * @return view
     */
    public function historyOrders($id = 0) {
        $resId = ($id > 0) ? $id : \Session::get('session_restaurant_id');
        $data['title'] = 'Orders History';
        $data['orders_list'] = \App\Http\Models\Reservations::where('restaurant_id', $resId)->orderBy('order_time', 'DESC')->get();
        return view('dashboard.restaurant.orders_history', $data);
    }

    /**
     * Events Log
     * gets all events for the user's restaurant
     * @param null
     * @return view
     */
    public function eventsLog() {
        $data['title'] = 'Events Log';
        $data['logs_list'] = \App\Http\Models\Eventlog::where('restaurant_id', \Session::get('session_restaurant_id'))->orderBy('created_at', 'DESC')->get();
        return view('dashboard.restaurant.events_log', $data);
    }

    /**
     * gets orders between from and to time
     * @param $res_id (restaurant ID)
     * @return view
     */
    public function report($res_id = 0) {
        if(!$res_id){$res_id = \Session::get('session_restaurant_id');}//gets all orders for this restaurant
        $order = \App\Http\Models\Reservations::where('restaurant_id', $res_id)->leftJoin('restaurants', 'reservations.restaurant_id', '=', 'restaurants.id');
        if (isset($_GET['from'])) {
            $order = $order->where('order_time', '>=', $_GET['from']);//equal to and greater than from time
        }
        if (isset($_GET['to'])) {
            $order = $order->where('order_time', '<=', $_GET['to']);//equal to and lesser than to time
        }

        $data['orders'] = $order->get();
        $data['states_list'] = \App\Http\Models\States::get();//gets all states/provinces
        $data['title'] = 'Report';
        return view('dashboard.restaurant.report', $data);
    }

    //return a menu item and it's child items
    public function menu_form($id, $res_id = 0) {
        $data['menu_id'] = $id;
        if(!$res_id){$res_id = \Session::get('session_restaurant_id');}
        $data['res_id'] = $res_id;
        $data['res_slug'] = select_field('restaurants', 'id', $res_id, 'slug');
        $data['category'] = \App\Http\Models\category::orderBy('display_order', 'ASC')->get();
        if ($id != 0) {
            $data['model'] = \App\Http\Models\Menus::where('id', $id)->get()[0];
            $data['cmodel'] = \App\Http\Models\Menus::where('parent', $id)->orderBy('display_order', 'ASC')->get();
            $data['ccount'] = \App\Http\Models\Menus::where('parent', $id)->count();
            return view('dashboard.restaurant.menu_form', $data);
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
    public function uploadimg($type = '') {
        if (isset($_FILES['myfile']['name']) && $_FILES['myfile']['name']) {
            $name = $_FILES['myfile']['name'];
            $arr = explode('.', $name);
            $ext = end($arr);
            $file = date('YmdHis') . '.' . $ext;
            if ($type == 'restaurant') {
                $path = 'assets/images/restaurants';
            } else if ($type == 'user') {
                $path = 'assets/images/users';
            } else {
                $path = 'assets/images/products';
            }
            move_uploaded_file($_FILES['myfile']['tmp_name'], public_path($path) . '/' . $file);
            $file_path = url() . "/" . $path . "/" . $file;
            //for each size in the array, make a thumbnail of the image.ext as image(WIDTHxHEIGHT).ext in the same folder
            foreach(array(150,300) as $size){
                $this->make_thumb(public_path($path) . '/' . $file, $size, $size, false);
            }
            echo $file_path . '___' . $file;
        }
        die();
    }

    //add a menu item
    public function menuadd() {
        $arr['restaurant_id'] = \Session::get('session_restaurant_id');
        //copy these keys to the $arr
        $Copy = array('menu_item', 'price', 'description', 'image', 'parent', 'has_addon', 'sing_mul', 'exact_upto', 'exact_upto_qty', 'req_opt', 'has_addon', 'display_order', 'cat_id');
        foreach ($Copy as $Key) {
            if (isset($_POST[$Key])) {
                $arr[$Key] = $_POST[$Key];
            }
        }
        //add this restaurant to the categories table
        if (!is_numeric($arr['cat_id'])) {
            $arrs['title'] = $arr['cat_id'];
            $arrs['res_id'] = $arr['restaurant_id'];
            $ob2 = new \App\Http\Models\Category();
            $ob2->populate($arrs);
            $ob2->save();
            $arr['cat_id'] = $ob2->id;
        }
        
        if (isset($_GET['id']) && $_GET['id']) {
            $id = $_GET['id'];
            \App\Http\Models\Menus::where('id', $id)->update($arr);
            //delete all child items
            $child = \App\Http\Models\Menus::where('parent', $id)->get();
            foreach ($child as $c) {
                \App\Http\Models\Menus::where('parent', $c->id)->delete();
            }
            \App\Http\Models\Menus::where('parent', $id)->delete();
            echo $id;
            //resize image
            $mns = \App\Http\Models\Menus::where('id', $id)->get()[0];
            if ($mns->parent == '0') {
                $image_file = $mns->image;
                $destinationPath = public_path('assets/images/products');
                $filename = $destinationPath . "/" . $image_file;
                if ($image_file != '' && file_exists($filename)) {
                    $arr = explode('.', $image_file);
                    $ext = end($arr);
                    $newName = $id . '.' . $ext;
                    if (!file_exists(public_path('assets/images/restaurants/' . $mns->restaurant_id . '/menus/' . $id))) {
                        mkdir('assets/images/restaurants/' . $mns->restaurant_id . '/menus/' . $id, 0777, true);
                    }
                    copy($filename, public_path('assets/images/restaurants/' . $mns->restaurant_id . '/menus/' . $id . '/' . $newName));
                    unlink($filename);
                    $sizes = ['assets/images/restaurants/' . $mns->restaurant_id . '/menus/' . $id . '/thumb_' => '150x145', 'assets/images/restaurants/' . $mns->restaurant_id . '/menus/' . $id . '/thumb1_' => '362x181', 'assets/images/restaurants/' . $mns->restaurant_id . '/menus/' . $id . '/thumb2_' => '40x35'];
                    $filename = public_path('assets/images/restaurants/' . $mns->restaurant_id . '/menus/' . $id . '/' . $newName);
                    copyimages($sizes, $filename, $newName);
                    $men = new \App\Http\Models\Menus();
                    $men->where('id', $id)->update(['image' => $newName]);
                }
            }
            die();
        } else {
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
                $image_file = $mns->image;
                $destinationPath = public_path('assets/images/products');
                $filename = $destinationPath . "/" . $image_file;
                if ($image_file != '' && file_exists($filename)) {
                    $arr = explode('.', $image_file);
                    $ext = end($arr);
                    $newName = $id . '.' . $ext;

                    if (!file_exists(public_path('assets/images/restaurants/' . $mns->restaurant_id . '/menus/' . $id))) {
                        mkdir('assets/images/restaurants/' . $mns->restaurant_id . '/menus/' . $id, 0777, true);
                    }

                    copy($filename, public_path('assets/images/restaurants/' . $mns->restaurant_id . '/menus/' . $id . '/' . $newName));
                    unlink($filename);
                    $sizes = ['assets/images/restaurants/' . $mns->restaurant_id . '/menus/' . $id . '/thumb_' => '150x145', 'assets/images/restaurants/' . $mns->restaurant_id . '/menus/' . $id . '/thumb1_' => '362x181', 'assets/images/restaurants/' . $mns->restaurant_id . '/menus/' . $id . '/thumb2_' => '40x35'];
                    $filename = public_path('assets/images/restaurants/' . $mns->restaurant_id . '/menus/' . $id . '/' . $newName);
                    copyimages($sizes, $filename, $newName);
                    $men = new \App\Http\Models\Menus();
                    $men->where('id', $id)->update(['image' => $newName]);
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
            /*$dir = public_path('assets/images/restaurants/'.$c->restaurant_id."/menus/".$c->id);
            $this->deleteDir($dir);*/
            \App\Http\Models\Menus::where('parent', $c->id)->delete();
        }
        \App\Http\Models\Menus::where('parent', $id)->delete();
        $dir = public_path('assets/images/restaurants/' . $res_id . "/menus/" . $id);
        $this->deleteDir($dir);
        \Session::flash('message', 'Item deleted successfully');
        \Session::flash('message-type', 'alert-success');
        \Session::flash('message-short', 'Congratulations!');
        if (!$slug) {
            return \Redirect::to('restaurant/menus-manager');
        }else {
            return \Redirect::to('restaurants/' . $slug . '/menus');
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
            $data['states_list'] = \App\Http\Models\States::get();//load provinces/states
            return view('dashboard.restaurant.orders_detail', $data);
        }
    }

    //quick redirect to a restaurant's page
    public function red($path) {
        return \Redirect::to('restaurant/' . $path)->with('message', 'Restaurant menu successfully updated');
    }

    //quick redirect to a restaurant's page using it's slug, and it's subpage ($path2)
    public function redfront($path, $slug, $path2) {
        return \Redirect::to($path . '/' . $slug . '/' . $path2)->with('message', 'Restaurant menu successfully updated');
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
}
