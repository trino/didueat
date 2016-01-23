<TABLE>
<?php
    printfile("views/common/orderinfo.blade.php");

    $date = new DateTime($order->order_time);//$date->format('l jS \of F Y h:i:s A');

    $Data = array("Ordered By" => $order->ordered_by);
    $Data["Status"] = $order->status;

    if(isset($user_detail) && is_object($user_detail)){
        $Data["Ordered By"] = $user_detail->name;
        $Data["Email"] = $user_detail->email;
    }

    $Data["Contact"] = $order->contact;
    $Data["Phone"] = $order->contact;
    $Data["Order Type"] = iif($order->order_type == '1', "Delivery", "Pickup");
    $Data["Ordered On"] =  $date->format(get_date_format());
    if(isset($restaurant->name)){
        $Data["Restaurant"] = $restaurant->name;
    }
    if($order->order_till != "0000-00-00 00:00:00"){
        $Data["Order Ready"] = $order->order_till;
    }
    if($order->remarks){
        $Data["Notes"] = $order->remarks;
    }
    foreach($Data as $Key => $Value){
        echo '<TR class="infolist noprint nowrap"><TD>' . $Key . ': </TD><TD WIDTH="5"></TD><TD>' . $Value . "</TD></TR>\r\n";
    }
?>
</TABLE>