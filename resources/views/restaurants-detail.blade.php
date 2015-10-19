@extends('layouts.default')
@section('content')

<div class="margin-bottom-40">
    <div class="col-md-2 col-sm-4 col-xs-12">

        <div class="well add-sidebar">
            <!--img class="img-responsive margin-bottom-10" alt="" src="/Foodie//img/works/img4.jpg"-->

            <address>
                <strong>Loop, Inc.</strong><br>
                795 Park Ave, Suite 120<br>
                San Francisco, CA 94107<br>
                <abbr title="Phone">P:</abbr> (234) 145-1810
            </address>
            <address>
                <strong>Full Name</strong><br>
                <a href="mailto:#">
                    first.last@email.com
                </a>
            </address>
        </div>
    </div>

    <div class="col-md-7 col-sm-4 col-xs-12 menu_div">
        <!--link rel="stylesheet" href="/Foodie/css/popstyle.css"-->

        <div id="postswrapper">
        </div>
        <div style="display: none;" class="nxtpage">
            <li class="next disabled"><a href="" onclick="return false;">Next &gt;&gt;</a></li>  </div>
        <div id="loadmoreajaxloader" style="display:none;"><center><img src="/Foodie/img/ajax-loader.gif"></center></div>
        <div class="clearfix"></div>
        <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12  margin-bottom-10">
            <button align="center" class="loadmore red btn btn-primary">Load More</button>
        </div>
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
                    //alert(subtotal);
                    //if (ccc > 3)
                    // $('.orders').attr('style', 'display:block;height:260px;overflow-x:hidden;overflow-y:scroll;');
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
    <div class="top-cart-block col-md-3 col-sm-4" id="printableArea" style="height: 601px;">

        <div class="top-cart-info" style="display: none;">
            <div class="top-cart-info" style="display: none;">
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
                                <img src="/Foodie/img/restaurants/" class="img-responsive">
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
                                                <input type="hidden" name="res_id" value="4">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
                                            <option value="Sep 30, 07:51 - 08:21">Sep 30, 07:51 - 08:21</option><option value="Sep 30, 08:21 - 08:51">Sep 30, 08:21 - 08:51</option><option value="Sep 30, 08:51 - 09:21">Sep 30, 08:51 - 09:21</option><option value="Sep 30, 09:21 - 09:51">Sep 30, 09:21 - 09:51</option><option value="Sep 30, 09:51 - 10:21">Sep 30, 09:51 - 10:21</option><option value="Sep 30, 10:21 - 10:51">Sep 30, 10:21 - 10:51</option><option value="Sep 30, 10:51 - 11:21">Sep 30, 10:51 - 11:21</option><option value="Sep 30, 11:21 - 11:51">Sep 30, 11:21 - 11:51</option><option value="Sep 30, 11:51 - 12:21">Sep 30, 11:51 - 12:21</option><option value="Sep 30, 12:21 - 12:51">Sep 30, 12:21 - 12:51</option><option value="Sep 30, 12:51 - 01:21">Sep 30, 12:51 - 01:21</option><option value="Sep 30, 01:21 - 01:51">Sep 30, 01:21 - 01:51</option><option value="Sep 30, 01:51 - 02:21">Sep 30, 01:51 - 02:21</option><option value="Sep 30, 02:21 - 02:51">Sep 30, 02:21 - 02:51</option><option value="Sep 30, 02:51 - 03:21">Sep 30, 02:51 - 03:21</option><option value="Sep 30, 03:21 - 03:51">Sep 30, 03:21 - 03:51</option><option value="Sep 30, 03:51 - 04:21">Sep 30, 03:51 - 04:21</option><option value="Sep 30, 04:21 - 04:51">Sep 30, 04:21 - 04:51</option>
                                        </select>
                                    </div>
                                    <div class="clearfix"></div>

                                </div>
                                <div class="profile_delivery_detail" style="display: none;">
                                    <div class="form-group margin-bottom-10">
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
                                            url: 'http://localhost/Foodie/users/ajax_register',
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

        </div>

        <!--END CART -->
        <!-- END CONTENT -->
    </div>
    <!-- END SIDEBAR & CONTENT -->
</div>

@stop