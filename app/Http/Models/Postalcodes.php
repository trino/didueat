<?php
namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Postalcodes
 * @package    Laravel 5.1.11
 * @subpackage Model
 * @author     Skp Software Technologies
 * @developer  Waqar Javed
 * @date       20 September, 2015
 */
class Postalcodes extends BaseModel {

    protected $table = 'postalcodes';
    protected $primaryKey = 'ID';
    public $timestamps = true;
    
    /**
     * @param array
     * @return Array
     */
    public function populate($data) {
        $cells = array('PostalCode', 'Number', 'Street', 'City', 'Province', 'Lattitude', 'Longitude', 'ShortStreet', 'ShortStreetType', 'ShortStreetDir');
        foreach($cells as $cell){
            if (array_key_exists($cell, $data)) {
                $this->$cell = $data[$cell];
            }
        }
    }
    
}