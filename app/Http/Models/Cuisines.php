<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Cuisines extends BaseModel {
    protected $table = 'cuisines';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * @param array
     * @return Array
     */

    public function populate($data) {
        $cells=array('restID','cuisine');
        $this->copycells($cells, $data);
    }
}