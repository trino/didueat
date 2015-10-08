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
        $this->beforeFilter(function() {
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
                $user = \App\Http\Models\Profiles::where('Email', '=', \Input::get('email'))->first();
                if (!is_null($user) && count($user) > 0) {
                    if ($user->Status == 0) {
                        return \Redirect::to('auth/login')->with('message', trans('messages.user_inactive.message'));
                    }
                    $password = encryptpassword(\Input::get('password'));
                    if ($user->Password == $password) {
                        login($user);
                        return redirect()->intended('dashboard');
                    } else {
                        return \Redirect::to('auth/login')->with('message', trans('messages.user_login_invalid.message'));
                    }
                } else {
                    //return redirect()->intended('auth/login');
                    return \Redirect::to('auth/login')->with('message', trans('messages.user_not_registered.message'));
                }
            } catch (Exception $e) {
                return \Redirect::to('auth/login')->with('message', $e->getMessage());
            }
        } else {
            return \Redirect::to('auth/login')->with('message', trans('messages.user_missing_email.message'));
        }
    }

    /**
     * Post Login Ajax
     * @param  null
     * @return view
     */
    public function authenticateAjax() {
        if (\Input::has('Email')) {
            try {
                $user = \App\Http\Models\Profiles::where('Email', '=', \Input::get('Email'))->first();
                if (!is_null($user) && count($user) > 0) {
                    if ($user->Status == 0) {
                        echo trans('messages.user_inactive.message');
                        die;
                    }
                    $password = encryptpassword(\Input::get('password'));
                    if ($user->Password == $password) {
                        login($user);
                    } else {
                        //echo $user->password . " != " . $password ; die();
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
    public function postRegister() {
        
        $data = \Input::all();
        if (isset($data) && count($data) > 0 && !is_null($data)) {
            if (!isset($data['Email']) || empty($data['Email'])) {
                return \Redirect::to('auth/register')->with('message', trans('messages.user_missing_email.message'))->withInput();
            }

            $is_email = \App\Http\Models\Profiles::where('email', '=', $data['Email'])->count();
            if ($is_email > 0) {
                return \Redirect::to('auth/register')->with('message', trans('messages.user_email_already_exist.message'))->withInput();
            }
            if (!isset($data['password']) || empty($data['password'])) {
                return \Redirect::to('auth/register')->with('message', trans('messages.user_pass_field_missing.message'))->withInput();
            }
            if (!isset($data['confirm_password']) || empty($data['confirm_password'])) {
                return \Redirect::to('auth/register')->with('message', trans('messages.user_confim_pass_field_missing.message'))->withInput();
            }
            if ($data['password'] != $data['confirm_password']) {
                return \Redirect::to('auth/register')->with('message', trans('messages.user_passwords_mismatched.message'))->withInput();
            } else {
                \DB::beginTransaction();
                try {
                    $data['Status'] = 0;
                    $data['ProfileType'] = 2;

                    $user = new \App\Http\Models\Profiles();
                    $user->populate($data);
                    $user->save();
                    
                    $userArray = $user->toArray();
                    $userArray['mail_subject'] = 'Thank you for registration.';
                    $this->sendEMail("emails.registration_welcome", $userArray);
                    \DB::commit();
                    
                    $message['title'] = "Registration Success";
                    $message['msg_type'] = "success";
                    $message['msg_desc'] = "Thank you for creating account with didueat.com. An confirmation email has been sent to your email address [$user->Email]. Please verify the link. If you did't find the email from us then <a href='" . url('auth/resend_email/' . base64_encode($user->email)) . "'><b>click here</b></a> to resent confirmation email. thanks";
                    return view('messages.message', $message);
                } catch (\Illuminate\Database\QueryException $e) {
                    \DB::rollback();
                    return \Redirect::to('auth/register')->with('message', trans('messages.user_email_already_exist.message'))->withInput();
                } catch (\Exception $e) {
                    \DB::rollback();
                    return \Redirect::to('auth/register')->with('message', $e->getMessage())->withInput();
                }
            }
        } else {
            return \Redirect::to('auth/register')->with('message', trans('messages.user_invalid_data_parse.message'))->withInput();
        }
    }
    
    /**
     * Ajax Post Registration
     * @param  array
     * @return redirect
     */
    public function postAjaxRegister() {
        
        $data = \Input::all();
        if (isset($data) && count($data) > 0 && !is_null($data)) {
           
            if (!isset($data['Email']) || empty($data['Email'])) {
               
                echo json_encode(array('type' => 'error', 'message' => trans('messages.user_missing_email.message'))); die;
            }

            $is_email = \App\Http\Models\Profiles::where('Email', '=', $data['Email'])->count();
            if ($is_email > 0) {
                echo json_encode(array('type' => 'error', 'message' => trans('messages.user_email_already_exist.message'))); die;
            }
            if (!isset($data['password']) || empty($data['password'])) {
                echo json_encode(array('type' => 'error', 'message' => trans('messages.user_pass_field_missing.message'))); die;
            }
            if (!isset($data['confirm_password']) || empty($data['confirm_password'])) {
                echo json_encode(array('type' => 'error', 'message' => trans('messages.user_confim_pass_field_missing.message'))); die;
            }
            if ($data['password'] != $data['confirm_password']) {
                echo json_encode(array('type' => 'error', 'message' => trans('messages.user_passwords_mismatched.message'))); die;
            } else {
                \DB::beginTransaction();
                try {
                    $data['Status'] = 0;
                    $data['ProfileType'] = 1;

                    $user = new \App\Http\Models\Profiles();
                    $user->populate($data);
                    $user->save();
                    
                    $userArray = $user->toArray();
                    $userArray['mail_subject'] = 'Thank you for registration.';
                    $this->sendEMail("emails.registration_welcome", $userArray);
                    \DB::commit();
                    
                    echo json_encode(array('type' => 'success', 'message' => "Thank you for creating account with didueat.com. An confirmation email has been sent to your email address [". $user->Email ."]. Please verify the link. If you did't find the email from us then <a id='resendMeEmail' href='" . url('auth/resend_email/ajax/' . base64_encode($user->Email)) . "'><b>click here</b></a> to resent confirmation email. thanks")); die;
                } catch (\Illuminate\Database\QueryException $e) {
                    \DB::rollback();
                    echo json_encode(array('type' => 'error', 'message' => trans('messages.user_email_already_exist.message'))); die;
                } catch (\Exception $e) {
                    \DB::rollback();
                    echo json_encode(array('type' => 'error', 'message' => $e->getMessage())); die;
                }
            }
        } else {
            echo json_encode(array('type' => 'error', 'message' => trans('messages.user_invalid_data_parse.message'))); die;
        }
    }
    
    
    /**
     * Ajax Resend Activation email
     * @param  $id
     * @return message
     */
    public function resendPostEmail($email = 0) {
        $email = base64_decode($email);
        $user = \App\Http\Models\Profiles::where('Email', $email)->first();
        
        if (isset($user) && count($user) > 0 && !is_null($user)) {
            $userArray = $user->toArray();
            $userArray['mail_subject'] = 'Thank you for registration.';
            $this->sendEMail("emails.registration_welcome", $userArray);
            
            echo json_encode(array('type' => 'success', 'message' => "Thank you for creating account with didueat.com. An confirmation email has been sent to your email address [$user->Email]. Please verify the link. If you did't find the email from us then <a id='resendMeEmail' href='" . url('auth/resend_email/ajax/' . base64_encode($user->Email)) . "'><b>click here</b></a> to resent confirmation email. thanks")); die;
        } else {
            echo json_encode(array('type' => 'error', 'message' => "Invalid code found. Please <a href='" . url('auth/login') . "'><b>click here</b></a> to login.")); die;
        }
    }
    
    /**
     * Resend Activation email
     * @param  $id
     * @return message
     */
    public function resendEmail($email = 0) {
        $email = base64_decode($email);
        $user = \App\Http\Models\Profiles::where('Email', $email)->first();
        
        if (isset($user) && count($user) > 0 && !is_null($user)) {
            $userArray = $user->toArray();
            $userArray['mail_subject'] = 'Thank you for registration.';
            $this->sendEMail("emails.registration_welcome", $userArray);

            $message['title'] = "Registration Success";
            $message['msg_type'] = "success";
            $message['msg_desc'] = "Thank you for creating account with didueat.com. An confirmation email has been sent to your email address [$user->Email]. Please verify the link. If you did't find the email from us then <a href='" . url('auth/resend_email/' . base64_encode($user->Email)) . "'><b>click here</b></a> to resent confirmation email. thanks";
            return view('messages.message', $message);
        } else {
            $message['title'] = "Email verification";
            $message['msg_type'] = "error";
            $message['msg_desc'] = "Invalid code found. Please <a href='" . url('auth/login') . "'><b>click here</b></a> to login.";
            return view('messages.message', $message);
        }
    }

    /**
     * Verify email address
     * @param  $email
     * @return message
     */
    public function verifyEmail($email = "") {
        $email = base64_decode($email);
        $count = \App\Http\Models\Profiles::where('Email', $email)->where('Status', 1)->count();
        $user = \App\Http\Models\Profiles::where('Email', $email)->first();

        if ($count > 0) {
            $message['title'] = "Email verification";
            $message['msg_type'] = "error";
            $message['msg_desc'] = "Your account has been verified already. Please <a href='" . url('auth/login') . "'><b>click here</b></a> to login.";
            return view('messages.message', $message);
        }

        if (isset($user) && count($user) > 0 && !is_null($user)) {
            $user->Status = 1;
            $user->save();

            login($user);

            $message['title'] = "Email verification";
            $message['msg_type'] = "success";
            //$message['msg_desc'] = "Thank you for activate your account with didueat.com. Your email has been confirmed successfully. Please <a href='" . url('auth/login') . "'><b>click here</b></a> to login.";
            $message['msg_desc'] = "Thank you for activate your account with didueat.com. Your email has been confirmed successfully. You has been logged in into our system. Please <a href='" . url('user/info') . "'><b>click here</b></a> to change your info. ";
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
    public function forgotPassword() {
        return view('auth.forgot', array('title' => 'Forgot Password'));
    }
    
    /**
     * Forgot Password Post
     * @param  array
     * @return message
     */
    public function postForgotPassword() {
        if (\Input::has('email')) {
            try {
                $user = \App\Http\Models\Profiles::where('email', '=', \Input::get('email'))->first();
                if (!is_null($user) && count($user) > 0) {
                   
                    if ($user->Status == 0) {
                        return \Redirect::to('auth/forgot-passoword')->with('message', trans('messages.user_inactive.message'));
                    }
                    
                    $newpass = substr(dechex(round(rand(0,999999999999999))),0,8);
                    $password = encryptpassword($newpass);
                    $user->Password = $password;
                    $user->save();
                    
                    $userArray = $user->toArray();
                    $userArray['mail_subject'] = 'New password request for your didueat account.';
                    $userArray['new_pass'] = $newpass;
                    $this->sendEMail("emails.forgot", $userArray);
                    
                    $message['title'] = "Forgot Password";
                    $message['msg_type'] = "success";
                    $message['msg_desc'] = "Your password has been has been reset successfully. We send you an email at [$user->Email]. Please check your inbox for your new password. If you still face difficulties please contact us. thanks";
                    return view('messages.message', $message);

                } else {
                    return \Redirect::to('auth/forgot-passoword')->with('message', trans('messages.user_email_not_verify.message'));
                }
            } catch (Exception $e) {
                return \Redirect::to('auth/forgot-passoword')->with('message', $e->getMessage());
            }
        } else {
            return \Redirect::to('auth/forgot-passoword')->with('message', trans('messages.user_missing_email.message'));
        }
    }
    
    /**
     * Ajax Forgot Password Post
     * @param  array
     * @return message
     */
    public function postAjaxForgotPassword() {
        if (\Input::has('email')) {
            try {
                $user = \App\Http\Models\Profiles::where('Email', '=', \Input::get('email'))->first();
                if (!is_null($user) && count($user) > 0) {
                    if ($user->Status == 0) {
                        echo json_encode(array('type' => 'error', 'message' => trans('messages.user_inactive.message'))); die;
                    }
                    $newpass = substr(dechex(round(rand(0,999999999999999))),0,8);
                    $password = encryptpassword($newpass);
                    $user->Password = $password;
                    $user->save();
                    
                    $userArray = $user->toArray();
                    $userArray['mail_subject'] = 'New password request for your didueat account.';
                    $userArray['new_pass'] = $newpass;
                    $this->sendEMail("emails.forgot", $userArray);
                    
                    echo json_encode(array('type' => 'success', 'message' => 'Your password has been has been reset successfully. We send you an email at ['.$user->Email.']. Please check your inbox for your new password. If you still face difficulties please contact us. thanks')); die;
                } else {
                    echo json_encode(array('type' => 'error', 'message' => trans('messages.user_email_not_verify.message'))); die;
                }
            } catch (Exception $e) {
                echo json_encode(array('type' => 'error', 'message' => $e->getMessage())); die;
            }
        } else {
            echo json_encode(array('type' => 'error', 'message' => trans('messages.user_missing_email.message'))); die;
        }
    }

    /**
     * Logout
     * @param  null
     * @return redirect
     */
    public function getLogout() {
        \Session::flush();
        return \Redirect::to('auth/login')->with('message', 'You are logout successfully!');
    }

    function test(){
        return view('auth.test', array('title' => 'Testing'));
    }
}
