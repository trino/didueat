<div class="col-lg-3">

    <?php
        printfile("views/dashboard/layouts/leftsidebar.blade.php");
        function makelink($URL, $Name){
            if(is_array($URL)){
                echo '<div class="card"><div class="card-header">' . $Name. '</div><div class="card-block p-a-0"><div class="list-group-flush">';
                foreach($URL as $URL2 => $Name){
                    makelink($URL2, $Name);
                }
                echo '</div></div></div>';
            } else {
                echo '<a href="' . url($URL) . '" class="list-group-item';
                if (Request::path() == $URL) {echo ' active';}
                echo '"><i class="fa fa-angle-right pull-right" style="margin-top: .3em;"></i> ' . $Name . '</a>';
            }
        }


    if (Session::get('session_type_user') == "super"){
        makelink(array( 'orders/list/admin' => 'All Orders',
                'users/list' => "All Users",
                'restaurant/list' => "All Restaurants",
                'subscribers/list' => "All Subscribers",
                'user/reviews' => "User Reviews",
                'eventlogs/list' => "Event Log"

        ), "<h4 class='card-title'><i class='fa fa-users' style='color:#0275d8 !important;margin-right:.3em;'></i> Admin</h4>");
    }

    if(\Session::get('session_restaurant_id')){
        makelink(array( 'orders/list/restaurant' => 'Restaurant Orders',
                'restaurants/' . select_field('restaurants', 'id', \Session::get('session_restaurant_id'), 'slug') . '/menus' => "Restaurant Menu",

                'notification/addresses' => "Notification Addresses",
                'restaurant/info' => "Restaurant Info",
                'credit-cards/list/restaurant' => "Credit Card"
        ), "<h4 class='card-title'><i class='fa fa-cutlery' style='color:#0275d8 !important;margin-right:.3em;'></i> My Restaurant</h4>");
    }

    makelink(array( 'orders/list/user' => 'My Orders',
                        'user/addresses' => "My Addresses",
                        'user/info' => "My Profile",
                        'credit-cards/list/user' => "Credit Card",
            'auth/logout' => "Log out"
    ), "<h4 class='card-title'><i class='fa fa-user' style='color:#0275d8 !important;margin-right:.3em;'></i> My Profile</h4>");


    ?>
</div>
