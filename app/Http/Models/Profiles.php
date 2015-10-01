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
                if(isset($data['password'])){
                    $this->generatePassword($data['password']);
                } else {
                    $this->$cell = $data[$cell];
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
        $this->salt = \App\Http\Models\Profiles::getSalt();
        $this->password = crypt($password, $this->salt);
    }
    
    /**
     * Function getSalt
     * This function will generate a random string
     * @param empty
     * @return encrypted string
     */
    public static function getSalt() {
        $cost = 10;
        $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
        $salt = sprintf("$2a$%02d$", $cost) . $salt;
        return $salt;
    }
}