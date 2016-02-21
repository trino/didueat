<nav class="navbar navbar-fixed-top navbar-dark bg-success">
    <div class="container" style="margin-top:0px !important;">
        <a class="hidden-sm-down" href="{{ url('/') }}">
            <img class="pull-left" src="{{ asset('assets/images/logo.png') }}" alt="diduEAT" style="height: 30px;"/>
        </a>
        <a style="color: white;font-weight:bold;" class="hidden-sm-up pull-left  nav-link" href="{{ url('/') }}">
            Didu Eat
        </a>
        <ul class="nav navbar-nav pull-right">
            <li class="nav-item">
                <A ID="cart-header" style="display:none;" href="#checkout_anchor" CLASS="btn btn-sm btn-warning"
                   style=""
                   onclick="checkout();">
                    <SPAN class="card-header-items"></SPAN>
                    <!--i class="fa fa-shopping-cart"></i-->
                    <SPAN class="card-header-total"></SPAN>
                </A>


                @if(Session::has('is_logged_in'))

                    @if (read("oldid"))
                        <a style="padding-left:6px !important;"
                           href="{{ url('restaurant/users/action/user_depossess/' . read("oldid")) }} "
                           class="nav-link pull-right">De-Possess</a>
                    @endif

                    <a href="#" data-toggle="modal" data-target="#navigationModal"
                       style="padding-left:6px !important;"
                       class="hidden-sm-down pull-right nav-link">{{explode(' ', Session::get('session_name'))[0] }}</a>

                    <a href="#" data-toggle="modal" data-target="#navigationModal" class="pull-right">
                        <img src="<?php
                        $filename = 'assets/images/users/' . read("id") . "/thumb_" . Session::get('session_photo', "");
                        if (Session::has('session_photo') && file_exists(public_path($filename))) {
                            echo asset($filename);
                        } else {
                            echo asset('assets/images/thumb1_didueatdefault.png');
                        }
                        ?>" class="img-rounded pull-right" style="margin-left:6px !important;height: 32px;width:32px;">
                    </a>

                    <a type="button" data-toggle="collapse" href="#"
                       class="pull-xs-right hidden-sm-up btn btn-sm btn-primary "
                       data-toggle="collapse" data-target=".navbar-collapse"><i class="fa fa-bars"></i></a>
                    <!--li class="nav-item"><a href="{{ url('auth/logout') }}" class="nav-link">Log out</a></li-->
                @else
                    <div class="btn-group">
                        <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#signupModal">Signup</a>
                        <a class="btn btn-sm btn-primary-outline" data-toggle="modal"
                           data-target="#loginModal">Login</a>
                    </div>

                @endif
            </li>

        </ul>
    </div>
</nav>