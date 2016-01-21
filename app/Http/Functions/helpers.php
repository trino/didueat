<?php

define("MAX_DELIVERY_DISTANCE", 30);

function asmoney($value){
    return "$" . number_format($value, 2);
}

function message_show($msgtype, $description) {
    if ($msgtype != "" && $description != "") {
        return '<script type="text/javascript">
                    Command: toastr["success"]("' . $description . '", "' . $msgtype . '")
                    toastr.options = {
                      "closeButton": true,
                      "debug": false,
                      "newestOnTop": true,
                      "progressBar": true,
                      "positionClass": "toast-top-left",
                      "preventDuplicates": false,
                      "showDuration": "300",
                      "hideDuration": "1000",
                      "timeOut": "5000",
                      "extendedTimeOut": "1000",
                      "showEasing": "swing",
                      "hideEasing": "linear",
                      "showMethod": "fadeIn",
                      "hideMethod": "fadeOut"
                    }
            </script>';
    }
}

function getweekdays(){
    return array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
}

/**
 * Pagination of the resource.
 *
 * @return Response
 */
function getPagination($recCount, $no_of_paginations, $cur_page, $first_btn, $last_btn, $previous_btn, $next_btn) {
    $html = "";
    /* -----Calculating the starting and endign values for the loop----- */
    if ($cur_page >= 7) {
        $start_loop = $cur_page - 3;
        if ($no_of_paginations > $cur_page + 3)
            $end_loop = $cur_page + 3;
        else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6) {
            $start_loop = $no_of_paginations - 6;
            $end_loop = $no_of_paginations;
        } else {
            $end_loop = $no_of_paginations;
        }
    } else {
        $start_loop = 1;
        if ($no_of_paginations > 7) {
            $end_loop = 7;
        } else {
            $end_loop = $no_of_paginations;
        }
    }

    $html .= '<div class="pull-right">';
    $html .= '<div class="dataTables_paginate paging_bs_normal" id="datatable1_paginate">';
    $html .= '<ul class="pagination">';

    if ($first_btn && $cur_page > 1) {
        $html .= '<li p="1" class="first prev page-item  clickable"><a href="#"   class="page-link" >First</a></li>';
    } else if ($first_btn) {
        $html .= '<li p="1" class="first prev page-item  disabled"><a  class="page-link" >First</a></li>';
    }

    if ($previous_btn && $cur_page > 1) {
        $pre = $cur_page - 1;
        $html .= '<li p=' . $pre . ' class="prev page-item  clickable"><a href="#"   class="page-link" >Previous</a></li>';
    } else if ($previous_btn) {
        $html .= '<li class="prev disabled page-item "><a  class="page-link" >Previous</a></li>';
    }

    for ($i = $start_loop; $i <= $end_loop; $i++) {
        if ($cur_page == $i) {
            $html .= '<li p=' . $i . ' class="active page-item "><a  class="page-link" >' . $i . '</a></li>';
        } else {
            $html .= '<li p=' . $i . ' class="clickable page-item " ><a href="#"   class="page-link" >' . $i . '</a></li>';
        }
    }

    // TO ENABLE THE NEXT BUTTON
    if ($next_btn && $cur_page < $no_of_paginations) {
        $nex = $cur_page + 1;
        $html .= '<li p=' . $nex . ' class="next clickable page-item "><a href="#"   class="page-link"  >Next</a></li>';
    } else if ($next_btn) {
        $html .= '<li class="next disabled page-item "><a  class="page-link" >Next</a></li>';
    }

    // TO ENABLE THE END BUTTON
    if ($last_btn && $cur_page < $no_of_paginations) {
        $html .= '<li p=' . $no_of_paginations . ' class="page-item last next clickable"><a href="#"   class="page-link" >Last</a></li>';
    } else if ($last_btn) {
        $html .= '<li p=' . $no_of_paginations . ' class="page-item last next disabled"><a  class="page-link" >Last</a></li>';
    }

    $html .= '</ul>';
    $html .= '</div>';
    $html .= '</div>';

    $html .= '<div class="pull-left">';
    if (!$no_of_paginations) {
        $cur_page = 0;
    }
    $html .= '<div ><p class="" a="' . $no_of_paginations . '">Total Records ' . $recCount . '. Showing Page ' . $cur_page . ' of ' . $no_of_paginations . '</p><div>';
    $html .= '</div>';

    return $html;
}

function includeJS($URL, $options = "") {
    $Short = $URL;
    $Start = strpos($Short, "?");
    if ($Start !== false) {
        $Short = left($Short, $Start);
    }
    if (!isset($GLOBALS["jsfiles"][$Short])) {
        echo '<script src="' . $URL . '" ' . $options . '></script>';
        $GLOBALS["jsfiles"][$Short] = true;
        return true;
    }
}

function areacodes() {
    return array(
        "AB" => array(403 => "S Alberta", 587 => "Province-wide", 780 => "N Alberta (Edmonton)", 825 => "Province-wide"),
        "BC" => array(236 => "Province-wide", 250 => "Vancouver Island & Mainland excl. Lower Mainland", 604 => "Lower Mainland (Vancouver)", 778 => "Province-wide"),
        "MB" => array(204 => "Province-wide", 431 => "Province-wide"),
        "NB" => array(506 => "Province-wide"),
        "NL" => array(709 => "Province-wide"),
        "ON" => array(226 => "SW Ontario (Windsor, London, Waterloo)", 249 => "NE Ontario", 289 => "S Ontario", 343 => "E Ontario (Ottawa)", 365 => "S Ontario", 416 => "Toronto", 437 => "Toronto", 519 => "SW Ontario (Windsor, London, Waterloo)", 548 => "SW Ontario (Windsor, London, Waterloo)", 613 => "E Ontario (Ottawa)", 647 => "Toronto", 705 => "NE Ontario", 807 => "NW Ontario", 905 => "S Ontario"),
        "QC" => array(418 => "NE Quebec (Quebec City)", 438 => "Montreal", 450 => "S Quebec", 514 => "Montreal", 579 => "S Quebec", 581 => "NE Quebec (Quebec City)", 819 => "NW Quebec", 873 => "NW Quebec"),
        "SK" => array(306 => "Province-wide", 639 => "Province-wide"),
        "MULTI" => array(782 => "Nova Scotia & Prince Edward Island (NS,PE)", 867 => "Northwest Territories, Nunavut & Yukon (NT,NU,YT)", 902 => "Nova Scotia & Prince Edward Island (NS,PE)")
    );
}

function qualifyareacode($phone) {
    //$phone = preg_replace("/[^0-9]/", "", $phone);
    //if(left($phone,1) == 0 || left($phone,1) == 1){$phone = right($phone, strlen($phone)-1);}
    $phone = left($phone, 3);
    foreach (areacodes() as $acronym => $province) {
        foreach ($province as $areacode => $district) {
            if ($areacode == $phone) {
                return array("province" => $acronym, "areacode" => $areacode, "district" => $district);
            }
        }
    }
    return false;
}

function phonenumber($phone, $qualifyareacode = true) {
    $phone = preg_replace("/[^0-9]/", "", $phone); // note: strip out everything but numbers
    if (left($phone, 1) == 0 || left($phone, 1) == 1) {
        $phone = right($phone, strlen($phone) - 1);
    }
    if (strlen($phone) == 10) {
        if ($qualifyareacode) {
            if (!qualifyareacode($phone)) {
                return "";
            }
        }
        return $phone;
        //return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $phone);
    }
}

