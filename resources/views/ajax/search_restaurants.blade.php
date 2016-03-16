<?php
    //used for getting the time in the user's time zone
    function offsettime($time, $hours = 0) {
        if ($hours) {
            $time = explode(":", $time);
            $time[0] = $time[0] + $hours;
            if ($time[0] < 0) {
                $time[0] += 24;
            }
            if ($time[0] > 23) {
                $time[0] -= 24;
            }
            $time = implode(":", $time);
        }
        return $time;
    }

    if (isset($data['data'])) {
        parse_str($data['data']);
        parse_str($data['data'], $_POST);
        if(debugmode()){
            var_dump($_POST);
        }
    }

    $server_gmt = date('Z') / 3600;
    $user_gmt = \Session::get('session_gmt', $server_gmt);
    $difference = $server_gmt - $user_gmt;
    $server_time = date('H:i:s');
    $user_time = $server_time;//the live server's timezone is different than expected, just use the server time and be done with it
    //$user_time = date('H:i:s', strtotime(iif($difference > -1, '+') . $difference . ' hours'));//get the user's time
    if (!isset($sql)) {
        $sql = "TIME ZONE IGNORED";//"Server GMT: " . $server_gmt . " User GMT: " . $user_gmt . " Difference: " . $difference . " hours Server Time: " . $server_time . " User Time: " . $user_time;
    }
    printfile("<BR>" . $sql . "<BR>views/ajax/search_restaurants.blade.php");
    if (is_object($count)) {
        echo "Count should not be an object!!!";//an error has occured, abort
        return;
    }

    echo '<div class="list-group" id="restuarant_bar">';

    $totalCnt=0;
    $openCnt=0;
    $closedCnt=0;
    $openStr="";
    $closedStr="";

    if(isset($query) && $count > 0 && is_iterable($query)){
        foreach($query as $value){
            ob_start();
            $is_open = \App\Http\Models\Restaurants::getbusinessday($value);
            ?>
                @include("dashboard.restaurant.restaurantpanel", array("Restaurant" => $value, "order" => true))
            <?php

            if($is_open){
                $openStr.="".ob_get_contents();
            } else{
                $closedStr.="".ob_get_contents();
            }
            ob_end_clean();
            // move counter outside buffer
            $totalCnt++;
            if(isset($is_open) && $is_open == 1){
                $openCnt++;
            } else{
                $closedCnt++;
            }
        }
    }

    if($openStr){
        echo $openStr;
    }
    if($openStr && $closedStr){
        echo $closedStr;
    } else if($closedStr){
        echo $closedStr;
    }
?>
</div>


<script>
    <?php
        echo "
        var totalCnt = " . $totalCnt . ";
        var openCnt = " . $openCnt . ";
        var closedCnt = " . $closedCnt . ";";
        //updates the text to show if all stores are open/closed
    ?>
    var openCntMsg="";
    var closedCntMsg="";
    var spBR="";
    if(openCnt != totalCnt){
        if(openCnt < totalCnt && closedCnt < totalCnt){
            spBR=" ";
            openCntMsg=openCnt+" Open";
            closedCntMsg=" and "+closedCnt+" Closed";
        } else if(closedCnt == totalCnt){
           // closedCntMsg="Sorry, but all restaurants are currently closed. In the meantime, you can view the restaurants, and place your order when they are open";
        }
        document.getElementById('openClosed').innerHTML=spBR+""+openCntMsg+closedCntMsg+"";
        totalCnt = totalCnt + Number($("#countRows").text());
        $("#countRows").text(totalCnt);
        if(totalCnt){
            $("#countRowsS").text("s");
        }
    }
</script>

<div id="loadMoreBtnContainer">
    @if($hasMorePage > 0)
        <div class="row">
            <div class="col-md-12 ">
                <button id="loadingbutton" data-id="{{ $start }}" align="center" class="loadMoreRestaurants btn btn-link btn-lg btn-block" title="Load more restaurants...">Load More ...</button>
                <img class="loadingbar" src="{{ asset('assets/images/loader.gif') }}" style="display: none;"/>
            </div>
        </div>
    @endif
    <input type="hidden" id="countTotalResult" value="{{ $count }}"/>
</div>
<img id='parentLoadingbar' src="{{ asset('assets/images/loader.gif') }}" style="display: none;"/><img id='parentLoadingbar' src="{{ asset('assets/images/loader.gif') }}" style="display: none;"/>