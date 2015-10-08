<ul class="scroller orders" <?php if(!isset($order)){?>style="height: 220px;"<?php }?>>
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
                    $m = \App\Http\Models\Menus::where('id',$me)->first();
                    $tt = $m->menu_item;
                }
                ?>
                <li id="list<?= $order->listid;?>" class="infolist" >
                  <span class="receipt_image">
                  <img src='{{url("assets/images/products/$m->image")}}' alt="{{$m->menu_item}}" width="37" height="34">
                  <span class="count">x <?= $arr_qty[$k];?></span><input type="hidden" class="count" name="qtys[]" value="1" />
                  </span>
                  <strong><?php echo "<span class='menu_bold'>".  $tt . "</span>:" . str_replace('<br/>','',$extz);?></strong>
                  <em class="total">$ <?= number_format(($arr_qty[$k] * $arr_prs[$k]), 2);?></em>
                  <span class="amount" style="display:none;"> <?= number_format($arr_prs[$k], 2);?></span>
                  <input type="hidden" class="menu_ids" name="menu_ids[]" value="1" />
                  <input type="hidden" name="extras[]" value="Watch Rolex Classic "/>
                  <input type="hidden" name="listid[]" value="2" />
                  <input type="hidden" class="prs" name="prs[]" value="<?= number_format(($arr_qty[$k] * $arr_prs[$k]), 2);?>" />
                </li>
            <?php
            }
        }
    ?>
</ul>