function newrow($new = false, $name = false, $class = "", $Required = false,$columns = 9, $labelStr = "") {
    $id = str_replace(" ", "_", strtolower($name)) . "_label";
    if($Required){$Required = " required";}
    if ($new) {
        return '<div class="col-md-12 col-sm-12 col-xs-12"><div class="form-group ' . $class . '"><label class="control-label' . $Required . '" id="' . $id . '"><b>' . $name . ':</b></label><BR>' . $labelStr;
    } else if ($name && ($labelStr=="" || !$labelStr)) {
        return '<div class="form-group row editaddress ' . $class . '"><label class="col-sm-3 text-xs-right' . $Required . '" id="' . $id . '"><b>' . $name . ':</b></label><div class="col-sm-' . $columns . '">';
    } else if ($labelStr!="" && !$labelStr) {
        return '<div class="form-group row editaddress ' . $class . '"><label class="col-sm-3 text-xs-right' . $Required . '" id="' . $id . '">' . $labelStr .  '</label><div class="col-sm-' . $columns . '">';
    } elseif($labelStr){
        return '<div class="form-group row editaddress ' . $class . '"><div class="col-sm-' . $columns . '">';
    } else {
        return '</div></div>';
    }
}

function fontawesome($profiletype, $icontype=0){
    switch($icontype){
        case 0://user types
            switch($profiletype){
                case 1: $icon = "user-secret"; break;//super
                case 2: $icon = "shopping-basket"; break;//user
                case 3: $icon = "user-plus"; break;//owner
                case 4: $icon = "user"; break;//employee
            }
    }
    if(isset($icon) && $icon){
        echo '<i class="fa fa-' . $icon . '"></i>';
    }
}

function handleexception($e) {
    $Message = $e->getMessage();
    if (debugmode()) {
        $Message .= "<BR>File " . $e->getFile() . " Line " . $e->getLine();
        debugprint($Message . "\r\n Trace " . $e->getTraceAsString());
    }
    return $Message;
}

//starts listening for SQL queries
function initialize($Source = "") {
    DB::enableQueryLog();
    handle_action();
}

//encodes text to a URL-compatible string
function Encode($str) {
    return trim(htmlentities(addslashes($str)));
}

//decodes a URL-compatible string back to text
function Decode($str) {
    return html_entity_decode(stripslashes($str));
}

//allows you to call a function from another controller
function call($controller, $action, $parameters = array()) {
    $app = app();
    $controller = $app->make($controller);
    return $controller->callAction($app, $app['router'], $action, $parameters);
}

function handle_action($Action = "") {
    //http://localhost/didueat/public/restaurant/users?action=test
    if (!$Action) {
        $Action = getpost("action");
    }
    if ($Action) {
        switch ($Action) {
            case "test":

                $ob = new \App\Http\Models\Hours();
                $Test = $ob->get_restaurant(1);

                //$Test = call("UsersController", "test");
                //$Test = App::make('UsersController')->test();
                //$Test = \App\Http\Controllers\UsersController::test();//static method in a model
                debug($Test);
                die();

                break;
            case "user_possess":
                login(getpost("ID"));
                break;
            case "user_fire":
                hire_employee(getpost("ID"), 0, 999);
                break;

            default:
            //echo $Action . " is unhandled";
            //die();
        }
    }
    return false;
}

//count orders
function countOrders($type = 'pending') {
    return DB::table('reservations')->where('status', $type)->count();
}

//returns an array of all the profile types with a hierarchy above $Hierarchy
function enum_profiletypes($Hierarchy = "", $toArray = true) {
    $Condition = "1=1";
    if ($Hierarchy) {
        $Condition = "Hierarchy > " . $Hierarchy;
    }
    $entries = enum_all("profiletypes", $Condition);
    if ($toArray) {
        return my_iterator_to_array($entries, "id", "name");
    }
    return $entries;
}

function webroot($Local = false) {
    if ($Local) {
        return app_path() . "/";
    }
    return URL::to('/');
}

////////////////////////////////////Profile API/////////////////////////////////////////
//read from session
function read($Name) {
    if (\Session::has('session_' . $Name)) {
        return \Session::get('session_' . $Name);
    }
}

//write to session
function write($Name, $Value, $Save = false) {
    \Session::put('session_' . $Name, $Value);
    if ($Save) {
        \Session::save();
    }
}

//returns the salt used for MD5ing
function salt() {
    return "18eb00e8-f835-48cb-bbda-49ee6960261f";
}

//enumerate all profiles
function enum_profiles($Key, $Value) {
    return enum_all('profiles', array($Key => $Value));
}

//get a specific profile, if not specified it will get the current user's profile
function get_profile($ID = "") {
    if (!$ID) {
        $ID = read("ID");
    }
    return get_entry("profiles", $ID);
}

//check if the email address is in use by someone who is not $NotByUserID
function is_email_in_use($EmailAddress, $NotByUserID = 0) {
    $EmailAddress = clean_email($EmailAddress);
    if ($NotByUserID) {
        return first("SELECT * FROM profiles WHERE Email = '" . $EmailAddress . "' AND ID != " . $NotByUserID);
    } else {
        return get_entry("profiles", $EmailAddress, "email");
    }
}

//gets a profile type
//if $GetByType is true: it gets the profile type specified by $ProfileID
//otherwise it gets the profile type of the user specified by $ProfileID
function get_profile_type($ProfileID = false, $GetByType = false) {
    if (!$ProfileID && $GetByType) {
        $ProfileID = get_entry("profiles", read("ID"), "id")->profile_type;
    }
    if ($GetByType) {
        return get_entry("profiletypes", $ProfileID);
    }
    if (!$ProfileID) {
        $ProfileID = read("ID");
    }
    if (!$ProfileID) {
        return -1;
    }
    $profiletype = get_entry("profiles", $ProfileID, "id");
    if ($profiletype) {
        $profiletype = $profiletype->profile_type;
        return get_entry("profiletypes", $profiletype);
    }
}

function get_date_format() {
    return "M d, Y h:i A";
}

//generates a random password of $Length digits
function randomPassword($Length = 8) {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = "";
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < $Length; $i++) {
        $n = rand(0, $alphaLength);
        $pass .= $alphabet[$n];
    }
    return $pass;
}

//checks if $EmailAddress is valid, returns it if it is. otherwise returns nothing
function is_valid_email($EmailAddress) {
    //http://php.net/manual/en/function.filter-var.php
    //filter_var can also validate: FILTER_VALIDATE_IP FILTER_VALIDATE_INT FILTER_VALIDATE_BOOLEAN FILTER_VALIDATE_URL FILTER_SANITIZE_STRING
    //flags FILTER_NULL_ON_FAILURE FILTER_FLAG_PATH_REQUIRED FILTER_FLAG_STRIP_LOW FILTER_FLAG_STRIP_HIGH
    $EmailAddress = clean_email($EmailAddress);
    if ($EmailAddress && filter_var($EmailAddress, FILTER_VALIDATE_EMAIL)) {
        return $EmailAddress;
    }
}

//encrypts the password using salt
function encryptpassword($Password) {
    return \crypt($Password, salt());
}

