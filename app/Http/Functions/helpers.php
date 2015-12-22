<?php

function initialize($Source = "") {
    DB::enableQueryLog();
    handle_action();
}

function Encode( $str ){
    return trim( htmlentities( addslashes($str) ) );
}

function Decode( $str ){
    return html_entity_decode( stripslashes($str) );	 
}

function handleevent($EventName, $Variables, $DirectEmail = "") {
    //handle emails
}

function sendemail($To, $Subject, $Message, $Raw = true) {
    
}

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

//func count orders
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

//shows what file is currently open in red text, use __FILE__ for $Filename
function fileinclude($Filename) {//pass __FILE__
    if ($_SERVER["SERVER_NAME"]) {
        return '<FONT COLOR="RED">Include: ' . $Filename . '</FONT>';
    }
}

function webroot($Local = false) {
    if ($Local) {
        return app_path() . "/";
    }
    return URL::to('/');
}

////////////////////////////////////Profile API/////////////////////////////////////////
function read($Name) {
    if (\Session::has('session_' . $Name)) {
        return \Session::get('session_' . $Name);
    }
}

function write($Name, $Value, $Save = false) {
    \Session::put('session_' . $Name, $Value);
    if ($Save) {
        \Session::save();
    }
}

function salt() {
    return "18eb00e8-f835-48cb-bbda-49ee6960261f";
}

function enum_profiles($Key, $Value) {
    return enum_all('profiles', array($Key => $Value));
}

function get_profile($ID = "") {
    if (!$ID) {
        $ID = read("ID");
    }
    return get_entry("profiles", $ID);
}

function is_email_in_use($EmailAddress, $NotByUserID = 0) {
    $EmailAddress = clean_email($EmailAddress);
    if ($NotByUserID) {
        return first("SELECT * FROM profiles WHERE Email = '" . $EmailAddress . "' AND ID != " . $NotByUserID);
    } else {
        return get_entry("profiles", $EmailAddress, "email");
    }
}

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

function is_valid_email($EmailAddress) {
    //http://php.net/manual/en/function.filter-var.php
    //filter_var can also validate: FILTER_VALIDATE_IP FILTER_VALIDATE_INT FILTER_VALIDATE_BOOLEAN FILTER_VALIDATE_URL FILTER_SANITIZE_STRING
    //flags FILTER_NULL_ON_FAILURE FILTER_FLAG_PATH_REQUIRED FILTER_FLAG_STRIP_LOW FILTER_FLAG_STRIP_HIGH
    $EmailAddress = clean_email($EmailAddress);
    if ($EmailAddress && filter_var($EmailAddress, FILTER_VALIDATE_EMAIL)) {
        return $EmailAddress;
    }
}

function encryptpassword($Password) {
    return \crypt($Password, salt());
}

function login($Profile) {
    if (is_numeric($Profile)) {
        $Profile = get_profile($Profile);
    } else if (is_array($Profile)) {
        $Profile = (object) $Profile;
    }
    write('ID', $Profile->id);
    write('Name', $Profile->name);
    write('Email', $Profile->email);
    write('Type', $Profile->profile_type);
    write('Restaurant', $Profile->restaurant_id);

    if($Profile->profile_type == 1){
        \Session::put('session_type_user', 'super');
    } else if($Profile->profile_type == 2){
        if($Profile->restaurant_id){
            \Session::put('session_type_user', 'restaurant');
        } else {
            \Session::put('session_type_user', 'user');
        }
    }

    \Session::put('session_id', $Profile->id);
    \Session::put('session_profiletype', $Profile->profile_type);
    \Session::put('session_name', $Profile->name);
    \Session::put('session_email', $Profile->email);
    \Session::put('session_phone', select_field("profiles_addresses", "user_id", $Profile->id, "phone_no"));
    \Session::put('session_subscribed', $Profile->subscribed);
    \Session::put('session_restaurant_id', $Profile->restaurant_id);
    \Session::put('session_createdBy', $Profile->created_by);
    \Session::put('session_status', $Profile->status);
    \Session::put('session_created_at', $Profile->created_at);
    \Session::put('session_photo', $Profile->photo);

    \Session::put('is_logged_in', true);
    \Session::save();
    return $Profile->id;
}

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

/////////////////////////////////////Date API////////////////////////////////////////
function now() {
    return date("Y-m-d H:i:s");
}

//returns date stamp
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

function data_type_name($Type) {
    $Values = array("Email Address", "Phone Number", "Postal Code");
    if ($Type < 0 or $Type >= count($Values)) {
        return "Unknown";
    }
    return $Values[$Type];
}

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

