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
            if (!isset($post['first_name']) || empty($post['first_name'])) {
                return $this->failure('[First Name] field is missing','credit-cards/list/'.$type, true);
            }
            if (!isset($post['last_name']) || empty($post['last_name'])) {
                return $this->failure('[Last Name] field is missing','credit-cards/list/'.$type, true);
            }
            if (!isset($post['card_type']) || empty($post['card_type'])) {
                return $this->failure('[Credit Card Type] field is missing','credit-cards/list/'.$type, true);
            }
            if (!isset($post['card_number']) || empty($post['card_number'])) {
                return $this->failure('[Card Number] field is missing','credit-cards/list/'.$type, true);
            }
            if (!isset($post['ccv']) || empty($post['ccv'])) {
                return $this->failure('[CCV] field is missing','credit-cards/list/'.$type, true);
            }
            if (!isset($post['expiry_month']) || empty($post['expiry_month'])) {
                return $this->failure('[Expiry Month] field is missing','credit-cards/list/'.$type, true);
            }
            if (!isset($post['expiry_year']) || empty($post['expiry_year'])) {
                return $this->failure('[Expiry Year] field is missing','credit-cards/list/'.$type, true);
            }
            
            \DB::beginTransaction();
            try {//save credit card info
                if(isset($post['user_type']) && !empty($post['user_type'])){
                    if($post['user_type'] == "restaurant" && isset($post['select_restaurant_id'])){
                        $post['user_id'] = $post['select_restaurant_id'];//for some reason this ends up being the user id
                    }
                    if($post['user_type'] == "user" && isset($post['select_user_id'])){
                        $post['user_id'] = $post['select_user_id'];
                    }
                } else {
                    $post['user_type'] = \Session::get('session_type_user');
                    $post['user_id'] = \Session::get('session_id');
                }
                
                $creditcard = \App\Http\Models\CreditCard::findOrNew(isset($post['id'])?$post['id']:0);
                $creditcard->populate(array_filter($post));
                if(!\Session::has('invalid-data')) {
                    $creditcard->save();
                    \DB::commit();
                    return $this->success('Credit card has been saved successfully.', 'credit-cards/list/' . $type);
                } else {
                    \Session::forget('invalid-data');
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

        $Query = \App\Http\Models\CreditCard::listing($data, "list")->get();
        $recCount = \App\Http\Models\CreditCard::listing($data)->count();
        $no_of_paginations = ceil($recCount / $per_page);

        $data['Query'] = $Query;
        $data['recCount'] = $recCount;
        $data['Pagination'] = getPagination($recCount, $no_of_paginations, $cur_page, TRUE, TRUE, TRUE, TRUE);

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
            $ob->delete();
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
    public function creditCardFind($id=0) {
        try {
            $data['credit_cards_list'] = \App\Http\Models\CreditCard::find($id);
            $data['users_list'] = \App\Http\Models\Profiles::orderBy('id', 'DESC')->get();
            $data['restaurants_list'] = \App\Http\Models\Restaurants::orderBy('name', 'ASC')->get();
            ob_start();
            return view('dashboard.credit_cards.ajax.edit', $data);
            ob_get_contents();//code will never run
            ob_get_flush();
        } catch(\Exception $e) {
            echo json_encode(array('type' => 'error', 'message' => handleexception($e)));
            die;
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


}
