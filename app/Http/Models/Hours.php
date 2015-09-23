<?php
namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Hours
 * @package    Laravel 5.1.11
 * @subpackage Model
 * @author     Skp Software Technologies
 * @developer  Waqar Javed
 * @date       20 September, 2015
 */
class Hours extends BaseModel {

    protected $table = 'hours';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    
    /**
     * @param array
     * @return Array
     */
    public function populate($data) {

        if (array_key_exists('RestaurantID', $data)) {
            $this->RestaurantID = $data['RestaurantID'];
        }
        if (array_key_exists('DayOfWeek', $data)) {
            $this->DayOfWeek = $data['DayOfWeek'];
        }
        if (array_key_exists('Open', $data)) {
            $this->Open = $data['Open'];
        }
        if (array_key_exists('Close', $data)) {
            $this->Close = $data['Close'];
        }
    }
    
}