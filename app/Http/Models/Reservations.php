<?php
namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Reservations
 * @package    Laravel 5.1.11
 * @subpackage Model
 * @author     Skp Software Technologies
 * @developer  Waqar Javed
 * @date       20 September, 2015
 */
class Reservations extends BaseModel {

    protected $table = 'reservations';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    /**
     * @param array
     * @return Array
     */
    public function populate($data) {
        $cells = array('restaurantId', 'menu_ids', 'prs', 'qtys', 'extras', 'listid', 'subtotal', 'g_total', 'cash_type', 'ordered_by', 'email', 'contact', 'payment_mode', 'address1', 'address2', 'city', 'province', 'postal_code', 'remarks', 'order_time', 'order_till', 'order_now', 'delivery_fee','tax', 'order_type', 'approved', 'cancelled');
        foreach($cells as $cell) {
            if (array_key_exists($cell, $data)) {
                $this->$cell = $data[$cell];
            }
        }

        /*
        if (array_key_exists('restaurantId', $data)) {
            $this->restaurantId = $data['restaurantId'];
        }
        if (array_key_exists('menu_ids', $data)) {
            $this->menu_ids = $data['menu_ids'];
        }
        if (array_key_exists('prs', $data)) {
            $this->prs = $data['prs'];
        }
        if (array_key_exists('qtys', $data)) {
            $this->qtys = $data['qtys'];
        }
        if (array_key_exists('extras', $data)) {
            $this->extras = $data['extras'];
        }
        if (array_key_exists('listid', $data)) {
            $this->listid = $data['listid'];
        }
        if (array_key_exists('subtotal', $data)) {
            $this->subtotal = $data['subtotal'];
        }
        if (array_key_exists('g_total', $data)) {
            $this->g_total = $data['g_total'];
        }
        if (array_key_exists('cash_type', $data)) {
            $this->cash_type = $data['cash_type'];
        }
        if (array_key_exists('ordered_by', $data)) {
            $this->ordered_by = $data['ordered_by'];
        }
        if (array_key_exists('email', $data)) {
            $this->email = $data['email'];
        }
        if (array_key_exists('contact', $data)) {
            $this->contact = $data['contact'];
        }
        if (array_key_exists('payment_mode', $data)) {
            $this->payment_mode = $data['payment_mode'];
        }
        if (array_key_exists('address1', $data)) {
            $this->address1 = $data['address1'];
        }
        if (array_key_exists('address2', $data)) {
            $this->address2 = $data['address2'];
        }
        if (array_key_exists('city', $data)) {
            $this->city = $data['city'];
        }
        if (array_key_exists('province', $data)) {
            $this->province = $data['province'];
        }
        if (array_key_exists('postal_code', $data)) {
            $this->postal_code = $data['postal_code'];
        }
        if (array_key_exists('remarks', $data)) {
            $this->remarks = $data['remarks'];
        }
        if (array_key_exists('order_time', $data)) {
            $this->order_time = $data['order_time'];
        }
        if (array_key_exists('order_till', $data)) {
            $this->order_till = $data['order_till'];
        }
        if (array_key_exists('order_now', $data)) {
            $this->order_now = $data['order_now'];
        }
        if (array_key_exists('delivery_fee', $data)) {
            $this->delivery_fee = $data['delivery_fee'];
        }
        if (array_key_exists('tax', $data)) {
            $this->tax = $data['tax'];
        }
        if (array_key_exists('order_type', $data)) {
            $this->order_type = $data['order_type'];
        }
        if (array_key_exists('approved', $data)) {
            $this->approved = $data['approved'];
        }
        if (array_key_exists('cancelled', $data)) {
            $this->cancelled = $data['cancelled'];
        }*/
    }
    
}