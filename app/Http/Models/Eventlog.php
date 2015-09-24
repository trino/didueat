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
    protected $primaryKey = 'ID';
    public $timestamps = false;
    
    /**
     * @param array
     * @return Array
     */
    public function populate($data) {

        if (array_key_exists('UserID', $data)) {
            $this->UserID = $data['UserID'];
        }
        if (array_key_exists('Date', $data)) {
            $this->Date = $data['Date'];
        }
        if (array_key_exists('RestaurantID', $data)) {
            $this->RestaurantID = $data['RestaurantID'];
        }
        if (array_key_exists('Text', $data)) {
            $this->Text = $data['Text'];
        }
        
    }
    
}