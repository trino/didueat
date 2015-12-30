<div class=" col-lg-3">
    <?php printfile("views/dashboard/layouts/leftsidebar.blade.php"); ?>

    <h5>User Navigation</h5>

    <div class="list-group">

        <a href="{{ url('restaurant/orders/user') }}"
           class="list-group-item <?php if (Request::path() == 'restaurant/orders/user') {
               echo 'active';
           } ?>"><i class="fa fa-angle-right"></i> My Orders</a>

        <a href="{{ url('user/addresses') }}"
           class="list-group-item <?php if (Request::path() == 'user/addresses') {
               echo 'active';
           } ?>"><i class="fa fa-angle-right"></i> My Addresses</a>

        <a href="{{ url('user/info') }}"
           class="list-group-item <?php if (Request::path() == 'user/info') {
               echo 'active';
           } ?>"><i class="fa fa-angle-right"></i> My Profile</a>

        <a href="{{ url('users/credit-cards/user') }}"
           class="list-group-item <?php if (Request::path() == 'users/credit-cards/user') {
               echo 'active';
           } ?>"><i class="fa fa-angle-right"></i> Credit Cards</a>

    </div>


    @if(check_permission("can_edit_global_settings"))
            <p></p>

            <h5>Admin Navigation</h5>
        <div class="list-group">

            <a href="{{ url('restaurant/orders/admin') }}"
               class="list-group-item <?php if (Request::path() == 'restaurant/orders/admin') {
                   echo 'active';
               } ?>"><i class="fa fa-angle-right"></i> Orders</a>

            <a href="{{ url('restaurant/users') }}"
               class="list-group-item <?php if (Request::path() == 'restaurant/users') {
                   echo 'active';
               } ?>"><i class="fa fa-angle-right"></i> Users</a>

            <a href="{{ url('restaurant/list') }}"
               class="list-group-item <?php if (Request::path() == 'restaurant/list') {
                   echo 'active';
               } ?>"><i class="fa fa-angle-right"></i> Restaurants</a>

            <a href="{{ url('restaurant/subscribers') }}"
               class="list-group-item <?php if (Request::path() == 'restaurant/subscribers') {
                   echo 'active';
               } ?>"><i class="fa fa-angle-right"></i> Subscribers</a>

            <a href="{{ url('restaurant/eventlog') }}"
               class="list-group-item <?php if (Request::path() == 'restaurant/eventlog') {
                   echo 'active';
               } ?>"><i class="fa fa-angle-right"></i> Event Log</a>

            <a href="{{ url('user/reviews') }}"
               class="list-group-item <?php if (Request::path() == 'user/reviews') {
                   echo 'active';
               } ?>"><i class="fa fa-angle-right"></i> User Reviews</a>

            @if(\Session::has('session_profiletype') && \Session::get('session_profiletype') == 1)

                <a href="{{ url('users/credit-cards/admin') }}"
                   class="list-group-item <?php if (Request::path() == 'users/credit-cards') {
                       echo 'active';
                   } ?>"><i class="fa fa-angle-right"></i> Credit Cards</a>

            @endif
        </div>
    @endif



    @if(\Session::get('session_restaurant_id'))
        <p></p>
        <h5>Restro Navigation</h5>
        <div class="list-group">

            <a href="{{ url('restaurant/orders/list') }}"
               class="list-group-item <?php if (Request::path() == 'restaurant/orders/list') {
                   echo 'active';
               } ?>"><i class="fa fa-angle-right"></i> My Orders</a>

            <a href="{{ url('restaurants/' . select_field('restaurants', 'id', \Session::get('session_restaurant_id'), 'slug') . '/menus') }}"
               class="list-group-item <?php if (Request::path() == url('restaurants/' . select_field('restaurants', 'id', \Session::get('session_restaurant_id'), 'slug') . '/menus')) {
                   echo 'active';
               } ?>"><i class="fa fa-angle-right"></i> My Menu </a>

            <a href="{{ url('restaurant/addresses') }}"
               class="list-group-item <?php if (Request::path() == 'restaurant/addresses') {
                   echo 'active';
               } ?>"><i class="fa fa-angle-right"></i> Notification Addresses</a>

            <a href="{{ url('restaurant/info') }}"
               class="list-group-item <?php if (Request::path() == 'restaurant/info') {
                   echo 'active';
               } ?>"><i class="fa fa-angle-right"></i> Restaurant Info</a>

            @if(\Session::has('session_profiletype') && \Session::get('session_profiletype') != 1)

                <a href="{{ url('users/credit-cards') }}"
                   class="list-group-item <?php if (Request::path() == 'users/credit-cards/restaurant') {
                       echo 'active';
                   } ?>"><i class="fa fa-angle-right"></i> Credit Cards</a>

            @endif
        </div>
    @endif


</div>