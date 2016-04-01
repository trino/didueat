<?php //ALTER TABLE `restaurants` ADD `payment_methods` INT NOT NULL ;
    printfile("views/dashboard/restaurant/payment.blade.php");
    if(!isset($is_disabled)){$is_disabled = false;}
    function makecheckbox($name, $Checked = false, $is_disabled = false, $onclick = false, $type = "checkbox"){
        if($is_disabled){$is_disabled = " DISABLED";}
        if($Checked){$Checked = " CHECKED";}
        if($onclick){ $onclick = ' ONCLICK="' . $onclick  . '"';}
        return '<LABEL class="c-input c-checkbox"><input type="' . $type . '" name="' . $name . '" ' . $is_disabled . $Checked . $onclick . ' id="' . $type . '" value="1"/><span class="c-indicator"></span></LABEL>';
    }
    $Style="";
    if(!$restaurant){
        echo "RESTAURANT NOT FOUND";
        return;
    }
    if(!$restaurant->is_delivery){
        $Style = ' STYLE="display: none;"';
    }
?>
<TABLE>
    <THEAD>
        <TR>
            <TH style="padding-right:5px">Method</TH>
            <TH style="padding-right:20px">Pickup</TH>
            <TH CLASS="is_delivery_options" {{ $Style }}>Delivery</TH>
        </TR>
    </THEAD>
    <TBODY>
        <?php
            $Value = 1;
            foreach(array("Cash", "Credit Card", "Debit") as $Method){
                echo '<TR>';
                    echo '<TD>' . $Method . '</TD>';
                    foreach(array("Pickup", "Delivery") as $delivery_type){
                        $Checked = $restaurant->payment_methods & $Value;
                        echo '<TD ALIGN="CENTER"';
                        if($delivery_type=="Delivery"){
                            echo ' CLASS="is_delivery_options"' . $Style;
                        }
                        echo '>' . makecheckbox($delivery_type . $Method, $Checked, $is_disabled, "paymentmethod_click(event, " . $Value . ")") . '</TD>';
                        $Value = $Value * 2;
                    }
                echo '</TR>';
            }
        ?>
    </TBODY>
    <TFOOT>
        <TR>
            <TD COLSPAN="3">
                <INPUT TYPE="{{ iif(debugmode(), "TEXT", "HIDDEN") }}" READONLY NAME="payment_methods" ID="payment_methods" VALUE="{{ $restaurant->payment_methods }}">
            </TD>
        </TR>
    </TFOOT>
</TABLE>
<SCRIPT>
    function paymentmethod_click(event, value){
        var payment_methods = $("#payment_methods").val();
        var checked = $(event.target).is(":checked");
        if(checked){
            payment_methods = payment_methods | value;
        } else {
            payment_methods = payment_methods & (~value);
        }
        $("#payment_methods").val(payment_methods);
    }
</SCRIPT>