//login as a specific profile
function login($Profile, $IsPossessing = false) {
    if (is_numeric($Profile)) {
        $Profile = get_profile($Profile);
    } else if (is_array($Profile)) {
        $Profile = (object) $Profile;
    }

    \Session::forget('session_oldid');
    if ($IsPossessing) {
        write("oldid", read("id"));
    }

    write('ID', $Profile->id);
    write('Name', $Profile->name);
    write('Email', $Profile->email);
    write('Type', $Profile->profile_type);
    write('Restaurant', $Profile->restaurant_id);

    if ($Profile->profile_type == 1) {
        \Session::put('session_type_user', 'super');
    } else if ($Profile->profile_type == 2) {
        if ($Profile->restaurant_id) {
            \Session::put('session_type_user', 'restaurant');
        } else {
            \Session::put('session_type_user', 'user');
        }
    }

    \Session::put('session_id', $Profile->id);
    \Session::put('session_profiletype', $Profile->profile_type);
    \Session::put('session_name', $Profile->name);
    \Session::put('session_email', $Profile->email);
    \Session::put('session_phone', select_field("profiles_addresses", "user_id", $Profile->id, "phone"));
    \Session::put('session_subscribed', $Profile->subscribed);
    \Session::put('session_restaurant_id', $Profile->restaurant_id);
    \Session::put('session_createdBy', $Profile->created_by);
    \Session::put('session_status', $Profile->status);
    \Session::put('session_created_at', $Profile->created_at);
    \Session::put('session_photo', $Profile->photo);
    \Session::put('session_gmt', $Profile->gmt);

    \Session::put('is_logged_in', true);
    \Session::save();
    return $Profile->id;
}

//gets the restaurant of the current user
function get_current_restaurant() {
    $Profile = read('id');
    if ($Profile) {
        if (isset($_GET["restaurant_id"])) {
            $ProfileType = get_profile_type($Profile);
            if ($ProfileType->can_edit_global_settings) {
                return $_GET["restaurant_id"];
            }
        }
        return get_profile($Profile)->restaurant_id;
    }
}

function current_day_of_week(){
    return jddayofweek( cal_to_jd(CAL_GREGORIAN, date("m"),date("d"), date("Y")) , 1 );
}

//check if a profile has permission to do something, no longer works since the profile type system is now hardcoded instead
function check_permission($Permission, $UserID = "") {
    if (!$UserID) {
        $UserID = read("id");
    }
    if (!$UserID) {
        echo 'You are not logged in';
        die();
    }
    $Permission = strtolower($Permission);
    $PType = get_profile_type($UserID);
    if (isset($PType->$Permission)) {
        return $PType->$Permission;
    }
}

