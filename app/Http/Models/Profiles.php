<?php
namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Profiles
 * @package    Laravel 5.1.11
 * @subpackage Model
 * @author     Skp Software Technologies
 * @developer  Waqar Javed
 * @date       20 September, 2015
 */ 
class Profiles extends BaseModel {

    protected $table = 'Profiles';
    protected $primaryKey = 'ID';
    public $timestamps = true;
    
    /**
     * @param array
     * @return Array
     */
    public function populate($data) {
        $cells = array('profileType', 'name', 'email', 'password', 'salt', 'phone', 'subscribed', 'restaurantId', 'createdBy', 'status', 'created_at', 'updated_at', 'deleted_at');
        foreach($cells as $cell) {
            if (array_key_exists($cell, $data)) {
                $this->$cell = $data[$cell];
                if(isset($data['password'])){
                    $this->generatePassword($data['password']);
                }
            }
        }

        /*
        if (array_key_exists('profileType', $data)) {
            $this->profileType = $data['profileType'];
        }
        if (array_key_exists('name', $data)) {
            $this->name = $data['name'];
        }
        if (array_key_exists('email', $data)) {
            $this->email = $data['email'];
        }
        if (array_key_exists('password', $data)) {
            $this->generatePassword($data['password']);
        }
        if (array_key_exists('salt', $data)) {
            $this->salt = $data['salt'];
        }
        if (array_key_exists('phone', $data)) {
            $this->phone = $data['phone'];
        }
        if (array_key_exists('subscribed', $data)) {
            $this->subscribed = $data['subscribed'];
        }
        if (array_key_exists('restaurantId', $data)) {
            $this->restaurantId = $data['restaurantId'];
        }
        if (array_key_exists('createdBy', $data)) {
            $this->createdBy = $data['createdBy'];
        }
        if (array_key_exists('status', $data)) {
            $this->status = $data['status'];
        }
        if (array_key_exists('created_at', $data)) {
            $this->created_at = $data['created_at'];
        }
        if (array_key_exists('updated_at', $data)) {
            $this->updated_at = $data['updated_at'];
        }
        if (array_key_exists('deleted_at', $data)) {
            $this->deleted_at = $data['deleted_at'];
        }*/
    }
    
    /**
     * Function generatePassword
     * This function will generate a random string for encrypted passwords
     * @param $password
     * @return encrypted string
     */
    public function generatePassword($password) {
        $this->password = encryptpassword($password);
    }
    
    /**
     * Function getSalt
     * This function will generate a random string
     * @param empty
     * @return encrypted string
     */
    public static function getSalt() {
        return salt();

        $cost = 10;
        $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
        $salt = sprintf("$2a$%02d$", $cost) . $salt;
        return $salt;
    }



    function edit_profile($ID, $Name, $EmailAddress, $Phone, $Password, $Subscribed = 0, $ProfileType = 0){
        $data = array("Name" => trim($Name), "Email" => clean_email($EmailAddress), "Phone" => clean_phone($Phone), "Subscribed" => $Subscribed);
        if($Password){
            $data["Password"] = encryptpassword($Password);
        }
        if($ProfileType){
            $data["ProfileType"] = $ProfileType;
        }
        set_subscribed($EmailAddress,$Subscribed);
        return update_database("profiles", "ID", $ID, $data);
    }

    function forgot_password($Email, $Password=""){
        $Email = clean_email($Email);
        $Profile = get_entry("profiles", $Email, "Email");
        if ($Profile){
            if(!$Password) {$Password = randomPassword();}
            $Encrypted = encryptpassword($Password);
            update_database("profiles", "ID", $Profile->ID, array("Password" => $Encrypted));
            return $Password;
        }
    }

    function find_profile($EmailAddress, $Password){
        $EmailAddress = clean_email($EmailAddress);
        $Password =  encryptpassword($Password);
        $ProfileMatch = enum_all("profiles", array("Email" => $EmailAddress, "Password" => $Password));
        return first($ProfileMatch);
    }

    function new_profile($CreatedBy, $Name, $Password, $ProfileType, $EmailAddress, $Phone, $RestaurantID, $Subscribed = ""){
        $EmailAddress = is_valid_email($EmailAddress);
        $Phone=clean_phone($Phone);
        if(!$EmailAddress){return false;}
        if(get_entry("profiles", $EmailAddress, "Email")){return false;}
        if(!$Password){$Password=randomPassword();}
        if($Subscribed){$Subscribed=1;} else {$Subscribed =0;}
        $Encrypted =  encryptpassword($Password);
        $data = array("Name" => trim($Name), "ProfileType" => $ProfileType, "Phone" => $Phone, "Email" => $EmailAddress, "CreatedBy" => 0, "RestaurantID" => $RestaurantID, "Subscribed" => $Subscribed, "Password" => $Encrypted);
        if($CreatedBy){
            if(!can_profile_create($CreatedBy, $ProfileType)){return false;}//blocks users from creating users of the same type
            $data["CreatedBy"] = $CreatedBy;
        }
        $data = edit_database("profiles", "ID", "", $data);
        $data["Password"] = $Password;
        if($CreatedBy){
            logevent("Created user: " . $data["ID"] . " (" . $data["Name"] . ")");
        }

        handleevent($EmailAddress, "new_profile", array("Profile" => $data));
        set_subscribed($EmailAddress,$Subscribed);
        return $data;
    }

}