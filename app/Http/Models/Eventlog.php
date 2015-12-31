<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;


class Eventlog extends BaseModel {

    protected $table = 'eventlog';
    protected $primaryKey = 'id';
    public $timestamps = true;

    /**
     * @param array
     * @return Array
     */
    public function populate($data) {
        $cells = array('user_id', 'restaurant_id', 'type', 'text');
        foreach ($cells as $cell) {
            if (array_key_exists($cell, $data)) {
                $this->$cell = $data[$cell];
            }
        }
    }
    
    public static function listing($array = "", $type = "") {
        //echo "<pre>".print_r($array)."</pre>"; exit();
        $searchResults = $array['searchResults'];
        $meta = $array['meta'];
        $order = $array['order'];
        $per_page = $array['per_page'];
        $start = $array['start'];

        $query = Eventlog::select('*')
                ->Where(function($query) use ($searchResults) {
                    if($searchResults != ""){
                          $query->orWhere('type', 'LIKE', "%$searchResults%")
                                ->orWhere('text', 'LIKE', "%$searchResults%")
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

    public static function enum_events($restaurant_id = false) {
        if (!$restaurant_id) {
            $restaurant_id = get_current_restaurant();
        }
        return enum_all("eventlog", array("restaurant_id" => $restaurant_id));
    }


}