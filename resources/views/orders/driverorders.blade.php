@extends('layouts.default')
@section('content')
<script src="{{ url("assets/global/scripts/provinces.js") }}" type="text/javascript"></script>
<div class="container">



<?php
    printfile("views/orders/driverorders.blade.php");
    $drivers = select_field("profiles", "profile_type", 5, false);
    $eighthoursago = now(false, strtotime("-8 hour"));
    function statuscolor($Status, $Color = false){
        switch ($Status) {
            case "incomplete":
                return iif($Color, 'BLUE', "btn-secondary");
                break;
            case "approved":
                return iif($Color, 'GREEN', "btn-success");
                break;
            case "cancelled":
                return iif($Color, 'RED', "btn-danger");
                break;
            case "pending":
                return iif($Color, 'ORANGE', "btn-warning");
                break;
        }
    }
    $alts = array(
            "order_detail" => "View the order"
    );

    function formatdate($date){
        $dateformat = get_date_format();//D M d, g:j A
        $date = strtotime($date);
        $prepend="";
        if (date("dmY", $date) == date("dmY")) {
            $prepend =  'Today, ';
            $dateformat = str_replace("D M d,", "", $dateformat);
        }
        return $prepend . date($dateformat, $date);
    }

    function sort_array($array, $key, $ascending = true){
        $new_array = array();
        $sortable_array = array();
        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $key) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }
            if($ascending){
                asort($sortable_array);
            } else {
                arsort($sortable_array);
            }
            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }
        return $new_array;
    }

    function var_dump2($varname, $var = ""){
        echo "<BR>" . $varname . iif($var, ": ") . $var;
    }

    var_dump2("address", $address);
    var_dump2("latitude", $latitude);
    var_dump2("longitude", $longitude);
    var_dump2("city", $city);
    var_dump2("province", $province);
    var_dump2("postal_code", $postal_code);
    var_dump2("country", $country);
    var_dump2("eighthoursago", $eighthoursago);
    var_dump2("now", now());

    foreach($drivers as $key => $driver){
        $driver->is_available = iif($driver->available_at > $eighthoursago, 1,0);
        $drivers[$key] = object_to_array($driver);
    }
    $drivers = sort_array($drivers, "available_at", false);

    $where = array(
            "driver_id" => 0,
            "status" => "pending",
            "subtotal > 0"
    );
    $orders = select_field_where("orders", $where, false);
?>

@include("dashboard.usercontrols.addresses")

<SCRIPT>
    function addresschange(where){
        log("driverorders.blade");
        where = $("#reservation_address option:selected").get(0);
        var latitude = where.getAttribute("latitude");
        var longitude = where.getAttribute("longitude");

        $(".distance").each(function() {
            var order_latitude = $( this ).attr("latitude");
            var order_longitude = $( this ).attr("longitude");
            var distance = calcdistance(latitude, longitude, order_latitude, order_longitude);
            $(this).text(distance.toFixed(2) + " km");
        });
    }
</SCRIPT>

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-lg-9">
                <h4 class="card-title">
                    Drivers
                </h4>
            </div>
        </div>
    </div>

    <div class="card-block p-a-0">
        <table class="table table-responsive m-b-0">
            <thead>
                <tr>
                    <th>ID #</th>
                    <th>Name</th>
                    <TH>Available</TH>
                    <TH>Orders</TH>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($drivers as $driver){
                        $ordercount = "N/A";
                        if($driver["is_available"]){
                            $where = array(
                                    "driver_id" => $driver["id"],
                                    "status" => "approved",
                                    "order_time > '" . $driver["available_at"] . "'"
                            );
                            $orders = select_field_where("orders", $where, false);
                            $ordercount = count($orders);
                        }

                        echo '<TR><TD>' . $driver["id"] . '</TD><TD>' . $driver["name"] . '</TD><TD>' . iif($driver["is_available"], "Yes", "No") . '</TD><TD>' . $ordercount . '</TD></TR>';
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-lg-9">
                <h4 class="card-title">
                    Unassigned Orders ({{ count($orders) }})
                </h4>
            </div>
        </div>
    </div>

    <div class="card-block p-a-0">
        <table class="table table-responsive m-b-0">
            <thead>
            <tr>
                <th>ID #</th>
                <th>Placed at</th>
                <TH>Items</TH>
                <TH>Restaurants</TH>
                <TH>Distance</TH>
            </tr>
            </thead>
            <tbody>
                <?php
                    foreach($orders as $order){
                        $restaurants = array();
                        $order->items = select_field('orderitems', "order_id", $order->id, false);
                        foreach($order->items as $item){
                            if(!isset($restaurants[$item->restaurant_id])){
                                $restaurants[$item->restaurant_id] = select_field("restaurants", "id", $item->restaurant_id);
                            }
                        }

                        $URL = url('orders/order_detail/' . $order->id . '/driver');
                        echo '<TR CLASS="order" ID="order' . $order->id . '" orderid="' . $order->id . '"><TD>';
                        echo '<a href="' . $URL . '" title="' . $alts["order_detail"] . '" class="btn ' . statuscolor($order->status) . ' btn-sm" style="width:100%">' . $order->id . '</a>';
                        echo '</TD><TD>' . formatdate($order->order_time) . '</TD><TD>' . count($order->items) . '</TD><TD style="padding: 0px;">';

                        echo '<TABLE>';
                        foreach($restaurants as $restaurant){
                            echo '<TR><TD>' . $restaurant->name . '</TD><TD CLASS="distance" latitude="' . $restaurant->latitude . '" longitude="' . $restaurant->longitude . '"></TD></TR>';
                        }
                        echo '</TABLE>';

                        echo '</TD><TD CLASS="distance" latitude="' . $order->latitude . '" longitude="' . $order->longitude . '"></TD></TR>';
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>
</div>

@stop
