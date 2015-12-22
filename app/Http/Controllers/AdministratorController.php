<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

/**
 * Administrator
 * @package    Laravel 5.1.11
 * @subpackage Controller
 * @author     Skp Software Technologies
 * @developer  Waqar Javed
 * @date       15 September, 2015
 */
class AdministratorController extends Controller {

    /**
     * Constructor
     * @param null
     * @return redirect
     */
    public function __construct() {
        $this->beforeFilter(function () {
            /*if (!\Session::has('is_logged_in')) {
                \Session::flash('message', trans('messages.user_session_exp.message'));
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('/restaurants');
                return \Redirect::to('auth/login');
            } */
            initialize("admin");
        });
    }

    /**
     * Dashboard
     * @param null
     * @return view
     */
    public function dashboard() {
        $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {
            if (!isset($post['name']) || empty($post['name'])) {
                $this->oops("[Name] field is missing!",'dashboard');
            }
            if (!isset($post['email']) || empty($post['email'])) {
                $this->oops( "[Email] field is missing!",'dashboard');
            }

            try {
                $ob = \App\Http\Models\Profiles::find(\Session::get('session_id'));

                if (isset($post['old_password']) && !empty($post['old_password'])) {
                    $password = \Input::get('old_password');
                    if (!\Hash::check($password, $ob->password)) {
                        $this->oops("[Old Password] is incorrect!",'dashboard');
                    }
                    if (empty($post['password'])) {
                        $this->oops( "[New Password] is missing!",'dashboard');
                    }
                    if (empty($post['confirm_password'])) {
                        $this->oops("[Confirm Password] is missing!",'dashboard');
                    }
                    if ($post['password'] != $post['confirm_password']) {
                        $this->oops("[Passwords] are mis-matched!",'dashboard');
                    }
                    $data['password'] = $post['confirm_password'];
                }
                if(!isset($post['subscribed'])){
                    $data['subscribed'] = 0;
                } else {
                    $data['subscribed'] = 1;
                }
                $data['email'] = $post['email'];
                $data['name'] = $post['name'];
                $data['phone_no'] = $post['phone_no'];
                $data['mobile'] = $post['mobile'];
                $data['status'] = $post['status'];
                $data['photo'] = $post['photo'];
                
                $ob->populate($data);
                $ob->save();
                
                event(new \App\Events\AppEvents($ob, "Profile Updated"));

                if(isset($post['phone_no']) && !empty($post['phone_no'])){
                    $post['user_id'] = $ob->id;
                    $add = \App\Http\Models\ProfilesAddresses::findOrNew($post['adid']);
                    $add->populate(array_filter($post));
                    $add->save();
                }

                login($ob);
                $this->success("Profile updated successfully", 'dashboard');
            } catch (\Exception $e) {
                $this->oops($e->getMessage(), 'dashboard');
            }
        } else {
            $data['title'] = 'Dashboard';
            $data['user_detail'] = \App\Http\Models\Profiles::find(\Session::get('session_id'));
            $data['address_detail'] = \App\Http\Models\ProfilesAddresses::where('user_id', $data['user_detail']->id)->orderBy('id', 'DESC')->first();
            return view('dashboard.administrator.dashboard', $data);
        }
    }

    /**
     * Users Action
     * @param $type
     * @param $id
     * @return redirect
     */
    public function usersAction($type = '', $id = 0) {
        if (!isset($type) || empty($type)) {
            $this->oops("[Type] is missing!", 'restaurant/users');
        }
        if (!isset($id) || empty($id) || $id == 0) {
            $this->oops("[Order Id] is missing!", 'restaurant/users');
        }

        try {
            $ob = \App\Http\Models\Profiles::find($id);
            if ($type == "user_fire") {
                $ob->delete();
            } else {
                $ob->populate(array('profile_type' => 1));
                $ob->save();
            }
            event(new \App\Events\AppEvents($ob, "User Status Changed"));
            $this->success('Status has been changed successfully!', 'Congratulations!');
            return \Redirect::to('restaurant/users');
        } catch (\Exception $e) {
            $this->oops( $e->getMessage(), 'restaurant/users');
        }
    }

