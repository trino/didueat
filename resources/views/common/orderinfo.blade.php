<?php
    $em=0;
    if(isset($email_msg)){
        $em = 1;
    }
?>
<TABLE style="width:100%;<?php if($em){?>padding: 15px 0;<?php }?>">
    <?php
        printfile("views/common/orderinfo.blade.php");
        if ($order->remarks) {
            $Data["Notes"] = $order->remarks;
        }
        //$Data = array("Status" => $order->status);
        $Data['Order #'] = $order->guid;

        if($type != "user"){
            $Data['Status'] = $order->status;
        }
        
        $Data["Type"] = iif($order->order_type == '1', "Delivery", "Pickup");
        $Data["Payment"] = iif( (isset($paid_for) && $paid_for == '1') || $order->paid, "Paid Online", "Cash on " . $Data["Type"]);



    $date = new DateTime($order->order_time);//$date->format('l jS \of F Y h:i:s A');
    $Data["On"] = $date->format(get_date_format());

    if ($order->order_till != "0000-00-00 00:00:00") {
        if(!$order->order_till){
            $Data["For"] = "As soon as possible";
        }else{
            $date = new DateTime($order->order_till);//$date->format('l jS \of F Y h:i:s A');
            $Data["For"] = $date->format(get_date_format());
        }
    }

    $Data["Customer"] = $order->ordered_by;

    if ($order->order_type == '1') {
        if(!isset($order->prov) || !$order->prov){$order->prov = "ON";}
        $Data['Address'] = $order->address2 . ', ' . $order->city. ' ' . $order->prov. ' ' . $order->postal_code;

    }


    $Data['Address Notes'] = $order->note;


        if (isset($user_detail) && is_object($user_detail)) {
            $Data["Customer"] = $user_detail->name;
            $Data["Cell Phone"] = $user_detail->phone;
            $Data["Email"] = $user_detail->email;

        }




        // $Data["Date format"] = get_date_format();

        if(isset($hash)){
            $hash="";
            foreach ($Data as $Key => $Value) {
                $hash .= $Key . $Value;
            }
            $Data["Hash"] = hashtext($hash);
        }

        foreach ($Data as $Key => $Value) {
            echo '<TR class="infolist noprint"><TD class="padright15"><strong>' . $Key . '</strong> </TD><TD WIDTH="5"></TD><TD>' . $Value . "</TD></TR>";
        }
    ?>
</TABLE>