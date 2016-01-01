<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Models\Profiles;
use App\Http\Models\Restaurants;

class ProfileAddressesController extends Controller {

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
     * adds an address to a profile, or edits an existing one
     * @param null
     * @return view
     */
    public function index() {
        $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {//check for missing data
            if (!isset($post['address']) || empty($post['address'])) {
                return $this->failure( "[Street address] field is missing!",'user/addresses');
            }
            if (!isset($post['city']) || empty($post['city'])) {
                return $this->failure("[City] field is missing!",'user/addresses');
            }
            if (!isset($post['province']) || empty($post['province'])) {
                \Session::flash('message', "[Province] field is missing!");
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('user/addresses');
            }
            if (!isset($post['country']) || empty($post['country'])) {
                return $this->failure( "[Country] field is missing!",'user/addresses');
            }
            try {
                $post['user_id'] = \Session::get('session_id');
                $idd = (isset($post['id'])) ? $post['id'] : 0;
                // Create/Edit if idd is zero then it create ortherwise it updates.
                $ob = \App\Http\Models\ProfilesAddresses::findOrNew($idd);
                $ob->populate($post);
                $ob->save();

                return $this->success("Address created successfully",'user/addresses');
            } catch(\Exception $e) {
                return $this->failure( $e->getMessage(),'user/addresses');
            }
        } else {
            $data['title'] = "Addresses Manage";
            $data['countries_list'] = \App\Http\Models\Countries::get();
            $data['states_list'] = \App\Http\Models\States::get();
            return view('dashboard.profiles_address.index', $data);
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
        
        $Query = \App\Http\Models\ProfilesAddresses::listing($data, "list")->get();
        $recCount = \App\Http\Models\ProfilesAddresses::listing($data)->count();
        $no_of_paginations = ceil($recCount / $per_page);
        
        $data['Query'] = $Query;
        $data['recCount'] = $recCount;
        $data['Pagination'] = getPagination($recCount, $no_of_paginations, $cur_page, TRUE, TRUE, TRUE, TRUE);
        
        \Session::flash('message', \Input::get('message'));
        return view('dashboard.profiles_address.ajax.list', $data);
    }
    
    /**
     * Addresses Sequence Change
     * @param none
     * @return response
     */
    public function addressesSequence() {
        $this->saveSequence('\App\Http\Models\ProfilesAddresses');
    }
    
    /**
     * Address
     * @param $id
     * @returns a view, or a JSON object
     */
    public function addressesFind($id = 0) {
        try {
            //load a specific address id
            $data['addresse_detail'] = \App\Http\Models\ProfilesAddresses::find($id);
            ob_start();
            return view('dashboard.profiles_address.ajax.edit', $data);
            ob_get_contents();//code will never run
            ob_get_flush();
        } catch(\Exception $e) {
            echo json_encode(array('type' => 'error', 'message' => $e->getMessage()));
            die;
        }
    }
    
    /**
     * Delete profile Address $id
     * @param $id
     * @return redirect
     */
    public function addressesDelete($id = 0) {
        if (!isset($id) || empty($id) || $id == 0) {//check for missing data
            return $this->failure("[Id] is missing!", 'user/addresses');
        }
        try {
            $ob = \App\Http\Models\ProfilesAddresses::find($id);
            $ob->delete();
            return $this->success("Address has been deleted successfully!", 'user/addresses');
        } catch(\Exception $e) {
            return $this->failure(handleexception($e),'user/addresses');
        }
    }

}
