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
        $cells = array('name', 'slug', 'email', 'cuisine', 'phone', 'mobile', 'website', 'formatted_address', 'address', 'city', 'province', 'country', 'postal_code', 'lat', 'lng', 'description', 'logo', 'is_delivery', 'is_pickup', 'delivery_fee', 'hours', 'days', 'holidays', 'minimum', 'rating', 'tags', 'open', 'status', 'ip_address', 'browser_name', 'browser_version', 'browser_platform');
        foreach ($cells as $cell) {
            if (array_key_exists($cell, $data)) {
                $this->$cell = $data[$cell];
            }
        }
    }

    /**
     * @param $term
     * @param $per_page
     * @param $start
     * @return response
     */
    public static function searchRestaurants($data = '', $per_page = 10, $start = 0)
    {
        $query = "";
        $limit = "";
        if (isset($data['radius']) && $data['radius'] != "" && $data['formatted_address'] != "") {
            $order = " ORDER BY distance";
            $limit = " LIMIT $start, $per_page";
            $where = "WHERE open = '1' AND status = '1'";
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
            if (isset($data['tags']) && $data['tags'] != "") {
                $where .= " AND tags LIKE '%".$data['tags']."%'";
            }
            if (isset($data['SortOrder']) && $data['SortOrder'] != "") {
                $order = " ORDER BY ".$data['SortOrder'];
            }
            
            $query = \DB::select("SELECT *, ( 6371 * acos( cos( radians('".$data['latitude']."') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('".$data['longitude']."') ) + sin( radians('".$data['latitude']."') ) * sin( radians( lat ) ) ) ) AS distance FROM restaurants $where HAVING distance < '".$data['radius']."' ".$order.$limit);
            $query = json_decode(json_encode($query),true);
        } else {
            $order = " ORDER BY id";
            $limit = " LIMIT $start, $per_page";
            $where = "WHERE open = '1' AND status = '1'";
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
            if (isset($data['tags']) && $data['tags'] != "") {
                $where .= " AND tags LIKE '%".$data['tags']."%'";
            }
            if (isset($data['SortOrder']) && $data['SortOrder'] != "") {
                $order = " ORDER BY ".$data['SortOrder'];
            }
            $query = \DB::select("SELECT * FROM restaurants ".$where.$order.$limit);
            $query = json_decode(json_encode($query),true);
            
//            if($query_type == "list"){
//                $query = \App\Http\Models\Restaurants::where('open', 1)->where('status', 1)
//                        ->Where(function ($query) use ($data){
//                            if($data){
//                                if ($data['tags'] != "") {
//                                    $query->where('tags', 'LIKE', '%'.$data['tags'].'%');
//                                }
//                                if ($data['minimum'] != "") {
//                                    $query->whereBetween('minimum', [$data['minimum'], $data['minimum']+5]);
//                                }
//                                if ($data['cuisine'] != "") {
//                                    $query->where('cuisine', '=', $data['cuisine']);
//                                }
//                                if ($data['rating'] != "") {
//                                    $query->where('rating', '=', $data['rating']);
//                                }
//                                if (isset($data['delivery_type']) && $data['delivery_type'] != "") {
//                                    $query->where($data['delivery_type'], '=', 1);
//                                }
//                            }
//                        })
//                        ->orderBy((isset($data['SortOrder']) && $data['SortOrder'] != "")?$data['SortOrder']:'id', 'DESC')
//                        ->take($per_page)
//                        ->skip($start)
//                        ->get()->toArray();
//            } else {
//                $query = \App\Http\Models\Restaurants::where('open', 1)->where('status', 1)
//                        ->Where(function ($query) use ($data){
//                            if($data){
//                                if ($data['tags'] != "") {
//                                    $query->where('tags', 'LIKE', '%'.$data['tags'].'%');
//                                }
//                                if ($data['minimum'] != "") {
//                                    $query->whereBetween('minimum', [$data['minimum'], $data['minimum']+5]);
//                                }
//                                if ($data['cuisine'] != "") {
//                                    $query->where('cuisine', '=', $data['cuisine']);
//                                }
//                                if ($data['rating'] != "") {
//                                    $query->where('rating', '=', $data['rating']);
//                                }
//                                if (isset($data['delivery_type']) && $data['delivery_type'] != "") {
//                                    $query->where($data['delivery_type'], '=', 1);
//                                }
//                            }
//                        })
//                        ->orderBy((isset($data['SortOrder']) && $data['SortOrder'] != "")?$data['SortOrder']:'id', 'DESC')
//                        ->get()->toArray();
//            }
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