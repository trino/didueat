<?php
    $alts = array(
            "restaurants/menu" => "View Restaurant",
            "View Menu" => "View this restaurant's menu",
            "Order Online" => "Order from this restaurant's menu",
            "moredetails" => "View more information about this restaurant",
            "logo" => "This restaurant's logo"
    );

    if (!function_exists("toseconds")) {
        printfile("dashboard/restaurant/restaurantpanel.blade.php");
        //convert a 24hr time into seconds
        function toseconds($Time) {
            if (strpos($Time, ":") !== false) {
                $Time = explode(":", $Time);
                return $Time[0] * 3600 + $Time[1] * 60 + $Time[2];
            }
            return $Time;
        }

        //get a rough estimate of the difference between 2 times
        function timediff($Start, $End = false) {//end is the bigger time
            $Start = toseconds($Start);
            if (!$End) {
                $End = time();
            }
            $End = toseconds($End);
            $Diff = abs($End - $Start);
            return durationtotext($Diff, false, ", ");
        }
    }

    if (is_object($Restaurant)) {
        $Restaurant = getProtectedValue($Restaurant, "attributes");
    }

    $logo = defaultlogo($Restaurant);
    $Restaurant['tags'] = str_replace(",", ", ", $Restaurant['tags']);
    if ($Restaurant['is_delivery']) {
        $Delivery_enable = "Delivery";
    }
    if ($Restaurant['is_pickup']) {
        $Pickup_enable = "Pickup";
    }
    if (!isset($delivery_type)) {
        $delivery_type = "is_pickup";
    }
    $key = iif($delivery_type == "is_delivery", "_del"); //check if store is open
    $is_open = \App\Http\Models\Restaurants::getbusinessday($Restaurant);

    $MoreTime = "";
    $grayout = "";
    $Message = "Order Online";
    if (!$Restaurant['open']) {
        $Message = "View Menu";
    }

    $user_time = date('H:i:s');

    $Day = current_day_of_week();
    if ($is_open) {
        $open = converttime($Restaurant[$is_open . "_open" . $key]);
        $close = converttime($Restaurant[$is_open . "_close" . $key]);
        $MoreTime = "Open " . strtolower($is_open) . " from " . $open . " to " . $close;
    } else {
        $MoreTime = "Currently closed";
        $grayout = " grayout";
        if ($Restaurant['open']) {
            for ($day = 0; $day < 7; $day++) {
                $Day = current_day_of_week($day);
                $open = $Restaurant[$Day . "_open" . $key];
                $close = $Restaurant[$Day . "_close" . $key];
                if ($open && $close && $open != $close) {
                    $Date = strtotime($open, time() + ($day * 86400));
                    //$MoreTime = "Opens in " . timediff($Date);
                    $MoreTime = "Opens ";
                    if ($day == 0) {
                        $MoreTime .= "today";
                    } else if ($day == 1) {
                        $MoreTime .= "tomorrow";
                    } else {
                        $MoreTime .= "in " . $day . " days";
                    }
                    $MoreTime .= " at " . converttime($open);
                    break;
                }
            }
        } else {
            // $MoreTime = "Not accepting orders";
        }
    }
?>

