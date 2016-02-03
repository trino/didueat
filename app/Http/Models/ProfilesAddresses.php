<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilesAddresses extends BaseModel {

    protected $table = 'profiles_addresses';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * @param array
     * @return Array
     */
    public function populate($data) {
        $cells = array('user_id', 'location', 'formatted_address', 'address', 'phone' => "phone",  'mobile' => "phone", 'postal_code' => "postalcode", 'apartment', 'city', 'province', 'country', 'order', 'latitude', 'longitude', 'notes');
        if(!isset($data["address"]) && isset($data["formatted_address"])){
            $data["address"] = $data["formatted_address"];
        }
        
        $this->copycells($cells, $data);
    }
    
    public static function listing($array = "", $type = "") {
        //echo "<pre>".print_r($array)."</pre>"; exit();
        $searchResults = $array['searchResults'];
        $meta = $array['meta'];
        $order = $array['order'];
        $per_page = $array['per_page'];
        $start = $array['start'];
        $query = ProfilesAddresses::select('*')->where('user_id', \Session::get('session_id'))
                ->Where(function($query) use ($searchResults) {
                    if($searchResults != ""){
                          $query->orWhere('location', 'LIKE', "%$searchResults%")
                                ->orWhere('mobile', 'LIKE', "%$searchResults%")
                                ->orWhere('postal_code', 'LIKE', "%$searchResults%")
                                ->orWhere('phone', 'LIKE', "%$searchResults%")
                                ->orWhere('apartment', 'LIKE', "%$searchResults%")
                                ->orWhere('address', 'LIKE', "%$searchResults%")
                                ->orWhere('notes', 'LIKE', "%$searchResults%")
                                ->orWhere('city', 'LIKE', "%$searchResults%");
                    }
                })
                ->orderBy($meta, $order);
        if ($type == "list") {
            $query->take($per_page);
            $query->skip($start);
        }

        return $query;
    }
}