<?php

/*

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `status` set('incomplete','pending','approved','cancelled','delivered') NOT NULL DEFAULT 'incomplete',
  `driver_id` int(11) NOT NULL,
  `order_time` datetime NOT NULL,
  `time` datetime NOT NULL,
  `ordered_by` varchar(128) NOT NULL,
  `order_type` tinyint(4) NOT NULL DEFAULT '1',
  `paid` tinyint(4) NOT NULL,
  `remarks` varchar(256) NOT NULL,
  `order_till` varchar(128) NOT NULL,
  `address1` varchar(128) NOT NULL,
  `address2` varchar(128) NOT NULL,
  `city` varchar(128) NOT NULL,
  `province` varchar(64) NOT NULL,
  `country` varchar(64) NOT NULL,
  `postal_code` varchar(16) NOT NULL,
  `note` varchar(5000) NOT NULL,
  `tip` decimal(6,2) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `subtotal` decimal(6,2) NOT NULL,
  `tax` decimal(6,2) NOT NULL,
  `delivery_fee` decimal(6,2) NOT NULL,
  `g_total` decimal(6,2) NOT NULL,
  `guid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `orderitems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `quantity` varchar(512) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `title` varchar(1024) NOT NULL,
  `csr_action` int(11) NOT NULL,
  `id_list` varchar(1024) NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

ALTER TABLE `orders` ADD `latitude` DOUBLE NOT NULL , ADD `longitude` DOUBLE NOT NULL ;

 */

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
        $cells = array('status', 'user_id', 'driver_id', 'order_time', 'time', 'ordered_by', 'order_type', 'paid', 'remarks', 'order_till', 'address1', 'address2', 'city', 'province', 'country', 'postal_code', 'note', 'tip', 'subtotal', 'tax', 'delivery_fee', 'g_total', 'guid', 'csr_action');
        $this->copycells($cells, $data);
    }

    //\App\Http\Models\Orders::newid();
    public static function newid(){
        if(isset($_GET["orderid"])){
            $ID = $_GET["orderid"];
            $order = select_field("orders", "id", $ID);
            if(isset($order->user_id) && ($order->user_id == read("id") || read("profiletype") == 1)){
                debugprint("Order resumed", $ID);
                return $ID;
            } else {
                unset($_GET["orderid"]);
            }
        }

        $ID = self::makenew(array(
            'status' => 'incomplete',
            'ordered_by' => read("name"),
            'user_id' => read("id")
        ))->id;
        debugprint("Order started", $ID, true);
        return $ID;
    }

    public static function finalizeorder($post){
        $cells = array('status', 'user_id', 'driver_id', 'order_time', 'time', 'ordered_by', 'order_type', 'paid', 'remarks', 'order_till', 'address1', 'address2', 'city', 'province', 'country', 'postal_code', 'note', 'tip', 'subtotal', 'tax', 'delivery_fee', 'g_total', 'csr_action');
        $post = array_filter($post);
        $post["status"] = "pending";
        $orderid = $post["order_id"];
        foreach($post as $key => $value){
            if (!in_array($key, $cells)){
                unset($post[$key]);
            }
        }
        $post['guid'] = $orderid;
        update_database("orders", "id", $orderid, $post);
        debugprint("Order finalized", $orderid);
        return $orderid;
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
                    $post["itemtotal"] = first("SELECT SUM(price * quantity) FROM orderitems WHERE id = " . $post["menuitem_id"])[0];
                    $post["itemmoney"] = asmoney($post["itemtotal"]);
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

        $Query = first("SELECT SUM(price * quantity), COUNT(restaurant_id) FROM orderitems WHERE order_id = " . $post["order_id"]);

        $post["subtotal"] = $Query[0];
        $post["restaurants"] = $Query[1];
        $post["deliveryfee"] = $Query[1] * 5;
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

        $SQL = "SELECT *, (SELECT count(*) FROM orderitems WHERE order_id = orders.id) as itemcount FROM `orders` HAVING itemcount > 0 ORDER BY id DESC";
        $query = select_query($SQL);
        $reccount = $query->rowCount();

        $SQL .= " LIMIT " . $start . ", " . $per_page;
        //$SQL .= " ORDER BY " . $meta . " " . $order;

        $query = select_all($SQL);
        /*
        $query = Orders::select("*, COUNT(SELECT id FROM orderitems WHERE 'orderitems.order_id' = 'orders.id') AS itemcount'")
            //->Where("itemcount", '>', 0)
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
                }
            })
            ->orderBy($meta, $order);
            $reccount = $query->count();
            if ($type == "list") {
                $query->take($per_page);
                $query->skip($start);
            }
        */
        return $query;
    }
}
?>