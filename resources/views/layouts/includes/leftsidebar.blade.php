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
                echo '"><i class="fa fa-angle-right pull-right" style="margin-top: .3em;"></i> ' . $Name . '</a>';
            }
        }


    if(\Session::get('session_restaurant_id')){
        makelink(array( 'orders/list/restaurant' => 'Restaurant Orders',
                'restaurants/' . select_field('restaurants', 'id', \Session::get('session_restaurant_id'), 'slug') . '/menus' => "Restaurant Menu",
                'notification/addresses' => "Notification Addresses",
                'restaurant/info' => "Restaurant Info",
                'credit-cards/list/restaurant' => "Credit Card" //if(\Session::has('session_profiletype') )
        ), "<i class='fa fa-cutlery' style='color:#d9534f !important;margin-right:.3em;'></i> Restaurant Navigation");
    }



    makelink(array( 'orders/list/user' => 'My Orders',
                        'user/addresses' => "My Home Address",
                        'user/info' => "My Personal Profile"
                    ), "<i class='fa fa-user' style='color:#d9534f !important;margin-right:.3em;'></i> User Navigation");

        if(check_permission("can_edit_global_settings")){
            makelink(array( 'orders/list/admin' => 'All Orders',
                            'users/list' => "All Users",
                            'restaurant/list' => "All Restaurants",
                            'subscribers/list' => "All Subscribers",
                            'eventlogs/list' => "Event Log",
                            'user/reviews' => "User Reviews"
                            //'cards/list/restaurant' => "All Credit Cards"//if(\Session::has('session_profiletype')  && \Session::get('session_profiletype') == 1)
            ), "<i class='fa fa-users' style='color:#d9534f !important;margin-right:.3em;'></i> Admin Navigation");
        }
    ?>
</div>