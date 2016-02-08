<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="width:100%">
        <?php
            $order = select_field("reservations", "id", $orderid);
            $restaurant = select_field("restaurants", "id", $order->restaurant_id);
            $user_detail = select_field("profiles", "id", $order->user_id);
        ?>
        <h4>Order # {{$order->id}} ({{$order->status}})</h4>

        <div class="row">
            <div class="col-md-6">
                @include('common.orderinfo', array("order" => $order, "restaurant" => $restaurant, "user_detail" => $user_detail))
            </div>

            <div class="col-md-6">
                @include('common.receipt', array("order" => $order, "restaurant" => $restaurant, "user_detail" => $user_detail, "email" => true))
            </div>
            <div class="clearfix"></div>
        </div>

        <a href="{{ url("/orders/list/cancel/email/" . $email . "/" . $order->guid) }}">Decline</a>
        <a href="{{ url("/orders/list/approve/email/" . $email . "/" . $order->guid) }}">Accept</a>

    </body>
</html>