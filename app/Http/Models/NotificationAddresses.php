<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationAddresses extends BaseModel {

    protected $table = 'notification_addresses';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * @param array
     * @return Array
     */
    public function populate($data) {
        $cells = array( 'user_id', 'address', 'is_default', 'is_call', 'is_sms', 'type', 'order');
        foreach ($cells as $cell) {
            if (array_key_exists($cell, $data)) {
                $this->$cell = $data[$cell];
            }
        }
    }
    
    public static function listing($array = "", $type = "") {
        //echo "<pre>".print_r($array)."</pre>"; exit();
        $searchResults = $array['searchResults'];
        $meta = $array['meta'];
        $order = $array['order'];
        $per_page = $array['per_page'];
        $start = $array['start'];

        $query = NotificationAddresses::select('*')->where('user_id', \Session::get('session_id'))
                ->Where(function($query) use ($searchResults) {
                    if($searchResults != ""){
                          $query->orWhere('address', 'LIKE', "%$searchResults%")
                                ->orWhere('note', 'LIKE', "%$searchResults%")
                                ->orWhere('type', 'LIKE', "%$searchResults%");
                    }
                })
                ->orderBy($meta, $order);

        if ($type == "list") {
            $query->take($per_page);
            $query->skip($start);
        }
        return $query;
    }


    /////////////////////////////////////Notification addresses API///////////////////////
    function enum_notification_addresses($restaurant_id = "", $type = "") {
        if (!$restaurant_id) {
            $restaurant_id = get_current_restaurant();
        }
        $conditions = array("restaurant_id" => $restaurant_id);
        if (is_numeric($type)) {
            $conditions["type"] = $type;
        }
        return enum_all("notification_addresses", $conditions);
    }

    function count_notification_addresses($restaurant_id = "", $type = "") {
        if (!$restaurant_id) {
            $restaurant_id = get_current_restaurant();
        }
        $conditions = array("restaurant_id" => $restaurant_id);
        if (is_numeric($type)) {
            $conditions["type"] = $type;
        }
        return get_row_count("notification_addresses", $conditions);
    }

    function sort_notification_addresses($restaurant_id = "") {
        if (!$restaurant_id) {
            $restaurant_id = get_current_restaurant();
        }
        $addresses = $this->enum_notification_addresses($restaurant_id);
        if ($addresses) {
            $Data = array("email" => array(), "phone" => array());
            foreach ($addresses as $address) {
                $Data[$address->type][] = $address->address;
            }
            return $Data;
        }
    }

    function find_notification_address($restaurant_id, $address) {
        $type = data_type($address);
        if ($type == 0 || $type == 1) {//email and phone whitelisted
            $address = clean_data($address);
            $Data = enum_all("notification_addresses", array("restaurant_id" => $restaurant_id, "address" => $address));
            return first($Data);
        }
    }

    function delete_notification_address($restaurant_id, $address = "") {
        if (!$restaurant_id) {
            $restaurant_id = get_current_restaurant();
        }
        if ($address) {
            $type = data_type($address);
            if ($type == 0 || $type == 1) {//email and phone whitelisted
                $address = clean_data($address);
                delete_all("notification_addresses", array("restaurant_id" => $restaurant_id, "address" => $address));
            }
        } else {//delete all
            delete_all("notification_addresses", array("restaurant_id" => $restaurant_id));
        }
    }

    function add_notification_addresses($restaurant_id, $address) {
        $type = data_type($address);
        if ($type == 0 || $type == 1) {//email and phone whitelisted
            $address = clean_data($address);
            if (!$this->find_notification_address($restaurant_id, $address)) {
                $Data = array("restaurant_id" => $restaurant_id, "type" => $type, "address" => $address);
                new_entry("notification_addresses", "id", $Data);
                return true;
            }
        }
    }
}