<?php

    namespace App\Http\Controllers;

    use App\Http\Controllers\Controller;
    use App\Http\Models\Profiles;
    use App\Http\Models\Restaurants;

    class UserReviewsController extends Controller {

        /**
         * Constructor
         * @param null
         * @return redirect
         */
        public function __construct() {
            date_default_timezone_set('America/Toronto');
        }

        /**
         * edit review $id
         * @param $id
         * @return view
         */
        public function index($id = 0) {
            $post = \Input::all();
            if (isset($post) && count($post) > 0 && !is_null($post)) {
                if (!isset($post['id']) || empty($post['id'])) {//check for missing data
                    return $this->failure('[ID] field is missing', 'user/reviews', true);
                }

                \DB::beginTransaction();
                try {
                    $review = \App\Http\Models\RatingUsers::find($post['id']);
                    $review->populate(array_filter($post));
                    $review->save();
                    \DB::commit();

                    return $this->success('Review has been updated successfully.', 'user/reviews', true);
                } catch (\Illuminate\Database\QueryException $e) {
                    \DB::rollback();
                    return $this->failure(trans('messages.user_email_already_exist.message'), 'restaurant/users', true);
                } catch (\Exception $e) {
                    \DB::rollback();
                    return $this->failure(handleexception($e), 'restaurant/users', true);
                }
            } else {
                $data['title'] = "User Reviews";
                return view('dashboard.user_reviews.index', $data);
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
                'meta' => (\Input::get('meta')) ? \Input::get('meta') : 'id',
                'order' => (\Input::get('order')) ? \Input::get('order') : 'DESC',
                'searchResults' => \Input::get('searchResults')
            );
            $userid = \Input::get('user_id');
            if($userid){
                $data["user_id"] = $userid;
            }
            //  $Query = \App\Http\Models\Profiles::listing($data, "list", $recCount)->get();

            $Query = \App\Http\Models\RatingUsers::listing($data, "list", $recCount)->get();
            $no_of_paginations = ceil($recCount / $per_page);

            $data['Query'] = $Query;
            $data['recCount'] = $recCount;
            $data['Pagination'] = getPagination($recCount, $no_of_paginations, $cur_page, TRUE, TRUE, TRUE, TRUE);
            $data["_GET"] = $_GET;

            \Session::flash('message', \Input::get('message'));
            return view('dashboard.user_reviews.ajax.list', $data);
        }

        /**
         * delete Reviews $id
         * @param $id
         * @return redirect
         */
        public function reviewAction($id = 0){
            $ob = \App\Http\Models\RatingUsers::find($id);
            $ob->delete();
            //return $this->listingAjax();
            //return $this->success('Review has been deleted successfully!', 'user/reviews');
        }

        /**
         * Edit User Review Form
         * @param $id
         * @return view
         */
        public function ajaxEditUserReviewForm($id = 0) {
            $data['user_review_detail'] = \App\Http\Models\RatingUsers::find($id);
            return view('dashboard.user_reviews.ajax.edit', $data);
        }

        /**
         * Edit User Review Form
         * @param $id
         * @return view
         */
        public function ajaxGetReviewUsersList() {
            $post = \Input::all();
            $rating_id = $post['rating_id'];
            $target_id = $post['target_id'];
            $type = $post['type'];
            $data['detail'] = \App\Http\Models\RatingUsers::select('user_id', 'target_id', 'comments', 'created_at', 'rating')->where('rating_id', $rating_id)->where('type', $type)->where('target_id', $target_id)->orderBy('updated_at', 'DESC')->get();
            $data['type'] = $type;
            return view('ajax.reviewed_users', $data);
        }

    }
