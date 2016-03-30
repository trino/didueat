<?php
    //handles the popup for showing everything required to open a store
    $RestaurantID=$Restaurant; // copy ID before the variable changes
    $Restaurant = select_field("restaurants", "id", $Restaurant);
    $post = \Input::all(); // testing for intial setup
    
    if ($Restaurant) {
        $MissingData = array();
        $MissingDataOptional = array();
        
        if (!$Restaurant->is_delivery && !$Restaurant->is_pickup) {
            $MissingData[] = "<a href=\"" . url('restaurant/info') . "#PickupAndDelivery\">Pickup and/or delivery options</a>";
        }

        /* dont need logo
        if (!$Restaurant->logo) {
            $MissingData[] = "Your Restaurant Logo <a href=\"" . url('restaurant/info') . "#setlogo\">(<u>Set Restaurant Logo</u>)</a>";
        }
*/
        if (!$Restaurant->description) {
            //$MissingData[] = "Your Restaurant Description <a href=\"" . url('restaurant/info') . "#setlogo\">(<u>Set Restaurant Description</u>)</a>";
        }

        if (!$Restaurant->latitude || !$Restaurant->longitude) {
            $MissingData[] = "<a href=\"" . url('restaurant/info') . "#RestaurantAddress\">Restaurant address</a>";
        }

        if ($Restaurant->max_delivery_distance < 2 && $Restaurant->is_delivery) {
            $MissingDataOptional[] = "<a href=\"" . url('restaurant/info') . "#HoursOpen\">[OPTIONAL] Delivery area</a>";
        }
        if ((!$Restaurant->minimum || $Restaurant->minimum == "0.00") && $Restaurant->is_delivery) {
            $MissingDataOptional[] = "<a href=\"" . url('restaurant/info') . "#HoursOpen\">[OPTIONAL] Minimum delivery sub-total</a>";
        }

        //check hours of operation
        $weekdays = getweekdays();
        $doesopen = false;
        $someHoursNotOK = false; // to encourage restaurant to finish setting up hours
        foreach ($weekdays as $weekday) {
            if(getfield($Restaurant, $weekday . "_open") != getfield($Restaurant, $weekday . "_close")) {
                foreach (array("_open", "_open_del", "_close", "_close_del") as $field) {
                    $field = $weekday . $field;
                    if ($Restaurant->$field != "00:00:00") {
                        $doesopen = true;
                    } //else {
                    //  $someHoursNotOK = true;
                    //}
                }
            }
        }

        if (!$doesopen) {
            $MissingData[] = " <a href=\"" . url('restaurant/info') . "#HoursOpen\">Hours of operation</a>";
        } elseif ($someHoursNotOK) {
            $MissingData[] = "<a href=\"" . url('restaurant/info') . "#HoursOpen\">Hours open needs completing</a>";
        }

        /*check credit card
        $creditcards = select_field_where("credit_cards", array("user_type" => "restaurant", "user_id" => $Restaurant->id), "COUNT()");
        if (!$creditcards) {
            $MissingData[] = "Your credit card authorization <a href=\"" . url('credit-cards/list/restaurant') . "\">(<u>Set Credit Card</u>)</a>";
        }
        */

        $MenuTst = select_field("menus", array("restaurant_id","is_active"), array($RestaurantID,1),"menu_item");
        if (!isset($MenuTst)) {
            $MissingData[] = "<a href=\"" . url('restaurants/'.$Restaurant->slug.'/menu') . "\">At least one menu item must be added and enabled</a>";
        }

        if ($MissingData) {
            $missingHeadInitialReg="";
            $missingHead="";
            if (isset($post['initialRestSignup'])) {
                $missingHeadInitialReg = '<h4>PARTIAL REGISTRATION COMPLETED!</h4>';
            }

            if (Session::get('session_type_user') == "restaurant") {
                $missingHead = $missingHeadInitialReg."<h4>Hi ".explode(' ', Session::get('session_name'))[0].", complete the following to start accepting orders:</h4>";
            }

            $MissingData = array_merge($MissingData, $MissingDataOptional);
            $MissingData = "<div>&bull; " . implode("<br/>&bull; ", $MissingData) . "</div>";
        } else if(Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\RestaurantController@restaurantInfo@index') {
            $missingHead =  '';
            $business_day = \App\Http\Models\Restaurants::getbusinessday($Restaurant);
            $MissingData= "Hi ".explode(' ', Session::get('session_name'))[0].", You're Currently " . iif($business_day, "Open", "Closed") . " & " . iif(!$Restaurant->open, "Not ") . "Accepting Orders ";
            if(!$Restaurant->open){
                $MissingData .= '<A HREF="' . url("restaurant/bringonline") . '">Start Accepting Orders</A>';
            }
        }
        if(isset($missingHead)) {
            echo '<div class="alert alert-warning " style="margin-bottom: 0px !important;"><div class="container" style="margin-top:0rem !important;"><div class="row">';
            printfile("views/common/required_to_open.php");
            echo '<div class="col-md-12 text-md-center"><div ID="invalid-data">' . $missingHead . $MissingData . '</DIV></div></div></div></div>';
        }
    }