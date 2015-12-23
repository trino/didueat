<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //sends an email using a template
    public function sendEMail($template_name = "", $array = array()) {
        \Mail::send($template_name, $array, function ($messages) use ($array) {
            $messages->to($array['email'])->subject($array['mail_subject']);
        });
    }

    public function __construct() {
        $this->beforeFilter(function () {
            initialize("cont");
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
}
