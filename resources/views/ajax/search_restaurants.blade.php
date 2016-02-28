<?php
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
}

$server_gmt = date('Z') / 3600;
$user_gmt = \Session::get('session_gmt', $server_gmt);
$difference = $server_gmt - $user_gmt;
$server_time = date('H:i:s');
$user_time = date('H:i:s', strtotime(iif($difference > -1, '+') . $difference . ' hours'));
if (!isset($sql)) {
    $sql = "Server GMT: " . $server_gmt . " User GMT: " . $user_gmt . " Difference: " . $difference . " hours Server Time: " . $server_time . " User Time: " . $user_time;
}
printfile("<BR>" . $sql . "<BR>views/ajax/search_restaurants.blade.php");

if (is_object($count)) {
    echo "Count should not be an object!!!";
    return;
}

?>

<div class="list-group m-t-2" id="restuarant_bar">

<?php

$totalCnt=0;
$openCnt=0;
$closedCnt=0;
$openStr="";
$closedStr="";

if(isset($query) && $count > 0 && is_iterable($query)){
    foreach($query as $value){
        $logo = ($value['logo'] != "") ? 'restaurants/' . $value['id'] . '/small-' . $value['logo'] : 'small-smiley-logo.png';
        $value['tags'] = str_replace(",", ", ", $value['tags']);
        $Modes = array();
        if ($value['is_delivery']) {
            $Delivery_enable = "Delivery";
        }
        if ($value['is_pickup']) {
            $Pickup_enable = "Pickup";
        }

        $Modes = implode(", ", $Modes); // why do this if it's empty?

        if(!isset($delivery_type)){
            $delivery_type = "is_pickup";
        }
        $key = iif($delivery_type == "is_delivery", "_del");
        $Day = current_day_of_week();
        $open = offsettime($value[$Day . "_open" . $key], $difference);
        $close = offsettime($value[$Day . "_close" . $key], $difference);
        $is_open = $open <= $user_time && $close >= $user_time;
        $openedRest = $value['openedRest'];

        ($openedRest == 0)? $grayout=" grayout" : $grayout="";

        ob_start();

        ?>













































































        <?php

        if(isset($is_open) && $is_open == 1){
            $openStr.="\n<br/>".ob_get_contents();
        }
        else{
            $closedStr.="\n<br/>".ob_get_contents();
        }

        ob_end_clean();

        // move counter outside buffer
        $totalCnt++;
        if(isset($openedRest) && $openedRest == 1){
            $openCnt++;
        }
        else{
            $closedCnt++;
        }


    }
}
?>


<?php

if($openStr != ""){
    echo $openStr;
}

if($openStr != "" && $closedStr != ""){
    echo '<hr width="100%" align="center" color="#000" /><h2 style="margin:2px;margin-left:auto;margin-right:auto;text-align:center;text-decoration:underline">Restaurants Currently Closed</h2><div class="instruct ctr">(But please feel free to browse their menus!)</div>';
    echo $closedStr;
}


?>






<?php

echo "
var totalCnt=".$totalCnt.";
var openCnt=".$openCnt.";
var closedCnt=".$closedCnt.";";

?>

var openCntMsg="";
var closedCntMsg="";
var spBR="<br/>";
if(openCnt != totalCnt){
			if(openCnt < totalCnt && closedCnt < totalCnt){
    spBR=" ";
			 openCntMsg=openCnt+" open";
			 closedCntMsg=" and "+closedCnt+" closed";
			}
			else if(closedCnt == totalCnt){
			 closedCntMsg="Sorry, but all restaurants are currently closed. In the meantime, you can review the Did U Eat restaurants in your area, and place your order when they are open";
			}

			document.getElementById('openClosed').innerHTML=spBR+"("+openCntMsg+closedCntMsg+")";
}
</script>

<div id="loadMoreBtnContainer">
    @if($hasMorePage > 0)
        <div class="row">
            <div class="col-md-12 col-md-offset-5">
                <button id="loadingbutton" data-id="{{ $start }}" align="center" class="loadMoreRestaurants btn custom-default-btn" title="Load more restaurants...">
                    Load More ...
                </button>
                <img class="loadingbar" src="{{ asset('assets/images/loader.gif') }}" style="display: none;"/>
            </div>
        </div>
    @endif
    <input type="hidden" id="countTotalResult" value="{{ $count }}"/>
</div>

<img id='parentLoadingbar' src="{{ asset('assets/images/loader.gif') }}" style="display: none;"/>