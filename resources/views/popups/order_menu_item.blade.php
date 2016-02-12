<div class="modal fade clearfix " id="product-pop-up_{{ (isset($value->id))?$value->id:'' }}"
     tabindex="-1"
     role="dialog" aria-labelledby="viewDetailModelLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close<?php echo $value->id; ?>" data-dismiss="modal"
                        aria-label="Close" id="clear_<?php echo $value->id; ?>">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="viewDetailModel"><?php echo $value->menu_item; ?></h4>
            </div>
            <div class="modal-body product-popup">
                <div class="product-page product-pop-up">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12 title">
                            <h3>
                                @if($dis)
                                    <strike class="text-muted">${{number_format($value->price,2)}}</strike>
                                    ${{number_format($main_price,2)}}
                                    <span class='label label-warning'>{{$dis}}</span>
                                @else
                                    ${{number_format($value->price,2)}}
                                @endif
                            </h3>
                        </div>
                        @if (Session::get('session_type_user') == "super" )
                                <!--div class="col-sm-12 col-xs-12">
                                               <p class="">Views: {{ ViewsCountsType($value->id, "menu") }}</p>
                                           </div-->
                        @endif
                        <div class="col-sm-12 col-xs-12">
                            <img class="popimage_{{ $value->id }}" width="100%" src="{{ $item_image }}"/>
                        </div>





                        <div class="subitems_{{ $value->id }} optionals">



                            <div style="display:none;">
                                <input type="checkbox" style="display: none;" checked="checked"
                                       title="{{ $value->id.'_<b>'.$value->menu_item.'</b>_'.$main_price.'_' }}"
                                       value="" class="chk">
                            </div>



                            <div class="banner bannerz">
                                <table>
                                    <tbody>

                                    <tr><td colspan="2">

                                            <div style="" class="col-xs-12">

                                            <p class="">{{ $value->description }}</p>
