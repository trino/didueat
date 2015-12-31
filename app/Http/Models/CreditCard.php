<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class CreditCard extends BaseModel {
    protected $table = 'credit_cards';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function populate($data) {
        $cells = array('first_name'     => true,
                       'user_type'      => false,
                       'profile_id'     => false,
                       'last_name'      => true,
                       'card_type'      => false,
                       'card_number'    => true,
                       'expiry_date'    => true,
                       'expiry_month'   => true,
                       'expiry_year'    => true,
                       'ccv'            => true,
                       'order'          => false,
        );
        foreach ($cells as $cell => $NeedsEncryption) {
            if (array_key_exists($cell, $data)) {
                if($NeedsEncryption){
                    $data[$cell] = \Crypt::encrypt($data[$cell]);
                    //use \Crypt::decrypt($encryptedValue); to decrypt
                }
                $this->$cell = $data[$cell];
            }
        }
    }
    
    public static function listing($array = "", $type = "") {
        $query_type = $array['type'];
        $searchResults = $array['searchResults'];
        $meta = $array['meta'];
        $order = $array['order'];
        $per_page = $array['per_page'];
        $start = $array['start'];

        $query = CreditCard::select('*')
                ->Where(function($query) use ($searchResults, $query_type) {
                    if($query_type == 'user'){
                        //$query->where('user_type', $query_type);
                        debugprint("Userid: " .  read('id'));
                        $query->where('user_id', read('id'));//see it's a one
                        //sql becomes: select * from `credit_cards` where (`user_id` = ?) order by `order` asc limit 10 offset 0
                    }
                    if($query_type == 'restaurant'){
                        $query->where('user_type', $query_type);
                        $query->where('user_id', \Session::get('session_restaurant_id'));
                    }
                    
                    if($searchResults != ""){
                        debugprint("searchResults: " .  $searchResults);
                        $query->orWhere('first_name',     'LIKE',     "%$searchResults%")
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

        if ($type == "list") {
            $query->take($per_page);
            $query->skip($start);
        }

        debugprint("SQL : " . $query->toSql() );

        return $query;
    }
    
    
}