<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItems extends BaseModel {

    protected $table = 'orderitems';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * @param array
     * @return Array
     */
    public function populate($data) {
        $cells = array('order_id', 'quantity', 'parent_id', 'title', 'csr_action', 'id_list', 'price');
        $this->restaurant_id = select_field("menus", "id", $data["parent_id"], "restaurant_id");
        $this->copycells($cells, $data);
    }
}
?>