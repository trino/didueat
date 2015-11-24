<?php
namespace App\Http\Controllers\Auth;

use Auth;
use \Input;

//use Illuminate\Routing\Controller;
//use App\Models\Profiles;
//use Validator;
use App\Http\Controllers\Controller;

class AuthController extends Controller {
    public function __construct() {
        $this->beforeFilter(function () {
            initialize("auth");
        });
    }

    /**
     * Login page
     * @param  null
     * @return view
     */
    public function getLogin() {
        return view('auth.login', array('title' => 'Login Page'));
    }

    /**
     * Post Login
     * @param  null
     * @return view
     */
    public function authenticate() {
        if (\Input::has('email')) {
            try {
                $user = \App\Http\Models\Profiles::where('email', '=', \Input::get('email'))->first();
                if (!is_null($user) && count($user) > 0) {
                    if ($user->status == 0) {
                        \Session::flash('message', trans('messages.user_inactive.message'));
                        \Session::flash('message-type', 'alert-danger');
                        \Session::flash('message-short', 'Oops!');
                        return \Redirect::to('auth/login');
                    }
                    $password = \Input::get('password');
                    if (\Hash::check($password, $user->password)) {
                        login($user);
                        return redirect()->intended('dashboard');
                    } else {
                        \Session::flash('message', trans('messages.user_login_invalid.message'));
                        \Session::flash('message-type', 'alert-danger');
                        \Session::flash('message-short', 'Oops!');
                        return \Redirect::to('auth/login');
                    }
                } else {
                    \Session::flash('message', trans('messages.user_not_registered.message'));
                    \Session::flash('message-type', 'alert-danger');
                    \Session::flash('message-short', 'Oops!');
                    //return redirect()->intended('auth/login');
                    return \Redirect::to('auth/login');
                }
            } catch (Exception $e) {
                \Session::flash('message', $e->getMessage());
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('auth/login');
            }
        } else {
            \Session::flash('message', trans('messages.user_missing_email.message'));
            \Session::flash('message-type', 'alert-danger');
            \Session::flash('message-short', 'Oops!');
            return \Redirect::to('auth/login');
        }
    }

    /**
     * Post Login Ajax
     * @param  null
     * @return view
     */
    public function authenticateAjax() {
        if (\Input::has('email')) {
            try {
                $user = \App\Http\Models\Profiles::where('email', '=', \Input::get('email'))->first();
                if (!is_null($user) && count($user) > 0) {
                    if ($user->status == 0) {
                        echo trans('messages.user_inactive.message');
                        die;
                    }
                    $password = \Input::get('password');
                    if (\Hash::check($password, $user->password)) {
                        login($user);

                    } else {
                        echo trans('messages.user_login_invalid.message');
                        die;
                    }
                } else {
                    echo trans('messages.user_not_registered.message');
                    die;
                }
            } catch (Exception $e) {
                echo $e->getMessage();
                die;
            }
        } else {
            echo trans('messages.user_missing_email.message');
            die;
        }
    }

    /**
     * Registration page
     * @param  null
     * @return view
     */
    public function getRegister() {
        return view('auth.register', array('title' => 'Register Page'));
    }

