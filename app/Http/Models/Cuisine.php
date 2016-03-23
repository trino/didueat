<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Cuisine extends BaseModel {

    protected $table = 'cuisine';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $orderBy = 'name';
    protected $orderDirection = 'ASC';

    /**
     * @param array
     * @return Array
     */
    public function populate($data) {
        $cells = array('name', 'is_active');
        $this->copycells($cells, $data);
    }
}