<?php

function test(){
    /*$Test = get_entry("countries", 1, "id");

    debug($Test);


    die();*/
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
    echo '<B>' . $Backtrace["file"] . ' (line ' . $Backtrace["line"] . ') From function: ' . $Backtrace["function"] . '(' . implode2($Backtrace["args"], "=", ",") . ');' ;

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

function select_query($Query){
    $con = DB::connection()->getPdo();
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

?>