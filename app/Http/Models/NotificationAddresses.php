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
class NotificationAddresses extends BaseModel {

    protected $table = 'notification_addresses';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    
    /**
     * @param array
     * @return Array
     */
    public function populate($data) {
        $cells = array('RestaurantID', 'Type', 'Address');
        foreach($cells as $cell) {
            if (array_key_exists($cell, $data)) {
                $this->$cell = $data[$cell];
            }
        }
        /*
        if (array_key_exists('RestaurantID', $data)) {
            $this->RestaurantID = $data['RestaurantID'];
        }
        if (array_key_exists('Type', $data)) {
            $this->Type = $data['Type'];
        }
        if (array_key_exists('Address', $data)) {
            $this->Address = $data['Address'];
        }*/
        
    }


/////////////////////////////////////Notification addresses API///////////////////////
    function enum_notification_addresses($RestaurantID = "", $Type = ""){
        if(!$RestaurantID){$RestaurantID = get_current_restaurant();}
        $conditions = array("RestaurantID" => $RestaurantID);
        if (is_numeric($Type)){$conditions["Type"] = $Type;}
        return enum_all("notification_addresses", $conditions);
    }
    function count_notification_addresses($RestaurantID = "", $Type = "") {
        if (!$RestaurantID) {$RestaurantID = get_current_restaurant();}
        $conditions = array("RestaurantID" => $RestaurantID);
        if (is_numeric($Type)){$conditions["Type"] = $Type;}
        return get_row_count("notification_addresses", $conditions);
    }

    function sort_notification_addresses($RestaurantID = ""){
        if(!$RestaurantID){$RestaurantID = get_current_restaurant();}
        $Addresses = enum_notification_addresses($RestaurantID);
        if($Addresses) {
            $Data = array("Email" => array(), "Phone" => array());
            foreach ($Addresses as $Address) {
                $Data[$Address->Type][] = $Address->Address;
            }
            return $Data;
        }
    }
    function find_notification_address($RestaurantID, $Address){
        $Type = data_type($Address);
        if ($Type == 0 || $Type == 1) {//email and phone whitelisted
            $Address = clean_data($Address);
            $Data = enum_all("notification_addresses", array("RestaurantID" => $RestaurantID, "Address" => $Address));
            return first($Data);
        }
    }
    function delete_notification_address($RestaurantID, $Address = "") {
        if(!$RestaurantID){$RestaurantID = get_current_restaurant();}
        if($Address) {
            $Type = data_type($Address);
            if ($Type == 0 || $Type == 1) {//email and phone whitelisted
                $Address = clean_data($Address);
                delete_all("notification_addresses", array("RestaurantID" => $RestaurantID, "Address" => $Address));
            }
        } else {//delete all
            delete_all("notification_addresses", array("RestaurantID" => $RestaurantID));
        }
    }

    function add_notification_addresses($RestaurantID, $Address){
        $Type = data_type($Address);
        if ($Type == 0 || $Type == 1){//email and phone whitelisted
            $Address = clean_data($Address);
            if(!find_notification_address($RestaurantID, $Address)){
                $Data = array("RestaurantID" => $RestaurantID, "Type" => $Type, "Address" => $Address);
                new_entry("notification_addresses", "ID", $Data);
                return true;
            }
        }
    }

}