function guidv4() {
    if (function_exists('com_create_guid') === true) {
        return trim(com_create_guid(), '{}');
    }
    $data = openssl_random_pseudo_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

/////////////////////////////////////Date API////////////////////////////////////////
//returns the current date/time
function now() {
    return date("Y-m-d H:i:s");
}

//returns date stamp of a date/time
function parse_date($Date) {
    if (strpos($Date, "-")) {
        return strtotime($Date);
    }
    return $Date;
}

function get_day_of_week($Date) {//0 is sunday, 6=saturday
    return date('w', parse_date($Date));
}

function get_time($Date) {//800
    return date('Gi', parse_date($Date));
}

function get_year($Date) {//2015
    return date('Y', parse_date($Date));
}

function get_month($Date) {//01-12
    return date('m', parse_date($Date));
}

function get_day($Date) {//3 (no leading zero)
    return date('j', parse_date($Date));
}

/////////////////////////////////Event log API////////////////////////////////////
//event logging for security, no longer used
function logevent($Event, $DoRestaurant = true, $restaurant_id = 0) {
    $UserID = read('ID');
    if (!$UserID) {
        $UserID = 0;
        $DoRestaurant = false;
    }
    if ($DoRestaurant) {
        if (!$restaurant_id) {
            $restaurant_id = get_profile($UserID)->restaurant_id;
        }
    }
    $Date = now();
    new_entry("eventlog", "ID", array("userid" => $UserID, "restaurant_id" => $restaurant_id, "date" => $Date, "text" => $Event));
}

//returns the type ID of type string given
function data_type_name($Type) {
    $Values = array("Email Address", "Phone Number", "Postal Code");
    if ($Type < 0 or $Type >= count($Values)) {
        return "Unknown";
    }
    return $Values[$Type];
}

//returns the type ID of the data given
function data_type($Data) {
    if (strpos($Data, "@")) {
        return 0;
    } //email
    if (clean_postalcode($Data)) {
        return 2;
    }//postal code
    if (clean_phone($Data)) {
        return 1;
    } //phone number

    return -1;
}

//cleans/sanitizes data by it's type
function clean_data($Data) {
    switch (data_type($Data)) {
        case -1:
            return trim($Data);
            break;
        case 0:
            return clean_email($Data);
            break;
        case 1:
            return clean_phone($Data);
            break;
        case 2:
            return clean_postalcode($Data);
            break;
    }
}

//check if a table exists in the database
function tableexists($Table, $Column = "") {
    if ($Column) {
        return \Schema::hasColumn($Table, $Column);
    }
    return \Schema::hasTable($Table);
}

//gets an array of columns for a table
//$Ignore an array of columns that will be filtered from the results
//$Full if true, will return more data than just an array of column names
function getColumnNames($Table, $Ignore = "", $Full = false) {
    if (!is_array($Ignore)) {
        $Ignore = array($Ignore);
    }
    if ($Full) {
        $Cols = select_query("SHOW columns FROM " . $Table);
    } else {
        $Cols = \Schema::getColumnListing($Table);
    }
    if (!count($Ignore)) {
        return $Cols;
    }
    $Columns = array();
    foreach ($Cols as $Key => $ColData) {
        if ($Full) {
            $ColumnName = $ColData["Field"];
        } else {
            $ColumnName = $ColData;
        }
        if (!in_array($ColumnName, $Ignore)) {
            $Columns[] = $ColData;
        }
    }
    return $Columns;
}

//sanitize a phone number
function clean_phone($Phone) {
    $Phone = kill_non_numeric($Phone, "+"); //add a check to be sure only the first digit is a +
    if ($Phone != "+") {
        return $Phone;
    }
}

//sanitize an email address
function clean_email($Email) {
    return strtolower(trim($Email));
}

function iif($Value, $True, $False = "") {
    if ($Value) {
        return $True;
    }
    return $False;
}

//sanitize a postal code
function clean_postalcode($PostalCode, $delimeter = " ") {
    $PostalCode = str_replace(" ", "", strtoupper(trim($PostalCode)));
    if (validateCanadaZip($PostalCode)) {
        return left($PostalCode, 3) . $delimeter . right($PostalCode, 3);
    }
}

//check if data is a valid postal code
function validateCanadaZip($PostalCode) {//function by Roshan Bhattara(http://roshanbh.com.np)
    return preg_match("/^([a-ceghj-npr-tv-z]){1}[0-9]{1}[a-ceghj-npr-tv-z]{1}[0-9]{1}[a-ceghj-npr-tv-z]{1}[0-9]{1}$/i", $PostalCode);
}

//write text to royslog.txt
function debugprint($text) {
    $path = "royslog.txt";
    $dashes = "----------------------------------------------------------------------------------------------\r\n";
    if (is_array($text)) {
        $text = print_r($text, true);
    }
    file_put_contents($path, $dashes . str_replace("%dashes%", $dashes, str_replace("<BR>", "\r\n", $text)) . "\r\n", FILE_APPEND);
}

//get the current function and line number
function debug_string_backtrace() {
    $BACK = debug_backtrace(0);
    $BACK[2]["line"] = $BACK[1]["line"];
    return $BACK[2];
}

//implodes uusing both the key and value
//[key]$SmallGlue[value]$BigGlue[key]$SmallGlue[value]
function implode2($Array, $SmallGlue, $BigGlue) {
    foreach ($Array as $Key => $Value) {
        $Array[$Key] = $Key . $SmallGlue . $Value;
    }
    return implode_data($Array, $BigGlue);
}

//like implode, but makes sure it's being run on an array first
function implode_data($Data, $Delimeter = ",") {
    if (is_array($Data)) {
        return implode($Delimeter, $Data);
    }
    return $Data;
}

//a clone of CakePHP's debug function
function debug222($Iterator, $DoStacktrace = true) {
    if ($DoStacktrace) {
        $Backtrace = debug_string_backtrace();
        echo '<B>';
        if(isset($Backtrace["file"])){echo $Backtrace["file"];}
        if(isset($Backtrace["line"])){echo ' (line ' . $Backtrace["line"] . ')';}
        if(isset($Backtrace["function"])){echo ' From function: ' . $Backtrace["function"];}
        echo '();</B> ';
    }

    if (is_array($Iterator)) {
        echo '(array)<BR>';
        var_dump($Iterator);
    } else if (is_object($Iterator)) {
        if (is_iterable($Iterator)) {
            echo '(object array)<BR>';
            foreach ($Iterator as $It) {
                debug($It, false);
            }
        } else {
            echo '(object)<BR>';
            var_dump($Iterator);
        }
    } else {
        echo '(value)<BR>';
        echo $Iterator . "<BR>";
    }
}

//checks if a variable can be used in a foreach() loop
function is_iterable($var) {
    return (is_array($var) || $var instanceof Traversable);
}

//returns an array of table names in this database
function enum_tables() {
    return collapsearray(DB::select('SHOW TABLES'));
}

//collapses a multidimensional array into a single one
function collapsearray($Array, $Key = "") {
    $NewArray = array();
    foreach ($Array as $Value) {
        if ($Key) {
            $NewArray[] = $Value[$Key];
        } else {
            foreach ($Value as $NewValue) {
                $NewArray[] = $NewValue;
            }
        }
    }
    return $NewArray;
}

//clones the flash message
function message($msgtype, $description) {
    if ($msgtype != "" && $description != "") {
        return '<script type="text/javascript">
                        $(document).ready(function() {
                            Command: toastr["' . $msgtype . '"]("' . $description . '")
                            toastr.options = {
                                "closeButton": true,
                                "debug": true,
                                "newestOnTop": true,
                                "progressBar": true,
                                "positionClass": "toast-bottom-left",
                                "preventDuplicates": true,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                        });
                        </script>';
    }
}

function mapcountryprovince($Value, $IsProvince = false) {
    if (is_numeric($Value)) {
        return select_field(iif($IsProvince, "states", "countries"), "id", $Value, "name");
    } else if ($IsProvince && strlen($Value) == 2) {
        return select_field("states", "abbreviation", strtoupper($Value), "name");
    }
    return $Value;
}

//SELECT * FROM $table WHERE $column = $value
function select_field($table, $column, $value, $getcol = "", $OrderBy = "", $Dir = "ASC", $GroupBy = "") {
    return select_field_where($table, array($column => $value), $getcol, $OrderBy, $Dir, $GroupBy);
}

//$getcol = false, returns all results after the get(), true returns before the get()
function select_field_where($table, $where = array(), $getcol = "", $OrderBy = "", $Dir = "ASC", $GroupBy = "") {
    $query = DB::table($table);
    if ($getcol) {
        if ($getcol !== true) {
            $query = $query->select($getcol);
        }
    }

    if (is_array($where) && $where != "") {
        foreach ($where as $key => $value) {
            if (is_numeric($key)) {
                $query->whereRaw($value);
            } else {
                $query->where($key, $value);
            }
        }
    }

    if ($OrderBy) {
        $query = $query->orderBy($OrderBy, $Dir);
    }
    if ($GroupBy) {
        $query = $query->groupBy($GroupBy);
    }
    if ($getcol === true) {
        return $query;
    }
    if ($getcol === false) {
        return $query->get();
    }
    if ($query->count() > 0) {
        if ($getcol) {
            if($getcol == "COUNT()"){
                return $query->count();
            }
            return $query->first()->$getcol;
        }
        return $query->first();
    }
}

//SELECT * FROM $Table WHERE $conditions
function enum_all($Table, $conditions = "1=1", $order = "", $Dir = "ASC") {
    return select_field_where($Table, $conditions, false, $order, $Dir);
}

//SELECT * FROM $Table WHERE $key = $value
function enum_anything($Table, $Key, $Value) {
    return select_field_where($Table, array($Key => $Value), false);
}

//SELECT * FROM $Table WHERE $PrimaryKey = $value, return fist result
//if $PrimaryKey is blank, get it from the database
function get_entry($Table, $Value, $PrimaryKey = "id") {
    if (!$PrimaryKey) {
        $PrimaryKey = get_primary_key($Table);
    }
    return select_field_where($Table, array($PrimaryKey => $Value));
}

/////////////////////////RAW SQL
//gets the primary key of a table
function get_primary_key($Table) {
    if (is_string($Table)) {
        $Table = getColumnNames($Table, "", true);
    }
    if (is_object($Table)) {
        foreach ($Table as $Key => $Value) {
            if ($Value["Key"] == "PRI") {
                return $Value["Field"];
            }
        }
    }
}

//SELECT * FROM $Table
function enum_table($Table) {
    return select_query("SELECT * FROM " . $Table . " WHERE 1=1");
}

//returns Laravel's connection to the Pdo object to run raw SQL
function getDatasource() {
    return DB::connection()->getPdo();
}

//run an SQL query
function select_query($Query) {
    $con = getDatasource();
    return $con->query($Query);
}

//get the first result of a query
function first($query) {
    if (is_array($query)) {
        if (count($query)) {
            return $query[0];
        }
        return false;
    }
    $result = select_query($query);
    if ($result) {
        foreach ($result as $Data) {
            return $Data;
        }
    }
}

//count how many tables are in the database
function table_count($Table, $Conditions = "1=1") {
    return count(select_field_where($Table, $Conditions, false));
}

//convert an iterable object to an array
function my_iterator_to_array($entries, $PrimaryKey, $Key) {
    $data = array();
    foreach ($entries as $profiletype) {
        if ($PrimaryKey) {
            $data[$profiletype->$PrimaryKey] = $profiletype->$Key;
        } else {
            $data[] = $profiletype->$Key;
        }
    }
    return $data;
}

//count how many rows are in a table that match $conditions
function get_row_count($Table, $Conditions = "1=1") {
    return table_count($Table, $Conditions);
}

//remove empty values from an array
function remove_empties($Array) {
    foreach ($Array as $Key => $Value) {
        if (!$Value) {
            unset($Array[$Key]);
        }
    }
    return $Array;
}

//get all SQL queries that have run since initialize() was called
function getallQueries() {
    $queries = DB::getQueryLog();
    return collapsearray($queries, "query");
}

//get the last SQL query that was wun
function lastQuery() {
    $queries = DB::getQueryLog();
    $queries = end($queries);
    if (!$queries) {
        echo 'Query log is disabled, run "initialize();" first';
    }
    return $queries["query"];
}

//check if an array is associative (the keys are strings) or not (the keys are numbers)
function isassocarray($my_array) {
    if (!is_array($my_array)) {
        return false;
    }
    if (count($my_array) <= 0) {
        return true;
    }
    return !(array_unique(array_map("is_int", array_keys($my_array))) === array(true));
}

//go through an iterable object to find the one where $Fieldname = $Value
function getIterator($Objects, $Fieldname, $Value) {
    foreach ($Objects as $Object) {
        if ($Object->$Fieldname == $Value) {
            return $Object;
        }
    }
    return false;
}

//get the left-most $length digits of $text
function left($text, $length) {
    return substr($text, 0, $length);
}

//get the right-most $length digits of $text
function right($text, $length) {
    return substr($text, -$length);
}

//convert an associative array to an object
function array_to_object($Array) {
    $object = (object) $Array;
    return $object;
}

//add a new row to a table
function new_anything($Table, $Data, $Column = "ID") {
    if (!is_array($Data)) {
        $Data = array($Column = $Data);
    }
    return DB::table($Table)->insertGetId($Data);
}

//delete all rows in a table that match $conditions
function delete_all($Table, $Conditions = "") {
    if ($Conditions) {
        DB::table($Table)->where($Conditions)->delete();
    } else {
        DB::table($Table)->truncate();
    }
}

//updates an existing entry in the database
//only use when you know the primary key value exists
function update_database($Table, $PrimaryKey, $Value, $Data) {
    DB::table($Table)->where($PrimaryKey, $Value)->update($Data);
    $Data[$PrimaryKey] = $Value;
    return $Data;
}

//SELECT * FROM $Table WHERE $PrimaryKey = $Value
//if found, edit it using $Data
//if not found, create it
//returns $Data with the primary key added
function edit_database($Table, $PrimaryKey, $Value, $Data, $IncludeKey = true) {
    $entry = false;
    if ($PrimaryKey && $Value) {
        $entry = select_field($Table, $PrimaryKey, $Value);
    }
    if ($entry) {
        update_database($Table, $PrimaryKey, $Value, $Data);
        $ID = $Value;
    } else {
        $ID = new_anything($Table, $Data);
    }
    if ($IncludeKey) {
        $Data[$PrimaryKey] = $ID;
    }
    return $Data;
}

//adds a new row to the database filled with $Data
function new_entry($Table, $PrimaryKey, $Data) {
    return edit_database($Table, $PrimaryKey, "", $Data);
}

//gets the protected value of an object ("_properties" is one used by most objects)
function getProtectedValue($obj, $name = "_properties") {
    $array = (array) $obj;
    $prefix = chr(0) . '*' . chr(0);
    if (isset($array[$prefix . $name])) {
        return $array[$prefix . $name];
    }
}

//remove anything that isn't a number from $text
function kill_non_numeric($text, $allowmore = "") {
    return preg_replace("/[^0-9" . $allowmore . "]/", "", $text);
}

//resize an image
function resize($file, $sizes, $CropToFit = false, $delimeter = "x") {
    if (is_array($sizes)) {
        $images = array();
        foreach ($sizes as $size) {
            $images[] = resize($file, $size, $CropToFit, $delimeter);
        }
        return $images;
    } else {
        $newsize = explode($delimeter, $sizes);
        $newfile = getfilename($file) . '-' . $sizes . "." . getextension($file);
        return getdirectory($file) . "/" . make_thumb($file, $newfile, $newsize[0], $newsize[1], false);
    }
}

//get the directory of a file path
//HOME/WINDOWS/TEST.JPG returns HOME/WINDOWS
function getdirectory($path) {
    return pathinfo(str_replace("\\", "/", $path), PATHINFO_DIRNAME);
}

//get the filename of a file path
//$WithExtension = true, HOME/WINDOWS/TEST.JPG returns TEST.JPG
//$WithExtension = false, HOME/WINDOWS/TEST.JPG returns TEST
function getfilename($path, $WithExtension = false) {
    if ($WithExtension) {
        return pathinfo($path, PATHINFO_BASENAME); //filename only, with extension
    } else {
        return pathinfo($path, PATHINFO_FILENAME); //filename only, no extension
    }
}

//get the extension of a file path
//HOME/WINDOWS/TEST.JPG returns jpg
function getextension($path) {
    return strtolower(pathinfo($path, PATHINFO_EXTENSION)); // extension only, no period
}

//loads a jpg/png/gif/bmp as an image object
function loadimage($filename) {
    if(file_exists($filename)) {
        //get image extension.
        $ext = getExtension($filename);
        //creates the new image using the appropriate function from gd library
        if (!strcmp("jpg", $ext) || !strcmp("jpeg", $ext)) {
            return imagecreatefromjpeg($filename);
        }
        if (!strcmp("png", $ext)) {
            return imagecreatefrompng($filename);
        }
        if (!strcmp("gif", $ext)) {
            return imagecreatefromgif($filename);
        }
        if (!strcmp("bmp", $ext)) {
            return imagecreatefrombmp($filename);
        }
    }
}

//loads a BMP manually
function imagecreatefrombmp($filename) {
    $file = fopen($filename, "rb");
    $read = fread($file, 10);
    while (!feof($file) && $read != "") {
        $read .= fread($file, 1024);
    }
    $temp = unpack("H*", $read);
    $hex = $temp[1];
    $header = substr($hex, 0, 104);
    $body = str_split(substr($hex, 108), 6);
    if (substr($header, 0, 4) == "424d") {
        $header = substr($header, 4);
        $header = substr($header, 32);
        $width = hexdec(substr($header, 0, 2));
        $header = substr($header, 8);
        $height = hexdec(substr($header, 0, 2));
        unset($header);
    }
    $x = 0;
    $y = 1;
    $image = imagecreatetruecolor($width, $height);
    foreach ($body as $rgb) {
        $r = hexdec(substr($rgb, 4, 2));
        $g = hexdec(substr($rgb, 2, 2));
        $b = hexdec(substr($rgb, 0, 2));
        $color = imagecolorallocate($image, $r, $g, $b);
        imagesetpixel($image, $x, $height - $y, $color);
        $x++;
        if ($x >= $width) {
            $x = 0;
            $y++;
        }
    }
    return $image;
}

//copies an image ($file) to a new location
//$sizes contains an array of key=path, value=size
function copyimages($sizes, $file, $name, $CropToFit = false) {
    foreach ($sizes as $path => $size) {
        $rsize = resize($file, $size, $CropToFit);
        copy($rsize, public_path($path . $name));
        @unlink($rsize);
    }
}

// this is the function that will create the thumbnail image from the uploaded image
// the resize will be done considering the width and height defined, but without deforming the image
function make_thumb($input_filename, $output_filename, $new_width, $new_height, $CropToFit = false, $Resize = false) {
    $src_img = loadimage($input_filename);
    if ($src_img) {
        //gets the dimmensions of the image
        $old_x = imageSX($src_img);
        $old_y = imageSY($src_img);

        $ratio1 = $old_x / $new_width;
        $ratio2 = $old_y / $new_height;

        $thumb_w=$new_width;
        $thumb_h=$new_height;
        if ($ratio1 > $ratio2) {
            $thumb_h = $old_y / $ratio1;
        } else {
            $thumb_w = $old_x / $ratio2;
        }
        if ($CropToFit) {
            if ($thumb_w < $new_width) {
                $ratio1 = $new_width / $thumb_w;
                $thumb_w = $new_width;
                $thumb_h = $thumb_h * $ratio1;
            } else if ($thumb_h < $new_height) {
                $ratio1 = $new_height / $thumb_h;
                $thumb_w = $thumb_w * $ratio1;
                $thumb_h = $new_height;
            }
        }
        if($Resize){
            if($thumb_w < $new_width){$new_width = $thumb_w;}
            if($thumb_h < $new_height){$new_height = $thumb_h;}
        }

        $dst_img = ImageCreateTrueColor($new_width, $new_height);
        $ext = "png";
        if ($output_filename) {$ext = getExtension($output_filename);}
        if($ext == "png" || $ext == "gif"){//transparent background
            $bgcolor = imagecolorallocatealpha($dst_img, 128, 255, 128, 127);
            imagesavealpha($dst_img, true);
        } else {//white background
            $bgcolor = imagecolorallocate($dst_img, 255, 255, 255);
        }
        imagefill($dst_img,0,0,$bgcolor);
        imagealphablending($dst_img, true);
        imageantialias($dst_img, true);
        imagecopyresampled($dst_img, $src_img, ($new_width * 0.5) - ($thumb_w * 0.5), ($new_height * 0.5) - ($thumb_h * 0.5), 0, 0, $thumb_w,$thumb_h, $old_x, $old_y);
        imagedestroy($src_img);

        if ($output_filename) {
            $Dir = "";
            if(strpos($output_filename, "/") === false){
                $Dir = getdirectory($input_filename) . "/";
            }
            switch ($ext) {
                case "png":
                    imagepng($dst_img, $Dir . $output_filename);
                    break;
                default:
                    imagejpeg($dst_img, $Dir . $output_filename);
            }
            imagedestroy($dst_img);
        } else {
            return $dst_img;
        }
        return $output_filename;
    }
}

//automatically handle uploading of files
function handle_upload($Dir) {
    if (isset($_FILES['myfile']['name']) && $_FILES['myfile']['name']) {
        if (right($Dir, 1) != "/") {
            $Dir .= "/";
        }
        $dest = resolve_path(APP . '../webroot/' . left($Dir, strlen($Dir) - 1));
        if (!file_exists($dest)) {
            mkdir($dest, 0777, true);
        }
        $name = $_FILES['myfile']['name'];
        $arr = explode('.', $name);
        $ext = end($arr);
        $file = date('YmdHis') . '.' . $ext; //unique filename
        move_uploaded_file($_FILES['myfile']['tmp_name'], APP . '../webroot/' . $Dir . $file);
        $file_path = webroot(true) . $Dir . $file;
        return $file_path;
    }
}

//convert a relative path with ..'s to a full path name
function resolve_path($str) {
    $str = str_replace('\\', '/', $str);
    $array = explode('/', $str);
    $domain = array_shift($array);
    $parents = array();
    foreach ($array as $dir) {
        switch ($dir) {
            case '.':
                // Don't need to do anything here
                break;
            case '..':
                array_pop($parents);
                break;
            default:
                $parents[] = $dir;
                break;
        }
    }

    return $domain . '/' . implode('/', $parents);
}

//gets a key from the get or post, or returns $default if it doesn't exist
function getpost($Key, $Default = "") {
    if (isset($_GET[$Key])) {
        return $_GET[$Key];
    }
    if (isset($_POST[$Key])) {
        return $_POST[$Key];
    }
    return $Default;
}

//this code is broken
function get_time_interval() {
    $min = date('i');
    $mod = $min % 15;
    $diff = 15 - $mod;

    $date = date('Y-m-d H:i:s');

    $currentDate = strtotime($date);
    $futureDate = $currentDate + (60 * $diff);
    $start = date("Y-m-d H:i:s", $futureDate);
    $start_format = date('M d, H:i', $futureDate);

    $end = $start;
    $end_format = $start_format;
    for ($i = 0; $i < 700; $i++) {
        if ($i == 0) {
            $start = $start;
            $start_format = $start_format;
        } else {
            $start = $end;//NOT SPECIFIED!!!
            $start_format = $end_format;//NOT SPECIFIED!!!
        }
        $currentDate = strtotime($start);
        $futureDate = $currentDate + (60 * 15);
        $end = date("Y-m-d H:i:s", $futureDate);
        $end_format = date('M d, H:i', $futureDate);
        echo "<option value='" . $start_format . " - " . $end_format . "'>" . $start_format . " - " . $end_format . "</option>";
    }
}

//checks if $Text is encrypted, might not work if the encrpytion key is changed
function is_encrypted($Text) {
    return strpos($Text, "eyJpdiI6I") === 0;
}

function debugmode() {
    return config('app.debug') || isset($_GET["debugmode"]);
}

//if the server is localhost, print whatever file is specified in red text
function printfile($File, $Ret = false) {//cannot use __FILE__ due to caching
    if (debugmode()) {
        $Return = '<FONT COLOR="RED" STYLE="background-color: white;" TITLE="' . $File . '">' . $File . '</FONT>';
        //if(isset($GLOBALS["currentfile"])){$Return .= " From: " . $GLOBALS["currentfile"];}//doesn't work as it expects a flat layout, not hierarchical
        $GLOBALS["currentfile"] = $File;
        if ($Ret) {
            return $Return;
        }
        echo $Return;
    }
}

// Function to get the client ip address
function get_client_ip_server() {
    foreach (array("HTTP_CLIENT_IP", "HTTP_X_FORWARDED_FOR", "HTTP_X_FORWARDED", "HTTP_FORWARDED_FOR", "HTTP_FORWARDED", "REMOTE_ADDR") as $field) {
        if (isset($_SERVER[$field])) {
            return $_SERVER[$field];
        }
    }
    return 'UNKNOWN';
}

//gets browser information about the user
function getBrowser() {
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $version = "";
    $ub = "";
    $ID = 0;
    // Next get the name of the useragent yes seperately and for good reason
    if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
        $ID = 1;
    } elseif (preg_match('/Firefox/i', $u_agent)) {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
        $ID = 2;
    } elseif (preg_match('/Chrome/i', $u_agent)) {
        $bname = 'Google Chrome';
        $ub = "Chrome";
        $ID = 3;
    } elseif (preg_match('/Safari/i', $u_agent)) {
        $bname = 'Apple Safari';
        $ub = "Safari";
        $ID = 4;
    } elseif (preg_match('/Opera/i', $u_agent)) {
        $bname = 'Opera';
        $ID = 5;
    } elseif (preg_match('/Netscape/i', $u_agent)) {
        $bname = 'Netscape';
        $ID = 6;
    }
    if (!$ub) {
        $ub = $bname;
    }

    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
            ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }

    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
            $version = (isset($matches['version'][0]))?$matches['version'][0]:0;
        } else {
            $version = (isset($matches['version'][1]))?$matches['version'][1]:0;
        }
    } else {
        $version = (isset($matches['version'][0]))?$matches['version'][0]:0;
    }

    // check if we have a number
    if ($version == null || $version == "") {
        $version = "?";
    }

    return array(
        'userAgent' => $u_agent,
        'agentID' => $ID,
        'name' => $bname,
        'short' => $ub,
        'version' => $version,
        'platform' => getOS(),
        'pattern' => $pattern
    );
}

