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
        return self::makenew(array(
            'status' => 0,
            'user_id' => read("id")
        ))->id;
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
                break;
            case "changequantity":
                update_database("orderitems", "id", $post["menuitem_id"], array("quantity" => $post["quantity"]));

            default:
                $post["status"] = false;
                $post["reason"] = "Action: '" . $post["action"] . "' is unhandled";
        }

        if(isset($post["layout"])) {
            if(debugmode()){$post["POST"] = $post;}
            $post["HTML"] = "" . view($post["layout"], $post);
        }
        $post["subtotal"] = first("SELECT SUM(price * quantity) FROM orderitems WHERE order_id = " . $post["order_id"])[0];
        return $post;
    }
}
?>