<?php $start_loading_time = microtime(true); ?>
<!DOCTYPE html>
<html lang="en">
<!--<![endif]-->
<!-- Head BEGIN -->
<head>
    <title>{{ $title." | didueat" }}</title>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <meta content="Metronic Shop UI description" name="description">
    <meta content="Metronic Shop UI keywords" name="keywords">
    <meta content="keenthemes" name="author">

    <meta property="og:site_name" content="-CUSTOMER VALUE-">
    <meta property="og:title" content="-CUSTOMER VALUE-">
    <meta property="og:description" content="-CUSTOMER VALUE-">
    <meta property="og:type" content="website">
    <meta property="og:image" content="-CUSTOMER VALUE-">
    <meta property="og:url" content="-CUSTOMER VALUE-">
    <link rel="shortcut icon" href="favicon.ico">

    <link href="//v4-alpha.getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="{{ asset('assets/global/css/custom_css.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/global/scripts/jqueryui/jquery-ui.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/plugins/fancybox/source/jquery.fancybox.css') }}" rel="stylesheet">

    <script src="{{ asset('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery-migrate.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/scripts/menu_manager.js') }}"></script>
    <script src="{{ asset('assets/global/scripts/upload.js') }}"></script>
    <script src="{{ asset('assets/global/scripts/jqueryui/jquery-ui.js') }}"></script>
    <script src="{{ asset('assets/global/plugins/carousel-owl-carousel/owl-carousel/owl.carousel.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/fancybox/source/jquery.fancybox.pack.js') }}" type="text/javascript"></script>
    <!-- pop up -->
    <script src="{{ asset('assets/global/plugins/carousel-owl-carousel/owl-carousel/owl.carousel.min.js') }}" type="text/javascript"></script>
    <!-- slider for products -->
    <script src="{{ asset('assets/global/plugins/zoom/jquery.zoom.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.js') }}" type="text/javascript"></script>
    <!-- Quantity -->
    <script src="{{ asset('assets/global/plugins/slider-layer-slider/js/greensock.js') }}" type="text/javascript"></script>
    <!-- External libraries: GreenSock -->
    <script src="{{ asset('assets/global/plugins/slider-layer-slider/js/layerslider.transitions.js') }}" type="text/javascript"></script>
    <!-- LayerSlider script files -->
    <script src="{{ asset('assets/global/plugins/slider-layer-slider/js/layerslider.kreaturamedia.jquery.js') }}" type="text/javascript"></script>
    <!-- LayerSlider script files -->
    <script src="{{ asset('assets/global/scripts/layerslider-init.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/scripts/layout.js') }}" type="text/javascript"></script>
</head>


<body class="ecommerce">

    @include('popups.login')
    @include('popups.signup')
    @include('popups.forgotpassword')
    @include('layouts.includes.header')

    <div class="main">

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