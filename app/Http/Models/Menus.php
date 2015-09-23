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
        $cells = array('restaurantId', 'menu_item', 'description', 'price', 'additional', 'has_addon', 'image', 'type', 'parent', 'req_opt', 'sing_mul', 'exact_upto', 'exact_upto_qty', 'display_order');
        foreach($cells as $cell){
            if (array_key_exists($cell, $data)) {
                $this->$cell = $data[$cell];
            }
        }

    }
    
}