function tableexists($Table, $Column = "") {
    if ($Column) {
        return \Schema::hasColumn($Table, $Column);
    }
    return \Schema::hasTable($Table);
}

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

function clean_phone($Phone) {
    $Phone = kill_non_numeric($Phone, "+"); //add a check to be sure only the first digit is a +
    if ($Phone != "+") {
        return $Phone;
    }
}

function clean_email($Email) {
    return strtolower(trim($Email));
}

function clean_postalcode($PostalCode) {
    $PostalCode = str_replace(" ", "", strtoupper(trim($PostalCode)));
    if (validateCanadaZip($PostalCode)) {
        $delimeter = ""; //" "
        return left($PostalCode, 3) . $delimeter . right($PostalCode, 3);
    }
}

function validateCanadaZip($PostalCode) {//function by Roshan Bhattara(http://roshanbh.com.np)
    return preg_match("/^([a-ceghj-npr-tv-z]){1}[0-9]{1}[a-ceghj-npr-tv-z]{1}[0-9]{1}[a-ceghj-npr-tv-z]{1}[0-9]{1}$/i", $PostalCode);
}

function debugprint($text){
    $path = "royslog.txt";
    $dashes = "----------------------------------------------------------------------------------------------\r\n";
    if(is_array($text)){$text = print_r($text,true);}
    file_put_contents($path, $dashes . str_replace("%dashes%", $dashes, str_replace("<BR>", "\r\n" , $text)) . "\r\n", FILE_APPEND);
}

function debug_string_backtrace() {
    $BACK = debug_backtrace(0);
    $BACK[2]["line"] = $BACK[1]["line"];
    return $BACK[2];
}

function implode2($Array, $SmallGlue, $BigGlue) {
    foreach ($Array as $Key => $Value) {
        $Array[$Key] = $Key . $SmallGlue . $Value;
    }
    return implode_data($Array, $BigGlue);
}

function implode_data($Data, $Delimeter = ",") {
    if (is_array($Data)) {
        return implode($Delimeter, $Data);
    }
    return $Data;
}

function debug($Iterator, $DoStacktrace = true) {
    if ($DoStacktrace) {
        $Backtrace = debug_string_backtrace();
        echo '<B>' . $Backtrace["file"] . ' (line ' . $Backtrace["line"] . ') From function: ' . $Backtrace["function"] . '();</B> ';
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

function is_iterable($var) {
    return (is_array($var) || $var instanceof Traversable);
}

// My common functions
function enum_tables() {
    return collapsearray(DB::select('SHOW TABLES'));
}

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
            return $query->first()->$getcol;
        }
        return $query->first();
    }
}

function enum_all($Table, $conditions = "1=1", $order = "", $Dir = "ASC") {
    return select_field_where($Table, $conditions, false, $order, $Dir);
}

function enum_anything($Table, $Key, $Value) {
    return select_field_where($Table, array($Key => $Value), false);
}

function get_entry($Table, $Value, $PrimaryKey = "id") {
    if (!$PrimaryKey) {
        $PrimaryKey = get_primary_key($Table);
    }
    return select_field_where($Table, array($PrimaryKey => $Value));
}

/////////////////////////RAW SQL
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

function enum_table($Table) {
    return select_query("SELECT * FROM " . $Table . " WHERE 1=1");
}

function getDatasource() {
    return DB::connection()->getPdo();
}

function select_query($Query) {
    $con = getDatasource();
    return $con->query($Query);
}

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

function table_count($Table, $Conditions = "1=1") {
    return count(select_field_where($Table, $Conditions, false));
}

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

function get_row_count($Table, $Conditions = "1=1") {
    return table_count($Table, $Conditions);
}

function remove_empties($Array) {
    foreach ($Array as $Key => $Value) {
        if (!$Value) {
            unset($Array[$Key]);
        }
    }
    return $Array;
}

function getallQueries() {
    $queries = DB::getQueryLog();
    return collapsearray($queries, "query");
}

function lastQuery() {
    $queries = DB::getQueryLog();
    $queries = end($queries);
    if (!$queries) {
        echo 'Query log is disabled, run "DB::enableQueryLog();" first';
    }
    return $queries["query"];
}

function isassocarray($my_array) {
    if (!is_array($my_array)) {
        return false;
    }
    if (count($my_array) <= 0) {
        return true;
    }
    return !(array_unique(array_map("is_int", array_keys($my_array))) === array(true));
}

function getIterator($Objects, $Fieldname, $Value) {
    foreach ($Objects as $Object) {
        if ($Object->$Fieldname == $Value) {
            return $Object;
        }
    }
    return false;
}

