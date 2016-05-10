<?php
    printfile("views/dashboard/restaurant/franchise.blade.php");
    $franchises = enum_all("restaurants", array("franchise" => -1));
    echo '<SELECT NAME="franchise" CLASS="form-control">';
        optionitem($restaurant, "Stand-alone", 0);
        optionitem($restaurant, "Parent", -1);
        foreach($franchises as $franchise){
            optionitem($restaurant, $franchise->name, $franchise->id);
        }
    echo '</SELECT>';

    function optionitem($restaurant, $franchiseName, $franchiseID){
        echo '<OPTION VALUE="' . $franchiseID . '"';
        if($restaurant->franchise == $franchiseID){
            echo ' SELECTED';
        }
        echo '>' . $franchiseName . '</OPTION>';
    }
?>
