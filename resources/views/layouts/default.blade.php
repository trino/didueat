<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    //$start_loading_time = microtime(true);
    if (Session::has('menuTS')) {
        $GLOBALS['menuTS'] = Session('menuTS');
    }
    $preUpRe = "false";
    if (isset($_COOKIE['pvrbck'])) {
        $preUpRe = "true";
    }
    echo '<script>preUpRe=' . $preUpRe . ';</script>';

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

    $first = false;
    $type = "hidden";
    ?>

    <title>{{ (isset($title))?$title.' | ':'' }}{{ DIDUEAT  }}</title>

    <meta charset="utf-8">
    <!--meta content="width=device-width, initial-scale=1.0" name="viewport"-->
    <meta name="theme-color" content="#5cb85c"/>
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta content="{{ (isset($keyword))?$keyword.' | ':'' }}{{ DIDUEAT }}" name="keywords">
    <meta content="Didueat" name="author">
    <meta name="content-language" content="en-CA"/>
    <meta http-equiv="content-language" content="en-CA"/>
    <meta content="{{ (isset($meta_description))? substr($meta_description,0,160):'didueat.ca is very good from all over the world.' }}"
          name="description">
    <meta property="og:site_name" content="DiduEat">
    <meta property="og:title" content="{{ (isset($title))?$title.' | ':'' }}{{ DIDUEAT }}">
    <meta property="og:description"
          content="{{ (isset($meta_description))? substr($meta_description,0,160):'didueat.ca is very good from all over the world.' }}">
    <meta property="og:type" content="website">
    <meta property="og:image" content="-CUSTOMER VALUE-">
    <meta property="og:url" content="{{ url('/') . $nextPath }}">
    <meta name="_token" class="csrftoken" content="{{ csrf_token() }}"/>
    <!-- CSS -->

    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab' rel='stylesheet' type='text/css'>

    <!-- Safari doesn't trust the certificate from here:
     <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet"> -->
    <link href="{{ asset('assets/global/css/font-awesome.min.css') }}" rel="stylesheet">
<!--link href="{{ asset('assets/global/css/bootstrap.min.css') }}" rel="stylesheet"-->

    <link rel="stylesheet" href="https://v4-alpha.getbootstrap.com/dist/css/bootstrap.min.css" integrity=""
          crossorigin="anonymous">

<!--link href="{{ asset('assets/global/css/bootstrap.css') }}" rel="stylesheet"-->
    <link href="{{ asset('assets/global/css/custom_css.css') }}" rel="stylesheet">

    <!-- JS these two must go first -->
    <script src="{{ asset('assets/global/plugins/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/global/plugins/jquery-migrate.min.js') }}"></script>
    <!-- JS these two must go first -->

    <script src="{{ asset('assets/global/scripts/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/global/scripts/upload.js') }}"></script>
    <script src="{{ asset('assets/global/scripts/jqueryui/jquery-ui.js') }}"></script>
    <script src="{{ asset('assets/global/scripts/jquery.tag-editor.js') }}"></script>
    <script src="{{ asset('assets/global/scripts/jquery.cookie.min.js') }}"></script>

<!--script src="{{ asset('assets/global/scripts/custom-datatable/bootbox.js') }}"></script-->

    <script src="{{ asset('assets/global/scripts/additional.js') }}" class="ignore"></script>
    <script src="{{ asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}"></script>

    @if (debugmode())
        <style>
            .container-fluid {
                border: 1px solid green;
            }

            .container {
                border: 1px solid green;
            }

            div[class^="col-"], div[class*=" col-"], div[class^="card-"], div[class*=" card-"] {
                border: 1px solid red !important;
            }

            .div {
                border: 1px solid red !important;
            }

            tr {
                border: 3px solid pink;
            }

            td {
                border: 3px solid yellow;
            }

            th {
                border: 3px solid purple;
            }

            form {
                border: 3px solid black;
            }
        </style>
    @endif

    <SCRIPT>
        var receiptversion = "{{ ReceiptVersion }}";
        var routename = "{{ \Route::getCurrentRoute()->getActionName() }}";
        var baseurl = "{{ url('/') }}";
        var debugmode = "{{ debugmode() }}";
        var profiletype = "{{ read("profiletype") }}";
        //only do an alert if debugmode is on
        function debugalert(message) {
            if (debugmode) {
                alert(message);
            }
        }
        var token = "{{ csrf_token() }}";
        var path = window.location.pathname;
        var base_url;
        if (path.replace('didueat', '') != path) {
            base_url = 'http://localhost/didueat/public/';
        } else {
            base_url = window.location.protocol + '//';
            if (window.location.href.toLowerCase().indexOf("www") > -1) {
                base_url = base_url + "www.";
            }
            base_url = base_url + 'didueat.ca/';
        }
        var shownat = Date.now();

        function keypress(e) {

            log(keycode);
        }

        $("body").keydown(function (e) {
            var keycode = e.keyCode || e.charCode;
            switch (keycode) {
                case 27://escape, hide all visible modals
                    $(".modal").filter(":visible").each(function () {
                        $(this).modal("hide");
                    });
                    break;
            }
        });
    </SCRIPT>

</head>

<body>

@include("popups.alert")

<div class="overlay_loader">
    <div class="loader"></div>
</div>

<div id="the-header">
    @include('layouts.includes.header')
</div>

<div class="container-fluid" id="the-messages">
    @include('common.alert_messages')
</div>

<div class="p-t-1" id="the-content">
    @yield('content')
    <DIV ID="popupholder"></DIV>
</div>

<div class="container" id="the-footer">
    @include('layouts.includes.footer')
</div>

@if(!read("id"))
    @include('popups.login')
    @include('popups.signup')
    @include('popups.forgot-password')
@endif

@if(\Session::has('session_id'))
    @include('popups.navigation_bar')
@endif


<script>
    $(window).load(function () {
        overlay_loader_hide();
    });

    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
        a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
    ga('create', 'UA-74638591-1', 'auto');
    ga('send', 'pageview');
</script>
@if (debugmode())

<script>

    $("*").not("body, html").hover(function(e) {
        $(this).css("border", "1px solid #000");
        e.stopPropagation();
    }, function(e) {
        $(this).css("border", "0px");
        e.stopPropagation();
    });

</script>

@endif
<!--script type="text/javascript">
    window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
            d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
    _.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
        $.src="//v2.zopim.com/?3u8GXzcxlOrJMcFj3nt8iVLulwN1RV8y";z.t=+new Date;$.
                type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
</script-->
</body>
</html>