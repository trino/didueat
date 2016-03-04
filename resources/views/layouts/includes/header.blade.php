<nav class="navbar navbar-fixed-top navbar-dark bg-success header-nav">
    <div class="container" style="margin-top:0px !important;">
        <a class="hidden-sm-down" href="{{ url('/') }}">
            <img class="pull-left" src="{{ asset('assets/images/logo.png') }}" alt="{{ DIDUEAT }}"
                 style="height: 38px;"/>
        </a>
        <a style="" class="hidden-md-up pull-left  nav-link" href="{{ url('/') }}">
            <img class="pull-left" src="{{ asset('assets/images/icon.png') }}" alt="{{ DIDUEAT }}"
                 style="height: 38px;"/>
        </a>
        <ul class="nav navbar-nav pull-right ">
            <li class="nav-item ">

                <A ID="cart-header" style="display:none;" CLASS="btn-responsive anchor btn  btn-warning"
                   onclick="return scrolltocheckout();">
                    <span class="fa fa-spinner fa-spin cart-header-gif"></SPAN>

                    <SPAN class="cart-header-items cart-header-show"></SPAN>
                    <SPAN class="cart-header-total cart-header-show"></SPAN>
                    <i class="fa fa-shopping-cart cart-header-show"></i>
                </A>


                @if(Session::has('is_logged_in'))
                    @if (read("oldid"))
                        <a style="padding-left:6px !important;"
                           href="{{ url('restaurant/users/action/user_depossess/' . read("oldid")) }} "
                           class="nav-link pull-right">De-Possess</a>
                    @endif

                    <a href="#" data-toggle="modal" data-target="#navigationModal"
                       style="padding-top:2px;padding-left:6px !important; color:white; text-decoration: none;" class="pull-right"
                       onclick="modalcheck();">

                        <img src="<?php
                        $filename = 'assets/images/users/' . read("id") . "/icon-" . Session::get('session_photo', "");
                        if (Session::has('session_photo') && file_exists(public_path($filename))) {
                            echo asset($filename);
                        } else {
                            echo asset('assets/images/icon-didueatdefault.png');
                        }
                        ?>" class="img-circle" style="margin-left:6px !important;height: 32px;width:32px;">


                        <span class="hidden-sm-down" style="">{{explode(' ', Session::get('session_name'))[0] }}</span>


                    </a>

                    <!--a href="#" data-toggle="modal" data-target="#navigationModal" class="pull-right"></a-->

                    <!--a type="button" data-toggle="collapse" href="#"
                       class="pull-xs-right hidden-sm-up btn btn-sm btn-primary "
                       data-toggle="collapse" data-target=".navbar-collapse"><i class="fa fa-bars"></i></a-->
                    <!--li class="nav-item"><a href="{{ url('auth/logout') }}" class="nav-link">Log out</a></li-->
                @else
                    <div class="btn-group">
                        <a class="btn  btn-primary-outline reserve_login btn-responsive" data-toggle="modal"
                           data-target="#loginModal" onclick="$('#login-ajax-form').attr('data-route', 'reservation');">Login</a>
                        <a class="btn btn-primary btn-responsive" data-toggle="modal" data-target="#signupModal">Signup</a>

                    </div>

                @endif
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