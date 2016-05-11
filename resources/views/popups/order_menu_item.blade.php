@if (Session::get('session_type_user') == "super" )
        <!--div class="col-sm-12 col-xs-12">
        <p class="">Views: {{ ViewsCountsType($value->id, "menu") }}</p>
    </div-->
@endif

<div class="modal" id="product-pop-up_{{ (isset($value->id))?$value->id:'' }}" tabindex="-1" role="dialog"
     aria-labelledby="viewDetailModelLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php
            printfile("resources/views/popups/order_menu_item.blade.php");
            $alts = array(
                    "addspan" => "Add this addon",
                    "remspan" => "Remove this addon",
                    "add" => "Add these items to your cart",
                    "minus" => "Remove 1 item",
                    "plus" => "Add 1 item",
                    "bigimage" => "This item's picture",
                    "csr" => "What to do if something is wrong with the order"
            );
            ?>
            <style>
                .image {
                    position: relative;
                    max-width: 100% !important; /* for IE 6 */
                }

                .fronttext {
                    position: absolute;
                    top: 0px;
                    left: 0;
                }
            </style>

            @if ($has_bigImage)
                <img src="{{$item_bigImage }}" style="max-width:100%;" alt="{{ $alts["bigimage"] }}"/>
            @endif

            <div style=" width:100%; border:0; @if ($has_bigImage)background:transparent !important; @endif"
                 class=" bg-inverse card-header @if ($has_bigImage) fronttext @else bg-success @endif">
                <button type="button" class="close close<?php echo $value->id; ?>" data-dismiss="modal" title="Close" aria-label="Close" id="clear_<?php echo $value->id; ?>">
                    <span aria-hidden="true" style="  @if ($has_bigImage) text-shadow: 1px 1px 9px rgba(0, 0, 0, 2);color:white !important; opacity: .8 !important; @endif">&times;</span>
                </button>

                <h4 class="modal-title " style="" id="viewDetailModel">
