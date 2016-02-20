<?php printfile("views/common/items.blade.php"); ?>
<table class="orders @if(!isset($order)) order-style @endif" width="100%">
    <thead class="itmQty" <?php if (isset($order) && isset($arr_menu) && count($arr_menu)) echo ''; else echo 'style="display:none;"';?>>
        <TH style="width:40px;">Qty</TH>
        <TH width="60%">Item</TH>
        <TH>
            <div class="pull-right">Price</div>
        </TH>
    </thead>
    <TBODY>
        <?php
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
                            <td class="receipt_image" style='width:40px;'>
                                <span class="count">{{ $arr_qty[$k] }} </span>
                                <input type="hidden" class="count" name="qtys[]" value="1"/>
                            </td>

                            <td>
                                <span class='menu_bold'>{{ $tt }}</span><?php if ($extz != '') echo ":";?> {{ str_replace('<br/>', '', $extz) }}
                            </td>

                            <td class="total text-xs-right">${{number_format($arr_prs[$k],2)}}</td>

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