//gets the user's OS
function getOS() {
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $os_platform = "Unknown OS Platform";
    $os_array = array(
        '/windows nt 10/i' => 'Windows 10',
        '/windows nt 6.3/i' => 'Windows 8.1',
        '/windows nt 6.2/i' => 'Windows 8',
        '/windows nt 6.1/i' => 'Windows 7',
        '/windows nt 6.0/i' => 'Windows Vista',
        '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
        '/windows nt 5.1/i' => 'Windows XP',
        '/windows xp/i' => 'Windows XP',
        '/windows nt 5.0/i' => 'Windows 2000',
        '/windows me/i' => 'Windows ME',
        '/win98/i' => 'Windows 98',
        '/win95/i' => 'Windows 95',
        '/win16/i' => 'Windows 3.11',
        '/macintosh|mac os x/i' => 'Mac OS X',
        '/mac_powerpc/i' => 'Mac OS 9',
        '/linux/i' => 'Linux',
        '/ubuntu/i' => 'Ubuntu',
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
        '/android/i' => 'Android',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i' => 'Mobile'
    );
    foreach ($os_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $os_platform = $value;
        }
    }
    return $os_platform;
}

function getUserBrowser() {
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $browser = "Unknown Browser";
    if (preg_match('~MSIE|Internet Explorer~i', $_SERVER['HTTP_USER_AGENT']) || (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0; rv:11.0') !== false)) {
        return "Internet Explorer";
    }
    $browser_array = array(
        '/firefox/i' => 'Firefox',
        '/safari/i' => 'Safari',
        '/chrome/i' => 'Chrome',
        '/opera/i' => 'Opera',
        '/netscape/i' => 'Netscape',
        '/maxthon/i' => 'Maxthon',
        '/konqueror/i' => 'Konqueror',
        '/mobile/i' => 'Handheld Browser'
    );

    //echo "<pre>";print_r($user_agent); die;

    foreach ($browser_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $browser = $value;
        }
    }
    return $browser;
}

