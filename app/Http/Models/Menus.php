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
        $cells = array('restaurant_id', 'menu_item', 'description', 'price', 'rating', 'additional', 'has_addon', 'image', 'type', 'parent', 'req_opt', 'sing_mul', 'exact_upto', 'exact_upto_qty', 'display_order', 'cat_id','has_discount','discount_per','days_discount','is_active','uploaded_by','cat_name','uploaded_on');
        $this->copycells($cells, $data);
    }

    /**
     * @param $term
     * @param $per_page
     * @param $start
     * @param $sortType
     * @param $sortBy
     * @return response
     */
    public static function searchMenus($term = '', $per_page = 10, $start = 0, $type = '', $sortType = 'display_order', $sortBy = 'ASC', $priceFrom = '', $priceTo = '', $hasAddon = '', $hasImage = '') {
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

        if ($type == "list") {
            $query->take($per_page);
            $query->skip($start);
        }
        return $query;
    }
    
    public static function get_price($id)
    {
        $submenus = \App\Http\Models\Menus::where('parent', $id)->get();
        //$minprice = \App\Http\Models\Menus::where('parent', $id)->min('price');
        $minprice = 1;
        foreach($submenus as $sub)
        {
             $minmenu_price = \App\Http\Models\Menus::where('parent', $sub->id)->min('price');
             if($minprice < $minmenu_price)
                $minprice= $minprice;
             else
                $minprice = $minmenu_price;
        }
       return $minprice;
        
    }
}