function left($text, $length) {
    return substr($text, 0, $length);
}

function right($text, $length) {
    return substr($text, -$length);
}

function array_to_object($Array) {
    $object = (object) $Array;
    return $object;
}

function new_anything($Table, $Data, $Column = "ID") {
    if (!is_array($Data)) {
        $Data = array($Column = $Data);
    }
    return DB::table($Table)->insertGetId($Data);
}

function delete_all($Table, $Conditions = "") {
    if ($Conditions) {
        DB::table($Table)->where($Conditions)->delete();
    } else {
        DB::table($Table)->truncate();
    }
}

//only use when you know the primary key value exists
function update_database($Table, $PrimaryKey, $Value, $Data) {
    DB::table($Table)->where($PrimaryKey, $Value)->update($Data);
    $Data[$PrimaryKey] = $Value;
    return $Data;
}

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

function new_entry($Table, $PrimaryKey, $Data) {
    return edit_database($Table, $PrimaryKey, "", $Data);
}

function getProtectedValue($obj, $name) {
    $array = (array) $obj;
    $prefix = chr(0) . '*' . chr(0);
    if (isset($array[$prefix . $name])) {
        return $array[$prefix . $name];
    }
}

function kill_non_numeric($text, $allowmore = "") {
    return preg_replace("/[^0-9" . $allowmore . "]/", "", $text);
}

function get_resize_details($case) {
    switch ($case) {
        case "restaurants":
            return array(
                0 => array(
                    "width" => "120",
                    "height" => "120",
                    "new_path" => public_path('assets/images/restaurants/thumb'),
                    "crop" => "true",
                    "crop_type" => "center",
                ),
                1 => array(
                    "width" => "400",
                    "height" => "300",
                    "new_path" => public_path('assets/images/restaurants/thumb1'),
                    "crop" => "true",
                    "crop_type" => "center",
                ),
            );
            break;

        case "menues":
            return array(
                0 => array(
                    "width" => "37",
                    "height" => "34",
                    "new_path" => public_path('assets/images/products/thumb'),
                    "crop" => "true",
                    "crop_type" => "center",
                ),
                1 => array(
                    "width" => "500",
                    "height" => "380",
                    "new_path" => public_path('assets/images/products/thumb1'),
                    "crop" => "true",
                    "crop_type" => "center",
                ),
                2 => array(
                    "width" => "700",
                    "height" => "600",
                    "new_path" => public_path('assets/images/restaurants'),
                    "crop" => "false",
                )
            );
            break;
    }
}

function resize($file, $sizes, $CropToFit = false, $delimeter = "x") {
    if (is_array($sizes)) {
        $images = array();
        foreach ($sizes as $size) {
            $images[] = resize($file, $size, $delimeter);
        }
        return $images;
    } else {
        $newsize = explode($delimeter, $sizes);
        $newfile = getfilename($file) . '-' . $sizes . "." . getextension($file);
        return make_thumb($file, $newfile, $newsize[0], $newsize[1], $CropToFit);
    }
}

function getdirectory($path) {
    return pathinfo( str_replace("\\", "/", $path), PATHINFO_DIRNAME);
}

function getfilename($path, $WithExtension = false) {
    if ($WithExtension) {
        return pathinfo($path, PATHINFO_BASENAME); //filename only, with extension
    } else {
        return pathinfo($path, PATHINFO_FILENAME); //filename only, no extension
    }
}

function getextension($path) {
    return strtolower(pathinfo($path, PATHINFO_EXTENSION)); // extension only, no period
}

function loadimage($filename) {
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

function copyimages($sizes, $file, $name) {
    foreach ($sizes as $path => $size) {
        $rsize = resize($file, $size, true);
        copy(public_path($rsize), public_path($path . $name));
        @unlink(public_path($rsize));
    }
}

// this is the function that will create the thumbnail image from the uploaded image
// the resize will be done considering the width and height defined, but without deforming the image
function make_thumb($input_filename, $output_filename, $new_width, $new_height, $CropToFit = false) {
    $src_img = loadimage($input_filename);
    if ($src_img) {
        //gets the dimmensions of the image
        $old_x = imageSX($src_img);
        $old_y = imageSY($src_img);

        $ratio1 = $old_x / $new_width;
        $ratio2 = $old_y / $new_height;
        if ($ratio1 > $ratio2) {
            $thumb_w = $new_width;
            $thumb_h = $old_y / $ratio1;
        } else {
            $thumb_h = $new_height;
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
            $dst_img = ImageCreateTrueColor($new_width, $new_height);
            imagecopyresampled($dst_img, $src_img, $new_width / 2 - $thumb_w / 2, 0, $new_height / 2 - $thumb_h / 2, 0, $thumb_w, $thumb_h, $old_x, $old_y);
        } else {
            $dst_img = ImageCreateTrueColor($thumb_w, $thumb_h);
            imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y);
        }

        imagedestroy($src_img);
        if ($output_filename) {
            $ext = getExtension($output_filename);
            switch ($ext) {
                case "png":
                    imagepng($dst_img, $output_filename);
                    break;
                default:
                    imagejpeg($dst_img, $output_filename);
            }
            imagedestroy($dst_img);
        } else {
            return $dst_img;
        }
        return $output_filename;
    }
}

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

