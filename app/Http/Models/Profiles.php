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
        foreach($cells as $cell){
            if (array_key_exists($cell, $data)) {
                $this->$cell = $data[$cell];
            }
        }
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