<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Profiles extends BaseModel {

    protected $table = 'profiles';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $hidden = array('password');

    /**
     * @param array
     * @return Array
     */

    public function populate($data) {
    
// requires associative array for phone, mobile, password so that copycells will know to modify
       $cells = array('profile_type', 'restaurant_id', 'name', 'email', 'phone' => 'phone', 'mobile' => 'phone', 'password' => 'password', 'subscribed', 'ip_address', 'browser_name', 'browser_version', 'browser_platform', 'gmt', 'status', 'photo');
        
        if((isset($data["mobile"]) && phonenumber(isset($data["mobile"])) && (!isset($data["phone"]) || !phonenumber($data["phone"]))) ){
            $data["phone"] = $data["mobile"];
        }

        $this->copycells($cells, $data);
    }

    public static function listing($array = "", $type = "") {
        //echo "<pre>".print_r($array)."</pre>"; exit();
        $searchResults = $array['searchResults'];

      //  var_dump($array);die();
        $meta = $array['meta'];
      //  $order = $array['email'];
        $per_page = $array['per_page'];
        $start = $array['start'];

        $query = Profiles::select('*')
                ->Where(function($query) use ($searchResults){
                    if($searchResults != ""){
                          $query->orWhere('name', 'LIKE', "%$searchResults%")
                                ->orWhere('email', 'LIKE', "%$searchResults%")
                                ->orWhere('created_at', 'LIKE', "%$searchResults%");
                    }
                })
               ;

        if ($type == "list") {
            $query->take($per_page);
            $query->skip($start);
        }
        return $query;
    }
}