function getpost($Key, $Default = "") {
    if (isset($_GET[$Key])) {
        return $_GET[$Key];
    }
    if (isset($_POST[$Key])) {
        return $_POST[$Key];
    }
    return $Default;
}

function get_time_interval() {
    $min = date('i');
    $mod = $min % 15;
    $diff = 15 - $mod;

    $date = date('Y-m-d H:i:s');

    $currentDate = strtotime($date);
    $futureDate = $currentDate + (60 * $diff);
    $start = date("Y-m-d H:i:s", $futureDate);
    $start_format = date('M d, H:i', $futureDate);
    for ($i = 0; $i < 700; $i++) {
        if ($i == 0) {
            $start = $start;
            $start_format = $start_format;
        } else {
            $start = $end;
            $start_format = $end_format;
        }
        $currentDate = strtotime($start);
        $futureDate = $currentDate + (60 * 15);
        $end = date("Y-m-d H:i:s", $futureDate);
        $end_format = date('M d, H:i', $futureDate);
        echo "<option value='" . $start_format . " - " . $end_format . "'>" . $start_format . " - " . $end_format . "</option>";
    }
}

function is_encrypted($Text){
    return strpos($Text, "eyJpdiI6I") === 0;
}


function printfile($File){//cannot user __FILE__ due to caching
    if($_SERVER["SERVER_NAME"] == "localhost"){
        echo '<FONT COLOR="RED">' . $File . '</FONT>';
    }
}

// Function to get the client ip address
function get_client_ip_server() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if (isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';

    return $ipaddress;
}

function getBrowser() {
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $version = "";
    $ub = "";

    // Next get the name of the useragent yes seperately and for good reason
    if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    } elseif (preg_match('/Firefox/i', $u_agent)) {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    } elseif (preg_match('/Chrome/i', $u_agent)) {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    } elseif (preg_match('/Safari/i', $u_agent)) {
        $bname = 'Apple Safari';
        $ub = "Safari";
    } elseif (preg_match('/Opera/i', $u_agent)) {
        $bname = 'Opera';
        $ub = "Opera";
    } elseif (preg_match('/Netscape/i', $u_agent)) {
        $bname = 'Netscape';
        $ub = "Netscape";
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
            $version = $matches['version'][0];
        } else {
            $version = $matches['version'][1];
        }
    } else {
        $version = $matches['version'][0];
    }

    // check if we have a number
    if ($version == null || $version == "") {
        $version = "?";
    }

    return array(
        'userAgent' => $u_agent,
        'name' => $bname,
        'version' => $version,
        'platform' => getOS(),
        'pattern' => $pattern
    );
}

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

