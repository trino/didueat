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
        $url = 'dashboard';//'auth/login';
        //if (\Input::has('url')) {$url = \Input::get('url');}
        if (\Input::has('email')) {
            try {
                $user = \App\Http\Models\Profiles::where('email', '=', \Input::get('email'))->first();
                if (!is_null($user) && count($user) > 0) {
                    if ($user->status != "active") {
                        return $this->failure2($AsJSON, trans('messages.user_inactive.message'), $url);
                    }

                    $password = encryptpassword(\Input::get('password'));
//                    debugprint($password . " = " . $user->password);

                    if ($password == $user->password) {
                        $gmt = \Input::get('gmt');
                        edit_database("profiles", "id", $user->id, array("gmt" => $gmt));//update time zone
                        $user->gmt = $gmt;
                        login($user, false);
                        if($AsJSON) {
                            die();
                        } else {
                            die();
                            return redirect()->intended('dashboard');
                        }
                    } else {
                        return $this->failure2($AsJSON, trans('messages.user_login_invalid.message') , $url);
                    }
                } else {
                    return $this->failure2($AsJSON, trans('messages.user_not_registered.message') , $url);
                }
            } catch (Exception $e) {
                return $this->failure2($AsJSON, handleexception($e), $url);
            }
        } else {
            return $this->failure2($AsJSON, trans('messages.user_missing_email.message') , $url);
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
            if($redir == 'auth/login'){
                return $message;
            } else {
                return json_encode(array('type' => 'error', 'message' => $message));
            }
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
        $email_verification = false;
        if (isset($data) && count($data) > 0 && !is_null($data)) {//check for missing data
            if (!isset($data['email']) || empty($data['email'])) {
                return $this->failure2($AsJSON, trans('messages.user_missing_email.message'));
            }
            $is_email = \App\Http\Models\Profiles::where('email', '=', $data['email'])->count();
            if ($is_email > 0) {
                return $this->failure2($AsJSON, trans('messages.user_email_already_exist.message'));
            }
            if (!isset($data['password']) || empty($data['password'])) {
                return $this->failure2($AsJSON, trans('messages.user_pass_field_missing.message') . " (0x04)");
            }
            /*
            if (!isset($data['confirm_password']) || empty($data['confirm_password'])) {
                return $this->failure2($AsJSON, trans('messages.user_confim_pass_field_missing.message'));
            }
            if (trim($data['password']) != trim($data['confirm_password'])) {
                return $this->failure2($AsJSON, trans('messages.user_passwords_mismatched.message'));
            } else {
            */
            if(true){
                \DB::beginTransaction();
                try {//add new user to the database
                    $user = $this->registeruser($data);

                    $message['title'] = "Registration Success. Welcome to " . DIDUEAT . "!";
                    $message['msg_type'] = "success";
                    $message['msg_desc'] = "Thank you for creating an account with " . DIDUEAT . ".";
                    if($email_verification) {
                        $message['msg_desc'] .= "A confirmation email has been sent to your email address [$user->email]. Please verify the link. If you didn't find the email from us, <a href='" . url('auth/resend_email/' . base64_encode($user->email)) . "'><b>click here</b></a> to resend the confirmation email. Thank you.";
                    }
                    if($AsJSON) {
                        echo json_encode(array('type' => $message['msg_type'], 'message' => $message['msg_desc']));
                        die;
                    }
                    return view('messages.message', $message);
                } catch (\Illuminate\Database\QueryException $e) {
                    \DB::rollback();
                    return $this->failure2($AsJSON, trans('messages.user_email_already_exist.message'));
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
        if($this->validBase64($email)) {$email = base64_decode($email);}
        $user = \App\Http\Models\Profiles::where('email', $email)->first();
        if (isset($user) && count($user) > 0 && !is_null($user)) {
            $userArray = $user->toArray();
            $userArray['mail_subject'] = 'Thank you for registering.';
            $userArray['idd'] = '2';
            $this->sendEMail("emails.registration_welcome", $userArray);
            $message['title'] = "Registration Success";
            $message['msg_type'] = "success";
            $message['msg_desc'] = "Thank you for creating an account with " . DIDUEAT . ". A confirmation email has been sent to your email address (" . $user->email . "). Please verify the link. If you didn't find the email from us, <a id='resendMeEmail' href='" . url('auth/resend_email/ajax/' . base64_encode($user->email)) . "'><b>click here</b></a> to resend the confirmation email. Thank you.";
        } else {
            $message['title'] = "Email verification";
            $message['msg_type'] = "error";
            $message['msg_desc'] = "Invalid code found. Please <a href='#login-pop-up' class='fancybox-fast-view'><b>click here</b></a> to login.";
        }
        if($AsJSON){
            echo json_encode(array('type' => $message['msg_type'], 'message' => $message['msg_desc']));
            die;
        } else {
            return view('messages.message', array_merge($userArray, $message));
        }
    }

    function validBase64($string){
        $decoded = base64_decode($string, true);// Check if there is no invalid character in strin
        if (!preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $string)) return false;// Decode the string in strict mode and send the responce
        if(!base64_decode($string, true)) return false;// Encode and compare it to origional one
        if(base64_encode($decoded) != $string) return false;
        return true;
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
            $user->status = 'active';
            $user->is_email_varified = 1;
            $user->save();

            login($user);

            $message['title'] = "Email verification";
            $message['msg_type'] = "success";
            //$message['msg_desc'] = "Thank you for activate your account with didueat.com. Your email has been confirmed successfully. Please <a href='#login-pop-up' class='fancybox-fast-view'><b>click here</b></a> to login.";
            $message['msg_desc'] = "Thank you for activating your account with " . DIDUEAT . ". Your email has been confirmed successfully. You have been logged in into our system. Please <a href='#login-pop-up' class='fancybox-fast-view'><b>click here</b></a> to change your info. ";
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
                $user = \App\Http\Models\Profiles::where('email', \Input::get('email'))->first();
                if (!is_null($user) && count($user) > 0) {
                    if ($user->status == "") {
                        return $this->failure2($AsJSON ,trans('messages.user_inactive.message'), 'auth/forgot-password');
                    }

                    $newpass = substr(dechex(round(rand(0, 999999999999999))), 0, 8);
                    $user->password = encryptpassword($newpass);;
                    $user->save();

                    $userArray = $user->toArray();
                    $userArray['mail_subject'] = 'New password request for your ' . DIDUEAT . ' account.';
                    $userArray['new_pass'] = $newpass;
                    $this->sendEMail("emails.forgot", $userArray);

                    $message['title'] = "Forgot Password";
                    $message['msg_type'] = "Password Emailed";
                    $message['msg_desc'] = "Your password has been has been reset successfully. We sent an email to [<span style='color:#0000FF'>$user->email</span>]. Please check your inbox for your new password. If you still have any difficulties please contact us. Thank you";
                    if($AsJSON){
                        echo json_encode(array('type' => $message['msg_type'], 'message' => $message['msg_desc']));
                        die;
                    }
                    return view('messages.message', $message);
                } else {
                    return $this->failure2($AsJSON, trans('messages.user_email_not_verify.message'), 'auth/forgot-password');
                }
            } catch (Exception $e) {
                return $this->failure2($AsJSON, handleexception($e), 'auth/forgot-password');
            }
        } else {
            return $this->failure2($AsJSON, trans('messages.user_missing_email.message'), 'auth/forgot-password');
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
    public function postAjaxValidateEmail($CurrentUser = 0) {
        if (\Input::has('email')) {
            try {
                $user = is_email_in_use(\Input::get('email'), $CurrentUser);
                //$user = \App\Http\Models\Profiles::where('email', \Input::get('email'))->count();
                echo iif($user, "false", "true");//false if is in use, and can't use this email address. True if not in use and can use it
                die;
            } catch (Exception $e) {
                echo json_encode(array('type' => 'error', 'message' => handleexception($e)));
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
