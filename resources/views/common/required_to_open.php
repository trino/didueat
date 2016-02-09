<?php
    $RestaurantID=$Restaurant; // copy ID before it variable changes
    $Restaurant = select_field("restaurants", "id", $Restaurant);

    $MenuTst = select_field("menus", array("restaurant_id","is_active"), array($RestaurantID,1),"menu_item");

    $post = \Input::all(); // testing for intial setup
    
    if ($Restaurant) {
        $MissingData = [];
        $MissingDataOptional = [];
        
        if (!isset($MenuTst)) {
            $MissingData[] = "At least one menu item must be added, and <u>Enabled</u> <a href=\"" . url('restaurants/'.$Restaurant->slug.'/menus') . "\">(<u>Click to Add Menu Items</u>)</a>";
        }        
        
        if (!$Restaurant->is_delivery && !$Restaurant->is_pickup) {
            $MissingData[] = "Pickup and/or Delivery options <a href=\"" . url('restaurant/info') . "#PickupAndDelivery\">(<u>Click to Set Delivery Options</u>)</a>";
        }
        /* dont need logo
        if (!$Restaurant->logo) {
            $MissingData[] = "Your Restaurant Logo <a href=\"" . url('restaurant/info') . "#setlogo\">(<u>Click to Set Restaurant Logo</u>)</a>";
        }
*/
        if (!$Restaurant->description) {
            $MissingData[] = "Your Restaurant Description <a href=\"" . url('restaurant/info') . "#setlogo\">(<u>Click to Set Restaurant Description</u>)</a>";
        }

        if (!$Restaurant->latitude || !$Restaurant->longitude) {
            $MissingData[] = "Restaurant address <a href=\"" . url('restaurant/info') . "#RestaurantAddress\">(<u>Click to Set Restaurant Address</u>)</a>";
        }

        if ($Restaurant->max_delivery_distance < 2 && $Restaurant->is_delivery) {
            $MissingDataOptional[] = "Delivery range <a href=\"" . url('restaurant/info') . "#HoursOpen\">(<u>Click to Set Delivery Range</u>)</a>";
        }
        if ((!$Restaurant->minimum || $Restaurant->minimum == "0.00") && $Restaurant->is_delivery) {
            $MissingDataOptional[] = "Minimum delivery sub-total <a href=\"" . url('restaurant/info') . "#HoursOpen\">(<u>Click to Set Delivery Minimum</u>)</a>";
        }

        //check hours of operation
        $weekdays = getweekdays();
        $doesopen = false;
        $someHoursNotOK = false; // to encourage restaurant to finish setting up hours
        foreach ($weekdays as $weekday) {
            foreach (array("_open", "_open_del", "_close", "_close_del") as $field) {
                $field = $weekday . $field;
                if ($Restaurant->$field != "00:00:00") {
                    $doesopen = true;
                } //else {
                  //  $someHoursNotOK = true;
                //}
            }
        }

        if (!$doesopen) {
            $MissingData[] = "Hours of operation <a href=\"" . url('restaurant/info') . "#HoursOpen\">(<u>Click to Set Hours of Operation</u>)</a>";
        } elseif ($someHoursNotOK) {
            $MissingData[] = "Hours Open Needs Completing <a href=\"" . url('restaurant/info') . "#HoursOpen\">(<u>Click to Complete Hours Open</u>)</a>";
        }

        //check credit card
        $creditcards = select_field_where("credit_cards", array("user_type" => "restaurant", "user_id" => $Restaurant->id), "COUNT()");
        if (!$creditcards) {
            $MissingData[] = "Your credit card authorization <a href=\"" . url('credit-cards/list/restaurant') . "\">(<u>Click to Set Credit Card</u>)</a>";
        }

        if ($MissingData) {
            printfile("views/common/required_to_open.php");

            $missingHeadInitialReg="";
            if (isset($post['initialRestSignup'])) {
                $missingHeadInitialReg = '<span style="font-size:20px">PARTIAL REGISTRATION COMPLETED!</span> &nbsp;';
            } 
              
            $missingHead = $missingHeadInitialReg."PLEASE COMPLETE THE FOLLOWING IN ORDER TO START ACCEPTING ORDERS";

            $MissingData = array_merge($MissingData, $MissingDataOptional);

            $MissingData = "<br/>Please click the links below, and/or use the Restaurant Navigation links on the left side below, to finish setting up your restaurant with the following: <div>&bull; " . implode("<br/>&bull; ", $MissingData) . "</div>";
            echo '<div class="alert alert-danger" ID="invalid-data"><STRONG><u>' . $missingHead . '</u></STRONG>' . $MissingData . '</DIV>';
        }
    }


