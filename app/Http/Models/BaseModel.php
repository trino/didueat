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
    protected $orderBy = '';
    protected $orderDirection = 'ASC';

    /**
     * Get a new query builder for the model's table.
     *
     * @param bool $ordered
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function newQuery($ordered = true) {
        $query = parent::newQuery();
        if (empty($ordered) || !$this->orderBy) {
            return $query;
        }
        return $query->orderBy($this->orderBy, $this->orderDirection);
    }

    //populate, and save a new entry
    public static function makenew($columns=false, $ID=0){
        $ob = self::findOrNew($ID);
        if(!$columns){$columns=\Input::all();}
        $ob->populate($columns);
        $ob->save();
        return $ob;
    }

    public function cleantext($text){
        return str_replace('"', "''", trim($text));
    }

    public function copycells($cells, $data){
        foreach ($cells as $key => $cell) {
            if(is_numeric($key)) {
                if (array_key_exists($cell, $data)) {
                    $this->$cell = $this->cleantext($data[$cell]);
                    $data[$cell] = $this->$cell;
                }
            } else {
                if (array_key_exists($key, $data)) {
                    $this->$key = $this->cleantext($data[$key]);
                    if($this->$key) {
                        switch ($cell) {
                            case "24hr":
                                if( strpos(strtolower($this->$key), "m") !== false ){
                                    $this->$key = converttime($this->$key);//convert 12hr time to 24hr time
                                }
                                break;
                            case "creditcard":
                                if (isvalid_creditcard($this->$key)){
                                    $this->$key = \Crypt::encrypt(filter_var($this->$key, FILTER_SANITIZE_NUMBER_INT));
                                } else {
                                    $this->$key = "";
                                }
                                break;
                            case "number":
                                $this->$key = filter_var($this->$key, FILTER_SANITIZE_NUMBER_FLOAT);
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
                        if($this->$key) {
                            $data[$key] = $this->$key;
                        } else {
                            $data["invalid-data"][] = $key;
                            $keys = array();
                            if(\Session::has('invalid-data')){
                                $keys = \Session::get('invalid-data');
                            }
                            if(!isset($keys[$key])) {
                                $keys[] = $key;
                            }
                            \Session::put('invalid-data', $keys);
                        }
                    }
                }
            }
        }

        return $data;
    }

    public function flash($success, $message, $title){
        \Session::flash('message', $message);
        \Session::flash('message-type', iif($success, 'alert-success', 'alert-danger'));
        \Session::flash('message-short', $title);
    }

    /**
     * Function generatePassword
     * This function will ENCRYPT AN EXISTING password
     * @param $password
     * @return encrypted string
     */

    public function encryptPassword($password) {
        if($password) {return encryptpassword($password);}
    }
}