    /**
     * Post Registration
     * @param  array
     * @return redirect
     */
    public function postRegister()
    {

        $data = \Input::all();
        if (isset($data) && count($data) > 0 && !is_null($data)) {
            if (!isset($data['email']) || empty($data['email'])) {
                \Session::flash('message', trans('messages.user_missing_email.message'));
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('auth/register')->withInput();
            }

            $is_email = \App\Http\Models\Profiles::where('email', '=', $data['email'])->count();
            if ($is_email > 0) {
                \Session::flash('message', trans('messages.user_email_already_exist.message'));
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('auth/register')->withInput();
            }
            if (!isset($data['password']) || empty($data['password'])) {
                \Session::flash('message', trans('messages.user_pass_field_missing.message'));
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('auth/register')->withInput();
            }
            if (!isset($data['confirm_password']) || empty($data['confirm_password'])) {
                \Session::flash('message', trans('messages.user_confim_pass_field_missing.message'));
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('auth/register')->withInput();
            }
            if ($data['password'] != $data['confirm_password']) {
                \Session::flash('message', trans('messages.user_passwords_mismatched.message'));
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('auth/register')->withInput();
            } else {
                \DB::beginTransaction();
                try {
                    $data['status'] = 0;
                    $data['profile_type'] = 2;

                    $user = new \App\Http\Models\Profiles();
                    $user->populate(array_filter($data));
                    $user->save();

                    if($user->id){
                        $add = new \App\Http\Models\ProfilesAddresses();
                        $data['user_id'] = $user->id;
                        $add->populate(array_filter($data));
                        $add->save();
                    }

                    $userArray = $user->toArray();
                    $userArray['mail_subject'] = 'Thank you for registration.';
                    $this->sendEMail("emails.registration_welcome", $userArray);
                    \DB::commit();

                    $message['title'] = "Registration Success";
                    $message['msg_type'] = "success";
                    $message['msg_desc'] = "Thank you for creating an account with DidUEat.com. A confirmation email has been sent to your email address [$user->email]. Please verify the link. If you didn't find the email from us, <a href='" . url('auth/resend_email/' . base64_encode($user->email)) . "'><b>click here</b></a> to resend the confirmation email. Thank you.";
                    return view('messages.message', $message);
                } catch (\Illuminate\Database\QueryException $e) {
                    \DB::rollback();
                    \Session::flash('message', trans('messages.user_email_already_exist.message'));
                    \Session::flash('message-type', 'alert-danger');
                    \Session::flash('message-short', 'Oops!');
                    return \Redirect::to('auth/register')->withInput();
                } catch (\Exception $e) {
                    \DB::rollback();
                    \Session::flash('message', $e->getMessage());
                    \Session::flash('message-type', 'alert-danger');
                    \Session::flash('message-short', 'Oops!');
                    return \Redirect::to('auth/register')->withInput();
                }
            }
        } else {
            \Session::flash('message', trans('messages.user_invalid_data_parse.message'));
            \Session::flash('message-type', 'alert-danger');
            \Session::flash('message-short', 'Oops!');
            return \Redirect::to('auth/register')->withInput();
        }
    }

    /**
     * Ajax Post Registration
     * @param  array
     * @return redirect
     */
    public function postAjaxRegister()
    {

        $data = \Input::all();
        if (isset($data) && count($data) > 0 && !is_null($data)) {
            if (!isset($data['email']) || empty($data['email'])) {
                echo json_encode(array('type' => 'error', 'message' => trans('messages.user_missing_email.message')));
                die;
            }

            $is_email = \App\Http\Models\Profiles::where('email', '=', $data['email'])->count();
            if ($is_email > 0) {
                echo json_encode(array('type' => 'error', 'message' => trans('messages.user_email_already_exist.message')));
                die;
            }
            if (!isset($data['password']) || empty($data['password'])) {
                echo json_encode(array('type' => 'error', 'message' => trans('messages.user_pass_field_missing.message')));
                die;
            }
            if (!isset($data['confirm_password']) || empty($data['confirm_password'])) {
                echo json_encode(array('type' => 'error', 'message' => trans('messages.user_confim_pass_field_missing.message')));
                die;
            }
            if ($data['password'] != $data['confirm_password']) {
                echo json_encode(array('type' => 'error', 'message' => trans('messages.user_passwords_mismatched.message')));
                die;
            } else {
                \DB::beginTransaction();
                try {
                    $data['status'] = 0;
                    $data['profile_type'] = 2;

                    $user = new \App\Http\Models\Profiles();
                    $user->populate(array_filter($data));
                    $user->save();
                    
                    event(new \App\Events\AppEvents($user, "User Created"));

                    $nd1 = new \App\Http\Models\NotificationAddresses();
                    $nd1->populate(array("is_default" => 1, 'type' => "Email", 'user_id' => $user->id, 'address' => $user->email));
                    $nd1->save();

                    if($user->id){
                        $add = new \App\Http\Models\ProfilesAddresses();
                        $data['user_id'] = $user->id;
                        $add->populate(array_filter($data));
                        $add->save();

                        $nd2 = new \App\Http\Models\NotificationAddresses();
                        $nd2->populate(array("is_default" => 1, 'type' => "Phone", 'user_id' => $user->id, 'address' => $add->phone_no));
                        $nd2->save();
                    }

                    $userArray = $user->toArray();
                    $userArray['mail_subject'] = 'Thank you for registration.';
                    $this->sendEMail("emails.registration_welcome", $userArray);
                    \DB::commit();

                    echo json_encode(array('type' => 'success', 'message' => "Thank you for creating an account with DidUEat.com. A confirmation email has been sent to your email address [" . $user->email . "]. Please verify the link. If you didn't find the email from us, <a id='resendMeEmail' href='" . url('auth/resend_email/ajax/' . base64_encode($user->email)) . "'><b>click here</b></a> to resend the confirmation email. Thank you."));
                    die;
                } catch (\Illuminate\Database\QueryException $e) {
                    \DB::rollback();
                    echo json_encode(array('type' => 'error', 'message' => trans('messages.user_email_already_exist.message')));
                    die;
                } catch (\Exception $e) {
                    \DB::rollback();
                    echo json_encode(array('type' => 'error', 'message' => $e->getMessage()));
                    die;
                }
            }
        } else {
            echo json_encode(array('type' => 'error', 'message' => trans('messages.user_invalid_data_parse.message')));
            die;
        }
    }


