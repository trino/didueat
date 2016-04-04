<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationAddresses extends BaseModel {

    protected $table = 'notification_addresses';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * @param array
     * @return Array
     */
    public function populate($data) {
        $cells = array( 'user_id', 'address', 'is_default', 'is_call', 'is_sms', 'type', 'order', 'note');
        $this->copycells($cells, $data);  
    }
    
    public static function listing($array = "", $type = "", &$reccount = 0) {
        //echo "<pre>".print_r($array)."</pre>"; exit();
        $searchResults = $array['searchResults'];
        $meta = $array['meta'];
        $order = $array['order'];
        $per_page = $array['per_page'];
        $start = $array['start'];

        $query = NotificationAddresses::select('*')->where('user_id', \Session::get('session_id'))
                ->Where(function($query) use ($searchResults) {
                    if($searchResults != ""){
                          $query->orWhere('address',    'LIKE', "%$searchResults%")
                                ->orWhere('note',       'LIKE', "%$searchResults%")
                                ->orWhere('type',       'LIKE', "%$searchResults%");
                    }
                })
                ->orderBy($meta, $order);
        $reccount = $query->count();
        if ($type == "list") {
            $query->take($per_page);
            $query->skip($start);
        }
        return $query;
    }

}