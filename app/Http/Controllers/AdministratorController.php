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
            initialize("admin");
        });
        if(\Session::has('message')){
            \Session::forget('message');
        }
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
                } else if ($post['password'] || $post['confirm_password']) {
                    return $this->failure("[Old Password] is missing!",'dashboard');
                }
                //copy post data to an array
                $data['subscribed'] = 0;
                if(isset($post['subscribed'])){
                    $data['subscribed'] = 1;
                }

                $data['name'] = $post['name'];
                $data['phone'] = $post['phone'];
                $data['mobile'] = $post['mobile'];
                $data['status'] = $post['status'];
                $data['photo'] = $post['photo'];

                //save the array to the database
                $ob->populate($data);
                $ob->save();
                
                event(new \App\Events\AppEvents($ob, "Profile Updated"));//log event

                if(isset($post['phone']) && !empty($post['phone'])){
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
    


}
