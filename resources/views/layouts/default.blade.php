<?php
printfile("views/dashboard/layouts/default.blade.php");
if (!isset($userAddress)) {
    $userAddress = "";
}
if (!isset($radiusSelect)) {
    $radiusSelect = "";
}
$nextPath = "";
if (Request::path() !== null && Request::path() != "/") {
    $nextPath = "/" . Request::path();
}
?>
        <!DOCTYPE html>
<html lang="en">
<head>
    <?php $start_loading_time = microtime(true); ?>
    <title>{{ (isset($title))?$title.' | ':'' }}diduEAT</title>

    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <meta content="{{ (isset($title))?$title.' | ':'' }}Did u eat" name="keywords">
    <meta content="Didueat" name="author">
    <meta name="content-language" content="fr-CA"/>
    <meta http-equiv="content-language" content="fr-CA"/>
    <meta content="{{ (isset($meta_description))? substr($meta_description,0,160):'didueat.com is very good from all over the world.' }}"
          name="description">

    <meta property="og:site_name" content="Didueat">
    <meta property="og:title" content="{{ (isset($title))?$title.' | ':'' }}DidUEat">
    <meta property="og:description"
          content="{{ (isset($meta_description))? substr($meta_description,0,160):'didueat.com is very good from all over the world.' }}">
    <meta property="og:type" content="website">
    <meta property="og:image" content="-CUSTOMER VALUE-">
    <meta property="og:url" content="{{ url('/') . $nextPath }}">
    <meta name="_token" content="{{ csrf_token() }}"/>
    
    <link rel="shortcut icon" href="{{ url('/favicon.ico') }}" type="image/vnd.microsoft.icon"/>
    <link rel="icon" href="{{ url('/favicon.ico') }}" type="image/vnd.microsoft.icon"/>

    <link href="{{ asset('assets/global/css/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet"
          integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" crossorigin="anonymous">
    <!--link href="https://bootswatch.com/lumen/bootstrap.css" rel="stylesheet" integrity="" crossorigin="anonymous"-->

    <link href="{{ asset('assets/global/css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet"/>

    <link href="{{ asset('assets/global/css/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/css/custom_css.css') }}" rel="stylesheet">

    <!--link href="{{ asset('assets/global/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet"-->
    <link href="{{ asset('assets/global/scripts/jqueryui/jquery-ui.css') }}" rel="stylesheet">
    <!--link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'-->

    <script src="{{ asset('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/scripts/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery-migrate.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/global/scripts/menu_manager.js') }}"></script>
    <script src="{{ asset('assets/global/scripts/upload.js') }}"></script>
    <script src="{{ asset('assets/global/scripts/jqueryui/jquery-ui.js') }}"></script>
    <script src="{{ asset('assets/global/plugins/carousel-owl-carousel/owl-carousel/owl.carousel.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/fancybox/source/jquery.fancybox.pack.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/carousel-owl-carousel/owl-carousel/owl.carousel.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/zoom/jquery.zoom.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/slider-layer-slider/js/greensock.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/slider-layer-slider/js/layerslider.transitions.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/slider-layer-slider/js/layerslider.kreaturamedia.jquery.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/global/scripts/layerslider-init.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/scripts/layout.js') }}" type="text/javascript"></script>

    <script src="{{ asset('assets/global/scripts/jquery.tag-editor.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/scripts/jquery.caret.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/scripts/jquery.cookie.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/scripts/custom-datatable/bootbox.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/scripts/receipt.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/scripts/additional.js') }}" class="ignore"></script>
    <script type="text/javascript"
            src="{{ asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}"></script>
</head>
<body>

@include('popups.login')
@include('popups.signup')
@include('popups.forgot-password')

@include('layouts.includes.header')

