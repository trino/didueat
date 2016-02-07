<TABLE class="">
    <?php
    printfile("views/common/orderinfo.blade.php");

    $date = new DateTime($order->order_time);//$date->format('l jS \of F Y h:i:s A');

    $Data = array("Customer" => $order->ordered_by);


    if (isset($user_detail) && is_object($user_detail)) {
        $Data["Customer"] = $user_detail->name;
        $Data["Email"] = $user_detail->email;
    }
    $Data["Phone"] = $order->contact;

    $Data["Order Type"] = iif($order->order_type == '1', "Delivery", "Pickup");

    if ($order->order_type == '1') {
        $Data['Address'] = $order->address2;
        $Data['City'] = $order->city;
        $Data['Prov'] = $order->prov;
        $Data['Postal Code'] = $order->postal_code;

    }
    $Data["Time Ordered"] = $date->format(get_date_format());

    if ($order->order_till != "0000-00-00 00:00:00") {
        $Data["Order Ready"] = $order->order_till;
    }
    if ($order->remarks) {
        $Data["Additional Notes"] = $order->remarks;
    }
    foreach ($Data as $Key => $Value) {
        echo '<TR class="infolist noprint nowrap"><TD class="padright15"><strong>' . $Key . '</strong> </TD><TD WIDTH="5"></TD><TD>' . $Value . "</TD></TR>\r\n";
    }
    ?>
</TABLE>