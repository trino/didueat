<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Drivers extends BaseModel {

    protected $table = 'drivers';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * @param array
     * @return Array
     */
    public function populate($data) {
        
        $cells = array('name', 'email', 'mobile' => "phone", 'website', 'formatted_address', 'address', 'apartment', 'city' => "ucfirst", 'province' => "ucfirst", 'country' => "ucfirst", 'postal_code' => "postalcode", 'latitude', 'longitude');
        if(!isset($data["open"])){$data["open"] = 0;}
        if(isset($data["formatted_address"]) && !$data["formatted_address"]){unset($data["formatted_address"]);}
        

        $this->copycells($cells, $data);

        
    }

    
    
    public function save(array $options = array()) {
        $ret=false;
        if($this->is_complete) {
            $OldData = select_field("drivers", "id", $this->id);
            //check for changes in the phone number and email address
            
        }
        parent::save($options);
        return $ret;
    }
}