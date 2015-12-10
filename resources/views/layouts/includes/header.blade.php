<div class="my-navbar">
  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ asset('assets/images/logos/logo.png') }}" alt="DidUEat?"/></a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right" id="top-menu">
          @if(Session::has('is_logged_in'))
            <li>
                <a href="{{ url('dashboard') }}">
                    Hi, {{ explode(' ', Session::get('session_name'))[0] }}
                </a>
            </li>
            <li>
                <a href="{{ url('dashboard') }}">
                    <img src="<?php if (Session::has('session_photo')) { echo asset('assets/images/users/' . Session::get('session_photo')); } else { echo asset('assets/images/default.png'); } ?>" id="avatarImage">
                </a>
            </li>
            <li><a href="{{ url('auth/logout') }}">Log Out</a></li>
          @else
            <li><a href="#login-pop-up" class="fancybox-fast-view">Log In</a></li>
          @endif
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
</div>