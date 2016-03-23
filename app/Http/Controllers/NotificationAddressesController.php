<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Models\Profiles;
use App\Http\Models\Restaurants;

class NotificationAddressesController extends Controller {

    /**
     * Constructor
     * @param null
     * @return redirect
     */
    public function __construct() {
        date_default_timezone_set('America/Toronto');
    }
    
    /**
     * adds an address to a profile, or edits an existing one
     * @param null
     * @return view
     */
    public function index() {
        $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {
            try {
                $post['user_id'] = \Session::get('session_id');
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

                return $this->success("Notification email/number saved successfully!", 'notification/addresses');
            } catch (Exception $e) {
                return $this->failure( handleexception($e), 'notification/addresses');
            }
        } else {
            $data['title'] = 'Notification Email/Number List';
            return view('dashboard.notifications_address.index', $data);
        }
    }
    
    /**
     * Listing Ajax
     * @return Response
     */
    public function listingAjax() {
        $per_page = \Input::get('showEntries');
        $page = \Input::get('page');
        $cur_page = $page;
        $page -= 1;
        $start = $page * $per_page;

        $data = array(
            'page' => $page,
            'cur_page' => $cur_page,
            'per_page' => $per_page,
            'start' => $start,
            'meta' => (\Input::get('meta')) ? \Input::get('meta') : 'order',
            'order' => (\Input::get('order')) ? \Input::get('order') : 'ASC',
            'searchResults' => \Input::get('searchResults')
        );
        
        $Query = \App\Http\Models\NotificationAddresses::listing($data, "list", $recCount)->get();
        $no_of_paginations = ceil($recCount / $per_page);
        
        $data['Query'] = $Query;
        $data['recCount'] = $recCount;
        $data['Pagination'] = getPagination($recCount, $no_of_paginations, $cur_page, TRUE, TRUE, TRUE, TRUE);
        $data["_GET"] = $_GET;
        $data["restaurant"] = select_field("restaurants", "id", read("restaurant_id"));

        \Session::flash('message', \Input::get('message'));
        return view('dashboard.notifications_address.ajax.list', $data);
    }
    
    /**
     * Addresses Sequence Change
     * @param none
     * @return response
     */
    public function addressesSequence() {
        $this->saveSequence('\App\Http\Models\NotificationAddresses');
    }
    
    /**
     * Edit Address Form
     * @param $id
     * @return view
     */
    public function ajaxEditAddressForm( $id=0 ) {
        $data['address_detail'] = \App\Http\Models\NotificationAddresses::find($id);
        return view('dashboard.notifications_address.ajax.edit', $data);
    }
    
    /**
     * Delete a notification Address
     * @param $id of the address to delete
     * @return redirect
     */
    public function deleteAddresses($id = 0) {
        if (!isset($id) || empty($id) || $id == 0) {//check for missing data
            return $this->failure("[Address Id] is missing!", 'notification/addresses');
        }
        try {
            $ob = \App\Http\Models\NotificationAddresses::find($id);
            $ob->delete();
            return $this->success("Address has been deleted successfully!", 'notification/addresses');
        } catch (\Exception $e) {
            return $this->failure( handleexception($e), 'notification/addresses');
        }
    }

    /**
     * sets a Default notification Address, and sets all others to not the default
     * @param $id
     * @return redirect
     */
    public function defaultAddresses($id = 0) {
        if (!isset($id) || empty($id) || $id == 0) {
            return $this->failure("[Address Id] is missing!", 'notification/addresses');
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

            return $this->success("Address has been default successfully!", 'notification/addresses');
        } catch (\Exception $e) {
            return $this->failure(handleexception($e), 'notification/addresses');
        }
    }

}
