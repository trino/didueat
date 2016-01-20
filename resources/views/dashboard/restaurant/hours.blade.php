<?php
    printfile("dashboard/restaurant/hours.blade.php");
    $layout=false;
    $day_of_week = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');

    $restaurantID = \Session::get('session_restaurant_id');
    if(!$restaurantID){$restaurantID=0;}
    if(isset($resturant->id)){$restaurantID = $resturant->id;}

    $IsPickup = old('is_pickup', -999);
    if($IsPickup == -999){
        if(isset($restaurant->is_pickup)){
            $IsPickup = $restaurant->is_pickup;
        } else {
            $IsPickup = 1;
        }
    }

    if(!isset($is_disabled)){$is_disabled=false;}
    $value = (isset($restaurant->max_delivery_distance))?$restaurant->max_delivery_distance: old("max_delivery_distance");

echo newrow($new, "Allow pickup"); ?>
    <LABEL>
        <input type="checkbox" name="is_pickup" {{ $is_disabled }} id="is_pickup" value="1" {{ ($IsPickup)?'checked':'' }} />&nbsp; I Offer Pickup
    </LABEL>
</DIV></DIV>

<?php echo newrow($new, "Allow delivery"); ?>
    <LABEL>
        <input type="checkbox" name="is_delivery" {{ $is_disabled }} id="is_delivery" value="1" {{ (old('is_delivery') || (isset($restaurant->is_delivery) && $restaurant->is_delivery > 0))?'checked':'' }} />&nbsp; I Offer Delivery
    </LABEL>
</DIV></DIV>

<div id="is_delivery_options" style="display: {{ (isset($restaurant->is_delivery) && $restaurant->is_delivery > 0)?'block':'none' }};">
    <?php echo newrow($new, "Delivery Fee ($)", "", true, 4); ?>
        <input type="text" min="0" name="delivery_fee" {{ $is_disabled }} class="form-control" style="width:60px" placeholder="Delivery Fee" value="{{ (isset($restaurant->delivery_fee))?$restaurant->delivery_fee: old('delivery_fee')  }}"/>
    </DIV></DIV>

    <?php echo newrow($new, "Min. Order Subtotal ($)<br/>(Before Delivery)", "", true, 4); ?>
        <input type="text" min="0" name="minimum" {{ $is_disabled }} class="form-control" style="width:60px" placeholder="Minimum Subtotal For Delivery" value="{{ (isset($restaurant->minimum))?$restaurant->minimum:old('minimum') }}"/>
    </DIV></DIV>

    <?php echo newrow($new, "Max Delivery Distance","", true, 9); ?>
        <input name="max_delivery_distance" {{ $is_disabled }} id="max_delivery_distance" type="range" min="1" max="30" class="form-control" value="{{ $value }}" onchange="$('#max_delivery_distance_label').html('<b>Max Delivery Distance:<br/><span style=\'color:#f00\'>(' + p.value + ' km)</span></b>');">

        <!--select name="max_delivery_distance" id="max_delivery_distance" class="form-control">
            <option value="10">Between 1 and 10 km</option>
        </select-->
        </DIV></DIV>
</div>

<label class="col-sm-12 row"><SPAN class="is_delivery_2"><b><u>Hours Open</u>:</b></SPAN></label>

<?php
    function getkey($object, $key){
        return $object->$key;
    }

    $isthesame=true;
    foreach ($day_of_week as $key => $value) {
        if(strpos($value, ">") !== false){
            echo $value;
        } else {
            //$day = select_field_where('hours', array('restaurant_id' => $restaurantID, 'day_of_week' => $value));
            if(isset($restaurant)){
                $open[$key] = getkey($restaurant, $value . "_open");
                $close[$key] = getkey($restaurant, $value . "_close");
                $open_del[$key] = getkey($restaurant, $value . "_open_del");
                $close_del[$key] = getkey($restaurant, $value . "_close_del");
            } else {
                $open[$key] = "12:00:00";
                $close[$key] = $open[$key];
                $open_del[$key] = $open[$key];
                $close_del[$key] = $open[$key];
            }

            $opentime = (isset($open[$key])) ? $open[$key] : getTime($open[$key]);
            $closetime = (isset($close[$key])) ? $close[$key] : getTime($close[$key]);
            printrow($layout, $key, $value, $opentime, $closetime, "", "", $is_disabled);
        }
    }
    
    echo '<label class="col-sm-12 row"><hr width="100%" align="center" /></label>';
    

    echo '<label class="col-sm-3 row"><SPAN><b><u>Delivery Times</u>:</b></SPAN></label><div class="col-sm-9"><LABEL class="is_delivery_options"><input type="CHECKBOX" ' . $is_disabled . ' onclick="same(event);" ID="samehours"' . iif($isthesame, " checked") . '>&nbsp; Same as regular Hours Open</LABEL></div>';

    foreach ($day_of_week as $key => $value) {
        $opentime = (isset($open_del[$key])) ? $open_del[$key] : getTime($open_del[$key]);
        $closetime = (isset($close_del[$key])) ? $close_del[$key] : getTime($close_del[$key]);
        if($opentime != $open[$key] || $closetime != $close[$key]){$isthesame=false;}
        printrow($layout, $key, $value, $opentime, $closetime, "_del", "is_delivery_options is_delivery_2", $is_disabled);
    }


    function printrow($layout, $key, $value, $opentime, $closetime, $suffix="", $class = "", $is_disabled = false){
        if($layout){$layout = 9; $width=5;} else {$layout = 2; $width=4; if($suffix){$layout=3;}}//width: 4 is editor, 5 is signup
        $closed = '<LABEL><input type="checkbox" onchange="closed(event, ' . $key . ');" CHECKED> Open</LABEL>';
        ?>
        <div class="row {{ $class }}">
            <label class="col-sm-{{ $layout }}">{{ $value }}</label>
            @if(!$suffix && $layout == 2) <div class="col-sm-1" align="center"><SMALL><SMALL><?php echo $closed; ?></SMALL></SMALL></DIV> @endif
            @if(!$suffix && $layout == 9) <?php echo $closed; ?> @endif
            <div class="col-sm-{{ $width }}">
                <input type="text" name="{{$value}}_open{{$suffix}}" id="open{{$suffix}}[{{ $key }}]" value="{{ $opentime }}" title="Open" class="form-control time" {{ $is_disabled }}/>
            </div>
            <div class="col-sm-1">to</div>
            <div class="col-sm-{{ $width }}">
                <input type="text" name="{{$value}}_close{{$suffix}}" id="close{{$suffix}}[{{ $key }}]" value="{{ $closetime }}" title="Close" class="form-control time" {{ $is_disabled }}/>
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
        same(false);
    }

    function closed(event, ID){
        closed_element(event, ID, "open");
        closed_element(event, ID, "close");
    }
    function closed_element(event, ID, name){
        var element = document.getElementById(name + "[" + ID + "]");
        if (!event.target.checked){
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
            $(".is_delivery_2").hide();
        } else {
            $(".is_delivery_2").show();
        }
    }

    var p = document.getElementById("max_delivery_distance");
    p.addEventListener("input", function() {
        $("#max_delivery_distance").trigger("change");
    }, false);
    $("#max_delivery_distance").trigger("change");

    $( document ).ready(function() {
        same(false);
    });
</script>
