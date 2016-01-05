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

echo newrow($new, "Allow pickup"); ?>
<LABEL>
    <input type="checkbox" name="is_pickup" id="is_pickup" value="1" {{ (old('is_pickup') || (isset($restaurant->is_pickup) && $restaurant->is_pickup > 0))?'checked':'' }} />
    I Offer Pickup
</LABEL>
<?php echo newrow();

echo newrow($new, "Allow delivery"); ?>
<LABEL>
    <input type="checkbox" name="is_delivery" id="is_delivery" value="1" {{ (old('is_delivery') || (isset($restaurant->is_delivery) && $restaurant->is_delivery > 0))?'checked':'' }} />
    I Offer Delivery
</LABEL>
<?php echo newrow(); ?>

<div id="is_delivery_options" style="display: {{ (isset($restaurant->is_delivery) && $restaurant->is_delivery > 0)?'block':'none' }};">
    <?php echo newrow($new, "Delivery Fee"); ?>
    <input type="number" min="0" name="delivery_fee" class="form-control" placeholder="Delivery Fee" value="{{ (isset($restaurant->delivery_fee))?$restaurant->delivery_fee: old('delivery_fee')  }}"/>
    <?php echo newrow();

    echo newrow($new, "Min. Subtotal Before Delivery"); ?>
    <input type="number" min="0" name="minimum" class="form-control" placeholder="Minimum Subtotal For Delivery" value="{{ (isset($restaurant->minimum))?$restaurant->minimum:old('minimum') }}"/>
    <?php echo newrow();

    $value = (isset($restaurant->max_delivery_distance))?$restaurant->max_delivery_distance: old("max_delivery_distance");
    echo newrow($new, "Max Delivery Distance"); ?>
    <input name="max_delivery_distance" id="max_delivery_distance" type="range" min="1" max="20" class="form-control" value="{{ $value }}" onchange="$('#max_delivery_distance_label').html('Max Delivery Distance (' + p.value + ' km)');">

    <!--select name="max_delivery_distance" id="max_delivery_distance" class="form-control">
        <option value="10">Between 1 and 10 km</option>
    </select-->
    <?php echo newrow(); ?>
</div>

<?php
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
                echo '<input type="hidden" name="day_of_week[' . $key . ']" value="' . $value . '"/>';
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
        echo '<div class="row is_delivery_options"><div class="caption is_delivery_options"><i class="fa fa-long-arrow-right" style="padding-left: 7px;"></i> DELIVERY TIMES</div></div>';
    } else {
        echo '</DIV></DIV><div class="form-group row is_delivery_options"><label class="col-sm-3 ">Delivery times</label><div class="col-sm-9">';
    }
    foreach ($day_of_week as $key => $value) {
        $opentime = (isset($open_del[$key])) ? $open_del[$key] : getTime($open_del[$key]);
        $closetime = (isset($close_del[$key])) ? $close_del[$key] : getTime($close_del[$key]);
        printrow($layout, $key, $value, $opentime, $closetime, "_del", "is_delivery_options");
    }
    echo '<BR><LABEL class="is_delivery_options"><input type="CHECKBOX" onclick="same(event);" ID="samehours"> Same as regular hours</LABEL>';

    function printrow($layout, $key, $value, $opentime, $closetime, $suffix="", $class = ""){
        if($layout){$layout = 9; $width=5;} else {$layout = 2; $width=4; if($suffix){$layout=3;}}//width: 4 is editor, 5 is signup
        $closed = '<LABEL><input type="checkbox" onchange="closed(event, ' . $key . ');"> Closed</LABEL>';
        ?>
        <div class="row {{ $class }}">
            <label class="col-sm-{{ $layout }}">{{ $value }}</label>
            @if(!$suffix && $layout == 2) <div class="col-sm-1" align="center"><SMALL><SMALL><?= $closed; ?></SMALL></SMALL></DIV> @endif
            @if(!$suffix && $layout == 9) <?= $closed; ?> @endif
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
    is_delivery_change();
    function is_delivery_change(){
        if ($('#is_delivery').is(':checked')) {
            $('#is_delivery_options').show();
            $('.is_delivery_options').show();
        } else {
            $('#is_delivery_options').hide();
            $('.is_delivery_options').hide();
        }
    }

    function closed(event, ID){
        closed_element(event, ID, "open");
        closed_element(event, ID, "close");
    }
    function closed_element(event, ID, name){
        var element = document.getElementById(name + "[" + ID + "]");
        if (event.target.checked){
            element.setAttribute("old", element.value);
            element.value = "";
        } else {
            element.value = element.getAttribute("old");
        }
        change(name, ID);
    }

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

    var p = document.getElementById("max_delivery_distance");
    p.addEventListener("input", function() {
        $("#max_delivery_distance").trigger("change");
    }, false);
    $("#max_delivery_distance").trigger("change");
</script>
