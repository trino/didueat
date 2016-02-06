<?php
    $first = false;
    $type = "hidden";
?>

<nav class="navbar navbar-default navbar-dark navbar-fixed-top bg-primary" role="navigation">

<div class="container" style="padding-top: 0px !important;">

        <a class="navbar-brand" href="{{ url('/') }}">
            <i class="fa fa-arrow-left pull-left" style="padding-top:5px;"></i>
            <img src="{{ asset('assets/images/logo.png') }}" alt="diduEAT" style="height: 30px;"/>
        </a>


        <div class="pull-right header-nav">
            <ul class="nav navbar-nav">

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
                    <li class="nav-item" style="    margin-left: 6px;">
                        <a href="{{ url('dashboard') }}"
                           class="nav-link">Hi, {{ explode(' ', Session::get('session_name'))[0] }} </a>
                    </li>

                    @if (read("oldid"))
                        <li class="nav-item"><a
                                    href="{{ url('restaurant/users/action/user_depossess/' . read("oldid")) }} "
                                    class="nav-link">De-possess</a></li>
                    @endif
                    <!--li class="nav-item"><a href="{{ url('auth/logout') }}" class="nav-link">Log Out</a></li-->
                @else
                    <li class="nav-item">
                        <a class="btn btn-primary" data-toggle="modal" data-target="#loginModal">Log in</a>
                        <a class="btn btn-primary" data-toggle="modal" data-target="#signupModal">Sign up</a>
                    </li>



                @endif
            </ul>
        </div>
</div>
</nav>