    /**
     * Users List
     * @param null
     * @return view
     */
    public function users() {
        $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {
            if (!isset($post['name']) || empty($post['name'])) {
                $this->oops('[Name] field is missing','restaurant/users', true);
            }
            if (!isset($post['email']) || empty($post['email'])) {
                $this->oops(trans('messages.user_missing_email.message'),'restaurant/users', true);
            }
            $is_email = \App\Http\Models\Profiles::where('email', '=', $post['email'])->count();
            if ($is_email > 0) {
                $this->oops( trans('messages.user_email_already_exist.message'),'restaurant/users', true);
            }
            if (!isset($post['password']) || empty($post['password'])) {
                $this->oops( trans('messages.user_pass_field_missing.message'),'restaurant/users', true);
            }
            if (!isset($post['confirm_password']) || empty($post['confirm_password'])) {
                $this->oops(trans('messages.user_confim_pass_field_missing.message'),'restaurant/users', true);
            }
            if ($post['password'] != $post['confirm_password']) {
                $this->oops(trans('messages.user_passwords_mismatched.message'),'restaurant/users', true);
            }

            \DB::beginTransaction();
            try {
                $post['status'] = 1;
                $post['is_email_varified'] = 0;
                $post['profile_type'] = 2;
                $post['subscribed'] = (isset($post['subscribed']))?$post['subscribed']:0;
                $post['created_by'] = \Session::get('session_id');

                $browser_info = getBrowser();
                $post['ip_address'] = get_client_ip_server();
                $post['browser_name'] = $browser_info['name'];
                $post['browser_version'] = $browser_info['version'];
                $post['browser_platform'] = $browser_info['platform'];

                $user = new \App\Http\Models\Profiles();
                $user->populate(array_filter($post));
                $user->save();
                event(new \App\Events\AppEvents($user, "User created"));
                
                if(isset($user->id)){
                    $add = new \App\Http\Models\ProfilesAddresses();
                    $post['user_id'] = $user->id;
                    $add->populate(array_filter($post));
                    $add->save();

                    $userArray = $user->toArray();
                    $userArray['mail_subject'] = 'Thank you for registration.';
                    $this->sendEMail("emails.registration_welcome", $userArray);
                    \DB::commit();
                }

                $this->success('User has been added successfully. A confirmation email has been sent to the selected email address for verification.', 'restaurant/users', true);
            } catch (\Illuminate\Database\QueryException $e) {
                \DB::rollback();
                $this->oops(trans('messages.user_email_already_exist.message'), 'restaurant/users', true);
            } catch (\Exception $e) {
                \DB::rollback();
                $this->oops( $e->getMessage(), 'restaurant/users', true);
            }
        } else {
            $data['title'] = 'Users List';
            $data['users_list'] = \App\Http\Models\Profiles::orderBy('id', 'DESC')->get();
            $data['states_list'] = \App\Http\Models\States::get();
            $data['restaurants_list'] = \App\Http\Models\Restaurants::where('open', 1)->orderBy('id', 'DESC')->get();
            return view('dashboard.administrator.users', $data);
        }
    }

/**
     * CreditCards Add new
     * @param null
     * @return view
     */
    public function addCreditCards($type = '') {
        $post = \Input::all();
        \Session::get('session_id');

        if (isset($post) && count($post) > 0 && !is_null($post)) {
            if (!isset($post['profile_id']) || empty($post['profile_id'])) {
                $this->oops('[User Type] field is missing','users/credit-cards/'.$type, true);
            }
            if (!isset($post['first_name']) || empty($post['first_name'])) {
                $this->oops('[Name] field is missing','users/credit-cards/'.$type, true);
            }
            if (!isset($post['last_name']) || empty($post['last_name'])) {
                $this->oops(trans('messages.user_missing_email.message'),'users/credit-cards/'.$type, true);
            }
            if (!isset($post['card_type']) || empty($post['card_type'])) {
                $this->oops(trans('messages.user_missing_email.message'),'users/credit-cards/'.$type, true);
            }
            if (!isset($post['card_number']) || empty($post['card_number'])) {
                $this->oops(trans('messages.user_missing_email.message'),'users/credit-cards/'.$type, true);
            }
            if (!isset($post['ccv']) || empty($post['ccv'])) {
                $this->oops( trans('messages.user_missing_email.message'),'users/credit-cards/'.$type, true);
            }
            if (!isset($post['expiry_date']) || empty($post['expiry_date'])) {
                $this->oops(trans('messages.user_missing_email.message'),'users/credit-cards/'.$type, true);
            }
            if (!isset($post['expiry_month']) || empty($post['expiry_month'])) {
                $this->oops(trans('messages.user_missing_email.message'), 'users/credit-cards/'.$type, true);
            }
            if (!isset($post['expiry_year']) || empty($post['expiry_year'])) {
                $this->oops(trans('messages.user_missing_email.message'),'users/credit-cards/'.$type, true);
            }
            
            \DB::beginTransaction();
            try {
                $creditcard = \App\Http\Models\CreditCard::findOrNew(isset($post['id'])?$post['id']:0);
                $creditcard->populate(array_filter($post));
                $creditcard->save();
                \DB::commit();
                $this->success( 'Credit card has been saved successfully.', 'users/credit-cards/'.$type);
            } catch (\Exception $e) {
                \DB::rollback();
                $this->oops($e->getMessage(), 'users/credit-cards', true);
            }
        } else {
            
            $data['title'] = 'Credit Cards List';
            $data['type'] = $type;
            if ($type == 'user') {
                $data['credit_cards_list'] = \App\Http\Models\CreditCard::where('profile_id', \Session::get('session_id'))->where('user_type', $type)->orderBy('order', 'ASC')->get();
            } else if ($type == 'restaurant') {
                $data['credit_cards_list'] = \App\Http\Models\CreditCard::where('profile_id', \Session::get('session_restaurant_id'))->where('user_type', $type)->orderBy('order', 'ASC')->get();
            } else {
                $data['credit_cards_list'] = \App\Http\Models\CreditCard::orderBy('order', 'ASC')->get();
            }
            $data['users_list'] = \App\Http\Models\Profiles::orderBy('id', 'DESC')->get();
            $data['restaurants_list'] = \App\Http\Models\Restaurants::orderBy('id', 'DESC')->get();
            return view('dashboard.administrator.creditcards', $data);
        }
    }


