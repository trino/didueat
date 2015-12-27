<?php printfile("views/dashboard/layouts/includes/header.blade.php"); ?>

<nav class="navbar navbar-default navbar-dark navbar-fixed-top primary_red" role="navigation">
    <button class="navbar-toggler hidden-xs-up" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar2">
        &#9776;
    </button>

    <a class="navbar-brand" href="{{ url('/') }}">
        <img src="{{ asset('assets/images/logos/logo.png') }}" alt="diduEAT" style="height: 30px;"/>
    </a>
    <ul class="nav navbar-nav">

        @if(Request::path() == '/' || (isset($searchTerm) && Request::path() == "restaurants/".$searchTerm) || (isset($slug) && Request::path() == "restaurants/".$slug."/menus"))
            <li class="nav-item">

                <input type="text" name="formatted_address" id="formatted_address" class="form-control"
                       placeholder="Address, City or Postal Code" value="" onFocus="geolocate()">
            </li>
        @endif
    </ul>

    <div class="collapse navbar-toggleable-xs pull-right" id="exCollapsingNavbar2">
        <ul class="nav navbar-nav">

            @if(Session::has('is_logged_in'))

                <li class="nav-item">
                    <a href="{{ url('dashboard') }}" class="nav-link">
                        Hi, {{ explode(' ', Session::get('session_name'))[0] }} </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('dashboard') }}" class="nav-link">
                        <img src="<?php if (Session::has('session_photo')) {
                            echo asset('assets/images/users/' . Session::get('session_photo'));
                        } else {
                            echo asset('assets/images/default.png');
                        } ?>" class="" style="height: 20px;">
                    </a>
                </li>

                <li class="nav-item"><a href="{{ url('auth/logout') }}" class="nav-link">Log Out</a></li>

            @else
                <li class="nav-item">


                    <a  class="btn btn-danger  pull-right" data-toggle="modal" data-target="#loginModal">
                        Log in
                    </a>

                </li>

                <li class="nav-item">


                    <a class="btn btn-danger  pull-right" data-toggle="modal" data-target="#signupModal">
                        Sign up
                    </a>

                </li>



            @endif
        </ul>
    </div>
</nav>