@extends('layouts.default')
@section('content')

    <div class="margin-bottom-40 clearfix">

        <div class="col-md-9 col-sm-9 col-xs-12 menu_div">





            <div class="portlet box red">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-spoon"></i>This is a category
                    </div>

                </div>
                <div class="portlet-body">


                    <div id="postswrapper">
                        @include('menus')

                    </div><br style="clear: both;">
                </div>
            </div>





            <div class="clearfix"></div>
            <div id="loadmoreajaxloader" style="display:none;">
                <img src="{{ asset('assets/images/ajax-loader.gif') }}">
            </div>
            <div class="clearfix"></div>
            <?php if($menus_list->hasMorePages()){?>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12" style="">
                    <button align="center" class="loadmore btn btn-primary">Load More</button>
                </div>
            </div>
            <?php }?>
            <div class="clearfix"></div>

        </div>




        <!-- BEGIN CART -->
        <div class="top-cart-block col-md-3 col-sm-3" id="printableArea">


            <div class="overlay overlay_reservation">
                <div class="clearfix"></div>
                <div id="loadmoreajaxloader">
                    <img src="{{ asset('assets/images/ajax-loading.gif') }}">
                </div>
            </div>
            <div class="top-cart-info">
                <div class="col-md-6">
                    <a href="javascript:void(0);" class="top-cart-info-count" id="cart-items">3 items</a>
                </div>
                <div class="col-md-6">
                    <a href="javascript:void(0);" class="top-cart-info-value" id="cart-total">$1260</a>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3">
                    <a href="#cartsz" class="fancybox-fast-view"><i class="fa fa-shopping-cart"
                                                                    onclick="#cartsz"></i></a>
                </div>
            </div>



            @include('common.receipt')




                    <!--
<div id="cartsz">


                <div class="resturant-logo-desc">


                    <div class="col-md-12 col-sm-12 col-xs-12">

                        @if(!empty($restaurant->logo))
                    <img class="img-responsive" alt=""
                         src="{{ url('assets/images/restaurants/'.$restaurant->logo) }}">
                        @else
                    <img class="img-responsive" alt="" src="{{ url('assets/images/default.png') }}">
                        @endif
                    <address>
                        <strong>{!! $restaurant->name !!}.</strong><br>
                            {!! $restaurant->address.' , '.$restaurant->city !!}
            {!! $restaurant->province.' , '.$restaurant->country !!}<br>
                            <abbr title="Phone">P:</abbr> {!! $restaurant->phone !!}
                    <abbr title="Email">E:</abbr>
                    <a href="{{ $restaurant->email }}">
                                {!! $restaurant->email !!}
                    </a>
                </address>

            </div>

            <div class="clearfix"></div>

        </div>


        <div class="top-cart-content-wrapper">

            <div class="top-cart-content ">
                <div class="receipt_main">
                    <div class="slimScrollDiv"
                         style="position: relative; overflow: hidden; width: auto; height: 220px;">
                        <ul class="scroller orders" style="height: 220px; overflow-y: scroll; width: auto;">

                        </ul>
                        <div class="slimScrollBar"
                             style="width: 7px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px;"></div>
                        <div class="slimScrollRail"
                             style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px;"></div>
                    </div>


                    <div class="totals col-md-12 col-sm-12 col-xs-12 no-padding">
                        <table class="table">
                            <tbody>
                            <tr>
                                <td><label class="radio-inline"><input type="radio" name="delevery_type"
                                                                       checked="checked"
                                                                       onclick="delivery('hide');">Pickup</label>
                                </td>
                                <td><label class="radio-inline"><input type="radio" name="delevery_type"
                                                                       onclick="delivery('show');">Delivery</label>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Subtotal&nbsp;</strong></td>
                                        <td>&nbsp;$<div class="subtotal" style="display: inline-block;">0</div>
                                            <input type="hidden" name="subtotal" class="subtotal" value="0"></td>
                                    </tr>

                                    <tr>
                                        <td><strong>Tax&nbsp;</strong></td>

                                        <td>&nbsp;$<div class="tax" style="display: inline-block;">0</div>
                                            &nbsp;(<div id="tax" style="display: inline-block;">13</div> %)
                                            <input type="hidden" value="0" name="tax" class="tax">
                                        </td>

                                    </tr>

                                    <tr style="display: none;" id="df">
                                        <td><strong>Delivery Fee&nbsp;</strong></td>
                                        <td>&nbsp;$1 <input type="hidden" value="1" class="df" name="delivery_fee">
                                            <input type="hidden" value="0" id="delivery_flag" name="order_type">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total</strong>&nbsp;</td>
                                        <td>&nbsp;$<div style="display: inline-block;" class="grandtotal">0</div>
                                            <input type="hidden" name="g_total" class="grandtotal" value="0">
                                            <input type="hidden" name="res_id" value="{{ $restaurant->id }}">
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>



                            <div class="text-right">
                                <a href="#" type="button" onclick="printDiv('printableArea')"
                                   class="btn btn-warning">Print</a>
                                <a href="javascript:void(0)" class="btn btn-warning">Restart</a>
                                <a href="javascript:void(0)" class="btn btn-primary"
                                   onclick="checkout();">Checkout</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
