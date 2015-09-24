<?php

function test(){
    DB::enableQueryLog();
    return;

    $Test = get_profile_type(1);
    debug($Test);
    die();
}

function logevent($Text, $IdontKNOW){

}





//////////////////////////////////////////////////PROFILE TYPES API/////////////////////////////////////////////////////
function new_profiletype($Name){
    logevent("Made a new profile type: " . $Name, false);
    return new_anything("profiletypes", $Name);
}

function get_profile_permissions(){//lists all permissions
    return getColumnNames("profiletypes", array("ID", "Name", "Hierarchy"));
}

function enum_profiletypes($Hierarchy = "", $toArray = true){
    $Condition = "1=1";
    if($Hierarchy){
        $Condition = "Hierarchy > " . $Hierarchy;
    }
    $entries = enum_all("profiletypes", $Condition);
    if($toArray) {return my_iterator_to_array($entries, "ID", "Name");}
    return $entries;
}

function fileinclude($Filename){//pass __FILE__
    if ($_SERVER["SERVER_NAME"]){
        return '<FONT COLOR="RED">Include: ' . $Filename . '</FONT>';
    }
}

function edit_profiletype($ID = "", $Name, $Hierarchy, $Permissions = ""){
    if(!$ID){
        $ID = new_profiletype($Name);
    }
    logevent("Changed profile type: " . $ID . " (" . $Name . ", " . $Hierarchy . ", " . print_r($Permissions, true) . ")", false);
    $data = array("Name" => $Name, "Hierarchy" => $Hierarchy);
    if ($Permissions == "ALL"){
        $Permissions = get_profile_permissions();
    }
    if (is_array($Permissions)) {
        foreach ($Permissions as $Permission) {
            $data[$Permission] = "1";
        }
    }
    update_database("profiletypes", "ID", $ID, $data);
    return $ID;
}

////////////////////////////////////Profile API/////////////////////////////////////////
function read($Name){
    return Session::get('Profile.' . $Name);
}
function salt(){
    return "18eb00e8-f835-48cb-bbda-49ee6960261f";
}

function enum_profiles($Key, $Value){
    return enum_all('profiles', $Key, $Value);
}

function get_profile($ID = ""){
    if(!$ID){$ID=read("ID");}
    return get_entry("profiles", $ID);
}

function is_email_in_use($EmailAddress, $NotByUserID=0){
    $EmailAddress = clean_email($EmailAddress);
    if($NotByUserID) {
        return first("SELECT * FROM profiles WHERE Email = '" . $EmailAddress. "' AND ID != " . $NotByUserID);
    } else {
        return get_entry("profiles",$EmailAddress, "Email");
    }
}

function get_profile_type($ProfileID, $GetByType = false){
    if($GetByType){return get_entry("profiletypes", $ProfileID);}
    $profiletype = get_entry("profiles", $ProfileID, "ID")->profileType;
    return get_entry("profiletypes", $profiletype);
}

function can_profile_create($ProfileID, $ProfileType){
    $creatorprofiletype = get_profile_type($ProfileID);
    if($creatorprofiletype->CanCreateProfiles){
        $ProfileType = get_profile_type($ProfileType, true);
        return $creatorprofiletype->Hierarchy < $ProfileType->Hierarchy;
    }
}

function randomPassword($Length=8) {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = "";
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < $Length; $i++) {
        $n = rand(0, $alphaLength);
        $pass .= $alphabet[$n];
    }
    return $pass;
}

function is_valid_email($EmailAddress){
    //http://php.net/manual/en/function.filter-var.php
    //filter_var can also validate: FILTER_VALIDATE_IP FILTER_VALIDATE_INT FILTER_VALIDATE_BOOLEAN FILTER_VALIDATE_URL FILTER_SANITIZE_STRING
    //flags FILTER_NULL_ON_FAILURE FILTER_FLAG_PATH_REQUIRED FILTER_FLAG_STRIP_LOW FILTER_FLAG_STRIP_HIGH
    $EmailAddress = clean_email($EmailAddress);
    if ($EmailAddress && filter_var($EmailAddress, FILTER_VALIDATE_EMAIL)) {
        return $EmailAddress;
    }
}

function find_profile($EmailAddress, $Password){
    //echo salt();die();
    $EmailAddress = clean_email($EmailAddress);
    $Password = md5($Password . salt());
    return enum_all("profiles", array("Email" => $EmailAddress, "Password" => $Password))->first();
}














