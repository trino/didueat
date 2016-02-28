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

            <div class="list-group-item{{ $grayout }}">



                <div class="col-md-3 col-xs-3 p-l-0">

                    <a href="{{ url('restaurants/'.$value['slug'].'/menu') }}">
                        <img style="max-width:100%;" class="img-rounded" alt="" src="{{ asset('assets/images/' . $logo) }}">
                    </a>
                    <div class="clearfix"></div>
                </div>


                <div class="col-md-9 p-a-0" style="">

                    <a class="card-link" href="{{ url('restaurants/'.$value['slug'].'/menu') }}">
                        <h4 style="color: #0275d8;">{{ $value['name'] }}


                                <div class="pull-right">


                                    <a href="{{ url('restaurants/'.$value['slug'].'/menu') }}" class="btn btn-sm btn-primary hidden-sm-down">

                                        Order Online

                                    </a>

                            </h4>
                    </a>

<div  class="clearfix"></div>
                    <div>
                            @if($openedRest != 1)
                                <div class="smallT up7"> (Currently Closed)</div>
                            @endif
                        {!! rating_initialize("static-rating", "restaurant", $value['id']) !!}
                    </div>
                    <div class="clearfix">
                        {{ $value['address'] }}, {{ $value['city'] }}
                    </div>
   <span class="p-r-2">
                        Genres: {{ str_replace(",", ", ", $value["cuisine"]) }}
                    </span><br>
                    <!--span class="p-r-2 ">{{ select_field("cuisine", "id", $value['id'], "name") }}</span-->
                    @if($value["is_delivery"])
                        <span class="p-r-2">Delivery: {{ asmoney($value['delivery_fee'],$free=true) }}</span>
                        <span class="p-r-2">Minimum: {{ asmoney($value['minimum'],$free=false) }}</span>
                        @if(!$value["is_pickup"])
                            <span class="p-r-2">Delivery only</span>
                        @endif
                    @elseif($value["is_pickup"])
                        <span class="p-r-2">Pickup only</span>
                        @endif
                                <!--span class="label label-warning">Tags: {{ $value['tags'] }}</span-->

                        @if(isset($latitude) && $radius)
                            <span class="p-r-2">Distance: {{ round($value['distance'],2) }} km</span>
                        @endif
                        @if(false)
                            {{ $value['address'] }}, {{ $value['city'] }}, {{ $value['province'] }}, {{ select_field("countries", 'id', $value['country'], 'name') }}

                            <span class="label label-pill label-{{ iif($is_open, "warning", "danger") }}"
                                  TITLE="{{ $Day }}">Hours: {{ left($open, strlen($open) - 3) . " - " . left($close, strlen($close) - 3) }}</span>
                        @endif



                </div>



                <div class="clearfix"></div>

            </div>
            
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


</div>

<script>

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