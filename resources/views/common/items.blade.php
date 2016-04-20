<?php printfile("views/common/items.blade.php"); ?>
<table class="orders @if(!isset($order)) order-style @endif" style=" width:100% !important; ">
    <thead class="itmQty" <?php if (isset($order) && isset($arr_menu) && count($arr_menu)) echo ''; else echo 'style="display:none;"';?>>
        <TH style="width:50px !important;<?php if($em){?>text-align:left;<?php }?>">Qty</TH>
        <TH width="60%;" <?php if($em){?>style="text-align:left;"<?php }?>>Item</TH>
        <TH <?php if($em){?>style="text-align:left;"<?php }?>>
            <div class="pull-right">Price</div>
        </TH>
    </thead>
    <TBODY>
        <?php
            $alts = array(
                    "csr" => "What to do if something is wrong with the order"
            );

            if(isset($order)){
                $menu_ids = $order->menu_ids;
                $arr_menu = explode(',', $menu_ids);
                $arr_qty = explode(',', $order->qtys);
                $arr_prs = explode(',', $order->prs);
                $arr_extras = explode(',', $order->extras);

                foreach ($arr_menu as $k => $me) {
                    if ($order->extras != "") {
                        $extz = str_replace(array("% ", ':'), array(" ", ': '), $arr_extras[$k]);
                        $extz = str_replace("%", ",", $extz);
                    } else {
                        $extz = "";
                    }
                    if (is_numeric($me)) {
                        $m = \App\Http\Models\Menus::where('id', $me)->first();
                        $tt = (isset($m->menu_item)) ? $m->menu_item : '';
                    }
                    $menu_item = (isset($m->menu_item)) ? $m->menu_item : '';
                    $image = (isset($m->image) && !empty($m->image)) ? $m->image : 'default.png';
                    ?>
                        <tr id="list{{ $order->listid }}" class="infolist">
                            <td valign="top" class="receipt_image" style='@if(isset($order)) width:20%; @else width:50px !important; @endif'>
                                @if(isset($order)) <span class="count">{{ $arr_qty[$k] }}</span> @endif
                                @if($showCSR) <BR><i id="spin{{ $order->id }}" class="fa fa-spinner fa-spin pull-bottom" style="display:none;"></i> @endif
                            </td>

                            <td @if(isset($order)) style='width:55%;' @endif>
                                <input type="hidden" class="count" name="qtys[]" value="{{ $arr_qty[$k] }}"/>
                                <span class='menu_bold'>{{ $tt }}</span><?php if ($extz != '') echo ":";?> {{ str_replace('<br/>', '', $extz) }}
                                    <?php
                                        if($showCSR){
                                            $Actions = array("Go with merchant recommendation", "Refund this item", "Contact me", "Cancel entire order");
                                            if(isset($order->csr) && $order->csr)
                                            echo "<br/><b>".$Actions[$order->csr].'</b>';
                                            else
                                            echo "<br/><b>".$Actions[0].'</b>';
                                        }
                                    ?>
                            </td>

                            <td valign="top" class="total text-xs-right" @if(isset($order)) style='width:25%;' @endif>${{number_format($arr_prs[$k],2)}}</td>

                            <input type="hidden" class="amount" value="{{number_format($arr_prs[$k], 2)}}">
                            <input type="hidden" class="menu_ids" name="menu_ids[]" value="1"/>
                            <input type="hidden" name="extras[]" value=""/>
                            <input type="hidden" name="listid[]" value="2"/>
                            <input type="hidden" class="prs" name="prs[]" value="{{ number_format(($arr_qty[$k] * $arr_prs[$k]), 2) }}"/>
                        </tr>
                    <?php
                }
            }
        ?>
    </TBODY>
</table>
@if($showCSR)
    <STYLE>
        .receipt_image {
            position: relative;
        }
        .pull-bottom {
            position: absolute;
            bottom: 0;
            margin-bottom: 8px;
        }
    </STYLE>
    <SCRIPT>
        function changecsr(event){
            var ID = $(event.target).attr("index");
            var Action = $(event.target).val();
            $("#spin" + ID).show();
            $.post("{{ url('ajax') }}", {_token: "{{ csrf_token() }}", type: "csr", id: ID, action: Action}, function (result) {
                $("#spin" + ID).hide();
                if(result) {alert(result);}
            });
        }
    </SCRIPT>
@endif