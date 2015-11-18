<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * RatingUsers
 * @package    Laravel 5.1.11
 * @subpackage Model
 * @author     Skp Software Technologies
 * @developer  Waqar Javed
 * @date       20 September, 2015
 */
class RatingUsers extends BaseModel
{

    protected $table = 'rating_user';
    protected $primaryKey = 'id';
    public $timestamps = true;

    /**
     * @param array
     * @return Array
     */
    public function populate($data)
    {
        $cells = array('user_id', 'target_id', 'rating_id', 'rating', 'comments');
        foreach ($cells as $cell) {
            if (array_key_exists($cell, $data)) {
                $this->$cell = $data[$cell];
            }
        }
    }

}