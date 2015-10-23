<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * NotificationAddresses
 * @package    Laravel 5.1.11
 * @subpackage Model
 * @author     Skp Software Technologies
 * @developer  Waqar Javed
 * @date       20 September, 2015
 */
class NotificationAddresses extends BaseModel
{

    protected $table = 'notification_addresses';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * @param array
     * @return Array
     */
    public function populate($data)
    {
        $cells = array('restaurant_id', 'type', 'address');
        foreach ($cells as $cell) {
            if (array_key_exists($cell, $data)) {
                $this->$cell = $data[$cell];
            }
        }
        /*
        if (array_key_exists('restaurant_id', $data)) {
            $this->restaurant_id = $data['restaurant_id'];
        }
        if (array_key_exists('Type', $data)) {
            $this->Type = $data['Type'];
        }
        if (array_key_exists('Address', $data)) {
            $this->Address = $data['Address'];
        }*/

    }


/////////////////////////////////////Notification addresses API///////////////////////
    function enum_notification_addresses($restaurant_id = "", $type = "")
    {
        if (!$restaurant_id) {
            $restaurant_id = get_current_restaurant();
        }
        $conditions = array("restaurant_id" => $restaurant_id);
        if (is_numeric($type)) {
            $conditions["type"] = $type;
        }
        return enum_all("notification_addresses", $conditions);
    }

    function count_notification_addresses($restaurant_id = "", $type = "")
    {
        if (!$restaurant_id) {
            $restaurant_id = get_current_restaurant();
        }
        $conditions = array("restaurant_id" => $restaurant_id);
        if (is_numeric($type)) {
            $conditions["type"] = $type;
        }
        return get_row_count("notification_addresses", $conditions);
    }

    function sort_notification_addresses($restaurant_id = "")
    {
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

    function find_notification_address($restaurant_id, $address)
    {
        $type = data_type($address);
        if ($type == 0 || $type == 1) {//email and phone whitelisted
            $address = clean_data($address);
            $Data = enum_all("notification_addresses", array("restaurant_id" => $restaurant_id, "address" => $address));
            return first($Data);
        }
    }

    function delete_notification_address($restaurant_id, $address = "")
    {
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

    function add_notification_addresses($restaurant_id, $address)
    {
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