<span class="bg-success">
           {{ $value->menu_item }} &ndash; @if($value->price>0)


    @if($dis)
            <!--span class=''>{{$dis}}</span-->
                    <strike class="text-muted strikedprice{{$value->id}}">${{$dis_price=number_format($value->price,2)}}</strike>
                    <input type="hidden" class="mainPrice{{$value->id}}" value="{{$dis_price}}"/>
                            <span style="" class="pricetitle modalprice<?php echo $value->id; ?>">
                                ${{number_format($dis_price=$main_price,2)}}
                            </span>
    @else
        <span class="pricetitle modalprice<?php echo $value->id; ?>">
                                    ${{$dis_price=number_format($value->price,2)}}
                            </span>
    @endif
    @else
        <span style="" class="pricetitle modalprice<?php echo $value->id; ?>">
                            ${{$dis_price=number_format($min_p,2)}}+
                        </span>
    @endif

    <span class="fa fa-spinner fa-spin cart-addon-gif" style="color:#0275d8; display: none;"></span>

    </span>

                    <input type="hidden" id="actualprice<?php echo $value->id; ?>" value="{{$value->price}}"/>
                    <input type="hidden" id="originalprice<?php echo $value->id; ?>" value="{{$value->price}}"/>
                    <input type="hidden" class="displayprice<?php echo $value->id; ?>" value="{{$dis_price}}"/>
                    <input type="hidden" class="Mprice<?php echo $value->id; ?>" value="{{$dis_price}}"/>
                </h4>

                <div class="clearfix"></div>
            </div>


            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">{{ $value->description }}</div>


                    <div class="col-md-12 subitems_{{ $value->id }} optionals">
                        <div style="display:none;">
                            <input type="checkbox" style="display: none;" checked="checked"
                                   title="{{ $value->id.'_<b>'.$value->menu_item.'</b>_'.$main_price.'_' }}"
                                   value="" class="chk">
                        </div>

                        <div class="banner bannerz">

                            <table style="min-width:100%;">
                                <tbody>

                                @foreach ($submenus as $sub)

                                    <tr>
                                        <td width="100%" id="td_{{ $sub->id }}" class="valign-top">

                                            <input type="hidden" value="{{ $sub->exact_upto_qty }}"
                                                   id="extra_no_{{ $sub->id }}">
                                            <input type="hidden" value="{{ $sub->req_opt }}"
                                                   id="required_{{ $sub->id }}">
                                            <input type="hidden" value="{{ $sub->sing_mul }}"
                                                   id="multiple_{{ $sub->id }}">
                                            <input type="hidden" value="{{ $sub->exact_upto }}"
                                                   id="upto_{{ $sub->id }}">

                                            <div class="infolist m-t-1">
                                                <div style="display: none;">
                                                    <input type="checkbox"
                                                           value="{{ '<br/>'.$sub->menu_item }}"
                                                           title="___" id="{{ $sub->id }}"
                                                           style="display: none;" checked="checked"
                                                           class="chk">
                                                </div>
                                                <strong style="float:left;">{{ ucfirst($sub->menu_item) }} &nbsp;</strong>

                                                <span style="float:left;" class="limit-options no_text_break" style="">

                                                   <?php
                                                    if ($sub->exact_upto == 0) {
                                                        $upto = "up to ";
                                                    } elseif ($sub->exact_upto == '1') {
                                                        $upto = "exactly ";
                                                    }
                                                    if ($sub->req_opt == '0') {
                                                        if ($sub->exact_upto_qty > 0 && $sub->sing_mul == '0' && $sub->exact_upto != 2) {
                                                            echo "Select " . $upto . $sub->exact_upto_qty . " ";
                                                        }
                                                        echo "<span style='color:#5cb85c!important;'>Optional</span>";
                                                    } elseif ($sub->req_opt == '1') {
                                                        if ($sub->exact_upto_qty > 0 && $sub->sing_mul == '0' && $sub->exact_upto != 2) {
                                                            echo "Select " . $upto . $sub->exact_upto_qty . " ";
                                                        }
                                                        echo "<span style='color:#5cb85c!important;'>Required</span>";
                                                    }
                                                    ?>
                                                </span>

                                                <div class="clearfix"></div>
                                                <span class="error_{{ $sub->id }} errormsg"></span>

                                                <div class="list clearfix row m-t-1" style="">
                                                    <?php
                                                    $mini_menus = \App\Http\Models\Menus::where('parent', $sub->id)->orderBy('display_order', 'ASC')->get();
                                                    $a = 0;
                                                    ?>
                                                    @foreach($mini_menus as $mm)
                                                        <?php
                                                        $a++;
                                                        if ($mm->price != 0) {
                                                            $extra_price = '(+$' . $mm->price . ')_';
                                                        } else {
                                                            $extra_price = '_';
                                                        }
                                                        ?>


                                                        <div class="" id="buttons_{{ $mm->id }}" valign="" style=""
                                                             href="javascript:void(0);">

                                                            <div class="col-sm-10 col-xs-8 " style="display: inline-block;