if (!function_exists("priority")) {

    function priority($Alpha, $Beta = false) {
        if ($Alpha) {
            return $Alpha;
        }
        if ($Beta) {
            return $Beta;
        }
        return "";
    }

}

function priority2($resturant, $Field, $Old = "") {
    if (!$Old) {
        $Old = $Field;
    }
    if (isset($resturant->$Field)) {
        return $resturant->$Field;
    }
    return old($Old);
}

//code is broken, will only return 12:00 AM
function getTime($time) {
    if (strpos($time, "AM") !== false || strpos($time, "PM") !== false || strpos($time, ":") === false) {
        return $time;
    }
    return "12:00 AM";
    if (!$time) {
        return $time;
    } else {
        $arr = explode(':', $time);
    }
    $hour = $arr[0];
    $min = $arr[1];
    $sec = $arr[2];
    $suffix = 'AM';
    if ($hour >= 12) {
        $hour = $hour - 12;
        $suffix = 'PM';
    }
    if (strlen($hour) == 1) {
        $hour = '0' . $hour;
    }
    return $hour . ':' . $min . ' ' . $suffix;
}

//rounds down by 0.5
function roundDownToHalf($number) {
    $remainder = ($number * 10) % 10;
    $half = ($remainder > 0) ? 0.5 : 0;
    $value = floatval(intval($number) + $half);
    return number_format($value, 1, '.', '');
}

