<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;


class Postalcodes extends BaseModel {

    protected $table = 'postalcodes';
    protected $primaryKey = 'id';
    public $timestamps = true;

    /**
     * @param array
     * @return Array
     */
    public function populate($data) {
        $cells = array('postal_code', 'number', 'street', 'city', 'province', 'lattitude', 'longitude', 'short_street', 'short_street_type', 'short_street_dir');
        $this->copycells($cells, $data);
    }

}