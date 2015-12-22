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
class AdministratorController extends Controller
{

    /**
     * Constructor
     * @param null
     * @return redirect
     */
    public function __construct()
    {
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
    public function dashboard()
    {
        $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {
            if (!isset($post['name']) || empty($post['name'])) {
                \Session::flash('message', "[Name] field is missing!");
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('dashboard');
            }
            if (!isset($post['email']) || empty($post['email'])) {
                \Session::flash('message', "[Email] field is missing!");
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('dashboard');
            }

            try {
                $ob = \App\Http\Models\Profiles::find(\Session::get('session_id'));

                if (isset($post['old_password']) && !empty($post['old_password'])) {
                    $password = \Input::get('old_password');
                    if (!\Hash::check($password, $ob->password)) {
                        \Session::flash('message', "[Old Password] is incorrect!");
                        \Session::flash('message-type', 'alert-danger');
                        \Session::flash('message-short', 'Oops!');
                        return \Redirect::to('dashboard');
                    }
                    if (empty($post['password'])) {
                        \Session::flash('message', "[New Password] is missing!");
                        \Session::flash('message-type', 'alert-danger');
                        \Session::flash('message-short', 'Oops!');
                        return \Redirect::to('dashboard');
                    }
                    if (empty($post['confirm_password'])) {
                        \Session::flash('message', "[Confirm Password] is missing!");
                        \Session::flash('message-type', 'alert-danger');
                        \Session::flash('message-short', 'Oops!');
                        return \Redirect::to('dashboard');
                    }
                    if ($post['password'] != $post['confirm_password']) {
                        \Session::flash('message', "[Passwords] are mis-matched!");
                        \Session::flash('message-type', 'alert-danger');
                        \Session::flash('message-short', 'Oops!');
                        return \Redirect::to('dashboard');
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

                \Session::flash('message', "Profile updated successfully");
                \Session::flash('message-type', 'alert-success');
                \Session::flash('message-short', 'Congratulations!');
                return \Redirect::to('dashboard');
            } catch (\Exception $e) {
                \Session::flash('message', $e->getMessage());
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('dashboard');
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
    public function usersAction($type = '', $id = 0)
    {
        if (!isset($type) || empty($type)) {
            \Session::flash('message', "[Type] is missing!");
            \Session::flash('message-type', 'alert-danger');
            \Session::flash('message-short', 'Oops!');
            return \Redirect::to('restaurant/users');
        }
        if (!isset($id) || empty($id) || $id == 0) {
            \Session::flash('message', "[Order Id] is missing!");
            \Session::flash('message-type', 'alert-danger');
            \Session::flash('message-short', 'Oops!');
            return \Redirect::to('restaurant/users');
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

            \Session::flash('message', 'Status has been changed successfully!');
            \Session::flash('message-type', 'alert-success');
            \Session::flash('message-short', 'Congratulations!');
            return \Redirect::to('restaurant/users');
        } catch (\Exception $e) {
            \Session::flash('message', $e->getMessage());
            \Session::flash('message-type', 'alert-danger');
            \Session::flash('message-short', 'Oops!');
            return \Redirect::to('restaurant/users');
        }
    }

    /**
     * Users List
     * @param null
     * @return view
     */
    public function users()
    {
        $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {
            if (!isset($post['name']) || empty($post['name'])) {
                \Session::flash('message', '[Name] field is missing');
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('restaurant/users')->withInput();
            }
            if (!isset($post['email']) || empty($post['email'])) {
                \Session::flash('message', trans('messages.user_missing_email.message'));
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('restaurant/users')->withInput();
            }
            $is_email = \App\Http\Models\Profiles::where('email', '=', $post['email'])->count();
            if ($is_email > 0) {
                \Session::flash('message', trans('messages.user_email_already_exist.message'));
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('restaurant/users')->withInput();
            }
            if (!isset($post['password']) || empty($post['password'])) {
                \Session::flash('message', trans('messages.user_pass_field_missing.message'));
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('restaurant/users')->withInput();
            }
            if (!isset($post['confirm_password']) || empty($post['confirm_password'])) {
                \Session::flash('message', trans('messages.user_confim_pass_field_missing.message'));
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('restaurant/users')->withInput();
            }
            if ($post['password'] != $post['confirm_password']) {
                \Session::flash('message', trans('messages.user_passwords_mismatched.message'));
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('restaurant/users')->withInput();
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

                \Session::flash('message', 'User has been added successfully. A confirmation email has been sent to the selected email address for verification.');
                \Session::flash('message-type', 'alert-success');
                \Session::flash('message-short', 'Congratulations!');
                return \Redirect::to('restaurant/users')->withInput();
            } catch (\Illuminate\Database\QueryException $e) {
                \DB::rollback();
                \Session::flash('message', trans('messages.user_email_already_exist.message'));
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('restaurant/users')->withInput();
            } catch (\Exception $e) {
                \DB::rollback();
                \Session::flash('message', $e->getMessage());
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('restaurant/users')->withInput();
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
    public function addCreditCards($type = '')
    {
        $post = \Input::all();
        \Session::get('session_id');

        if (isset($post) && count($post) > 0 && !is_null($post)) {
            if (!isset($post['profile_id']) || empty($post['profile_id'])) {
                \Session::flash('message', '[User Type] field is missing');
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('users/credit-cards/'.$type)->withInput();
            }
            if (!isset($post['first_name']) || empty($post['first_name'])) {
                \Session::flash('message', '[Name] field is missing');
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('users/credit-cards/'.$type)->withInput();
            }
            if (!isset($post['last_name']) || empty($post['last_name'])) {
                \Session::flash('message', trans('messages.user_missing_email.message'));
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('users/credit-cards/'.$type)->withInput();
            }
            if (!isset($post['card_type']) || empty($post['card_type'])) {
                \Session::flash('message', trans('messages.user_missing_email.message'));
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('users/credit-cards/'.$type)->withInput();
            }
            if (!isset($post['card_number']) || empty($post['card_number'])) {
                \Session::flash('message', trans('messages.user_missing_email.message'));
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('users/credit-cards/'.$type)->withInput();
            }
            if (!isset($post['ccv']) || empty($post['ccv'])) {
                \Session::flash('message', trans('messages.user_missing_email.message'));
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('users/credit-cards/'.$type)->withInput();
            }
            if (!isset($post['expiry_date']) || empty($post['expiry_date'])) {
                \Session::flash('message', trans('messages.user_missing_email.message'));
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('users/credit-cards/'.$type)->withInput();
            }
            if (!isset($post['expiry_month']) || empty($post['expiry_month'])) {
                \Session::flash('message', trans('messages.user_missing_email.message'));
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('users/credit-cards/'.$type)->withInput();
            }
            if (!isset($post['expiry_year']) || empty($post['expiry_year'])) {
                \Session::flash('message', trans('messages.user_missing_email.message'));
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('users/credit-cards/'.$type)->withInput();
            }
            
            \DB::beginTransaction();
            try {
                $creditcard = \App\Http\Models\CreditCard::findOrNew(isset($post['id'])?$post['id']:0);
                $creditcard->populate(array_filter($post));
                $creditcard->save();
                \DB::commit();

                \Session::flash('message', 'Credit card has been saved successfully.');
                \Session::flash('message-type', 'alert-success');
                \Session::flash('message-short', 'Congratulations!');
                return \Redirect::to('users/credit-cards/'.$type);
                    
            } catch (\Exception $e) {
                \DB::rollback();
                \Session::flash('message', $e->getMessage());
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('users/credit-cards')->withInput();
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
    public function creditCardsAction($id = 0, $type = "")
    {
        if (!isset($id) || empty($id) || $id == 0) {
            \Session::flash('message', "[card Id] is missing!");
            \Session::flash('message-type', 'alert-danger');
            \Session::flash('message-short', 'Oops!');
            return \Redirect::to('users/credit-cards/'.$type);
        }

        try {
            $ob = \App\Http\Models\CreditCard::find($id);
                $ob->delete();
            
            event(new \App\Events\AppEvents($ob, "Card Delete"));

            \Session::flash('message', 'Card has been deleted successfully!');
            \Session::flash('message-type', 'alert-success');
            \Session::flash('message-short', 'Congratulations!');
            return \Redirect::to('users/credit-cards/'.$type);
        } catch (\Exception $e) {
            \Session::flash('message', $e->getMessage());
            \Session::flash('message-type', 'alert-danger');
            \Session::flash('message-short', 'Oops!');
            return \Redirect::to('users/credit-cards/'.$type);
        }
    }

    /**
     * Credit Card Sequance Change
     * @param none
     * @return response
     */
    public function saveCreditCardsSequance()
    {
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
    public function ajaxEditCreditCardFrom($id=0)
    {
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
    public function ajaxEditUserForm($id=0)
    {
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
    public function userUpdate()
    {
        $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {
            if (!isset($post['id']) || empty($post['id'])) {
                \Session::flash('message', '[ID] field is missing');
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('restaurant/users')->withInput();
            }
            if (!isset($post['name']) || empty($post['name'])) {
                \Session::flash('message', '[Name] field is missing');
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('restaurant/users')->withInput();
            }
            if (!isset($post['email']) || empty($post['email'])) {
                \Session::flash('message', trans('messages.user_missing_email.message'));
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('restaurant/users')->withInput();
            }
            $is_email = \App\Http\Models\Profiles::where('email', '=', $post['email'])->where('id', '!=', $post['id'])->count();
            if ($is_email > 0) {
                \Session::flash('message', trans('messages.user_email_already_exist.message'));
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('restaurant/users')->withInput();
            }
            if (!isset($post['password']) || empty($post['password'])) {
                \Session::flash('message', trans('messages.user_pass_field_missing.message'));
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('restaurant/users')->withInput();
            }
            if (!isset($post['confirm_password']) || empty($post['confirm_password'])) {
                \Session::flash('message', trans('messages.user_confim_pass_field_missing.message'));
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('restaurant/users')->withInput();
            }
            if ($post['password'] != $post['confirm_password']) {
                \Session::flash('message', trans('messages.user_passwords_mismatched.message'));
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('restaurant/users')->withInput();
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

                \Session::flash('message', 'User has been updated successfully.');
                \Session::flash('message-type', 'alert-success');
                \Session::flash('message-short', 'Congratulations!');
                return \Redirect::to('restaurant/users')->withInput();
            } catch (\Illuminate\Database\QueryException $e) {
                \DB::rollback();
                \Session::flash('message', trans('messages.user_email_already_exist.message'));
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('restaurant/users')->withInput();
            } catch (\Exception $e) {
                \DB::rollback();
                \Session::flash('message', $e->getMessage());
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('restaurant/users')->withInput();
            }
        } else {
            \Session::flash('message', "Invalid parsed data!");
            \Session::flash('message-type', 'alert-danger');
            \Session::flash('message-short', 'Oops!');
            return \Redirect::to('restaurant/users')->withInput();
        }
    }

    /**
     * Newsletter Setting
     * @param null
     * @return view
     */
    public function newsletter()
    {
        $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {
            if (!isset($post['subject']) || empty($post['subject'])) {
                \Session::flash('message', "[Subject] field is missing!");
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('restaurant/newsletter');
            }
            if (!isset($post['message']) || empty($post['message'])) {
                \Session::flash('message', "[Message] field is missing!");
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('restaurant/newsletter');
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

                \Session::flash('message', "Newsletter sent successfully");
                \Session::flash('message-type', 'alert-success');
                \Session::flash('message-short', 'Congratulations!');
                return \Redirect::to('restaurant/newsletter');
            } catch (\Exception $e) {
                \Session::flash('message', $e->getMessage());
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('restaurant/newsletter');
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
    public function subscribers()
    {
        $data['title'] = 'Subscribers List';
        $data['list'] = \App\Http\Models\Newsletter::get();
        return view('dashboard.administrator.subscribers', $data);
    }


}
