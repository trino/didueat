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
        \Mail::send($template_name, $array, function ($messages) use ($array) {
            $messages->to($array['email'])->subject($array['mail_subject']);
        });
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

    //makes a thumbnail of an image
    public function make_thumb($filename, $new_width, $new_height, $CropToFit = false){
        $output_filename = getdirectory($filename) . "/" . getfilename($filename) . "(" . $new_width . "x" . $new_height . ")." . getextension($filename);
        make_thumb($filename, $output_filename, $new_width, $new_height, $CropToFit);
        return $output_filename;
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
            echo $e->getMessage();
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
