<!--<?php
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
//echo $nextPath; die;
?>-->
<!DOCTYPE html>
<html lang="en">
<head>
    <?php $start_loading_time = microtime(true); ?>
    <title>{{ (isset($title))?$title.' | ':'' }}DidUEat</title>

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
    <link rel="shortcut icon" href="favicon.ico" type="image/vnd.microsoft.icon"/>
    <link rel="icon" href="favicon.ico" type="image/vnd.microsoft.icon"/>

    <link href="{{ asset('assets/global/css/custom_css.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/scripts/jqueryui/jquery-ui.css') }}" rel="stylesheet">

    @if(false)
        <link href="{{ asset('assets/global/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
        <!--google font open sans -->
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic'
              rel='stylesheet' type='text/css'>
        <!--google font Montserrat -->
        <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Ubuntu:400,500|Arimo&subset=latin,latin-ext'
              rel='stylesheet' type='text/css'>
    @endif


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css"
          integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" crossorigin="anonymous">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet"/>

    <style>
        * {
            border-radius: 0 !important;
        }

        body {
            background-color: #f7f7f7 !important;
        }

        /* modal padding */
        body.modal-open {
            overflow-y: auto !important;
            padding-right: 0 !important;
        }

        .primary_red {
            background: #D50000 !important;
        }

        .secondary_red {
            background: #ef0000 !important;
        }

        .image_placeholder {
            background: #d9534f;
            height: 100px;
            width: 100px;
        }
    </style>


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


</head>

<body>
@include('popups.login')
@include('popups.signup')
@include('popups.forgotpassword')
@include('layouts.includes.header')


<div class=" bg-danger m-y-2 p-t-3  p-b-1 secondary_red">
    <div class="container">
        <div class="row ">
            <div class="col-lg-8">
                <h1 class="display-3">diduEAT </h1>

                <p class="lead">
                    The easiest way to order food from local restaurants.
                    <br>
                    Meal of the Day Business Model.
                </p>
            </div>
            <div class="col-lg-4">
                <div class="primary_red  p-a-2 ">
                    <p class="lead">Where are you located?</p>
                    <input class="form-control" type="text" placeholder="Address, City or Postal Code">

                </div>
            </div>
        </div>
    </div>
</div>


<div class="container">

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif


@yield('content')
</div>

@include('layouts.includes.footer')
</body>
</html>