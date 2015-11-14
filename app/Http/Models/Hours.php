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
class Hours extends BaseModel
{

    protected $table = 'hours';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * @param array
     * @return Array
     */
    public function populate($data)
    {
        $cells = array('restaurant_id', 'day_of_week', 'open', 'close');
        foreach ($cells as $cell) {
            if (array_key_exists($cell, $data)) {
                $this->$cell = $data[$cell];
            }
        }
    }


/////////////////////////////////////Hours API///////////////////////////////////////
    function to_time($Time)
    {
        if ($Time) {
            if (substr_count($Time, ":") == 2) {
                $Time = left($Time, strlen($Time) - 3);
            }
            return str_replace(":", "", $Time);
        }
    }

    function edit_hours($restaurant_id, $Data)
    {
        $Days = array();
        for ($day_of_week = 1; $day_of_week < 8; $day_of_week++) {
            $Open = $this->to_time($Data[$day_of_week . "_open"]);
            $Close = $this->to_time($Data[$day_of_week . "_close"]);
            $Days[$day_of_week] = $Open . " to " . $Close;
            $this->edit_hour($restaurant_id, $day_of_week, $Open, $Close);
        }
        logevent("Edited hours: " . print_r($Days, true));
    }


    function is_restaurant_open_now($restaurant_id, $date = "")
    {
        if (!$date) {
            $date = now();
        }
        if (strpos($date, "-")) {
            $date = strtotime($date);
        }
        if (!$this->is_day_off($restaurant_id, get_day($date), get_month($date), get_year($date))) {
            $day_of_week = $this->get_name_of_weekday($date);
            $time = date('Gi', $date);
            return $this->is_restaurant_open($restaurant_id, $day_of_week, $time);
        }
    }

    function get_name_of_weekday($day_of_week = "")
    {
        if (!$day_of_week) {
            $day_of_week = now();
            $day_of_week = date('w', $day_of_week);
        }
        $Days = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
        return $Days[$day_of_week];
    }

    function get_hours($restaurant_id, $day_of_week = "")
    {
        $ret = array();
        $Params = array('restaurant_id' => $restaurant_id);
        if ($day_of_week) {
            if (is_numeric($day_of_week)) {
                $day_of_week = $this->get_name_of_weekday($day_of_week);
            }
            $Params['day_of_week'] = $day_of_week;
        }
        $Data = enum_all('hours', $Params, 'day_of_week');
        $HasHours = false;
        foreach ($Data as $Day) {
            $ret[$Day->day_of_week . ".open"] = $Day->open;
            $ret[$Day->day_of_week . ".close"] = $Day->close;
            if ($Day->open <> 0 || $Day->close <> 2359) {
                $HasHours = true;
            }
        }
        $ret["HasHours"] = $HasHours;
        return $ret;
    }

    function edit_hour($restaurant_id, $day_of_week, $Open, $Close)
    {
        if (is_numeric($day_of_week)) {
            $day_of_week = $this->get_name_of_weekday($day_of_week);
        }
        $data = array('restaurant_id' => $restaurant_id, 'day_of_week' => $day_of_week);
        delete_all('hours', $data);
        if (!$Open) {
            $Open = "";
        }
        if (!$Close) {
            $Close = "";
        }
        $data["open"] = $Open;
        $data["close"] = $Close;
        if ($Open && $Close) {
            new_entry("hours", "id", $data);
        }
    }

    function get_restaurant($restaurant_id)
    {
        $ob = new \App\Http\Models\Restaurants();
        return $ob->get_restaurant($restaurant_id);
    }

    function is_restaurant_open($restaurant_id, $day_of_week, $Time)
    {
        if ($this->get_restaurant($restaurant_id)->open) {
            if (is_numeric($day_of_week)) {
                $day_of_week = $this->get_name_of_weekday($day_of_week);
            }
            $Data = $this->get_hours($restaurant_id, $day_of_week);
            if ($Data["has_hours"]) {
                $Open = $this->parsetime($Data[$day_of_week . ".open"]);
                $Close = $this->parsetime($Data[$day_of_week . ".close"]);
                return $Open <= $Time && $Close >= $Time;
            }
        }
    }

    function parsetime($Time)
    {
        $TheTime = 0;
        $Time = strtoupper($Time);
        if (right($Time, 2) == "PM" || right($Time, 2) == "AM") {//12 hour time
            if (right($Time, 2) == "PM") {
                $TheTime = 1200;
            }
            $Time = left($Time, strlen($Time) - 3);
        }
        $Time = explode(":", $Time);
        if (count($Time) == 2) {
            $TheTime = $TheTime + ($Time[0] * 100) + $Time[1];
        }
        return $TheTime;
    }

}