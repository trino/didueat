<?php
    printfile("dashboard/restaurant/hours.blade.php");
    $layout = false;
    $day_of_week = getweekdays();
    $use_delivery_hours = true;

    $restaurantID = \Session::get('session_restaurant_id');
    if (!$restaurantID) {
        $restaurantID = 0;
    }
    if (isset($resturant->id)) {
        $restaurantID = $resturant->id;
    }

    $IsPickup = old('is_pickup', -999);
    if ($IsPickup == -999) {
        if (isset($restaurant->is_pickup)) {
            $IsPickup = $restaurant->is_pickup;
        } else {
            $IsPickup = 1;
        }
    }

    if (!isset($is_disabled)) {
        $is_disabled = false;
    }

    $value = (isset($restaurant->max_delivery_distance)) ? $restaurant->max_delivery_distance : old("max_delivery_distance");
    $is_delivery = old('is_delivery') || (isset($restaurant->is_delivery) && $restaurant->is_delivery > 0);

echo newrow($new, "I Offer Pickup",null, false,6,null); ?>
<LABEL class="c-input c-checkbox">
    <input type="checkbox" name="is_pickup" {{ $is_disabled }} id="is_pickup"value="1" {{ ($IsPickup)?'checked':'' }} />
    <span class="c-indicator"></span>
</LABEL>
</DIV></DIV>


<?= newrow($new, "I Offer Delivery",null, false,6,null); ?>
<LABEL class="c-input c-checkbox">
    <input type="checkbox" name="is_delivery" {{ $is_disabled }} id="is_delivery" value="1" {{ ($is_delivery)?'checked':'' }} />
    <span class="c-indicator"></span>
</LABEL>
</DIV></DIV>

<a name="HoursOpen"></a>
<div id="is_delivery_options" style="display: {{ ((isset($restaurant->is_delivery) && $restaurant->is_delivery > 0) || isset($showDeliveryOptions))?'block':'none' }};">
    <?= newrow($new, "Delivery Fee $", "", true, 2); ?>
        <input type="number" step="any" min="0" name="delivery_fee" {{ $is_disabled }} class="form-control" placeholder="Delivery Fee"
               value="{{ (isset($restaurant->delivery_fee))?$restaurant->delivery_fee: old('delivery_fee')  }}"/>
    </DIV></DIV>

    <?= newrow($new, "Minimum Subtotal Before Delivery $", "", true, 2); ?>
        <input type="number" step="any" min="0" name="minimum" {{ $is_disabled }} class="form-control" placeholder="Minimum Subtotal For Delivery $"
           value="{{ (isset($restaurant->minimum))?$restaurant->minimum:old('minimum') }}"/>
    </DIV></DIV>

    <?= newrow($new, "Max Delivery Distance", "", true, 5); ?>
        <input name="max_delivery_distance" {{ $is_disabled }} id="max_delivery_distance" type="range" min="1"
           max="<?= MAX_DELIVERY_DISTANCE; ?>" class="form-control" value="{{ $value }}"
           onchange="$('#max_delivery_distance_label').html('Max Delivery Distance<br/><span>(' + p.value + ' km)</span>');">
    </DIV></DIV>

    <?= newrow($new, "Estimated delivery time", "", true, 2);
        $range = durationtotext(array(15,120,15), false, " ", "", "hour", "min");
        makeselect("aprox_time", $range, (isset($restaurant->aprox_time))?$restaurant->aprox_time:old('aprox_time'));
    ?>
    </DIV></DIV>
</div>

