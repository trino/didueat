<?php printfile("views/common/items.blade.php"); ?>
<table class="table scroller orders @if(!isset($order)) order-style @endif">
<thead>
    <th width='15%'>Qty</th><th>Item</th><th>Price</th>
</thead>
@if(isset($order))
    <?php
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
                //echo "<pre>"; print_r($m);die;
                $tt = (isset($m->menu_item)) ? $m->menu_item : '';
            }
            $menu_item = (isset($m->menu_item)) ? $m->menu_item : '';
            $image = (isset($m->image) && !empty($m->image)) ? $m->image : 'default.png';
    ?>
    <tr id="list{{ $order->listid }}" class="infolist">
        <td class="receipt_image">
                
              <!--img src='{{ asset("assets/images/products/".$image) }}' alt="{{ $menu_item }}" width="37" height="34"-->
              <b><span class="count">{{ $arr_qty[$k] }} x</span></b><input type="hidden" class="count" name="qtys[]" value="1" />
        </td>
        <td><span class='menu_bold'>{{ $tt }}</span>: {{ str_replace('<br/>', '', $extz) }}</td>
        <td class="total">$ {{ number_format(($arr_qty[$k] * $arr_prs[$k]), 2) }}</td>
        <span class="amount" style="display:none;"> {{ number_format($arr_prs[$k], 2) }}</span>
        <input type="hidden" class="menu_ids" name="menu_ids[]" value="1"/>
        <input type="hidden" name="extras[]" value=""/>
        <input type="hidden" name="listid[]" value="2"/>
        <input type="hidden" class="prs" name="prs[]" value="{{ number_format(($arr_qty[$k] * $arr_prs[$k]), 2) }}" />
    </tr>
    <?php } ?>
    @endif
</table>
