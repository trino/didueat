<div class="page-sidebar" aria-expanded="true">
    <ul class="page-sidebar-menu page-sidebar-menu-hover-submenu" style="margin-bottom:0px !important">
        <?php
        printfile("views/dashboard/layouts/leftsidebar.blade.php");
        if(!function_exists("makelink")){
            function makelink($URL, $Name) {
                if (is_array($URL)) {
                    echo '<li><div class="card "><div class="card-header title"><h4 class="card-title">';
                    $FontAwesome = '<i class="fa fa-cutlery" style="color:#0275d8 !important;margin-right:.3em;"></i> ';
                    if($Name == "My Profile" && read("photo")){
                        $filename = 'assets/images/users/' . read("id") . "/icon-" . read('photo');
                        if (Session::has('session_photo') && file_exists(public_path($filename))) {
                            $FontAwesome = false;
                            echo '<IMG SRC="' . asset($filename) . '" STYLE="height: 16px;width:16px;"> ';
                        }
                    }
                    echo $FontAwesome . $Name . '</h4></div><div class="card-block p-a-0"><div class="list-group-flush">';
                    $Name = str_replace(" ", "_", strtolower($Name)) . "_menu";
                    echo '<ul class="sub-menu " id="' . $Name . '">';
                    foreach ($URL as $URL2 => $Name) {
                        makelink($URL2, $Name);
                    }
                    echo '</UL>';
                    echo '</div></div></div>';
                    echo '</li>';
                } else {
                    echo '<LI><a href="' . url($URL) . '" class="list-group-item';
                    if (Request::path() == $URL) {
                        echo ' active';
                    }
                    echo '"><i class="fa fa-angle-right pull-right" style="margin-top: .3em;"></i> ' . $Name . '</a></LI>';
                }
            }
        }

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