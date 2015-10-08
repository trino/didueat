<?php
namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Genres
 * @package    Laravel 5.1.11
 * @subpackage Model
 * @author     Skp Software Technologies
 * @developer  Waqar Javed
 * @date       20 September, 2015
 */
class Genres extends BaseModel {

    protected $table = 'genres';
    protected $primaryKey = 'ID';
    public $timestamps = true;
    
    /**
     * @param array
     * @return Array
     */
    public function populate($data) {
        $cells = array('name');
        foreach($cells as $cell) {
            if (array_key_exists($cell, $data)) {
                $this->$cell = $data[$cell];
            }
        }

        /* if (array_key_exists('name', $data)) {
            $this->name = $data['name'];
        }*/
        
    }


    //////////////////////////////////////Genre API//////////////////////////////////////
    function add_genre($Name){
        if(is_array($Name)){
            $Ret=array();
            foreach($Name as $Key => $Genre){
                $Ret[$Genre] = $this->add_genre($Genre);
            }
            return $Ret;
        } else {
            if($this->genre_exists($Name)){return false;}//don't allow duplicates
            new_anything("genres", array("Name" => $Name));
            return true;
        }
    }

    public static function genre_exists($Name){
        if(get_entry("genres", $Name, "Name")){return true;}
    }

    function rename_genre($ID, $NewName){
        if($this->genre_exists($NewName)){return false;}
        update_database('genres', "ID", $ID, array("Name" => $NewName));
        return true;
    }
    public static function enum_restaurants($Genre = ""){
        if($Genre) {
            return enum_anything("restaurants", "Genre", $Genre);
        }
        return enum_table("restaurants");
    }

    public static function enum_genres(){
        $entries = enum_all('genres');
        return my_iterator_to_array($entries, "ID", "Name");
    }

}