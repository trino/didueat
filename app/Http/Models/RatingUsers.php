<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class RatingUsers extends BaseModel {

    protected $table = 'rating_users';
    protected $primaryKey = 'id';
    public $timestamps = true;

    /**
     * @param array
     * @return Array
     */
    public function populate($data) {
        $cells = array('user_id', 'target_id', 'rating_id', 'rating', 'comments', 'type');
        $this->copycells($cells, $data);
    }
    
    public static function listing($array = "", $type = "") {
        //echo "<pre>".print_r($array)."</pre>"; exit();
        $searchResults = $array['searchResults'];
        $meta = $array['meta'];
        $order = $array['order'];
        $per_page = $array['per_page'];
        $start = $array['start'];

        $query = RatingUsers::select('*')
                ->Where(function($query) use ($searchResults) {
                    if($searchResults != ""){
                          $query->orWhere('type', 'LIKE', "%$searchResults%")
                                ->orWhere('comments', 'LIKE', "%$searchResults%")
                                ->orWhere('rating', 'LIKE', "%$searchResults%")
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