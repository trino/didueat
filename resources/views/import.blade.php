<?php
    if(!isset($_GET["stores"]) || (!is_numeric($_GET["stores"]) && $_GET["stores"] != "all") ){
        die("Please specify how many stores to import by adding &stores=### to the URL. If ### = all then all stores will be imported, otherwise it must be a number");
    }

    $StoreNumber = false;
    $StoreName = "";
    $StoreAddress = "";
    $StorePhone = "";
    $HasHours = false;

    //$Franchises = array();
    $Stores = array();
    $StoreCount = select_field_where("restaurants", array("1=1"), "id", "id", "DESC", "");
    $StoresDone = 0;

    function getlatlong($address, $postalcode = ""){
        $prepAddr = str_replace(' ','+',$address);
        $geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
        $output= json_decode($geocode);
        $found = 0;
        if($postalcode){//make sure it's the right one
            foreach($output->results as $Index => $result){
                if($result->formatted_address){
                    if(strpos(strtolower($result->formatted_address), strtolower($postalcode)) !== false){
                        $found = $Index;
                    }
                }
            }
        }
        return array("latitude" => $output->results[$found]->geometry->location->lat, "longitude" => $output->results[$found]->geometry->location->lng);
    }

    $File = explode("\r\n", file_get_contents( public_path("restaurants.txt") ) );
    foreach($File as $LineNumber => $Text){
        $DayOfWeek = startingtext($Text);
        $IsStore = left($Text, 6) == "STORE ";
        $IsAddress =  strpos(strtolower($Text), "hamilton, on") !== false;

        if( ($IsStore || $IsAddress) && $StoreAddress && $HasHours){
            //$Fields = array("email", "apartment", "phone", "description", "city", "country", "tags", "postal_code", "cuisine" => "cuisines", "province", "address" => "formatted_address", "formatted_address" => "formatted_addressForDB");            //foreach(array("name", "email", "password") as $field){

            $StoreCount++;
            $StoresDone++;
            $Store["restname"] = $StoreName;
            $Store["phone"] = $StorePhone;
            $Store["formatted_addressForDB"] = $StoreAddress;
            $Store["formatted_address"] = $StoreShortAddress;
            $Store["city"] = "Hamilton";
            $Store["province"] = "Ontario";
            $Store["country"] = "Canada";
            $Store["postal_code"] = $PostalCode;
            $Store["franchise"] = $StoreNumber;
            $Store['delivery_fee'] = 5;
            $Store['is_delivery'] = 1;
            $Store['max_delivery_distance'] = MAX_DELIVERY_DISTANCE;
            $Store["description"] = $StoreName . " at " . $StoreShortAddress;
            $Store["email"] = "info+rest" . $StoreCount . "@trinoweb.com";
            $Store["name"] = "Imported Restaurant " . $StoresDone;
            $Store["password"] = "rest" . $StoreCount;
            $Store["cuisines"] = $TheStore->cuisine;
            $Store['minimum'] = 0;
            $Store["is_complete"] = 1;
            $Store["noemail"] = 1;

            $Exists = select_field("restaurants", "description", $Store["description"]);
            echo $StoreName . " at " . $StoreShortAddress;
            if(!$Exists){
                $Store = array_filter(array_merge($Store, getlatlong($StoreAddress, $PostalCode)));
                app('App\Http\Controllers\RestaurantController')->addRestaurants($Store);
                echo " imported<BR>";
                if( is_numeric( $_GET["stores"] ) ){
                    if ($_GET["stores"] <= $StoresDone){
                        die("LAST STORE DONE");
                    }
                }
            } else {
                echo " exists, skipping<BR>";
            }
            $Store = array();
        }

        if($IsStore){
            $StoreNumber = get_string_between($Text, "STORE ", " ");
            $StoreName = trim(str_replace("STORE " . $StoreNumber . " ", "", $Text));
            $TheStore = select_field("restaurants", "name", $StoreName);
            if($TheStore){
                if(!$TheStore->id != $StoreNumber){
                    $StoreNumber = $TheStore->id;
                }
            } else {
                $TheStore = select_field("restaurants", "id", $StoreNumber);
            }

            $StoreAddress = "";
            $StorePhone = "";
            $HasHours = false;
            $Store = array();
            //$Franchises[$StoreName] = $StoreNumber;
        } else if ($IsAddress){
            $HasHours = false;
            $StoreAddress = $Text;
            $StorePhone="";
            $StoreShortAddress = trim(strstr($Text, "Hamilton", true), ", ");
            $PostalCode = str_replace("ON ", "", strstr($Text, "ON "));
        } else if ( left($Text, 1) == "(" ){
            $StorePhone = kill_non_numeric($Text);
        } else if (isdayofweek($DayOfWeek)){
            $HasHours = true;
            $HOURS = trim(str_replace(array("	", $DayOfWeek), "", $Text));
            if($HOURS != "Closed"){
                if($HOURS == "Open 24 hours"){
                    $OPEN = "00:00:00";
                    $CLOSE = "23:59:59";
                } else if ( strpos($HOURS, "-") !== false) {
                    $nHOURS = explode("-", $HOURS);
                    foreach($nHOURS as $Index => $Time){
                        if (strpos($nHOURS[$Index], ":")){
                            $nHOURS[$Index] = converttime(trim($Time));
                        } else{
                            if(is_numeric($Time) && $Index == 0){
                                $Time .= ":00" . right($nHOURS[1], 2);
                            }
                            $nHOURS[$Index] = converttime(str_replace(array("AM", "PM"), array(":00AM", ":00PM"), $Time));
                        }
                    }

                    $OPEN = $nHOURS[0];
                    $CLOSE = $nHOURS[1];
                }
                $Store[$DayOfWeek . "_open"] = $OPEN;
                $Store[$DayOfWeek . "_close"] = $CLOSE;
            }
        }
    }

    //var_dump($Franchises);

    function startingtext($Text){
        return strstr($Text, "	", true);
    }
    function isdayofweek($Text){
        $Days = ["Wednesday", "Thursday", "Friday", "Saturday", "Sunday", "Monday", "Tuesday"];
        return in_array(ucfirst($Text), $Days);
    }
?>