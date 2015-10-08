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
    protected $primaryKey = 'ID';
    public $timestamps = false;
    
    /**
     * @param array
     * @return Array
     */
    public function populate($data) {
        $cells = array('UserID', 'RestaurantID', 'Filename', 'Title', 'OrderID');
        foreach($cells as $cell) {
            if (array_key_exists($cell, $data)) {
                $this->$cell = $data[$cell];
            }
        }

        /*if (array_key_exists('UserID', $data)) {
            $this->UserID = $data['UserID'];
        }
        if (array_key_exists('RestaurantID', $data)) {
            $this->RestaurantID = $data['RestaurantID'];
        }
        if (array_key_exists('Filename', $data)) {
            $this->Filename = $data['Filename'];
        }
        if (array_key_exists('Title', $data)) {
            $this->Title = $data['Title'];
        }
        if (array_key_exists('OrderID', $data)) {
            $this->OrderID = $data['OrderID'];
        }*/
    }

    ////////////////////////////////////profile image API///////////////////////////////////
    function get_profile_image($Filename, $UserID = ""){
        if(!$UserID){$UserID = read("ID");}
        if (strpos($Filename, "/")){$Filename = pathinfo($Filename, PATHINFO_BASENAME);}
        return enum_all("profiles_images", array("UserID" => $UserID, "Filename" => $Filename))->first();
    }

    function delete_profile_image($Filename, $UserID = "") {
        if (!$UserID) {$UserID = read("ID");}
        if (strpos($Filename, "/")){$Filename = pathinfo($Filename, PATHINFO_BASENAME);}
        $dir = "img/users/" . $UserID . "/" . $Filename;
        if (file_exists($dir)) {unlink($dir);}
        delete_all("profiles_images", array("UserID" => $UserID, "Filename" => $Filename));
    }

    function edit_profile_image($UserID, $Filename, $RestaurantID, $Title, $OrderID){
        $Entry = $this->get_profile_image($Filename, $UserID);
        $Data = array("RestaurantID" => $RestaurantID, "Title" => $Title, "OrderID" => $OrderID);
        if($Entry){
            edit_database("profiles_images", "ID", $Entry->ID, $Data);
        } else {
            $Data["UserID"] = $UserID;
            $Data["Filename"] = $Filename;
            new_entry("profiles_images", "ID", $Data);
        }
    }


}