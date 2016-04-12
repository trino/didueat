<?php
if (!function_exists("toseconds")) {
    printfile("dashboard/restaurant/restaurantpanel.blade.php");
    //convert a 24hr time into seconds
    function toseconds($Time)
    {
        if (strpos($Time, ":") !== false) {
            $Time = explode(":", $Time);
            return $Time[0] * 3600 + $Time[1] * 60 + $Time[2];
        }
        return $Time;
    }

    //get a rough estimate of the difference between 2 times
    function timediff($Start, $End = false)
    {//end is the bigger time
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
if (!$is_open) {
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
$alts = array(
        "restaurants/menu" => "View Restaurant",
        "View Menu" => "View this restaurant's menu",
        "Order Online" => "Order from this restaurant's menu",
        "moredetails" => "View more information about this restaurant",
        "logo" => "This restaurant's logo"
);
?>
<div class="list-group-item">
    <div class="col-md-3 col-xs-3 p-a-0" style="z-index: 1;">
        <div class="p-r-1">

            @if(isset($details) && $details)
                <img style="max-width:100%;" class="img-rounded" alt="{{ $alts["logo"] }}" src="{{ $logo }}">
                <div class="clearfix"></div>

            @else
                <a href="{{ url('restaurants/' . $Restaurant['slug'] . '/menu') }}?delivery_type={{ $delivery_type }}"
                   class="restaurant-url" title="{{ $alts["restaurants/menu"] }}">
                    <img style="max-width:100%;" class="img-rounded" alt="{{ $alts["logo"] }}" src="{{ $logo }}">

                    <div class="clearfix"></div>
                </a>
            @endif

        </div>
        <div class="clearfix"></div>
    </div>

    <div class="col-md-9 p-a-0">
        <h4 style="margin-bottom: .1rem !important;">


            @if(isset($order))


                <a class="card-link restaurant-url"
                   href="{{ url('restaurants/'.$Restaurant['slug'].'/menu') }}?delivery_type={{ $delivery_type }}"
                   title="{{ $alts["restaurants/menu"] }}">
                    {{ $Restaurant['name'] }}


                    <div class="pull-right">
                        <a href="{{ url('restaurants/'.$Restaurant['slug'].'/menu') }}?delivery_type={{ $delivery_type }}"
                           class="restaurant-url btn @if($Message=='View Menu') btn-secondary @else btn-primary @endif hidden-sm-down"
                           title="{{ $alts[$Message] }}">{{ $Message }}</a>
                    </div>


                </a>
            @else
                {{ $Restaurant['name'] }}


            @endif


        </h4>



            @if(!$is_open)
                <div class="smallT">{{ $MoreTime }}</div>
            @endif
            {!! rating_initialize("static-rating", "restaurant", $Restaurant['id']) !!}
@if($Restaurant["cuisine"])
            <span class="list-inline-item"> {{ str_replace(",", ", ", $Restaurant["cuisine"]) }}</span>
@endif
            <div class="clearfix"></div>


    <span class="list-inline-item"> {{ $Restaurant['phone'] }} </span> <span class="list-inline-item">{{ $Restaurant['address'] }}, {{ $Restaurant['city'] }} </span>
        <div class="clearfix"></div>

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

            @if(isset($details) && $details)
                <a class="list-inline-item" class="clearfix" href="#" data-toggle="modal" data-target="#viewMapModel"
                   title="{{ $alts["moredetails"] }}">More Details</a>
            @endif
    </div>
    <div class="clearfix"></div>
</div>

<?php
if (isset($is_menu)) {
    $menuitems = enum_all("menus", array("restaurant_id" => $Restaurant["id"], "is_active" => 1));
    if ($menuitems) {
        echo '<div class="list-group-item"><table style="min-width: 100% !important;" class="table m-b-0"><THEAD><TR><TH style="border-top:0;">Item</TH><TH style="border-top:0;">Cost</TH></TR></THEAD>';
        foreach ($menuitems as $menuitem) {
            //'restaurant_id', 'menu_item', 'description', 'price', 'rating', 'additional', 'has_addon', 'image', 'type', 'parent', 'req_opt', 'sing_mul', 'exact_upto', 'exact_upto_qty', 'display_order', 'cat_id', 'has_discount', 'discount_per', 'days_discount', 'is_active', 'uploaded_by', 'cat_name', 'uploaded_on'
            $filename = asset("assets/images/restaurants/" . $Restaurant["id"] . "/menus/" . $menuitem->id . "/icon-" . $menuitem->id . ".jpg");
            echo '<TR><TD><IMG style="width: 64px; height: 64px;" SRC="' . $filename . '">' . $menuitem->menu_item . '</TD>';

            echo '<TD style="vertical-align: middle;">' . asmoney($menuitem->price) . '</TD></TR>';
        }
        echo '</TABLE><div class="clearfix"></div></DIV>';
    }
}
?>