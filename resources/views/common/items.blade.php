<?php printfile("views/common/items.blade.php"); ?>
<table class="orders @if(!isset($order)) order-style @endif" style=" width:100% !important; ">
    <!--thead class="itmQty" <?php if (isset($order) && isset($arr_menu) && count($arr_menu)) echo ''; else echo 'style="display:none;"';?>>
        <TH style="width:50px !important;<?php if($em){?>text-align:left;<?php }?>">Qty</TH>
        <TH width="60%;" <?php if($em){?>style="text-align:left;"<?php }?>>Item</TH>
        <TH <?php if($em){?>style="text-align:left;"<?php }?>>
            <div class="pull-right">Price</div>
        </TH>
    </thead-->
    <TBODY>
        <?php
            if(!isset($ordering)){$ordering = false;}
            if(ReceiptVersion == 2 && isset($order)){
                ?> @include("common.receipt2") <?php
                if(!isset($restaurant)){$restaurant = firstrest($items); } //get first restaurant in the order
            } else {
                $alts = array(
                        "csr" => "What to do if something is wrong with the order"
                );
                $Actions = array("Go with merchant suggestion", "Refund this item", "Contact me", "Cancel entire order");

                if(isset($order)){
                    $menu_ids = $order->menu_ids;
                    $arr_menu = explode(',', $menu_ids);
                    $arr_qty = explode(',', $order->qtys);
                    $arr_prs = explode(',', $order->prs);
                    $arr_extras = explode(',', $order->extras);
                    $csr_actions = explode(',', $order->csr);

                    foreach ($arr_menu as $k => $me) {
                        $extz = "";
                        if ($order->extras != "") {
                            $extz = str_replace(array('%', ':', ' :'), array(',', ': ', ':'), $arr_extras[$k]);
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
                                    <span class='menu_bold'>{{ $tt }}</span>
                                    <?php
                                        if ($extz != '') echo ":";
                                        //$extz = str_replace("<br/>", ", ", trim($extz, "<br/>"));
                                        echo $extz;
                                        if($showCSR){
                                            if(!isset($csr_actions[$k])){$csr_actions[$k] = 0;}
                                            echo "<br/><i class='text-muted'>".$Actions[$csr_actions[$k]].'</i>';
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
            }
        ?>

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