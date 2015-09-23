<div class="sidebar col-md-3 col-sm-4 col-xs-12">
    <aside class="sidebar  sidebar--shop">
        <div class="shop-filter">
            <h4>Administrator</h4>
            <ul class="list-group margin-bottom-25 sidebar-menu">
                <li class="list-group-item clearfix"><a href="{{ url('dashboard') }}" class="<?php if(Request::path() == 'dashboard'){ echo 'active'; } ?>"><i class="fa fa-angle-right"></i> Dashboard</a></li>
                <li class="list-group-item clearfix"><a href="{{ url('restaurant/users') }}" class="<?php if(Request::path() == 'restaurant/users'){ echo 'active'; } ?>"><i class="fa fa-angle-right"></i> Users Manager</a></li>
                <li class="list-group-item clearfix"><a href="{{ url('restaurant/restaurants') }}" class="<?php if(Request::path() == 'restaurant/restaurants'){ echo 'active'; } ?>"><i class="fa fa-angle-right"></i> Restaurants</a></li>
                <li class="list-group-item clearfix"><a href="{{ url('restaurant/newsletter') }}" class="<?php if(Request::path() == 'restaurant/newsletter'){ echo 'active'; } ?>"><i class="fa fa-angle-right"></i> Newsletter</a></li>
            </ul>
            <hr class="shop__divider">
            <h4>Restaurant</h4>
            <ul class="list-group margin-bottom-25 sidebar-menu">
                <li class="list-group-item clearfix"><a href="{{ url('restaurant/info') }}" class="<?php if(Request::path() == 'restaurant/info'){ echo 'active'; } ?>"><i class="fa fa-angle-right"></i> Restaurant Info</a></li>
                <li class="list-group-item clearfix"><a href="{{ url('restaurant/addresses') }}" class="<?php if(Request::path() == 'restaurant/addresses'){ echo 'active'; } ?>"><i class="fa fa-angle-right"></i> Notifications Addresses</a></li>
                <li class="list-group-item clearfix"><a href="{{ url('restaurant/menus-manager') }}" class="<?php if(Request::path() == 'restaurant/menus-manager'){ echo 'active'; } ?>"><i class="fa fa-angle-right"></i> Menu Manager</a></li>
                <li class="list-group-item clearfix"><a href="{{ url('restaurant/orders/pending') }}" class="<?php if(Request::path() == 'restaurant/orders/pending'){ echo 'active'; } ?>"><i class="fa fa-angle-right"></i> Pending Orders <span class="notification">(20)</span></a></li>
                <li class="list-group-item clearfix"><a href="{{ url('restaurant/orders/history') }}" class="<?php if(Request::path() == 'restaurant/orders/history'){ echo 'active'; } ?>"><i class="fa fa-angle-right"></i> Order History</a></li>
                <li class="list-group-item clearfix"><a href="{{ url('restaurant/eventlog') }}" class="<?php if(Request::path() == 'restaurant/eventlog'){ echo 'active'; } ?>"><i class="fa fa-angle-right"></i> Event Log</a></li>
                <li class="list-group-item clearfix"><a href="{{ url('restaurant/report') }}" class="<?php if(Request::path() == 'restaurant/report'){ echo 'active'; } ?>"><i class="fa fa-angle-right"></i> Print Report</a></li>
            </ul>
            <hr class="shop__divider">
            <h4>User</h4>
            <ul class="list-group margin-bottom-25 sidebar-menu">
                <li class="list-group-item clearfix"><a href="{{ url('user/info') }}" class="<?php if(Request::path() == 'user/info'){ echo 'active'; } ?>"><i class="fa fa-angle-right"></i> User Info</a></li>
                <li class="list-group-item clearfix"><a href="{{ url('user/addresses') }}" class="<?php if(Request::path() == 'user/addresses'){ echo 'active'; } ?>"><i class="fa fa-angle-right"></i> Addresses</a></li>
                <li class="list-group-item clearfix"><a href="{{ url('user/images') }}" class="<?php if(Request::path() == 'user/images'){ echo 'active'; } ?>"><i class="fa fa-angle-right"></i> Images</a></li>
                <li class="list-group-item clearfix"><a href="{{ url('logout') }}" class="<?php if(Request::path() == 'logout'){ echo 'active'; } ?>"><i class="fa fa-angle-right"></i> Logout</a></li>
            </ul>            
            <hr class="shop__divider">
        </div>
    </aside>
</div>