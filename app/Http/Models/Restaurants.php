<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurants extends BaseModel {

    protected $table = 'restaurants';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * @param array
     * @return Array
     */
    public function populate($data,$addlogo = false) {

// requires associative array for postal_code so that copycells will know to modify
        $cells = array('name', 'slug', 'email', 'cuisine', 'phone' => "phone", 'mobile' => "phone", 'website', 'formatted_address', 'address', 'city', 'province', 'postal_code' => "postalcode", 'latitude', 'longitude', 'description', 'is_delivery', 'is_pickup', 'max_delivery_distance', 'delivery_fee', 'hours', 'days', 'holidays', 'minimum', 'rating', 'tags', 'open', 'status', 'sameas', 'ip_address', 'browser_name', 'browser_version', 'browser_platform', 'apartment');
        
        if($addlogo){
            array_push($cells,'logo');
        }
        
        $weekdays = getweekdays();
        $this->is_complete = true;
        $doesopen = false;

        $Fields = array("_open","_close", "_open_del", "_close_del");
        foreach($weekdays as $day){
            foreach($Fields as $field){
                $cells[] = $day . $field;
                if(!isset($data[$day . $field])){
                    $this->is_complete = false;
                } else if($data[$day . $field] && $data[$day . $field] != "00:00:00"){
                    $doesopen = true;
                }
            }
        }

        $browser_info = getBrowser();
        $data['ip_address'] = get_client_ip_server();
        $data['browser_name'] = $browser_info['name'];
        $data['browser_version'] = $browser_info['version'];
        $data['browser_platform'] = $browser_info['platform'];

        $this->copycells($cells, $data);
        if(!$doesopen){$this->is_complete=false;}
        if(!$this->is_delivery && !$this->is_pickup){$this->is_complete=false;}
        if(!$this->latitude || !$this->longitude){$this->is_complete=false;}
        if(!$this->open){$this->is_complete=false;}
        if(!$this->status){$this->is_complete=false;}
    }
    
    public static function listing($array = "", $type = "") {
        //echo "<pre>".print_r($array)."</pre>"; exit();
        $searchResults = $array['searchResults'];
        $meta = $array['meta'];
        $order = $array['order'];
        $per_page = $array['per_page'];
        $start = $array['start'];

        $query = Restaurants::select('*')
                ->Where(function($query) use ($searchResults){
                    if($searchResults != ""){
                          $query->orWhere('name', 'LIKE', "%$searchResults%")
                                ->orWhere('cuisine', 'LIKE', "%$searchResults%")
                                ->orWhere('email', 'LIKE', "%$searchResults%")
                                ->orWhere('website', 'LIKE', "%$searchResults%")
                                ->orWhere('phone', 'LIKE', "%$searchResults%")
                                ->orWhere('mobile', 'LIKE', "%$searchResults%")
                                ->orWhere('formatted_address', 'LIKE', "%$searchResults%")
                                ->orWhere('created_at', 'LIKE', "%$searchResults%");
                    }
                })
                ->orderBy($meta, $order);

        if ($type == "list") {
            $query->take($per_page);
            $query->skip($start);
        }
        return $query;
    }

    /**
     * @param $term
     * @param $per_page
     * @param $start 
     * @return response
     */
    public static function searchRestaurants($data = '', $per_page = 10, $start = 0, $ReturnSQL = false) {
        $query = "";
        $limit = "";
        $order = " ORDER BY distance";
        $limit = " LIMIT $start, $per_page";
        $where = "WHERE restaurants.open = '1' AND status = '1'";
        if(isset($data['is_complete'])){
            $where .= " AND is_complete = '1' AND has_creditcard = '1'";
        }
        if (isset($data['minimum']) && $data['minimum'] != "") {
            $where .= " AND (minimum BETWEEN '".$data['minimum']."' and '".($data['minimum']+5)."')";
        }
        if (isset($data['cuisine']) && $data['cuisine'] != "") {
            $where .= " AND cuisine = '".$data['cuisine']."'";
        }
        if (isset($data['rating']) && $data['rating'] != "") {
            $where .= " AND rating = '".$data['rating']."'";
        }
        if (isset($data['delivery_type']) && $data['delivery_type'] != "") {
            $where .= " AND ".$data['delivery_type']." = '1'";
        }
        if (isset($data['name']) && $data['name'] != "") {
            $where .= " AND name LIKE '%" . Encode($data['name']) . "%'";
        }
        if (isset($data['tags']) && $data['tags'] != "") {
            $where .= " AND tags LIKE '%" . $data['tags'] . "%'";
        }
        if (isset($data['SortOrder']) && $data['SortOrder'] != "") {
            $order = " ORDER BY " . $data['SortOrder'];
        }

        $DayOfWeek = current_day_of_week();
        $now = "02:00:00"; //date('H:i:s');
        $Yesterday = current_day_of_week(-1);
        $DeliveryHours = $data['delivery_type'] == "is_delivery";
        $open = "open" . iif($DeliveryHours, "_del");
        $close = "close" . iif($DeliveryHours, "_del");
        $hours = " AND ((today_open <= now AND today_close > now) OR (today_open > now AND yesterday_close > now))";
        $where .= str_replace(array("now", "open", "close", "midnight", "today", "yesterday"), array("'" . $now . "'", $open, $close, "00:00:00", $DayOfWeek, $Yesterday),  $hours);

        if (isset($data['radius']) && $data['radius'] != "" && isset($data['latitude']) && $data['latitude'] && isset($data['longitude']) && $data['longitude']) {
            $SQL = "SELECT *, ( 6371 * acos( cos( radians('" . $data['latitude'] . "') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('" . $data['longitude']."') ) + sin( radians('" . $data['latitude']."') ) * sin( radians( latitude ) ) ) ) AS distance FROM restaurants $where HAVING distance <= '" . $data['radius'] . "' ";
        } else {
            $SQL = "SELECT *, 0 AS distance FROM restaurants " . $where;
        }
        $SQL .= $order . $limit;
        if($ReturnSQL){return $SQL;}
        $query = \DB::select(\DB::raw($SQL));
        return json_decode(json_encode($query),true);
    }

           
    //////////////////////////////////////Restaurant API/////////////////////////////////

    function blank_restaurant() {
        $Restaurant = getColumnNames("restaurants");
        $Restaurant = array_flip($Restaurant);
        foreach ($Restaurant as $Key => $Value) {
            $Restaurant[$Key] = "";
        }
        $Data = array("id" => 0, "city" => "HAMILTON", "province" => "ON", 'delivery_fee' => 0, 'minimum' => 0, 'country' => 'Canada', 'genre' => 0, 'hours' => array());
        $Restaurant = array_merge($Restaurant, $Data);
        return $Restaurant;
    }

    function get_hours($restaurant_id) {
        $ob = new \App\Http\Models\Hours();
        return $ob->get_hours($restaurant_id);
    }

    function get_restaurant($ID = false, $IncludeHours = False, $IncludeAddresses = False) {
        if (!$ID) {
            $ID = get_current_restaurant();
        }
        if (is_numeric($ID)) {
            $restaurant = get_entry("restaurants", $ID);
        } else {
            $restaurant = get_entry('restaurants', $ID, 'Slug');
        }
        if ($restaurant) {
            if ($IncludeHours) {
                $restaurant->Hours = $this->get_hours($ID);
            }
            if ($IncludeAddresses) {
                $restaurant->Addresses = my_iterator_to_array(enum_notification_addresses($ID), "", "Address");
            }
        }
        return $restaurant;
    }

    function edit_restaurant($ID, $Name, $GenreID, $Email, $Phone, $Address, $City, $Province, $Country, $PostalCode, $Description, $DeliveryFee, $Minimum) {
        if (!$ID) {
            $ID = new_anything("restaurants", $Name);
        }
        $C = ', ';
        $PostalCode = clean_postalcode($PostalCode);
        logevent("Edited restaurant: " . $Name . $C . $GenreID . $C . $Email . $C . clean_phone($Phone) . $C . $Address . $C . $City . $C . $Province . $C . $Country . $C . $PostalCode . $C . $Description . $C . $DeliveryFee . $C . $Minimum);
        $data = array("name" => $Name, "genre" => $GenreID, "email" => $Email, "phone" => clean_phone($Phone), "address" => $Address, "city" => $City, "province" => $Province, "country" => $Country, "postal_code" => $PostalCode, "description" => $Description, "delivery_fee" => $DeliveryFee, "minimum" => $Minimum);

        update_database("restaurants", "id", $ID, $data);
        return $ID;
    }

    function enum_employees($restaurant_id = "", $Hierarchy = "") {
        if (!$restaurant_id) {
            $restaurant_id = get_current_restaurant();
        }
        if ($Hierarchy) {
            return enum_all("profiles", array("restaurant_id" => $restaurant_id, "hierarchy >" => $Hierarchy));
        }
        return enum_profiles("restaurant_id", $restaurant_id);//->order("Hierarchy" , "ASC");
    }


    function hire_employee($UserID, $restaurant_id = 0, $ProfileType = "") {
        if (!check_permission("CanHireOrFire")) {
            return false;
        }

        $Profile = get_profile($UserID);
        if (!$ProfileType) {
            $ProfileType = $Profile->ProfileType;
        }
        $Name = "";
        if ($restaurant_id) {//hire
            if (!$Profile->restaurant_id) {
                $Name = "Hired";
            }
        } else {//fire
            if ($Profile->restaurant_id) {
                $Name = "Fired";
            }
        }
        if ($Name) {
            update_database("profiles", "id", $UserID, array("restaurant_id" => $restaurant_id, "profiletype" => $ProfileType));
            logevent($Name . ": " . $Profile->id . " (" . $Profile->Name . ")");
            return true;
        }
    }

    public static function openclose_restaurant($restaurant_id, $Status = false) {
        if ($Status) {
            $Status = 1;
        } else {
            $Status = 0;
        }
        logevent("Set status to: " . $Status, true, $restaurant_id);
        update_database("restaurants", "id", $restaurant_id, array("open" => $Status));
    }

    public static function delete_restaurant($restaurant_id, $NewProfileType = 2) {
        logevent("Deleted restaurant", true, $restaurant_id);
        delete_all("restaurants", array("id" => $restaurant_id));
        update_database("profiles", "restaurant_id", $restaurant_id, array("restaurant_id" => 0, "profiletype" => $NewProfileType));
    }

/////////////////////////////////////days off API////////////////////////////////////
    function add_day_off($restaurant_id, $Day, $Month, $Year) {
        $this->delete_day_off($restaurant_id, $Day, $Month, $Year, false);
        logevent("Added a day off on: " . $Day . "-" . $Month . "-" . $Year);
        new_entry("daysoff", "ID", array("restaurant_id" => $restaurant_id, "day" => $Day, "month" => $Month, "year" => $Year));
    }

    public static function delete_day_off($restaurant_id, $Day, $Month, $Year, $IsNew = true) {
        if ($IsNew) {
            logevent("Deleted a day off on: " . $Day . "-" . $Month . "-" . $Year);
        }
        delete_all("daysoff", array("restaurant_id" => $restaurant_id, "day" => $Day, "month" => $Month, "year" => $Year));
    }

    public static function enum_days_off($restaurant_id) {
        return enum_all("daysoff", array("restaurant_id" => $restaurant_id));
    }

    public static function is_day_off($restaurant_id, $Day, $Month, $Year) {
        return first(enum_all("daysoff", array("restaurant_id" => $restaurant_id, "day" => $Day, "month" => $Month, "year" => $Year))) == true;
    }

}