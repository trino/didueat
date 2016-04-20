<style>
    .page-sidebar .list-group-item {
        padding-top: .25rem !important;
        padding-bottom: .25rem !important;
    }
</style>

<div class="page-sidebar" aria-expanded="true">
    <ul class="page-sidebar-menu page-sidebar-menu-hover-submenu" style="margin-bottom:0px !important">
        <?php
            printfile("views/common/navbar_content.blade.php");

            if (!function_exists("makelink")) {
                function makelink($URL, $Name) {
                    if (is_array($URL)) {
                        echo '<li><div class="card "><div class="card-header title"><h4 class="card-title">';
                        $FontAwesome = '<i class="fa fa-cutlery" style="color:#0275d8 !important;margin-right:.3em;"></i> ';
                        if ($Name == "My Profile") {
                            $FontAwesome = '<i class="fa fa-user" style="color:#0275d8 !important;margin-right:.3em;"></i> ';
                        }
                        echo $FontAwesome . $Name . '</h4></div><div class="card-block" style="padding:0 !important;"><div class="list-group-flush">';
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
                        if ($URL == "notification/addresses") {
                            $Name = "Notifications";
                        }
                        echo '"><i class="fa fa-angle-right pull-right" style="margin-top: .3em;"></i> ' . $Name . '</a></LI>';
                    }
                }
            }




            if (Session::get('session_type_user') == "super") {
                makelink(array('orders/list/admin' => 'Orders',
                        'users/list' => "Users",
                        'restaurant/list' => "Restaurants",
                       /* 'subscribers/list' => "Subscribers", */
                        'user/reviews' => "Reviews",
                        'eventlogs/list' => "Event Log",
                        'home/debug' => "Debug Log"
                ), "Admin");
            }

            if (trim(\Session::get('session_restaurant_id'))) {
                $Pending_orders = select_field_where("reservations", array("restaurant_id" => \Session::get('session_restaurant_id'), "status" => "pending"), "COUNT()");
                if (!$Pending_orders) {
                    $Pending_orders = 0;
                }
                makelink(array(
                        'orders/list/restaurant' => 'Orders (' . $Pending_orders . iif($Pending_orders, '<i class="fa fa-exclamation-triangle" style="color: red;"></i>') . ')',
                        'restaurants/' . select_field('restaurants', 'id', \Session::get('session_restaurant_id'), 'slug') . '/menu' => "My Menu",
                        'notification/addresses' => "Notification methods", 'restaurant/info' => "Settings",
                ), "My Restaurant");
            }

            /*else {//if(read("profiletype") == 3){
                makelink(array(
                        'restaurant/list' => "Restaurants",
                ), "Restaurants");
            }*/

            $profiletype = Session::get('session_profiletype');
            $data = array();
            if (!\Session::get('session_restaurant_id') || $profiletype == 1) {
                $data["orders/list/user"] = "Orders";
                $data["user/addresses"] = "Address";
                $data['user/reviews'] = "Reviews";
                //    $data["credit-cards/list/user"] = "Credit Card";
                if ($profiletype == 1 || $profiletype == 3) {
                    $data["user/uploads"] = "Uploads";
                }

            }
            $data["user/info"] = "Settings";
            $data["auth/logout"] = "Log out";

            if (read("oldid")) {
                $data['restaurant/users/action/user_depossess/' . read("oldid")] = "De-Possess";
            }

            makelink($data, "My Profile");
        ?>
    </UL>
</div>