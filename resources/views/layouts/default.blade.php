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
    <!-- link to image for socio -->
    <meta property="og:url" content="-CUSTOMER VALUE-">

    <link rel="shortcut icon" href="favicon.ico">

    <!-- Fonts START -->
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|PT+Sans+Narrow|Source+Sans+Pro:200,300,400,600,700,900&amp;subset=all"
          rel="stylesheet" type="text/css">
    <link href="//fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900&amp;subset=all"
          rel="stylesheet" type="text/css">
    <!-- Fonts END -->

    <!-- Global styles START -->
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <!-- Global styles END -->

    <!-- Page level plugin styles START -->
    <link href="{{ asset('assets/global/plugins/fancybox/source/jquery.fancybox.css') }}" rel="stylesheet">
    <!-- Page level plugin styles END -->

    <!-- Theme styles START -->
    <link href="{{ asset('assets/global/css/components.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/css/style-responsive.css') }}" rel="stylesheet">

    <!-- MAKE ALL CSS CHANGES TO HERE -->
    <link href="{{ asset('assets/global/css/custom_css.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/scripts/jqueryui/jquery-ui.css') }}" rel="stylesheet">
    <!-- Theme styles END -->

    <!-- BEGIN CORE PLUGINS (REQUIRED FOR ALL PAGES) -->

    <!--[if lt IE 9]>
    <script src="{{ asset('assets/plugins/respond.min.js') }}"></script>
    <![endif]-->

    <script src="{{ asset('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery-migrate.min.js') }}" type="text/javascript"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" type="text/javascript"></script>

    <script src="{{ asset('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/global/scripts/menu_manager.js') }}"></script>
    <script src="{{ asset('assets/global/scripts/upload.js') }}"></script>
    <script src="{{ asset('assets/global/scripts/jqueryui/jquery-ui.js') }}"></script>

    <!-- END CORE PLUGINS -->
</head>
<!-- Head END -->
<!-- Body BEGIN -->
<body class="ecommerce">







<div id="registration-form" class="col-md-12" style="display: none;">
    <div id="registration-success" class="note note-success" style="display: none;">
        <h1 class="block">success</h1>
        <p></p>
    </div>
    {!! Form::open(array('url' => '/auth/register', 'id'=>'register-form','class'=>'form-horizontal','method'=>'post','role'=>'form')) !!}
    <fieldset>
        <div id="registration-error" class="alert alert-danger" style="display: none;"></div>

        <legend>Your personal details</legend>
        <div class="form-group">
            <label class="col-lg-4 col-sm-4 control-label col-xs-12" for="name">Name <span
                        class="require">*</span></label>

            <div class="col-lg-8 col-sm-8 col-xs-12">
                <input type="text" name="name" id="name" class="form-control" value="" required="">
            </div>
        </div>

        <div class="form-group">
            <label class="col-lg-4 col-sm-4 control-label col-xs-12" for="email">Email <span
                        class="require">*</span></label>

            <div class="col-lg-8 col-sm-8 col-xs-12">
                <input type="text" name="email" id="email" class="form-control" value="" required="">
            </div>
        </div>

        <div class="form-group">
            <label class="col-lg-4 col-sm-4 control-label col-xs-12" for="phone">Phone<span
                        class="require">*</span></label>

            <div class="col-lg-8 col-sm-8 col-xs-12">
                <input type="number" name="phone" id="phone" class="form-control" value="" required="">
            </div>
        </div>
    </fieldset>

    <fieldset>
        <legend>Your password</legend>
        <div class="form-group">
            <label class="col-lg-4 col-sm-4 control-label col-xs-12" for="password">Password <span
                        class="require">*</span></label>

            <div class="col-lg-8 col-sm-8 col-xs-12">
                <input type="password" name="password" id="passwords" class="form-control" required="">
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-4 col-sm-4 control-label col-xs-12" for="confirm_password">Confirm password <span
                        class="require">*</span></label>

            <div class="col-lg-8 col-sm-8 col-xs-12">
                <input type="password" name="confirm_password" id="confirm_passwords" class="form-control" required="">
            </div>
        </div>
    </fieldset>

    <fieldset>
        <legend>Newsletter</legend>
        <div class="checkbox form-group">
            <label class="col-lg-4 col-sm-4 control-label" for="subscribed2">Sign up for our Newsletter</label>

            <div class="col-lg-8 col-sm-8">
                <div class="checker">
                                <span>
                                    <input type="checkbox" name="subscribed" id="subscribed2" class="form-control"
                                           value="1">
                                </span>
                </div>
            </div>
        </div>
    </fieldset>

    <div class="row">
        <div class="col-lg-8 col-sm-8 col-xs-12 col-md-offset-4 padding-left-0 padding-top-20">
            <button id="regButton" class="btn btn-primary" type="submit">Create an account</button>
            <img id="regLoader" src="{{ asset('assets/images/loader.gif') }}" style="display: none;"/>
        </div>
    </div>
    {!! Form::close() !!}