<div class="row">

    <div class="col-md-12 col-xs-12 p-t-1" >
        <h4>Hours</h4>

        <?php
            function getkey($object, $key) {
                return $object->$key;
            }

            $isthesame = true;
            foreach ($day_of_week as $key => $value) {
                if (strpos($value, ">") !== false) {
                    echo $value;
                } else {
                    //$day = select_field_where('hours', array('restaurant_id' => $restaurantID, 'day_of_week' => $value));
                    if (isset($restaurant)) {
                        $open[$key] = getkey($restaurant, $value . "_open");
                        $close[$key] = getkey($restaurant, $value . "_close");
                        $open_del[$key] = getkey($restaurant, $value . "_open_del");
                        $close_del[$key] = getkey($restaurant, $value . "_close_del");
                        if ($open_del[$key] != $open[$key] || $close_del[$key] != $close[$key]) {
                            $isthesame = false;
                        }
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

            function printrow($layout, $key, $value, $opentime, $closetime, $suffix = "", $class = "", $is_disabled = false, $del_class = false){
                $inputclass = "form-control time ";
                $closed = "";
                if (!$suffix) {
                    $closed = '<LABEL class="c-input c-checkbox"><input type="checkbox" onchange="closed(event, ' . $key . ');"';
                    if (($opentime != "00:00:00" || $closetime != "00:00:00") && $opentime != $closetime) {
                        $closed .= " CHECKED";
                    } else {
                        $opentime = "";
                        $closetime = "";
                    }
                    $closed .= '> Open<span class="c-indicator"></span>';
                }
                ?>
                    <div class="clearfix" >
                        <hr />
                    </div>
                    <div class="form-group row" >
                        <div class="col-xs-5">  <?= $closed; ?> {{ $value }}</div></LABEL>
                        <div class="col-sm-7 col-xs-12 {{ $del_class }}">

                            <input type="text" name="{{$value}}_open{{$suffix}}" id="open{{$suffix}}[{{ $key }}]"
                                   value="{{ converttime($opentime) }}"
                                   title="Open" class="{{ $inputclass }} col-xs-4" onfocus="this.blur();"/>

                            <SPAN class="col-xs-4-3 to-span">to</SPAN>

                            <input type="text" name="{{$value}}_close{{$suffix}}" id="close{{$suffix}}[{{ $key }}]"
                                   value="{{ converttime($closetime) }}"
                                   title="Close" class="{{ $inputclass }} col-xs-4" onfocus="this.blur();" />

                        </DIV>
                    </div>
                <?php
            }

            echo newrow($new, " ", ""); //required to stop the datetime picker issue
            echo newrow();
        ?>
    </div>

    <div class="col-md-12 col-xs-12 p-a-0" >
        @if($use_delivery_hours)
            <DIV CLASS="is_delivery_options col-md-12">
                <h4 class="pull-left p-r-1">Hours</h4>
                <LABEL class="">
                    <LABEL class="c-input c-checkbox pull-left" valign="bottom">
                        <input type="CHECKBOX" {{ $is_disabled }} onclick="same(event);" ID="samehours" name="samehours" {{ ($isthesame)? " checked":"" }}>
                        Same as Pickup
                        <span class="c-indicator"></span>
                    </LABEL>
                </LABEL>
                <div class="clearfix"></div>

                <DIV CLASS="is_delivery_2">
                    <?php
                        foreach ($day_of_week as $key => $value) {
                            if (strpos($value, ">") === false) {
                                $opentime_del = (isset($open_del[$key])) ? $open_del[$key] : getTime($open_del[$key]);
                                $closetime_del = (isset($close_del[$key])) ? $close_del[$key] : getTime($close_del[$key]);
                                printrow($layout, $key, $value, $opentime_del, $closetime_del, "_del", "", $is_disabled);
                            }
                        }
                   ?>
                </DIV>
            </div>
        @endif

        <div class="col-md-12">
            <hr class="m-y-1" align="center"/>
            <button type="submit" class="btn btn-primary pull-right">Save</button>
        </div>
    </div>
</div>

<script>
    //handle showing/hiding of delivery-only options
    is_delivery_change();
    function is_delivery_change() {
        if ($('#is_delivery').is(':checked')) {
            $('#is_delivery_options').show();
            $('.is_delivery_options').show();
        } else {
            $('#is_delivery_options').hide();
            $('.is_delivery_options').hide();
        }
        @if($use_delivery_hours)
            same(false);
        @endif
    }

    //close/open a day
    function closed(event, ID) {
        closed_element(event, ID, "open");
        closed_element(event, ID, "close");
        closed_element(event, ID, "open_del");
        closed_element(event, ID, "close_del");
    }

    //close/open an input
    function closed_element(event, ID, name) {
        var element = document.getElementById(name + "[" + ID + "]");
        if(element) {
            if (!event.target.checked) {
                element.setAttribute("old", element.value);
                element.value = "";
            } else {
                var tempstr = element.getAttribute("old");
                if (tempstr || !element.value) {
                    element.value = tempstr;
                }
            }
            change(name, ID);
        }
    }

    //an input was changed, handle it
    function change(type, id) {
        @if($use_delivery_hours)
            if (document.getElementById("samehours").checked) {
                var value = document.getElementById(type + "[" + id + "]").value;
                document.getElementById(type + "_del[" + id + "]").value = value;
            }
        @endif
    }

    //check if the delivery hours should be the same as the pickup hours
    function same(event) {
        @if($use_delivery_hours)
            if (document.getElementById("samehours").checked) {
                for (var i = 0; i < 7; i++) {
                    change("open", i);
                    change("close", i);
                }
                $(".is_delivery_2").hide();
            } else {
                $(".is_delivery_2").show();
            }
        @endif
    }

    var p = document.getElementById("max_delivery_distance");
    p.addEventListener("input", function () {
        $("#max_delivery_distance").trigger("change");
    }, false);
    $("#max_delivery_distance").trigger("change");

    $(document).ready(function () {
        same(false);
    });
</script></script></script></script></script></script></script></script>