    /**
     * Ajax Resend Activation email
     * @param  $id
     * @return message
     */
    public function resendPostEmail($email = 0)
    {
        $email = base64_decode($email);
        $user = \App\Http\Models\Profiles::where('email', $email)->first();

        if (isset($user) && count($user) > 0 && !is_null($user)) {
            $userArray = $user->toArray();
            $userArray['mail_subject'] = 'Thank you for registration.';
            $this->sendEMail("emails.registration_welcome", $userArray);

            echo json_encode(array('type' => 'success', 'message' => "Thank you for creating an account with DidUEat.com. A confirmation email has been sent to your email address [" . $user->email . "]. Please verify the link. If you didn't find the email from us, <a id='resendMeEmail' href='" . url('auth/resend_email/ajax/' . base64_encode($user->email)) . "'><b>click here</b></a> to resend the confirmation email. Thank you."));
            die;
        } else {
            echo json_encode(array('type' => 'error', 'message' => "Invalid code found. Please <a href='" . url('auth/login') . "'><b>click here</b></a> to login."));
            die;
        }
    }

    /**
     * Resend Activation email
     * @param  $id
     * @return message
     */
    public function resendEmail($email = 0)
    {
        $email = base64_decode($email);
        $user = \App\Http\Models\Profiles::where('email', $email)->first();

        if (isset($user) && count($user) > 0 && !is_null($user)) {
            $userArray = $user->toArray();
            $userArray['mail_subject'] = 'Thank you for registering.';
            $this->sendEMail("emails.registration_welcome", $userArray);

            $message['title'] = "Registration Success";
            $message['msg_type'] = "success";
            $message['msg_desc'] = "Thank you for creating an account with DidUEat.com. A confirmation email has been sent to your email address [" . $user->email . "]. Please verify the link. If you didn't find the email from us, <a id='resendMeEmail' href='" . url('auth/resend_email/ajax/' . base64_encode($user->email)) . "'><b>click here</b></a> to resend the confirmation email. Thank you.";
            return view('messages.message', $message);
        } else {
            $message['title'] = "Email verification";
            $message['msg_type'] = "error";
            $message['msg_desc'] = "Invalid code found. Please <a href='#login-pop-up' class='fancybox-fast-view'><b>click here</b></a> to login.";
            return view('messages.message', $message);
        }
    }

    /**
     * Verify email address
     * @param  $email
     * @return message
     */
    public function verifyEmail($email = "")
    {
        $email = base64_decode($email);
        $count = \App\Http\Models\Profiles::where('email', $email)->where('status', 1)->count();
        $user = \App\Http\Models\Profiles::where('email', $email)->first();

        if ($count > 0) {
            $message['title'] = "Email verification";
            $message['msg_type'] = "error";
            $message['msg_desc'] = "Your account has been verified already. Please <a href='#login-pop-up' class='fancybox-fast-view'><b>click here</b></a> to login.";
            return view('messages.message', $message);
        }

        if (isset($user) && count($user) > 0 && !is_null($user)) {
            $user->status = 1;
            $user->save();

            login($user);

            $message['title'] = "Email verification";
            $message['msg_type'] = "success";
            //$message['msg_desc'] = "Thank you for activate your account with didueat.com. Your email has been confirmed successfully. Please <a href='#login-pop-up' class='fancybox-fast-view'><b>click here</b></a> to login.";
            $message['msg_desc'] = "Thank you for activating your account with DidUEat.com. Your email has been confirmed successfully. You have been logged in into our system. Please <a href='#login-pop-up' class='fancybox-fast-view'><b>click here</b></a> to change your info. ";
            return view('messages.message', $message);
        } else {
            $message['title'] = "Email verification";
            $message['msg_type'] = "error";
            $message['msg_desc'] = "Activation code is invalid. Please <a href='" . url('auth/login') . "'><b>click here</b></a> to login.";
            return view('messages.message', $message);
        }
    }

    /**
     * Forgot Password
     * @param  null
     * @return view
     */
    public function forgotPassword()
    {
        return view('auth.forgot', array('title' => 'Forgot Password'));
    }

