<?php
    //convert a 24hr time into seconds
    function toseconds($Time){
        $Time = explode(":", $Time);
        return $Time[0] * 3600 + $Time[1] * 60 + $Time[2];
    }
    //get a rough estimate of the difference between 2 times
    function timediff($Start, $End){//end is the bigger time
        $Start = toseconds($Start);
        $End = toseconds($End);
        $Diff = abs($End - $Start);
        if ($Diff >= 3600){
            $Diff = round($Diff / 3600,2);
            $Unit = "hour";
        } else {
            $Diff = ceil($Diff / 60);
            if(!$Diff){$Diff = 1;}
            $Unit = "minute";
        }
        return $Diff . " " . $Unit . iif($Diff <> 1, "s");
    }

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
            $logo = ($value['logo'] != "") ? 'restaurants/' . $value['id'] . '/small-' . $value['logo'] : 'small-smiley-logo.png';
            $value['tags'] = str_replace(",", ", ", $value['tags']);
            if ($value['is_delivery']) {
                $Delivery_enable = "Delivery";
            }
            if ($value['is_pickup']) {
                $Pickup_enable = "Pickup";
            }
            if(!isset($delivery_type)){
                $delivery_type = "is_pickup";
            }
            //check if the store is opened, based on it's hours
            $key = iif($delivery_type == "is_delivery", "_del");
            $Day = current_day_of_week();
            $open = $value[$Day . "_open" . $key];// offsettime($value[$Day . "_open" . $key], $difference);
            $close = $value[$Day . "_close" . $key];//offsettime($value[$Day . "_close" . $key], $difference);
            $is_open = $open <= $user_time && $close >= $user_time && $value['open'];

            //show how long it is/was till the store opens/closed
            $MoreTime = "";
            if(!$is_open && $value['open']){
                if($open > $user_time){
                    $MoreTime = "Opens in: ~" . timediff($open, $user_time);
                } else if ($close < $user_time) {
                    $MoreTime = "Closed: ~" . timediff($user_time, $close) . " ago";
                }
            }

            $openedRest=$is_open;
            if(isset($value['openedRest'])){
                $openedRest = $value['openedRest'];
            }
            $grayout=" grayout";
            $Message = "View Menu";
            if($is_open){
                $grayout="";
                $Message = "Order Online";
            }
            ob_start();
        ?>

            <div class="list-group-item">
                <div class="col-md-3 col-xs-3 p-a-0" style="z-index: 1;">
                    <div class="p-r-1" >
                        <a href="{{ url('restaurants/'.$value['slug'].'/menu') }}?delivery_type={{ $delivery_type }}" class="restaurant-url">
                            <img style="max-width:100%;" class="" alt="" src="{{ asset('assets/images/' . $logo) }}">
                            <div class="clearfix"></div>
                        </a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="col-md-9 p-a-0">
                    <a class="card-link restaurant-url" href="{{ url('restaurants/'.$value['slug'].'/menu') }}?delivery_type={{ $delivery_type }}">
                        <h4 style="margin-bottom: 0 !important;">
                            {{ $value['name'] }}
                            <div class="pull-right">
                                <a href="{{ url('restaurants/'.$value['slug'].'/menu') }}?delivery_type={{ $delivery_type }}" class="restaurant-url btn @if($Message=='View Menu')btn-secondary @else btn-primary @endif hidden-sm-down">{{ $Message }}</a>
                            </div>
                        </h4>
                    </a>

                    <div>
                        @if(!$openedRest)
                            <div class="smallT "> Currently @if(!$value['open']) not accepting orders @else closed @endif </div>
                        @endif
                        {!! rating_initialize("static-rating", "restaurant", $value['id']) !!}
                        <div  class="clearfix"></div>
                    </div>
                    <div>{{ $value['address'] }}, {{ $value['city'] }}</div>

                    <span class="list-inline-item">Cuisine: {{ str_replace(",", ", ", $value["cuisine"]) }}</span><br>

                    @if($value["is_delivery"])

                        @if(!$value["is_pickup"])
                            <span class="list-inline-item"><strong>Delivery only</strong></span>
                        @endif

                        <span class="list-inline-item">Delivery: {{ asmoney($value['delivery_fee'],$free=true) }}</span>
                        <span class="list-inline-item">Minimum: {{ asmoney($value['minimum'],$free=false) }}</span>

                    @elseif($value["is_pickup"])
                        <span class="list-inline-item"><strong>Pickup only</strong></span>
                    @endif

                    <!--span class="label label-warning">Tags: {{ $value['tags'] }}</span-->
                    @if(isset($latitude) && $radius && $value['distance'])
                        <span class="list-inline-item">Distance: {{ round($value['distance'],2) }} km</span>
                    @endif

                    @if(false)
                        {{ $value['address'] }}, {{ $value['city'] }}, {{ $value['province'] }}, {{ select_field("countries", 'id', $value['country'], 'name') }}
                        <span class="label label-pill label-{{ iif($is_open, "warning", "danger") }}" TITLE="{{ $Day }}">Hours: {{ left($open, strlen($open) - 3) . " - " . left($close, strlen($close) - 3) }}</span>
                    @endif

                    @if($MoreTime)
                        <span class="list-inline-item">{{ $MoreTime }}</span>
                    @endif

                </div>
                <div class="clearfix"></div>
            </div>




            <?php//i don't know what this mess of code does
                if(isset($openedRest) && $openedRest == 1){
                    $openStr.="".ob_get_contents();
                } else{
                    $closedStr.="".ob_get_contents();
                }
                ob_end_clean();
                // move counter outside buffer
                $totalCnt++;
                if(isset($openedRest) && $openedRest == 1){
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
<div class="m-b-1"></div>

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
            closedCntMsg="Sorry, but all restaurants are currently closed. In the meantime, you can view the restaurants, and place your order when they are open";
        }
        document.getElementById('openClosed').innerHTML=spBR+"<BR>("+openCntMsg+closedCntMsg+")";
    }
</script>

<div id="loadMoreBtnContainer">
    @if($hasMorePage > 0)
        <div class="row">
            <div class="col-md-12 col-md-offset-5">
                <button id="loadingbutton" data-id="{{ $start }}" align="center" class="loadMoreRestaurants btn custom-default-btn" title="Load more restaurants...">Load More ...</button>
                <img class="loadingbar" src="{{ asset('assets/images/loader.gif') }}" style="display: none;"/>
            </div>
        </div>
    @endif
    <input type="hidden" id="countTotalResult" value="{{ $count }}"/>
</div>
<img id='parentLoadingbar' src="{{ asset('assets/images/loader.gif') }}" style="display: none;"/>