</div>
















<div id="login-pop-up" style="display:none;">
    <div class="login-pop-up">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="login-form">
                <h1>Login</h1>

                <DIV ID="message" align="center"></DIV>
                <form role="form" action="" id="login-ajax-form" method="post"
                      class="form-horizontal form-without-legend">
                    {!! csrf_field() !!}
                    <input type="hidden" name="action" value="login">
                    <input type="hidden" name="type" id="login_type" value=""/>

                    <p style="display: none;text-align:center; color: red;" id="invalid"></p>

                    <div class="form-group">
                        <label class="col-lg-4 col-md-4 col-sm-4 col-xs-12 control-label" for="email">Email <span
                                    class="require">*</span></label>

                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                            <input type="text" id="email" name="email" class="form-control" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 col-md-4 col-sm-4 col-xs-12 control-label" for="password">Password <span
                                    class="require">*</span></label>

                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                            <input type="password" id="password" name="password" class="form-control" required="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 col-md-offset-4 padding-left-0">
                            <a href="#forget-passsword" class="fancybox-fast-view">Forgot Password?</a>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 col-md-offset-4 padding-left-0 padding-top-20">
                            <input class="btn btn-primary" type="button" Value="Login"
                                   onclick="trylogin(); return false;">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="col-lg-8 col-md-offset-4 padding-left-0 padding-top-20">
                            <a href="#registration-form" class="btn btn-primary fancybox-fast-view" type="button">Sign
                                Up</a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>

        </div>

    </div>
</div>











<div id="forget-passsword" style="display: none;">
    <h1>Forgot Your Password?</h1>

    <div id="forgot-pass-success" class="note note-success" style="display: none;">
        <h1 class="block">success</h1>

        <p></p>
    </div>
    {!! Form::open(array('url' => '/auth/forgot-passoword', 'id'=>'forgot-pass-form','class'=>'form-horizontal form-without-legend','method'=>'post','role'=>'form')) !!}
    <div id="error" class="alert alert-danger" style="display: none;"></div>
    <div class="form-group col-md-12 col-sm-124 col-xs-12">
        <label class="col-lg-4 col-md-4 col-sm-4 col-xs-12 control-label" for="forgot-email">Email</label>

        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <input type="text" name="email" id="forgot-email" class="form-control">
        </div>
    </div>

    <div class="col-lg-8  col-md-8 col-sm-8 col-xs-12col-md-offset-4 padding-left-0 padding-top-5">
        <button id="regButton" class="btn btn-primary" type="submit">Send</button>
        <img id="regLoader" src="{{ asset('assets/images/loader.gif') }}" style="display: none;"/>
    </div>
    {!! Form::close() !!}
</div>











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

        $("#regButton").hide();
        $("#regLoader").show();
        $.post("{{ url('auth/register/ajax') }}", {
            _token: token,
            name: Name,
            email: Email,
            phone: phone,
            password: password,
            confirm_password: confirm_password,
            subscribed: subscribed
        }, function (result) {
            $("#regButton").show();
            $("#regLoader").hide();

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

    })






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






</body>
</html>