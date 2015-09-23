<?php
namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Reservations
 * @package    Laravel 5.1.11
 * @subpackage Model
 * @author     Skp Software Technologies
 * @developer  Waqar Javed
 * @date       20 September, 2015
 */
class Reservations extends BaseModel {

    protected $table = 'reservations';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    /**
     * @param array
     * @return Array
     */
    public function populate($data) {
        $cells = array('restaurantId', 'menu_ids', 'prs', 'qtys', 'extras', 'listid', 'subtotal', 'g_total', 'cash_type', 'ordered_by', 'email', 'contact', 'payment_mode', 'address1', 'address2', 'city', 'province', 'postal_code', 'remarks', 'order_time', 'order_till', 'order_now', 'delivery_fee','tax', 'order_type', 'approved', 'cancelled');
        foreach($cells as $cell){
            if (array_key_exists($cell, $data)) {
                $this->$cell = $data[$cell];
            }
        }
    }
    
}