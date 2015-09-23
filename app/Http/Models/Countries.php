<?php
namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Countries
 * @package    Laravel 5.1.11
 * @subpackage Model
 * @author     Skp Software Technologies
 * @developer  Waqar Javed
 * @date       20 September, 2015
 */
class Countries extends BaseModel {

    protected $table = 'countries';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    /**
     * @param array
     * @return Array
     */
    public function populate($data) {
        $cells = array('name', 'alpha_2', 'alpha_3');
        foreach($cells as $cell){
            if (array_key_exists($cell, $data)) {
                $this->$cell = $data[$cell];
            }
        }
    }
    
}