<div class="container m-t-3 p-t-2">
    @if (session('status'))
        <div class="alert alert-success"> 
            {{ session('status') }}
        </div>
    @endif

    <?php
    
    $step1CompleteMsg="";

    $Restaurant = \Session::get('session_restaurant_id', 0);
    if ($Restaurant) {
        $Restaurant = select_field("restaurants", "id", $Restaurant);
        if ($Restaurant) {
            $MissingData = [];
            $MissingDataOptional = [];
            if (!$Restaurant->is_delivery && !$Restaurant->is_pickup) {
                $MissingData[] = "Pickup and/or Delivery options <a href=\"".url('restaurant/info')."#PickupAndDelivery\">(<u>Click to Set Delivery Options</u>)</a>";
            }
            if (!$Restaurant->logo) {
                $MissingData[] = "Your Restaurant logo <a href=\"".url('restaurant/info')."#setlogo\">(<u>Click to Set Restaurant Logo</u>)</a>";
            }

            if (!$Restaurant->latitude || !$Restaurant->longitude) {
                $MissingData[] = "Restaurant address <a href=\"".url('restaurant/info')."#RestaurantAddress\" class=\"missLnk\">(<u>Click to Set Restaurant Address</u>)</a>";
            }

//          if(!$Restaurant->open){$MissingData[] = "to be set to open";}
//          if(!$Restaurant->status){$MissingData[] = "status to be set to 'Active'";}
            if ($Restaurant->max_delivery_distance < 2) {
                $MissingDataOptional[] = "Delivery range <a href=\"".url('restaurant/info')."#HoursOpen\">(<u>Click to Set Delivery Range</u>)</a>";
            }
            if (!$Restaurant->minimum || $Restaurant->minimum == "0.00") {
                $MissingDataOptional[] = "Minimum delivery sub-total <a href=\"".url('restaurant/info')."#HoursOpen\">(<u>Click to Set Delivery Minimum</u>)</a>";
            }

            //check hours of operation
            $weekdays = getweekdays();
            $DayOfWeek = current_day_of_week();
            $now = date('H:i:s');
            foreach ($weekdays as $weekday) {
                foreach (array("_open", "_close", "_open_del", "_close_del") as $field) {
                    $field = $weekday . $field;
                    if ($Restaurant->$field != "12:00:00") {
                        $weekdays = false;
                        break;
                    }
                }
                if (!$weekdays) {
                    break;
                }
            }
            if ($weekdays) {
                $MissingData[] = "Hours of operation <a href=\"".url('restaurant/info')."#HoursOpen\">(<u>Click to Set Hours of Operation</u>)</a>";
            } else {
                if (getfield($Restaurant, $DayOfWeek . "_open") > $now || getfield($Restaurant, $DayOfWeek . "_close") < $now) {
                    $MissingData[] = "Hours Open <a href=\"".url('restaurant/info')."#HoursOpen\">(<u>Click to Set Hours Open</u>)</a>";
                }
                if (getfield($Restaurant, $DayOfWeek . "_open_del") > $now || getfield($Restaurant, $DayOfWeek . "_close_del") < $now) {
                    $MissingData[] = "Delivery Times <a href=\"".url('restaurant/info')."#DeliveryTimes\">(<u>Click to Set Delivery Times</u>)</a>";
                }
            }

            //check credit card
            $creditcards = select_field_where("credit_cards", array("user_type" => "restaurant", "user_id" => $Restaurant->id), "COUNT()");
            if (!$creditcards) {
                $MissingData[] = "Your credit card authorization <a href=\"".url('credit-cards/list/restaurant')."\">(<u>Click to Set Credit Card</u>)</a>";
            }

            if ($MissingData) {
                if(isset($post['initialRestSignup'])){
                      $missingHead="PARTIAL REGISTRATION COMPLETED!";
                } else{
                      $missingHead="PLEASE COMPLETE THE FOLLOWING IN ORDER TO START ACCEPTING ORDERS";
                }
                $MissingData = array_merge($MissingData, $MissingDataOptional);

                $MissingData = "<br/>Please click the links below, and/or use the Restaurant Navigation links on the left side below, to finish setting up your restaurant with the following: <div style='margin-left:100px;color:#000;font-weight:bold'>&bull; " . implode("<br/>&bull; ", $MissingData) . "</div>";
                echo '<div class="alert alert-danger" ID="invalid-data"><STRONG><u>'.$missingHead.'</u></STRONG>' . $MissingData . '</DIV>';
            }
        }
    }
    if (\Session::has('invalid-data')) {
        $fields = Session::get('invalid-data');
        $message = "The following field" . iif(count($fields) == 1, " is", "s are") . " invalid: <SPAN ID='invalid-fields'>" . implode(", ", $fields) . '</SPAN>';
        echo '<div class="alert alert-danger" ID="invalid-data"><STRONG>Invalid Data</STRONG>&nbsp;' . $message . '</DIV>';
        \Session::forget('invalid-data');
    }
    ?>

    @if(\Session::has('message-type') && Session::get('message'))
        <div class="alert {!! Session::get('message-type') !!}">
            <strong>{!! Session::get('message-short') !!}</strong>
            &nbsp; {!! Session::get('message') !!}
        </div>
        <?php \Session::forget('message'); ?>
    @endif

    @yield('content')
</div>

@include('layouts.includes.footer')
</body>
</html>
<SCRIPT>
    //attempts to replace the field name with it's label for invalid data
    $(document).ready(function () {
        var element = document.getElementById("invalid-fields");
        if (element) {
            var fields = element.innerHTML.split(", ");
            for (i = 0; i < fields.length; i++) {
                fields[i] = getfieldlabel(fields[i]);
            }
            element.innerHTML = fields.join(", ");
        }
    });

    function getfieldlabel(field) {
        element = document.getElementsByName(field)[0];
        if (element) {
            element = element.parentElement.parentElement;
            if (element) {
                var children = element.children;
                for (var j = 0; j < children.length; j++) {
                    element = children[j];
                    if (element.tagName = "label" && element.innerText) {
                        field = element.innerText;
                    }
                }
            }
        }
        return field.replace(":", "");
    }
</SCRIPT>