-->
        </div>
    </div>


    <!-- END SIDEBAR & CONTENT -->


    </div>


    </div>


    <script>
        function check_val(v) {
            if (v != '') {
                $('.confirm_password').show();
                $('#confirm_password').attr('required', 'required');
            }
            else {
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
        $(function () {

            $('.back').live('click', function () {
                $('.receipt_main').show();
                $('.profiles').hide();
            });
            $('#profiles').submit(function (e) {
                e.preventDefault();
                $('.overlay_reservation').show();
                var datas = $('#profiles input, select, textarea').serialize();
                var order_data = $('.receipt_main input').serialize();
                $.ajax({
                    type: 'post',
                    url: '<?php echo url();?>/user/ajax_register',
                    data: datas + '&' + order_data,
                    success: function (msg) {
                        $('.overlay_reservation').hide();
                        if (msg == '0') {
                            $('.top-cart-content ').html('<span class="thankyou"> Thank you, for your order <br/>or <br/> creating an account.<br/> (an email has been sent to you).</span>');
                        }
                        else if (msg == '1')
                            alert('Email Already Registred.');
                        else
                            alert(msg);
                    }
                })
            });

        });

    </script>















    <script>
        $(function () {


            $('.modal').on('shown.bs.modal', function () {
                $('input:text:visible:first', this).focus();
            });

            $('.clearall , .close').click(function () {
                var menu = $(this).attr('id');
                menu = menu.replace('clear_', '');
                //alert(menu);
                $('.subitems_' + menu).find('input:checkbox, input:radio').each(function () {
                    if (!$(this).hasClass('chk'))
                        $(this).removeAttr("checked");
                    $('.allspan').html('&nbsp;&nbsp;1&nbsp;&nbsp;');

                });
                $('.inp').val("");
                $('.fancybox-close').click();
            });

            $('.resetslider').live('click', function () {
                var menu = $(this).attr('id');
                menu = menu.replace('clear_', '');
                //alert(menu);
                $('.subitems_' + menu).find('input:checkbox, input:radio').each(function () {
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
            $('.add_menu_profile').live('click', function () {
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

                $('.subitems_' + menu_id).find('input:checkbox, input:radio').each(function (index) {
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
                            $('.extra-' + catid).each(function () {
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
                    catarray.forEach(function (catid) {
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
                $('.total').each(function () {
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
                $('.subitems_' + menu_id).find('input:checkbox, input:radio').each(function () {
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


    <script>
        function checkout() {
            var del = $('#delivery_flag').val();

            if ($('.subtotal').text() == '0' || $('#subtotal1').val() == '0') {
                alert('Please select an item.');
            }
            else {
                $('.receipt_main').hide();
                $('.profiles').show();
            }
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
                $('.profile_delivery_detail input').each(function () {
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
                if ($('#pickup1').hasClass("deliverychecked")) {
                    //alert('sss');
                }
                else {
                    var grandtotal = $('input.grandtotal').val();
                    grandtotal = Number(grandtotal) - Number(df);
                    $('.grandtotal').text(grandtotal.toFixed(2));
                    $('.grandtotal').val(grandtotal.toFixed(2));
                    $('#df').hide();
                    $('#delivery_flag').val('0');
                    $('#cart-total').text('$' + grandtotal.toFixed(2));
                }
            }
        }

        $(function () {


            $('.decrease').live('click', function () {
                //alert('test');
                var menuid = $(this).attr('id');
                var numid = menuid.replace('dec', '');

                var quant = $('#list' + numid + ' span.count').text();
                quant = quant.replace('x ', '');

                var amount = $('#list' + numid + ' .amount').text();
                amount = parseFloat(amount);

                var subtotal = 0;
                $('.total').each(function () {
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
                    $('.total').each(function () {
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

            $('.increase').live('click', function () {
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

            $('.del-goods').live('click', function () {
                $(this).parent().remove();
                var subtotal = 0;
                $('.total').each(function () {
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






@stop