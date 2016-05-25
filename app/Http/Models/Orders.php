<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends BaseModel {

    protected $table = 'orders';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * @param array
     * @return Array
     */
    public function populate($data) {
        $cells = array('status', 'user_id');
        $this->copycells($cells, $data);
    }

    //\App\Http\Models\Orders::newid();
    public static function newid(){
        $ID = self::makenew(array(
            'status' => 0,
            'ordered_by' => read("name"),
            'user_id' => read("id")
        ))->id;
        debugprint("Order started", $ID);
        return $ID;
    }

    //must return an array for json_encode
    public static function additem($post){
        if(!isset($post["action"])){$post["action"] = "[BLANK]";}
        $post["status"] = true;
        $post["reason"] = "no reason set";
        switch ($post["action"]){
            case "additemtoreceipt": //menu_id, ids, quantity, price, csr_action, app_title, extratitle, dbtitle
                $post["menuitem_id"] = \App\Http\Models\OrderItems::makenew($post)->id;
                $post["layout"] = "receipt.menuitem";
                debugprint("Item added: " . $post["quantity"] . "x " . $post["title"], $post["order_id"]);
                break;
            case "changequantity":
                if($post["quantity"]) {
                    update_database("orderitems", "id", $post["menuitem_id"], array("quantity" => $post["quantity"]));
                } else {
                    delete_all("orderitems", array("id" => $post["menuitem_id"]));
                }
                debugprint("Item " . $post["menuitem_id"] . " quantity changed to: " . $post["quantity"] . "x", $post["order_id"]);
                break;
            case "updateorder":
                update_database("orders", "id", $post["order_id"], array($post["key"] => $post["value"]));
                debugprint("Column " . $post["key"] . " changed to: " . $post["value"], $post["order_id"]);
                break;
            default:
                $post["status"] = false;
                $post["reason"] = "Action: '" . $post["action"] . "' is unhandled";
        }

        if(isset($post["layout"])) {
            if(debugmode()){$post["POST"] = $post;}
            $post["HTML"] = "" . view($post["layout"], $post);
        }
        $post["subtotal"] = first("SELECT SUM(price * quantity) FROM orderitems WHERE order_id = " . $post["order_id"])[0];
        if(!$post["subtotal"]){$post["subtotal"] = "0.00";}
        return $post;
    }






    public static function listing($array = "", $type = "", &$reccount = 0) {
        foreach($array as $key => $value){
            if($value === "undefined"){
                var_dump($array);
                die("ERROR: " . $key . " should not be undefined");
            }
        }

        $query_type = $array['type'];
        $searchResults = $array['searchResults'];
        $meta = $array['meta'];
        $order = $array['order'];
        $per_page = $array['per_page'];
        $start = $array['start'];

        $query = Orders::select('*')
            ->Where(function($query) use ($query_type, $array) {
                $userid=read('id');
                //$restaurantid=read('restaurant_id');
                if(isset($array['id'])){
                    $userid=$array['id'];
                    //$restaurantid=$array['id'];
                }
                if($query_type == 'user'){
                    $query->where('user_id', $userid);
                }
                //if($query_type == 'restaurant'){
                    //$query->where('restaurant_id', $restaurantid);
                //}
                if($query_type == 'driver'){
                    $query->where('driver_id', $userid);
                }
            })
            ->Where(function($query) use ($searchResults) {
                if($searchResults != "" && $searchResults != "undefined"){
                    $query->orWhere('id', '=', $searchResults);
                        /*
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
                        */
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
?>