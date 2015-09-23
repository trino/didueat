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
        
        if (array_key_exists('name', $data)) {
            $this->name = $data['name'];
        }
        if (array_key_exists('alpha_2', $data)) {
            $this->alpha_2 = $data['alpha_2'];
        }
        if (array_key_exists('alpha_3', $data)) {
            $this->alpha_3 = $data['alpha_3'];
        }
    }
    
}