<?php //menu_id, parent_id, quantity, price, csr_action, title, extratitle, dbtitle ; ?>
<div ID="menuitem_{{ $menuitem_id }}" menuid="{{ $parent_id }}" class="menuitem">
    <td valign="top">
        <SELECT id="selectitem_{{ $menuitem_id }}" onchange="updatequantity({{ $menuitem_id }});" class="btn btn-secondary">
            <?php
                for ($i = 0; $i <= 10; $i++) {
                    echo '<OPTION';
                    if ($quantity == $i) {
                        echo ' SELECTED';
                    }
                    echo '>' . $i . '</OPTION>';
                }
                $restid = "";
                if (debugmode() && isset($restaurant)) {
                    $restid = ' <FONT COLOR="RED">Rest: ' . $restaurant . '</FONT>';
                }
            ?>
        </SELECT>
    </td>
    <div class="innerst" width="60%">{!! $title . $restid !!}</div>
    <TD id="totalitem_{{ $menuitem_id }}" class="total">{{ asmoney($price * $quantity) }}</TD>
</div>