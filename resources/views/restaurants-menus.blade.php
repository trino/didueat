@extends('layouts.default')
@section('content')

<div class="margin-bottom-40">
    <!-- BEGIN CONTENT -->
    <div class="col-md-2 col-sm-4 col-xs-12">

        <div class="well add-sidebar">
             @if(!empty($res_detail->Logo)) 
                <img class="img-responsive" alt="" src="{{ url('assets/images/restaurants/'.$res_detail->Logo) }}">
                 @else 
                <img class="img-responsive" alt="" src="{{ url('assets/images/default.png') }}">    
             @endif
            <address>
                <strong>{!! $res_detail->Name !!}.</strong><br>
                {!! $res_detail->Address.' , '.$res_detail->City !!}<br>
                {!! $res_detail->Province.' , '.$res_detail->Country !!}<br>
                <abbr title="Phone">P:</abbr> {!! $res_detail->Phone !!}
            </address>
            <address>
                <strong>Email</strong><br>
                <a href="{!! $res_detail->Email !!}" >
                    {!! $res_detail->Email !!}
                </a>
            </address>
        </div>
    </div>

    <div class="col-md-7 col-sm-4 col-xs-12 menu_div">
        <link rel="stylesheet" href="<?php echo url('assets/frontend/layout');?>/css/popstyle.css">

        <div id="postswrapper">
            <div class="margin-bottom-10">
                
                @foreach($menus_list as $value)
                <div class="col-md-3 col-sm-12 col-xs-12 margin-bottom-20">
                    <a href="#product-pop-up_{{ $value->ID }}" class="fancybox-fast-view"></a>
                    <div class="product-item">
                        <a href="#product-pop-up_{{ $value->ID }}" class="fancybox-fast-view">
                            <div class="pi-img-wrapper">
                                <img src="{{ url('assets/images/products') }}/{{ ($value->image)?$value->image:'default.jpg' }}" class="img-responsive" alt="{{ $value->menu_item }}">
                            </div>
                        </a>
                        <h3><a href="#product-pop-up_{{ $value->ID }}" class="fancybox-fast-view"></a><a href="#">{{ $value->menu_item }}</a></h3>
                        <div class="pi-price">${{ $value->price }}</div>
                        <div class="sticker sticker-new"></div>
                    </div>
                </div>
                
                <!-- BEGIN fast view of a product -->
                <!--div id="product-pop-up_{{ $value->ID }}" style="display: none; width: 500px;">
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
                <div id="product-pop-up_{{ $value->ID }}" style="display: none; width: 500px;">

                    <div class="product-page product-pop-up">
                        <!--div class="modal-header">
                            <button id="clear_{{ $value->ID }}" aria-hidden="true" data-dismiss="modal" class="close close{{ $value->ID }}" type="button">x
                            </button>
                
                        </div-->
                        <div style=" font-family:mainfont;" class="modal-body">
                            <div style="text-align: left;padding:0px;" class="col-sm-12 col-xs-12 title">
                                <h2 style="color:white;">{{ $value->menu_item }}: $ {{ $value->price }}</h2>
                
                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <img class="popimage_{{ $value->ID }}" width="150"
                                     src="{{ url('assets/images/products/')}} {{$value->image}}"/>
                            </div>
                            <div class="clearfix"></div>
                
                            <div class="product-titles">
                                <h2>{{ $value->description }}</h2>
                            </div>
                
                            <div class="subitems_{{ $value->ID }} optionals">
                                <!--<span class="topright"><a href="javascript:void(0)" onclick="$('#Modal{{ $value->ID }}').toggle();"><strong class="btn btn-danger">x</strong></a></span>-->
                
                                <div class="clearfix space10"></div>
                                <div style="display:none;"><input type="checkbox" style="display: none;" checked="checked" title="{{ $value->ID }}_<?php echo $value->menu_item;?>-_<?php echo $value->price;?>_" value="" class="chk">
                                </div>
                                <div style="overflow: hidden;" class="banner bannerz">
                                    <table width="100%">
                                        <tbody>
                                        <?php
                                        $submenus = \App\Http\Models\Menus::where('parent', $value->ID)->get();
                                            //$submenus = $Manager->enum_all('Menus',['parent'=>$menu->ID]);
                                            foreach($submenus as $sub){
                                        ?>
                                        <tr class="zxcx">
                                            <td width="100%" id="td_<?php echo $sub->ID;?>" style="vertical-align: top;">
                                                <input type="hidden" value="<?php echo $sub->exact_upto_qty;?>" id="extra_no_<?php echo $sub->ID;?>">
                                                <input type="hidden" value="<?php echo $sub->req_opt;?>" id="required_<?php echo $sub->ID;?>">
                                                <input type="hidden" value="<?php echo $sub->sing_mul;?>" id="multiple_<?php echo $sub->ID;?>">
                                                <input type="hidden" value="<?php echo $sub->exact_upto;?>" id="upto_<?php echo $sub->ID;?>">
                
                                                <div style="" class="infolist col-xs-12">
                                                    <div style="display: none;">
                                                        <input type="checkbox" value="<?php echo $sub->menu_item;?>" title="___" id="<?php echo $sub->ID;?>"
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
                                                    <span class="error_<?php echo $sub->ID;?>" style="color: red; font-weight: bold;"></span>
                
                                                    <div class="list clearfix">
                                                    <?php
                                                    $mini_menus = \App\Http\Models\Menus::where('parent', $sub->ID)->get();
                                                        //$mini_menus = $Manager->enum_all('Menus',['parent'=>$sub->ID]);
                                                        foreach($mini_menus as $mm):
                                                    ?>
                                                        <div class="col-xs-6 col-md-6"  style="padding: 0px;border-radius: 17px 0 0 17px !important;"
                                                             class="subin btn default btnxx">
                                                            <div style="padding:0px;border-radius: 17px 0 0 17px !important;">
                                                                <a style="text-decoration: none;display:inline-block; padding-right: 15px;"
                                                                   title="" id="buttons_<?php echo $mm->ID;?>" class="buttons "
                                                                   href="javascript:void(0);">
                                                                    <button style="border-radius: 17px!important;"
                                                                            class="btn btn-primary">
                                                                    </button>
                                                                    
                                                                    <input type="<?php echo ($sub->sing_mul=='1')?'radio':'checkbox';?>" id="extra_<?php echo $mm->ID;?>" title="<?php echo $mm->ID;?>_<br/> <?php echo $mm->menu_item;?>_<?php echo $mm->price;?>_<?php echo $sub->menu_item;?>"
                                                                           class="extra-<?php echo $sub->ID;?>" name="extra_<?php echo $sub->ID;?>" value="post"/>
                                                                    &nbsp;&nbsp;<?php echo $mm->menu_item;?>
                                                                    &nbsp;&nbsp;<?php if ($mm->price) echo "(+ $" . number_format(str_replace('$', '', $mm->price), 2) . ")"; ?>
                                                                     <b style="display:none;">
                                                                    </b></a><b style="display:none;"><a onclick=""
                                                                                                        style="text-decoration: none; color: #000;"
                                                                                                        id="remspan_<?php echo $mm->ID;?>"
                                                                                                        class="remspan"
                                                                                                        href="javascript:;"><b>
                                                                            &nbsp;&nbsp;-&nbsp;&nbsp;</b></a>
                                                                    <span id="sprice_0" class="span_<?php echo $mm->ID;?> allspan">&nbsp;&nbsp;1&nbsp;&nbsp;</span>
                                                                    <a style="text-decoration: none; color: #000;" onclick=""
                                                                       id="addspan_<?php echo $mm->ID;?>" class="addspan" href="javascript:;"><b>
                                                                            &nbsp;&nbsp;+&nbsp;&nbsp;</b></a>
                                                                </b>
                
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                        <?php endforeach;?>
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
                                                                           class="extra-<?php echo $sub->ID;?>" name="extra_<?php echo $sub->ID;?>" value=""
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
                                                        <input type="hidden" value="" class="chars_<?php echo $sub->ID;?>">
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
                                   <a class="btn btn-primary minus" href="javascript:void(0);" onclick="changeqty('{{ $value->ID }}','minus')">-</a>
                                   <div class="number{{ $value->ID }}">1</div>
                                   <a class="btn btn-primary add" href="javascript:void(0);" onclick="changeqty('{{ $value->ID }}','plus')">+</a>
                
                                    
                                </div>
                
                                    <a style="float: right; margin-left: 10px;" id="profilemenu{{ $value->ID }}"
                                       class="btn btn-primary add_menu_profile add_end" href="javascript:void(0);">Add</a>
                                     <button id="clear_{{ $value->ID }}"
                                            style="opacity: 1; text-shadow:none;margin-left: 10px;float: right;margin-left: 10px;display:none;"
                                            data-dismiss="modal" class="btn btn-warning resetslider" type="button">
                                        RESET
                                    </button>
                                   <!-- &nbsp;<a style="float: right;margin-left:10px;" id="clear_{{ $value->ID }}" class="btn btn-danger  clearall"
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
                <script>
                    function changeqty(id, opr){
                        var num = Number($('.number' + id).text());
                        if (num == '1'){
                            if (opr == 'plus'){
                                num++;
                            }
                        } else {
                            (opr == 'plus') ? num++ : --num;
                        }
                        $('.number' + id).text(num);
                    }
                </script>
                @endforeach
            </div>
        </div>
        <div style="display: none;" class="nxtpage">
            <li class="next disabled"><a href="" onclick="return false;">Next &gt;&gt;</a></li>  
        </div>
        <div id="loadmoreajaxloader" style="display:none;">
            <center><img src="{{ asset('assets/images/ajax-loader.gif') }}"></center>
        </div>
        <div class="clearfix"></div>
        
        <div class="col-md-12  margin-bottom-10">
            <button align="center" class="loadmore btn btn-primary">Load More</button>
        </div>
        
        <div class="clearfix"></div>

        <script>
            $(function() {
                $('.loadmore').click(function() {
                    $('div#loadmoreajaxloader').show();
                    $.ajax({
                        url: $('.next a').attr('href'),
                        success: function(html) {
                            if (!$('.next').hasClass('disabled')) {
                                if (html) {
                                    $('.nxtpage').remove();
                                    $("#postswrapper").append(html);
                                    $('div#loadmoreajaxloader').hide();
                                } else {
                                    $('div#loadmoreajaxloader').html('<center>No more menus to show.</center>');
                                }
                            } else {
                                $('.loadmore').hide();
                                $('div#loadmoreajaxloader').html('<center>No more menus to show.</center>');
                            }
                        }
                    });
                });

                $('.modal').on('shown.bs.modal', function() {
                    $('input:text:visible:first', this).focus();
                });
                
                $('.clearall , .close').click(function() {
                    var menu = $(this).attr('id');
                    menu = menu.replace('clear_', '');
                    //alert(menu);
                    $('.subitems_' + menu).find('input:checkbox, input:radio').each(function() {
                        if (!$(this).hasClass('chk'))
                            $(this).removeAttr("checked");
                        $('.allspan').html('&nbsp;&nbsp;1&nbsp;&nbsp;');

                    });
                    $('.inp').val("");
                    $('.fancybox-close').click();
                });
                
                $('.resetslider').live('click', function() {
                    var menu = $(this).attr('id');
                    menu = menu.replace('clear_', '');
                    //alert(menu);
                    $('.subitems_' + menu).find('input:checkbox, input:radio').each(function() {
                        if (!$(this).hasClass('chk'))
                            $(this).removeAttr("checked");
                        $('.allspan').html('&nbsp;&nbsp;1&nbsp;&nbsp;');

                    });
                    $('.inp').val("");
                    $(this).parent().parent().find('.nxt_button').show();
                    $(this).parent().parent().find('.nxt_button').attr('title', '1');
                    $(this).parent().parent().find('.prv_button').hide();
                    var banner = $(this).parent().parent().parent().find('.bannerz');
                    banner.animate({scrollLeft: 0}, 1000);
                });
                //add items to receipt
                var counter_item = 0;
                $('.add_menu_profile').live('click', function() {
                    //alert(123);
                    var menu_id = $(this).attr('id').replace('profilemenu', '');
                    var ids = "";
                    var app_title = "";
                    var price = "";
                    var extratitle = "";
                    var dbtitle = "";
                    var err = 0;
                    var catarray = [];
                    var td_index = 0;
                    var td_temp = 9999;

                    $('.subitems_' + menu_id).find('input:checkbox, input:radio').each(function(index) {
                        if ($(this).is(':checked') && $(this).attr('title') != "") {

                            var tit = $(this).attr('title');

                            var title = tit.split("_");
                            if (index != 0) {
                                extratitle = extratitle + "," + title[1];
                            }
                            var su = "";

                            if ($(this).val() != "") {

                                var cnn = 0;
                                var catid = $(this).attr('id');
                                catarray.push(catid);

                                var is_required = $('#required_' + catid).val();
                                var extra_no = $('#extra_no_' + catid).val();
                                if (extra_no == 0)
                                    extra_no = 1;
                                var multiples = $('#multiple_' + catid).val();
                                var upto = $('#upto_' + catid).val();

                                var ary_qty = "";
                                var ary_price = "";
                                $('.extra-' + catid).each(function() {
                                    if ($(this).is(":checked")) {
                                        var mid = $(this).attr('id').replace('extra_', '');
                                        //alert(mid);
                                        var qty = Number($(this).parent().find('.span_' + mid).text().trim());

                                        if (qty != "") {
                                            cnn += Number(qty);
                                            //ary_qty = ary_qty+"_"+qty;
                                            //qprice = Number()*Number(qty);
                                            //ary_price = ary_price+"_"+qprice;
                                        } else {
                                            cnn++;
                                        }
                                    }
                                });


                                if (is_required == '1') {
                                    if (upto == 0) {
                                        if (cnn == 0) {
                                            err++;
                                            td_index = $('#td_' + catid).index();
                                            //alert(td_index);
                                            if (td_temp >= td_index) {
                                                td_temp = td_index;
                                            } else {
                                                td_temp = td_temp;
                                            }
                                            $('.error_' + catid).html("Options are Mandatory");
                                        } else if (multiples == 0 && cnn > extra_no) {
                                            err++;
                                            td_index = $('#td_' + catid).index();
                                            //alert(td_index);
                                            if (td_temp >= td_index) {
                                                td_temp = td_index;
                                            } else {
                                                td_temp = td_temp;
                                            }
                                            $('.error_' + catid).html("Select up to " + extra_no + " Options");
                                        } else {
                                            $('.error_' + catid).html("");
                                        }
                                    } else {
                                        if (cnn == 0) {
                                            err++;
                                            td_index = $('#td_' + catid).index();
                                            //alert(td_index);
                                            if (td_temp >= td_index) {
                                                td_temp = td_index;
                                            } else {
                                                td_temp = td_temp;
                                            }
                                            $('.error_' + catid).html("Options are Mandatory");
                                        } else if (multiples == 0 && cnn != extra_no) {
                                            err++;
                                            td_index = $('#td_' + catid).index();
                                            //alert(td_index);
                                            if (td_temp >= td_index) {
                                                td_temp = td_index;
                                            } else {
                                                td_temp = td_temp;
                                            }
                                            $('.error_' + catid).html("Select " + extra_no + " Options");
                                        } else {
                                            $('.error_' + catid).html("");
                                        }
                                    }
                                } else {
                                    if (upto == 0) {
                                        if (multiples == 0 && cnn > 0 && cnn > extra_no) {
                                            err++;
                                            td_index = $('#td_' + catid).index();
                                            //alert(td_index);
                                            if (td_temp >= td_index) {
                                                td_temp = td_index;
                                            } else {
                                                td_temp = td_temp;
                                            }
                                            $('.error_' + catid).html("Select up to " + extra_no + " Options");
                                        } else {
                                            $('.error_' + catid).html("");
                                        }
                                    } else {
                                        if (multiples == 0 && cnn > 0 && cnn != extra_no) {
                                            err++;
                                            td_index = $('#td_' + catid).index();

                                            //alert(td_index);
                                            if (td_temp >= td_index) {
                                                td_temp = td_index;
                                            } else {
                                                td_temp = td_temp;
                                            }
                                            $('.error_' + catid).html("Select " + extra_no + " Options");
                                        } else {
                                            $('.error_' + catid).html("");
                                        }
                                    }
                                }
                                if (cnn > 0) {
                                    su = $(this).val();
                                    extratitle = extratitle + " " + su + ":";
                                    app_title = app_title + " " + su + ":";
                                }
                            }
                            var x = index;
                            if (title[0] != "") {
                                ids = ids + "_" + title[0];
                            }
                            //if(app_title!="")
                            app_title = app_title + "," + title[1];

                            //else
                            //app_title = title[1];
                            price = Number(price) + Number(title[2]);

                        }
                    });
                    ids = ids.replace("__", "_");

                    //app_title =app_title.replace(",,"," ");
                    app_title = app_title.split(",,").join("");
                    app_title = app_title.substring(1, app_title.length);
                    var last = app_title.substring(app_title.length, app_title.length - 1);
                    if (last == ",") {
                        app_title = app_title.substring(0, app_title.length - 1);
                    }
                    var last = app_title.substring(app_title.length, app_title.length - 1);
                    if (last == "-") {
                        app_title = app_title.substring(0, app_title.length - 1);
                    }
                    app_title = app_title.split(",(").join("(");
                    app_title = app_title.split("-").join(" -");
                    app_title = app_title.split("-,").join("-");
                    app_title = app_title.split(",").join(", ");
                    app_title = app_title.split(":").join(": ");

                    app_title = app_title.split("x,").join("x");

                    extratitle = extratitle.split(":,").join(":");
                    extratitle = extratitle.substring(1, extratitle.length);
                    var last1 = extratitle.substring(extratitle.length, extratitle.length - 1);
                    if (last1 == ",") {
                        extratitle = extratitle.substring(0, extratitle.length - 1);
                    }
                    var last1 = extratitle.substring(extratitle.length, extratitle.length - 1);
                    if (last1 == "-") {
                        extratitle = extratitle.substring(0, extratitle.length - 1);
                    }
                    dbtitle = extratitle.split(",").join("%");
                    dbtitle = dbtitle.split("%%").join("");
                    //alert(dbtitle);
                    if (err > 0) {
                        var banner = $(this).parent().parent().parent().find('.bannerz');
                        var l = banner.width();
                        var total_td = banner.find('td').length;
                        $(".bannerz").animate({scrollLeft: (l * td_temp)}, 800);
                        td_temp = td_temp + 1;

                        $(this).parent().parent().find('.nxt_button').attr('title', td_temp);
                        $(this).parent().parent().find('.nxt_button').show();
                        var id = banner.find('td:nth-child(' + td_temp + ')').attr('id').replace('td_', '');
                        //alert(id);
                        $('#boxes_' + id).focus();
                        if (td_temp == 1) {
                            $(this).parent().parent().find('.prv_button').hide();
                        } else {
                            $(this).parent().parent().find('.prv_button').show();
                        }
                        return false;
                    } else {
                        var banner = $(this).parent().parent().parent().find('.bannerz');
                        $(this).parent().parent().find('.nxt_button').attr('title', '1');
                        $(this).parent().parent().find('.prv_button').hide();
                        banner.animate({scrollLeft: 0}, 10);
                        $(this).parent().parent().find('.nxt_button').show();
                        catarray.forEach(function(catid) {
                            $('#error_' + catid).html("");
                        })
                    }

                    var pre_cnt = $('#list' + ids).find('.count').text();
                    pre_cnt = Number(pre_cnt.replace('x ', ''));
                    var n = $('.number' + menu_id).text();
                    if (pre_cnt != "") {
                        pre_cnt = Number(pre_cnt) + Number(n);
                    } else {
                        pre_cnt = Number(n);
                    }
                    var img = $('.popimage_' + menu_id).attr('src');
                    //price = price*pre_cnt;
                    $('#list' + ids).remove();
                    $('.orders').prepend('<li id="list' + ids + '" class="infolist" ></li>');
                    $('#list' + ids).html('<span class="receipt_image"><img src="' + img + '" width="37" height="34">' +
                            '<a style="padding: 6px;height: 18px;line-height: 6px" id="dec' + ids + '" class="decrease small btn btn-danger" href="javascript:void(0);">' +
                            '<strong>-</strong></a><span class="count">x ' + pre_cnt + '</span><input type="hidden" class="count" name="qtys[]" value="' + pre_cnt + '" />' + ' &nbsp;<a id="inc' + ids + '" class="increase btn btn-primary small " href="javascript:void(0);" style="padding: 6px;height: 18px;line-height: 6px">' +
                            '<strong>+</strong></a></span>' +
                            //'<span class="cart-content-count">x '+pre_cnt+'</span>'+
                            '<span class="amount" style="display:none;">' + price.toFixed(2) + '</span>' +
                            '<strong>' + app_title + '</strong>' +
                            '<em class="total">$' + (pre_cnt * price).toFixed(2) + '</em>' +
                            '<input type="hidden" class="menu_ids" name="menu_ids[]" value="' + menu_id + '" />' +
                            '<input type="hidden" name="extras[]" value="' + dbtitle + '"/><input type="hidden" name="listid[]" value="' + ids + '" />' +
                            '<input type="hidden" class="prs" name="prs[]" value="' + (pre_cnt * price).toFixed(2) + '" />' +
                            '<a href="javascript:void(0);" class="del-goods" onclick="">&nbsp;</a>');
                    price = parseFloat(price);
                    var subtotal = "";
                    var ccc = 0;
                    $('.total').each(function() {
                        ccc++;
                        var tt = $(this).text().replace('$', '');
                        subtotal = Number(subtotal) + Number(tt);
                    })
                    var items = (ccc == '1') ? ccc + ' item' : ccc + ' items';
                    $('#cart-items').text(items);
                    subtotal = parseFloat(subtotal);
                    //subtotal = Number(subtotal)+Number(price);
                    subtotal = subtotal.toFixed(2);
                    $('div.subtotal').text(subtotal);
                    $('input.subtotal').val(subtotal);

                    var tax = $('#tax').text();
                    tax = parseFloat(tax);
                    tax = (tax / 100) * subtotal;
                    tax = tax.toFixed(2);
                    $('div.tax').text(tax);
                    $('input.tax').val(tax);

                    if ($('#delivery_flag').val() == '1')
                        var del_fee = $('.df').val();
                    else
                        var del_fee = 0;
                    del_fee = parseFloat(del_fee);
                    //alert(del_fee);

                    var gtotal = Number(subtotal) + Number(tax) + Number(del_fee);
                    gtotal = gtotal.toFixed(2);

                    $('div.grandtotal').text(gtotal);
                    $('input.grandtotal').val(gtotal);
                    $('#cart-total').text(gtotal);
                    $('.subitems_' + menu_id).find('input:checkbox, input:radio').each(function() {
                        if (!$(this).hasClass('chk'))
                            $(this).removeAttr("checked");
                    });

                    $('.number' + menu_id).text('1');
                    //$('#clear_' + menu_id).click();
                    $('.fancybox-close').click();
                    //$('.subitems_'+menu_id).hide();
                });
            });

            function inArray(needle, haystack) {
                var length = haystack.length;
                for (var i = 0; i < length; i++) {
                    if (haystack[i] == needle)
                        return true;
                }
                return false;
            }

            function changeqty(id, opr) {
                var num = Number($('.number' + id).text());
                if (num == '1') {
                    if (opr == 'plus')
                        num++;
                } else {
                    (opr == 'plus') ? num++ : --num;
                }
                $('.number' + id).text(num);
            }
        </script>
    </div>
    <!-- BEGIN CART -->
    <div class="top-cart-block col-md-3 col-sm-4" id="printableArea" style="height: 599px;">

        
            <div class="top-cart-info" >
                <div class="col-md-6">
                    <a href="javascript:void(0);" class="top-cart-info-count" id="cart-items">3 items</a>
                </div>
                <div class="col-md-6">
                    <a href="javascript:void(0);" class="top-cart-info-value" id="cart-total">$1260</a>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3">
                    <a href="#cartsz" class="fancybox-fast-view"><i class="fa fa-shopping-cart" onclick="#cartsz"></i></a>
                </div>
            </div>

            <div id="cartsz">
                <div class="row  resturant-logo-desc">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12 no-padding">
                                <img src="<?php echo url('assets/images/restaurants')."/".$res_detail->Logo; ?>" class="img-responsive">
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 resturant-desc">
                                <span>1</span>
                                <span>1</span>
                            </div>
                        </div>  
                    </div> 
                </div>  

                <div class="top-cart-content-wrapper">

                    <div class="top-cart-content ">
                        <div class="receipt_main">
                            <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 220px;">
                                <ul class="scroller orders" style="height: 220px; overflow: hidden; width: auto;">
                                   
                                </ul>
                                <div class="slimScrollBar" style="width: 7px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px; background: rgb(187, 187, 187);"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(234, 234, 234);"></div></div>                    <div class="totals col-md-12 col-sm-12 col-xs-12">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td><label class="radio-inline"><input type="radio" name="delevery_type" checked="checked" onclick="delivery('hide');">Pickup</label></td>
                                            <td><label class="radio-inline"><input type="radio" name="delevery_type" onclick="delivery('show');">Delivery</label></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Subtotal&nbsp;</strong></td><td>&nbsp;$<div class="subtotal" style="display: inline-block;">0</div>
                                                <input type="hidden" name="subtotal" class="subtotal" value="0"></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tax&nbsp;</strong></td><td>&nbsp;$<div class="tax" style="display: inline-block;">0</div>&nbsp;(<div id="tax" style="display: inline-block;">13</div>%)
                                                <input type="hidden" value="0" name="tax" class="tax"></td>
                                        </tr>

                                        <tr style="display: none;" id="df">
                                            <td><strong>Delivery Fee&nbsp;</strong></td><td>&nbsp;$1                                <input type="hidden" value="1" class="df" name="delivery_fee">
                                                <input type="hidden" value="0" id="delivery_flag" name="order_type">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total</strong>&nbsp;</td><td>&nbsp;$<div style="display: inline-block;" class="grandtotal">0</div>
                                                <input type="hidden" name="g_total" class="grandtotal" value="0">
                                                <input type="hidden" name="res_id" value="1">
                                            </td>
                                        </tr>
                                    </tbody></table>
                            </div>
                            <div class="text-right">
                                <input type="button" onclick="printDiv('printableArea')" value="Print">
                                <a href="javascript:void(0)" class="btn btn-default">Clear</a>
                                <a href="javascript:void(0)" class="btn btn-primary" onclick="checkout();">Checkout</a>
                            </div>
                        </div>
                        <div class="profiles" style="display: none;">
                           <div class="form-group">
                                <div class="col-xs-12">
                                    <h2 class="profile_delevery_type"></h2>
                                </div>
                            </div>
                            <form id="profiles">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <div class="form-group">
                                    <div class="col-xs-12 margin-bottom-10">
                                        <input type="text" style="padding-top: 0;margin-top: 0;" placeholder="Name" class="form-control  form-control--contact" name="ordered_by" id="fullname" required="">
                                    </div>                        
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12 col-sm-6 margin-bottom-10">
                                        <input type="email" placeholder="Email" class="form-control  form-control--contact" name="email" id="ordered_email" required="">                        
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <input type="text" placeholder="Phone Number" class="form-control  form-control--contact" name="contact" id="ordered_contact" required="">
                                    </div>
                                    <div class="clearfix"></div>                        
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <input type="password" name="password" id="password1" class="form-control  form-control--contact" placeholder="Password" onkeyup="check_val(this.value);">
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-group confirm_password" style="display: none;">
                                    <div class="col-xs-12">
                                        <input type="password" id="confirm_password" name="" class="form-control  form-control--contact" placeholder="Confirm Password">
                                    </div>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-12">

                                        <select class="form-control  form-control--contact" name="order_till" id="ordered_on_time" required="">
                                            <option value="ASAP">ASAP</option>
                                            <option value="Sep 30, 08:44 - 09:14">Sep 30, 08:44 - 09:14</option><option value="Sep 30, 09:14 - 09:44">Sep 30, 09:14 - 09:44</option><option value="Sep 30, 09:44 - 10:14">Sep 30, 09:44 - 10:14</option><option value="Sep 30, 10:14 - 10:44">Sep 30, 10:14 - 10:44</option><option value="Sep 30, 10:44 - 11:14">Sep 30, 10:44 - 11:14</option><option value="Sep 30, 11:14 - 11:44">Sep 30, 11:14 - 11:44</option><option value="Sep 30, 11:44 - 12:14">Sep 30, 11:44 - 12:14</option><option value="Sep 30, 12:14 - 12:44">Sep 30, 12:14 - 12:44</option><option value="Sep 30, 12:44 - 01:14">Sep 30, 12:44 - 01:14</option><option value="Sep 30, 01:14 - 01:44">Sep 30, 01:14 - 01:44</option><option value="Sep 30, 01:44 - 02:14">Sep 30, 01:44 - 02:14</option><option value="Sep 30, 02:14 - 02:44">Sep 30, 02:14 - 02:44</option><option value="Sep 30, 02:44 - 03:14">Sep 30, 02:44 - 03:14</option><option value="Sep 30, 03:14 - 03:44">Sep 30, 03:14 - 03:44</option><option value="Sep 30, 03:44 - 04:14">Sep 30, 03:44 - 04:14</option><option value="Sep 30, 04:14 - 04:44">Sep 30, 04:14 - 04:44</option><option value="Sep 30, 04:44 - 05:14">Sep 30, 04:44 - 05:14</option><option value="Sep 30, 05:14 - 05:44">Sep 30, 05:14 - 05:44</option>        
                                        </select>
                                    </div>
                                    <div class="clearfix"></div> 

                                </div>
                                <div class="profile_delivery_detail" style="display: none;">
                                    <div class="form-group margin-bottom-10">
                                        <!--textarea placeholder="Address 2" name="address2"></textarea-->   
                                        <div class="col-xs-12 col-sm-6  margin-bottom-10">
                                            <input type="text" placeholder="Address 2" class="form-control  form-control--contact" name="address2">
                                        </div>                        



                                        <div class="col-xs-12 col-sm-6  margin-bottom-10">                        
                                            <input type="text" placeholder="City" class="form-control  form-control--contact" name="city" id="city">                        
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-12 col-sm-6">
                                            <select class="form-control form-control--contact" name="province">
                                                <option value="Alberta">Alberta</option>
                                                <option value="British Columbia">British Columbia</option>
                                                <option value="Manitoba">Manitoba</option>
                                                <option value="New Brunswick">New Brunswick</option>
                                                <option value="Newfoundland and Labrador">Newfoundland and Labrador</option>
                                                <option value="Nova Scotia">Nova Scotia</option>
                                                <option selected="selected" value="Ontario">Ontario</option>
                                                <option value="Prince Edward Island">Prince Edward Island</option>
                                                <option value="Quebec">Quebec</option>
                                                <option value="Saskatchewan">Saskatchewan</option>
                                            </select>

                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <input type="text" placeholder="Postal Code" class="form-control  form-control--contact" name="postal_code" id="postal_code">
                                        </div>                        
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <textarea placeholder="Additional Notes" class="form-control  form-control--contact" name="remarks"></textarea>
                                    </div> 
                                    <div class="clearfix"></div>                       
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <a href="javascript:void(0)" class="btn btn-default back">Back</a>
                                        <button type="submit" class="btn btn-primary">Checkout</button>
                                    </div>
                                    <div class="clearfix"></div>  
                                </div>
                            </form>
                            <script>
                                function check_val(v)
                                {
                                    if (v != '') {
                                        $('.confirm_password').show();
                                        $('#confirm_password').attr('required', 'required');
                                    }
                                    else
                                    {
                                        $('#confirm_password').removeAttr('required');
                                    }
                                }
                                var password = document.getElementById("password1")
                                        , confirm_password = document.getElementById("confirm_password");

                                function validatePassword() {

                                    if (password.value != confirm_password.value) {
                                        confirm_password.setCustomValidity("Passwords Don't Match");
                                    } else {
                                        confirm_password.setCustomValidity('');
                                        $('#confirm_password').removeAttr('required');
                                    }
                                }

                                password.onchange = validatePassword;

                                confirm_password.onkeyup = validatePassword;
                                $(function() {

                                    $('.back').live('click', function() {
                                        $('.receipt_main').show();
                                        $('.profiles').hide();
                                    });
                                    $('#profiles').submit(function(e) {
                                        e.preventDefault();
                                        var datas = $('#profiles input, select, textarea').serialize();
                                        var order_data = $('.receipt_main input').serialize();
                                        $.ajax({
                                            type: 'post',
                                            url: '<?php echo url();?>/user/ajax_register',
                                            data: datas + '&' + order_data,
                                            success: function(msg) {
                                                if (msg == '0')
                                                {
                                                    $('.top-cart-content ').html('<span class="thankyou">Thank You.</span>');
                                                }
                                                else if (msg == '1')
                                                    alert('Email Already Registred.');
                                            }
                                        })
                                    });

                                });

                            </script>
                        </div>
                    </div>
                </div>

            </div>
            <script>
                function checkout() {
                    var del = $('#delivery_flag').val();
                    $('.receipt_main').hide();
                    $('.profiles').show();
                    /*var datas = $('.top-cart-content input').serialize();
                     $.ajax({
                     type:'post',
                     url:'/Foodie/restaurants/order_ajax',
                     data: datas,
                     success:function(id){
                     if(del == '0') {
                     $('.top-cart-content').load('/Foodie/common/profile.php?order_id='+id);
                     } else {
                     $('.top-cart-content').load('/Foodie/common/profile.php?delivery&order_id='+id);
                     }
                     }
                     })*/
                }

                function delivery(t) {
                    var df = $('input.df').val();
                    if (t == 'show') {
                        $('#df').show();
                        $('.profile_delevery_type').text('Delivery Detail');
                        $('.profile_delivery_detail').show();
                        $('.profile_delivery_detail input').each(function() {
                            $(this).attr('required', 'required');
                        });
                        var tax = $('.tax').text();
                        var grandtotal = 0;
                        var subtotal = $('input.subtotal').val();
                        grandtotal = Number(grandtotal) + Number(df) + Number(subtotal) + Number(tax);
                        $('.df').val(df);
                        $('.grandtotal').text(grandtotal.toFixed(2));
                        $('.grandtotal').val(grandtotal.toFixed(2));
                        $('#delivery_flag').val('1');
                        $('#cart-total').text('$' + grandtotal.toFixed(2));
                    } else {
                        $('.profile_delevery_type').text('Pickup Detail');
                        $('.profile_delivery_detail').hide();
                        var grandtotal = $('input.grandtotal').val();
                        grandtotal = Number(grandtotal) - Number(df);
                        $('.grandtotal').text(grandtotal.toFixed(2));
                        $('.grandtotal').val(grandtotal.toFixed(2));
                        $('#df').hide();
                        $('#delivery_flag').val('0');
                        $('#cart-total').text('$' + grandtotal.toFixed(2));
                    }
                }

                $(function() {
                    var wd = $(window).width();
                    var ht = $(window).height();

                    var headr_ht = $('.container-fluid').height();
                    var htt = Number(ht) - Number(headr_ht);
                    $('.top-cart-block').css({'height': htt});
                    //$(window).scroll(function(){
                    // if(wd>='767')
                    //{
                    //$('.top-cart-block').css({'top':0});
                    //if($(window).scrollTop()== 0)
                    //$('.top-cart-block').css({'top':'110px'});
                    //}
                    //});

                    if (wd <= '767') {
                        $('.top-cart-info').show();
                        $('.header-navigation-wrap').hide();
                        $('.new_headernav').show();
                        $('#cartsz').hide();
                    } else {
                        $('.header-navigation-wrap').show();
                        $('.top-cart-info').hide();
                        $('.new_headernav').hide();
                        $('#cartsz').show();

                    }

                    $(window).resize(function() {
                        var wd = $(window).width();
                        if (wd <= '767') {
                            $('.top-cart-info').show();
                            $('.header-navigation-wrap').hide();
                            $('.new_headernav').show();
                            $('#cartsz').hide();
                        } else {
                            $('.header-navigation-wrap').show();
                            $('.top-cart-info').hide();
                            $('.new_headernav').hide();
                            $('#cartsz').show();

                        }
                    });

                    $('.decrease').live('click', function() {
                        //alert('test');
                        var menuid = $(this).attr('id');
                        var numid = menuid.replace('dec', '');

                        var quant = $('#list' + numid + ' span.count').text();
                        quant = quant.replace('x ', '');

                        var amount = $('#list' + numid + ' .amount').text();
                        amount = parseFloat(amount);

                        var subtotal = 0;
                        $('.total').each(function() {
                            var sub = $(this).text().replace('$', '');
                            subtotal = Number(subtotal) + Number(sub);
                        })
                        subtotal = parseFloat(subtotal);
                        subtotal = Number(subtotal) - Number(amount);
                        subtotal = subtotal.toFixed(2);
                        $('div.subtotal').text(subtotal);
                        $('input.subtotal').val(subtotal);

                        var tax = $('#tax').text();
                        tax = parseFloat(tax);
                        tax = (tax / 100) * subtotal;
                        tax = tax.toFixed(2);
                        $('div.tax').text(tax);
                        $('input.tax').val(tax);

                        var del_fee = 0;
                        if ($('#delivery_flag').val() == '1') {
                            del_fee = $('.df').val();
                        }

                        del_fee = parseFloat(del_fee);

                        var gtotal = Number(subtotal) + Number(tax) + Number(del_fee);
                        gtotal = gtotal.toFixed(2);
                        $('div.grandtotal').text(gtotal);
                        $('input.grandtotal').val(gtotal);

                        var total = $('#list' + numid + ' .total').text();
                        total = total.replace("$", "");
                        total = parseFloat(total);
                        total = Number(total) - Number(amount);
                        total = total.toFixed(2);
                        $('#list' + numid + ' .total').text('$' + total);

                        quant = parseFloat(quant);
                        //alert(quant);
                        if (quant == 1) {
                            $('#list' + numid).remove();
                            $('#profilemenu' + numid).text('Add');
                            $('#profilemenu' + numid).attr('style', '');
                            $('#profilemenu' + numid).addClass('add_menu_profile');
                            $('#profilemenu' + numid).removeAttr('disabled');
                            var ccc = 0;
                            $('.total').each(function() {
                                ccc++;
                            });
                            if (ccc < 4)
                                $('.orders').removeAttr('style');
                            $('.orders').show();
                        } else {
                            quant--;
                            $('#list' + numid + ' span.count').text('x ' + quant);
                            $('#list' + numid + ' input.count').val(quant);
                            //$('#list'+numid+' .count').val(quant-1);
                        }
                    });

                    $('.increase').live('click', function() {
                        var menuid = $(this).attr('id');
                        var numid = menuid.replace('inc', '');
                        var quant = '';
                        quant = $('#list' + numid + ' span.count').text();
                        quant = quant.replace('x ', '');
                        quant = parseFloat(quant);
                        var amount = $('#list' + numid + ' .amount').text();
                        amount = parseFloat(amount);
                        var subtotal = $('.subtotal').text();
                        subtotal = parseFloat(subtotal);
                        subtotal = Number(subtotal) + Number(amount);
                        subtotal = subtotal.toFixed(2);
                        $('div.subtotal').text(subtotal);
                        $('input.subtotal').val(subtotal);
                        var tax = $('#tax').text();
                        tax = parseFloat(tax);
                        tax = (tax / 100) * subtotal;
                        tax = tax.toFixed(2);
                        $('div.tax').text(tax);
                        $('input.tax').val(tax);
                        if ($('#delivery_flag').val() == '1')
                            var del_fee = $('.df').val();
                        else
                            var del_fee = 0;
                        del_fee = parseFloat(del_fee);
                        var gtotal = Number(subtotal) + Number(tax) + Number(del_fee);
                        gtotal = gtotal.toFixed(2);
                        $('div.grandtotal').text(gtotal);
                        $('input.grandtotal').val(gtotal);
                        var total = $('#list' + numid + ' .total').text();
                        total = total.replace("$", "");
                        total = parseFloat(total);
                        total = Number(total) + Number(amount);
                        total = total.toFixed(2);
                        $('#list' + numid + ' .total').text('$' + total);
                        quant++;
                        $('#list' + numid + ' span.count').text('x ' + quant);
                        $('#list' + numid + ' input.count').val(quant);
                    });

                    $('.del-goods').live('click', function() {
                        $(this).parent().remove();
                        var subtotal = 0;
                        $('.total').each(function() {
                            var sub = $(this).text().replace('$', '');
                            subtotal = Number(subtotal) + Number(sub);
                        })
                        subtotal = parseFloat(subtotal);
                        //subtotal = Number(subtotal) - Number(amount);
                        subtotal = subtotal.toFixed(2);
                        $('div.subtotal').text(subtotal);
                        $('input.subtotal').val(subtotal);

                        var tax = $('#tax').text();
                        tax = parseFloat(tax);
                        tax = (tax / 100) * subtotal;
                        tax = tax.toFixed(2);
                        $('div.tax').text(tax);
                        $('input.tax').val(tax);
                        var del_fee = 0;
                        if ($('#delivery_flag').val() == '1') {
                            del_fee = $('.df').val();
                        }
                        del_fee = parseFloat(del_fee);
                        var gtotal = Number(subtotal) + Number(tax) + Number(del_fee);
                        gtotal = gtotal.toFixed(2);
                        $('div.grandtotal').text(gtotal);
                        $('input.grandtotal').val(gtotal);
                    });

                })

                function printDiv(divName) {
                    var printContents = document.getElementById(divName).innerHTML;
                    var originalContents = document.body.innerHTML;

                    document.body.innerHTML = printContents;
                    window.print();
                    document.body.innerHTML = originalContents;
                }


            </script>    


        <!--END CART -->                
        <!-- END CONTENT -->
    </div>
    <!-- END SIDEBAR & CONTENT -->
</div>

@stop