<?php
namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Genres
 * @package    Laravel 5.1.11
 * @subpackage Model
 * @author     Skp Software Technologies
 * @developer  Waqar Javed
 * @date       20 September, 2015
 */
class Genres extends BaseModel {

    protected $table = 'genres';
    protected $primaryKey = 'ID';
    public $timestamps = true;
    
    /**
     * @param array
     * @return Array
     */
    public function populate($data) {
        
        if (array_key_exists('name', $data)) {
            $this->name = $data['name'];
        }
        
    }
    
}