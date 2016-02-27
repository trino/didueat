<TABLE style="width:100%;">
    <?php
        printfile("views/common/orderinfo.blade.php");

        //$Data = array("Status" => $order->status);
        $Data['Order #'] = $order->guid;
        $Data['Status'] = $order->status;
        $Data["Customer"] = $order->ordered_by;

        $Data["Order Type"] = iif($order->order_type == '1', "Delivery", "Pickup");

        if(isset($paid_for)){
        $Data["Payment"] = iif($paid_for == '1', "Paid Online", "Cash on " . $Data["Order Type"]);
}


        $date = new DateTime($order->order_time);//$date->format('l jS \of F Y h:i:s A');
        $Data["Time Ordered"] = $date->format(get_date_format());

        if ($order->order_till != "0000-00-00 00:00:00") {
            if(!$order->order_till){
                $Data["Ordered For"] = "As soon as possible";

            }else{
                $date = new DateTime($order->order_till);//$date->format('l jS \of F Y h:i:s A');
                $Data["Ordered For"] = $date->format(get_date_format());


            }
        }

        if (isset($user_detail) && is_object($user_detail)) {
            $Data["Customer"] = $user_detail->name;
            $Data["Email"] = $user_detail->email;
            $Data["Cell Phone"] = $user_detail->phone;
        }

        if ($order->order_type == '1') {
            $Data['Address'] = $order->address2;
            $Data['City'] = $order->city;
            if(!isset($order->prov) || !$order->prov){$order->prov = "ON";}
            $Data['Prov'] = $order->prov;
            $Data['PC'] = $order->postal_code;
        }

        if ($order->remarks) {
            $Data["Additional Notes"] = $order->remarks;
        }

      //  $Data["Date format"] = get_date_format();

        foreach ($Data as $Key => $Value) {
            echo '<TR class="infolist noprint"><TD class="padright15"><strong>' . $Key . '</strong> </TD><TD WIDTH="5"></TD><TD>' . $Value . "</TD></TR>";
        }
    ?>
</TABLE>