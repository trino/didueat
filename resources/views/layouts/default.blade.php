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
        <meta content="{{ (isset($meta_description))? substr($meta_description,0,160):'didueat.com is very good from all over the world.' }}" name="description">

        <meta property="og:site_name" content="Didueat">
        <meta property="og:title" content="{{ (isset($title))?$title.' | ':'' }}DidUEat">
        <meta property="og:description" content="{{ (isset($meta_description))? substr($meta_description,0,160):'didueat.com is very good from all over the world.' }}">
        <meta property="og:type" content="website">
        <meta property="og:image" content="-CUSTOMER VALUE-">
        <meta property="og:url" content="{{ url('/') . $nextPath }}">
        <link rel="shortcut icon" href="{{ url('/favicon.ico') }}" type="image/vnd.microsoft.icon"/>
        <link rel="icon" href="{{ url('/favicon.ico') }}" type="image/vnd.microsoft.icon"/>

        <link href="{{ asset('assets/global/css/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet" integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" crossorigin="anonymous">
        <link href="{{ asset('assets/global/css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet"/>
        <link href="{{ asset('assets/global/css/toastr.min.css') }}" rel="stylesheet">

        <link href="{{ asset('assets/global/css/custom_css.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/global/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/global/scripts/jqueryui/jquery-ui.css') }}" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
            @if(true)
        <script src="{{ asset('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/global/scripts/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/global/plugins/jquery-migrate.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/global/scripts/menu_manager.js') }}"></script>
        <script src="{{ asset('assets/global/scripts/upload.js') }}"></script>
        <script src="{{ asset('assets/global/scripts/jqueryui/jquery-ui.js') }}"></script>
        <script src="{{ asset('assets/global/plugins/carousel-owl-carousel/owl-carousel/owl.carousel.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/global/plugins/fancybox/source/jquery.fancybox.pack.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/global/plugins/carousel-owl-carousel/owl-carousel/owl.carousel.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/global/plugins/zoom/jquery.zoom.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/global/plugins/slider-layer-slider/js/greensock.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/global/plugins/slider-layer-slider/js/layerslider.transitions.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/global/plugins/slider-layer-slider/js/layerslider.kreaturamedia.jquery.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/global/scripts/layerslider-init.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/global/scripts/layout.js') }}" type="text/javascript"></script>

        <script src="{{ asset('assets/global/scripts/jquery.tag-editor.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/global/scripts/jquery.caret.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/global/scripts/jquery.cookie.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/global/scripts/custom-datatable/bootbox.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/global/scripts/receipt.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/global/scripts/additional.js') }}" class="ignore"></script>
@endif

    </head>
    <body>


    @if(true)
        @include('popups.login')
        @include('popups.signup')
        @include('popups.forgotpassword')

    @endif

        @include('layouts.includes.header')

            <div class="container m-t-3">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                @if(\Session::has('message-parent'))
                    <div class="alert {!! Session::get('message-type') !!}">
                        <strong>{!! Session::get('message-short') !!}</strong>
                        &nbsp; {!! Session::get('message-parent') !!}
                    </div>
                    <?php \Session::forget('message'); ?>
                @endif

                @yield('content')
            </div>

        @include('layouts.includes.footer')
    </body>
</html>