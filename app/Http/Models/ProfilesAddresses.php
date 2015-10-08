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
    protected $primaryKey = 'ID';
    public $timestamps = false;
    
    /**
     * @param array
     * @return Array
     */
    public function populate($data) {
        $cells = array('UserID', 'Number', 'Apt', 'Buzz', 'PostCode', 'PhoneNo', 'Street', 'City', 'Province', 'Country', 'Notes');
        foreach($cells as $cell) {
            if (array_key_exists($cell, $data)) {
                $this->$cell = $data[$cell];
            }
        }
        /*
        if (array_key_exists('UserID', $data)) {
            $this->UserID = $data['UserID'];
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
    function enum_profile_addresses($ProfileID){
        return enum_all("profiles_addresses", array("UserID" => $ProfileID));
    }
    function delete_profile_address($ID){
        delete_all("profiles_addresses", array("ID" => $ID));
    }
    function get_profile_address($ID){
        return get_entry("profiles_addresses", $ID);
    }
    function edit_profile_address($ID, $UserID, $Name, $Phone, $Number, $Street, $Apt, $Buzz, $City, $Province, $PostalCode, $Country, $Notes){
        $Data = array("UserID" => $UserID, "Name" => $Name, "Phone" => clean_phone($Phone), "Number" => $Number, "Street" => $Street, "Apt" => $Apt, "Buzz" => $Buzz, "City" => $City, "Province" => $Province, "PostalCode" => clean_postalcode($PostalCode), "Country" =>$Country, "Notes" =>$Notes);
        return edit_database("profiles_addresses", "ID", $ID, $Data);
    }



}