function getTime($time) {
    if (strpos($time, "AM") !== false || strpos($time, "PM") !== false) {
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

function roundDownToHalf($number) {
    $remainder = ($number * 10) % 10;
    $half = ($remainder > 0) ? 0.5 : 0;
    $value = floatval(intval($number) + $half);
    return number_format($value, 1, '.', '');
}

function rating_get($target_id = 0, $rating_id = 0, $type = "") {
    $fetch = App\Http\Models\RatingUsers::select(DB::raw('SUM(rating) as rating'))->where('target_id', $target_id)->where('rating_id', $rating_id)->where('type', $type)->first();
    $numberOfratings = App\Http\Models\RatingUsers::where('target_id', $target_id)->where('rating_id', $rating_id)->where('type', $type)->count();
    $numberOfratings = ($numberOfratings > 0)?$numberOfratings:1;
    return roundDownToHalf($fetch->rating / $numberOfratings);
}

function rating_initialize($type = "rating", $load_type = "", $target_id = 0) {
    $html = "";
    foreach (select_field_where("rating_define", array('type' => $load_type, 'is_active' => 1), false) as $key => $value) {
        $update_class = ($type == "rating") ? ' update-rating '.$target_id.$value->id.$value->type : '';
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

        $user_id = (\Session::has('session_id'))?\Session::get('session_id'):0;
        $countExit = table_count("rating_users", array('user_id' => $user_id, 'target_id' => $target_id, 'rating_id' => $value->id));


        $html .= '<div class="' . $type . ' rating-font-size rating-center-align"> <div class="col-md-3"><h4>' . $value->title . '</h4></div>
                    <input type="radio" id="star5' . $target_id . $value->id . '" name="rating[' . $target_id . $value->id . ']" data-target-id="' . $target_id . '" data-rating-id="' . $value->id . '" data-type="' . $value->type . '" data-count-exist="'.$countExit.'" value="5" ' . $start5 . ' /><label class = "full" for="star5' . $target_id . $value->id . '" title="5 stars"></label>
                    <input type="radio" id="star4half' . $target_id . $value->id . '" name="rating[' . $target_id . $value->id . ']" data-target-id="' . $target_id . '" data-rating-id="' . $value->id . '" data-type="' . $value->type . '" data-count-exist="'. $countExit .'" value="4.5" ' . $start4Half . ' /><label class="half" for="star4half' . $target_id . $value->id . '" title="4.5 stars"></label>
                    <input type="radio" id="star4' . $target_id . $value->id . '" name="rating[' . $target_id . $value->id . ']" data-target-id="' . $target_id . '" data-rating-id="' . $value->id . '" data-type="' . $value->type . '" data-count-exist="'. $countExit .'" value="4" ' . $start4 . ' /><label class = "full" for="star4' . $target_id . $value->id . '" title="4 stars"></label>
                    <input type="radio" id="star3half' . $target_id . $value->id . '" name="rating[' . $target_id . $value->id . ']" data-target-id="' . $target_id . '" data-rating-id="' . $value->id . '" data-type="' . $value->type . '" data-count-exist="'. $countExit .'" value="3.5" ' . $start3Half . ' /><label class="half" for="star3half' . $target_id . $value->id . '" title="3.5 stars"></label>
                    <input type="radio" id="star3' . $target_id . $value->id . '" name="rating[' . $target_id . $value->id . ']" data-target-id="' . $target_id . '" data-rating-id="' . $value->id . '" data-type="' . $value->type . '" data-count-exist="'. $countExit .'" value="3" ' . $start3 . ' /><label class = "full" for="star3' . $target_id . $value->id . '" title="3 stars"></label>
                    <input type="radio" id="star2half' . $target_id . $value->id . '" name="rating[' . $target_id . $value->id . ']" data-target-id="' . $target_id . '" data-rating-id="' . $value->id . '" data-type="' . $value->type . '" data-count-exist="'. $countExit .'" value="2.5" ' . $start2Half . ' /><label class="half" for="star2half' . $target_id . $value->id . '" title="2.5 stars"></label>
                    <input type="radio" id="star2' . $target_id . $value->id . '" name="rating[' . $target_id . $value->id . ']" data-target-id="' . $target_id . '" data-rating-id="' . $value->id . '" data-type="' . $value->type . '" data-count-exist="'. $countExit .'" value="2" ' . $start2 . ' /><label class = "full" for="star2' . $target_id . $value->id . '" title="2 stars"></label>
                    <input type="radio" id="star1half' . $target_id . $value->id . '" name="rating[' . $target_id . $value->id . ']" data-target-id="' . $target_id . '" data-rating-id="' . $value->id . '" data-type="' . $value->type . '" data-count-exist="'. $countExit .'" value="1.5" ' . $start1Half . ' /><label class="half" for="star1half' . $target_id . $value->id . '" title="1.5 stars"></label>
                    <input type="radio" id="star1' . $target_id . $value->id . '" name="rating[' . $target_id . $value->id . ']" data-target-id="' . $target_id . '" data-rating-id="' . $value->id . '" data-type="' . $value->type . '" data-count-exist="'. $countExit .'" value="1" ' . $start1 . ' /><label class = "full" for="star1' . $target_id . $value->id . '" title="1 star"></label>
                    <input type="radio" id="starhalf' . $target_id . $value->id . '" name="rating[' . $target_id . $value->id . ']" data-target-id="' . $target_id . '" data-rating-id="' . $value->id . '" data-type="' . $value->type . '" data-count-exist="'. $countExit .'" value="0.5" ' . $startHalf . ' /><label class="half" for="starhalf' . $target_id . $value->id . '" title="0.5 stars"></label>
                </div>';
    }

    return $html;
}


function strToTagsConversion($string=""){
    $html = "";
    if($string){
        foreach (explode(", ", $string) as $value) {
            $html .= "'".$value."', ";
        }
    }
    return $html;
}

?>