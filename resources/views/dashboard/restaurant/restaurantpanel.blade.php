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

    function link_it($text) {
        $text = preg_replace("/(^|[\n ])([\w]*?)([\w]*?:\/\/[\w]+[^ \,\"\n\r\t<]*)/is", "$1$2<a href=\"$3\" >$3</a>", $text);
        $text = preg_replace("/(^|[\n ])([\w]*?)((www)\.[^ \,\"\t\n\r<]*)/is", "$1$2<a href=\"http://$3\" >$3</a>", $text);
        $text = preg_replace("/(^|[\n ])([\w]*?)((ftp)\.[^ \,\"\t\n\r<]*)/is", "$1$2<a href=\"ftp://$3\" >$3</a>", $text);
        $text = preg_replace("/(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+)+)/i", "$1<a href=\"mailto:$2@$3\">$2@$3</a>", $text);
        return ($text);
    }
}

if (is_object($Restaurant)) {
    if (isset($isgood)) {
        $Restaurant = object_to_array($Restaurant);
    } else {
        $Restaurant = getProtectedValue($Restaurant, "attributes");
    }
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
if (!isset($IncludeMenu)) {
    $IncludeMenu = false;
}

if (isset($user_time) && $user_time) {
    $user_time = strtotime($user_time);
    $Day = current_day_of_week($user_time);
    $is_open = \App\Http\Models\Restaurants::getbusinessday($Restaurant, $user_time);
    $user_time = date('H:i:s', $user_time);
} else {
    $user_time = date('H:i:s');
    $Day = current_day_of_week();
    $is_open = \App\Http\Models\Restaurants::getbusinessday($Restaurant);
}

$key = iif($delivery_type == "is_delivery", "_del"); //check if store is open

$MoreTime = "";
$grayout = "";
$Message = "Order Online";
if (!$Restaurant['open']) {
    $Message = "View Menu";
}

if ($is_open) {
    if (isset($showtoday) || debugmode()) {
        $open = converttime($Restaurant[$is_open . "_open" . $key]);
        $close = converttime($Restaurant[$is_open . "_close" . $key]);
        $MoreTime = "Open " . $open . " to " . $close;
    }
} else {
    $MoreTime = "Currently closed";
    $grayout = " grayout";
    if ($Restaurant['open']) {
        for ($day = 0; $day < 7; $day++) {
            $Day = current_day_of_week($day);
            $open = $Restaurant[$Day . "_open" . $key];
            $close = $Restaurant[$Day . "_close" . $key];
            if ($open && $close && $open != $close) {
                $allowbreak = true;
                $Date = strtotime($open, time() + ($day * 86400));
                //$MoreTime = "Opens in " . timediff($Date);
                $MoreTime = "Opens ";
                if ($day == 0) {
                    $MoreTime .= "today";
                    if ($close > $open && $close < $user_time) {
                        $allowbreak = false;
                    } //closed for today already
                } else if ($day == 1) {
                    $MoreTime .= "tomorrow";
                } else {
                    $MoreTime .= "in " . $day . " days";
                }
                if ($allowbreak) {
                    $MoreTime .= " at " . converttime($open);
                    if($open == "12:00:00"){
                        $MoreTime .= " (noon)";
                    } else if($open == "00:00:00"){
                        $MoreTime .= " (midnight)";
                    }
                    $MoreTime = '<FONT COLOR="RED">' . $MoreTime . '</FONT>';
                    break;
                }
            }
        }
    } else if (debugmode()) {
         $MoreTime = "Not accepting orders";
    }
}

if ($IncludeMenu) {
    if ($is_open) {
        $OnClick = 'onclick="loadmenu(' . $Restaurant["id"] . ');" ';
    } else {
        $OnClick = 'onclick="alert(' . "'" . strip_tags($MoreTime) . "'" . ');" ';
    }
} else {
    $OnClick = 'href="' . url('restaurants/' . $Restaurant['slug'] . '/menu') . '" ';//oldurl="?delivery_type={{ $delivery_type }}"
}

    if(isset($Restaurant["franchiseid"])){
        $Restaurant["franchiseid"] = " - FID: " . $Restaurant["franchiseid"];
    }else {
        $Restaurant["franchiseid"] = "";
    }
?>


<ul class="m-b-1 p-a-1 list-group" id="card-header-{{ $Restaurant["id"] }}" style="border:1px solid #eee; background:white; @if(!isset($order)) @endif ">

    @if(isset($order))

        <a class="card-link restaurant-url" {!! $OnClick !!} title="{{ $alts["restaurants/menu"] }}">
            <h4 class="m-b-0">
                {{ printfile("(ID: " . $Restaurant["id"] . $Restaurant["franchiseid"] . ") ") . $Restaurant['name'] }}
            </h4>
            @if($Restaurant["cuisine"])
                <span class="text-muted">
                    {{ str_replace(",", ", ", $Restaurant["cuisine"]) }}
                </span>
            @endif
        </a>

        <span class="pull-right"> {!! rating_initialize("static-rating no-rating", "restaurant", $Restaurant['id']) !!} </span>

        @if($MoreTime)
            <span class="error"> {!! $MoreTime !!} </span>
        @endif
    @endif

    @if(isset($latitude) && $radius && $Restaurant['distance'] && false)
        <span class="list-inline-item">Distance: {{ round($Restaurant['distance'],2) }} km</span>
    @endif

    @if(isset($Restaurant["notes"]) && isset($showtoday) && false)
        {!! link_it($Restaurant["notes"]) !!}
    @endif

    <div class="clearfix"></div>

</ul>






@if(isset($details) && $details && false)
    @if(false)
        @if($Restaurant["is_delivery"])
            @if(!$Restaurant["is_pickup"])
            @endif
            <span class="list-inline-item">Delivery: {{ asmoney($Restaurant['delivery_fee'],$free=true) }}</span>
            <span class="list-inline-item">Minimum: {{ asmoney($Restaurant['minimum'],$free=false) }}</span>
        @elseif($Restaurant["is_pickup"])
        @endif
    @endif

    <a class="list-inline-item" class="clearfix" href="#" data-toggle="modal"
       data-target="#viewMapModel"
       title="{{ $alts["moredetails"] }}">More Details</a>

    @if(read("profiletype") == 1)
        <A HREF="{{ url("restaurant/info/" . $Restaurant["id"]) }}">Edit</A>
    @endif
@endif



@if(false)
    @if(isset($details) && $details)
        <img style="max-width:20px;" class="img-rounded" alt="{{ $alts["logo"] }}" src="{{ $logo }}">
    @else
        <a {!! $OnClick !!}
           class="restaurant-url" title="{{ $alts["restaurants/menu"] }}">
            <img style="max-width:20px;" class="img-rounded" alt="{{ $alts["logo"] }}" src="{{ $logo }}">
        </a>
    @endif
@endif



@if (isset($is_menu) && false)
    <a href="{{ url('restaurants/'.$Restaurant['slug'].'/menu') }}" oldurl="?delivery_type={{ $delivery_type }}"
       style="text-decoration:none;">
        <?php
        $menuitems = enum_all("menus", array("restaurant_id" => $Restaurant["id"], "is_active" => 1));
        if ($menuitems) {
            echo '<div class="list-group-item" style="padding-top: 0rem !important; "></div>';
            $i = 0;
            foreach ($menuitems as $menuitem) {
                echo '<div class="list-group-item" style="padding-top: .25rem !important;padding-bottom: .25rem !important; ">';
                $filename = file_exists("assets/images/restaurants/" . $Restaurant["id"] . "/menus/" . $menuitem->id . "/icon-" . $menuitem->id . ".jpg");
                if (($filename == 1)) {
                    $filename = asset("assets/images/restaurants/" . $Restaurant["id"] . "/menus/" . $menuitem->id . "/icon-" . $menuitem->id . ".jpg") . ' ';
                    echo '<IMG style="width: 34px; height: 34px;" class="img-rounded" SRC="' . $filename . '">';
                }
                echo ' ' . $menuitem->menu_item . '';
                echo '<span style="white-space: nowrap;"> &ndash; ';


                $min_p = get_price($menuitem->id);
                if ($menuitem->price > 0) {
                    echo "$" . number_format(($menuitem->price > 0) ? $menuitem->price : $min_p, 2);
                } else {
                    echo "$" . number_format($min_p, 2), "+";
                }

                echo '</span><div class="clearfix " style="margin-bottom:.1rem;"></div></div>';

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
@endif