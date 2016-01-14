<div class=" col-lg-3">
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
                echo '"><i class="fa fa-angle-right"></i> ' . $Name . '</a>';
            }
        }

        makelink(array( 'orders/list/user' => 'My Orders',
                        'user/addresses' => "My Addresses",
                        'user/info' => "My Profile"
                    ), "User Navigation");

        if(\Session::get('session_restaurant_id')){
            makelink(array( 'orders/list/restaurant' => 'My Orders',
                            'restaurants/' . select_field('restaurants', 'id', \Session::get('session_restaurant_id'), 'slug') . '/menus' => "My Menu",
                            'notification/addresses' => "My Notification Addresses",
                            'restaurant/info' => "My Restaurant",
                            'credit-cards/list/restaurant' => "My Credit Cards" //if(\Session::has('session_profiletype') )
            ), "Restaurant Navigation");
        }

        if(check_permission("can_edit_global_settings")){
            makelink(array( 'orders/list/admin' => 'All Orders',
                            'users/list' => "All Users",
                            'restaurant/list' => "All Restaurants",
                            'subscribers/list' => "All Subscribers",
                            'eventlogs/list' => "Event Log",
                            'user/reviews' => "User Reviews"
                            //'cards/list/restaurant' => "All Credit Cards"//if(\Session::has('session_profiletype')  && \Session::get('session_profiletype') == 1)
            ), "Admin Navigation");
        }
    ?>
</div>