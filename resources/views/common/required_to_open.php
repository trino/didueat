<?php
    $RestaurantID=$Restaurant; // copy ID before it variable changes
    $Restaurant = select_field("restaurants", "id", $Restaurant);

    $MenuTst = select_field("menus", array("restaurant_id","is_active"), array($RestaurantID,1),"menu_item");

    $post = \Input::all(); // testing for intial setup
    
    if ($Restaurant) {
        $MissingData = [];
        $MissingDataOptional = [];
        
        if (!isset($MenuTst)) {
            $MissingData[] = "At least one menu item must be added, and <u>Enabled</u> <a href=\"" . url('restaurants/'.$Restaurant->slug.'/menus') . "\">(<u>Add Menu Items</u>)</a>";
        }        
        
        if (!$Restaurant->is_delivery && !$Restaurant->is_pickup) {
            $MissingData[] = "Pickup and/or Delivery options <a href=\"" . url('restaurant/info') . "#PickupAndDelivery\">(<u>Set Pickup/Delivery Options</u>)</a>";
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
            $MissingData[] = "Restaurant address <a href=\"" . url('restaurant/info') . "#RestaurantAddress\">(<u>Set Restaurant Address</u>)</a>";
        }

        if ($Restaurant->max_delivery_distance < 2 && $Restaurant->is_delivery) {
            $MissingDataOptional[] = "Delivery range <a href=\"" . url('restaurant/info') . "#HoursOpen\">(<u>Set Delivery Range</u>)</a>";
        }
        if ((!$Restaurant->minimum || $Restaurant->minimum == "0.00") && $Restaurant->is_delivery) {
            $MissingDataOptional[] = "Minimum delivery sub-total <a href=\"" . url('restaurant/info') . "#HoursOpen\">(<u>Set Delivery Minimum</u>)</a>";
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
            $MissingData[] = "Hours of operation <a href=\"" . url('restaurant/info') . "#HoursOpen\">(<u>Set Hours of Operation</u>)</a>";
        } elseif ($someHoursNotOK) {
            $MissingData[] = "Hours Open Needs Completing <a href=\"" . url('restaurant/info') . "#HoursOpen\">(<u>Complete Hours Open</u>)</a>";
        }

        /*check credit card
        $creditcards = select_field_where("credit_cards", array("user_type" => "restaurant", "user_id" => $Restaurant->id), "COUNT()");
        if (!$creditcards) {
            $MissingData[] = "Your credit card authorization <a href=\"" . url('credit-cards/list/restaurant') . "\">(<u>Set Credit Card</u>)</a>";
        }
        */

        if ($MissingData) {
            

            ?>

            <div class="alert alert-danger " style="margin-bottom: 0px !important;">
                <div class="container" style="padding-top:0rem !important;">
                    <div class="row" style="">

<?
            printfile("views/common/required_to_open.php");

            $missingHeadInitialReg="";
            if (isset($post['initialRestSignup'])) {
                $missingHeadInitialReg = '<span style="font-size:20px">PARTIAL REGISTRATION COMPLETED!</span> &nbsp;';
            } 
              
            $missingHead = $missingHeadInitialReg."<h5>COMPLETE THE FOLLOWING TO START ACCEPTING ORDERS</h5>";

            $MissingData = array_merge($MissingData, $MissingDataOptional);

            $MissingData = "<div>&bull; " . implode("<br/>&bull; ", $MissingData) . "</div>";
            echo '<div class="col-md-12"><div ID="invalid-data">' . $missingHead . '' . $MissingData . '</DIV></div>';


            ?>

                        </div>
                        </div>
                        </div>
                        <?
        }
    }


