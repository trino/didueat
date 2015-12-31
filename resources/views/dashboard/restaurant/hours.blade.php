<?php
    printfile("dashboard/restaurant/hours.blade.php");
    if(!isset($layout)){$layout=false;}
    $day_of_week = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');

    $restaurantID = \Session::get('session_restaurant_id');
    if(!$restaurantID){$restaurantID=0;}
    if(isset($resturant->id)){$restaurantID = $resturant->id;}

    if($layout){
        echo '<STYLE> .time{ padding-left: 8px; padding-right: 6px; }</STYLE>';
    }

    foreach ($day_of_week as $key => $value) {
        if(strpos($value, ">") !== false){
            echo $value;
        } else {
            $day = select_field_where('hours', array('restaurant_id' => $restaurantID, 'day_of_week' => $value));
            if($day){
                $open[$key] = $day->open;
                $close[$key] = $day->close;
                $open_del[$key] = $day->open_del;
                $close_del[$key] = $day->close_del;
                $ID[$key] = $day->id;
                echo '<input type="hidden" name="idd[' . $key . ']" value="' . $day->id . '"/>';
            } else {
                $open[$key] = "12:00:00";
                $close[$key] = $open[$key];
                $open_del[$key] = $open[$key];
                $close_del[$key] = $open[$key];
            }

            $opentime = (isset($open[$key])) ? $open[$key] : getTime($open[$key]);
            $closetime = (isset($close[$key])) ? $close[$key] : getTime($close[$key]);
            printrow($layout, $key, $value, $opentime, $closetime);
        }
    }
    if($layout){
        echo '<div class="row"><div class="caption"><i class="fa fa-long-arrow-right" style="padding-left: 7px;"></i> DELIVERY TIMES</div></div>';
    } else {
        echo '</DIV></DIV><div class="form-group row"><label class="col-sm-3">Delivery times</label><div class="col-sm-9">';
    }
    foreach ($day_of_week as $key => $value) {
        $opentime = (isset($open_del[$key])) ? $open_del[$key] : getTime($open_del[$key]);
        $closetime = (isset($close_del[$key])) ? $close_del[$key] : getTime($close_del[$key]);
        printrow($layout, $key, $value, $opentime, $closetime, "_del");
    }
    echo '<BR><LABEL><input type="CHECKBOX" onclick="same(event);" ID="samehours"> Same as regular hours</LABEL>';

    function printrow($layout, $key, $value, $opentime, $closetime, $suffix=""){
        if($layout){$layout = 9; $width=5;} else {$layout = 3; $width=4;}
        ?>
        <div class="row">
            <label class="col-sm-{{ $layout }}">{{ $value }}</label>
            <div class="col-sm-{{ $width }}">
                <input type="text" name="open{{$suffix}}[{{ $key }}]" id="open{{$suffix}}[{{ $key }}]" value="{{ $opentime }}" title="Open" class="form-control time"/>
            </div>
            <div class="col-sm-1">
                to
            </div>
            <div class="col-sm-{{ $width }}">
                <input type="text" name="close{{$suffix}}[{{ $key }}]" id="close{{$suffix}}[{{ $key }}]" value="{{ $closetime }}" title="Close" class="form-control time"/>
            </div>
        </div>
        <?php
    }
?>


<script>
    function change(type, id){
        if(document.getElementById("samehours").checked){
            var value = document.getElementById(type + "[" + id + "]").value;
            document.getElementById(type + "_del[" + id + "]").value = value;
        }
    }
    function same(event){
        if(document.getElementById("samehours").checked){
            for(var i = 0; i<7; i++){
                change("open", i);
                change("close", i);
            }
        }
    }
</script>