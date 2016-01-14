<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilesImages extends BaseModel {

    protected $table = 'profiles_images';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * @param array
     * @return Array
     */
    public function populate($data) {
        $cells = array('user_id', 'restaurant_id', 'filename', 'title', 'order_id');
        $this->copycells($cells, $data);
    }
}