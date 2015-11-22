<div class="header">
    <div class="container-fluid" >
        <div class="header-navigation-wrap pull-left logo-style" id="header-nav">
            <div class="header-navigation">
                <a class="site-logo" href="{{ url('restaurants') }}"><img src="{{ asset('assets/images/logos/logo.png') }}" alt="DidUEat?" style="padding:0px;padding-left:15px" /></a>
            </div>
        </div>
        <!-- BEGIN NAVIGATION -->
        <div class="header-navigation-wrap pull-left" id="header-nav">
            <div class="header-navigation">
                <ul>
                    <!-- BEGIN TOP BAR MENU -->
                    <li><a href="{{ url('/') }}"></a></li>
                    <li id="top-address-search-input">
                        <input name="addressInput" type="text" id="addressInput" class="form-control address-input" placeholder="Address, City or Postal Code" value="{{ $userAddress }}" autocomplete="off">
                    </li>
                    <li id="top-address-search-input">&nbsp;
                    <select id="radiusSelect" style="margin-right:3px">
																	      <option value="1">1 km</option>
																	      <option value="2">2 km</option>
																	      <option value="5">5 km</option>
																	      <option value="10">10 km</option>
																	      <option value="20">20 km</option>
                    </select>
                    <input id="searchBtn" type="button" onclick="addressChngd()" style="border:none;width:133px;height:36px;background-image: url('assets/images/find-nearby-restaurants.gif');background-color: transparent;background-repeat: no-repeat;background-position: 0px 0px;cursor: pointer;"></input>
                    </li>
      
<script>
 var radiusSelectV=<?php echo $radiusSelect;?>;
 var radObj=document.getElementById('radiusSelect');
 for(var i=0;i<radObj.length;i++){
 	 if(radObj.options[i].value == radiusSelectV){
    radObj.selectedIndex=i;
		  break;
		 }
 }
</script>

                </ul>
            </div>
        </div>
          
        <a href="#header-nav" class="fancybox-fast-view new_headernav hide"></a>
        
        <!-- BEGIN NAVIGATION -->
        <div class="header-navigation-wrap" id="header-nav">
            <div class="header-navigation">
                <ul>
                    <!-- BEGIN TOP BAR MENU -->
                    <!--li><a href="{{ url('/') }}">Meals</a></li>
                    <li><a href="{{ url('restaurants') }}">Restaurants</a></li>
                    @if(!Session::has('is_logged_in'))
                        <li><a href="{{ url('restaurants/signup') }}">Restaurant Owner</a></li>
                    @endif
                    <li><a style="" href="mailto:info@trinoweb.com?cc=info@didueat.ca">Email</a>
                    </li-->
                    @if(Session::has('is_logged_in'))
                    <li><a href="{{ url('dashboard') }}">Hi,  {{ explode(' ', Session::get('session_name'))[0] }}
                            <img src="<?php
                            $Image = asset('assets/images/default.png');
                            if (Session::has('session_photo')) {
                                if (Session::get('session_photo')) {
                                    $Image = asset('assets/images/users/' . Session::get('session_photo'));
                                }
                            }
                            echo $Image; ?>" id="avatarImage"></a>
                    <li><a href="{{ url('auth/logout') }}">Log Out</a></li>
                    @else
                    <li><a href="#login-pop-up" class="fancybox-fast-view">Log In</a></li>
                    @endif
                    <!-- BEGIN TOP SEARCH -->
                    <li class="menu-search">
                        <span class="sep"></span>
                        <i class="fa fa-search search-btn"></i>
                        <div class="search-box">
                            {!! Form::open(array('url' => '/search/menus', 'id'=>'searchMenuForm','class'=>'form-horizontal','method'=>'get','role'=>'form')) !!}
                            <div class="input-group" valign="center">
                                <input type="text" name="search_term" placeholder="Search Menus" class="form-control"/>
                                <span class="input-group-btn">
                                    <button class="btn btn-primary red" type="submit">Search</button>
                                </span>
                            </div>
                            {!! Form::close() !!}
                            <br/>
                            {!! Form::open(array('url' => '/search/restaurants', 'id'=>'searchRestaurantForm','class'=>'form-horizontal','method'=>'get','role'=>'form')) !!}
                            <div class="input-group" valign="center">
                                <input type="text" name="search_term" placeholder="Search Restaurants" class="form-control"/>
                                <span class="input-group-btn">
                                    <button class="btn btn-primary red" type="submit">Search</button>
                                </span>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </li>
                    <!-- END TOP SEARCH -->
                </ul>
            </div>
        </div>
        <!-- END NAVIGATION -->

    </div>
</div>
</div>

<a href="#header-nav" class="fancybox-fast-view new_headernav hide" style="display: none !important;"></a>
<div id="header-nav"></div>
