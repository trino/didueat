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
                return \Redirect::to('auth/login')->with('message', 'Session expired please relogin!');
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
                return \Redirect::to('dashboard')->with('message', "[Name] field is missing!");
            }
            if (!isset($post['email']) || empty($post['email'])) {
                return \Redirect::to('dashboard')->with('message', "[Email] field is missing!");
            }
            if (!isset($post['phone']) || empty($post['phone'])) {
                return \Redirect::to('dashboard')->with('message', "[Phone] field is missing!");
            }
            try {
                $ob = \App\Http\Models\Profiles::find(\Session::get('session_id'));

                if (isset($post['old_password']) && !empty($post['old_password'])) {
                    $password = encrypt($post['old_password']);
                    if ($ob->Password != $password) {
                        return \Redirect::to('dashboard')->with('message', "[Old Password] is incorrect!");
                    }
                    if (empty($post['new_password'])) {
                        return \Redirect::to('dashboard')->with('message', "[New Password] is missing!");
                    }
                    if (empty($post['confirm_password'])) {
                        return \Redirect::to('dashboard')->with('message', "[Confirm Password] is missing!");
                    }
                    if ($post['new_password'] != $post['confirm_password']) {
                        return \Redirect::to('dashboard')->with('message', "[Passwords] are mis-matched!");
                    }
                    $post['password'] = $post['confirm_password'];
                }

                $ob->populate($post);
                $ob->save();

                login($ob);

                return \Redirect::to('dashboard')->with('message', "Profile updated successfully");
            } catch (\Exception $e) {
                return \Redirect::to('dashboard')->with('message', $e->getMessage());
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
            return \Redirect::to('restaurant/users')->with('message', "[Type] is missing!");
        }
        if (!isset($id) || empty($id) || $id == 0) {
            return \Redirect::to('restaurant/users')->with('message', "[Order Id] is missing!");
        }
        
        try {
            $ob = \App\Http\Models\Profiles::find($id);
            //$ob->populate(array('status' => 'approved'));
            //$ob->save();
            
            return \Redirect::to('restaurant/users')->with('message', 'Status has been changed successfully!');
        } catch (\Exception $e) {
            return \Redirect::to('restaurant/users')->with('message', $e->getMessage());
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
                return \Redirect::to('restaurant/users')->with('message', '[Name] field is missing')->withInput();
            }
            if (!isset($post['email']) || empty($post['email'])) {
                return \Redirect::to('restaurant/users')->with('message', trans('messages.user_missing_email.message'))->withInput();
            }
            $is_email = \App\Http\Models\Profiles::where('email', '=', $post['email'])->count();
            if ($is_email > 0) {
                return \Redirect::to('restaurant/users')->with('message', trans('messages.user_email_already_exist.message'))->withInput();
            }
            if (!isset($post['password']) || empty($post['password'])) {
                return \Redirect::to('restaurant/users')->with('message', trans('messages.user_pass_field_missing.message'))->withInput();
            }
            if (!isset($post['confirm_password']) || empty($post['confirm_password'])) {
                return \Redirect::to('restaurant/users')->with('message', trans('messages.user_confim_pass_field_missing.message'))->withInput();
            }
            if ($post['password'] != $post['confirm_password']) {
                return \Redirect::to('restaurant/users')->with('message', trans('messages.user_passwords_mismatched.message'))->withInput();
            }

            \DB::beginTransaction();
            try {
                $post['status'] = 0;

                $user = new \App\Http\Models\Profiles();
                $user->populate($post);
                $user->save();

                $userArray = $user->toArray();
                $userArray['mail_subject'] = 'Thank you for registration.';
                $this->sendEMail("emails.registration_welcome", $userArray);
                \DB::commit();

                return \Redirect::to('restaurant/users')->with('message', 'User has been added successfully. An confirmation email has been sent to the selected email address for verification.')->withInput();
            } catch (\Illuminate\Database\QueryException $e) {
                \DB::rollback();
                return \Redirect::to('restaurant/users')->with('message', trans('messages.user_email_already_exist.message'))->withInput();
            } catch (\Exception $e) {
                \DB::rollback();
                return \Redirect::to('restaurant/users')->with('message', $e->getMessage())->withInput();
            }
        } else {
            $data['title'] = 'Users List';
            $data['users_list'] = \App\Http\Models\Profiles::where('ProfileType', 2)->orWhere('ProfileType', 4)->orWhere('ProfileType', 1)->orderBy('ID', 'DESC')->get();
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
                return \Redirect::to('restaurant/newsletter')->with('message', "[Subject] field is missing!");
            }
            if (!isset($post['message']) || empty($post['message'])) {
                return \Redirect::to('restaurant/newsletter')->with('message', "[Message] field is missing!");
            }
            try {
                $ob = \App\Http\Models\Newsletter::get();
                foreach ($ob as $value) {
                    $ob_user = \App\Http\Models\Profiles::where('email', $value->Email)->where('status', 1)->first();
                    if (isset($ob_user) && count($ob_user) > 0 && !is_null($ob_user)) {
                        $array = $ob_user->toArray();
                        $array['mail_subject'] = $post['subject'];
                        $array['message'] = $post['message'];

                        $this->sendEMail("emails.newsletter", $array);
                    }
                }

                return \Redirect::to('restaurant/newsletter')->with('message', "Newsletter sent successfully");
            } catch (\Exception $e) {
                return \Redirect::to('restaurant/newsletter')->with('message', $e->getMessage());
            }
        } else {
            $data['title'] = 'Newsletter Send';
            return view('dashboard.administrator.newsletter', $data);
        }
    }

}
