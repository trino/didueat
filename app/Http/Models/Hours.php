<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Hours extends BaseModel {

    protected $table = 'hours';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * @param array
     * @return Array
     */
    public function populate($data) {
        $cells = array('restaurant_id', 'day_of_week', 'open', 'close', 'open_del', 'close_del');
        $this->copycells($cells, $data);
    }
}