</div>

                                        </td></tr>


                                    @foreach ($submenus as $sub)


                                        <tr class="zxcx">
                                            <td width="100%" id="td_{{ $sub->id }}" class="valign-top">

                                                <hr class="clearfix" style="margin: 10px 0;"/>




                                                <input type="hidden" value="{{ $sub->exact_upto_qty }}"
                                                       id="extra_no_{{ $sub->id }}">
                                                <input type="hidden" value="{{ $sub->req_opt }}"
                                                       id="required_{{ $sub->id }}">
                                                <input type="hidden" value="{{ $sub->sing_mul }}"
                                                       id="multiple_{{ $sub->id }}">
                                                <input type="hidden" value="{{ $sub->exact_upto }}"
                                                       id="upto_{{ $sub->id }}">

                                                <div style="" class="infolist col-xs-12">
                                                    <div style="display: none;">
                                                        <input type="checkbox"
                                                               value="{{ '<br/>'.$sub->menu_item }}"
                                                               title="___" id="{{ $sub->id }}"
                                                               style="display: none;" checked="checked"
                                                               class="chk">
                                                    </div>
                                                    <strong>
                                                        {{ ucfirst($sub->menu_item) }}     </strong>

                                                           <span class="limit-options">
                                                               <?php
                                                               if ($sub->exact_upto == 0) {
                                                                   $upto = "up to ";
                                                               } else {
                                                                   $upto = "exactly ";
                                                               }
                                                               if ($sub->req_opt == '0') {
                                                                   if ($sub->exact_upto_qty > 0 && $sub->sing_mul == '0') {
                                                                       echo "Select " . $upto . $sub->exact_upto_qty . " Items ";
                                                                   }
                                                                   echo "(Optional)";
                                                               } elseif ($sub->req_opt == '1') {
                                                                   if ($sub->exact_upto_qty > 0 && $sub->sing_mul == '0') {
                                                                       echo "Select " . $upto . $sub->exact_upto_qty . " Items ";
                                                                   }
                                                                   echo "(Required)";
                                                               }
                                                               ?>
                                                               </span>


                                                    <div class="clearfix"></div>
                                                    <span class="error_{{ $sub->id }} errormsg"></span>

                                                    <div class="list clearfix row">
                                                        <?php $mini_menus = \App\Http\Models\Menus::where('parent', $sub->id)->orderBy('display_order', 'ASC')->get(); ?>
                                                        @foreach($mini_menus as $mm)






                                                            <div class="col-xs-12 col-md-6">


                                                                <div id="buttons_{{ $mm->id }}"
                                                                     class="buttons <?php if ($sub->sing_mul != '1') { ?> <?php }?>"
                                                                     href="javascript:void(0);">
                                                                    <?php
                                                                    if ($mm->price != 0)
                                                                        $extra_price = '(+$' . $mm->price . ')_';
                                                                    else
                                                                        $extra_price = '_';
                                                                    ?>

                                                                    <div <?php if ($sub->sing_mul == '1') {
                                                                        echo "style='display:none'";
                                                                    } ?> class="pull-left p-r-1">
                                                                        <a id="remspan_{{ $mm->id }}"
                                                                           class="remspan btn btn-secondary-outline btn-xs"
                                                                           href="javascript:;"><i class="fa fa-minus"
                                                                                                  style="width:9px;height:9px;"></i></a>
                                                                        <span id="sprice_{{$mm->price}}"
                                                                              class="span_{{ $mm->id }} allspan">0</span>
                                                                        <a id="addspan_{{ $mm->id }}"
                                                                           class="addspan btn btn-xs btn-primary"
                                                                           href="javascript:;"><i class="fa fa-plus"
                                                                                                  style="width:9px;height:9px;"></i></a>


                                                                    </div>


                                                                    <LABEL @if($sub->sing_mul =='1')  class="c-input c-radio" @endif >


                                                                        <input type="{{ ($sub->sing_mul == '1') ? 'radio' : 'checkbox' }}"
                                                                               id="extra_{{ $mm->id }}"
                                                                               title="{{ $mm->id.'_ '.$mm->menu_item.$extra_price.$mm->price.'_'.$sub->menu_item }}"
                                                                               class="extra-{{ $sub->id }} spanextra_<?php echo $mm->id; ?>"
                                                                               name="extra_{{ $sub->id }}"
                                                                               value="post" <?php if ($sub->sing_mul == '0') echo "style='display:none'"; ?> />

                                                                        {{ $mm->menu_item }}
                                                                        @if($sub->sing_mul =='1')  <span
                                                                                class="c-indicator"></span> @endif

                                                                        <?php if ($mm->price) echo "(+$" . number_format(str_replace('$', '', $mm->price), 2) . ")"; ?>

                                                                    </LABEL>


                                                                </div>


                                                                <div class="clearfix"></div>
                                                            </div>




                                                        @endforeach
                                                        <input type="hidden" value=""
                                                               class="chars_{{ $sub->id }}">
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
                    </div>
                </div>
            </div>


            <div class="modal-footer">
                <!--button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                   <button id="clear_{{ $value->id }}" class="btn btn-warning resetslider" type="button">
                                       Reset
                                   </button-->
                Qty&nbsp;
                <a class="btn  btn-secondary-outline  btn-sm" href="javascript:void(0);"
                   onclick="changeqty('{{ $value->id }}', 'minus')"><i class="fa fa-minus" style=""></i></a>
                &nbsp;
                <span class="number{{ $value->id }}">1</span> &nbsp;
                <a class="btn  btn-secondary-outline  btn-sm" href="javascript:void(0);"
                   onclick="changeqty('{{ $value->id }}', 'plus')"><i class="fa fa-plus" style=""></i></a>

                <a id="profilemenu{{ $value->id }}"
                   class="btn  btn-primary add_menu_profile add_end"
                   href="javascript:void(0);">Add</a>
            </div>
        </div>
    </div>
</div>