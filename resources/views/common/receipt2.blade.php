<style>
    .receipt_image {
        position: relative;
    }
    .pull-bottom {
        position: absolute;
        bottom: 0;
        margin-bottom: 8px;
    }
    .pull-top {
        position: absolute;
        top: 0;
        margin-top: 8px;
    }

    tr.border_bottom td {
        border: 1px solid black !important;
    }
</style>
<?php
    printfile("views/common/receipt2.blade.php");
    $restaurants = array();
    foreach($items as $item){
        $menuitem = select_field("menus", "id", $item->parent_id);
        if(!isset($restaurants[ $menuitem->restaurant_id ])){
            $restaurants[ $menuitem->restaurant_id ] = select_field("restaurants", "id", $menuitem->restaurant_id);
        }
    }
    $curr_rest = 0;
    $curr_rest_subtotal = 0;
    $total = 0;
    $delivery_fee = 5;//per restaurant
    $tax = 13;

    function totals($subtotal, $tip = 0, $tax = 0, $delivery_fee = 0, $message = ""){
        $total = $subtotal + $tip;
        if($tax){
            $total = $subtotal * ( 1 + ($tax * 0.01) ) + $delivery_fee;
        }
        ?>
        @if($tax)
            <tr>
                <td colspan="2" width="75%"><strong>Subtotal {{ $message }}</strong></td>
                <td width="25%"><div class="pull-right subtotal inlineblock">{{ asmoney($subtotal) }}</div></td>
            </tr>
            <tr>
                <td colspan="2"><strong>Tax (<span id="tax inlineblock">{{ $tax }}</span>%)</strong></td>
                <td><div class="pull-right"><span class="tax inlineblock">{{ asmoney($subtotal * $tax * 0.01) }}</span></div></td>
            </tr>
        @endif
        @if($delivery_fee)
            <tr>
                <td colspan="2"><strong>Delivery</strong></td>
                <td><div class="pull-right"><span class="df">{{ asmoney( $delivery_fee ) }}</span></div></td>
            </tr>
        @endif
        @if($tip)
            <tr>
                <td colspan="2"><strong>Tip</strong></td>
                <td class="pull-right"><span>{{ asmoney( $tip ) }}</span></td>
            </tr>
        @endif
        <tr>
            <td colspan="2"><strong>Total {{ $message }}</strong></td>
            <td><div class="grandtotal inlineblock pull-right">{{ asmoney($total) }}</div></td>
        </tr>
        <?php
        return $total;
    }
?>

<div id="cartsz">
    <div class="card">
        <div class="card-block">
            <h4 class="card-title p-b-1">{{ $title }}</h4>

            <div class="receipt_main">
                <div class="totals form-group" style="width:100%;">
                    <table class="orders" style="width:100% !important;">
                        <thead class="itmQty">
                            <tr><th style="width:50px !important;">Qty</th>
                                <th width="60%;">Item</th>
                                <th>
                                    <div class="pull-right">Price</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach($items as $item){
                                    if($item->restaurant_id != $curr_rest){
                                        if(isset($restaurant) && $curr_rest_subtotal){
                                            echo '<TR><TD COLSPAN="3"><HR></TD></TR>';
                                            $total += totals($curr_rest_subtotal,  0, $tax, $delivery_fee," for " . $restaurant->name);
                                        }
                                        $curr_rest = $item->restaurant_id;
                                        $curr_rest_subtotal = 0;
                                        $restaurant = $restaurants[$curr_rest];
                                        echo '<TR class="border_bottom"><TD COLSPAN="3">' . $restaurant->name . '<BR>';
                                        echo $restaurant->address . ', ' . $restaurant->city . " " . $restaurant->province . '</TD></TR>';
                                    }
                                    echo '<TR><TD>' . $item->quantity . '</TD><TD>' . $item->title;
                                    echo '</TD><TD class="pull-right">' . asmoney($item->price) . '</TD></TR>';
                                    $curr_rest_subtotal += $item->price;
                                }
                                $total += totals($curr_rest_subtotal, 0, $tax, $delivery_fee, " for " . $restaurant->name);
                                totals($total, $order->tip);
                            /*
                            var_dump($ID);//6
                            var_dump($title);//Orders Detail
                            var_dump($type);//admin

                            var_dump($user_detail);

                            var_dump($order);
                            foreach($items as $item){
                                var_dump($item);
                            }
                            */
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>