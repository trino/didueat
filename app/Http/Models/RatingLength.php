<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * RatingLength
 * @package    Laravel 5.1.11
 * @subpackage Model
 * @author     Skp Software Technologies
 * @developer  Waqar Javed
 * @date       20 September, 2015
 */
class RatingLength extends BaseModel
{

    protected $table = 'rating_length';
    public $timestamps = false;

    /**
     * @param array
     * @return Array
     */
    public function populate($data)
    {
        $cells = array('rating_length');
        foreach ($cells as $cell) {
            if (array_key_exists($cell, $data)) {
                $this->$cell = $data[$cell];
            }
        }
    }

}