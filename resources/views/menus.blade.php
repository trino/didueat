<?php if(!isset($_GET['page'])){?>
<div id="loadmenus_{{$catid}}"><?php }?>
@foreach($menus_list as $value)
  <div class="col-md-4 col-sm-6 col-xs-12 no-padding" style="">
    <div class="product-item" style="margin:3px;background: white;height: 120px; padding: 10px;">

        <a href="<?php echo (Request::is('restaurants/*')) ? '#product-pop-up_' . $value->id : url('restaurants/' . select_field('restaurants', 'id', $value->restaurant_id, 'slug') . '/menus'); ?>"
           class="<?php echo (Request::is('restaurants/*')) ? 'fancybox-fast-view' : '';?>">

            <div class="col-md-8 col-sm-7 col-xs-6 ">
                <h2 class="padding-top-5" style="color: black;margin:0px;">{{ $value->menu_item }}</h2>
                <p style="overflow: hidden;font-size: 11px;color:#666;">{{ $value->description }}</p>
            </div>



            <div class="col-md-2 col-sm-3 col-xs-3 padding-top-5 " style="padding:0;">
                <h2 class="" style="color: black;font-weight: 300;">${{ $value->price }}</h2>
            </div>


            <div class="col-md-2 col-sm-2 col-xs-3" style="padding:0;">


                <img style="max-height:100%;"
                 src="<?php if($value->image != '' && file_exists(public_path('assets/images/restaurants/'.$value->restaurant_id.'/menus/'.$value->id.'/thumb1_'.$value->image)))
            echo url('assets/images/restaurants/'.$value->restaurant_id.'/menus/'.$value->id.'/thumb1_'.$value->image);
                  else echo url('assets/images/default_menu.jpg'); ?>"
                     class="img-responsive" alt="{{ $value->menu_item }}"/>

            </div>

            <!--div class="sticker sticker-new"></div-->

        </a>
        <?php if(Session::has('is_logged_in')){?>
        <div class="col-md-12 col-sm-12 col-xs-12 category_detail_btn no-padding" style="margin-top: 10px;">

        <a href="<?php echo url('restaurant/deleteMenu/'.$value->id.'/'.$restaurant->slug);?>" class="btn red">Remove</a>
        <a href="#menumanager2" id="add_item<?php echo $value->id;?>" class="btn blue fancybox-fast-view additem">Edit</a>
        <input type="hidden" id="res_id" value="<?php echo $restaurant->id;?>" />
        <input type="hidden" id="res_slug" value="<?php echo $restaurant->slug;?>" />

        </div>
        <?php }?>
    </div>
    </div>




    <div id="product-pop-up_{{ $value->id }}" style="display: none; width: 800px;">

        <div class="product-page product-pop-up">
            <!--div class="modal-header">
                            <button id="clear_{{ $value->id }}" aria-hidden="true" data-dismiss="modal" class="close close{{ $value->id }}" type="button">x
                            </button>

                        </div-->
            <div style=" font-family:mainfont;" class="modal-body">
                <div style="text-align: left;padding:0px;" class="col-sm-12 col-xs-12 title">
                    <h2 style="color:white;">{{ $value->menu_item }}: $ {{ $value->price }}</h2>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <img class="popimage_{{ $value->id }}" width="150"
                         src="<?php if($value->image != '' && file_exists(public_path('assets/images/restaurants/'.$value->restaurant_id.'/menus/'.$value->id.'/thumb1_'.$value->image)))
            echo url('assets/images/restaurants/'.$value->restaurant_id.'/menus/'.$value->id.'/thumb1_'.$value->image);
                  else echo url('assets/images/default_menu.jpg'); ?>"/>
                </div>
                <div class="clearfix"></div>

                <div class="product-titles">
                    <h2>{{ $value->description }}</h2>
                </div>

                <div class="subitems_{{ $value->id }} optionals">
                    <!--<span class="topright"><a href="javascript:void(0)" onclick="$('#Modal{{ $value->id }}').toggle();"><strong class="btn btn-danger">x</strong></a></span>-->

                    <div class="clearfix space10"></div>
                    <div style="display:none;"><input type="checkbox" style="display: none;" checked="checked"
                                                      title="{{ $value->id }}_<?php echo $value->menu_item;?>-_<?php echo $value->price;?>_"
                                                      value="" class="chk">
                    </div>
                    <div style="overflow: hidden;" class="banner bannerz">
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


                                                    <span class="limit-options" style="float: right;">
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
                                        <span class="error_<?php echo $sub->id;?>"
                                              style="color: red; font-weight: bold;"></span>

                                        <div class="list clearfix">
                                            <?php
                                            $mini_menus = \App\Http\Models\Menus::where('parent', $sub->id)->get();
                                            //$mini_menus = $Manager->enum_all('Menus',['parent'=>$sub->id]);
                                            foreach($mini_menus as $mm):
                                            ?>
                                            <div class="col-xs-6 col-md-6"
                                                 style="padding: 0px;border-radius: 17px 0 0 17px !important;"
                                                 class="subin btn default btnxx">
                                                <div style="padding:0px;border-radius: 17px 0 0 17px !important;">
                                                    <a style="text-decoration: none;display:inline-block; padding-right: 15px;"
                                                       title="" id="buttons_<?php echo $mm->id;?>" class="buttons "
                                                       href="javascript:void(0);">
                                                        <button style="border-radius: 17px!important;"
                                                                class="btn btn-primary">
                                                        </button>

                                                        <input type="<?php echo ($sub->sing_mul == '1') ? 'radio' : 'checkbox';?>"
                                                               id="extra_<?php echo $mm->id;?>"
                                                               title="<?php echo $mm->id;?>_<br/> <?php echo $mm->menu_item;?>_<?php echo $mm->price;?>_<?php echo $sub->menu_item;?>"
                                                               class="extra-<?php echo $sub->id;?>"
                                                               name="extra_<?php echo $sub->id;?>" value="post"/>
                                                        &nbsp;&nbsp;<?php echo $mm->menu_item;?>
                                                        &nbsp;&nbsp;<?php if ($mm->price) echo "(+ $" . number_format(str_replace('$', '', $mm->price), 2) . ")"; ?>
                                                        <b style="display:none;">
                                                        </b></a><b style="display:none;"><a onclick=""
                                                                                            style="text-decoration: none; color: #000;"
                                                                                            id="remspan_<?php echo $mm->id;?>"
                                                                                            class="remspan"
                                                                                            href="javascript:;"><b>
                                                                &nbsp;&nbsp;-&nbsp;&nbsp;</b></a>
                                                        <span id="sprice_0" class="span_<?php echo $mm->id;?> allspan">&nbsp;&nbsp;1&nbsp;&nbsp;</span>
                                                        <a style="text-decoration: none; color: #000;" onclick=""
                                                           id="addspan_<?php echo $mm->id;?>" class="addspan"
                                                           href="javascript:;"><b>
                                                                &nbsp;&nbsp;+&nbsp;&nbsp;</b></a>
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
                            <?php }?>

                            </tbody>
                        </table>
                    </div>

                    <div class="clearfix"></div>
                    <div style="line-height:45px;" class="col-xs-12 add-btn">
                        <div class="add-minus-btn" style="float:left;">
                            <a class="btn btn-primary minus" href="javascript:void(0);"
                               onclick="changeqty('{{ $value->id }}','minus')">-</a>

                            <div class="number{{ $value->id }}">1</div>
                            <a class="btn btn-primary add" href="javascript:void(0);"
                               onclick="changeqty('{{ $value->id }}','plus')">+</a>


                        </div>

                        <a style="float: right; margin-left: 10px;" id="profilemenu{{ $value->id }}"
                           class="btn btn-primary add_menu_profile add_end" href="javascript:void(0);">Add</a>
                        <button id="clear_{{ $value->id }}"
                                style="opacity: 1; text-shadow:none;margin-left: 10px;float: right;margin-left: 10px;display:none;"
                                data-dismiss="modal" class="btn btn-warning resetslider" type="button">
                            RESET
                        </button>
                        <!-- &nbsp;<a style="float: right;margin-left:10px;" id="clear_{{ $value->id }}" class="btn btn-danger  clearall"
                                             href="javascript:void(0);">CLOSE</a>&nbsp; &nbsp;

                                    &nbsp;
                                    <a title="1" class="nxt_button btn btn-primary" href="javascript:void(0);"
                                       style="float: right; display: block;">Next</a>
                                    <a title="1" class="prv_button btn btn-primary" href="javascript:void(0);"
                                       style="float: right; margin-right: 10px; display: none;">Previous</a> -->

                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="clearfix"></div>
            </div>
        </div>
    </div>


