<?php
namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Restaurants
 * @package    Laravel 5.1.11
 * @subpackage Model
 * @author     Skp Software Technologies
 * @developer  Waqar Javed
 * @date       20 September, 2015
 */
class Restaurants extends BaseModel {

    protected $table = 'restaurants';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    /**
     * @param array
     * @return Array
     */
    public function populate($data) {
        $cells = array('name', 'slug', 'genre', 'email', 'phone', 'address', 'city', 'province', 'country', 'postal_code', 'description', 'logo', 'delivery_fee', 'minimum', 'open');
        foreach($cells as $cell) {
            if (array_key_exists($cell, $data)) {
                $this->$cell = $data[$cell];
            }
        }
        /*
        if (array_key_exists('Name', $data)) {
            $this->Name = $data['Name'];
        }
        if (array_key_exists('Slug', $data)) {
            $this->Slug = $data['Slug'];
        }
        if (array_key_exists('Genre', $data)) {
            $this->Genre = $data['Genre'];
        }
        if (array_key_exists('Email', $data)) {
            $this->Email = $data['Email'];
        }
        if (array_key_exists('Phone', $data)) {
            $this->Phone = $data['Phone'];
        }
        if (array_key_exists('Address', $data)) {
            $this->Address = $data['Address'];
        }
        if (array_key_exists('City', $data)) {
            $this->City = $data['City'];
        }
        if (array_key_exists('Province', $data)) {
            $this->Province = $data['Province'];
        }
        if (array_key_exists('Country', $data)) {
            $this->Country = $data['Country'];
        }
        if (array_key_exists('PostalCode', $data)) {
            $this->PostalCode = $data['PostalCode'];
        }
        if (array_key_exists('Description', $data)) {
            $this->Description = $data['Description'];
        }
        if (array_key_exists('Logo', $data)) {
            $this->Logo = $data['Logo'];
        }
        if (array_key_exists('DeliveryFee', $data)) {
            $this->DeliveryFee = $data['DeliveryFee'];
        }
        if (array_key_exists('Minimum', $data)) {
            $this->Minimum = $data['Minimum'];
        }
        if (array_key_exists('Status', $data)) {
            $this->Status = $data['Status'];
        }*/
    }


//////////////////////////////////////Restaurant API/////////////////////////////////

    function blank_restaurant(){
        $Restaurant = getColumnNames("restaurants");
        $Restaurant = array_flip($Restaurant);
        foreach($Restaurant as $Key => $Value){
            $Restaurant[$Key] = "";
        }
        $Data = array("id" => 0, "city" => "HAMILTON", "province" => "ON", 'deliveryfee' => 0, 'minimum' => 0, 'country' => 'Canada', 'genre' => 0, 'hours' => array());
        $Restaurant = array_merge($Restaurant, $Data);
        return $Restaurant;
    }

    function get_hours($RestaurantID){
        $ob = new \App\Http\Models\Hours();
        return $ob->get_hours($RestaurantID);
    }

    function get_restaurant($ID = false, $IncludeHours = False, $IncludeAddresses = False){
        if(!$ID){$ID = get_current_restaurant();}
        if (is_numeric($ID)) {
            $restaurant = get_entry("restaurants", $ID);
        } else {
            $restaurant = get_entry('restaurants', $ID, 'Slug');
        }
        if($restaurant){
            if($IncludeHours) {$restaurant->Hours = $this->get_hours($ID);}
            if($IncludeAddresses){$restaurant->Addresses = my_iterator_to_array(enum_notification_addresses($ID), "", "Address");}
        }
        return $restaurant;
    }

    function edit_restaurant($ID, $Name, $GenreID, $Email, $Phone, $Address, $City, $Province, $Country, $PostalCode, $Description, $DeliveryFee, $Minimum){
        if(!$ID){$ID = new_anything("restaurants", $Name);}
        $C = ', ';
        $PostalCode = clean_postalcode($PostalCode);
        logevent("Edited restaurant: " . $Name .$C. $GenreID .$C. $Email .$C. clean_phone($Phone) .$C. $Address .$C. $City .$C. $Province .$C. $Country .$C. $PostalCode .$C. $Description .$C. $DeliveryFee .$C. $Minimum);
        $data = array("name" => $Name, "genre" => $GenreID, "email" => $Email, "phone" => clean_phone($Phone), "address" => $Address, "city" => $City, "province" => $Province, "country" => $Country, "postalcode" => $PostalCode, "description" => $Description, "deliveryfee" => $DeliveryFee, "minimum" => $Minimum);
        update_database("restaurants", "id", $ID, $data);
        return $ID;
    }

    function enum_employees($RestaurantID = "", $Hierarchy = ""){
        if(!$RestaurantID){
            $RestaurantID = get_current_restaurant();
        }
        if($Hierarchy){
            return enum_all("profiles", array("restaurantid" => $RestaurantID, "hierarchy >" => $Hierarchy));
        }
        return enum_profiles("restaurantid", $RestaurantID);//->order("Hierarchy" , "ASC");
    }


    function hire_employee($UserID, $RestaurantID = 0, $ProfileType = ""){
        if(!check_permission("CanHireOrFire")){return false;}

        $Profile = get_profile($UserID);
        if(!$ProfileType){$ProfileType=$Profile->ProfileType;}
        $Name = "";
        if($RestaurantID){//hire
            if (!$Profile->RestaurantID) { $Name = "Hired"; }
        } else {//fire
            if ($Profile->RestaurantID) { $Name = "Fired"; }
        }
        if($Name){
            update_database("profiles", "id", $UserID, array("restaurantid" => $RestaurantID, "profiletype" => $ProfileType));
            logevent($Name . ": " . $Profile->ID . " (" . $Profile->Name . ")" );
            return true;
        }
    }

    public static function openclose_restaurant($RestaurantID, $Status = false){
        if($Status){$Status=1;} else {$Status = 0;}
        logevent("Set status to: " . $Status, true, $RestaurantID);
        update_database("restaurants", "id", $RestaurantID, array("open" => $Status));
    }

    public static function delete_restaurant($RestaurantID, $NewProfileType = 2){
        logevent("Deleted restaurant", true, $RestaurantID);
        delete_all("restaurants", array("id" => $RestaurantID));
        update_database("profiles", "restaurantid", $RestaurantID, array("restaurantid" => 0, "profiletype" => $NewProfileType));
    }

/////////////////////////////////////days off API////////////////////////////////////
    function add_day_off($RestaurantID, $Day, $Month, $Year){
        $this->delete_day_off($RestaurantID, $Day, $Month, $Year, false);
        logevent("Added a day off on: " . $Day . "-" . $Month . "-" . $Year);
        new_entry("daysoff", "ID", array("restaurantid" => $RestaurantID, "day" => $Day, "month" => $Month, "year" => $Year));
    }
    public static function delete_day_off($RestaurantID, $Day, $Month, $Year, $IsNew = true){
        if ($IsNew){
            logevent("Deleted a day off on: " . $Day . "-" . $Month . "-" . $Year);
        }
        delete_all("daysoff", array("restaurantid" => $RestaurantID, "day" => $Day, "month" => $Month, "year" => $Year));
    }
    public static function enum_days_off($RestaurantID){
        return enum_all("daysoff", array("restaurantid" => $RestaurantID));
    }
    public static function is_day_off($RestaurantID, $Day, $Month, $Year){
        return first(enum_all("daysoff", array("restaurantid" => $RestaurantID, "day" => $Day, "month" => $Month, "year" => $Year))) == true;
    }

}