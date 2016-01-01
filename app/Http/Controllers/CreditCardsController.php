<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Models\Profiles;
use App\Http\Models\Restaurants;

class CreditCardsController extends Controller {

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
     * index Add/edit/list
     * @param null
     * @return view
     */
    public function index($type = '') {
        $post = \Input::all();
        \Session::get('session_id');
        //check for missing data
        if (isset($post) && count($post) > 0 && !is_null($post)) {
            if (!isset($post['profile_id']) || empty($post['profile_id'])) {
                return $this->failure('[User Type] field is missing','users/credit-cards/'.$type, true);
            }
            if (!isset($post['first_name']) || empty($post['first_name'])) {
                return $this->failure('[Name] field is missing','users/credit-cards/'.$type, true);
            }
            if (!isset($post['last_name']) || empty($post['last_name'])) {
                return $this->failure(trans('messages.user_missing_email.message'),'users/credit-cards/'.$type, true);
            }
            if (!isset($post['card_type']) || empty($post['card_type'])) {
                return $this->failure(trans('messages.user_missing_email.message'),'users/credit-cards/'.$type, true);
            }
            if (!isset($post['card_number']) || empty($post['card_number'])) {
                return $this->failure(trans('messages.user_missing_email.message'),'users/credit-cards/'.$type, true);
            }
            if (!isset($post['ccv']) || empty($post['ccv'])) {
                return $this->failure( trans('messages.user_missing_email.message'),'users/credit-cards/'.$type, true);
            }
            if (!isset($post['expiry_date']) || empty($post['expiry_date'])) {
                return $this->failure(trans('messages.user_missing_email.message'),'users/credit-cards/'.$type, true);
            }
            if (!isset($post['expiry_month']) || empty($post['expiry_month'])) {
                return $this->failure(trans('messages.user_missing_email.message'), 'users/credit-cards/'.$type, true);
            }
            if (!isset($post['expiry_year']) || empty($post['expiry_year'])) {
                return $this->failure(trans('messages.user_missing_email.message'),'users/credit-cards/'.$type, true);
            }
            
            \DB::beginTransaction();
            try {//save credit card info
                $creditcard = \App\Http\Models\CreditCard::findOrNew(isset($post['id'])?$post['id']:0);
                $creditcard->populate(array_filter($post));
                $creditcard->save();
                \DB::commit();
                return $this->success( 'Credit card has been saved successfully.', 'users/credit-cards/'.$type);
            } catch (\Exception $e) {
                \DB::rollback();
                return $this->failure(handleexception($e), 'users/credit-cards', true);
            }
        } else {
            //get list of credit cards
            $data['title'] = 'Credit Cards List';
            $data['type'] = $type;
            
            $data['users_list'] = \App\Http\Models\Profiles::orderBy('id', 'DESC')->get();
            $data['restaurants_list'] = \App\Http\Models\Restaurants::orderBy('id', 'DESC')->get();
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
            return $this->failure( "[card Id] is missing!",'users/credit-cards/'.$type);
        }
        try {//delete credit card by $id
            $ob = \App\Http\Models\CreditCard::find($id);
            $ob->delete();
            event(new \App\Events\AppEvents($ob, "Card Delete"));
            return $this->success('Card has been deleted successfully!', 'users/credit-cards/'.$type);
        } catch (\Exception $e) {
            return $this->failure(handleexception($e), 'users/credit-cards/'.$type);
        }
    }

    /**
     * Edit Credit Card Form
     * @param $id
     * @return view
     */
    public function ajaxEditCreditCardFrom($id=0) {
        $data['credit_cards_list'] = \App\Http\Models\CreditCard::find($id);
        $data['users_list'] = \App\Http\Models\Profiles::orderBy('id', 'DESC')->get();
        $data['restaurants_list'] = \App\Http\Models\Restaurants::orderBy('id', 'DESC')->get();
        return view('common.edit_credit_card', $data);
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
