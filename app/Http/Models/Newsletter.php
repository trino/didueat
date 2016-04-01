<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends BaseModel {

    protected $table = 'newsletter';
    protected $primaryKey = 'id';
    public $timestamps = true;

    /**
     * @param array
     * @return Array
     */
    public function populate($data) {
        $cells = array('email', 'status', 'guid');
        $this->copycells($cells, $data);
    }
    
    public static function listing($array = "", $type = "", &$reccount = 0) {
        //echo "<pre>".print_r($array)."</pre>"; exit();
        $searchResults = $array['searchResults'];
        $meta = $array['meta'];
        $order = $array['order'];
        $per_page = $array['per_page'];
        $start = $array['start'];

        $query = Newsletter::select('*')
                ->Where(function($query) use ($searchResults) {
                    if($searchResults != ""){
                          $query->orWhere('email',      'LIKE', "%$searchResults%")
                                ->orWhere('created_at', 'LIKE', "%$searchResults%");
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