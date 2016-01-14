<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends BaseModel
{

    protected $table = 'tags';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function populate($data) {
        $cells = array('name', 'is_active');
        $this->copycells($cells, $data);
    }

}