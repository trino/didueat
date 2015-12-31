<div class=" col-lg-3">
    <?php printfile("views/dashboard/layouts/leftsidebar.blade.php"); ?>

    <div class="card">
        <div class="card-header">
            User Navigation
        </div>
        <div class="card-block p-a-0">

            <div class="list-group-flush">

                <a href="{{ url('orders/list/user') }}"
                   class="list-group-item <?php
                   if (Request::path() == 'orders/list/user') {
                       echo 'active';
                   }
                   ?>"><i class="fa fa-angle-right"></i> My Orders</a>

                <a href="{{ url('user/addresses') }}"
                   class="list-group-item <?php
                   if (Request::path() == 'user/addresses') {
                       echo 'active';
                   }
                   ?>"><i class="fa fa-angle-right"></i> My Addresses</a>

                <a href="{{ url('user/info') }}"
                   class="list-group-item <?php
                   if (Request::path() == 'user/info') {
                       echo 'active';
                   }
                   ?>"><i class="fa fa-angle-right"></i> My Profile</a>

                <a href="{{ url('credit-cards/list/user') }}"
                   class="list-group-item <?php
                   if (Request::path() == 'credit-cards/list/user') {
                       echo 'active';
                   }
                   ?>"><i class="fa fa-angle-right"></i> Credit Cards</a>

            </div>
        </div>
    </div>


    @if(\Session::get('session_restaurant_id'))

    <div class="card">
        <div class="card-header">
            Restaurant Navigation
        </div>
        <div class="card-block p-a-0">
            <div class=" list-group-flush">

                <a href="{{ url('orders/list/restaurant') }}"
                   class="list-group-item <?php
                   if (Request::path() == 'orders/list/restaurant') {
                       echo 'active';
                   }
                   ?>"><i class="fa fa-angle-right"></i> My Orders</a>

                <a href="{{ url('restaurants/' . select_field('restaurants', 'id', \Session::get('session_restaurant_id'), 'slug') . '/menus') }}"
                   class="list-group-item <?php
                   if (Request::path() == url('restaurants/' . select_field('restaurants', 'id', \Session::get('session_restaurant_id'), 'slug') . '/menus')) {
                       echo 'active';
                   }
                   ?>"><i class="fa fa-angle-right"></i> My Menu </a>

                <a href="{{ url('restaurant/addresses') }}"
                   class="list-group-item <?php
                   if (Request::path() == 'restaurant/addresses') {
                       echo 'active';
                   }
                   ?>"><i class="fa fa-angle-right"></i> Notification Addresses</a>

                <a href="{{ url('restaurant/info') }}"
                   class="list-group-item <?php
                   if (Request::path() == 'restaurant/info') {
                       echo 'active';
                   }
                   ?>"><i class="fa fa-angle-right"></i> Restaurant Info</a>

                @if(\Session::has('session_profiletype') && \Session::get('session_profiletype') != 1)

                <a href="{{ url('users/credit-cards') }}"
                   class="list-group-item <?php
                   if (Request::path() == 'users/credit-cards/restaurant') {
                       echo 'active';
                   }
                   ?>"><i class="fa fa-angle-right"></i> Credit Cards</a>

                @endif
            </div>
        </div>
        @endif
    </div>

    
    @if(check_permission("can_edit_global_settings"))
    <div class="card">
        <div class="card-header">
            Admin Navigation
        </div>
        <div class="card-block p-a-0">
            <div class="list-group-flush">

                <a href="{{ url('orders/list/admin') }}"
                   class="list-group-item <?php
                   if (Request::path() == 'orders/list/admin') {
                       echo 'active';
                   }
                   ?>"><i class="fa fa-angle-right"></i> Orders</a>

                <a href="{{ url('users/list') }}"
                   class="list-group-item <?php
                   if (Request::path() == 'users/list') {
                       echo 'active';
                   }
                   ?>"><i class="fa fa-angle-right"></i> Users</a>

                <a href="{{ url('restaurant/list') }}"
                   class="list-group-item <?php
                   if (Request::path() == 'restaurant/list') {
                       echo 'active';
                   } ?>"><i class="fa fa-angle-right"></i> Restaurants</a>

                <a href="{{ url('subscribers/list') }}"
                   class="list-group-item <?php
                   if (Request::path() == 'subscribers/list') {
                       echo 'active';
                   }
                   ?>"><i class="fa fa-angle-right"></i> Subscribers</a>

                <a href="{{ url('eventlogs/list') }}"
                   class="list-group-item <?php
                   if (Request::path() == 'eventlogs/list') {
                       echo 'active';
                   }
                   ?>"><i class="fa fa-angle-right"></i> Event Log</a>

                <a href="{{ url('user/reviews') }}"
                   class="list-group-item <?php
                   if (Request::path() == 'user/reviews') {
                       echo 'active';
                   }
                   ?>"><i class="fa fa-angle-right"></i> User Reviews</a>

                @if(\Session::has('session_profiletype') && \Session::get('session_profiletype') == 1)

                <a href="{{ url('credit-cards/list/admin') }}"
                   class="list-group-item <?php
                   if (Request::path() == 'credit-cards/list/admin') {
                       echo 'active';
                   }
                   ?>"><i class="fa fa-angle-right"></i> Credit Cards</a>

                @endif
            </div>
        </div>
    </div>
    @endif


</div>