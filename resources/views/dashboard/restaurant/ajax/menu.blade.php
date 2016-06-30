@include('menus')
<?php
    $itemPosnForJSStr="";
    $catIDforJS_Str="";
    $catNameStrJS="";
    $catid=0;
    $Restaurant= select_field("restaurants", "id", $RestaurantID);
    if(debugmode()){
        $Day =  \App\Http\Models\Restaurants::getbusinessday($Restaurant);
        echo '<BR>DEBUG MODE: ' . $Restaurant->address . " is open " . $Day . " from " . getfield($Restaurant, $Day . "_open") . " to " . getfield($Restaurant, $Day . "_close");
    }
    printmenu($__env, $Restaurant, $catid, $itemPosnForJSStr, $catIDforJS_Str, $catNameStrJS, false);
?>