    /**
     * Forgot Password Post
     * @param  array
     * @return message
     */
    public function postForgotPassword()
    {
        if (\Input::has('email')) {
            try {
                $user = \App\Http\Models\Profiles::where('email', '=', \Input::get('email'))->first();
                if (!is_null($user) && count($user) > 0) {
                    if ($user->status == 0) {
                        \Session::flash('message', trans('messages.user_inactive.message'));
                        \Session::flash('message-type', 'alert-danger');
                        \Session::flash('message-short', 'Oops!');
                        return \Redirect::to('auth/forgot-passoword');
                    }

                    $newpass = substr(dechex(round(rand(0, 999999999999999))), 0, 8);
                    $user->password = \bcrypt($newpass);;
                    $user->save();

                    $userArray = $user->toArray();
                    $userArray['mail_subject'] = 'New password request for your DidUEat account.';
                    $userArray['new_pass'] = $newpass;
                    $this->sendEMail("emails.forgot", $userArray);

                    $message['title'] = "Forgot Password";
                    $message['msg_type'] = "success";
                    $message['msg_desc'] = "Your password has been has been reset successfully. We sent an email to [$user->email]. Please check your inbox for your new password. If you still have any difficulties please contact us. Thank you";
                    return view('messages.message', $message);

                } else {
                    \Session::flash('message', trans('messages.user_email_not_verify.message'));
                    \Session::flash('message-type', 'alert-danger');
                    \Session::flash('message-short', 'Oops!');
                    return \Redirect::to('auth/forgot-passoword');
                }
            } catch (Exception $e) {
                \Session::flash('message', $e->getMessage());
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('auth/forgot-passoword');
            }
        } else {
            \Session::flash('message', trans('messages.user_missing_email.message'));
            \Session::flash('message-type', 'alert-danger');
            \Session::flash('message-short', 'Oops!');
            return \Redirect::to('auth/forgot-passoword');
        }
    }

    /**
     * Ajax Forgot Password Post
     * @param  array
     * @return message
     */
    public function postAjaxForgotPassword()
    {
        if (\Input::has('email')) {
            try {
                $user = \App\Http\Models\Profiles::where('email', '=', \Input::get('email'))->first();
                if (!is_null($user) && count($user) > 0) {
                    if ($user->status == 0) {
                        echo json_encode(array('type' => 'error', 'message' => trans('messages.user_inactive.message')));
                        die;
                    }
                    $newpass = substr(dechex(round(rand(0, 999999999999999))), 0, 8);
                    $user->password = \bcrypt($newpass);
                    $user->save();

                    $userArray = $user->toArray();
                    $userArray['mail_subject'] = 'New password request for your DidUEat account.';
                    $userArray['new_pass'] = $newpass;
                    $this->sendEMail("emails.forgot", $userArray);

                    echo json_encode(array('type' => 'success', 'message' => "Your password has been has been reset successfully. We sent an email to [$user->email]. Please check your inbox for your new password. If you still have any difficulties please contact us. Thank you"));
                    die;
                } else {
                    echo json_encode(array('type' => 'error', 'message' => trans('messages.user_email_not_verify.message')));
                    die;
                }
            } catch (Exception $e) {
                echo json_encode(array('type' => 'error', 'message' => $e->getMessage()));
                die;
            }
        } else {
            echo json_encode(array('type' => 'error', 'message' => trans('messages.user_missing_email.message')));
            die;
        }
    }
    
    /**
     * Validate Unique Email
     * @param  $email
     * @return string
     */
    public function postAjaxValidateEmail()
    {
        if (\Input::has('email')) {
            try {
                $user = \App\Http\Models\Profiles::where('email', \Input::get('email'))->count();
                if ($user > 0) {
                    echo "false";
                    die;
                } else {
                    echo "true";
                    die;
                }
            } catch (Exception $e) {
                echo json_encode(array('type' => 'error', 'message' => $e->getMessage()));
                die;
            }
        } else {
            echo json_encode(array('type' => 'error', 'message' => trans('messages.user_missing_email.message')));
            die;
        }
    }
    
    /**
     * Logout
     * @param  null
     * @return redirect
     */
    public function getLogout()
    {
        \Session::flush();
        \Session::flash('message', trans('messages.user_logout.message'));
        \Session::flash('message-type', 'alert-success');
        \Session::flash('message-short', 'Congratulations!');
        return \Redirect::to('/');
    }

    function test()
    {
        return view('auth.test', array('title' => 'Testing'));
    }
}
