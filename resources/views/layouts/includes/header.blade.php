<?php
    $alts = array(
            "home" => "Go back to the home page",
            "cart-header" => "Checkout",
            "navigationModal" => "Bring up the options menu",
            "login" => "Log in with your email address and password",
            "signup" => "Create a new account",
            "checkout" => "Check out"
    );
?>
<nav class="navbar navbar-dark  bg-success header-nav" style="">
    <div class="container-fluid" style="margin-top:0px !important;">
        <ul class="nav navbar-nav pull-left " style="">
            <li class="nav-item hidden-sm-down ">
                <a class="" href="{{ url('/') }}" title="{{ $alts["home"] }}">
                    <img class="pull-left" src="{{ asset('assets/images/logo.png') }}" alt="{{ DIDUEAT }}" style="height: 39px;margin-top:5px;"/>
                </a>
            </li>

            <li class="nav-item m-l-0 pading-left-mobile">
                <a style="padding-bottom:0 !important;padding-top:4px !important;" class="hidden-md-up pull-left  nav-link" href="{{ url('/') }}" title="{{ $alts["home"] }}">
                    <img class="pull-left" src="{{ asset('assets/images/icon.png') }}" alt="{{ DIDUEAT }}" style="height: 39px;"/>
                </a>
            </li>
        </ul>
        <ul class="nav navbar-nav pull-right " style="">
            <li class="nav-item ">

                @if(Session::has('is_logged_in'))

                    <div class="btn-group">
                        <button type="button" style="border-radius:0;" class="btn btn-lg btn-success" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                            <img src="<?php
                                $logoTS = "";
                                if (Session::has('logoTS')) {
                                    $logoTS = "?i=" . Session('logoTS');
                                }
                                $filename = 'assets/images/users/' . read("id") . "/icon-" . read('photo');
                                if (Session::has('session_photo') && file_exists(public_path($filename))) {
                                    echo asset($filename) . $logoTS;
                                } else {
                                    echo asset('assets/images/icon-didueatdefault.png');
                                }
                            ?>" class="img-circle"
                                 style="margin-top:-10px !important;margin-bottom:-6px !important;height: 28px;width:28px;">


                            <span class="" style="">{{explode(' ', Session::get('session_name'))[0] }}</span>



                        </button>
                        <div class="dropdown-menu  dropdown-menu-right" style="min-width: 200px;">
                            @include('common.navbar_content')
                        </div>
                    </div>

                    <!--a href="#" data-toggle="modal" data-target="#navigationModal" class="pull-right"></a-->
                    <!--a type="button" data-toggle="collapse" href="#"
                       class="pull-xs-right hidden-sm-up btn btn-sm btn-primary "
                       data-toggle="collapse" data-target=".navbar-collapse"><i class="fa fa-bars"></i></a-->
                    <!--li class="nav-item"><a href="{{ url('auth/logout') }}" class="nav-link">Log out</a></li-->
                @else
                    <div class="btn-group">
                        <a style="border-radius:0; padding-left:1rem;padding-right:1rem;" class="btn btn-lg btn-success reserve_login " data-toggle="modal"
                           title="{{ $alts["login"] }}"
                           data-target="#loginModal" onclick="$('#login-ajax-form').attr('data-route', 'reservation');">Login</a>
                        <a style="border-radius:0; padding-left:1rem;padding-right:1rem;" class="btn btn-lg btn-success " data-toggle="modal"
                           data-target="#signupModal" title="{{ $alts["signup"] }}">Signup</a>

                    </div>

                @endif
            </li>

            <li class="nav-item m-l-0">
                <A ID="cart-header" style="@if(Route::getCurrentRoute()->getActionName() != "App\Http\Controllers\HomeController@menusRestaurants") display:none; @endif border-radius: 0; padding-left:10px;padding-right:10px;" CLASS="anchor btn bg-warning btn-lg"
                   title="{{ $alts["checkout"] }}"
                   onclick="return scrolltocheckout();" title="{{ $alts["cart-header"] }}">
                    <span class="fa fa-spinner fa-spin cart-header-gif"></SPAN>
                    <SPAN class="cart-header-items cart-header-show"></SPAN>
                    <SPAN class="cart-header-total cart-header-show"></SPAN>
                    <!--i class="fa fa-shopping-cart cart-header-show"></i-->
                </A>
            </li>
        </ul>
    </div>
</nav>
<?php
    $AreaCodes = array();
    foreach (areacodes() as $Region) {
        $AreaCodes = array_merge($AreaCodes, array_keys($Region));
    }
?>
<script>
    function modalcheck() {
        if ($("#navigationModal").length == 0) {
            window.location.assign("{{  url("user/info") }}");
        }
    }

    var AreaCodes = [{{  implode(", ", $AreaCodes) }}];

    //check the #hash part of the URL for any special commands
    $(document).ready(function () {
        switch (window.location.hash) {
            @if(!read("id"))
				case "#login":
                $('.reserve_login').trigger("click");
                break;
            @endif
        }
        @if(Route::getCurrentRoute()->getActionName() == "App\Http\Controllers\HomeController@menusRestaurants")
            updatecart("header");
        @endif
        $.altConfirm();
    });

    function scrollto(selector) {
        if(isNaN(selector)) {
            if (typeof selector == "object"){
                selector = selector.offset().top;
            } else {
                selector = $(selector).offset().top;
            }
        }
        if($(".modal-dialog:visible" ).length){
            $(".modal:visible").animate({scrollTop: selector}, 800, 'swing');
            return "Modal " + selector;
        } else {
            $('html,body').animate({
                scrollTop: selector + $(".navbar").height()
            });
            return "Body " + selector;
        }
    }

    function log(text){
        if(debugmode){console.log(text);}
    }

    jQuery.altConfirm = function () {
        var box = '<div class="modal fade static" id="confirm-modal" data-backdrop="static" tabindex="-1" role="dialog">';
        box += '<div id="confirm-modal-dialog" class="modal-dialog">';
        box += '<div id="confirm-modal-content" class="modal-content">';
        box += '<div id="confirm-modal-body" class="modal-body"> </div>';
        box += '<div id="confirm-modal-footer" class="modal-footer">';
        box += '<button id="confirm-modal-btn-default" type="button" class="btn btn-default" data-dismiss="modal">No</button>';
        box += '<button id="confirm-modal-btn-primary" type="button" class="btn btn-primary">Ok</button>';
        box += '</div></div></div></div>';
        $("body").append(box);

        confirm2 = function (dialog, command, data) {
            $("#confirm-modal-body").html( dialog.replace(/\n/, "<br />") );
            $('#confirm-modal').modal();
            $("#confirm-modal-btn-default").on('click', function() {
                $(this).modal('hide');
            });
            $("#confirm-modal-btn-primary").off('click');
            $("#confirm-modal-btn-primary").on('click', function() {
                $("#confirm-modal").modal('hide');
                if(typeof command == "function"){
                    command(this, data);
                }
            });
        };
    };
</script>