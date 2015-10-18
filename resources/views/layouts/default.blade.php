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



    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.1/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.1/js/materialize.min.js"></script>



    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">

    <link href="{{ asset('assets/global/css/custom_css.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/css/components-md.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/global/scripts/jqueryui/jquery-ui.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/plugins/fancybox/source/jquery.fancybox.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/global/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/css/style-responsive.css') }}" rel="stylesheet">

    <script src="{{ asset('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery-migrate.min.js') }}" type="text/javascript"></script>
    <!--script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" type="text/javascript"></script-->
    <script src="{{ asset('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/global/scripts/menu_manager.js') }}"></script>
    <script src="{{ asset('assets/global/scripts/upload.js') }}"></script>
    <script src="{{ asset('assets/global/scripts/jqueryui/jquery-ui.js') }}"></script>



    <script src="{{ asset('assets/global/plugins/fancybox/source/jquery.fancybox.pack.js') }}" type="text/javascript"></script><!-- pop up -->
    <script src="{{ asset('assets/global/plugins/carousel-owl-carousel/owl-carousel/owl.carousel.min.js') }}" type="text/javascript"></script><!-- slider for products -->
    <script src='{{ asset('assets/global/plugins/zoom/jquery.zoom.min.js') }}' type="text/javascript"></script><!-- product zoom -->
    <script src="{{ asset('assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.js') }}" type="text/javascript"></script><!-- Quantity -->
    <script src="{{ asset('assets/global/plugins/slider-layer-slider/js/greensock.js') }}" type="text/javascript"></script><!-- External libraries: GreenSock -->
    <script src="{{ asset('assets/global/plugins/slider-layer-slider/js/layerslider.transitions.js') }}" type="text/javascript"></script><!-- LayerSlider script files -->
    <script src="{{ asset('assets/global/plugins/slider-layer-slider/js/layerslider.kreaturamedia.jquery.js') }}" type="text/javascript"></script><!-- LayerSlider script files -->
    <script src="{{ asset('assets/global/scripts/layerslider-init.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/scripts/layout.js') }}" type="text/javascript"></script>








    <!-- END CORE PLUGINS -->
</head>
<!-- Head END -->
<!-- Body BEGIN -->
<body class="ecommerce">


@include('popups.login')
@include('popups.signup')
@include('popups.forgotpassword')


