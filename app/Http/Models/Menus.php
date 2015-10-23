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

        /*
          if (array_key_exists('restaurant_id', $data)) {
          $this->restaurant_id = $data['restaurant_id'];
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
          } */
    }

    /**
     * @param $term
     * @param $per_page
     * @param $start
     * @return response
     */
    public static function searchMenus($term = '', $per_page = 10, $start = 0, $type = '', $sortType = 'display_order', $sortBy = 'ASC', $priceFrom = '', $priceTo = '', $hasAddon = '', $hasImage = '')
    {
        $query = \App\Http\Models\Menus::where('parent', 0)
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
