<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * ProfilesAddresses
 * @package    Laravel 5.1.11
 * @subpackage Model
 * @author     Skp Software Technologies
 * @developer  Waqar Javed
 * @date       20 September, 2015
 */
class ProfilesAddresses extends BaseModel
{

    protected $table = 'profiles_addresses';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * @param array
     * @return Array
     */
    public function populate($data)
    {
        $cells = array('user_id', 'location', 'address', 'phone_no', 'post_code', 'city', 'province', 'country');
        foreach ($cells as $cell) {
            if (array_key_exists($cell, $data)) {
                $this->$cell = $data[$cell];
            }
        }
    }

    ////////////////////////////////////////Profile Address API ////////////////////////////////////
    function enum_profile_addresses($profile_id)
    {
        return enum_all("profiles_addresses", array("user_id" => $profile_id));
    }

    function delete_profile_address($id)
    {
        delete_all("profiles_addresses", array("id" => $id));
    }

    function get_profile_address($id)
    {
        return get_entry("profiles_addresses", $id);
    }

    function edit_profile_address($id, $user_id, $address, $phone_no, $address, $city, $province, $post_code, $country)
    {
        $Data = array("user_id" => $user_id, "address" => $address, "phone_no" => clean_phone($phone_no), "address" => $address, "city" => $city, "province" => $province, "post_code" => clean_postalcode($post_code), "country" => $country);
        return edit_database("profiles_addresses", "id", $id, $Data);
    }


}