function tableexists($Table, $Column = ""){
    if($Column){
        return \Schema::hasColumn($Table, $Column);
    }
    return \Schema::hasTable($Table);
}

function getColumnNames($Table, $Ignore ="", $Full = false){
    if(!is_array($Ignore)){$Ignore = array($Ignore);}
    if($Full){
        $Cols = select_query("SHOW columns FROM " . $Table);
    } else {
        $Cols = \Schema::getColumnListing($Table);
    }
    if(!count($Ignore)) {return $Cols;}
    $Columns = array();
    foreach ($Cols as $Key => $ColData) {
        if($Full){$ColumnName = $ColData["Field"];} else {$ColumnName = $ColData;}
        if (!in_array($ColumnName, $Ignore)) {
            $Columns[] = $ColData;
        }
    }
    return $Columns;
}

























function clean_phone($Phone){
    $Phone = kill_non_numeric($Phone, "+");//add a check to be sure only the first digit is a +
    if($Phone != "+") {
        return $Phone;
    }
}
function clean_email($Email){
    return strtolower(trim($Email));
}
function clean_postalcode($PostalCode){
    $PostalCode = str_replace(" ", "", strtoupper(trim($PostalCode)));
    if(validateCanadaZip($PostalCode)){
        $delimeter = "";//" "
        return left($PostalCode, 3) . $delimeter . right($PostalCode, 3);
    }
}
function validateCanadaZip($PostalCode)  {//function by Roshan Bhattara(http://roshanbh.com.np)
    return preg_match("/^([a-ceghj-npr-tv-z]){1}[0-9]{1}[a-ceghj-npr-tv-z]{1}[0-9]{1}[a-ceghj-npr-tv-z]{1}[0-9]{1}$/i", $PostalCode);
}


function debug_string_backtrace() {
    $BACK = debug_backtrace(0);
    $BACK[2]["line"] = $BACK[1]["line"];
    return $BACK[2];
}

