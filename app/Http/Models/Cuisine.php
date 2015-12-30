<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Cuisine extends BaseModel {

    protected $table = 'cuisine';
    protected $primaryKey = 'id';
    public $timestamps = true;

    /**
     * @param array
     * @return Array
     */
    public function populate($data) {
        $cells = array('name', 'is_active');
        foreach ($cells as $cell) {
            if (array_key_exists($cell, $data)) {
                $this->$cell = $data[$cell];
            }
        }

    }


    //////////////////////////////////////Genre API//////////////////////////////////////
    function add_genre($name) {
        if (is_array($name)) {
            $Ret = array();
            foreach ($name as $Key => $Genre) {
                $Ret[$Genre] = $this->add_genre($Genre);
            }
            return $Ret;
        } else {
            if ($this->genre_exists($name)) {
                return false;
            }//don't allow duplicates
            new_anything("genres", array("name" => $name));
            return true;
        }
    }

    public static function genre_exists($name) {
        if (get_entry("genres", $name, "name")) {
            return true;
        }
    }

    function rename_genre($id, $new_name) {
        if ($this->genre_exists($new_name)) {
            return false;
        }
        update_database('genres', "id", $id, array("name" => $new_name));
        return true;
    }

    public static function enum_restaurants($Genre = "") {
        if ($Genre) {
            return enum_anything("restaurants", "genre", $Genre);
        }
        return enum_table("restaurants");
    }

    public static function enum_genres() {
        $entries = enum_all('genres');
        return my_iterator_to_array($entries, "id", "name");
    }

}