<div class="card-header" style=" @if(!isset($order)) background: white !important; margin-bottom:1rem !important;    box-shadow: 0 1px 1px rgba(0,0,0,.1) !important;
@endif ">

    <div class="col-md-2 col-xs-3 p-a-0" style="z-index: 1;">
        <div class="p-r-1">

            @if(isset($details) && $details)
                <img style="max-width:100%;" class="img-circle" alt="{{ $alts["logo"] }}" src="{{ $logo }}">
                <div class="clearfix"></div>
            @else
                <a href="{{ url('restaurants/' . $Restaurant['slug'] . '/menu') }}?delivery_type={{ $delivery_type }}"
                   class="restaurant-url" title="{{ $alts["restaurants/menu"] }}">
                    <img style="max-width:100%;" class="img-circle" alt="{{ $alts["logo"] }}" src="{{ $logo }}">

                    <div class="clearfix"></div>
                </a>
            @endif

        </div>
        <div class="clearfix"></div>
    </div>

    <div class="col-md-10 p-a-0 ">
        <h3 style="margin-bottom: .2rem !important;">
            @if(isset($order))
                <a class="card-link restaurant-url"
                   href="{{ url('restaurants/'.$Restaurant['slug'].'/menu') }}"
                   title="{{ $alts["restaurants/menu"] }}">
                    {{ printfile("(ID: " . $Restaurant["id"] . ") ") . $Restaurant['name'] }}
                </a>
                <!--div class="pull-right">
                    <a href="{{ url('restaurants/'.$Restaurant['slug'].'/menu') }}?delivery_type={{ $delivery_type }}"
                       class="restaurant-url btn @if($Message=='View Menu') btn-secondary @else btn-primary @endif hidden-sm-down"
                       title="{{ $alts[$Message] }}">{{ $Message }}</a>
                </div-->

            @else
                {{ $Restaurant['name'] }}

            @endif

        </h3>
        <div class=" text-muted">

            @if($MoreTime)
                <div class="smallT">{{ $MoreTime }}</div>
            @endif
            {!! rating_initialize("static-rating", "restaurant", $Restaurant['id']) !!}
            @if($Restaurant["cuisine"])
                <span class="list-inline-item"> {{ str_replace(",", ", ", $Restaurant["cuisine"]) }}</span>
                @endif

                        <!--span class="list-inline-item"> {{ $Restaurant['phone'] }} </span> <span class="list-inline-item">{{ $Restaurant['address'] }}
                        , {{ $Restaurant['city'] }} </span>
        <div class="clearfix"></div-->

                @if(isset($latitude) && $radius && $Restaurant['distance'] && false)
                    <span class="list-inline-item">Distance: {{ round($Restaurant['distance'],2) }} km</span>
                @endif

                @if(isset($details) && $details)

                    @if(false)
                        @if($Restaurant["is_delivery"])
                            @if(!$Restaurant["is_pickup"])
                                <!--span class="list-inline-item"><strong>Delivery only</strong></span-->
                            @endif
                            <span class="list-inline-item">Delivery: {{ asmoney($Restaurant['delivery_fee'],$free=true) }}</span>
                            <span class="list-inline-item">Minimum: {{ asmoney($Restaurant['minimum'],$free=false) }}</span>
                        @elseif($Restaurant["is_pickup"])
                            <!--span class="list-inline-item"><strong>Pickup only</strong></span-->
                        @endif
                    @endif


                    <a class="list-inline-item" class="clearfix" href="#" data-toggle="modal"
                       data-target="#viewMapModel"
                       title="{{ $alts["moredetails"] }}">More Details</a>

                    @if(read("profiletype") == 1)
                        <A HREF="{{ url("restaurant/info/" . $Restaurant["id"]) }}">Edit</A>
                    @endif
                @endif


        </div>
    </div>

    <div class="clearfix"></div>
</div>


<?php
if (isset($is_menu)) {

?>
<div class="">

    <a href="{{ url('restaurants/'.$Restaurant['slug'].'/menu') }}?delivery_type={{ $delivery_type }}"
       style="text-decoration:none;">

        <?
        $menuitems = enum_all("menus", array("restaurant_id" => $Restaurant["id"], "is_active" => 1));
        if ($menuitems) {
            echo '<div class="list-group-item" style="padding-top: 0rem !important; "></div>';
            $i = 0;
            foreach ($menuitems as $menuitem) {
                echo '<div class="list-group-item" style="padding-top: .25rem !important;padding-bottom: .25rem !important; ">';
                //'restaurant_id', 'menu_item', 'description', 'price', 'rating', 'additional', 'has_addon', 'image', 'type', 'parent', 'req_opt', 'sing_mul', 'exact_upto', 'exact_upto_qty', 'display_order', 'cat_id', 'has_discount', 'discount_per', 'days_discount', 'is_active', 'uploaded_by', 'cat_name', 'uploaded_on'
                $filename = file_exists("assets/images/restaurants/" . $Restaurant["id"] . "/menus/" . $menuitem->id . "/icon-" . $menuitem->id . ".jpg");
                if (($filename == 1)) {
                    //echo $filename;
                    $filename = asset("assets/images/restaurants/" . $Restaurant["id"] . "/menus/" . $menuitem->id . "/icon-" . $menuitem->id . ".jpg") . ' ';
                    echo '<IMG style="width: 34px; height: 34px;" class="img-rounded" SRC="' . $filename . '">';
                }
                echo ' ' . $menuitem->menu_item . '';
                echo '<span style="white-space: nowrap;"> &ndash; ' . asmoney($menuitem->price) . '</span><div class="clearfix " style="margin-bottom:.1rem;"></div>';
                echo '</div>';

                $i++;
                if ($i == 5) {
                    break;
                }
            }
        }
        echo '<div class="list-group-item" style="padding-top: 0rem !important; "></div>';


        ?>
    </a>

    <div class="clearfix"></div>
</div>


<?
}
?>
