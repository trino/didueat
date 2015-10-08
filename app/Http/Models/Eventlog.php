<?php
namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Eventlog
 * @package    Laravel 5.1.11
 * @subpackage Model
 * @author     Skp Software Technologies
 * @developer  Waqar Javed
 * @date       20 September, 2015
 */
class Eventlog extends BaseModel {

    protected $table = 'eventlog';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    /**
     * @param array
     * @return Array
     */
    public function populate($data) {
        $cells = array('user_id', 'date', 'restaurant_id', 'text');
        foreach($cells as $cell) {
            if (array_key_exists($cell, $data)) {
                $this->$cell = $data[$cell];
            }
        }
        /*
        if (array_key_exists('user_id', $data)) {
            $this->user_id = $data['user_id'];
        }
        if (array_key_exists('date', $data)) {
            $this->date = $data['date'];
        }
        if (array_key_exists('restaurant_id', $data)) {
            $this->restaurant_id = $data['restaurant_id'];
        }
        if (array_key_exists('text', $data)) {
            $this->text = $data['text'];
        }
        */
    }

    public static function enum_events($restaurant_id = false){
        if(!$restaurant_id){ $restaurant_id = get_current_restaurant(); }
        return enum_all("eventlog", array("restaurant_id" => $restaurant_id));
    }


}