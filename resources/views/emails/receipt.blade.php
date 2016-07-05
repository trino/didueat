<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" @if(!isset($order)) style="width:100%" @else style="width:800px" @endif>
        <?php
            if(!isset($email)){$email = false;}
            printfile($profile_type . " views/emails/receipt.blade.php<BR>Email: " . $email);

            $order = select_field("orders", "id", $orderid);
            $guid = $orderid;
            $restaurant = firstrest($orderid);

            $user_detail = select_field("profiles", "id", $order->user_id);
            $receipt = view('common.orderinfo', array("order" => $order, "restaurant" => $restaurant, "user_detail" => $user_detail));
            $view = view('common.receipt', array("order" => $order, "restaurant" => $restaurant, "user_detail" => $user_detail, "email" => true, "hash" => true));
            $hash = hashtext($receipt . $view);
        ?>
        <!--h4 style="">Order Status:&nbsp; <span style="color:#f00">{{$order->status}}</span><br/><span style="font-weight:normal;">Note: You will receive a confirmation email when your order has been finalized</span></span></h4>

        <h3 style="margin-left:10px">Please indicate whether you Accept or Decline this order:  <span style="color:#FF0000">(Is this needed. What if user doesn't check email) ANSWER: Yes, it's for the store</span>
            <div style="margin-left:10px">
                <a href="{{ url("/orders/list/approve/email/" . $email . "/" . $guid) }}">Accept</a>&nbsp; &nbsp;
                <a href="{{ url("/orders/list/cancel/email/" . $email . "/" . $guid) }}">Decline</a>
            </div>
        </h3-->
        <TABLE WIDTH="100%">
            <TR>
                <TD COLSPAN="2">
                    <table><tr><td>We've received your {{ DIDUEAT }} order. Please stand by, your food will be arriving soon.</td></tr></table>
                </TD>
            </TR>
            <TR>
                <TD WIDTH="50%" class="orderinfo"><?= $receipt; ?></TD>
                <TD WIDTH="50%" class="receipt"><?= $view;  ?></TD>
            </TR>
            <TR>
                <TD COLSPAN="2"><?= $hash; ?></TD>
            </TR>
        </TABLE>

        <div class="clearfix"></div>
        @include("emails.footer")
    </body>
</html>