<?php
    /**
     * Created by PhpStorm.
     * User: Van
     * Date: 2/1/2016
     * Time: 8:30 PM
     */

    $Restaurant = select_field("restaurants", "id", $Restaurant);
    if ($Restaurant) {
        $MissingData = [];
        $MissingDataOptional = [];
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
        if (!$Restaurant->minimum || $Restaurant->minimum == "0.00") {
            $MissingDataOptional[] = "Minimum delivery sub-total <a href=\"" . url('restaurant/info') . "#HoursOpen\">(<u>Click to Set Delivery Minimum</u>)</a>";
        }

        //check hours of operation
        $weekdays = getweekdays();
        $someHoursNotOK = false; // to encourage restaurant to finish setting up hours
        $DayOfWeek = current_day_of_week();
        $now = date('H:i:s');
        foreach ($weekdays as $weekday) {
            foreach (array("_close", "_close_del") as $field) { // only the close needs to be checked, as 12:00 is often an opening time
                $field = $weekday . $field;
                if ($Restaurant->$field != "12:00:00") {
                    $weekdays = false;
                } else {
                    $someHoursNotOK = true;
                }
            }

        }
        if ($weekdays) {
            $MissingData[] = "Hours of operation <a href=\"" . url('restaurant/info') . "#HoursOpen\">(<u>Click to Set Hours of Operation</u>)</a>";
        } elseif ($someHoursNotOK) {
            $MissingData[] = "Hours Open Needs Completing <a href=\"" . url('restaurant/info') . "#HoursOpen\">(<u>Click to Complete Hours Open</u>)</a>";

            /*  What is the point of this?
                  if (getfield($Restaurant, $DayOfWeek . "_open") > $now || getfield($Restaurant, $DayOfWeek . "_close") < $now) {
                        $MissingData[] = "Hours Open <a href=\"" . url('restaurant/info') . "#HoursOpen\">(<u>Click to Set Hours Open</u>)</a>";
                    }
                    if ($Restaurant->is_delivery && (getfield($Restaurant, $DayOfWeek . "_open_del") > $now || getfield($Restaurant, $DayOfWeek . "_close_del") < $now)) {
                        $MissingData[] = "Delivery Times <a href=\"" . url('restaurant/info') . "#DeliveryTimes\">(<u>Click to Set Delivery Times</u>)</a>";
                    }
            */

        }

        //check credit card
        $creditcards = select_field_where("credit_cards", array("user_type" => "restaurant", "user_id" => $Restaurant->id), "COUNT()");
        if (!$creditcards) {
            $MissingData[] = "Your credit card authorization <a href=\"" . url('credit-cards/list/restaurant') . "\">(<u>Click to Set Credit Card</u>)</a>";
        }

        if ($MissingData) {
            if (isset($post['initialRestSignup'])) {
                $missingHead = "PARTIAL REGISTRATION COMPLETED!";
            } else {
                $missingHead = "PLEASE COMPLETE THE FOLLOWING IN ORDER TO START ACCEPTING ORDERS";
            }
            $MissingData = array_merge($MissingData, $MissingDataOptional);

            $MissingData = "<br/>Please click the links below, and/or use the Restaurant Navigation links on the left side below, to finish setting up your restaurant with the following: <div style=''>&bull; " . implode("<br/>&bull; ", $MissingData) . "</div>";
            echo '<div class="alert alert-danger" ID="invalid-data"><STRONG><u>' . $missingHead . '</u></STRONG>' . $MissingData . '</DIV>';
        }
    }


