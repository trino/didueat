<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Countries extends BaseModel {

    protected $table = 'countries';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * @param array
     * @return Array
     */
    public function populate($data) {
        $cells = array('name', 'alpha_2', 'alpha_3');
        $this->copycells($cells, $data);
    }

}