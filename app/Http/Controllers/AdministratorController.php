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
                    $password = \crypt($post['old_password'], $ob->salt);
                    if ($ob->password != $password) {
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

                \Session::put('session_name', $ob->name);
                \Session::put('session_email', $ob->email);
                \Session::put('session_phone', $ob->phone);
                \Session::put('session_subscribed', $ob->subscribed);
                
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
     * Users List
     * @param null
     * @return view
     */
    public function users() {
        $data['title'] = 'Users List';
        $data['users_list'] = \App\Http\Models\Profiles::where('ProfileType', 2)->orWhere('ProfileType', 4)->orWhere('ProfileType', 1)->get();
        return view('dashboard.administrator.users', $data);
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
