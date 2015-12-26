<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

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
            //check for missing name/email
            if (!isset($post['name']) || empty($post['name'])) {
                return $this->failure("[Name] field is missing!",'dashboard');
            }
            if (!isset($post['email']) || empty($post['email'])) {
                return $this->failure( "[Email] field is missing!",'dashboard');
            }
            try {
                $ob = \App\Http\Models\Profiles::find(\Session::get('session_id'));
                //check old password, and both new passwords
                if (isset($post['old_password']) && !empty($post['old_password'])) {
                    $password = \Input::get('old_password');
                    if (!\Hash::check($password, $ob->password)) {
                        return $this->failure("[Old Password] is incorrect!",'dashboard');
                    }
                    if (empty($post['password'])) {
                        return $this->failure( "[New Password] is missing!",'dashboard');
                    }
                    if (empty($post['confirm_password'])) {
                        return $this->failure("[Confirm Password] is missing!",'dashboard');
                    }
                    if ($post['password'] != $post['confirm_password']) {
                        return $this->failure("[Passwords] are mis-matched!",'dashboard');
                    }
                    $data['password'] = $post['confirm_password'];
                }
                //copy post data to an array
                $data['subscribed'] = 0;
                if(isset($post['subscribed'])){
                    $data['subscribed'] = 1;
                }
                $data['email'] = $post['email'];
                $data['name'] = $post['name'];
                $data['phone_no'] = $post['phone_no'];
                $data['mobile'] = $post['mobile'];
                $data['status'] = $post['status'];
                $data['photo'] = $post['photo'];

                //save the array to the database
                $ob->populate($data);
                $ob->save();
                
                event(new \App\Events\AppEvents($ob, "Profile Updated"));//log event

                if(isset($post['phone_no']) && !empty($post['phone_no'])){
                    $post['user_id'] = $ob->id;
                    $add = \App\Http\Models\ProfilesAddresses::findOrNew($post['adid']);
                    $add->populate(array_filter($post));
                    $add->save();
                }

                login($ob);//log in as this user
                return $this->success("Profile updated successfully", 'dashboard');
            } catch (\Exception $e) {
                return $this->failure(handleexception($e), 'dashboard');
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
        //check for missing type/id
        if (!isset($type) || empty($type)) {
            return $this->failure("[Type] is missing!", 'restaurant/users');
        }
        if (!isset($id) || empty($id) || $id == 0) {
            return $this->failure("[Order Id] is missing!", 'restaurant/users');
        }
        try {
            $ob = \App\Http\Models\Profiles::find($id);//search for user $id
            if ($type == "user_fire") {//fire user by deleting them
                $ob->delete();
            } else {//hire user by changing the profile type to employee
                $ob->populate(array('profile_type' => 1));
                $ob->save();
            }
            event(new \App\Events\AppEvents($ob, "User Status Changed"));//log event
            return $this->success('Status has been changed successfully!', 'Congratulations!');
            return \Redirect::to('restaurant/users');
        } catch (\Exception $e) {
            return $this->failure( $e->getMessage(), 'restaurant/users');
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
            //check for missing data
            if (!isset($post['name']) || empty($post['name'])) {
                return $this->failure('[Name] field is missing','restaurant/users', true);
            }
            if (!isset($post['email']) || empty($post['email'])) {
                return $this->failure(trans('messages.user_missing_email.message'),'restaurant/users', true);
            }
            $is_email = \App\Http\Models\Profiles::where('email', '=', $post['email'])->count();
            if ($is_email > 0) {
                return $this->failure( trans('messages.user_email_already_exist.message'),'restaurant/users', true);
            }
            if (!isset($post['password']) || empty($post['password'])) {
                return $this->failure( trans('messages.user_pass_field_missing.message'),'restaurant/users', true);
            }
            if (!isset($post['confirm_password']) || empty($post['confirm_password'])) {
                return $this->failure(trans('messages.user_confim_pass_field_missing.message'),'restaurant/users', true);
            }
            if ($post['password'] != $post['confirm_password']) {
                return $this->failure(trans('messages.user_passwords_mismatched.message'),'restaurant/users', true);
            }

            \DB::beginTransaction();
            try {//construct profile as an array
                $post['status'] = 1;
                $post['is_email_varified'] = 0;
                $post['profile_type'] = 2;
                $post['subscribed'] = (isset($post['subscribed']))?$post['subscribed']:0;
                $post['created_by'] = \Session::get('session_id');

                $browser_info = getBrowser();//get user's web browser/OS data
                $post['ip_address'] = get_client_ip_server();
                $post['browser_name'] = $browser_info['name'];
                $post['browser_version'] = $browser_info['version'];
                $post['browser_platform'] = $browser_info['platform'];

                $user = new \App\Http\Models\Profiles();
                $user->populate(array_filter($post));
                $user->save();
                event(new \App\Events\AppEvents($user, "User created"));
                
                if(isset($user->id)){//save address
                    $add = new \App\Http\Models\ProfilesAddresses();
                    $post['user_id'] = $user->id;
                    $add->populate(array_filter($post));
                    $add->save();

                    $userArray = $user->toArray();
                    $userArray['mail_subject'] = 'Thank you for registration.';
                    $this->sendEMail("emails.registration_welcome", $userArray);
                    \DB::commit();
                }

                return $this->success('User has been added successfully. A confirmation email has been sent to the selected email address for verification.', 'restaurant/users', true);
            } catch (\Illuminate\Database\QueryException $e) {
                \DB::rollback();
                return $this->failure(trans('messages.user_email_already_exist.message'), 'restaurant/users', true);
            } catch (\Exception $e) {
                \DB::rollback();
                return $this->failure( $e->getMessage(), 'restaurant/users', true);
            }
        } else {//get data to load the page
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
        } else {//get list of credit cards
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
        if (isset($post) && count($post) > 0 && !is_null($post)) {//check for missing or duplicate data
            if (!isset($post['id']) || empty($post['id'])) {
                return $this->failure('[ID] field is missing', 'restaurant/users', true);
            }
            if (!isset($post['name']) || empty($post['name'])) {
                return $this->failure('[Name] field is missing','restaurant/users', true);
            }
            if (!isset($post['email']) || empty($post['email'])) {
                return $this->failure(trans('messages.user_missing_email.message'),'restaurant/users', true);
            }
            $is_email = \App\Http\Models\Profiles::where('email', '=', $post['email'])->where('id', '!=', $post['id'])->count();
            if ($is_email > 0) {
                return $this->failure(trans('messages.user_email_already_exist.message'),'restaurant/users', true);
            }
            if (!isset($post['password']) || empty($post['password'])) {
                return $this->failure( trans('messages.user_pass_field_missing.message'),'restaurant/users', true);
            }
            if (!isset($post['confirm_password']) || empty($post['confirm_password'])) {
                return $this->failure(trans('messages.user_confim_pass_field_missing.message'),'restaurant/users', true);
            }
            if ($post['password'] != $post['confirm_password']) {
                return $this->failure(trans('messages.user_passwords_mismatched.message'),'restaurant/users', true);
            }

            \DB::beginTransaction();
            try {//save user's browser/OS info
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
                return $this->failure( trans('messages.user_email_already_exist.message'), 'restaurant/users', true);
            } catch (\Exception $e) {
                \DB::rollback();
                return $this->failure(handleexception($e),'restaurant/users', true);
            }
        } else {
            return $this->failure( "Invalid parsed data!",'restaurant/users', true);
        }
    }

    /**
     * Newsletter Setting
     * @param null
     * @return view
     */
    public function newsletter() {
        $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {//check for missing data
            if (!isset($post['subject']) || empty($post['subject'])) {
                return $this->failure("[Subject] field is missing!",'restaurant/newsletter');
            }
            if (!isset($post['message']) || empty($post['message'])) {
                return $this->failure("[Message] field is missing!", 'restaurant/newsletter');
            }
            try {//get each user that has subscribed to the newsletter and email them
                //this currently only works for existing users, but should be fixed so it only needs the email address
                $ob = \App\Http\Models\Newsletter::get();
                foreach ($ob as $value) {
                    $ob_user = \App\Http\Models\Profiles::where('email', $value->email)->where('status', 1)->first();//this should not be done
                    if (isset($ob_user) && count($ob_user) > 0 && !is_null($ob_user)) {
                        $array = $ob_user->toArray();
                        $array['mail_subject'] = $post['subject'];
                        $array['message'] = $post['message'];

                        $this->sendEMail("emails.newsletter", $array);
                    }
                }
                return $this->success( "Newsletter sent successfully",'restaurant/newsletter');
            } catch (\Exception $e) {
                return $this->failure(handleexception($e),'restaurant/newsletter');
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
