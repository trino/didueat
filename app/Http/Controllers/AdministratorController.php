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
        $this->beforeFilter(function() {
            if (!\Session::has('is_logged_in')) {
                \Session::flash('message', trans('messages.user_session_exp.message')); 
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('auth/login');
            }
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
            if (!isset($post['phone']) || empty($post['phone'])) {
                \Session::flash('message', "[Phone] field is missing!");
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
                    if (empty($post['new_password'])) {
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
                    if ($post['new_password'] != $post['confirm_password']) {
                        \Session::flash('message', "[Passwords] are mis-matched!");
                        \Session::flash('message-type', 'alert-danger');
                        \Session::flash('message-short', 'Oops!');
                        return \Redirect::to('dashboard');
                    }
                    $post['password'] = $post['confirm_password'];
                }

                $ob->populate($post);
                $ob->save();

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
            return view('dashboard.administrator.dashboard', $data);
        }
    }

    /**
     * Users Action
     * @param $type
     * @param $id
     * @return redirect
     */
    public function usersAction($type='', $id=0) {
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
            if($type == "user_fire"){
                $ob->delete();
            } else {
                $ob->populate(array('profile_type' => 1));
                $ob->save();
            }
            
            
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
    public function users() {
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
                $post['status'] = 0;
                $post['subscribed'] = 0;
                $post['created_by'] = \Session::get('session_id');
                $post['restaurant_id'] = \Session::get('session_restaurantid');

                $user = new \App\Http\Models\Profiles();
                $user->populate($post);
                $user->save();

                $userArray = $user->toArray();
                $userArray['mail_subject'] = 'Thank you for registration.';
                $this->sendEMail("emails.registration_welcome", $userArray);
                \DB::commit();
                
                \Session::flash('message', 'User has been added successfully. An confirmation email has been sent to the selected email address for verification.');
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
            $data['users_list'] = \App\Http\Models\Profiles::where('profiletype', 2)->orWhere('profiletype', 4)->orWhere('profiletype', 1)->orderBy('id', 'DESC')->get();
            //this should not be hard-coded to use profiletype IDs, but check those profile types permissions or hierarchy
            return view('dashboard.administrator.users', $data);
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

}
