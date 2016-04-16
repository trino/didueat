<?php

    $provinces = array(
            "ON" => "Ontario",
            "QC" => "Quebec",
            "NS" => "Nova Scotia",
            "NB" => "New Brunswick",
            "MB" => "Manitoba",
            "BC" => "British Columbia",
            "PE" => "Prince Edward Island",
            "SK" => "Saskatchewan",
            "AB" => "Alberta",
            "NL" => "Newfoundland and Labrador",
            "NT" => "Northwest Territories",
            "YT" => "Yukon",
            "NU" => "Nunavut"
    );

    $now = now();
    $getimages = false;//set to true to download images for the restaurant, done during second refresh though
    $cities = true;//array("hamilton", "burlington");//use an array of lower-cased cities to filter, or true to get them all
    $times = array();//default values to merge into the restaurant
    foreach(getweekdays() as $weekday){
        $times[$weekday . "_open"] = "10:00:00";
        $times[$weekday . "_open_del"] = "10:00:00";
        $times[$weekday . "_close"] = "22:00:00";
        $times[$weekday . "_close_del"] = "22:00:00";
    }
    $times["is_complete"] = 1;
    $times["is_delivery"] = 1;
    $times["delivery_fee"] = 5;
    $times["is_pickup"] = 1;
    $times["province"] = 1;
    $times["is_pickup"] = 1;
    $times["minimum"] = 10;
    $times["province"] = 'Ontario';
    $times["country"] = 'Canada';
    $times["uploaded_by"] = read("id");

    $handle = fopen( public_path("assets/restaurants.ini") , "r");
    $restaurant = array();
    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            // process the line read.
            $line=trim($line);
            if ( left($line,1) == "[" && right($line,1) == "]" ){
                processrestaurant($restaurant, $times, $now, $getimages);
                $restaurant = array();
            } else {
                $equal = strpos($line, "=");
                if( $equal ) {
                    $key = left($line, $equal);
                    $value = right($line, strlen($line) - $equal - 1);
                    $restaurant[$key] = $value;
                }
            }
            //break;
        }
        fclose($handle);
        processrestaurant($restaurant, $times, $now, $getimages);
    } else {
        echo "error opening the file.";
    }

function processrestaurant($restaurant, $times, $now, $getimages){
    if(!$restaurant){return false;}

    foreach(array("address" => "street", "postal_code" => "postalcode", "phone" => "telephone") as $dest => $src){
        if(isset($restaurant[$src])){
            $restaurant[$dest] = $restaurant[$src];
            unset($restaurant[$src]);
        }
    }

    if(isset($restaurant["coordinates"])){
        $coordinates = explode(",", $restaurant["coordinates"]);
        if(count($coordinates) == 2){
            $restaurant["latitude"] = $coordinates[0];
            $restaurant["longitude"] = $coordinates[1];
            unset($restaurant["coordinates"]);
        } else {
            var_dump($coordinates);
        }
    }
    if(isset($restaurant["phone"])){
        $restaurant["phone"] = str_replace("-", "", $restaurant["phone"]);
    }

    foreach(array("address", "phone", "city", "province", "postal_code", "id") as $key){
        if(!isset($restaurant[$key]) || !$restaurant[$key]){
            echo "MISSING DATA: " . $key;
            var_dump($restaurant);return false;
        }
    }

    $restaurant["formatted_address"] = implode(", ", array($restaurant["address"], $restaurant["city"], $restaurant["province"], $restaurant["postal_code"], "Canada"));
    $restaurant["email"] = "roy+" . $restaurant["id"] . "@trinoweb.com";
    $restaurant["slug"] = app('App\Http\Controllers\RestaurantController')->createslug( $restaurant["name"] );

    if($restaurant["id"] == "3439905"){
        //var_dump($restaurant);die();
    }

    unset($restaurant["id"]);
    $ob = select_field("restaurants", "email", $restaurant["email"]);
    if($ob){
        $repair = array();
        if(!$ob->slug){$repair["slug"] = $restaurant["slug"];}
        $repair = array_merge($times, $repair);
        if($repair){update_database("restaurants", "id", $ob->id, $repair);}
        $restaurant["status"] = "Existed already, repaired";
    } else {
        $restaurant = array_merge($times, $restaurant);
        $ob = \App\Http\Models\Restaurants::findOrNew(0);
        $ob->populate($restaurant,false);
        $ob->save();

        if(isset($restaurant["image"]) && $getimages){
            $image = downloadfile($restaurant["image"], public_path("/assets/images/restaurants/" . $ob->id . "/image." .  pathinfo($restaurant["image"], PATHINFO_EXTENSION)));
            if($image !== false){
                $restaurant["id"] = $ob->id;
                $restaurant["photo"] = $image;
                update_database("restaurants", "id", $ob->id, array("logo" => $image));
            }
        }
        $restaurant = object_to_array($restaurant);

        $restaurant["status"] = "Created";
    }

    $profile = select_field("profiles", "restaurant_id", $ob->id);
    if(!$profile){
        echo "<BR>Made account: " . new_anything("profiles", array("profile_type" => 2, "name" => $restaurant["name"] . " owner", "email" => $restaurant["email"], "password" => "18GgKcb2FFBHM", "restaurant_id" => $ob->id, "created_at" => $now, "phone" => $restaurant["phone"]));
    }

    $catid = select_field("category", "res_id", $ob->id);
    if(!$catid){
        $catid = new_anything("category", array("title" => "Main", "display_order" => 1, "res_id" => $ob->id));
        new_anything("menus", array("cat_name" => "Main", "cat_id" => $catid, "is_active" => 1, "display_order" => 1, "price" => 1, "description" => "", "restaurant_id" => $ob->id, "menu_item" => "Test Item", "uploaded_by" => read("id"), "uploaded_on" => $now));
    }
    var_dump($restaurant);
}

function downloadfile($URL, $Filename = false){
        $URL = @file_get_contents($URL);
        if($URL !== false){
            if($Filename){
                @mkdir(getdirectory($Filename), 0777 , true);
                file_put_contents($Filename, $URL);
                return basename($Filename);
            }
        }
        return $URL;
    }
?>