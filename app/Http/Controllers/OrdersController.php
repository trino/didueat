<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Models\Profiles;
use App\Http\Models\Restaurants;

class OrdersController extends Controller {

    /**
     * Constructor
     * @param null
     * @return redirect
     */
    public function __construct() {
        date_default_timezone_set('America/Toronto');
        if(\Session::has('message')){
            \Session::forget('message');
        }
    }

    /**
     * Orders List
     * @param $type
     * @return view
     */
    public function index($type = '') {
        $data['title'] = 'Orders';
        $data['type'] = $type;
        
        return view('dashboard.orders.index', $data);
    }
    
    /**
     * Ajax Listing Ajax
     * @return Response
     */
    public function listingAjax($type = '') {
        $per_page = \Input::get('showEntries');
        $page = \Input::get('page');
        $cur_page = $page;
        $page -= 1;
        $start = $page * $per_page;

        $data = array(
            'type' => $type,
            'page' => $page,
            'cur_page' => $cur_page,
            'per_page' => $per_page,
            'start' => $start,
            'meta' => (\Input::get('meta')) ? \Input::get('meta') : 'order_time',
            'order' => (\Input::get('order')) ? \Input::get('order') : 'DESC',
            'searchResults' => \Input::get('searchResults')
        );
        
        $Query = \App\Http\Models\Reservations::listing($data, "list")->get();
        $recCount = \App\Http\Models\Reservations::listing($data)->count();
        $no_of_paginations = ceil($recCount / $per_page);
        
        $data['Query'] = $Query;
        $data['recCount'] = $recCount;
        $data['Pagination'] = getPagination($recCount, $no_of_paginations, $cur_page, TRUE, TRUE, TRUE, TRUE);
        
        \Session::flash('message', \Input::get('message'));
        return view('dashboard.orders.ajax.list', $data);
    }

    /**
     * Orders Detail
     * @param $id
     * @return view
     */
    public function order_detail($ID) {
        $data['order'] = \App\Http\Models\Reservations::select('reservations.*')->where('reservations.id', $ID)->leftJoin('restaurants', 'reservations.restaurant_id', '=', 'restaurants.id')->first();
        if(is_null($data['order']['restaurant_id'])) {//check for a valid restaurant $ID
            return back()->with('status', 'Restaurant Not Found!');
        } else {
            $data['title'] = 'Orders Detail';
            $data['restaurant'] = \App\Http\Models\Restaurants::find($data['order']->restaurant_id);//load the restaurant the order was placed for
            $data['user_detail'] = \App\Http\Models\Profiles::find($data['order']->user_id);//load user that placed the order
            $data['states_list'] = \App\Http\Models\States::get();//load provinces/states
            return view('dashboard.orders.orders_detail', $data);
        }
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
    public function changeOrderCancel($type="") {
        return $this->changeOrderStatus('cancelled', 'Your order has been cancelled.', "emails.order_cancel", 'Order has been cancelled successfully!', "orders/list/".$type);
    }
    
    /**
     * Change Order Status to Approved
     * @param $id
     * @return redirect
     */
    public function changeOrderApprove($type="") {
        return $this->changeOrderStatus('approved', 'Your order has been approved.', "emails.order_approve", 'Order has been approved successfully!', "orders/list/".$type);
    }
    
    /**
     * Change Order Status to Disapproved
     * @param $id
     * @return redirect
     */
    public function changeOrderDisapprove($type="") {
        return $this->changeOrderStatus('pending', 'Your order has been disapproved.', "emails.order_disapprove", 'Order has been disapproved successfully!', "orders/list/".$type);
    }

    /**
     * Change Order Status to $status, send email (using $subject/$email) and $flash
     * @param $id (POST)
     * statuses can be cancelled, approved or pending
     * @return redirect
     */
    public function changeOrderStatus($status, $subject = "", $email = "", $flash = "", $URL = ""){
        $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {
            if (!isset($post['id']) || empty($post['id'])) {
                return $this->failure("[Order Id] is missing!", $URL);
            }
            if (is_numeric($post['id']) && (!isset($post['note']) || empty($post['note']))) {
                return $this->failure("[Note Field] is missing!", $URL);
            }

            try {
                if(is_numeric($post['id'])) {
                    $ob = \App\Http\Models\Reservations::find($post['id']);
                } else {
                    $ob = \App\Http\Models\Reservations::where('guid', $post['id'])->first();
                    $flash = "Order " . $status . " via email";
                    $post['note'] = $flash;
                }
                $ob->populate(array('status' => $status, 'note' => $post['note'], 'time' => now()));
                $ob->save();

                if ($ob->user_id && $subject && $email) {
                    $userArray = \App\Http\Models\Profiles::find($ob->user_id)->toArray();
                    $userArray['mail_subject'] = $subject;
                    $userArray['note'] = $post['note'];
                    $this->sendEMail($email, $userArray);
                }
                return $this->success($flash, $URL);
            } catch (\Exception $e) {
                return $this->failure(handleexception($e), $URL);
            }
        } else {
            return $this->failure("Invalid request made!", $URL);
        }
    }

    /**
     * Delete Order $id
     * @param $id
     * @return redirect
     */
    public function deleteOrder($type = "", $id = 0) {
        if (!isset($id) || empty($id) || $id == 0) {
            return $this->failure("[Order Id] is missing!", 'orders/list/'.$type);
        }
        try {
            $ob = \App\Http\Models\Reservations::find($id);
            $ob->delete();
            return $this->success('Order has been deleted successfully!', 'orders/list/'.$type);
        } catch (\Exception $e) {
            return $this->failure(handleexception($e), 'orders/list/'.$type);
        }
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

}
