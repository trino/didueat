<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * City
 * @package    Laravel 5.1.11
 * @subpackage Model
 * @author     Skp Software Technologies
 * @developer  Waqar Javed
 * @date       20 September, 2015
 */
class City extends BaseModel
{

    protected $table = 'cities';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function populate($data)
    {
        $cells = array('city', 'state_id', 'country_id');
        foreach ($cells as $cell) {
            if (array_key_exists($cell, $data)) {
                $this->$cell = $data[$cell];
            }
        }
    }

}