<?php
namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Restaurants
 * @package    Laravel 5.1.11
 * @subpackage Model
 * @author     Skp Software Technologies
 * @developer  Waqar Javed
 * @date       20 September, 2015
 */
class Restaurants extends BaseModel {

    protected $table = 'restaurants';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    
    /**
     * @param array
     * @return Array
     */
    public function populate($data) {
        $cells = array('Name', 'Slug', 'Genre', 'Email', 'Phone', 'Address', 'City', 'Province', 'Country', 'PostalCode', 'Description', 'Logo', 'DeliveryFee', 'Minimum', 'Status');
        foreach($cells as $cell){
            if (array_key_exists($cell, $data)) {
                $this->$cell = $data[$cell];
            }
        }
    }
    
}