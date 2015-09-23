<?php
namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Newsletter
 * @package    Laravel 5.1.11
 * @subpackage Model
 * @author     Skp Software Technologies
 * @developer  Waqar Javed
 * @date       20 September, 2015
 */
class Newsletter extends BaseModel {

    protected $table = 'newsletter';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    
    /**
     * @param array
     * @return Array
     */
    public function populate($data) {

        if (array_key_exists('Email', $data)) {
            $this->Email = $data['Email'];
        }
        if (array_key_exists('GUID', $data)) {
            $this->GUID = $data['GUID'];
        }
    }
    
}