//gets a rating
function rating_get($target_id = 0, $rating_id = 0, $type = "") {
    $fetch = App\Http\Models\RatingUsers::select(DB::raw('SUM(rating) as rating'))->where('target_id', $target_id)->where('rating_id', $rating_id)->where('type', $type)->first();
    $numberOfratings = App\Http\Models\RatingUsers::where('target_id', $target_id)->where('rating_id', $rating_id)->where('type', $type)->count();
    $numberOfratings = ($numberOfratings > 0) ? $numberOfratings : 1;
    return roundDownToHalf($fetch->rating / $numberOfratings);
}

//prints a rating
function rating_initialize($type = "rating", $load_type = "", $target_id = 0, $TwoLines = false, $class_name='update-rating', $add_rate_brn = true) {
    $html = "";
    foreach (select_field_where("rating_define", array('type' => $load_type, 'is_active' => 1), false) as $key => $value) {
        $update_class = ($type == "rating") ? $class_name . $target_id . $value->id . $value->type : '';
        $checked_class = ' checked-stars ';

        $startHalf = 'class="' . $update_class . '"';
        $start1 = 'class="' . $update_class . '"';
        $start1Half = 'class="' . $update_class . '"';
        $start2 = 'class="' . $update_class . '"';
        $start2Half = 'class="' . $update_class . '"';
        $start3 = 'class="' . $update_class . '"';
        $start3Half = 'class="' . $update_class . '"';
        $start4 = 'class="' . $update_class . '"';
        $start4Half = 'class="' . $update_class . '"';
        $start5 = 'class="' . $update_class . '"';

        $average = rating_get($target_id, $value->id, $load_type);
        if ($average == 0.5) {
            $startHalf = 'checked class="' . $checked_class . $update_class . '"';
        } else if ($average == 1.0) {
            $start1 = 'checked class="' . $checked_class . $update_class . '"';
        } else if ($average == 1.5) {
            $start1Half = 'checked class="' . $checked_class . $update_class . '"';
        } else if ($average == 2.0) {
            $start2 = 'checked class="' . $checked_class . $update_class . '"';
        } else if ($average == 2.5) {
            $start2Half = 'checked class="' . $checked_class . $update_class . '"';
        } else if ($average == 3.0) {
            $start3 = 'checked class="' . $checked_class . $update_class . '"';
        } else if ($average == 3.5) {
            $start3Half = 'checked class="' . $checked_class . $update_class . '"';
        } else if ($average == 4.0) {
            $start4 = 'checked class="' . $checked_class . $update_class . '"';
        } else if ($average == 4.5) {
            $start4Half = 'checked class="' . $checked_class . $update_class . '"';
        } else if ($average == 5.0) {
            $start5 = 'checked class="' . $checked_class . $update_class . '"';
        }

        $user_id = (\Session::has('session_id')) ? \Session::get('session_id') : 0;
        $countExit = table_count("rating_users", array('user_id' => $user_id, 'target_id' => $target_id, 'rating_id' => $value->id));
        
        $html .= '<div class="' . $type . '">';
        //$value->title;
        if ($TwoLines) {
            $html .= '<br>';
        }
        if($add_rate_brn == true && \Session::has('session_id')){
            $html .= '<a style="color:white;" class="rating-it-btn" data-target-id="' . $target_id . '" data-rating-id="' . $value->id . '" data-type="' . $value->type . '" data-count-exist="' . $countExit . '">Rate it</a>';
        }
        $html .= stars($target_id, $value, $countExit, $start5, "5");
        $html .= stars($target_id, $value, $countExit, $start4Half, "4.5");
        $html .= stars($target_id, $value, $countExit, $start4, "4");
        $html .= stars($target_id, $value, $countExit, $start3Half, "3.5");
        $html .= stars($target_id, $value, $countExit, $start3, "3");
        $html .= stars($target_id, $value, $countExit, $start2Half, "2.5");
        $html .= stars($target_id, $value, $countExit, $start2, "2");
        $html .= stars($target_id, $value, $countExit, $start1Half, "1.5");
        $html .= stars($target_id, $value, $countExit, $start1, "1");
        $html .= stars($target_id, $value, $countExit, $startHalf, "0.5");
        $html .= ' </div>';
    }

    return $html;
}


