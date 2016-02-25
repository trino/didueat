<nav class="navbar navbar-fixed-top navbar-dark bg-success header-nav">
    <div class="container" style="margin-top:0px !important;padding-left: 1rem !important;padding-right: 1rem !important;">
        <a class="hidden-sm-down" href="{{ url('/') }}">
            <img class="pull-left" src="{{ asset('assets/images/logo.png') }}" alt="diduEAT" style="height: 38px;"/>
        </a>
        <a style="color: white;font-weight:bold;padding-top:5px;" class="hidden-md-up pull-left  nav-link" href="{{ url('/') }}">
            DiduEat
        </a>
        <ul class="nav navbar-nav pull-right ">
            <li class="nav-item ">

                <A ID="cart-header" style="display:none;" href="#checkout_anchor" CLASS="btn btn-sm btn-warning" onclick="return checkout();">
                    <SPAN class="cart-header-items"></SPAN>
                    <i class="fa fa-shopping-cart"></i>
                    <SPAN class="cart-header-total"></SPAN>
                </A>


                @if(Session::has('is_logged_in'))
                    @if (read("oldid"))
                        <a style="padding-left:6px !important;" href="{{ url('restaurant/users/action/user_depossess/' . read("oldid")) }} " class="nav-link pull-right">De-Possess</a>
                    @endif

                    <a href="#" data-toggle="modal" data-target="#navigationModal" style="padding-left:6px !important; color:white; text-decoration: none;" class="pull-right" onclick="modalcheck();">
                        <img src="<?php
                            $filename = 'assets/images/users/' . read("id") . "/icon-" . Session::get('session_photo', "");
                            if (Session::has('session_photo') && file_exists(public_path($filename))) {
                                echo asset($filename);
                            } else {
                                echo asset('assets/images/icon-didueatdefault.png');
                            }
                        ?>" class="img-rounded" style="margin-left:6px !important;height: 31px;width:31px;">
                        <span class="hidden-sm-down ">{{explode(' ', Session::get('session_name'))[0] }}</span>
                    </a>

                    <a href="#" data-toggle="modal" data-target="#navigationModal" class="pull-right"></a>

                    <!--a type="button" data-toggle="collapse" href="#"
                       class="pull-xs-right hidden-sm-up btn btn-sm btn-primary "
                       data-toggle="collapse" data-target=".navbar-collapse"><i class="fa fa-bars"></i></a-->
                    <!--li class="nav-item"><a href="{{ url('auth/logout') }}" class="nav-link">Log out</a></li-->
                @else
                    <div class="btn-group">
                        <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#signupModal">Signup</a>
                        <a class="btn btn-sm btn-primary-outline reserve_login" data-toggle="modal" data-target="#loginModal" onclick="$('#login-ajax-form').attr('data-route', 'reservation');">Login</a>
                    </div>

                @endif
            </li>

        </ul>
    </div>
</nav>
<SCRIPT>
    function modalcheck(){
        if ($("#navigationModal").length == 0){
            window.location.assign("{{  url("user/info") }}");
        }
    }
</SCRIPT>