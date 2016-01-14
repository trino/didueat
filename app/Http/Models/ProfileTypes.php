<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileTypes extends BaseModel {

    protected $table = 'profiletypes';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * @param array
     * @return Array
     */
    public function populate($data) {
        $cells = array('name', 'hierarchy', 'can_create_profiles', 'can_edit_global_settings', 'can_hire_or_fire', 'can_possess');
        $this->copycells($cells, $data);
    }
}