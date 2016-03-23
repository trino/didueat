<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class CreditCardsController extends Controller {

    /**
     * Constructor
     * @param null
     * @return redirect
     */
    public function __construct() {
        date_default_timezone_set('America/Toronto');
    }

    /**
     * index Add/edit/list
     * @param null
     * @return view
     */
    public function index($type = '') {
        $post = \Input::all();
        //check for missing data
        if (isset($post) && count($post) > 0 && !is_null($post)) {
            foreach(array('first_name' => "First Name", 'last_name' => "Last Name", 'card_number' => 'Card Number', 'ccv' => "CCV", 'expiry_month' => 'Expiry Month', 'expiry_year' => "Expiry Year") as $field => $text){
                if (!isset($post[$field]) || empty($post[$field])) {//check for missing data
                    return $this->failure('[' . $text . '] field is missing','credit-cards/list/'.$type, true);
                }
            }
            
            \DB::beginTransaction();
            try {//save credit card info
                if(isset($post['user_type']) && !empty($post['user_type'])){
                    if($post['user_type'] == "restaurant" && isset($post['select_restaurant_id'])){
                        $post['user_id'] = $post['select_restaurant_id'];//if it's a restaurant, use the restaurant id instead of the user id
                    }
                    if($post['user_type'] == "user" && isset($post['select_user_id'])){
                        $post['user_id'] = $post['select_user_id'];//if it's a user, use the user id
                    }
                } else {
                    $post['user_type'] = \Session::get('session_type_user');
                    $post['user_id'] = \Session::get('session_id');
                }
                
                $creditcard = \App\Http\Models\CreditCard::findOrNew(isset($post['id'])?$post['id']:0);
                $creditcard->populate(array_filter($post));
                if(!\Session::has('invalid-data')) {//check if populate resulted in invalid data
                    $creditcard->save();
                    \DB::commit();
                    //if($post['user_type'] == "restaurant"){//$this->updatestore($post['user_id']);}
                    return $this->success('Credit card has been saved successfully.', 'credit-cards/list/' . $type);
                } else {
                    \Session::forget('invalid-data');//forget invalid data and just show the error message
                    return $this->failure('The credit card number was not valid', 'credit-cards/list/'.$type, true);
                }
            } catch (\Exception $e) {
                \DB::rollback();
                return $this->failure(handleexception($e), 'credit-cards/list/'.$type, true);
            }
        } else {
            //get list of credit cards
            $data['title'] = 'Credit Cards List';
            $data['type'] = $type;
            $data['users_list'] = \App\Http\Models\Profiles::orderBy('id', 'DESC')->get();
            $data['restaurants_list'] = \App\Http\Models\Restaurants::orderBy('name', 'ASC')->get();
            return view('dashboard.credit_cards.index', $data);
        }
    }
    
    /**
     * Listing Ajax
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
            'meta' => (\Input::get('meta')) ? \Input::get('meta') : 'order',
            'order' => (\Input::get('order')) ? \Input::get('order') : 'ASC',
            'searchResults' => \Input::get('searchResults')
        );
        if($type == "user"){
            $data["user_id"] = read("id");
        }

        $Query = \App\Http\Models\CreditCard::listing($data, "list", $recCount)->get();
        $no_of_paginations = ceil($recCount / $per_page);

        $data['Query'] = $Query;
        $data['recCount'] = $recCount;
        $data['Pagination'] = getPagination($recCount, $no_of_paginations, $cur_page, TRUE, TRUE, TRUE, TRUE);
        $data["_GET"] = $_GET;

        \Session::flash('message', \Input::get('message'));
        return view('dashboard.credit_cards.ajax.list', $data);
    }


    /**
     * Credit Card Action Delete
     * @param $id
     * @return redirect
     */
    public function creditCardsAction($id = 0, $type = "") {
        if (!isset($id) || empty($id) || $id == 0) {//check for missing data
            return $this->failure( "[card Id] is missing!",'credit-cards/list/'.$type);
        }
        try {//delete credit card by $id
            $ob = \App\Http\Models\CreditCard::find($id);
            $restaurant=0;
            if($ob->user_type == "restaurant" ){
                $restaurant = $ob->user_id;
            }
            $ob->delete();
            $this->updatestore($restaurant);
            event(new \App\Events\AppEvents($ob, "Card Delete"));
            return $this->success('Card has been deleted successfully!', 'credit-cards/list/'.$type);
        } catch (\Exception $e) {
            return $this->failure(handleexception($e), 'credit-cards/list/'.$type);
        }
    }

    /**
     * Edit Credit Card Form
     * @param $id
     * @return view
     */
    public function creditCardFind($id=0, $type="restaurant") {
        try {
            $data['credit_cards_list'] = \App\Http\Models\CreditCard::find($id);
            if($type == "admin"){
                $data['users_list'] = \App\Http\Models\Profiles::orderBy('id', 'DESC')->get();
                $data['restaurants_list'] = \App\Http\Models\Restaurants::orderBy('name', 'ASC')->get();
            } else {
                $data['users_list'] =  \App\Http\Models\Profiles::where(array("id" => read("id")))->get();
                $data['restaurants_list'] = \App\Http\Models\Restaurants::where(array("id" => read("restaurant_id")))->get();
                $data["user_id"] = read(iif($type=="restaurant", "restaurant_id", "id"));
            }
            $data["type"] = $type;
            ob_start();
            return view('common.edit_credit_card', $data);
            ob_get_contents();//code will never run
            ob_get_flush();
        } catch(\Exception $e) {
            echo json_encode(array('type' => 'error', 'message' => handleexception($e)));
            die;
        }
    }

    //when a credit card was required, this would keep the store status updated when you add/delete cards. No longer used
    public function updatestore($ID=0){
        if($ID && false){
            $Cards = \App\Http\Models\CreditCard::where(array("user_type" => "restaurant", 'user_id' => $ID))->count();
            if($Cards){$Cards=1;}
            edit_database("restaurants", "id", $ID, array("has_creditcard" => $Cards));
        }
    }
    
    /**
     * Credit Card Sequence Change
     * @param none
     * @return response
     */
    public function creditCardsSequence() {
        $this->saveSequence('\App\Http\Models\CreditCard');
    }

    //pay with stripe.
    //return app('App\Http\Controllers\CreditCardsController')->stripepayment();
    public function stripepayment($OrderID = false, $StripeToken = false, $description = false, $amount = false, $currency = "cad"){
        if(!$OrderID && !$StripeToken && !$description && !$amount){
            $post = \Input::all();
            
            if (isset($post) && count($post) > 0 && !is_null($post)) {
                $OrderID = $post['orderID'];
                $StripeToken = $post['stripeToken'];
                $description = $post['description'];
                $amount = $post['chargeamt'];
                $currency = $post['currencyType'];
            }
        }
        if($OrderID && $StripeToken && $amount) {
            if(strpos($amount, ".")){$amount = $amount * 100;}//remove the period, make it in cents

            // Set secret key: remember to change this to live secret key in production
            \Stripe\Stripe::setApiKey("BJi8zV1i3D90vmaaBoLKywL84HlstXEg");
         //   \Stripe\Stripe::setApiKey("sk_test_dKNzYR8GIs6VN9UVzupvOgUX");

            // Create the charge on Stripe's servers - this will charge the user's card
            try {
                $charge = \Stripe\Charge::create(array(
                    "amount" => $amount,
                    "currency" => $currency,
                    "source" => $StripeToken,
                    "description" => $description
                ));
            } catch (\Stripe\Error\Card $e) {
                return false;// The card has been declined
            }
            
            if (isset($charge)) {
                //die($StripeToken."::".$OrderID);
                // if credit card payment test, save data to users table
                $stripeConf['orderID'] = $OrderID;
                $stripeConf['stripeToken'] = $StripeToken;
               // $stripeConf['status'] = 'approved';
                $stripeConf['user_id'] = \Session::get('session_id');
                edit_database("reservations", "id", $OrderID, array("paid" => 1, "stripeToken" => $StripeToken));
                
                $stripeOb = \App\Http\Models\StripeConfirm::findOrNew($stripeConf['orderID']);
                $stripeOb->populate($stripeConf);
                $stripeOb->save();
                $Order = select_field("reservations", "id", $OrderID);
                app('App\Http\Controllers\OrdersController')->notifystore($Order->restaurant_id, "Payment of $" . $Order->g_total . " recieved for order: " . $Order->id . " (" . $Order->guid . ")");
                return true;
            }
        }
        return false;
    }
}
