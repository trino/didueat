<?php
namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Base Model
 * @package    Laravel 5.1
 * @subpackage Model
 * @author     PDL-Fireplay

 * @date       13 July, 2015
 */
class BaseModel extends Model {
    //populate, and save a new entry
    public static function makenew($columns){
        $ob = self::findOrNew(0);
        $ob->populate($columns);
        $ob->save();
        return $ob;
    }

    public function copycells($cells, $data){
        foreach ($cells as $key => $cell) {
            if(is_numeric($key)) {
                if (array_key_exists($cell, $data)) {
                    $this->$cell = trim($data[$cell]);
                }
            } else {
                if (array_key_exists($key, $data)) {
                    $this->$key = trim($data[$key]);
                    switch($cell){
                        case "phone":
                            $this->$key = phonenumber($this->$key);
                            break;
                        case "postalcode":
                            $this->$key = clean_postalcode($this->$key);
                            break;
                        case "encrypted":
                            $this->$key = \Crypt::encrypt($this->$key);
                            break;
                        case "password":
                            $this->$key = $this->encryptPassword($this->$key);
                            break;
                    }
                }
                if(!isset($this->$key) || !$this->$key) {//empty or doesn't exist
                    switch ($cell) {
                        case "guid":
                            $this->$key = guidv4();
                            break;
                    }
                }
            }
        }
    }

    /**
     * Function generatePassword
     * This function will ENCRYPT AN EXISTING password
     * @param $password
     * @return encrypted string
     */

    public function encryptPassword($password) {
        if($password) {return \bcrypt($password);}
    }
}
