<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Models\Profiles;
use App\Http\Models\Restaurants;

class SubscribersController extends Controller {

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
     * Subscribers List
     * @param null
     * @return view
     */
    public function index() {
        $data['title'] = 'Subscribers List';
        return view('dashboard.subscribers.index', $data);
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
            'meta' => (\Input::get('meta')) ? \Input::get('meta') : 'created_at',
            'order' => (\Input::get('order')) ? \Input::get('order') : 'DESC',
            'searchResults' => \Input::get('searchResults')
        );
        
        $Query = \App\Http\Models\Newsletter::listing($data, "list")->get();
        $recCount = \App\Http\Models\Newsletter::listing($data)->count();
        $no_of_paginations = ceil($recCount / $per_page);
        
        $data['Query'] = $Query;
        $data['recCount'] = $recCount;
        $data['Pagination'] = getPagination($recCount, $no_of_paginations, $cur_page, TRUE, TRUE, TRUE, TRUE);
        
        \Session::flash('message', \Input::get('message'));
        return view('dashboard.subscribers.ajax.list', $data);
    }
    

}
