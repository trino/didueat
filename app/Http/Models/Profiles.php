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

    public function populate($data,$addlogo = false) {
        $cells = array('profile_type', 'restaurant_id', 'name', 'email', 'phone' => 'phone', 'mobile' => 'phone', 'password' => 'password', 'subscribed', 'ip_address', 'browser_name', 'browser_version', 'browser_platform', 'gmt', 'status');
        
        if((isset($data["mobile"]) && phonenumber(isset($data["mobile"])) && (!isset($data["phone"]) || !phonenumber($data["phone"]))) ){
            $data["phone"] = $data["mobile"];
        }
        
        if($addlogo){
            array_push($cells,'photo');
        }
        
 
        $browser_info = getBrowser();
        $data['ip_address'] = get_client_ip_server();
        $data['browser_name'] = $browser_info['name'];
        $data['browser_version'] = $browser_info['version'];
        $data['browser_platform'] = $browser_info['platform'];
        if(!$this->profile_type){$this->profile_type = 2;}
        $this->copycells($cells, $data);
    }

    public static function listing($array = "", $type = ""){
        //echo "<pre>".print_r($array)."</pre>"; exit();
        $searchResults = $array['searchResults'];
        $meta = $array['meta'];
        $order = $array['order'];
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
                ->orderBy($meta, $order);

        if ($type == "list") {
            $query->take($per_page);
            $query->skip($start);
        }
        return $query;
    }
}