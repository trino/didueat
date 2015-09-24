<?php

function test(){
    return;
    DB::enableQueryLog();

    getColumnNames("countries");
    $Test = getallQueries();

    debug($Test);


    die();
}


















function tableexists($Table, $Column = ""){
    if($Column){
        return \Schema::hasColumn($Table, $Column);
    }
    return \Schema::hasTable($Table);
}

function getColumnNames($Table, $Full = false){
    if($Full){
        return select_query("SHOW columns FROM " . $Table);
    }
    return \Schema::getColumnListing($Table);
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
function debug($Iterator){
    $Backtrace = debug_string_backtrace();
    echo '<B>' . $Backtrace["file"] . ' (line ' . $Backtrace["line"] . ') From function: ' . $Backtrace["function"] . '(' . implode2($Backtrace["args"], "=", ",") . ');</B><BR>' ;

    if(is_array($Iterator)){
        var_dump($Iterator);
    } else if (is_object($Iterator)) {
        foreach ($Iterator as $It) {
            var_dump($It);
        }
    } else {
        echo $Iterator;
    }
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
function get_entry($Table, $Value, $PrimaryKey = ""){
    if(!$PrimaryKey){$PrimaryKey = get_primary_key($Table);}
    return select_field_where($Table, array($PrimaryKey => $Value));
}




/////////////////////////RAW SQL
function get_primary_key($Table){
    if (is_string($Table)){
        $Table = getColumnNames($Table, true);
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