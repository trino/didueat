<?php
$alts = array(
        "home" => "Go back to the home page",
        "cart-header" => "Checkout",
        "navigationModal" => "Bring up the options menu",
        "login" => "Log in with your email address and password",
        "signup" => "Create a new account"
);
?>
<nav class="navbar navbar-fixed-top navbar-dark bg-success header-nav">
    <div class="container" style="margin-top:0px !important;">
        <ul class="nav navbar-nav pull-left " style="">
            <li class="nav-item hidden-sm-down ">
                <a class="" href="{{ url('/') }}" title="{{ $alts["home"] }}">
                    <img class="pull-left" src="{{ asset('assets/images/logo.png') }}" alt="{{ DIDUEAT }}"
                         style="height: 40px;margin-top:5px;"/>
                </a>
            </li>
            <li class="nav-item m-l-0">
                <a class="hidden-md-up pull-left" href="{{ url('/') }}" title="{{ $alts["home"] }}">
                    <span style="border-radius:0;" class="btn btn-lg btn-success p-x-0">
                            <!--img class="pull-left" src="{{ asset('assets/images/icon.png') }}" alt="{{ DIDUEAT }}"
                                 style="height: 40px;margin:-14px;padding-right:17px;padding-top:10px;"/-->
                        <strong>DiduEat</strong></span>
                </a>
            </li>
        </ul>


        <ul class="nav navbar-nav pull-right " style="">
            <li class="nav-item ">
                @if(Session::has('is_logged_in'))

<!--a href="#" data-toggle="modal" data-target="#navigationModal" title="{{ $alts["navigationModal"] }}"
style="padding-top:4px;padding-left:6px !important; color:white; text-decoration: none;" class="pull-right"
onclick="modalcheck();">
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
?>" class="img-circle hidden-sm-down" style="margin-left:6px !important;height: 30px;width:30px;">
<span class="hidden-sm-down" style="">{{explode(' ', Session::get('session_name'))[0] }}</span>
<i class="fa fa-bars hidden-md-up"  style="font-size: 27px !important;"></i>
</a-->


                <div class="btn-group">
                    <button type="button" style="border-radius:0;" class="btn btn-lg btn-success"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

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
                        ?>" class="img-circle hidden-sm-down"
                             style="margin-top:-10px !important;margin-bottom:-6px !important;height: 28px;width:28px;">

                        <span class="hidden-sm-down" style="">{{explode(' ', Session::get('session_name'))[0] }}</span>
                        <i class="fa fa-bars hidden-md-up" style=""></i>

                    </button>
                    <div class="dropdown-menu  dropdown-menu-right" style="min-width: 200px;">
                        @include('common.navbar_content')
                    </div>
                </div>

                @else

                    <div class="btn-group">
                        <button style="border-radius:0;padding-left:9px !important;;padding-right:9px !important;"
                                class="btn btn-lg btn-success  reserve_login "
                                data-toggle="modal"
                                title="{{ $alts["login"] }}"
                                data-target="#loginModal"
                                onclick="$('#login-ajax-form').attr('data-route', 'reservation');">Login
                        </button>
                        <button style="padding-left:9px !important;;padding-right:9px !important;border-radius:0;"
                                class="btn btn-lg btn-success " data-toggle="modal"
                                data-target="#signupModal" title="{{ $alts["signup"] }}">Signup
                        </button>
                    </div>
                @endif

            </li>

            <li class="nav-item m-l-0">
                <A ID="cart-header"
                   style="padding-left:9px !important;;padding-right:9px !important;display:none;border-radius: 0;"
                   CLASS="anchor btn bg-warning  btn-lg"
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
<SCRIPT>
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
    });
</SCRIPT>