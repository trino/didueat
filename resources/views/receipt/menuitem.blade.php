<?php //menu_id, parent_id, quantity, price, csr_action, title, extratitle, dbtitle ;
$restaurant_id = select_field("menus", "id", $parent_id, "restaurant_id");
$restaurant = select_field("restaurants", "id", $restaurant_id);
?>
<div style="width: 100%;" ID="menuitem_{{ $menuitem_id }}" itemid="{{ $menuitem_id }}" menuid="{{ $parent_id }}"
     restaurant="{{ $restaurant_id }}" latitude="{{ $restaurant->latitude }}" longitude="{{ $restaurant->longitude }}"
     name="{{ $restaurant->name }}" maxdistance="{{ $restaurant->max_delivery_distance }}"
     class="receipt_item receipt_item_{{ $parent_id }}">
        <SELECT id="selectitem_{{ $menuitem_id }}" onchange="updatequantity({{ $menuitem_id }});"
                class="btn btn-secondary">
            <?php
            for ($i = 0; $i <= 10; $i++) {
                echo '<OPTION';
                if ($quantity == $i) {
                    echo ' SELECTED';
                }
                echo '>' . $i . '</OPTION>';
            }
            $restid = "";
            if (debugmode() && isset($restaurant_id)) {
                $restid = ' <FONT COLOR="RED">Rest: ' . $restaurant_id . '</FONT>';
            }
            ?>
        </SELECT>
    <div class="innerst" width="">{!! $title . $restid !!}</div>
    <TD id="totalitem_{{ $menuitem_id }}" class="total">{{ asmoney($price * $quantity) }}</TD>
</div>