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
class Restaurants extends BaseModel
{

    protected $table = 'restaurants';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * @param array
     * @return Array
     */
    public function populate($data)
    {
        $cells = array('name', 'slug', 'genre', 'email', 'phone', 'address', 'city', 'province', 'country', 'postal_code', 'description', 'logo', 'delivery_fee', 'minimum', 'open');
        foreach ($cells as $cell) {
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

    /**
     * @param $term
     * @param $per_page
     * @param $start
     * @return response
     */
    public static function searchRestaurants($term = '', $per_page = 10, $start = 0, $type = '', $sortType = 'id', $sortBy = 'DESC', $city = '', $province = '', $country = '')
    {
        $query = \App\Http\Models\Restaurants::where('open', 1)
            ->Where(function ($query) use ($term, $city, $province, $country) {
                if ($term != "") {
                    $query->where('name', 'LIKE', "%$term%");
                }
                if ($city != "") {
                    $query->where('city', '=', "$city");
                }
                if ($province != "") {
                    $query->where('province', '=', "$province");
                }
                if ($country != "") {
                    $query->where('country', '=', "$country");
                }
            })->orderBy($sortType, $sortBy);
        //print_r($query->toSql()); die;
        if ($type == "list") {
            $query->take($per_page);
            $query->skip($start);
        }
        return $query;
    }


//////////////////////////////////////Restaurant API/////////////////////////////////

    function blank_restaurant()
    {
        $Restaurant = getColumnNames("restaurants");
        $Restaurant = array_flip($Restaurant);
        foreach ($Restaurant as $Key => $Value) {
            $Restaurant[$Key] = "";
        }
        $Data = array("id" => 0, "city" => "HAMILTON", "province" => "ON", 'delivery_fee' => 0, 'minimum' => 0, 'country' => 'Canada', 'genre' => 0, 'hours' => array());
        $Restaurant = array_merge($Restaurant, $Data);
        return $Restaurant;
    }

    function get_hours($restaurant_id)
    {
        $ob = new \App\Http\Models\Hours();
        return $ob->get_hours($restaurant_id);
    }

    function get_restaurant($ID = false, $IncludeHours = False, $IncludeAddresses = False)
    {
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

    function edit_restaurant($ID, $Name, $GenreID, $Email, $Phone, $Address, $City, $Province, $Country, $PostalCode, $Description, $DeliveryFee, $Minimum)
    {
        if (!$ID) {
            $ID = new_anything("restaurants", $Name);
        }
        $C = ', ';
        $PostalCode = clean_postalcode($PostalCode);
        logevent("Edited restaurant: " . $Name . $C . $GenreID . $C . $Email . $C . clean_phone($Phone) . $C . $Address . $C . $City . $C . $Province . $C . $Country . $C . $PostalCode . $C . $Description . $C . $DeliveryFee . $C . $Minimum);
        $data = array("name" => $Name, "genre" => $GenreID, "email" => $Email, "phone" => clean_phone($Phone), "address" => $Address, "city" => $City, "province" => $Province, "country" => $Country, "post_code" => $PostalCode, "description" => $Description, "delivery_fee" => $DeliveryFee, "minimum" => $Minimum);
        update_database("restaurants", "id", $ID, $data);
        return $ID;
    }

    function enum_employees($restaurant_id = "", $Hierarchy = "")
    {
        if (!$restaurant_id) {
            $restaurant_id = get_current_restaurant();
        }
        if ($Hierarchy) {
            return enum_all("profiles", array("restaurant_id" => $restaurant_id, "hierarchy >" => $Hierarchy));
        }
        return enum_profiles("restaurant_id", $restaurant_id);//->order("Hierarchy" , "ASC");
    }


    function hire_employee($UserID, $restaurant_id = 0, $ProfileType = "")
    {
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

    public static function openclose_restaurant($restaurant_id, $Status = false)
    {
        if ($Status) {
            $Status = 1;
        } else {
            $Status = 0;
        }
        logevent("Set status to: " . $Status, true, $restaurant_id);
        update_database("restaurants", "id", $restaurant_id, array("open" => $Status));
    }

    public static function delete_restaurant($restaurant_id, $NewProfileType = 2)
    {
        logevent("Deleted restaurant", true, $restaurant_id);
        delete_all("restaurants", array("id" => $restaurant_id));
        update_database("profiles", "restaurant_id", $restaurant_id, array("restaurant_id" => 0, "profiletype" => $NewProfileType));
    }

/////////////////////////////////////days off API////////////////////////////////////
    function add_day_off($restaurant_id, $Day, $Month, $Year)
    {
        $this->delete_day_off($restaurant_id, $Day, $Month, $Year, false);
        logevent("Added a day off on: " . $Day . "-" . $Month . "-" . $Year);
        new_entry("daysoff", "ID", array("restaurant_id" => $restaurant_id, "day" => $Day, "month" => $Month, "year" => $Year));
    }

    public static function delete_day_off($restaurant_id, $Day, $Month, $Year, $IsNew = true)
    {
        if ($IsNew) {
            logevent("Deleted a day off on: " . $Day . "-" . $Month . "-" . $Year);
        }
        delete_all("daysoff", array("restaurant_id" => $restaurant_id, "day" => $Day, "month" => $Month, "year" => $Year));
    }

    public static function enum_days_off($restaurant_id)
    {
        return enum_all("daysoff", array("restaurant_id" => $restaurant_id));
    }

    public static function is_day_off($restaurant_id, $Day, $Month, $Year)
    {
        return first(enum_all("daysoff", array("restaurant_id" => $restaurant_id, "day" => $Day, "month" => $Month, "year" => $Year))) == true;
    }

}