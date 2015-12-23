<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;


class City extends BaseModel {

    protected $table = 'cities';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function populate($data) {
        $cells = array('city', 'state_id', 'country_id');
        foreach ($cells as $cell) {
            if (array_key_exists($cell, $data)) {
                $this->$cell = $data[$cell];
            }
        }
    }

}