<?php printfile("views/common/items.blade.php"); ?>

<table width="100%">
<thead class="itmQty" >
    <th width='26%'>Qty</th><th width="50%">Item</th><th>Price</th>
</thead>
<tr>
    <td colspan="3">
        <div class="scroller" data-height='150px'>
        <table class="orders @if(!isset($order)) order-style @endif">    

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
        <td class="receipt_image" width='26%'>
                
             
              <span class="count">{{ $arr_qty[$k] }} </span><input type="hidden" class="count" name="qtys[]" value="1" />
        </td>

        <td style="50%"><span class='menu_bold'>{{ $tt }}</span><?php if($extz!='')echo ":";?> {{ str_replace('<br/>', '', $extz) }}</td>
        <!--td class="total">$ {{ number_format(($arr_qty[$k] * $arr_prs[$k]), 2) }}</td-->
        <td class="total">${{number_format($arr_prs[$k],2)}}</td>

        <span class="amount" style="display:none;"> {{ number_format($arr_prs[$k], 2) }}</span>
        <input type="hidden" class="menu_ids" name="menu_ids[]" value="1"/>
        <input type="hidden" name="extras[]" value=""/>
        <input type="hidden" name="listid[]" value="2"/>
        <input type="hidden" class="prs" name="prs[]" value="{{ number_format(($arr_qty[$k] * $arr_prs[$k]), 2) }}" />
    </tr>
    <?php } ?>
    @endif
</table>
</div>
</td></tr>
</table>
