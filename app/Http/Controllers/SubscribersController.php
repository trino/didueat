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

            $Query = \App\Http\Models\Newsletter::listing($data, "list", $recCount)->get();
            $no_of_paginations = ceil($recCount / $per_page);

            $data['Query'] = $Query;
            $data['recCount'] = $recCount;
            $data['Pagination'] = getPagination($recCount, $no_of_paginations, $cur_page, TRUE, TRUE, TRUE, TRUE);
            $data["_GET"] = $_GET;

            \Session::flash('message', \Input::get('message'));
            return view('dashboard.subscribers.ajax.list', $data);
        }

        //sends a newslaetter to all subscribers
        public function send() {
            $array['mail_subject'] = \Input::get('subject');
            $array['body'] = \Input::get('newsletter');
            $Emails = \App\Http\Models\Newsletter::select('email')->where('status', 1)->get();
            foreach ($Emails as $Email) {
                $array['email'][] = $Email->email;
            }
            if (isset($array['email']) && $array['mail_subject'] && $array['body']) {
                $this->sendEMail("emails.newsletter", $array);
                return $this->success("Newsletter sent", "subscribers/list");
            } else {
                return $this->failure("No subscribers, or missing subject/contents", "subscribers/list");
            }
        }
    }