@if ($sub->sing_mul == '1') @else  @endif">


                                                                <LABEL class="changemodalP c-input @if($sub->sing_mul =='1') c-radio @else p-l-0 @endif ">

                                                                    <input
                                                                            type="{{ ($sub->sing_mul == '1') ? 'radio' : 'checkbox' }}"
                                                                            id="extra_{{ $mm->id }}"
                                                                            title="{{ $mm->id.'_ '.$mm->menu_item.$extra_price.$mm->price.'_'.$sub->menu_item }}"
                                                                            class="extra-{{ $sub->id }} spanextra_<?php echo $mm->id; ?>"
                                                                            name="extra_{{ $sub->id }}"
                                                                            value="post"
                                                                            @if ($sub->sing_mul == '0')  style="display:none;" @endif
                                                                    />

                                                                    @if($sub->sing_mul =='1')
                                                                        <span class="c-indicator"></span>


                                                                        <span class="list-inline-item ver">{{ $mm->menu_item }}
                                                                            <span class="text-muted"><?php if ($mm->price) echo "+$" . number_format(str_replace('$', '', $mm->price), 2); ?></span></span>

                                                                    @endif

                                                                </LABEL>

                                                                @if($sub->sing_mul =='0')

                                                                    <span class="list-inline-item ver">{{ $mm->menu_item }}
                                                                        <span class="text-muted"><?php if ($mm->price) echo "+$" . number_format(str_replace('$', '', $mm->price), 2); ?></span></span>

                                                                @endif

                                                            </div>

                                                            <div style="display: inline-block; @if ($sub->sing_mul == '1')display:none; @endif"
                                                                 class="col-sm-2 col-xs-4 p-a-0">

                                                                <a id="addspan_{{ $mm->id }}"
                                                                   title="{{ $alts["addspan"] }}"
                                                                   class="addspan btn  mobile-p-r-0 pull-right"
                                                                   href="javascript:;"><i
                                                                            class="fa fa-plus"></i></a>

                                                                <a id="sprice_{{$mm->price}}"
                                                                   style="margin-top:6px;"
                                                                   class=" btn pull-right p-a-0 span_{{ $mm->id }} qty_{{ $value->id }} allspan">0</a>

                                                                <a id="remspan_{{ $mm->id }}"
                                                                   title="{{ $alts["remspan"] }}"
                                                                   class="remspan btn pull-right  p-l-0 "
                                                                   href="javascript:;"><i style="color: #dadada"
                                                                                          class="fa fa-minus"></i></a>
                                                            </div>


                                                        </div>


                                                        <?php
                                                        if (!($a & 1)) {
                                                            //  echo '<div class="clearfix" ></div>';
                                                        }
                                                        echo '<div class="clearfix" ></div>';

                                                        ?>


                                                    @endforeach
                                                    <input type="hidden" value="" class="chars_{{ $sub->id }}">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="p-t-1 clearfix">
                        <div class="col-md-4 btn text-muted" style="cursor: default;text-align: left;">
                            If issue arises?
                        </div>
                        <div class="col-md-8">
                            <SELECT style="padding:.375rem;width:100%;text-align: left;" ID="csr{{ $value->id }}"
                                    TITLE="{{ $alts["csr"] }}" CLASS="btn btn-secondary text-muted">
                                <?php
                                $Actions = array("Go with restaurant suggestion", "Contact me", "Refund this item", "Cancel entire order");
                                foreach ($Actions as $Index => $Action) {
                                    echo '<OPTION VALUE="' . $Index . '">' . $Action . '</OPTION>';
                                }
                                ?>
                            </SELECT>

                        </div>
                        <div class=""></div>

                    </div>
                </div>
            </div>
            <div class="card-footer" style="border-radius: 0 !important;">
                <div class="">
                    <div class=" pull-left">
                        <button type="button" class="btn btn-link text-muted hidden-md-up p-x-0 m-x-" title="Close"
                                data-dismiss="modal">
                            Close
                        </button>
                        <!--button id="clear_{{ $value->id }}" class="btn btn-warning resetslider" type="button">
                                       Reset
                                   </button-->

                    </div>
                    <div class="pull-right" style="margin-left:.5rem;">
                        <a id="profilemenu{{ $value->id }}" title="{{ $alts["add"] }}"
                           class="btn btn-primary add_menu_profile add_end"
                           href="javascript:void(0);">ADD</a>
                    </div>
                    <div class="pull-right text-muted">Qty
                        <?php
                        $usedropdown = true;
                        ?>
                        <SELECT id="select{{ $value->id }}" onchange="changeqty('{{ $value->id }}', $(this).val());"
                                class="btn btn-secondary p-x-0 text-muted"
                                style=" background: transparent; border:0 !important; @if(!$usedropdown) display:none; @endif ">
                            <?php
                            for ($i = 1; $i <= 10; $i++) {
                                echo '<OPTION';
                                if ($i == 1) {
                                    echo ' SELECTED';
                                }
                                echo '>' . $i . '</OPTION>';
                            }
                            ?>
                        </SELECT>
                        @if($usedropdown) <SPAN STYLE="display: none;"> @endif
                            <a class="btn btn-secondary" href="javascript:void(0);" title="{{ $alts["minus"] }}"
                               onclick="changeqty('{{ $value->id }}', 'minus')">
                                <i class="fa fa-minus"></i>
                            </a>
                            <span class="number{{ $value->id }}">1</span>
                            <a class="btn btn-secondary" href="javascript:void(0);" title="{{ $alts["plus"] }}"
                               onclick="changeqty('{{ $value->id }}', 'plus')">
                                <i class="fa fa-plus"></i>
                            </a>
                            @if($usedropdown) </SPAN> @endif
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>

        </div>
    </div>
</div>