<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class CreditCard extends BaseModel {
    protected $table = 'credit_cards';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function populate($data) {
        $cells = array('first_name', 'user_type', 'user_id', 'last_name', 'card_number' => "creditcard", 'expiry_date' => "encrypted", 'expiry_month' => "encrypted", 'expiry_year' => "encrypted", 'ccv' => "encrypted", 'order');
        $this->card_type = isvalid_creditcard($data['card_number']);
        $this->copycells($cells, $data);
        if(isset($this->user_type) && $this->user_type == "restaurant"){
            $this->user_id = \Session::get('session_restaurant_id');
        } else {
            $this->user_type = "user";
            if(!isset($this->user_id) || !$this->user_id) {$this->user_id = read("id");}
            if(!isset($this->first_name) || !$this->first_name) {$this->first_name = read("name");}
        }
    }
    
    public static function listing($array = "", $type = "", &$reccount = 0) {
        $query_type = $array['type'];
        $searchResults = $array['searchResults'];
        $meta = $array['meta'];
        $order = $array['order'];
        $per_page = $array['per_page'];
        $start = $array['start'];

        $query = CreditCard::select('*')
                ->Where(function($query) use ($query_type) {
                    $query->where('user_type', $query_type);
                    if($query_type == 'user'){
                        $query->where('user_id', read('id'));
                    } else if($query_type == 'restaurant'){
                        $query->where('user_id', \Session::get('session_restaurant_id'));
                    }
                })
                ->Where(function($query) use ($searchResults) {                    
                    if($searchResults != ""){
                        debugprint("searchResults: " .  $searchResults);
                        $query->orWhere('first_name',       'LIKE',     "%$searchResults%")
                                ->orWhere('last_name',      'LIKE',     "%$searchResults%")
                                ->orWhere('card_type',      'LIKE',     "%$searchResults%")
                                ->orWhere('card_number',    'LIKE',     "%$searchResults%")
                                ->orWhere('ccv',            'LIKE',     "%$searchResults%")
                                ->orWhere('expiry_date',    'LIKE',     "%$searchResults%")
                                ->orWhere('expiry_month',   'LIKE',     "%$searchResults%")
                                ->orWhere('expiry_year',    'LIKE',     "%$searchResults%");
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