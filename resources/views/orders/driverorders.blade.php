@extends('layouts.default')
@section('content')
<?php
    printfile("views/orders/driverorders.blade.php");
    $drivers = select_field("profiles", "profile_type", 5, false);
    $eighthoursago = now(false, strtotime("-8 hour"));

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
                <TH>Distance</TH>
            </tr>
            </thead>
            <tbody>
                <?php
                    foreach($orders as $order){
                        $order->items = select_field('orderitems', "order_id", $order->id, "COUNT()");
                        echo '<TR ID="order' . $order->id . '"><TD>' . $order->id . '</TD><TD>' . $order->order_time . '</TD><TD>' . $order->items . '</TD></TR>';
                        var_dump($order);
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>

@stop
