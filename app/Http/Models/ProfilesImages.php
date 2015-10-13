<?php
namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * ProfilesImages
 * @package    Laravel 5.1.11
 * @subpackage Model
 * @author     Skp Software Technologies
 * @developer  Waqar Javed
 * @date       20 September, 2015
 */
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
        foreach($cells as $cell) {
            if (array_key_exists($cell, $data)) {
                $this->$cell = $data[$cell];
            }
        }

        /*if (array_key_exists('user_id', $data)) {
            $this->user_id = $data['user_id'];
        }
        if (array_key_exists('restaurant_id', $data)) {
            $this->restaurant_id = $data['restaurant_id'];
        }
        if (array_key_exists('filename', $data)) {
            $this->filename = $data['filename'];
        }
        if (array_key_exists('Title', $data)) {
            $this->Title = $data['Title'];
        }
        if (array_key_exists('OrderID', $data)) {
            $this->OrderID = $data['OrderID'];
        }*/
    }

    ////////////////////////////////////profile image API///////////////////////////////////
    function get_profile_image($filename, $user_id = ""){
        if(!$user_id){$user_id = read("ID");}
        if (strpos($filename, "/")){$filename = pathinfo($filename, PATHINFO_BASENAME);}
        return enum_all("profiles_images", array("user_id" => $user_id, "filename" => $filename))->first();
    }

    function delete_profile_image($filename, $user_id = "") {
        if (!$user_id) {$user_id = read("ID");}
        if (strpos($filename, "/")){$filename = pathinfo($filename, PATHINFO_BASENAME);}
        $dir = "img/users/" . $user_id . "/" . $filename;
        if (file_exists($dir)) {unlink($dir);}
        delete_all("profiles_images", array("user_id" => $user_id, "filename" => $filename));
    }

    function edit_profile_image($user_id, $filename, $restaurant_id, $Title, $OrderID){
        $Entry = $this->get_profile_image($filename, $user_id);
        $Data = array("restaurant_id" => $restaurant_id, "title" => $Title, "order_id" => $OrderID);
        if($Entry){
            edit_database("profiles_images", "ID", $Entry->ID, $Data);
        } else {
            $Data["user_id"] = $user_id;
            $Data["filename"] = $filename;
            new_entry("profiles_images", "ID", $Data);
        }
    }


}