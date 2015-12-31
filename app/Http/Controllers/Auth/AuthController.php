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
     * handles email address/password based login
     * @param  null
     * @return view
     */
    public function authenticate($AsJSON = false) {
        if (\Input::has('email')) {
            try {
                $user = \App\Http\Models\Profiles::where('email', '=', \Input::get('email'))->first();
                if (!is_null($user) && count($user) > 0) {
                    if ($user->status == 0) {
                        return $this->failure2($AsJSON, trans('messages.user_inactive.message') , 'auth/login');
                    }
                    $password = \Input::get('password');
                    if (\Hash::check($password, $user->password)) {
                        login($user);
                        if($AsJSON) {
                            die();
                        } else {
                            return redirect()->intended('dashboard');
                        }
                    } else {
                        return $this->failure2($AsJSON, trans('user_login_invalid.user_inactive.message') , 'auth/login');
                    }
                } else {
                    return $this->failure2($AsJSON, trans('user_login_invalid.user_not_registered.message') , 'auth/login');
                }
            } catch (Exception $e) {
                return $this->failure2($AsJSON, handleexception($e), 'auth/login');
            }
        } else {
            return $this->failure2($AsJSON, trans('user_login_invalid.user_missing_email.message') , 'auth/login');
        }
    }

    /**
     * alias of authenticate, but by AJAX
     * @param  null
     * @return view
     */
    public function authenticateAjax() {
        return $this->authenticate(true);
    }

    /**
     * Registration page
     * @param  null
     * @return view
     */
    public function getRegister() {
        return view('auth.register', array('title' => 'Register Page'));
    }

    function failure2($AsJSON, $message, $redir = 'auth/register'){
        if ($AsJSON){
            echo json_encode(array('type' => 'error', 'message' => $message));
            die;
        }
        return $this->failure($message, $redir, true);
    }

    /**
     * handles user registration
     * @param  array
     * @return redirect
     */
    public function postRegister($AsJSON = false) {
        $data = \Input::all();
        if (isset($data) && count($data) > 0 && !is_null($data)) {//check for missing data
            if (!isset($data['email']) || empty($data['email'])) {
                return $this->failure2($AsJSON, trans('messages.user_missing_email.message'));
            }
            $is_email = \App\Http\Models\Profiles::where('email', '=', $data['email'])->count();
            if ($is_email > 0) {
                return $this->failure2($AsJSON, trans('messages.user_email_already_exist.message.message'));
            }
            if (!isset($data['password']) || empty($data['password'])) {
                return $this->failure2($AsJSON, trans('messages.user_pass_field_missing.message.message'));
            }
            if (!isset($data['confirm_password']) || empty($data['confirm_password'])) {
                return $this->failure2($AsJSON, trans('messages.user_confim_pass_field_missing.message.message'));
            }
            if ($data['password'] != $data['confirm_password']) {
                return $this->failure2($AsJSON, trans('messages.user_passwords_mismatched.message.message'));
            } else {
                \DB::beginTransaction();
                try {//add new user to the database
                    $data['status'] = 1;
                    $data['is_email_varified'] = 0;
                    $data['profile_type'] = 2;

                    $user = new \App\Http\Models\Profiles();
                    $user->populate(array_filter($data));
                    $user->save();

                    if($user->id){
                        if($this->saveaddress($data)) {
                            $add = new \App\Http\Models\ProfilesAddresses();
                            $data['user_id'] = $user->id;
                            $add->populate(array_filter($data));
                            $add->save();
                        }
                    }

                    $userArray = $user->toArray();
                    $userArray['mail_subject'] = 'Thank you for registration.';
                    $this->sendEMail("emails.registration_welcome", $userArray);
                    \DB::commit();

                    //$this->saveaddress($user->id, $data);

                    $message['title'] = "Registration Success";
                    $message['msg_type'] = "success";
                    $message['msg_desc'] = "Thank you for creating an account with DidUEat.com. A confirmation email has been sent to your email address [$user->email]. Please verify the link. If you didn't find the email from us, <a href='" . url('auth/resend_email/' . base64_encode($user->email)) . "'><b>click here</b></a> to resend the confirmation email. Thank you.";

                    if($AsJSON) {
                        echo json_encode(array('type' => $message['msg_type'], 'message' => $message['msg_desc']));
                        die;
                    }
                    return view('messages.message', $message);
                } catch (\Illuminate\Database\QueryException $e) {
                    \DB::rollback();
                    return $this->failure2($AsJSON, trans('messages.user_email_already_exist.message.message'));
                } catch (\Exception $e) {
                    \DB::rollback();
                    return $this->failure2($AsJSON, handleexception($e));
                }
            }
        } else {
            return $this->failure2($AsJSON, trans('messages.user_invalid_data_parse.message'));
        }
    }

    /**
     * alias of postRegister, by ajax
     * @param  array
     * @return redirect
     */
    public function postAjaxRegister() {
        return $this->postRegister(true);//
    }

    public function saveaddress($data){
        $fields = array("formatted_address");//, "address", "postal_code", "phone", "country", "province", "city");
        foreach($fields as $field){
            if(!isset($data[$field]) || !$data[$field]){
                return false;
            }
        }
        return true;
    }


    /**
     * Ajax Resend Activation email
     * @param  $id
     * @return message
     */
    public function resendPostEmail($email = 0) {
        return $this>resendEmail($email, true);
    }

    /**
     * Resend Activation email
     * @param  $id
     * @return message
     */
    public function resendEmail($email = 0, $AsJSON = false) {
        $email = base64_decode($email);
        $user = \App\Http\Models\Profiles::where('email', $email)->first();

        if (isset($user) && count($user) > 0 && !is_null($user)) {
            $userArray = $user->toArray();
            $userArray['mail_subject'] = 'Thank you for registering.';
            $this->sendEMail("emails.registration_welcome", $userArray);
            $message['title'] = "Registration Success";
            $message['msg_type'] = "success";
            $message['msg_desc'] = "Thank you for creating an account with DidUEat.com. A confirmation email has been sent to your email address [" . $user->email . "]. Please verify the link. If you didn't find the email from us, <a id='resendMeEmail' href='" . url('auth/resend_email/ajax/' . base64_encode($user->email)) . "'><b>click here</b></a> to resend the confirmation email. Thank you.";
        } else {
            $message['title'] = "Email verification";
            $message['msg_type'] = "error";
            $message['msg_desc'] = "Invalid code found. Please <a href='#login-pop-up' class='fancybox-fast-view'><b>click here</b></a> to login.";
        }
        if($AsJSON){
            echo json_encode(array('type' => $message['msg_type'], 'message' => $message['msg_desc']));
            die;
        } else {
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
        $count = \App\Http\Models\Profiles::where('email', $email)->where('is_email_varified', 1)->count();
        $user = \App\Http\Models\Profiles::where('email', $email)->first();

        if ($count > 0) {
            $message['title'] = "Email verification";
            $message['msg_type'] = "error";
            $message['msg_desc'] = "Your account has been verified already. Please <a href='#login-pop-up' class='fancybox-fast-view'><b>click here</b></a> to login.";
            return view('messages.message', $message);
        }

        if (isset($user) && count($user) > 0 && !is_null($user)) {
            $user->status = 1;
            $user->is_email_varified = 1;
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
    public function forgotPassword() {
        return view('auth.forgot', array('title' => 'Forgot Password'));
    }

    /**
     * Forgot Password Post
     * @param  array
     * @return message
     */
    public function postForgotPassword($AsJSON = false) {
        if (\Input::has('email')) {
            try {
                $user = \App\Http\Models\Profiles::where('email', '=', \Input::get('email'))->first();
                if (!is_null($user) && count($user) > 0) {
                    if ($user->status == 0) {
                        return $this->failure2($AsJSON ,trans('messages.user_inactive.message'), 'auth/forgot-passoword');
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
                    if($AsJSON){
                        echo json_encode(array('type' => $message['msg_type'], 'message' => $message['msg_desc']));
                        die;
                    }
                    return view('messages.message', $message);
                } else {
                    return $this->failure2(trans($AsJSON, 'messages.user_email_not_verify.message'), 'auth/forgot-passoword');
                }
            } catch (Exception $e) {
                return $this->failure2($AsJSON, handleexception($e), 'auth/forgot-passoword');
            }
        } else {
            return $this->failure2($AsJSON, trans('messages.user_missing_email.message'), 'auth/forgot-passoword');
        }
    }

    /**
     * alias of Ajax Forgot Password via Post
     * @param  array
     * @return message
     */
    public function postAjaxForgotPassword() {
        return $this->postForgotPassword(true);
    }
    
    /**
     * Validate Unique Email
     * @param  $email
     * @return string
     */
    public function postAjaxValidateEmail() {
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
    public function getLogout() {
        \Session::flush();
        return $this->success(trans('messages.user_logout.message'), '/');
    }
}
