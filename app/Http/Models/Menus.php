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
class Menus extends BaseModel
{

    protected $table = 'menus';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * @param array
     * @return Array
     */
    public function populate($data)
    {
        $cells = array('restaurant_id', 'menu_item', 'description', 'price', 'additional', 'has_addon', 'image', 'type', 'parent', 'req_opt', 'sing_mul', 'exact_upto', 'exact_upto_qty', 'display_order', 'cat_id');
        foreach ($cells as $cell) {
            if (array_key_exists($cell, $data)) {
                $this->$cell = $data[$cell];
            }
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
    public static function searchMenus($term = '', $per_page = 10, $start = 0, $type = '', $sortType = 'display_order', $sortBy = 'ASC', $priceFrom = '', $priceTo = '', $hasAddon = '', $hasImage = '')
    {
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

////////////////////////////////////////Menus API/////////////////////////////////
    public static function enum_menus($restaurant_id = "", $Sort = "")
    {
        if ($restaurant_id == "all") {
            return enum_all('menus', ['parent' => '0', 'image <> "undefined"']);
        }
        if (!$restaurant_id) {
            $restaurant_id = get_current_restaurant();
        }
        if ($Sort) {
            $order = array('display_order' => $Sort);
        } else {
            $order = "";
        }
        return enum_all("menus", array('res_id' => $restaurant_id, 'parent' => '0', 'image<>"undefined"'), $order);
    }

    public static function get_menu($restaurant_id)
    {
        return enum_all('menus', array('res_id' => $restaurant_id));
    }

}
