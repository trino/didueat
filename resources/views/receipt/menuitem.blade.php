<?php //menu_id, ids, quantity, price, csr_action, title, extratitle, dbtitle ; ?>
<TR ID="menuitem_{{ $menuitem_id }}">
    <TD valign="top">
        <SELECT id="selectitem_{{ $menuitem_id }}" onchange="updatequantity({{ $menuitem_id }});" style="border:0 !important;padding:0rem !important;margin-right:.1rem !important;" class="btn btn-secondary">
            <?php
                for($i = 0; $i <= 10; $i++){
                    echo '<OPTION';
                    if($quantity == $i){
                        echo ' SELECTED';
                    }
                    echo '>' . $i . '</OPTION>';
                }
                $restid="";
                if(debugmode() && isset($restaurant)){
                    $restid = ' <FONT COLOR="RED">Rest: ' . $restaurant . '</FONT>';
                }
            ?>
        </SELECT>
    </TD>
    <TD class="innerst" width="60%">{!! $title . $restid !!}</TD>
    <TD valign="top" id="totalitem_{{ $menuitem_id }}" class="total">{{ asmoney($price * $quantity) }}</TD>
</TR>