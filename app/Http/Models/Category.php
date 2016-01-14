<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends BaseModel {

    protected $table = 'category';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function populate($data) {
        $cells = array('title', 'display_order', 'res_id');
        $this->copycells($cells, $data);
    }

}