function select_rating_starts($type = "rating", $load_type = "", $target_id = 0, $TwoLines = false, $class_name='update-rating') {
    $html = "";
    foreach (select_field_where("rating_define", array('type' => $load_type, 'is_active' => 1), false) as $key => $value) {
        $update_class = ($type == "rating") ? $class_name : '';
        $checked_class = ' checked-stars ';

        $startHalf = 'class="' . $update_class . '"';
        $start1 = 'class="' . $update_class . '"';
        $start1Half = 'class="' . $update_class . '"';
        $start2 = 'class="' . $update_class . '"';
        $start2Half = 'class="' . $update_class . '"';
        $start3 = 'class="' . $update_class . '"';
        $start3Half = 'class="' . $update_class . '"';
        $start4 = 'class="' . $update_class . '"';
        $start4Half = 'class="' . $update_class . '"';
        $start5 = 'class="' . $update_class . '"';
        
        $average = rating_get($target_id, $value->id, $load_type);
        if ($average == 0.5) {
            $startHalf = 'checked class="' . $checked_class . $update_class . '"';
        } else if ($average == 1.0) {
            $start1 = 'checked class="' . $checked_class . $update_class . '"';
        } else if ($average == 1.5) {
            $start1Half = 'checked class="' . $checked_class . $update_class . '"';
        } else if ($average == 2.0) {
            $start2 = 'checked class="' . $checked_class . $update_class . '"';
        } else if ($average == 2.5) {
            $start2Half = 'checked class="' . $checked_class . $update_class . '"';
        } else if ($average == 3.0) {
            $start3 = 'checked class="' . $checked_class . $update_class . '"';
        } else if ($average == 3.5) {
            $start3Half = 'checked class="' . $checked_class . $update_class . '"';
        } else if ($average == 4.0) {
            $start4 = 'checked class="' . $checked_class . $update_class . '"';
        } else if ($average == 4.5) {
            $start4Half = 'checked class="' . $checked_class . $update_class . '"';
        } else if ($average == 5.0) {
            $start5 = 'checked class="' . $checked_class . $update_class . '"';
        }

        $user_id = (\Session::has('session_id')) ? \Session::get('session_id') : 0;
        $countExit = table_count("rating_users", array('user_id' => $user_id, 'target_id' => $target_id, 'rating_id' => $value->id));
        
        $html .= '<div class="' . $type . '">&nbsp;';
        //$value->title;
        if ($TwoLines) {
            $html .= '<br>';
        }
        $html .= stars($target_id, $value, $countExit, $start5, "5");
        $html .= stars($target_id, $value, $countExit, $start4Half, "4.5");
        $html .= stars($target_id, $value, $countExit, $start4, "4");
        $html .= stars($target_id, $value, $countExit, $start3Half, "3.5");
        $html .= stars($target_id, $value, $countExit, $start3, "3");
        $html .= stars($target_id, $value, $countExit, $start2Half, "2.5");
        $html .= stars($target_id, $value, $countExit, $start2, "2");
        $html .= stars($target_id, $value, $countExit, $start1Half, "1.5");
        $html .= stars($target_id, $value, $countExit, $start1, "1");
        $html .= stars($target_id, $value, $countExit, $startHalf, "0.5");
        $html .= ' </div>';
    }

    return $html;
}

//prints 1 star
function stars($target_id, $value, $countExit, $start, $Number) {
    $half = "";
    $class = "full";
    if (strpos($Number, ".")) {
        $half = "half";
        $class = $half;
    }
    return '<input type="radio" id="star' . $Number . $half . $target_id . $value->id . '" name="rating[' . $target_id . $value->id . ']" data-target-id="' . $target_id . '" data-rating-id="' . $value->id . '" data-type="' . $value->type . '" data-count-exist="' . $countExit . '" value="' . $Number . '" ' . $start . ' /><label class = "' . $class . '" for="star' . $Number . $half . $target_id . $value->id . '" title="' . $Number . ' stars"></label>';
}

//converts a CSV array into one where each value is in a single quote
function strToTagsConversion($string = "") {
    $html = "";
    if ($string) {
        foreach (explode(", ", $string) as $value) {
            $html .= "'" . $value . "', ";
        }
    }
    return $html;
}

function obfuscate($CardNumber, $maskingCharacter = "*") {
    if (!isvalid_creditcard($CardNumber)) {
        return "[INVALID CARD NUMBER]";
    }
    return substr($CardNumber, 0, 4) . str_repeat($maskingCharacter, strlen($CardNumber) - 8) . substr($CardNumber, -4);
}

function isvalid_creditcard($CardNumber, $Invalid = "") {
    $CardNumber = preg_replace('/\D/', '', $CardNumber);
    // http://stackoverflow.com/questions/174730/what-is-the-best-way-to-validate-a-credit-card-in-php
    // https://en.wikipedia.org/wiki/Bank_card_number#Issuer_identification_number_.28IIN.29
    if ($CardNumber) {
        $length = 0;
        $mod10 = true;
        $Prefix = left($CardNumber, 2);
        if ($Prefix >= 51 && $Prefix <= 55) {
            $length = 16; //mastercard
            $type = "mastercard";
        } else if ($Prefix == 34 || $Prefix == 37) {
            $length = 15; //amex
            $type = "americanExpress";
        } else if (left($CardNumber, 1) == 4) {
            $length = array(13, 16); //visa
            $type = "visa";
        } else if ($Prefix == 65) {
            $length = 16; //discover
            $type = "discover";
        } else {
            $Prefix = left($CardNumber, 6);
            if ($Prefix >= 622126 || $Prefix <= 622925) {
                $length = 16; //discover
                $type = "discover";
            } else {
                $Prefix = left($CardNumber, 3);
                if ($Prefix >= 644 || $Prefix <= 649) {
                    $length = 16; //discover
                    $type = "discover";
                } else if (left($CardNumber, 4) == 6011) {
                    $length = 16; //discover
                    $type = "discover";
                }
            }
        }
        if ($length) {
            if (!is_array($length)) {
                $length = array($length);
            }
            $Prefix = false;
            foreach ($length as $digits) {
                if (strlen($CardNumber) == $digits) {
                    $Prefix = true;
                }
            }
            if ($Prefix) {
                if ($mod10) {
                    if (luhn_check($CardNumber)) {
                        return $type;
                    }
                }
                return $type;
            }
        }
    }
    return $Invalid;
}

function luhn_check($number) {
    // Strip any non-digits (useful for credit card numbers with spaces and hyphens)
    $number = preg_replace('/\D/', '', $number);

    // Set the string length and parity
    $number_length = strlen($number);
    $parity = $number_length % 2;

    // Loop through each digit and do the maths
    $total = 0;
    for ($i = 0; $i < $number_length; $i++) {
        $digit = $number[$i];
        // Multiply alternate digits by two
        if ($i % 2 == $parity) {
            $digit *= 2;
            // If the sum is two digits, add them together (in effect)
            if ($digit > 9) {
                $digit -= 9;
            }
        }
        // Total up the digits
        $total += $digit;
    }

    // If the total mod 10 equals 0, the number is valid
    return ($total % 10 == 0) ? TRUE : FALSE;
}


function ViewsCountsType($id=0, $type=""){
    return \App\Http\Models\PageViews::getView($id, $type);
}
?>