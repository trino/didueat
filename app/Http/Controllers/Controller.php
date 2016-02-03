<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct() {
        $this->beforeFilter(function () {
            initialize("cont");
        });
    }
    
    //sends an email using a template
    public function sendEMail($template_name = "", $array = array()) {
        if(isset($array["message"])){die("array[message] is reserved and cannot be used!!!");}
        if(is_array($array['email'])){
            $emails = $array['email'];
            foreach($emails as $email){
                $array["email"] = $email;
                $this->sendEMail($template_name, $array);
            }
        } else {
            \Mail::send($template_name, $array, function ($messages) use ($array) {
                $messages->to($array['email'])->subject($array['mail_subject']);
            });
        }
    }

    //automates the flash/flash with input and redirect for the success condition
    public function success($message, $redirect, $withInput = false){
        return $this->failure($message, $redirect, $withInput, 'alert-success', 'Congratulations!');
    }

    //automates the flash/flash with input and redirect for the failure condition
    public function failure($message, $redirect, $withInput = false, $type = 'alert-danger', $title = 'Oops!'){
        \Session::flash('message', $message);
        \Session::flash('message-type', $type);
        \Session::flash('message-short', $title);
        if($withInput) {
            return \Redirect::to($redirect)->withInput();
        }
        return \Redirect::to($redirect);
    }

    public function registeruser($SourceFunction, $post=false, $profile_type=2, $restaurantid=0, $browser_info=false, $createdby = false, $login = true){
        $email_verification = false;
        if(!$post){
            $post = \Input::all();
        }
        if(!$browser_info) {
            $browser_info = getBrowser();
        }

        if($createdby){
            $post['created_by'] = \Session::get('session_id');
        }

        $profile['restaurant_id'] = $restaurantid;
        $profile['profile_type'] = $profile_type;  // restaurant
        if(!isset($post['ordered_by'])){$post['ordered_by']=0;}
        $profile['name'] = $post['ordered_by'];
        $profile['email'] = $post['email'];
        if(isset($post['phone'])) {$profile['phone'] = $post['phone'];}
        if(isset($post['mobile'])) {$profile['mobile'] = $post['mobile'];}
        $profile['password'] = $post['password'];
        $profile['subscribed'] = (isset($post['subscribed'])) ? $post['subscribed'] : 0;
        $profile['is_email_varified'] = iif($email_verification, 0, 1);
        $browser_info = getBrowser();
        $profile['ip_address'] = get_client_ip_server();
        $profile['browser_name'] = $browser_info['name'];
        $profile['browser_version'] = $browser_info['version'];
        $profile['browser_platform'] = $browser_info['platform'];
        if(isset($_POST['gmt']))
        $profile['gmt'] = $post['gmt'];
        $profile['status'] = 'active';

        $user = new \App\Http\Models\Profiles();
        $user->populate($profile);
        $user->save();

        event(new \App\Events\AppEvents($user, "User Created"));

        if(isset($post['formatted_addressForDB']) && isset($post['formatted_address'])) {
            $post["user_id"] = $user->id;
            $post["formatted_address"] = $post['formatted_addressForDB'];
            $post['address'] = $post['formatted_address'];
            \App\Http\Models\ProfilesAddresses::makenew($post);
        }
        if($user->id && $login){
            login($user->id);
        }

        $userArray = $user->toArray();
        $userArray['mail_subject'] = 'Thank you for your registration at DidUEat.';
        $userArray['idd'] = '4';//why?
        $this->sendEMail("emails.registration_welcome", array_merge($profile, $userArray));
        \DB::commit();

        return $user;
    }

    /**
     * Credit Card Sequence Change
     * @param none
     * @return response
     */
    public function saveSequence($modal = '') {
        $post = \Input::all();
        try {
            //splits $_POST["id"] into $idArray and $_POST["order"] into $orderArray, by the "|" character
            $idArray = explode("|", $post['id']);
            $orderArray = explode("|", $post['order']);
            
            //uses $idArray as the keys ($id), and $orderArray as the values ($order)
            foreach ($idArray as $key => $value) {
                $id = $value;
                $order = $orderArray[$key];
                //search for credit cards by $id and set it's order to $order
                $ob = $modal::find($id);
                $ob->order = $order;
                $ob->save();
            }

        } catch (\Exception $e) {
            echo handleexception($e);
        }
    }

    //convert text to a slug
    function createslug($text) {
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        if (empty($text)) {
            return 'n-a';
        }
        //test for same slug in db
        $text = $this->chkSlug($text);


        return $text;
    }

    //checks if a slug is in use, if it is, randomize it
    function chkSlug($txt) {
        if (\App\Http\Models\Restaurants::where('slug', $txt)->first()) {
            $txt = $this->chkSlug($txt . rand(0, 999));
        }
        return $txt;
    }

    //sanitize time data
    public function cleanTime($time) {
        if (strpos($time, ":") === false) {
            if(!is_numeric($time)){
                return "12:00:00";
            }
            return gmdate("H:i:s", $time);
        }
        if (!$time) {
            return $time;
        }
        if (strpos($time, "AM") !== false) {
            $suffix = 'AM';
        } else {
            $suffix = 'PM';
        }
        $time = str_replace(array(' AM', ' PM'), array('', ''), $time);

        $arr_time = explode(':', $time);
        $hour = $arr_time[0];
        $min = $arr_time[1];
        $sec = '00';

        if ($hour < 12 && $suffix == 'PM') {
            $hour = $hour + 12;
        }
        return $hour . ':' . $min . ':' . $sec;
    }
}
