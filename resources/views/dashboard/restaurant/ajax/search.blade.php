<A NAME="search" />
<?php
    printfile("views/dashboard/restaurant/ajax/search.blade.php");
    if(iterator_count($restaurants)){
        echo '<DIV class="row">';
        echo '<DIV CLASS="col-sm-12">We have found similar restaurant(s), click one to claim it:</DIV>';
        foreach($restaurants as $restaurant){
            echo '<A HREF="#search" ONCLICK="claimrestaurant(' . $restaurant->id . ')"><DIV CLASS="col-sm-6">';
            echo '<H4 id="restname' . $restaurant->id . '">' . $restaurant->name . '</H4>';
            echo $restaurant->address . " " . $restaurant->city;
            echo '</DIV></A>';
        }
        echo '</div>';
    }
?>