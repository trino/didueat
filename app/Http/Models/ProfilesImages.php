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

        if (array_key_exists('UserID', $data)) {
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
        }
    }
    
}