<?php
namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * NotificationAddresses
 * @package    Laravel 5.1.11
 * @subpackage Model
 * @author     Skp Software Technologies
 * @developer  Waqar Javed
 * @date       20 September, 2015
 */
class NotificationAddresses extends BaseModel {

    protected $table = 'notification_addresses';
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
        if (array_key_exists('Type', $data)) {
            $this->Type = $data['Type'];
        }
        if (array_key_exists('Address', $data)) {
            $this->Address = $data['Address'];
        }
        
    }
    
}