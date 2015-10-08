<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function sendEMail($template_name="", $array=array()) {
        \Mail::send($template_name, $array, function($messages) use ($array) {
            $messages->to($array['email'])->subject($array['mail_subject']);
        });
    }

    public function __construct() {
        $this->beforeFilter(function() {
            initialize("cont");
        });
    }
}