@endforeach
<?php if(!isset($_GET['page'])){?>
</div>
<?php }?>
    <div style="display: none;" class="nxtpage_{{$catid}}">
        <li class="next_{{$catid}}"><a href="{{$menus_list->nextPageUrl()}}">Next &gt;&gt;</a></li>
    </div>
  <?php if(!isset($_GET['page'])){?>              
 <?php if($menus_list->hasMorePages()){?>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12" >
            <button align="center" class="loadmore btn btn-primary" title="{{$catid}}">Load More</button>
        </div>
    </div>
    <?php }?>
    <div class="clearfix"></div>
<?php }?>

<? if(false){?>


        <!-- BEGIN fast view of a product -->
<!--div id="product-pop-up_{{ $value->id }}" style="display: none; width: 500px;">
                    <div class="product-page product-pop-up">
                        <div style=" font-family:mainfont;" class="modal-body">
                            <div style="text-align: left;padding:0px;" class="col-sm-12 col-xs-12 title">
                                <h2 style="color:white;">{{ $value->menu_item }}: ${{ $value->price }}</h2>
                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <img class="popimage_10" width="150" src="{{ url('assets/images/products') }}/{{ ($value->image)?$value->image:'default.jpg' }}">
                            </div>
                            <div class="clearfix"></div>

                            <div class="product-titles">
                                <h2>{{ $value->description }}</h2>
                            </div>

                            <div class="subitems_10 optionals">
                                <div class="clearfix space10"></div>
                                <div style="display:none;">
                                    <input type="checkbox" style="display: none;" checked="checked" title="10_Menu6-_60_" value="" class="chk">
                                </div>
                                <div style="overflow: hidden;" class="banner bannerz">
                                    <table width="100%">
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="clearfix"></div>
                                <div style="line-height:45px;" class="col-xs-12 add-btn">
                                    <div class="add-minus-btn" style="float:left;">
                                        <a class="btn btn-primary minus" href="javascript:void(0);" onclick="changeqty('10', 'minus')">-</a>
                                        <div class="number10">1</div>
                                        <a class="btn btn-primary add" href="javascript:void(0);" onclick="changeqty('10', 'plus')">+</a>
                                    </div>

                                    <a style="float: right; margin-left: 10px;" id="profilemenu10" class="btn btn-primary add_menu_profile add_end" href="javascript:void(0);">Add</a>
                                    <button id="clear_10" style="opacity: 1; text-shadow:none;margin-left: 10px;float: right;margin-left: 10px;display:none;" data-dismiss="modal" class="btn btn-warning resetslider" type="button">
                                        RESET
                                    </button>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div-->
<!--div style="padding: 0px;border-radius: 17px 0 0 17px !important;"
                                                             class="subin btn default btnxx">
                                                            <div class="col-xs-12 col-md-6"  style="padding:0px;border-radius: 17px 0 0 17px !important;"
                                                                >
                                                                <a style="text-decoration: none;display:inline-block; padding-right: 15px;"
                                                                   title="B" id="buttons_5051" class="buttons "
                                                                   href="javascript:void(0);">
                                                                    <button style="border-radius: 17px!important;"
                                                                            class="btn btn-primary">B
                                                                    </button>
                                                                    <input type="radio" id="extra_5051"
                                                                           title="5051_<br/> Milk Tea_0_Choose Type"
                                                                           class="extra-<?php echo $sub->id;?>" name="extra_<?php echo $sub->id;?>" value=""
                                                                          />
                                                                    &nbsp;&nbsp;Milk Tea <b style="display:none;">
                                                                    </b></a><b style="display:none;"><a onclick=""
                                                                                                        style="text-decoration: none; color: #000;"
                                                                                                        id="remspan_5051"
                                                                                                        class="remspan"
                                                                                                        href="javascript:;"><b>
                                                                            &nbsp;&nbsp;-&nbsp;&nbsp;</b></a>
                                                                    <span id="sprice_0" class="span_5051 allspan">&nbsp;&nbsp;1&nbsp;&nbsp;</span>
                                                                    <a style="text-decoration: none; color: #000;" onclick=""
                                                                       id="addspan_5051" class="addspan" href="javascript:;"><b>
                                                                            &nbsp;&nbsp;+&nbsp;&nbsp;</b></a>
                                                                </b>

                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div-->


<?} ?>

