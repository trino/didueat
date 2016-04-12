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
        $use_delivery_hours = !isset($data["samehours"]);//update $use_delivery_hours in dashboard/restaurant/hours.blade.php if this policy changes
        $cells = array('name', 'slug', 'email', 'cuisine', 'phone' => "phone", 'mobile' => "phone", 'website', 'formatted_address', 'address', 'apartment', 'city' => "ucfirst", 'province' => "ucfirst", 'country' => "ucfirst", 'postal_code' => "postalcode", 'latitude', 'longitude', 'description', 'is_delivery', 'is_pickup', 'max_delivery_distance', 'delivery_fee', 'hours', 'days', 'holidays', 'minimum', 'rating', 'tags', 'open', 'sameas', 'ip_address', 'browser_name', 'browser_version', 'browser_platform','initialReg', 'payment_methods', 'aprox_time', 'uploaded_by');
        if(!isset($data["open"])){$data["open"] = 0;}

        if(!isset($data["max_delivery_distance"]) || !$data["max_delivery_distance"]){$data["max_delivery_distance"] = 5;}

        if($addlogo){
            array_push($cells,'logo');
        }
        
        $weekdays = getweekdays();
        $Fields = array("_open","_close", "_open_del", "_close_del");
        foreach($weekdays as $day){
            foreach($Fields as $field){
                $cells[$day . $field] = "24hr";
            }
        }

        $this->copycells($cells, $data);

        //This sets delivery times to pickup times
        if(!$use_delivery_hours) {
            foreach ($weekdays as $day) {
                foreach (array("_open", "_close") as $fieldname) {
                    $srcfield = $day . $fieldname;
                    if (isset($this->$srcfield)) {
                        $field = $day . $fieldname . "_del";
                        $this->$field = $this->$srcfield;
                    }
                }
            }
        }

        $this->is_complete = $this->restaurant_opens($this);
        if(!$this->is_complete){$this->open = false;}
    }

    //checks if the restaurant is now open, and sends an email to the restaurant if it wasn't open before
    //exmaple: \App\Http\Models\Restaurants::restaurant_opens($rest);
    public static function restaurant_opens($restaurant, $update_database = false){
        if(!is_object($restaurant)) {
            $restaurant = select_field("restaurants", "id", $restaurant);
        }
        if(!isset($restaurant->id) || !$restaurant->id){return false;}//new stores can't open anyway

        $weekdays = getweekdays();
        $doesopen = false;
        foreach($weekdays as $day){
            $open = getfield($restaurant, $day . "_open");
            $close = getfield($restaurant, $day . "_close");
            if($open && $close && $open != $close){
                $doesopen = true;
                break;
            }
        }
        if(!$doesopen){return false;}
        if(!$restaurant->is_delivery && !$restaurant->is_pickup){return false;}
        if(!$restaurant->latitude || !$restaurant->longitude){$restaurant->is_complete=false;}
        if(isset($restaurant->id)) {
            $MenuTst = select_field("menus", array("restaurant_id", "is_active"), array($restaurant->id, 1), "menu_item");
            if (!isset($MenuTst)) {return false;}
        }
        if($update_database && !$restaurant->is_complete){
            edit_database("restaurants", "id", $restaurant->id, array("is_complete" => true));
            app('App\Http\Controllers\OrdersController')->emailstore($restaurant->id, "Your restaurant is now open");
        }
        return true;
    }
    
    public static function listing($array = "", $type = "", &$reccount = 0) {
        //echo "<pre>".print_r($array)."</pre>"; exit();
        $searchResults = $array['searchResults'];
        $incomplete = $array['incomplete'];
        $meta = $array['meta'];
        $order = $array['order'];
        $per_page = $array['per_page'];
        $start = $array['start'];
        $city = "";
        if(isset($array["city"])){$city = $array["city"];}

        $query = Restaurants::select('*')
            ->Where(function ($query) use ($searchResults, $incomplete, $city, $array) {
                if ($incomplete) {
                    $query->Where('is_complete', '0');
                    //->orWhere('has_creditcard', '0');
                }
                if($city){
                    $query->Where('city',               'LIKE', "%$city%");
                }
                if ($searchResults) {
                    $query->orWhere('name',             'LIKE', "%$searchResults%")
                        ->orWhere('cuisine',            'LIKE', "%$searchResults%")
                        ->orWhere('email',              'LIKE', "%$searchResults%")
                        ->orWhere('website',            'LIKE', "%$searchResults%")
                        ->orWhere('phone',              'LIKE', "%$searchResults%")
                        ->orWhere('mobile',             'LIKE', "%$searchResults%")
                        ->orWhere('formatted_address',  'LIKE', "%$searchResults%");
                }
            })
            ->orderBy($meta, $order);
        $reccount = $query->count();
        if ($type == "list") {
            $query->take($per_page);
            $query->skip($start);
        }
        return $query;
    }

    //only returns a value if the store is open at the time specified
    //example use \App\Http\Models\Restaurants::getbusinessday($rest);
    public static function getbusinessday($restaurant, $date = false, $delivery = false){
        if(is_array($restaurant)){$restaurant = array_to_object($restaurant);}
        if(!$date){$date = now(true);}
        $now = date('H:i:s', $date);
        $Today = current_day_of_week($date);
        $Yesterday = current_day_of_week($date - 86400);
        if(!is_object($restaurant)) {
            $restaurant = get_entry("restaurants", $restaurant);
        }
        if($delivery){$delivery = "_del";}
        $Today_Open = getfield($restaurant, $Today . "_open" . $delivery);
        $Today_Close = getfield($restaurant, $Today . "_close" . $delivery);
        $Yesterday_Open = getfield($restaurant, $Yesterday . "_open" . $delivery);
        $Yesterday_Close = getfield($restaurant, $Yesterday . "_close" . $delivery);
        if ($Yesterday_Close >= $now && $Yesterday_Open > $Yesterday_Close && $now < $Today_Open){
            return $Yesterday;
        }
        if($now >= $Today_Open && $now <= $Today_Close) {
            return $Today;
        }
        if($Today_Close < $Today_Open && $now >= $Today_Open){
            return $Today;
        }
        //echo "Now: " . $now . ' Today open: ' . $Today_Open . " Today close: " . $Today_Close . " Yest. Open: " . $Yesterday_Open . " Yest. Close: " . $Yesterday_Close;
        return false;
    }


    /**
     * @param $term
     * @param $per_page
     * @param $start 
     * @return response
     */
    public static function searchRestaurants($data = '', $per_page = 10, $start = 0, $ReturnSQL = false, &$count = 0) {
        $order = " ORDER BY openedRest desc, views desc";//" ORDER BY openedRest desc, distance";
        $limit = " LIMIT $start, $per_page";
        $where = "WHERE is_complete = '1'";// AND status = '1'";
        if (isset($data['minimum']) && $data['minimum'] != "") {
            $where .= " AND (minimum BETWEEN '".$data['minimum']."' and '".($data['minimum']+5)."')";
        }
        if (isset($data['delivery_type']) && $data['delivery_type'] != "") {
            if($data['delivery_type'] != "both"){
               $where .= " AND ".$data['delivery_type']." = 1"; // for both, just do not have any condn here
            }
        }

        if (isset($data['name']) && $data['name'] != "") {
            $where .= " AND name LIKE '%" . Encode($data['name']) . "%'";
        }

        foreach(array("tags", "cuisine") as $field) {//LIKE
            if (isset($data[$field]) && $data[$field]) {
                $where .= " AND " . $field . " LIKE '%" . $data[$field] . "%'";
            }
        }

        //handle hard-coded addresses
        $IsHardcoded=false;
        if(isset($data["formatted_address"]) && $data["formatted_address"]){
            $IsHardcoded = true;
            switch($data["formatted_address"]){
                case "Hamilton, Ontario"; case "Hamilton, ON, Canada";
                    $data["city"] = "Hamilton";
                    $data["province"] = "Ontario";
                    break;
                default:
                    $IsHardcoded = false;
            }
        }

        foreach(array("city", "province", "country", "rating") as $field) {//EQUAL
            if (isset($data[$field]) && $data[$field]) {
                $where .= " AND " . $field . " = '" . $data[$field] . "'";
            }
        }

        if (isset($data['SortOrder']) && $data['SortOrder'] != "") {
            $order = " ORDER BY " . $data['SortOrder'];
        }

        //handles hours of operation
        $date = now(true);
        $data['date'] = date("l F j, Y - H:i (g:i A)", $date);
        $DayOfWeek = current_day_of_week($date);
        $now = date('H:i:s', $date);
        $Yesterday = current_day_of_week($date - 86400);
        $DeliveryHours = isset($data['delivery_type']) && $data['delivery_type'] == "is_delivery";
        $open = "open" . iif($DeliveryHours, "_del");
        $close = "close" . iif($DeliveryHours, "_del");
        $hours = " (today_open != today_close AND (today_close > today_open AND today_open < now AND today_close > now) OR (today_close < today_open AND today_open < now)) ";
        $hours .= " OR (today_open > now AND yesterday_close > now AND yesterday_close != yesterday_open)";
        $openedRestCondn = str_replace(array("now", "open", "close", "midnight", "today", "yesterday"), array("'" . $now . "'", $open, $close, "00:00:00", $DayOfWeek, $Yesterday),  $hours);
        $asopenedRest = "IF(".$openedRestCondn.",1,0) as openedRest";

        (isset($data['earthRad']))? $earthRad=$data['earthRad'] : $earthRad=6371;//why? Because the default will be in kilometers

        //handles distance
        $data['radius']=iif(debugmode(), 30, "max_delivery_distance");
        if (!$IsHardcoded && isset($data['radius']) && $data['radius'] != "" && isset($data['latitude']) && $data['latitude'] && isset($data['longitude']) && $data['longitude']) {
            $SQL = "SELECT *, ( " . $earthRad . " * acos( cos( radians('" . $data['latitude'] . "') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('" . $data['longitude']."') ) + sin( radians('" . $data['latitude']."') ) * sin( radians( latitude ) ) ) ) AS distance, $asopenedRest FROM restaurants $where HAVING distance <= " . $data['radius'];
        } else {
            $SQL = "SELECT *, 0 AS distance, $asopenedRest FROM restaurants " . $where;
        }

        if(!$ReturnSQL) {$count = iterator_count(select_query($SQL));}//get total count

        $asopenedRest2 = $asopenedRest . ', (SELECT COUNT(*) as views FROM `page_views` WHERE page_views.type = "restaurant" AND page_views.target_id= restaurants.id) as views';
        $SQL = str_replace($asopenedRest, $asopenedRest2, $SQL);

        //assemble the final query, with a comment showing which date was used
        $SQL .= $order . $limit . " -- Using date: " . $data['date'];
        
        if($ReturnSQL){return $SQL;}
        $query = \DB::select(\DB::raw($SQL));
//        debugprint(json_decode(json_encode($query),true));
        return json_decode(json_encode($query),true);
    }

    //save the restaurant, checking if it was complete before hand, and if it is afterwards
    //if it was not complete before, but is after, notify the store by email that it is now open
    public function save(array $options = array()) {
        $ret=false;
        if($this->is_complete) {
            $OldData = select_field("restaurants", "id", $this->id);
            //check for changes in the phone number and email address
            if($OldData->phone != $this->phone){
                update_database("notification_addresses", "address", $OldData->phone, array("address" => $this->phone));
            }
            if($OldData->email != $this->email){
                update_database("notification_addresses", "address", $OldData->email, array("address" => $this->email));
            }

            $Was_Complete = $OldData->is_complete;
            if(!$Was_Complete){
                $this->is_complete=false;
                $this->restaurant_opens($this, true);
                $this->is_complete=true;
                $this->flash(true, "Your restaurant is now open", "Success!");
                $ret=true;
            }
        }
        parent::save($options);
        return $ret;
    }
}