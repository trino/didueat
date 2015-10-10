<div class="sidebar col-md-2 col-sm-4 col-xs-12">
    <aside class="sidebar sidebar--shop">
        <div class="shop-filter">
            @if(\Session::get('session_profileType') == 1)



                <div class="portlet box red">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-gift"></i>Administrator
                        </div>
                    </div>
                    <div class="portlet-body">

                        <ul class="list-group margin-bottom-25 sidebar-menu">
                            <li class="list-group-item clearfix"><a href="{{ url('dashboard') }}"
                                                                    class="<?php if (Request::path() == 'dashboard') {
                                                                        echo 'active';
                                                                    } ?>"><i class="fa fa-angle-right"></i>
                                    Dashboard</a></li>
                            <li class="list-group-item clearfix"><a href="{{ url('restaurant/users') }}"
                                                                    class="<?php if (Request::path() == 'restaurant/users') {
                                                                        echo 'active';
                                                                    } ?>"><i class="fa fa-angle-right"></i> Users</a>
                            </li>
                            <!--li class="list-group-item clearfix"><a href="{{ url('restaurant/newsletter') }}" class="<?php if (Request::path() == 'restaurant/newsletter') {
                                echo 'active';
                            } ?>"><i class="fa fa-angle-right"></i> Newsletter</a></li-->
                            <li class="list-group-item clearfix"><a href="{{ url('restaurant/restaurants') }}"
                                                                    class="<?php if (Request::path() == 'restaurant/restaurants') {
                                                                        echo 'active';
                                                                    } ?>"><i class="fa fa-angle-right"></i> Restaurants</a>
                            </li>

                            <li class="list-group-item clearfix"><a href="{{ url('restaurant/eventlog') }}"
                                                                    class="<?php if (Request::path() == 'restaurant/eventlog') {
                                                                        echo 'active';
                                                                    } ?>"><i class="fa fa-angle-right"></i> Event
                                    Log</a></li>

                        </ul>
                    </div>
                </div>




            @endif
            @if(\Session::get('session_restaurantId'))

                <div class="portlet box red">

                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-gift"></i>Restaurant
                        </div>
                    </div>

                    <div class="portlet-body">

                        <ul class="list-group margin-bottom-25 sidebar-menu">

                            <li class="list-group-item clearfix"><a
                                        href="{{ url('restaurant/orders/history/'.\Session::get('session_restaurantId')) }}"
                                        class="<?php if (Request::path() == 'restaurant/orders/history/' . \Session::get('session_restaurantId')) {
                                            echo 'active';
                                        } ?>"><i class="fa fa-angle-right"></i> My Orders</a></li>


                            <li class="list-group-item clearfix"><a href="{{ url('restaurant/menus-manager') }}"
                                                                    class="<?php if (Request::path() == 'restaurant/menus-manager') {
                                                                        echo 'active';
                                                                    } ?>"><i class="fa fa-angle-right"></i> Menu Manager</a>
                            </li>
                            <li class="list-group-item clearfix"><a href="{{ url('restaurant/addresses') }}"
                                                                    class="<?php if (Request::path() == 'restaurant/addresses') {
                                                                        echo 'active';
                                                                    } ?>"><i class="fa fa-angle-right"></i> Notifications
                                </a></li>

                            <li class="list-group-item clearfix"><a href="{{ url('restaurant/info') }}"
                                                                    class="<?php if (Request::path() == 'restaurant/info') {
                                                                        echo 'active';
                                                                    } ?>"><i class="fa fa-angle-right"></i> Restaurant
                                    Info</a>
                            </li>

                            <!--<li class="list-group-item clearfix"><a href="{{ url('restaurant/orders/pending') }}" class="<?php if (Request::path() == 'restaurant/orders/pending') {
                                echo 'active';
                            } ?>"><i class="fa fa-angle-right"></i> Pending Orders <span class="notification">({{ countOrders('pending') }})</span></a></li>-->

                            <!--<li class="list-group-item clearfix"><a href="{{ url('restaurant/report') }}" class="<?php if (Request::path() == 'restaurant/report') {
                                echo 'active';
                            } ?>"><i class="fa fa-angle-right"></i> Print Report</a></li>-->
                        </ul>
                    </div>
                </div>

            @endif

            <div class="portlet box red">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i>User
                    </div>
                </div>
                <div class="portlet-body">
                    <ul class="list-group margin-bottom-25 sidebar-menu">


                        <li class="list-group-item clearfix"><a
                                    href="{{ url('restaurant/orders/history/'.\Session::get('session_restaurantId')) }}"
                                    class="<?php if (Request::path() == 'restaurant/orders/history/' . \Session::get('session_restaurantId')) {
                                        echo 'active';
                                    } ?>"><i class="fa fa-angle-right"></i> My Orders</a></li>


                        <li class="list-group-item clearfix"><a href="{{ url('user/images') }}"
                                                                class="<?php if (Request::path() == 'user/images') {
                                                                    echo 'active';
                                                                } ?>"><i class="fa fa-angle-right"></i> My Uploads</a>
                        </li>


                        <li class="list-group-item clearfix"><a href="{{ url('user/addresses') }}"
                                                                class="<?php if (Request::path() == 'user/addresses') {
                                                                    echo 'active';
                                                                } ?>"><i class="fa fa-angle-right"></i>My Address</a>
                        </li>



                        <li class="list-group-item clearfix"><a href="{{ url('user/info') }}"
                                                                class="<?php if (Request::path() == 'user/info') {
                                                                    echo 'active';
                                                                } ?>"><i class="fa fa-angle-right"></i> My Info</a>
                        </li>


                        <!--li class="list-group-item clearfix"><a href="{{ url('logout') }}"
                                                                class="<?php if (Request::path() == 'logout') {
                                                                    echo 'active';
                                                                } ?>"><i class="fa fa-angle-right"></i> Logout</a></li-->
                    </ul>
                </div>
            </div>
        </div>
    </aside>
</div>