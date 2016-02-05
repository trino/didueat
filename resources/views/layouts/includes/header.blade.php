<?php
    printfile("views/dashboard/layouts/includes/header.blade.php");
    $first = false;
    $type = "hidden";
?>

<nav class="navbar navbar-default navbar-dark navbar-fixed-top bg-danger" role="navigation">

<div class="container">

        <a class="navbar-brand" href="{{ url('/') }}">
            <i class="fa fa-arrow-left pull-left" style="padding-top:5px;"></i>
            <img src="{{ asset('assets/images/logo.png') }}" alt="diduEAT" style="height: 30px;"/>
        </a>


        <div class="collapse navbar-toggleable-xs pull-right header-nav" id="exCollapsingNavbar2" style="">
            <ul class="nav navbar-nav">

                @if(Session::has('is_logged_in'))


                    <li class="nav-item">
                        <a href="{{ url('dashboard') }}"
                           class="nav-link">Hi, {{ explode(' ', Session::get('session_name'))[0] }} </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('dashboard') }}" class="nav-link">
                            <img src="<?php
                            $filename = 'assets/images/users/' . read("id") . "/" . Session::get('session_photo', "");
                            if (Session::has('session_photo') && file_exists(public_path($filename))) {
                                echo asset($filename);
                            } else {
                                echo asset('assets/images/default.png');
                            }
                            ?>" class="img-circle" style="height: 25px;width:25px;">
                        </a>
                    </li>
                    @if (read("oldid"))
                        <li class="nav-item"><a
                                    href="{{ url('restaurant/users/action/user_depossess/' . read("oldid")) }} "
                                    class="nav-link">De-possess</a></li>
                    @endif
                    <li class="nav-item"><a href="{{ url('auth/logout') }}" class="nav-link">Log Out</a></li>
                @else
                    <li class="nav-item">
                        <a class="btn btn-danger" data-toggle="modal" data-target="#loginModal">Log in</a>
                        <a class="btn btn-danger" data-toggle="modal" data-target="#signupModal">Sign up</a>
                    </li>



                @endif
            </ul>
        </div>
</div>
</nav>