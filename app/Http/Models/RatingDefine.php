<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;


class RatingDefine extends BaseModel {

    protected $table = 'rating_define';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * @param array
     * @return Array
     */
    public function populate($data) {
        $cells = array('title', 'type', 'is_active');
        foreach ($cells as $cell) {
            if (array_key_exists($cell, $data)) {
                $this->$cell = $data[$cell];
            }
        }
    }

}