    /**
     * Credit Card Action Delete
     * @param $id
     * @return redirect
     */
    public function creditCardsAction($id = 0, $type = "") {
        if (!isset($id) || empty($id) || $id == 0) {
            $this->oops( "[card Id] is missing!",'users/credit-cards/'.$type);
        }
        try {
            $ob = \App\Http\Models\CreditCard::find($id);
            $ob->delete();
            event(new \App\Events\AppEvents($ob, "Card Delete"));
            $this->success('Card has been deleted successfully!', 'users/credit-cards/'.$type);
        } catch (\Exception $e) {
            $this->oops($e->getMessage(), 'users/credit-cards/'.$type);
        }
    }

    /**
     * Credit Card Sequance Change
     * @param none
     * @return response
     */
    public function saveCreditCardsSequance() {
        $post = \Input::all();
        try {
            $idArray = explode("|", $post['id']);
            $orderArray = explode("|", $post['order']);

            foreach ($idArray as $key => $value) {
                $id = $value;
                $order = $orderArray[$key];
                //echo $id.'=>'.$order.'<br>';
                $ob = \App\Http\Models\CreditCard::find($id);
                $ob->populate(array('order'=>$order));
                $ob->save();
            }
            
        } catch (\Exception $e) {
            echo $e->getMessage();
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
     * Edit User Form
     * @param $id
     * @return view
     */
    public function ajaxEditUserForm($id=0) {
        $data['user_detail'] = \App\Http\Models\Profiles::find($id);
        $data['address_detail'] = \App\Http\Models\ProfilesAddresses::where('user_id', $data['user_detail']->id)->orderBy('id', 'DESC')->first();
        $data['restaurants_list'] = \App\Http\Models\Restaurants::where('open', 1)->orderBy('id', 'DESC')->get();
        $data['states_list'] = \App\Http\Models\States::get();
        //echo '<pre>'; print_r($data['address_detail']); die;
        return view('common.edituser', $data);
    }


    /**
     * Users List
     * @param null
     * @return view
     */
    public function userUpdate() {
        $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {
            if (!isset($post['id']) || empty($post['id'])) {
                $this->oops('[ID] field is missing', 'restaurant/users', true);
            }
            if (!isset($post['name']) || empty($post['name'])) {
                $this->oops('[Name] field is missing','restaurant/users', true);
            }
            if (!isset($post['email']) || empty($post['email'])) {
                $this->oops(trans('messages.user_missing_email.message'),'restaurant/users', true);
            }
            $is_email = \App\Http\Models\Profiles::where('email', '=', $post['email'])->where('id', '!=', $post['id'])->count();
            if ($is_email > 0) {
                $this->oops(trans('messages.user_email_already_exist.message'),'restaurant/users', true);
            }
            if (!isset($post['password']) || empty($post['password'])) {
                $this->oops( trans('messages.user_pass_field_missing.message'),'restaurant/users', true);
            }
            if (!isset($post['confirm_password']) || empty($post['confirm_password'])) {
                $this->oops(trans('messages.user_confim_pass_field_missing.message'),'restaurant/users', true);
            }
            if ($post['password'] != $post['confirm_password']) {
                $this->oops(trans('messages.user_passwords_mismatched.message'),'restaurant/users', true);
            }

            \DB::beginTransaction();
            try {
                $browser_info = getBrowser();
                $post['ip_address'] = get_client_ip_server();
                $post['browser_name'] = $browser_info['name'];
                $post['browser_version'] = $browser_info['version'];
                $post['browser_platform'] = $browser_info['platform'];

                $user = \App\Http\Models\Profiles::find($post['id']);
                $user->populate(array_filter($post));
                $user->save();
                
                event(new \App\Events\AppEvents($user, "User updated"));

                if(isset($post['adid']) && !empty($post['adid'])){
                    $add = \App\Http\Models\ProfilesAddresses::find($post['adid']);
                    $add->populate(array_filter($post));
                    $add->save();

                    \DB::commit();
                }

                $this->success( 'User has been updated successfully.', 'restaurant/users', true);
            } catch (\Illuminate\Database\QueryException $e) {
                \DB::rollback();
                $this->oops( trans('messages.user_email_already_exist.message'), 'restaurant/users', true);
            } catch (\Exception $e) {
                \DB::rollback();
                $this->oops($e->getMessage(),'restaurant/users', true);
            }
        } else {
            $this->oops( "Invalid parsed data!",'restaurant/users', true);
        }
    }

    /**
     * Newsletter Setting
     * @param null
     * @return view
     */
    public function newsletter() {
        $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {
            if (!isset($post['subject']) || empty($post['subject'])) {
                $this->oops("[Subject] field is missing!",'restaurant/newsletter');
            }
            if (!isset($post['message']) || empty($post['message'])) {
                $this->oops("[Message] field is missing!", 'restaurant/newsletter');
            }
            try {
                $ob = \App\Http\Models\Newsletter::get();
                foreach ($ob as $value) {
                    $ob_user = \App\Http\Models\Profiles::where('email', $value->email)->where('status', 1)->first();
                    if (isset($ob_user) && count($ob_user) > 0 && !is_null($ob_user)) {
                        $array = $ob_user->toArray();
                        $array['mail_subject'] = $post['subject'];
                        $array['message'] = $post['message'];

                        $this->sendEMail("emails.newsletter", $array);
                    }
                }

                $this->success( "Newsletter sent successfully",'restaurant/newsletter');
            } catch (\Exception $e) {
                $this->oops($e->getMessage(),'restaurant/newsletter');
            }
        } else {
            $data['title'] = 'Newsletter Send';
            return view('dashboard.administrator.newsletter', $data);
        }
    }

    /**
     * Subscribers List
     * @param null
     * @return view
     */
    public function subscribers() {
        $data['title'] = 'Subscribers List';
        $data['list'] = \App\Http\Models\Newsletter::get();
        return view('dashboard.administrator.subscribers', $data);
    }


}
