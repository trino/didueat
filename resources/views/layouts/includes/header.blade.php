<?php printfile("views/dashboard/layouts/includes/header.blade.php"); ?>
@if(false)
    <div class="my-navbar">
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="{{ asset('assets/images/logos/logo.png') }}" alt="DidUEat?"/>
                    </a>
                </div>

                @if(Request::path() == '/' || (isset($searchTerm) && Request::path() == "restaurants/".$searchTerm) || (isset($slug) && Request::path() == "restaurants/".$slug."/menus"))
                    <div id="top-search-creteria">
                        <input type="text" name="formatted_address" id="formatted_address" class="form-control"
                               placeholder="Address, City or Postal Code" value="" onFocus="geolocate()">
                    </div>
                @endif
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right" id="top-menu">
                        @if(Session::has('is_logged_in'))
                            <li>
                                <a href="{{ url('dashboard') }}">
                                    Hi, {{ explode(' ', Session::get('session_name'))[0] }}
                                </a>
                            </li>
                            <li class="avatarli">
                                <a href="{{ url('dashboard') }}">
                                    <img src="<?php if (Session::has('session_photo')) {
                                        echo asset('assets/images/users/' . Session::get('session_photo'));
                                    } else {
                                        echo asset('assets/images/default.png');
                                    } ?>" class="avatarImage">
                                </a>
                            </li>
                            <li><a href="{{ url('auth/logout') }}">Log Out</a></li>
                        @else
                            <li><a href="#login-pop-up" class="fancybox-fast-view"> Login <i class="fa fa-sign-in"></i></a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
    </div>

@endif


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
                <!--a href="#login-pop-up" class="nav-link fancybox-fast-view"> Log in <i
                                class="fa fa-sign-in"></i></a-->

                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#loginModal">
                        Log in
                    </button>
                </li>
            @endif
        </ul>
    </div>
</nav>