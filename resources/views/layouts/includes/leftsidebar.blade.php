<div class="col-lg-3">
    <div class="page-sidebar navbar-collapse collapse in" aria-expanded="true">
        <ul id="mainbar" class="page-sidebar-menu page-sidebar-menu-hover-submenu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <?php
                printfile("views/dashboard/layouts/leftsidebar.blade.php");
                function makelink($URL, $Name){
                    if(is_array($URL)){
                        echo '<li><div class="card"><div class="card-header title"><h4 class="card-title"><i class="fa fa-cutlery" style="color:#0275d8 !important;margin-right:.3em;"></i> ' . $Name . '</h4>';
                        echo '</div><div class="card-block p-a-0"><div class="list-group-flush">';
                        $Name = str_replace(" ", "_", strtolower($Name)) . "_menu";
                        echo '<ul class="sub-menu" id="' . $Name . '">';
                        foreach($URL as $URL2 => $Name){
                            makelink($URL2, $Name);
                        }
                        echo '</UL>';
                        echo '</div></div></div>';
                        echo '</li>';
                    } else {
                        echo '<LI><a href="' . url($URL) . '" class="list-group-item';
                        if (Request::path() == $URL) {echo ' active';}
                        echo '"><i class="fa fa-angle-right pull-right" style="margin-top: .3em;"></i> ' . $Name . '</a></LI>';
                    }
                }

                if (Session::get('session_type_user') == "super"){
                    makelink(array( 'orders/list/admin' => 'All Orders',
                            'users/list' => "All Users",
                            'restaurant/list' => "All Restaurants",
                            'subscribers/list' => "All Subscribers",
                            'user/reviews' => "User Reviews",
                            'eventlogs/list' => "Event Log"
                    ), "Admin");
                }

                if(\Session::get('session_restaurant_id')){
                    makelink(array( 'orders/list/restaurant' => 'Restaurant Orders',
                            'restaurants/' . select_field('restaurants', 'id', \Session::get('session_restaurant_id'), 'slug') . '/menus' => "Restaurant Menu",

                            'notification/addresses' => "Notification Addresses",
                            'restaurant/info' => "Restaurant Info"
                            //,'credit-cards/list/restaurant' => "Credit Card"
                    ), "My Restaurant");
                }

                makelink(array( 'orders/list/user' => 'My Orders',
                                    'user/addresses' => "My Addresses",
                                    'user/info' => "My Profile",
                                    'credit-cards/list/user' => "Credit Card",
                        'auth/logout' => "Log out"
                ), "My Profile");

            ?>
        </UL>
    </div>
</div>
<SCRIPT>
    was_small = false;

    $("#expand-header").show();

    $( window ).resize(function() {
        resize();
    });
    $( document ).ready(function() {
        resize();
    });

    function resize(){
        var width = $(window).width();
        var is_small = width <= 970;

        console.log("Handler for .resize(" + width + ") called");
        if (is_small != was_small){
            width = $(".navbar-collapse").height();
            if( (is_small && width) || (!is_small && !width)) {
                $(".menu-toggler").trigger("click");
            }
        }
        was_small = is_small;
    }
</SCRIPT>