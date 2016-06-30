<style>
    .pull-top {
        position: absolute;
        top: 0;
        margin-top: 8px;
    }
</style>
<?php
    if(!function_exists ("totals")){
        function totals($subtotal, $tip = 0, $tax = 0, $delivery_fee = 0, $message = "", $ordering = false){
            $total = $subtotal + $tip;
            if($tax){
                $total = $subtotal * ( 1 + ($tax * 0.01) ) + $delivery_fee;
            }
            if(!$ordering){ ?>
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
                    <TR><TD COLSPAN="3"><HR></TD></TR>

                @endif
                @if($message !== false)
                    <tr>
                        <td colspan="2"><strong>Total {{ $message }}</strong></td>
                        <td><div class="grandtotal inlineblock pull-right">{{ asmoney($total) }}</div></td>
                    </tr>
                @endif
            <?php }
            return $subtotal;
        }
    }

    printfile("<BR>views/common/receipt2.blade.php");
    $restaurants = array();
    $items = select_field("orderitems", "order_id", $order->id, false );

    if(isset($items)){
        foreach($items as $item){
            $menuitem = select_field("menus", "id", $item->parent_id);
            if(!isset($restaurants[ $menuitem->restaurant_id ])){
                $restaurants[ $menuitem->restaurant_id ] = select_field("restaurants", "id", $menuitem->restaurant_id);
                if(!isset($restaurant)){
                    $restaurant = $restaurants[ $menuitem->restaurant_id ];
                }
            }
        }

        $curr_rest = 0;
        $curr_rest_subtotal = 0;
        $total = 0;
        $total_restaurants = 0;
        $delivery_fee = 5;//per restaurant
        $tax = 13;

        foreach($items as $item){
            if($item->quantity){
                if($item->restaurant_id != $curr_rest && !$ordering){
                    if($curr_rest){// && $curr_rest_subtotal){
                        $restaurant = $restaurants[$item->restaurant_id];
                        $total_restaurants += 1;
                        $total += totals($curr_rest_subtotal,  0, $tax, $delivery_fee," for " . $restaurant->name);
                        echo '<TR><TD COLSPAN="3"><HR></TD></TR>';
                    }
                    $curr_rest = $item->restaurant_id;
                    $curr_rest_subtotal = 0;
                    $restaurant = $restaurants[$curr_rest];

                    echo '<TR><TD COLSPAN="3">' . $restaurant->name . '<BR>';
                    echo $restaurant->address . ', ' . $restaurant->city . " " . $restaurant->province . '</TD></TR>';
                }
                if($ordering){
                    if($item->restaurant_id != $curr_rest){
                        $total_restaurants += 1;
                        $curr_rest = $item->restaurant_id;
                    }
                    echo view("receipt.menuitem", array("menuitem_id" => $item->id, "title" => $item->title, "price" => $item->price, "quantity" => $item->quantity, "restaurant" => $item->restaurant_id));
                } else {
                    echo '<TR><TD>' . $item->quantity . '</TD><TD>' . $item->title;
                    echo '</TD><TD class="pull-right">' . asmoney($item->price) . '</TD></TR>';
                }
                $curr_rest_subtotal += $item->price;
            }
        }

        $total += totals($curr_rest_subtotal, 0, $tax, $delivery_fee, " for " . $restaurant->name, $ordering);
        $order->subtotal = $total;
        $order->restaurants = $total_restaurants;
        $order->tax = $total * 0.13;
        $order->delivery_fee = $delivery_fee;
        //$order->delivery_fee = $delivery_fee * $total_restaurants;
        $order->g_total = $total;
        totals($total, $order->tip, 0,0, false);
    }
?>
