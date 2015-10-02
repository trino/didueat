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
    <meta property="og:image" content="-CUSTOMER VALUE-"><!-- link to image for socio -->
    <meta property="og:url" content="-CUSTOMER VALUE-">

    <link rel="shortcut icon" href="favicon.ico">

    <!-- Fonts START -->
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|PT+Sans+Narrow|Source+Sans+Pro:200,300,400,600,700,900&amp;subset=all" rel="stylesheet" type="text/css">
    <link href="//fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900&amp;subset=all" rel="stylesheet" type="text/css">
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
    
    <script src="{{ asset('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/scripts/menu_manager.js') }}"></script>
    <script src="{{ asset('assets/global/scripts/upload.js') }}"></script>
    <script src="{{ asset('assets/global/scripts/jqueryui/jquery-ui.js') }}"></script>
    
    <!-- END CORE PLUGINS -->
</head>
<!-- Head END -->
<!-- Body BEGIN -->
    <body class="ecommerce">
        <div id="fb-root"></div>
        <script>/*(function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4&appId=222640917866457";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));*/</script>

        <!-- BEGIN TOP BAR -->
        <div id="registration-form"class="col-md-12" style="display: none;">
            <form action="" class="form-horizontal" method="post">
                <INPUT TYPE="hidden" name="action" value="signup">
                <fieldset>
                    <legend>Your personal details</legend>
                    <div class="form-group">
                        <label class="col-lg-4 col-sm-4 control-label col-xs-12" for="Name">Name <span class="require">*</span></label>
                        <div class="col-lg-8 col-sm-8 col-xs-12">
                          <input type="text" name="Name" class="form-control" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 col-sm-4 control-label col-xs-12" for="Email">Email <span class="require">*</span></label>
                        <div class="col-lg-8 col-sm-8 col-xs-12">
                          <input type="text" name="Email" class="form-control" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 col-sm-4 control-label col-xs-12" for="Phone">Phone<span class="require">*</span></label>
                        <div class="col-lg-8 col-sm-8 col-xs-12">
                          <input type="phone" name="Phone" class="form-control" value="">
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Your password</legend>
                    <div class="form-group">
                        <label class="col-lg-4 col-sm-4 control-label col-xs-12" for="Password">Password <span class="require">*</span></label>
                        <div class="col-lg-8 col-sm-8 col-xs-12">
                          <input type="text" name="Password" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 col-sm-4 control-label col-xs-12" for="Confirm-Password">Confirm password <span class="require">*</span></label>
                        <div class="col-lg-8 col-sm-8 col-xs-12">
                          <input type="text" name="Confirm-Password" class="form-control">
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Newsletter</legend>
                    <div class="checkbox form-group">
                        <label class="col-lg-4 col-sm-4 control-label" for="newsletter">Sign up for our Newsletter</label>
                        <div class="col-lg-8 col-sm-8">
                            <div class="checker"><span>
                                <input type="checkbox" name="newsletter" id="newsletter" class="form-control" >
                            </span></div>
                        </div>
                    </div>
                </fieldset>

                <div class="row">
                    <div class="col-lg-8 col-sm-8 col-xs-12 col-md-offset-4 padding-left-0 padding-top-20">
                        <button class="btn btn-primary" type="submit">Create an account</button>
                    </div>
                </div>
            </form>
        </div>
        
        <div id="login-pop-up" style="display:none;">
            <div class="login-pop-up">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="login-form">
                        <h1>Login</h1>
                        <DIV ID="message" align="center"></DIV>
                        <form role="form" action="" id="login-ajax-form" method="post" class="form-horizontal form-without-legend">
                            {!! csrf_field() !!}
                            <input type="hidden" name="action" value="login">
                            <p style="display: none;text-align:center; color: red;" id="invalid"></p>
                            <div class="form-group">
                                <label class="col-lg-4 control-label" for="email">Email <span class="require">*</span></label>
                                <div class="col-lg-8">
                                    <input type="text" id="email" name="email" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-4 control-label" for="password">Password <span class="require">*</span></label>
                                <div class="col-lg-8">
                                    <input type="password" id="password" name="password" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-8 col-md-offset-4 padding-left-0">
                                    <a href="{{ url('auth/forgot-passoword') }}" class="fancybox-fast-view">Forgot Password?</a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-lg-8 col-md-offset-4 padding-left-0 padding-top-20">
                                    <input class="btn btn-primary" type="button" Value="Login" onclick="trylogin(); return false;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-lg-8 col-md-offset-4 padding-left-0 padding-top-20">
                                    <a href="{{ url('auth/register') }}" class="btn btn-primary fancybox-fast-view" type="button">Sign Up</a>
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
            <DIV ID="forgot-message" align="center"></DIV>
            <form role="form" class="form-horizontal form-without-legend" method="post">
                <div class="form-group col-md-12">
                    <label class="col-lg-4 control-label" for="email">Email</label>
                    <div class="col-lg-8">
                        <input type="hidden" Name="action" value="forgotpass">
                        <input type="text" Name="Email" id="forgot-email" class="form-control">
                    </div>
                </div>

                <div class="col-lg-8 col-md-offset-4 padding-left-0 padding-top-5">
                    <button class="btn btn-primary" type="button" onclick="forgotpass();">Send</button>
                </div>

            </form>
        </div>
        <!-- END TOP BAR -->
        <script type="text/javascript">
            function getvalue(ElementID){
                return document.getElementById(ElementID).value;
            }
            
            function setvalue(ElementID, Value){
                document.getElementById(ElementID).innerHTML = Value;
            }
            
            function escapechars(text){
                return text.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
            }
            
            function forgotpass(){
                $.ajax({
                    url: "/Foodie/",
                    data: "action=forgotpass&Email=" + escapechars(getvalue("forgot-email")),
                    type: "post",
                    success: function (msg) {
                        setvalue("forgot-message", msg);
                    },
                    failure: function (msg){
                        setvalue("forgot-message", "ERROR: " + msg);
                    }
                });
                return false;
            }

            function trylogin(){
                var data = $('#login-ajax-form').serialize();
                $.ajax({
                    url: "{{ url('auth/login/ajax') }}",
                    data: data,
                    type: "post",
                    success: function (msg) {
                        if(msg) {
                            if(checkUrl(msg)){
                                window.location = msg;
                            } else {
                                $('#invalid').text(msg);
                                $('#invalid').show();
                            }
                        } else {
                            window.location = "{{ url('dashboard') }}";
                        }
                    },
                    failure: function (msg){
                        setvalue("message", "ERROR: " + msg);
                    }
                });
                return false;
            }

            function ValidURL(textval) {
                var urlregex = new RegExp(
                    "^(http|https|ftp)\://([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&amp;%\$\-]+)*@)*((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(\:[0-9]+)*(/($|[a-zA-Z0-9\.\,\?\'\\\+&amp;%\$#\=~_\-]+))*$");
              return urlregex.test(textval);
            }
            function checkUrl(textval)
            {
                if(textval.replace('/dashboard','')!=textval)
                return true;
                else
                return false;
            }
        </script>

        <!-- Header -->
        @include('layouts.includes.header')
        <!-- End Header -->

        <!-- BEGIN MAIN -->
        <div class="main">
            <!-- BEGIN SIDEBAR & CONTENT -->
            <!-- Dynamic Content -->
            @yield('content')                       
            <!-- End Dynamic Content -->
            <!-- END SIDEBAR & CONTENT -->
        </div>
        <!-- END MAIN -->
        
        <!-- Footer -->
        @include('layouts.includes.footer')
        <!-- End Footer -->
        
    </body>
    <!-- END BODY -->
</html>