<!-- END TOP BAR -->
<script type="text/javascript">
    function getvalue(ElementID) {
        return document.getElementById(ElementID).value;
    }

    function setvalue(ElementID, Value) {
        document.getElementById(ElementID).innerHTML = Value;
    }

    function escapechars(text) {
        return text.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
    }

    $('body').on('submit', '#forgot-pass-form', function (e) {
        var token = $("#forgot-pass-form input[name=_token]").val();
        var email = $("#forgot-pass-form input[name=email]").val();

        $("#forgot-pass-form #regButton").hide();
        $("#forgot-pass-form #regLoader").show();
        $.post("{{ url('auth/forgot-passoword/ajax') }}", {_token: token, email: email}, function (result) {
            $("#forgot-pass-form #regButton").show();
            $("#forgot-pass-form #regLoader").hide();

            var json = jQuery.parseJSON(result);
            if (json.type == "error") {
                $('#forgot-pass-form #error').show();
                $('#forgot-pass-form #error').html(json.message);
            } else {
                $('#forgot-pass-form').hide();
                $('#forgot-pass-success').show();
                $('#forgot-pass-success p').html(json.message);
            }
        });
        e.preventDefault();
    });

    function trylogin() {
        var data = $('#login-ajax-form').serialize();
        $.ajax({
            url: "{{ url('auth/login/ajax') }}",
            data: data,
            type: "post",
            success: function (msg) {

                if (isNaN(Number(msg))) {
                    if (checkUrl(msg)) {
                        window.location = msg;
                    } else {
                        $('#invalid').text(msg);
                        $('#invalid').show();
                    }
                }
                else {
                    if ($('#login_type').val() == 'reservation') {

                        $.ajax({
                            url: "{{url('/user/json_data')}}",
                            type: "post",
                            data: "id=" + msg + '&_token={{csrf_token()}}',
                            dataType: "json",
                            success: function (arr) {
                                $('#fullname').val(arr.name);
                                $('#ordered_email').val(arr.email);
                                $('#ordered_contact').val(arr.phone);
                                $('#ordered_province').val(arr.province);
                                $('#ordered_street').val(arr.street);
                                $('#ordered_city').val(arr.city);
                                $('#ordered_code').val(arr.postal_code);
                                $('.reservation_signin').hide();
                                $('.fancybox-close').click();
                            }
                        })

                    }
                    else
                        window.location = "{{ url('dashboard') }}";
                }
            },
            failure: function (msg) {
                setvalue("message", "ERROR: " + msg);
            }
        });
        return false;
    }

    $('body').on('click', '#resendMeEmail', function (e) {
        var url = $(this).attr('href');
        $('#registration-success p').html('Please wait email is being send...');
        $.get(url, {}, function (result) {
            var json = jQuery.parseJSON(result);
            $('#registration-success p').html(json.message);
        });
        e.preventDefault();
    });

    $('body').on('submit', '#register-form', function (e) {
        var token = $("#register-form input[name=_token]").val();
        var Name = $("#register-form input[name=name]").val();
        var Email = $("#register-form input[name=email]").val();
        var phone = $("#register-form input[name=phone]").val();
        var password = $("#register-form input[name=password]").val();
        var confirm_password = $("#register-form input[name=confirm_password]").val();
        var subscribed = $("#register-form input[name=subscribed]").val();

        $("#register-form #regButton").hide();
        $("#register-form #regLoader").show();
        $.post("{{ url('auth/register/ajax') }}", {
            _token: token,
            name: Name,
            email: Email,
            phone: phone,
            password: password,
            confirm_password: confirm_password,
            subscribed: subscribed
        }, function (result) {
            $("#register-form #regButton").show();
            $("#register-form #regLoader").hide();

            var json = jQuery.parseJSON(result);
            if (json.type == "error") {
                $('#register-form #registration-error').show();
                $('#register-form #registration-error').html(json.message);
            } else {
                $('#register-form').hide();
                $('#registration-success').show();
                $('#registration-success p').html(json.message);
            }
        });
        e.preventDefault();
    });


    function ValidURL(textval) {
        var urlregex = new RegExp(
                "^(http|https|ftp)\://([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&amp;%\$\-]+)*@)*((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(\:[0-9]+)*(/($|[a-zA-Z0-9\.\,\?\'\\\+&amp;%\$#\=~_\-]+))*$");
        return urlregex.test(textval);
    }

    function checkUrl(textval) {
        if (textval.replace('/dashboard', '') != textval)
            return true;
        else
            return false;
    }

    //loadmore
    $(function () {
        $('.loadmore').click(function () {
            $('div#loadmoreajaxloader').show();
            ur = $('.next a').attr('href');
            if (ur != '') {
                url1 = ur.replace('/?', '?');
                $.ajax({
                    url: url1,
                    success: function (html) {

                        if (html) {
                            $('.nxtpage').remove();
                            $("#postswrapper").append(html);
                            $('div#loadmoreajaxloader').hide();
                        } else
                            $('div#loadmoreajaxloader').html('<center>No more menus to show.</center>');

                    }
                });
            }
            else {
                $('div#loadmoreajaxloader').html('<center>No more menus to show.</center>');
                $(this).parent().remove();
            }
        });

    });
</script>


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


 <div class="overlay_loader">
                <div class="clearfix"></div>
                <div id="loadmoreajaxloader">
                    <img src="{{ asset('assets/images/ajax-loading.gif') }}">
                </div>
 </div>

</body>
</html>