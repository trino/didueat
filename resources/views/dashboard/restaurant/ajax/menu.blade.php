@include('menus')
<?php
    $itemPosnForJSStr="";
    $catIDforJS_Str="";
    $catNameStrJS="";
    $catid=0;
    $Restaurant= select_field("restaurants", "id", $RestaurantID);
    printmenu($__env, $Restaurant, $catid, $itemPosnForJSStr, $catIDforJS_Str, $catNameStrJS, false);
?>