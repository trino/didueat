<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Menus extends BaseModel {

    protected $table = 'menus';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * @param array
     * @return Array
     */
    public function populate($data) {
        $cells = array('restaurant_id', 'menu_item', 'description', 'price', 'rating', 'additional', 'has_addon', 'image', 'type', 'parent', 'req_opt', 'sing_mul', 'exact_upto', 'exact_upto_qty', 'display_order', 'cat_id', 'has_discount', 'discount_per', 'days_discount', 'is_active', 'uploaded_by', 'cat_name', 'uploaded_on','temp_id');
        $this->copycells($cells, $data);
    }

    //on save, makes sure the store is open if that's all it needed
    public function save(array $options = array()) {
        parent::save($options);
        if(isset($this->restaurant_id)) {
            $before = select_field("restaurants", "id", $this->restaurant_id);
            $after = \App\Http\Models\Restaurants::restaurant_opens($this->restaurant_id, true);
            if (!$before->is_complete && $after) {return true;}
        }
    }

    /**
     * @param $term
     * @param $per_page
     * @param $start
     * @param $sortType
     * @param $sortBy
     * @return response
     */
    public static function searchMenus($term = '', $per_page = 10, $start = 0, $type = '', $sortType = 'display_order', $sortBy = 'ASC', $priceFrom = '', $priceTo = '', $hasAddon = '', $hasImage = '', &$reccount = 0) {
        $query = \App\Http\Models\Menus::Where('parent', 0)
            ->Where(function ($query) use ($term, $priceFrom, $priceTo, $hasAddon, $hasImage) {
                if ($term != "") {
                    $query->where('menu_item', 'LIKE', "%$term%");
                }
                if ($hasAddon != "") {
                    $query->where('has_addon', '=', "$hasAddon");
                }
                if ($hasImage != "" && $hasImage == 1) {
                    $query->whereNotNull('image');
                }
                if ($hasImage != "" && $hasImage == 0) {
                    $query->whereNull('image');
                }
                if ($priceFrom != "") {
                    $query->where('price', '>=', $priceFrom);
                }
                if ($priceTo != "") {
                    $query->where('price', '<=', $priceTo);
                }
            })->orderBy($sortType, $sortBy);

        $reccount = $query->count();
        if ($type == "list") {
            $query->take($per_page);
            $query->skip($start);
        }
        return $query;
    }

    //I don't understand what this should do
    public static function get_price($id) {
        $submenus = \App\Http\Models\Menus::where('parent', $id)->get();
        //$minprice = \App\Http\Models\Menus::where('parent', $id)->min('price');
        if($submenus->count()> 0){
            $minprice = 10000;
            foreach($submenus as $sub) {
                   $minmenu_price = \App\Http\Models\Menus::where('parent', $sub->id)->where('price','!=', '0')->min('price');
                 if(isset($minmenu_price) && $minprice > $minmenu_price) {
                      $minprice = $minmenu_price;
                      
                 } else {
                     $minprice = $minprice;
                 }
            }
        } else {
            $minprice = 0;
        }
        return $minprice;
    }
}
