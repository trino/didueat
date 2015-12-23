<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class States extends BaseModel
{

    protected $table = 'states';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * @param array
     * @return Array
     */


    public function populate($data)
    {
        $cells = array('name', 'abbreviation', 'country_id', 'type', 'is_active');
        foreach ($cells as $cell) {
            if (array_key_exists($cell, $data)) {
                $this->$cell = $data[$cell];
            }
        }
    }

}