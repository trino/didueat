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
        $cells = array('user_id', 'location', 'address', 'phone' => "phone",  'mobile' => "mobile", 'postal_code' => "postalcode", 'apartment', 'buzz', 'city', 'province', 'country', 'order', 'latitude', 'longitude', 'notes');
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
                                ->orWhere('buzz', 'LIKE', "%$searchResults%")
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