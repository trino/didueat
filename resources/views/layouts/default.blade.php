<?php
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
    <title>{{ (isset($title))?$title.' | ':'' }}Didu Eat</title>

    <meta charset="utf-8">
    <!--meta content="width=device-width, initial-scale=1.0" name="viewport"-->

    <meta name="viewport" content="width=device-width, user-scalable=no">
        <meta name="viewport" content="width=device-width, user-scalable=no">

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <meta content="{{ (isset($title))?$title.' | ':'' }}Did u eat" name="keywords">
    <meta content="DiduEat" name="author">
    <meta name="content-language" content="en-CA"/>
    <meta http-equiv="content-language" content="en-CA"/>
    <meta content="{{ (isset($meta_description))? substr($meta_description,0,160):'didueat.ca is very good from all over the world.' }}"
          name="description">

    <meta property="og:site_name" content="DiduEat">
    <meta property="og:title" content="{{ (isset($title))?$title.' | ':'' }}Didu Eat">
    <meta property="og:description"
          content="{{ (isset($meta_description))? substr($meta_description,0,160):'didueat.ca is very good from all over the world.' }}">
    <meta property="og:type" content="website">
    <meta property="og:image" content="-CUSTOMER VALUE-">
    <meta property="og:url" content="{{ url('/') . $nextPath }}">
    <meta name="_token" class="csrftoken" content="{{ csrf_token() }}"/>
    <!-- CSS -->

    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <!-- Safari doesn't trust the certificate from here:    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet"> -->
    <link href="{{ asset('assets/global/css/font-awesome.min.css') }}" rel="stylesheet">
    <!--link rel="stylesheet" href="https://cdn.rawgit.com/twbs/bootstrap/v4-dev/dist/css/bootstrap.css" integrity="" crossorigin="anonymous"-->
    <link href="{{ asset('assets/global/css/bootstrap.css') }}" rel="stylesheet">
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

    <script src="{{ asset('assets/global/scripts/menu_manager.js') }}"></script>
    <script src="{{ asset('assets/global/scripts/receipt.js') }}"></script>
    <script src="{{ asset('assets/global/scripts/additional.js') }}" class="ignore"></script>
    <script src="{{ asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}"></script>

    @if(isset($paymentpg))
        <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
        <script src="{{ asset('assets/global/scripts/stripe.js') }}"></script>
    @endif

    @if (debugmode())
        <style>
            .container-fluid {
                border: 1px solid green;
            }

            .container {
                border: 1px solid green;
            }

            div[class^="col-"], div[class*=" col-"] {
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
            form{
                border: 3px solid black;
            }
        </style>
    @endif

<!--[if IE]>
    <style>
        .form-control{
            padding-bottom: 10px !important;
        }
    </style>
<![endif]-->
<STYLE>
    _:-ms-fullscreen, :root input.form-control{
        padding-bottom: 10px !important;
    }
</STYLE>

<SCRIPT>
    var baseurl = "{{ url('/') }}";
    var debugmode = "{{ debugmode() }}";
    function debugalert(message) {
        if (debugmode) {
            alert(message);
        }
    }
</SCRIPT>

</head>
<body>


<div class="overlay_loader">
    <div class="overlay">
        <img src="{{ asset('assets/images/ajax-loading.gif') }}"/>
    </div>
</div>


<?php
$first = false;
$type = "hidden";
?>

<div class="bg-success">
<div class="container-fluid" style="margin-bottom: 53px;">
    @include('layouts.includes.header')
</div>
    <div class="clearfix"></div>
</div>


<! --test -->
<! --test -->
<div class="container-fluid">
    @include('common.alert_messages')
</div>

<div class="container-fluid">
    @yield('content')
</div>

<div class="container-fluid" >
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




</body>
</html>
<script>
    $( window ).load(function() {
    $('.overlay_loader').hide();
});
</script>