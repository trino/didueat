<?php
namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Hours
 * @package    Laravel 5.1.11
 * @subpackage Model
 * @author     Skp Software Technologies
 * @developer  Waqar Javed
 * @date       20 September, 2015
 */
class Hours extends BaseModel {

    protected $table = 'hours';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    
    /**
     * @param array
     * @return Array
     */
    public function populate($data) {
        $cells = array('RestaurantID', 'DayOfWeek', 'Open', 'Close');
        foreach($cells as $cell) {
            if (array_key_exists($cell, $data)) {
                $this->$cell = $data[$cell];
            }
        }

        /*
        if (array_key_exists('RestaurantID', $data)) {
            $this->RestaurantID = $data['RestaurantID'];
        }
        if (array_key_exists('DayOfWeek', $data)) {
            $this->DayOfWeek = $data['DayOfWeek'];
        }
        if (array_key_exists('Open', $data)) {
            $this->Open = $data['Open'];
        }
        if (array_key_exists('Close', $data)) {
            $this->Close = $data['Close'];
        }*/

    }


/////////////////////////////////////Hours API///////////////////////////////////////
    function to_time($Time){
        if($Time){
            if (substr_count($Time, ":") == 2) {
                $Time = left($Time, strlen($Time) - 3);
            }
            return str_replace(":", "", $Time);
        }
    }

    function edit_hours($RestaurantID, $Data){
        $Days = array();
        for ($DayOfWeek = 1; $DayOfWeek < 8; $DayOfWeek++){
            $Open = $this->to_time($Data[$DayOfWeek . "_Open"]);
            $Close = $this->to_time($Data[$DayOfWeek . "_Close"]);
            $Days[$DayOfWeek] = $Open . " to " . $Close;
            $this->edit_hour($RestaurantID, $DayOfWeek, $Open, $Close);
        }
        logevent("Edited hours: " . print_r($Days, true));
    }


    function is_restaurant_open_now($RestaurantID, $date = ""){
        if(!$date){ $date = now();}
        if(strpos($date, "-")){$date = strtotime($date);}
        if(!$this->is_day_off($RestaurantID, get_day($date), get_month($date), get_year($date))) {
            $dayofweek = $this->get_name_of_weekday($date);
            $time = date('Gi', $date);
            return $this->is_restaurant_open($RestaurantID, $dayofweek, $time);
        }
    }

    function get_name_of_weekday($DayOfWeek = ""){
        if(!$DayOfWeek){
            $DayOfWeek = now();
            $DayOfWeek = date('w', $DayOfWeek);
        }
        $Days = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
        return $Days[$DayOfWeek];
    }
    function get_hours($RestaurantID, $DayOfWeek = ""){
        $ret = array();
        $Params = array('RestaurantID' => $RestaurantID);
        if($DayOfWeek){
            if(is_numeric($DayOfWeek)){$DayOfWeek = $this->get_name_of_weekday($DayOfWeek);}
            $Params['DayOfWeek'] = $DayOfWeek;
        }
        $Data = enum_all('hours', $Params, 'DayOfWeek');
        $HasHours = false;
        foreach($Data as $Day){
            $ret[$Day->DayOfWeek . ".Open"] = $Day->Open;
            $ret[$Day->DayOfWeek . ".Close"] = $Day->Close;
            if($Day->Open <> 0 || $Day->Close <> 2359){$HasHours=true;}
        }
        $ret["HasHours"] = $HasHours;
        return $ret;
    }

    function edit_hour($RestaurantID, $DayOfWeek, $Open, $Close){
        if(is_numeric($DayOfWeek)){$DayOfWeek = get_name_of_weekday($DayOfWeek);}
        $data = array('RestaurantID'=>$RestaurantID, 'DayOfWeek'=> $DayOfWeek);
        delete_all('hours', $data);
        if(!$Open){$Open = "";}
        if(!$Close){$Close = "";}
        $data["Open"] = $Open;
        $data["Close"] = $Close;
        if($Open && $Close) {new_entry("hours", "ID", $data);}
    }

    function get_restaurant($RestaurantID){
        $ob = new \App\Http\Models\Restaurants();
        return $ob->get_restaurant($RestaurantID);
    }

    function is_restaurant_open($RestaurantID, $DayOfWeek, $Time){
        if ($this->get_restaurant($RestaurantID)->Open) {
            if(is_numeric($DayOfWeek)){$DayOfWeek = $this->get_name_of_weekday($DayOfWeek);}
            $Data = $this->get_hours($RestaurantID, $DayOfWeek);
            if ($Data["HasHours"]) {
                $Open = $this->parsetime($Data[$DayOfWeek . ".Open"]);
                $Close = $this->parsetime($Data[$DayOfWeek . ".Close"]);
                return $Open <= $Time && $Close >= $Time;
            }
        }
    }

    function parsetime($Time){
        $TheTime = 0;
        $Time = strtoupper($Time);
        if( right($Time, 2) == "PM" || right($Time, 2) == "AM"){//12 hour time
            if(right($Time, 2) == "PM"){
                $TheTime = 1200;
            }
            $Time = left($Time, strlen($Time) - 3);
        }
        $Time = explode(":", $Time);
        if(count($Time)==2) {
            $TheTime = $TheTime + ($Time[0] * 100) + $Time[1];
        }
        return $TheTime;
    }

}