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
        $cells = array('name', 'slug', 'email', 'cuisine', 'phone' => "phone", 'mobile' => "phone", 'website', 'formatted_address', 'address', 'apartment', 'city', 'province', 'country', 'postal_code' => "postalcode", 'latitude', 'longitude', 'description', 'is_delivery', 'is_pickup', 'max_delivery_distance', 'delivery_fee', 'hours', 'days', 'holidays', 'minimum', 'rating', 'tags', 'open', 'status', 'sameas', 'ip_address', 'browser_name', 'browser_version', 'browser_platform','initialReg');

        if(!isset($data["max_delivery_distance"]) || !$data["max_delivery_distance"]){$data["max_delivery_distance"] = 5;}

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

        $this->copycells($cells, $data);
        if(!$doesopen){$this->is_complete=false;}
        if(!$this->is_delivery && !$this->is_pickup){$this->is_complete=false;}
        if(!$this->latitude || !$this->longitude){$this->is_complete=false;}
        //if(!$this->open){$this->is_complete=false;}
        if(!$this->status){$this->is_complete=false;}

        if($this->is_complete){$this->open=true;}
    }
    
    public static function listing($array = "", $type = "") {
        //echo "<pre>".print_r($array)."</pre>"; exit();
        $searchResults = $array['searchResults'];
        $incomplete = $array['incomplete'];
        $meta = $array['meta'];
        $order = $array['order'];
        $per_page = $array['per_page'];
        $start = $array['start'];

        $query = Restaurants::select('*')
                ->Where(function($query) use ($searchResults, $incomplete){
                    if($incomplete){
                        $query->Where('is_complete', '0');
                            //->orWhere('has_creditcard', '0');
                    }
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

    public static function getbusinessday($restaurant){
        $now = date('H:i:s');
        $Today = current_day_of_week();
        $Yesterday = current_day_of_week(-1);
        if(!is_object($restaurant)) {
            $restaurant = get_entry("restaurants", $restaurant);
        }
        $Today_Open = getfield($restaurant, $Today . "_open");
        $Yesterday_Open = getfield($restaurant, $Yesterday . "_open");
        $Yesterday_Close = getfield($restaurant, $Yesterday . "_close");
        if ($Yesterday_Close > $now && $Yesterday_Open > $Yesterday_Close && $now < $Today_Open){
            return $Yesterday;
        }
        return $Today;
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
        $where = "WHERE restaurants.open = '1'";// AND status = '1'";
        if(isset($data['is_complete'])){
            $where .= " AND is_complete = '1'";// AND has_creditcard = '1'";
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
        $now = date('H:i:s');
        $Yesterday = current_day_of_week(-1);
        $DeliveryHours = isset($data['delivery_type']) && $data['delivery_type'] == "is_delivery";
        $open = "open" . iif($DeliveryHours, "_del");
        $close = "close" . iif($DeliveryHours, "_del");
        $hours = " AND ((today_open <= now AND today_close > now) OR (today_open > now AND yesterday_close > now))";
        $where .= str_replace(array("now", "open", "close", "midnight", "today", "yesterday"), array("'" . $now . "'", $open, $close, "00:00:00", $DayOfWeek, $Yesterday),  $hours);

        $data['radius']="max_delivery_distance";//other options are "5", or MAX_DELIVERY_DISTANCE
        if (isset($data['radius']) && $data['radius'] != "" && isset($data['latitude']) && $data['latitude'] && isset($data['longitude']) && $data['longitude']) {
            $SQL = "SELECT *, ( 6371 * acos( cos( radians('" . $data['latitude'] . "') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('" . $data['longitude']."') ) + sin( radians('" . $data['latitude']."') ) * sin( radians( latitude ) ) ) ) AS distance FROM restaurants $where HAVING distance <= " . $data['radius'];
        } else {
            $SQL = "SELECT *, 0 AS distance FROM restaurants " . $where;
        }
        $SQL .= $order . $limit;
        if($ReturnSQL){return $SQL;}
        $query = \DB::select(\DB::raw($SQL));
        return json_decode(json_encode($query),true);
    }

    public function saverestaurant(){
        die("TEST");
    }
}