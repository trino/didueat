@foreach($query as $value)
    <div id="{{ $start }}" class="col-md-4 col-sm-6 col-xs-12  parentDiv no-padding " style="">
        <div class="card ">
            <div class="sticker sticker-new" style="z-index: 99;"></div>
            <div class="col-md-9 no-padding">
                <div class="card-content">
                    <a href="<?php echo (Request::is('restaurants/*')) ? '#product-pop-up_' . $value->id : url('restaurants/' . select_field('restaurants', 'id', $value->restaurant_id, 'slug') . '/menus'); ?>" class="<?php echo (Request::is('restaurants/*')) ? 'fancybox-fast-view' : '';?>">
                        <strong>{{ $value->menu_item }}</strong>
                        {{ $value->description }}
                    </a>
                </div>
                <div class="card-action">
                    <a href="" class="">McDonalds Eastgate</a>
                </div>
            </div>
            <div class="col-md-3 no-padding">
                <div class="card-image">
                    <?php if($value->image != '' && file_exists(public_path('assets/images/restaurants/' . $value->restaurant_id . '/menus/' . $value->id . '/thumb1_' . $value->image))){?>
                    <img style="" src="<?php if ($value->image != '' && file_exists(public_path('assets/images/restaurants/' . $value->restaurant_id . '/menus/' . $value->id . '/thumb1_' . $value->image))){
                        echo asset('assets/images/restaurants/' . $value->restaurant_id . '/menus/' . $value->id . '/thumb1_' . $value->image);
                     } else { echo asset('assets/images/default_menu.jpg'); } ?>">
                    <?php } ?>
                    <span class="card-title"><span style="color:red;">${{ $value->price }}</span></span>
                </div>
            </div>
            <div style="clear: both;"></div>
        </div>
    </div>

    <div id="product-pop-up_{{ $value->id }}" style="display: none; width: 800px;">
        <div class="product-page product-pop-up">
            <div style=" font-family:mainfont;" class="modal-body">
                <div style="text-align: left;padding:0px;" class="col-sm-12 col-xs-12 title">
                    <h2 style="color:white;">{{ $value->menu_item }}: $ {{ $value->price }}</h2>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <img class="popimage_{{ $value->id }}" width="150"
                         src="<?php if ($value->image != '' && file_exists(public_path('assets/images/restaurants/' . $value->restaurant_id . '/menus/' . $value->id . '/thumb_' . $value->image)))
                             echo asset('assets/images/restaurants/' . $value->restaurant_id . '/menus/' . $value->id . '/thumb_' . $value->image);
                         else echo asset('assets/images/default_menu.jpg'); ?>"/>
                </div>
                <div class="clearfix"></div>

                <div class="product-titles">
                    <h2>{{ $value->description }}</h2>
                </div>

                <div class="subitems_{{ $value->id }} optionals">
                    <div class="clearfix space10"></div>
                    <div style="display:none;">
                        <input type="checkbox" style="display: none;" checked="checked" title="{{ $value->id }}_<?php echo $value->menu_item;?>-_<?php echo $value->price;?>_" value="" class="chk">
                    </div>
                    <div class="banner bannerz no-overflow">
                        <table width="100%">
                            <tbody>
                            <?php
                            $submenus = \App\Http\Models\Menus::where('parent', $value->id)->get();
                            //$submenus = $Manager->enum_all('Menus',['parent'=>$menu->id]);
                                foreach($submenus as $sub){
                                ?>
                                <tr class="zxcx">
                                    <td width="100%" id="td_<?php echo $sub->id;?>" style="vertical-align: top;">
                                        <input type="hidden" value="<?php echo $sub->exact_upto_qty;?>"
                                               id="extra_no_<?php echo $sub->id;?>">
                                        <input type="hidden" value="<?php echo $sub->req_opt;?>"
                                               id="required_<?php echo $sub->id;?>">
                                        <input type="hidden" value="<?php echo $sub->sing_mul;?>"
                                               id="multiple_<?php echo $sub->id;?>">
                                        <input type="hidden" value="<?php echo $sub->exact_upto;?>"
                                               id="upto_<?php echo $sub->id;?>">

                                        <div style="" class="infolist col-xs-12">
                                            <div style="display: none;">
                                                <input type="checkbox" value="<?php echo $sub->menu_item;?>" title="___"
                                                       id="<?php echo $sub->id;?>"
                                                       style="display: none;" checked="checked" class="chk">
                                            </div>
                                            <a href="javascript:void(0);"><strong><?php echo $sub->menu_item;?></strong></a>
                                            <span><em> </em></span>


                                                        <span class="limit-options right-float">
                                                        <?php
                                                            if ($sub->exact_upto == 0)
                                                                $upto = "up to ";
                                                            else
                                                                $upto = "exactly ";
                                                            if ($sub->req_opt == '0') {
                                                                if ($sub->exact_upto_qty > 0 && $sub->sing_mul == '0')
                                                                    echo "(Select " . $upto . $sub->exact_upto_qty . " Items) ";
                                                                echo "(Optional)";

                                                            } elseif ($sub->req_opt == '1') {
                                                                if ($sub->exact_upto_qty > 0 && $sub->sing_mul == '0')
                                                                    echo "Select " . $upto . $sub->exact_upto_qty . " Items ";

                                                                echo "(Mandatory)";
                                                            }?>
                                                        </span>

                                            <div class="clearfix"></div>
                                            <span class="error_<?php echo $sub->id;?> strong-error"></span>

                                            <div class="list clearfix">
                                                <?php
                                                $mini_menus = \App\Http\Models\Menus::where('parent', $sub->id)->get();
                                                //$mini_menus = $Manager->enum_all('Menus',['parent'=>$sub->id]);
                                                foreach($mini_menus as $mm):
                                                ?>
                                                <div class="col-xs-6 col-md-6"
                                                     class="subin btn default btnxx pad-17">
                                                    <div class="pad-17">
                                                        <a title="" id="buttons_<?php echo $mm->id;?>" class="buttons btn-plain" href="javascript:void(0);">
                                                            <button class="btn btn-primary btn-curved"></button>
                                                            <input type="<?php echo ($sub->sing_mul == '1') ? 'radio' : 'checkbox';?>" id="extra_<?php echo $mm->id;?>" title="<?php echo $mm->id;?>_<br/> <?php echo $mm->menu_item;?>_<?php echo $mm->price;?>_<?php echo $sub->menu_item;?>" class="extra-<?php echo $sub->id;?>" name="extra_<?php echo $sub->id;?>" value="post"/> &nbsp;&nbsp;<?php echo $mm->menu_item;?> &nbsp;&nbsp;<?php if ($mm->price) echo "(+ $" . number_format(str_replace('$', '', $mm->price), 2) . ")"; ?>
                                                            <b style="display:none;"></b>
                                                        </a>
                                                        <b style="display:none;"><a onclick="" id="remspan_<?php echo $mm->id;?>" class="remspan plain" href="javascript:;"><b>&nbsp;&nbsp;-&nbsp;&nbsp;</b></a>
                                                            <span id="sprice_0" class="span_<?php echo $mm->id;?> allspan">&nbsp;&nbsp;1&nbsp;&nbsp;</span>
                                                            <a onclick="" id="addspan_<?php echo $mm->id;?>" class="addspan plain" href="javascript:;"><b>&nbsp;&nbsp;+&nbsp;&nbsp;</b></a>
                                                        </b>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <?php endforeach;?>
                                                <input type="hidden" value="" class="chars_<?php echo $sub->id;?>">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="clearfix"></div>
                    <div style="line-height:45px;" class="col-xs-12 add-btn">
                        <div class="add-minus-btn left-float">
                            <a class="btn btn-primary minus" href="javascript:void(0);" onclick="changeqty('{{ $value->id }}','minus')">-</a>
                            <div class="number{{ $value->id }}">1</div>
                            <a class="btn btn-primary add" href="javascript:void(0);" onclick="changeqty('{{ $value->id }}','plus')">+</a>
                        </div>
                        <a id="profilemenu{{ $value->id }}" class="btn btn-primary add_menu_profile add_end btn-spc right-float" href="javascript:void(0);">Add</a>
                        <button id="clear_{{ $value->id }}" data-dismiss="modal" class="btn btn-warning resetslider" type="button">
                            RESET
                        </button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
@endforeach