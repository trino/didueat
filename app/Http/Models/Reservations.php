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
        $cells = array('restaurant_id', 'menu_ids', 'prs', 'qtys', 'extras', 'listid', 'subtotal', 'g_total', 'cash_type', 'ordered_by', 'email', 'contact', 'payment_mode', 'address1', 'address2', 'city', 'province', 'postal_code', 'remarks', 'order_time', 'order_till', 'order_now', 'delivery_fee','tax', 'order_type', 'approved', 'cancelled');
        foreach($cells as $cell) {
            if (array_key_exists($cell, $data)) {
                $this->$cell = $data[$cell];
            }
        }

        /*
        if (array_key_exists('restaurant_id', $data)) {
            $this->restaurant_id = $data['restaurant_id'];
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


    function new_order($menu_ids, $prs, $qtys, $extras, $listid, $order_type, $delivery_fee, $res_id, $subtotal, $g_total, $tax){
        $Data = array();
        $Data['menu_ids'] = implode_data($menu_ids);
        $Data['prs'] = implode_data($prs);
        $Data['qtys'] = implode_data($qtys);
        $Data['extras'] = implode_data($extras);
        $Data['listid'] = implode_data($listid);
        $Data['delivery_fee'] = $delivery_fee;

        date_default_timezone_set('Canada/Eastern');
        $Data['order_time'] = new \DateTime('NOW');
        $Data['res_id'] = $res_id;
        $Data['subtotal'] = $subtotal;
        $Data['g_total'] = $g_total;
        $Data['tax'] = $tax;

        if ($order_type == '0'){$order_type = "0.00";}
        $Data['order_type'] = $order_type;

        //convert to a Manager API call
        $ord = TableRegistry::get('reservations');
        $att = $ord->newEntity($Data);
        $ord->save($att);
        return $att->id;
    }
    function edit_order_profile($OrderID, $email, $address2, $city, $ordered_by, $postal_code, $remarks, $order_till, $province, $Phone){
        $Data = array();
        $Data['email'] = $email;
        $Data['address2'] = $address2;
        $Data['city'] = $city;
        $Data['ordered_by'] = $ordered_by;
        $Data['postal_code'] = $postal_code;
        $Data['remarks'] = $remarks;
        $Data['order_till'] = $order_till;
        $Data['province'] = $province;
        $Data['contact'] = $Phone;

        edit_database('reservations', 'id', $OrderID, $Data);
    }


/////////////////////////////////Orders API/////////////////////////////////////
    function enum_orders($ID = "", $IsUser = false, $Approved = false){
        $Conditions = array();
        $OrderBy = array('order_time'=>'desc');
        if($IsUser){
            if(!$ID){$ID = read("ID");}
            $Conditions["ordered_by"] = $ID;
        } else {
            if(!$ID){$ID = get_current_restaurant();}
            $Conditions["res_id"] = $ID;
        }
        if (strtolower($Approved != "any")) {
            if ($Approved) {
                $Conditions[] = '(approved = 1 OR cancelled=1)';
            } else {
                $Conditions['approved'] = 0;
                $Conditions['cancelled'] = 0;
            }
        }
        return enum_all("reservations", $Conditions, $OrderBy);
    }
    function delete_order($ID){
        delete_all("reservations", array('id' => $ID));
    }
    function pending_order_count($restaurant_id = ""){
        return iterator_count($this->enum_orders($restaurant_id, false, false));
    }
    function get_order($ID){
        return get_entry("reservations", $ID, "id");
    }
    function order_status($Order){
        if (!is_object($Order)){$Order = $this->get_order($Order);}
        if($Order->cancelled == 1) {
            return 'Cancelled';
        }else if($Order->approved == 1) {
            return 'Approved';
        }else {
            return 'Pending';
        }
    }
    function approve_order($OrderID, $Status=true){
        if($Status){$Status = 'approved';} else {$Status = 'cancelled';}
        edit_database('reservations', "ID", $OrderID, array($Status=>1));
    }



}