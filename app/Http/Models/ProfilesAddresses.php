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
class ProfilesAddresses extends BaseModel {

    protected $table = 'profiles_addresses';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    /**
     * @param array
     * @return Array
     */
    public function populate($data) {
        $cells = array('user_id', 'number', 'apt', 'buzz', 'post_code', 'phone_no', 'street', 'city', 'province', 'country', 'notes');
        foreach($cells as $cell) {
            if (array_key_exists($cell, $data)) {
                $this->$cell = $data[$cell];
            }
        }
        /*
        if (array_key_exists('user_id', $data)) {
            $this->user_id = $data['user_id'];
        }
        if (array_key_exists('Number', $data)) {
            $this->Number = $data['Number'];
        }
        if (array_key_exists('Apt', $data)) {
            $this->Apt = $data['Apt'];
        }
        if (array_key_exists('Buzz', $data)) {
            $this->Buzz = $data['Buzz'];
        }
        if (array_key_exists('PostCode', $data)) {
            $this->PostCode = $data['PostCode'];
        }
        if (array_key_exists('PhoneNo', $data)) {
            $this->PhoneNo = $data['PhoneNo'];
        }
        if (array_key_exists('Street', $data)) {
            $this->Street = $data['Street'];
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
        if (array_key_exists('Notes', $data)) {
            $this->Notes = $data['Notes'];
        }*/
    }

    ////////////////////////////////////////Profile Address API ////////////////////////////////////
    function enum_profile_addresses($profile_id){
        return enum_all("profiles_addresses", array("user_id" => $profile_id));
    }
    function delete_profile_address($id){
        delete_all("profiles_addresses", array("id" => $id));
    }
    function get_profile_address($id){
        return get_entry("profiles_addresses", $id);
    }
    function edit_profile_address($id, $user_id, $name, $phone, $number, $street, $apt, $buzz, $city, $province, $postal_code, $country, $notes){
        $Data = array("user_id" => $user_id, "name" => $name, "phone" => clean_phone($phone), "number" => $number, "street" => $street, "apt" => $apt, "buzz" => $buzz, "city" => $city, "province" => $province, "postal_code" => clean_postalcode($postal_code), "country" =>$country, "notes" =>$notes);
        return edit_database("profiles_addresses", "id", $id, $Data);
    }



}