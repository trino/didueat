<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;


class Reservations extends BaseModel {

    protected $table = 'reservations';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * @param array
     * @return Array
     */
    public function populate($data, $Key = false) {
        //var_dump($data);
        $cells = array('restaurant_id', 'menu_ids', 'prs', 'qtys', 'extras', 'listid', 'subtotal', 'g_total', 'cash_type', 'ordered_by', 'contact', 'payment_mode', 'address1', 'address2', 'city', 'province', 'country', 'postal_code', 'remarks', 'order_time', 'order_till', 'order_now', 'delivery_fee', 'tax', 'order_type', 'status', 'note', 'user_id', 'time', 'csr');
        $this->copycells($cells, $data);
        if(!isset($this->user_id) || !$this->user_id){$this->user_id = read("id");}
        if(isset($data["restaurant_id"]) && ( !isset($this->guid) || !$this->guid ) ) {
            $this->guid = $this->guid($data["restaurant_id"]) . iif($data['order_type'] == '1', "-D", "-P");
        }
    }

    public function guid($restaurantID){
        $restaurant = get_entry("restaurants", $restaurantID);
        //$today = date("ymd");
        $OrderID = $restaurant->lastorder_id + 1; //iif($restaurant->lastorder_date == $today, $restaurant->lastorder_id, 0) + 1;
        edit_database("restaurants", "id", $restaurantID, array("lastorder_id" => $OrderID));//, "lastorder_date" => $today));
        return $restaurantID . "-" . $OrderID;
    }
    
    public static function listing($array = "", $type = "", &$reccount = 0) {
        //echo "<pre>".print_r($array)."</pre>"; exit();
        $query_type = $array['type'];
        $searchResults = $array['searchResults'];
        $meta = $array['meta'];
        $order = $array['order'];
        $per_page = $array['per_page'];
        $start = $array['start'];
        
        $query = Reservations::select('*')
                ->Where(function($query) use ($query_type, $array) {
                    $userid=\Session::get('session_id');
                    $restaurantid=\Session::get('session_restaurant_id');
                    if(isset($array['id'])){
                        $userid=$array['id'];
                        $restaurantid=$array['id'];
                    }
                    if($query_type == 'user'){
                        $query->where('user_id', $userid);
                    }
                    if($query_type == 'restaurant'){
                        $query->where('restaurant_id', $restaurantid);
                    }
                })
                ->Where(function($query) use ($searchResults) {
                    if($searchResults != ""){
                          $query->orWhere('id', '=', $searchResults)
                                ->orWhere('ordered_by',     'LIKE', "%$searchResults%")
                                ->orWhere('contact',        'LIKE', "%$searchResults%")
                                ->orWhere('payment_mode',   'LIKE', "%$searchResults%")
                                ->orWhere('address1',       'LIKE', "%$searchResults%")
                                ->orWhere('address2',       'LIKE', "%$searchResults%")
                                ->orWhere('city',           'LIKE', "%$searchResults%")
                                ->orWhere('postal_code',    'LIKE', "%$searchResults%")
                                ->orWhere('note',           'LIKE', "%$searchResults%")
                                ->orWhere('status',         'LIKE', "%$searchResults%")
                                ->orWhere('remarks',        'LIKE', "%$searchResults%");
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

    function new_order($menu_ids, $prs, $qtys, $extras, $listid, $order_type, $delivery_fee, $res_id, $subtotal, $g_total, $tax) {
        $Data = array();
        $Data['menu_ids'] = implode_data($menu_ids);
        $Data['prs'] = implode_data($prs);
        $Data['qtys'] = implode_data($qtys);
        $Data['extras'] = implode_data($extras);
        $Data['listid'] = implode_data($listid);
        $Data['delivery_fee'] = $delivery_fee;

        date_default_timezone_set('Canada/Eastern');
        $Data['order_time'] = new \DateTime('NOW');
        $Data['res_id'] = $res_id;
        $Data['subtotal'] = $subtotal;
        $Data['g_total'] = $g_total;
        $Data['tax'] = $tax;

        if ($order_type == '0') {
            $order_type = "0.00";
        }
        $Data['order_type'] = $order_type;

        //convert to a Manager API call
        $ord = TableRegistry::get('reservations');
        $att = $ord->newEntity($Data);
        $ord->save($att);
        return $att->id;
    }

    function edit_order_profile($OrderID, $email, $address2, $city, $ordered_by, $postal_code, $remarks, $order_till, $province, $Phone) {
        $Data = array();
        $Data['email'] = $email;
        $Data['address2'] = $address2;
        $Data['city'] = $city;
        $Data['ordered_by'] = $ordered_by;
        $Data['postal_code'] = $postal_code;
        $Data['remarks'] = $remarks;
        $Data['order_till'] = $order_till;
        $Data['province'] = $province;
        $Data['contact'] = $Phone;

        edit_database('reservations', 'id', $OrderID, $Data);
    }
}