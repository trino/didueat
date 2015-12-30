<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class RatingUsers extends BaseModel {

    protected $table = 'rating_users';
    protected $primaryKey = 'id';
    public $timestamps = true;

    /**
     * @param array
     * @return Array
     */
    public function populate($data) {
        $cells = array('user_id', 'target_id', 'rating_id', 'rating', 'comments', 'type');
        foreach ($cells as $cell) {
            if (array_key_exists($cell, $data)) {
                $this->$cell = $data[$cell];
            }
        }
    }

}