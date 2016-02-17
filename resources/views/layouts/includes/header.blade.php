<?php
    $first = false;
    $type = "hidden";
?>

<nav class="navbar navbar-default navbar-dark navbar-fixed-top bg-success" role="navigation" style="padding-left:0 !important;padding-right:0 !important;">

<div class="container" style=" margin-top:0 !important;">

        <a class="navbar-brand" href="{{ url('/') }}">

            <img class="pull-left" src="{{ asset('assets/images/logo.png') }}" alt="diduEAT" style="height: 30px;"/>
        </a>


        <div class="pull-right header-nav">
            <ul class="nav navbar-nav">

                <LI class="nav-item" ID="cart-header" style="display: none;">
                    <A CLASS="nav-link" style="padding-bottom: 0px; padding-top: 4px;" onclick="checkout();">
                        <span class="fa-stack">
                            <SPAN class="card-header-items fa-stack-1x"></SPAN>
                            <i class="fa fa-shopping-cart"></i>
                        </span>
                        <SPAN class="card-header-total"></SPAN>
                    </A>
                </LI>

                @if(Session::has('is_logged_in'))
                    <li class="nav-item">
                        <a href="{{ url('dashboard') }}" class="nav-link">
                            <img src="<?php
                            $filename = 'assets/images/users/' . read("id") . "/" . Session::get('session_photo', "");
                            if (Session::has('session_photo') && file_exists(public_path($filename))) {
                                echo asset($filename);
                            } else {
                                echo asset('assets/images/default.png');
                            }
                            ?>" class="img-circle" style="height: 23px;width:23px;">
                        </a>
                    </li>
                    <li class="nav-item hidden-xs-down" style="    margin-left: 6px;">
                        <a href="{{ url('dashboard') }}"
                           class="nav-link">Hi, {{ explode(' ', Session::get('session_name'))[0] }} </a>
                    </li>

                    @if (read("oldid"))
                        <li class="nav-item"><a
                                    href="{{ url('restaurant/users/action/user_depossess/' . read("oldid")) }} "
                                    class="nav-link">De-possess</a></li>
                    @endif
                    <!--li class="nav-item"><a href="{{ url('auth/logout') }}" class="nav-link">Log out</a></li-->
                @else
                    <li class="nav-item">
                        <a class="btn btn-primary" data-toggle="modal" data-target="#signupModal">Sign up</a>

                        <a class="btn btn-primary-outline" data-toggle="modal" data-target="#loginModal">Log in</a>
                    </li>
                @endif

                <LI class="nav-item" id="expand-header" style="display: none;">
                    <a href="javascript:;" class="btn btn-primary menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"><i class="fa fa-bars"></i></a>
                </LI>
            </ul>
        </div>
</div>
</nav>