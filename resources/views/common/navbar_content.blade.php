<div class="page-sidebar" aria-expanded="true">
    <ul class="page-sidebar-menu page-sidebar-menu-hover-submenu" style="margin-bottom:0px !important">
        <?php
        printfile("views/common/navbar_content.blade.php");
        if(!function_exists("makelink")){
            function makelink($URL, $Name) {
                if (is_array($URL)) {
                    echo '<li><div class="card "><div class="card-header title"><h4 class="card-title">';
                    $FontAwesome = '<i class="fa fa-cutlery" style="color:#0275d8 !important;margin-right:.3em;"></i> ';
                    if($Name == "My Profile"){
                        $FontAwesome = '<i class="fa fa-user" style="color:#0275d8 !important;margin-right:.3em;"></i> ';
/*
                        $filename = 'assets/images/users/' . read("id") . "/icon-" . read('photo');
                        if (Session::has('session_photo') && file_exists(public_path($filename))) {
                            $FontAwesome = false;
                            echo '<IMG SRC="' . asset($filename) . '" STYLE="height: 16px;width:16px;"> ';
                        }
*/
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
                    if($URL=="notification/addresses"){$Name="Notification Methods";}
                    echo '"><i class="fa fa-angle-right pull-right" style="margin-top: .3em;"></i> ' . $Name . '</a></LI>';
                }
            }
        }

        if (Session::get('session_type_user') == "super") {
            makelink(array('orders/list/admin' => 'Orders',
                    'users/list' => "Users",
                    'restaurant/list' => "Restaurants",
                    'subscribers/list' => "Subscribers",
                    'user/reviews' => "Reviews",
                    'eventlogs/list' => "Event Log",
                    'home/debug' => "Debug Log"
            ), "Admin");
        }
  
        if (trim(\Session::get('session_restaurant_id'))) {
            $Pending_orders = select_field_where("reservations", array("restaurant_id" => \Session::get('session_restaurant_id'), "status" => "pending"), "COUNT()");
            if(!$Pending_orders){$Pending_orders=0;}
            makelink(array('restaurant/info' => "Settings",
                    'orders/list/restaurant' => 'Orders (' . $Pending_orders . iif($Pending_orders, '<i class="fa fa-exclamation-triangle" style="color: red;"></i>') . ')',
                    'restaurants/' . select_field('restaurants', 'id', \Session::get('session_restaurant_id'), 'slug') . '/menu' => "Your Menu",
                    'notification/addresses' => "Notification methods"
                    //,'credit-cards/list/restaurant' => "Credit Card"
            ), "My Restaurant");
        } else if(read("profiletype") == 3){
            makelink(array(
                    'restaurant/list' => "Restaurants",
            ), "Restaurants");
        }

        $data = array('user/info' => "Settings");
        if (!\Session::get('session_restaurant_id') || Session::get('session_type_user') == "super") {
            $data["orders/list/user"] = "Orders";
            $data["user/addresses"] = "Delivery Address";
        }
        $data["auth/logout"] = "Log out";
        if (read("oldid")){
            $data['restaurant/users/action/user_depossess/' . read("oldid")] = "De-Possess";
        }
        makelink($data, "My Profile");

        ?>
    </UL>
</div>