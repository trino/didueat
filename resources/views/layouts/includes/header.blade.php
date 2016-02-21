<?php
$first = false;
$type = "hidden";
?>

<nav class="navbar navbar-default navbar-dark navbar-fixed-top bg-success" role="navigation"
     style="padding-left:0 !important;padding-right:0 !important;">

    <div class="container" style=" margin-top:0 !important;">


        <div class="header-nav text-xs-center">
            <ul class="nav navbar-nav pull-left">

            <li class="nav-item" style="">

            <a class="hidden-sm-down" href="{{ url('/') }}">

                <img class="pull-left" src="{{ asset('assets/images/logo.png') }}" alt="diduEAT" style="height: 30px;"/>
            </a>

            <a style="color: white;font-weight:bold;" class="hidden-sm-up pull-left  nav-link" href="{{ url('/') }}">

                Didu Eat
            </a>
</li>
                </ul>
            <ul class="nav navbar-nav pull-right">


                <li class="nav-item" style="padding-top:4px;">

                    <A ID="cart-header" style="display:none;" href="#checkout_anchor" CLASS="btn btn-sm btn-warning"
                       style=""
                       onclick="checkout();">
                        <SPAN class="card-header-items"></SPAN>
                        <!--i class="fa fa-shopping-cart"></i-->
                        <SPAN class="card-header-total"></SPAN>
                    </A>

                    @if(Session::has('is_logged_in'))


                        <a   style="margin-left:5px;" href="{{ url('dashboard') }}"
                           class="hidden-sm-down pull-right nav-link">Hi, {{ explode(' ', Session::get('session_name'))[0] }} </a>

                        <a href="{{ url('dashboard') }}" class="pull-right">
                            <img src="<?php
                            $filename = 'assets/images/users/' . read("id") . "/thumb_" . Session::get('session_photo', "");
                            if (Session::has('session_photo') && file_exists(public_path($filename))) {
                                echo asset($filename);
                            } else {
                                echo asset('assets/images/thumb1_smiley-logo.png');
                            }
                            ?>" class="img-rounded" style="height: 25px;width:25px;">
                        </a>

                        <!--li class="nav-item"><a href="{{ url('auth/logout') }}" class="nav-link">Log out</a></li-->
                    @else
                        <div class="btn-group">
                            <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#signupModal">Signup</a>
                            <a class="btn btn-sm btn-primary-outline" data-toggle="modal" data-target="#loginModal">Login</a>
                        </div>
                    @endif


                    @if (read("oldid"))
                        <a
                                href="{{ url('restaurant/users/action/user_depossess/' . read("oldid")) }} "
                                class="nav-link">De-possess</a>
                    @endif

                </li>

                <LI class="nav-item" id="expand-header" style="display: none;">
                    <a href="javascript:;" class="btn btn-sm btn-primary menu-toggler responsive-toggler"
                       data-toggle="collapse" data-target=".navbar-collapse"><i class="fa fa-bars"></i></a>
                </LI>
            </ul>
        </div>
    </div>
</nav>