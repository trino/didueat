<?php
    printfile("views/dashboard/restaurant/ajax/search.blade.php");
    if(iterator_count($restaurants)){
        echo '<DIV class="row">';
        echo '<SELECT name="id" id="restid" CLASS="form-control" onchange="claimrestaurant();"><OPTION VALUE="">We have found similar restaurant(s), click one to claim it</OPTION>';
        foreach($restaurants as $restaurant){
            echo '<OPTION VALUE="' . $restaurant->id . '" TITLE="' . $restaurant->name. '" ID="restname' . $restaurant->id. '">';
            echo $restaurant->name . ' [' . $restaurant->address . " " . $restaurant->city . '] (' . $restaurant->phone . ')</OPTION>';
        }
        echo '</SELECT></div>';
    }
?>