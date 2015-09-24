<?php
namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Menus
 * @package    Laravel 5.1.11
 * @subpackage Model
 * @author     Skp Software Technologies
 * @developer  Waqar Javed
 * @date       20 September, 2015
 */
class Menus extends BaseModel {

    protected $table = 'menus';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    
    /**
     * @param array
     * @return Array
     */
    public function populate($data) {

        if (array_key_exists('restaurantId', $data)) {
            $this->restaurantId = $data['restaurantId'];
        }
        if (array_key_exists('menu_item', $data)) {
            $this->menu_item = $data['menu_item'];
        }
        if (array_key_exists('description', $data)) {
            $this->description = $data['description'];
        }
        if (array_key_exists('price', $data)) {
            $this->price = $data['price'];
        }
        if (array_key_exists('additional', $data)) {
            $this->additional = $data['additional'];
        }
        if (array_key_exists('has_addon', $data)) {
            $this->has_addon = $data['has_addon'];
        }
        if (array_key_exists('image', $data)) {
            $this->image = $data['image'];
        }
        if (array_key_exists('type', $data)) {
            $this->type = $data['type'];
        }
        if (array_key_exists('parent', $data)) {
            $this->parent = $data['parent'];
        }
        if (array_key_exists('req_opt', $data)) {
            $this->req_opt = $data['req_opt'];
        }
        if (array_key_exists('sing_mul', $data)) {
            $this->sing_mul = $data['sing_mul'];
        }
        if (array_key_exists('exact_upto', $data)) {
            $this->exact_upto = $data['exact_upto'];
        }
        if (array_key_exists('exact_upto_qty', $data)) {
            $this->exact_upto_qty = $data['exact_upto_qty'];
        }
        if (array_key_exists('display_order', $data)) {
            $this->display_order = $data['display_order'];
        }
    }
    
}