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
    }
    
    /**
     * adds an address to a profile, or edits an existing one
     * @param null
     * @return view
     */ 
    public function index($idd = 0) {  
        $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {//check for missing data
            if ((isset($post['formatted_addressForDB']) && !empty($post['formatted_addressForDB'])) && (!isset($post['formatted_address']) || empty($post['formatted_address']))) {
              $post['formatted_address'] = $post['formatted_addressForDB'];
            }
            if (!isset($post['formatted_address']) || empty($post['formatted_address'])) {
                return $this->failure( "[Street address] field is missing!",'user/addresses');
            }
            if (!isset($post['city']) || empty($post['city'])) {
                return $this->failure("[City] field is missing!",'user/addresses');
            }
            if (!isset($post['province']) || empty($post['province'])) {
                return $this->failure("[Province] field is missing!",'user/addresses');
            }
            if (!isset($post['country']) || empty($post['country'])) {
              //  return $this->failure( "[Country] field is missing!",'user/addresses');
            }
            if (!isset($post['phone']) || empty(phonenumber($post['phone']))) {
                return $this->failure( "[Phone number] field is missing or invalid!",'user/addresses');
            }

            try {
                $post['user_id'] = \Session::get('session_id');
                if(!$idd) {
                    $idd = (isset($post['id'])) ? $post['id'] : 0;
                    $createUpd="created";
                }
                else{
                  $createUpd="updated";
                }

                // Create/Edit if idd is zero then it create otherwise it updates.
                $ob = \App\Http\Models\ProfilesAddresses::findOrNew($idd);
                $ob->populate($post);
                $ob->save();

                return $this->success("Address ".$createUpd." successfully",'user/addresses');
            } catch(\Exception $e) {
                return $this->failure( handleexception($e),'user/addresses');
            }
        } else {
            $data['title'] = "Addresses Manage";
//            $data['countries_list'] = \App\Http\Models\Countries::get();
//            $data['states_list'] = \App\Http\Models\States::get();
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

        $Query = \App\Http\Models\ProfilesAddresses::listing($data, "list", $recCount)->get();
        $no_of_paginations = ceil($recCount / $per_page);
        
        $data['Query'] = $Query;
        $data['recCount'] = $recCount;
        $data['Pagination'] = getPagination($recCount, $no_of_paginations, $cur_page, TRUE, TRUE, TRUE, TRUE);
        $data["_GET"] = $_GET;

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
     * Address search
     * @param $id
     * @returns a view, or a JSON object
     */
    public function addressesFind($id = 0) {
        try {
            //load a specific address id
            $_GET['addresse_detail'] = \App\Http\Models\ProfilesAddresses::find($id);
            $_GET["apartment"] = true;
            $_GET["mini"] = true;
            ob_start();
            return view('common.editaddress', $_GET);
            ob_get_contents();//code will never run
            ob_get_flush();
        } catch(\Exception $e) {
            echo json_encode(array('type' => 'error', 'message' => handleexception($e)));
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
            //return $this->success("Address has been deleted successfully!", 'user/addresses');
        } catch(\Exception $e) {
            return $this->failure(handleexception($e),'user/addresses');
        }
    } 

    //edit an address
    public function addressEdit($id=0){
        $post = \Input::all();
        //var_dump($post); 
        if(!$id || !is_numeric($id)){
            $post["user_id"] = read("id");
            $post["id"] = 0;
            $id = 0;
        }

        $post["id"] = $id;

        if($id || (isset($_POST['addOrEdit']) && $_POST['addOrEdit'] == "edit")){
             $ob = \App\Http\Models\ProfilesAddresses::findOrNew($id);
             $ob->populate($post);
             $ob->save();
             $thismsg="edited";
        } else {
            $add = \App\Http\Models\ProfilesAddresses::makenew($post, $id);
            if(isset($_GET['ajax'])) {
                $address = \App\Http\Models\ProfilesAddresses::find($add->id);
                return json_encode($address);
                die();
            }
           $thismsg="added";
        }

        return $this->success("Your Address has been ".$thismsg." successfully!", 'user/addresses');
    }
}
