<div class="my-navbar">
  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"
                aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{ url('restaurants') }}"><img src="{{ asset('assets/images/logos/logo.png') }}" alt="DidUEat?"/></a>
      </div>



      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        @if( (Request::path() == 'restaurants' || (isset($slug) && Request::path() == 'restaurants/' . $slug . '/menus')) )
        <ul class="nav navbar-nav">
          <li id="top-address-search-input">
            <input name="addressInput" type="text" id="addressInput" class="form-control address-input" placeholder="Address, City or Postal Code"
                   value="{{ $userAddress }}">
          </li>
          <li id="top-address-search-select">
            <select id="radiusSelect" class="topbar-select" onchange="radiusChng(this.value)">
              <option value="1">1 km</option>
              <option value="2">2 km</option>
              <option value="5">5 km</option>
              <option value="10">10 km</option>
              <option value="20">20 km</option>
            </select>
          </li>
          <li id="top-address-search-submit">
            <input class="btn btn-default nearby-res-btn" id="searchBtn" type="button" title="Click to Search" onclick="addressChngd()"
                   value="Find Nearby Restaurants">
          </li>
        </ul>
        @endif
        <div id="header-nav">
          <ul class="nav navbar-nav navbar-right">
            @if(Session::has('is_logged_in'))
              <li><a href="{{ url('dashboard') }}">Hi, {{ explode(' ', Session::get('session_name'))[0] }}
                  <img src="<?php
                  $Image = asset('assets/images/default.png');
                  if (Session::has('session_photo')) {
                    if (Session::get('session_photo')) {
                      $Image = asset('assets/images/users/' . Session::get('session_photo'));
                    }
                  }
                  echo $Image;
                  ?>" id="avatarImage"></a>
              </li>
              <li><a href="{{ url('auth/logout') }}">Log Out</a></li>
            @else
              <li><a href="#login-pop-up" class="fancybox-fast-view">Log In</a></li>
            @endif
          </ul>
        </div>
      </div><!-- /.navbar-collapse -->


    </div><!-- /.container-fluid -->
  </nav>
</div>


