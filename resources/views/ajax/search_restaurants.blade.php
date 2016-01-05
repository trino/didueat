<?php
    function measuredistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = "KM") {
        switch($earthRadius){
            case "KM":$earthRadius = 6371; break;//kilometers
            case "M": $earthRadius = 6371000; break;//meters
            case "m": $earthRadius = 3959; break;//miles
        }

        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $lonDelta = $lonTo - $lonFrom;
        $a = pow(cos($latTo) * sin($lonDelta), 2) + pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
        $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

        $angle = atan2(sqrt($a), $b);
        return $angle * $earthRadius;
    }

    if(isset($data['data'])){
        parse_str($data['data']);
    }
    $notfound=0;
?>

<div class="">
    <div class="list-group" id="restuarant_bar">
        <?php printfile("views/ajax/search_restaurants.blade.php");?>
        @if(isset($query) && $count > 0 && is_iterable($query))
            @foreach($query as $value)
                <?php
                    $logo = ($value['logo'] != "") ? 'restaurants/' . $value['id'] . '/' . $value['logo'] : 'default.png';
                    $distance = 0;
                    if(isset($latitude)){
                        //$distance = measuredistance($latitude, $longitude, $value['lat'], $value['lng']);//done in the SQL
                    }
                    if($distance <= $radius){
                ?>
                    <a href="{{ url('restaurants/'.$value['slug'].'/menus') }}" class="list-group-item">

                        <img style="width:100px;" class="pull-right img-responsive full-width" alt="" src="{{ asset('assets/images/' . $logo) }}">
                        <h4>{{ $value['name'] }}</h4>

                        <p class="card-text">
                            {{ $value['address'] }}, {{ $value['city'] }}, {{ $value['province'] }}, {{ select_field("countries", 'id', $value['country'], 'name') }}, {{ $value['phone'] }}
                        </p>

                        <span class="label label-primary">Minimum Delivery: {{ $value['minimum'] }}</span>

                        <span class="label label-success">Delivery Fee: {{ $value['delivery_fee'] }}</span>

                        <span class="label label-warning">Tags:
                            <?php
                                $tag = $value['tags'];
                                $tags = explode(",", $tag);
                                for ($i = 0; $i <= 4; $i++) {
                                    if ($i == 4) {
                                        echo (isset($tags[$i])) ? $tags[$i] : '';
                                    } else {
                                        echo (isset($tags[$i])) ? $tags[$i] . ',' : '';
                                    }
                                }
                            ?>
                        </span>

                        @if(isset($latitude) && $distance)
                            <span class="label label-info">Distance:
                                {{ round($distance,2) }} km
                            </span>
                        @endif

                        {!! rating_initialize("static-rating", "restaurant", $value['id']) !!}
                    </a>



                <!--div class="row">
                    <div class="col-md-9">
                        <div class="new-layout-box-content">
                            <div class="restaurant-name">
                                <a href="{{ url('restaurants/'.$value['slug'].'/menus') }}">
                                    <h2>{{ $value['name'] }}</h2></a>
                            </div>
                            <p class="box-des">
                                {{ $value['address'] }}, {{ $value['city'] }}, {{ $value['province'] }},
                                {{ select_field("countries", 'id', $value['country'], 'name') }}
                                <br/>
                                {{ $value['phone'] }}
                            </p>

                            <span class="label label-default">Minimum Delivery: {{ $value['minimum'] }}</span>

                            <span class="label label-default">Delivery Fee: {{ $value['delivery_fee'] }}</span>

                            <span class="label label-default">Tags:
                                <?php
                                $tag = $value['tags'];
                                $tags = explode(",", $tag);
                                for ($i = 0; $i <= 4; $i++) {
                                    if ($i == 4) {
                                        echo (isset($tags[$i])) ? $tags[$i] : '';
                                    } else {
                                        echo (isset($tags[$i])) ? $tags[$i] . ',' : '';
                                    }
                                }
                                ?>
                            </span>
                            <a class="btn custom-default-btn"
                               href="{{ url('restaurants/'.$value['slug'].'/menus') }}">{{ $value['name'] }}
                                Pick-up Only</a>

                            <div class="row">
                                {!! rating_initialize("static-rating", "restaurant", $value['id']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="menu-img">
                            <a href="{{ url('restaurants/'.$value['slug'].'/menus') }}">
                                <div class="card-image">
                                    <img class="img-responsive full-width" alt=""
                                         src="{{ asset('assets/images/' . $logo) }}">
                                </div>
                            </a>
                        </div>
                    </div>
                </div-->
                <?php } else {
                    $notfound++;
                }?>
            @endforeach
        @endif
        @if($notfound)
                <DIV class="list-group-item">
                    {{$notfound}} restaurant(s) found outside your radius ({{$radius}} km)
                </DIV>
        @endif

        <div id="loadMoreBtnContainer">
            @if($hasMorePage > 0)
                <div class="row">
                    <div class="col-md-12 col-md-offset-5">
                        <button id="loadingbutton" data-id="{{ $start }}" align="center"
                                class="loadMoreRestaurants btn custom-default-btn" title="Load more restaurants...">Load
                            More ...
                        </button>
                        <img class="loadingbar" src="{{ asset('assets/images/loader.gif') }}" style="display: none;"/>
                    </div>
                </div>
            @endif
            <input type="hidden" id="countTotalResult" value="{{ $count }}"/>
        </div>
    </div>
</div>


<img class='parentLoadingbar' src="{{ asset('assets/images/loader.gif') }}" style="display: none;"/>