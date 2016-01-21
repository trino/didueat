<?php
    function offsettime($time, $hours = 0){
        if($hours){
            $time = explode(":", $time);
            $time[0] = $time[0] + $hours;
            if($time[0] < 0){$time[0] += 24;}
            if($time[0] > 23){$time[0] -= 24;}
            $time = implode(":", $time);
        }
        return $time;
    }

    if(isset($data['data'])){parse_str($data['data']);}
    $server_gmt = date('Z') / 3600;
    $user_gmt = \Session::get('session_gmt', $server_gmt);
    $difference = $server_gmt - $user_gmt;
    $server_time = date('H:i:s');
    $user_time = date('H:i:s', strtotime(iif($difference >-1, '+') . $difference . ' hours'));
    if(!isset($sql)){
        $sql = "Server GMT: " . $server_gmt . " User GMT: " . $user_gmt . " Difference: " . $difference . " hours Server Time: " . $server_time. " User Time: " . $user_time;
    }
    printfile("<BR>" . $sql . "<BR>views/ajax/search_restaurants.blade.php");
?>
<DIV class="">
    <DIV class="list-group" id="restuarant_bar">
        @if(isset($query) && $count > 0 && is_iterable($query))
            @foreach($query as $value)
                <?php
                    $logo = ($value['logo'] != "") ? 'restaurants/' . $value['id'] . '/' . $value['logo'] : 'default.png';
                    $value['tags'] = str_replace(",", ", ", $value['tags']);
                    $Modes = array();
                    if($value['is_delivery']){$Modes[] = "Delivery";}
                    if($value['is_pickup']){$Modes[] = "Pickup";}
                    $Modes = implode(", ", $Modes);
                    $key = iif($delivery_type == "is_delivery", "_del");
                    $Day = current_day_of_week();
                    $open = offsettime($value[$Day . "_open" . $key], $difference);
                    $close = offsettime($value[$Day . "_close" . $key], $difference);
                    $is_open = $open <= $user_time && $close >= $user_time;
                ?>
                <a href="{{ url('restaurants/'.$value['slug'].'/menus') }}" class="list-group-item">
                    <img style="width:100px;" class="pull-right img-responsive full-width" alt="" src="{{ asset('assets/images/' . $logo) }}">
                    <h4>{{ $value['name'] }}</h4>
                    <p class="card-text">{{ $value['address'] }}, {{ $value['city'] }}, {{ $value['province'] }}, {{ select_field("countries", 'id', $value['country'], 'name') }}, {{ $value['phone'] }}</p>
                    <span class="label label-primary label-pill">{{ $Modes }}</span>
                    <span class="label label-warning label-pill">Minimum Delivery: {{ asmoney($value['minimum']) }}</span>
                    <span class="label label-success label-pill">Delivery Fee: {{ asmoney($value['delivery_fee']) }}</span>
                    <!--span class="label label-warning">Tags: {{ $value['tags'] }}</span-->
                    <span class="label label-success label-pill">Cuisine: {{ select_field("cuisine", "id", $value['id'], "name") }}</span>
                    <span class="label label-pill label-{{ iif($is_open, "primary", "danger") }}" TITLE="{{ $Day }}">Hours: {{ left($open, strlen($open) - 3) . " - " . left($close, strlen($close) - 3) }}</span>
                    @if(isset($latitude) && $radius)
                        <span class="label label-info">Distance: {{ round($value['distance'],2) }} km</span>
                    @endif
                    {!! rating_initialize("static-rating", "restaurant", $value['id']) !!}
                </A>
            @endforeach
        @endif
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
    </DIV>
</DIV>
<img class='parentLoadingbar' src="{{ asset('assets/images/loader.gif') }}" style="display: none;"/>