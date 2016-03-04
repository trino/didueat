<div class="page-sidebar" aria-expanded="true">
    <ul class="page-sidebar-menu page-sidebar-menu-hover-submenu" style="margin-bottom:0px !important">
        <?php
        printfile("views/dashboard/layouts/leftsidebar.blade.php");

        if (Session::get('session_type_user') == "super") {
            if (true) {
                makelink(array('orders/list/admin' => 'All Orders',
                        'users/list' => "All Users",
                        'restaurant/list' => "All Restaurants",
                        'subscribers/list' => "All Subscribers",
                        'user/reviews' => "User Reviews",
                        'eventlogs/list' => "Event Log"
                ), "Admin");
            }
        }
  
        if (trim(\Session::get('session_restaurant_id'))) {
            makelink(array('orders/list/restaurant' => 'Restaurant Orders',
                    'restaurants/' . select_field('restaurants', 'id', \Session::get('session_restaurant_id'), 'slug') . '/menu' => "Restaurant Menu",
                    'notification/addresses' => "Order Notifications",
                    'restaurant/info' => "Restaurant Details"
                //,'credit-cards/list/restaurant' => "Credit Card"
            ), "My Restaurant");
        }

        if (!\Session::get('session_restaurant_id') || Session::get('session_type_user') == "super") {
            makelink(array(
                    'orders/list/user' => 'My Orders',
                    'user/info' => "My Settings",
                    'user/addresses' => "Delivery Address",
                /*
                    'credit-cards/list/user' => "My Credit Cards",
                */
                    'auth/logout' => "Log out"
            ), "My Profile");
        } else {
            makelink(array('user/info' => "My Settings",
                    'auth/logout' => "Log out"
            ), "My Profile");
        }
        ?>
    </UL>
</div>