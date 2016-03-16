<?php
    if(!function_exists("toseconds")){
        printfile("dashboard/restaurant/restaurantpanel.blade.php");
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
    }

    if(is_object($Restaurant)){
        $Restaurant = getProtectedValue($Restaurant, "attributes");
    }

    $logo = 'small-smiley-logo.png';
    if($Restaurant['logo'] && file_exists(public_path('assets/images/restaurants/' . $Restaurant['id'] . '/small-' . $Restaurant['logo']))){
        $logo = 'restaurants/' . $Restaurant['id'] . '/small-' . $Restaurant['logo'];
    }
    $Restaurant['tags'] = str_replace(",", ", ", $Restaurant['tags']);
    if ($Restaurant['is_delivery']) {
        $Delivery_enable = "Delivery";
    }
    if ($Restaurant['is_pickup']) {
        $Pickup_enable = "Pickup";
    }
    if(!isset($delivery_type)){
        $delivery_type = "is_pickup";
    }
    //check if the store is opened, based on it's hours
    $key = iif($delivery_type == "is_delivery", "_del");
    $is_open = \App\Http\Models\Restaurants::getbusinessday(array_to_object($Restaurant), $Restaurant['open']);
    $Day = current_day_of_week();

    $MoreTime = "";
    $grayout="";
    $Message = "Order Online";

    if(!$Restaurant['open']){
        $Message = "View Menu";
    }

    if(!$is_open){
        $grayout=" grayout";
        $open = $Restaurant[$Day . "_open" . $key];// offsettime($Restaurant[$Day . "_open" . $key], $difference);
        $close = $Restaurant[$Day . "_close" . $key];//offsettime($Restaurant[$Day . "_close" . $key], $difference);
        if($Restaurant['open']){
            if($open == $close){
                $MoreTime = "Doesn't open today";
            } else if($open > $user_time){
                $MoreTime = "Opens in: ~" . timediff($open, $user_time);
            } else if ($close < $user_time) {
                $MoreTime = "Closed: ~" . timediff($user_time, $close) . " ago";
            }
        } else {
            $MoreTime = "Not accepting orders";
        }
    }
?>
<div class="list-group-item">
    <div class="col-md-3 col-xs-3 p-a-0" style="z-index: 1;">
        <div class="p-r-1" >
            <a href="{{ url('restaurants/' . $Restaurant['slug'] . '/menu') }}?delivery_type={{ $delivery_type }}" class="restaurant-url">
                <img style="max-width:100%;" class="img-rounded" alt="" src="{{ asset('assets/images/' . $logo) }}">
                <div class="clearfix"></div>
            </a>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="col-md-9 p-a-0">
        <a class="card-link restaurant-url" href="{{ url('restaurants/'.$Restaurant['slug'].'/menu') }}?delivery_type={{ $delivery_type }}">
            <h4 style="margin-bottom: 0 !important;">
                {{ $Restaurant['name'] }}
                @if(isset($order))
                    <div class="pull-right">
                        <a href="{{ url('restaurants/'.$Restaurant['slug'].'/menu') }}?delivery_type={{ $delivery_type }}" class="restaurant-url btn @if($Message=='View Menu')btn-secondary @else btn-primary @endif hidden-sm-down">{{ $Message }}</a>
                    </div>
                @endif
            </h4>
        </a>

        <div>
            @if(!$is_open)
                <div class="smallT">Currently closed</div>
            @endif
            {!! rating_initialize("static-rating", "restaurant", $Restaurant['id']) !!}

            <span class="list-inline-item"> {{ str_replace(",", ", ", $Restaurant["cuisine"]) }}</span>

            <div  class="clearfix"></div>
        </div>


        <div>{{ $Restaurant['address'] }}, {{ $Restaurant['city'] }}</div>

        @if($Restaurant["is_delivery"])
            @if(!$Restaurant["is_pickup"])
                <span class="list-inline-item"><strong>Delivery only</strong></span>
            @endif
            <span class="list-inline-item">Delivery: {{ asmoney($Restaurant['delivery_fee'],$free=true) }}</span>
            <span class="list-inline-item">Minimum: {{ asmoney($Restaurant['minimum'],$free=false) }}</span>
        @elseif($Restaurant["is_pickup"])
            <span class="list-inline-item"><strong>Pickup only</strong></span>
        @endif

        <!--span class="label label-warning">Tags: {{ $Restaurant['tags'] }}</span-->

        @if(isset($latitude) && $radius && $Restaurant['distance'])
            <span class="list-inline-item">Distance: {{ round($Restaurant['distance'],2) }} km</span>
        @endif

        @if(isset($MoreTime) && $MoreTime && debugmode())
            <span class="list-inline-item" style="color: red;">{{ $MoreTime }}</span>
        @endif

    </div>
    <div class="clearfix"></div>
</div>