function implode2($Array, $SmallGlue, $BigGlue){
    foreach($Array as $Key => $Value){
        $Array[$Key] = $Key . $SmallGlue. $Value;
    }
    return implode($Array,$BigGlue);
}
function debug($Iterator, $DoStacktrace = true){
    if($DoStacktrace) {
        $Backtrace = debug_string_backtrace();
        echo '<B>' . $Backtrace["file"] . ' (line ' . $Backtrace["line"] . ') From function: ' . $Backtrace["function"] . '();</B> ';
    }

    if(is_array($Iterator)){
        echo '(array)<BR>';
        var_dump($Iterator);
    } else if (is_object($Iterator)) {
        if(is_iterable($Iterator)) {
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
        echo $Iterator;
    }
}
function is_iterable($var) {
    return (is_array($var) || $var instanceof Traversable);
}

// My common functions
function enum_tables(){
    return collapsearray(DB::select('SHOW TABLES'));
}

function collapsearray($Array, $Key = ""){
    $NewArray = array();
    foreach($Array as $Value){
        if($Key){
            $NewArray[] = $Value[$Key];
        } else {
            foreach($Value as $NewValue){
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


function select_field($table, $column, $value, $getcol = "", $OrderBy="", $Dir="ASC", $GroupBy="") {
    return select_field_where($table, array($column =>$value), $getcol, $OrderBy, $Dir, $GroupBy);
}

function select_field_where($table, $where=array(), $getcol = "", $OrderBy="", $Dir="ASC", $GroupBy="") {
    $query = DB::table($table);
    if($getcol) {
        $query = $query->select($getcol);
    }
    if(!is_array($where)){$where = array($where);}
    foreach ($where as $key => $value) {
        if(is_numeric($key)){
            $query->whereRaw($value);
        } else {
            $query->where($key, $value);
        }
    }

    if($OrderBy){$query = $query->orderBy($OrderBy, $Dir);}
    if($GroupBy){$query = $query->groupBy($GroupBy);}
    if($getcol === true){return $query;}
    if($getcol === false){return $query->get();}
    if ($query->count() > 0) {
        if($getcol) {
            return $query->first()->$getcol;
        }
        return $query->first();
    }
}









function enum_all($Table, $conditions = "1=1", $order = ""){
    return select_field_where($Table, $conditions, false, $order);
}
function enum_anything($Table, $Key, $Value){
    return select_field_where($Table, array($Key => $Value), false);
}
function get_entry($Table, $Value, $PrimaryKey = "ID"){
    if(!$PrimaryKey){$PrimaryKey = get_primary_key($Table);}
    return select_field_where($Table, array($PrimaryKey => $Value));
}




/////////////////////////RAW SQL
function get_primary_key($Table){
    if (is_string($Table)){
        $Table = getColumnNames($Table, "", true);
    }
    if (is_object($Table)) {
        foreach ($Table as $Key => $Value) {
            if($Value["Key"] == "PRI"){
                return $Value["Field"];
            }
        }
    }
}

function enum_table($Table){
    return select_query("SELECT * FROM " . $Table . " WHERE 1=1");
}

function getDatasource(){
    return DB::connection()->getPdo();
}

function select_query($Query){
    $con = getDatasource();
    return $con->query($Query);
}

function first($query) {
    $result = select_query($query);
    if($result) {
        foreach($result as $Data){
            return $Data;
        }
    }
}

function table_count($Table, $Conditions = "1=1"){
    return count(select_field_where($Table, $Conditions, false));
}

function my_iterator_to_array($entries, $PrimaryKey, $Key){
    $data = array();
    foreach($entries as $profiletype){
        if($PrimaryKey) {
            $data[$profiletype->$PrimaryKey] = $profiletype->$Key;
        } else {
            $data[] = $profiletype->$Key;
        }
    }
    return $data;
}

function get_row_count($Table, $Conditions = "1=1"){
   return table_count($Table, $Conditions);
}

function remove_empties($Array){
    foreach($Array as $Key => $Value){
        if (!$Value){
            unset($Array[$Key]);
        }
    }
    return $Array;
}

function getallQueries(){
    $queries = DB::getQueryLog();
    return collapsearray($queries, "query");
}
function lastQuery(){
    $queries = DB::getQueryLog();
    $queries = end($queries);
    if(!$queries){
        echo 'Query log is disabled, run "DB::enableQueryLog();" first';
    }
    return $queries["query"];
}

function isassocarray($my_array){
    if(!is_array($my_array)) {return false;}
    if(count($my_array) <= 0) {return true;}
    return !(array_unique(array_map("is_int", array_keys($my_array))) === array(true));
}

function getIterator($Objects, $Fieldname, $Value){
    foreach($Objects as $Object){
        if ($Object->$Fieldname == $Value){
            return $Object;
        }
    }
    return false;
}

function left($text, $length){
    return substr($text,0,$length);
}
function right($text, $length){
    return substr($text, -$length);
}

function array_to_object($Array){
    $object = (object) $Array;
    return $object;
}

function new_anything($Table, $Data, $Column = "ID"){
    if(!is_array($Data)){$Data = array($Column = $Data);}
    return DB::table($Table)->insertGetId($Data);
}

function delete_all($Table, $Conditions = ""){
    if($Conditions){
        DB::table($Table)->where($Conditions)->delete();
    } else {
        DB::table($Table)->truncate();
    }
}

//only use when you know the primary key value exists
function update_database($Table, $PrimaryKey, $Value, $Data){
    DB::table($Table)->where($PrimaryKey, $Value)->update($Data);
    $Data[$PrimaryKey] = $Value;
    return $Data;
}

function edit_database($Table, $PrimaryKey, $Value, $Data, $IncludeKey = false){
    $entry = false;
    if($PrimaryKey && $Value) {
        $entry = select_field($Table, $PrimaryKey, $Value);
    }
    if($entry) {
        update_database($Table, $PrimaryKey, $Value, $Data);
        $ID = $Value;
    } else {
        $ID = new_anything($Table, $Data);
    }
    if($IncludeKey) {$Data[$PrimaryKey] = $ID;}
    return $Data;
}

function new_entry($Table, $PrimaryKey, $Data){
    return $this->edit_database($Table, $PrimaryKey, "", $Data);
}



function getProtectedValue($obj,$name) {
    $array = (array)$obj;
    $prefix = chr(0).'*'.chr(0);
    if (isset($array[$prefix.$name])) {
        return $array[$prefix . $name];
    }
}
function kill_non_numeric($text, $allowmore = ""){
    return preg_replace("/[^0-9" . $allowmore . "]/", "", $text);
}

?>