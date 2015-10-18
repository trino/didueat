<div class="header">
    <div class="container-fluid">
        <a class="site-logo" href="{{ url('/') }}"><img src="{{ url('assets/images/logos/logo.png') }}" alt="didueat?"
                                                        style="height: 40px; position: relative; top: 2px;"/></a>
        <a href="#header-nav" class="fancybox-fast-view new_headernav hide"></a>

        <!-- BEGIN NAVIGATION -->
        <div class="header-navigation-wrap" id="header-nav">
            <div class="header-navigation">
                <ul>
                    <!-- BEGIN TOP BAR MENU -->

                    <!--li><a href="#"><i class="material-icons">search</i></a></li>
                    <li><a href="#"><i class="material-icons">view_module</i></a></li>
                    <li><a href="#"><i class="material-icons">refresh</i></a></li>
                    <li><a href="#"><i class="material-icons">more_vert</i></a></li-->


                    <li><a href="{{ url('/') }}">Meals</a></li>
                    <li><a href="{{ url('restaurants') }}">Restaurants</a></li>
                    @if(Session::has('is_logged_in'))
                        <li><a href="{{ url('dashboard') }}">Admin's Dashboard</a></li>
                    @else
                        <li><a href="{{ url('restaurants/signup') }}">Restaurant Owner</a></li>
                    @endif
                    <li><a style="" href="mailto:info@trinoweb.com?cc=info@didueat.ca our name address phone number">Email</a>
                    </li>
                    @if(Session::has('is_logged_in'))
                        <li><a href="{{ url('auth/logout') }}" class="fancybox-fast-view">Log Out</a></li>
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
                                    <input type="text" name="search_term" placeholder="Search Menus"
                                           class="form-control"/>
                                <span class="input-group-btn">
                                    <button class="btn btn-primary red" type="submit">Search</button>
                                </span>
                                </div>
                                {!! Form::close() !!}
                                <br/>
                                {!! Form::open(array('url' => '/search/restaurants', 'id'=>'searchRestaurantForm','class'=>'form-horizontal','method'=>'get','role'=>'form')) !!}
                                <div class="input-group" valign="center">
                                    <input type="text" name="search_term" placeholder="Search Restaurants"
                                           class="form-control"/>
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


<a href="#header-nav" class="fancybox-fast-view new_headernav hide" style="display: block !important;"></a>
<div id="header-nav">
</div>
