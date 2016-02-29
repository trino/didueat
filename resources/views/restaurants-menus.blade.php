@extends('layouts.default')
@section('content')
    <script src="{{ asset('assets/global/scripts/form-validation.js') }}"></script>
    @include("popups.rating")

    <?php
    $checkout_modal = false;

    if (read("restaurant_id") && read("restaurant_id") != $restaurant->id) {
        popup(false, "You can not place orders as a restaurant owner", "Oops");
    }


    $is_my_restro = false;
    if (Session::has('session_restaurant_id') && Session::get('session_restaurant_id') == $restaurant->id) {
        $is_my_restro = true;
    }

    $business_day = \App\Http\Models\Restaurants::getbusinessday($restaurant);
    if (!$business_day) {
        //popup(false, $restaurant->name . " is currently closed", "Oops");
    }

    if($is_my_restro){
    ?>
    <div class="card  m-b-0" style="border-radius:0 !important;">
        <div class="card-block ">
            <div class="container" style="margin-top: 0 !important;padding:0 !important;">
                <h4 class="card-title text-xs-center m-b-0">Limit of 25 items</h4>

                <p class="card-title text-xs-center m-b-0">Be creative, 95% of your menu can be uploaded with oursystem.</p>

                <div class="col-md-4 col-md-offset-4 ">
                    <a href="#" id="add_item0" type="button btn-primary btn-block"
                       class="btn btn-primary additem  btn-block"
                       data-toggle="modal"
                       data-target="#addMenuModel">
                        Add Menu Item
                    </a>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <?
    }
    ?>

    <div class="container" style="">
        <?= printfile("views/restaurants-menus.blade.php"); ?>
        <div class="row">

            <div class="col-md-8 col-xs-12 " style="">
                @if(!$is_my_restro)

                    <div class="list-group-item m-b-1">
                        <div class="col-md-3 col-xs-3 p-l-0">
                            <img style="max-width:100%;" class="pull-left img-rounded"
                                 @if(isset($restaurant->logo) && !empty($restaurant->logo))
                                 src="{{ asset('assets/images/restaurants/'.$restaurant->id.'/small-'.$restaurant->logo) }}"
                                 @else
                                 src="{{ asset('assets/images/small-smiley-logo.png') }}"
                                 @endif
                                 alt="">


                            <div class="clearfix"></div>
                        </div>

                        <div class="col-md-9 p-a-0" style="">
                            <div class="">
                                <h2 class="card-title">
                                    {!! (isset($restaurant->name))?$restaurant->name:'' !!}
                                </h2>

                                <div id="restaurant_rating">
                                    {!! rating_initialize((session('session_id'))?"static-rating":"static-rating", "restaurant", $restaurant->id, false, 'update-rating', true, false, '') !!}
                                    <div class="clearfix"></div>
                                </div>
                    <span class="card-text m-b-0 list-inline-item">
                    {!! (isset($restaurant->address))?$restaurant->address.',':'' !!}
                        {!! (isset($restaurant->city))?$restaurant->city.', ':'' !!}
                        {!! (isset($restaurant->province))? 'ON':'' !!}
                        {!! (isset($restaurant->postal_code))?$restaurant->postal_code.' ':'' !!}
                    </span>


                                <div class="clearfix"></div>
                                @if($restaurant->is_delivery)
                                    @if(!$restaurant->is_pickup)
                                        <span class="list-inline-item"><strong>Delivery only</strong></span>
                                    @endif
                                    <span class="list-inline-item">
                                        <? echo '<strong>Delivery</strong> ' . asmoney($restaurant->delivery_fee, $free = true); ?>
                                    </span>

                                    <span class="list-inline-item">
                                        <? echo '<strong>Minimum</strong> ' . asmoney($restaurant->minimum, $free = false); ?>
                                    </span>

                                @elseif($restaurant->is_pickup)
                                    <span class="list-inline-item"><strong>Pickup only</strong></span>
                                @endif


                                <a class="list-inline-item" style="" class="clearfix" href="#" data-toggle="modal"
                                   data-target="#viewMapModel">More Details</a>
                                </span>

                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                @endif

                <div class="">
                    <div class="overlay overlay_reservation">
                        <div class="loadmoreajaxloader">

                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class=" menu_div">
                        @if(isset($restaurant))
                            <input type="hidden" id="res_id" value="{{ $restaurant->id }}"/>
                            @endif
                            @foreach($category as $cat)
                                    <!--  {{ $cat->title }} -->
                            <div id="postswrapper_{{ $cat->id }}" class="loadcontent"></div>
                            <div id="loadmoreajaxloader_{{ $cat->id }}" style="display: none;">

                            </div>
                            <!-- add menu item -->
                            <script>
                                $(function () {
                                    $.ajax({
                                        url: "{{ url('/restaurants/loadmenus/' . $cat->id . '/' . $restaurant->id) }}",
                                        success: function (res) {
                                            if (res != 'no') {
                                                $("#postswrapper_{{ $cat->id }}").html(res);
                                            }
                                            else {
                                                $("#postswrapper_{{ $cat->id }}").html('<div class="alert alert-danger" role="alert">7777No menu items yet<div class="clearfix"></div></div>');
                                            }
                                        },
                                        error: function (res) {
                                            if (res != 'no') {
                                                $("#postswrapper_{{ $cat->id }}").html(res);
                                            }
                                            else {
                                                $("#postswrapper_{{ $cat->id }}").html('<div class="alert alert-danger" role="alert">88888N4o menu items yet<div class="clearfix"></div></div>');
                                            }
                                        }
                                    });
                                });
                            </script>
                            @endforeach
                                    <!--input type="file" accept="image/*;capture=camera"-->
                    </div>
                </div>
            </div>
            <div class=" col-md-4 col-sm-4" id="printableArea">

                @include('common.receipt', array("is_my_restro" => $is_my_restro, "is_open"=>$business_day, "checkout_modal" => $checkout_modal))
            </div>
        </div>
    </div>
    </div>

    @if(Session::has('session_restaurant_id') && Session::get('session_restaurant_id') == $restaurant->id)
        <div class="modal clearfix" id="addMenuModel" tabindex="-1" role="dialog"
             aria-labelledby="addMenuModelLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="addMenuModelLabel">Add Menu Item</h4>
                    </div>
                    <div class="modal-body" id="menumanager2"></div>
                    <div class="modal-footer">
                        <!--button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button-->
                    </div>
                </div>
            </div>
        </div>
    @endif



    @include('popups.more_detail')



    <script type="text/javascript">
        var checkout_modal = "{{ $checkout_modal }}";
        function addresschange(where) {
            //code for adding addresses to the drop down is in views/common/receipt.blade.php
            if ($("#delivery1").is(":checked")) {
                var found = false;
                if ($("#reservation_address").is(":visible")) {
                    var element = $("#reservation_address .dropdown-item").filter(":selected");
                    if (element) {
                        var address_latitude = element.attr("latitude");
                        var address_longitude = element.attr("longitude");
                        found = !isundefined(element.attr("latitude"));
                    }
                } else {
                    var address_latitude = $("#latitude").val();
                    var address_longitude = $("#longitude").val();
                    found = address_latitude && address_longitude && !$("#ordered_email-error").is(":visible");
                }

                if (found) {
                    var distance = calcdistance({{ $restaurant->latitude }}, {{ $restaurant->longitude }}, address_latitude, address_longitude);
                    if (distance > {{ $restaurant->max_delivery_distance }}) {
                        var message = unescapetext("{{ $restaurant->name }}") + " will only deliver within {{ $restaurant->max_delivery_distance }} km, your address is " + distance.toFixed(2) + " km away.";
                        @if(debugmode())
                            if (where == "addresscheck") {
                            return confirm(message + " Would you like to bypass this restriction? (DEBUG MODE)");
                        }
                        @endif
                        alert(message);
                        return false;
                    } else if (debugmode) {
                        alert("DEBUG MODE: The address " + address_latitude + " - " + address_longitude + " is " + distance + " km away from {{ $restaurant->latitude }} - {{ $restaurant->longitude }}");
                    }
                    element.trigger("click");
                    return true;
                } else if (where == "addresscheck") {
                    alert("No address specified");
                    return false;
                }
            }
            return true;
        }

        function check_val(v) {
        }

        Stripe.setPublishableKey('pk_test_fcMnnEwpoC2fUrTPpOayYUOf');
        var stripeResponseHandler = function (status, response) {
            //var $form = $('#payment-form');
            var $form = $('#profiles');
            if (response.error) {
                // Show the errors on the form
                $form.find('.payment-errors').text(response.error.message);
                $form.find('button').prop('disabled', false);
                $('.overlay_loader').hide();
                $('#chkOut').removeAttr('disabled');
            } else {
                // token contains id, last4, and card type
                var token = response.id;
                // Insert the token into the form so it gets submitted to the server
                $('.stripeToken').val(token);

                // and re-submit

                var token = $('#profiles input[name=_token]').val();
                var datas = $('#profiles input, select, textarea').serialize();
                var order_data = $('.receipt_main input').serialize();
                //alert(order_data);
                $.ajax({
                    type: 'post',
                    url: '<?php echo url(); ?>/user/ajax_register',
                    data: datas + '&' + order_data + '&_token=' + token,
                    success: function (msg) {
                        msg = msg.trim();
                        $('.overlay_loader').hide();
                        $('#chkOut').removeAttr('disabled');
                        if (msg == '1') {
                            $('#ordered_email').focus();
                            $('.email_error').show();
                            $('.email_error').html('Email Already Registered.');
                            //$('.email_error').fadeOut(2000);
                        } else if (msg == '6') {
                            window.location = "{{url('orders/list/user?flash=1')}}";
                            $('.top-cart-content ').html("<span class='thankyou'>Thank you! Your order has been received</span>");
                        } else if (msg == '786') {
                            window.location = "{{url('orders/list/user?flash=2')}}";
                            $('.top-cart-content ').html("<span class='thankyou'>Thank you! Your order has been received and your account has been created</span>");
                        } else {
                            alert(msg);
                        }
                    }
                })

            }
        };
        $(document).ready(function () {
            var delivery_type = getCookie("delivery_type");
            if (!delivery_type) {
                delivery_type == "is_delivery";
            }
            if (delivery_type == "is_pickup") {
                $("#pickup1").trigger("click");
            } else {
                $("#delivery1").trigger("click");
            }

            function validatePassword() {
                var password = document.getElementById("password"), confirm_password = document.getElementById("confirm_password");
                if (password.value != confirm_password.value) {
                    confirm_password.setCustomValidity("Passwords Don't Match");
                } else {
                    confirm_password.setCustomValidity('');
                    $('#confirm_password').removeAttr('required');
                }
            }

            $('.back').live('click', function () {
                $('.receipt_main').show();
                $('.profiles').hide();
            });

            $('#profiles').submit(function (e) {
                e.preventDefault();
                $('#chkOut').attr('disabled','disabled');
                $('.overlay_loader').show();
                if ($('.CC').is(':visible')) {
                    Stripe.card.createToken($('#profiles'), stripeResponseHandler);


                }
                else 
                {

                    var token = $('#profiles input[name=_token]').val();
                    var datas = $('#profiles input, select, textarea').serialize();
                    var order_data = $('.receipt_main input').serialize();
                    //alert(order_data);
                    $.ajax({
                        type: 'post',
                        url: '<?php echo url(); ?>/user/ajax_register',
                        data: datas + '&' + order_data + '&_token=' + token,
                        success: function (msg) {
                            msg = msg.trim();
                            $('.overlay_loader').hide();
                            $('#chkOut').removeAttr('disabled');
                            if (msg == '1') {
                                $('#ordered_email').focus();
                                $('.email_error').show();
                                $('.email_error').html('Email Already Registered.');
                                //$('.email_error').fadeOut(2000);
                            } else if (msg == '6') {
                                window.location = "{{url('orders/list/user?flash=1')}}";
                                $('.top-cart-content ').html("<span class='thankyou'>Thank you! Your order has been received</span>");
                            } else if (msg == '786') {
                                window.location = "{{url('orders/list/user?flash=2')}}";
                                $('.top-cart-content ').html("<span class='thankyou'>Thank you! Your order has been received and your account has been created</span>");
                            } else {
                                alert(msg);
                            }
                        }
                    })
                }

            });

            $('.modal').on('shown.bs.modal', function () {
                $('input:text:visible:first', this).focus();
            });
            $('.clearall , .close').click(function () {
                var menu = $(this).attr('id');
                if (menu) {
                    menu = menu.replace('clear_', '');
//alert(menu);
                    $('.subitems_' + menu).find('input:checkbox, input:radio').each(function () {
                        if (!$(this).hasClass('chk'))
                            $(this).removeAttr("checked");
                        $('.allspan').html('0');
                    });
                    $('.inp').val("");
                }
                $('.fancybox-close').click();
            });
            $('.resetslider').live('click', function () {
                var menu = $(this).attr('id');
                menu = menu.replace('clear_', '');
                $('.number' + menu).html('1');
//alert(menu);
                $('.subitems_' + menu).find('input:checkbox, input:radio').each(function () {
                    if (!$(this).hasClass('chk'))
                        $(this).removeAttr("checked");
                    $('.allspan').html('0');
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
                var n_counter = 0;
                $('.subitems_' + menu_id).find('input:checkbox, input:radio').each(function (index) {
                    if ($(this).hasClass('checked') || ($(this).is(':checked') && $(this).attr('title') != "")) {
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
                                    var qty = Number($(this).parent().parent().find('.span_' + mid).text().trim());
                                    if (qty != "") {
                                        cnn += Number(qty);
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
                                        if (td_temp >= td_index) {
                                            td_temp = td_index;
                                        } else {
                                            td_temp = td_temp;
                                        }
                                        $('.error_' + catid).html("Options are required");
                                    } else if (multiples == 0 && cnn > extra_no) {
                                        err++;
                                        td_index = $('#td_' + catid).index();
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
                                        if (td_temp >= td_index) {
                                            td_temp = td_index;
                                        } else {
                                            td_temp = td_temp;
                                        }
                                        $('.error_' + catid).html("Options are required");
                                    } else if (multiples == 0 && cnn != extra_no) {
                                        err++;
                                        td_index = $('#td_' + catid).index();
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
                        app_title = app_title + "," + title[1];
                        price = Number(price) + Number(title[2]);
                    }
                });
                if (err > 0) {
                    return false;
                } else {
                    var banner = $(this).parent().parent().parent().find('.bannerz');
                    $(this).parent().parent().find('.nxt_button').attr('title', '1');
                    $(this).parent().parent().find('.prv_button').hide();
                    banner.animate({scrollLeft: 0}, 10);
                    $(this).parent().parent().find('.nxt_button').show();
                    catarray.forEach(function (catid) {
                        $('#error_' + catid).html("");
                    });
                }
                ids = ids.replace("__", "_");
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

                var pre_cnt = $('#list' + ids).find('.count').text();
                pre_cnt = parseInt(Number(pre_cnt.replace('x', '')));
                var n = parseInt($('.number' + menu_id).text());
                if (pre_cnt != "") {
                    pre_cnt = Number(pre_cnt) + Number(n);
                } else {
                    pre_cnt = Number(n);
                }
                /*
                 var img = $('.popimage_' + menu_id).attr('src');
                 img = img.replace('thumb', 'thumb2');
                 */
                $('#list' + ids).remove();
                $('.orders').prepend('<tr id="list' + ids + '" class="infolist" ></tr>');
                $('#list' + ids).html('<td class="receipt_image" style="width:40px;">' +


                        '<a id="inc' + ids + '" class="clearfix increase btn btn-sm  btn-secondary-outline  " href="javascript:void(0);"><i class="fa fa-plus"></i></a>' +

                        '<div class="clearfix "><span class="count" style="padding-left:15px;">' + pre_cnt + '</span><input type="hidden" class="count" name="qtys[]" value="' + pre_cnt + '" </div>' +

                        '<br><a id="dec' + ids + '" class="clearfix decrease  btn btn-sm btn-secondary-outline" href="javascript:void(0);"><i class="fa fa-minus"></i></a>' +

                        '<input class="amount" type="hidden" value="' + price.toFixed(2) + '"/>' +
                        '</td>' +
                        '<td class="innerst" width="60%">' + app_title + '</td>' +
                        '<td class="total"><div class="pull-right">$' + (pre_cnt * price).toFixed(2) + '</div></td>' +
                        '<input type="hidden" class="menu_ids" name="menu_ids[]" value="' + menu_id + '" />' +
                        '<input type="hidden" name="extras[]" value="' + dbtitle + '"/><input type="hidden" name="listid[]" value="' + ids + '" />' +
                        '<input type="hidden" class="prs" name="prs[]" value="' + (pre_cnt * price).toFixed(2) + '" />' +
                        '<a href="javascript:void(0);" class="del-goods" onclick=""></a>');

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
                subtotal = subtotal.toFixed(2);
                $('div.subtotal').text('$' + subtotal);
                $('input.subtotal').val(subtotal);
                subtotal = parseFloat(subtotal);
                var tax = 13;
                tax = parseFloat(tax);
                tax = (tax / 100) * subtotal;
                tax = tax.toFixed(2);
                $('span.tax').text('$' + tax);
                $('input.tax').val(tax);
                if ($('#delivery_flag').val() == '1') {
                    var del_fee = $('.df').val();
                } else {
                    var del_fee = 0;
                }
                del_fee = parseFloat(del_fee);
                var gtotal = Number(subtotal) + Number(tax) + Number(del_fee);
                gtotal = gtotal.toFixed(2);
                $('div.grandtotal').text('$' + gtotal);
                $('input.grandtotal').val(gtotal);
                $('#cart-total').text(gtotal);
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
                            $('.extra-' + catid).each(function () {
                                if ($(this).is(":checked")) {
                                    var mid = $(this).attr('id').replace('extra_', '');
                                    var qty = Number($(this).parent().parent().find('.span_' + mid).text().trim());
                                    var tit1 = $(this).attr('title');
                                    tit1 = tit1.split('_');
                                    tit1[0] = tit1[0].replace('-' + qty, '');
                                    tit1[1] = tit1[1].replace(" x(" + qty + ")", "");
                                    nwtit = tit1[0] + "_" + tit1[1] + "_" + tit1[2];
                                    $(this).attr('title', nwtit);

                                }
                            });
                        }
                    }
                });
                $('.number' + menu_id).text('1');
                $('.subitems_' + menu_id).find('input:checkbox, input:radio').each(function () {
                    if (!$(this).hasClass('chk')) {
                        $(this).removeAttr("checked");
                    }
                    if ($(this).hasClass('checked')) {
                        $(this).removeClass("checked");
                    }
                });
                var dispr = Number($('.displayprice' + menu_id).val());
                $('.modalprice' + menu_id).html('$' + dispr.toFixed(2));

                $('.allspan').html('0');
                $('.close' + menu_id).click();

                show_header();
                total_items = "(" + (parseInt(Number(total_items)) + parseInt(Number(n))) + ")";

                updatecart();
            });
            function inArray(needle, haystack) {
                var length = haystack.length;
                for (var i = 0; i < length; i++) {
                    if (haystack[i] == needle) {
                        return true;
                    }
                }
                return false;
            }

            $(document).on('click', '.loadmore', function () {
                var catid = $(this).attr('title');
                $('.overlay_loader').show();
                ur = $('.next_' + catid + ' a').attr('href');
                if (ur != '') {
                    url1 = ur.replace('/?', '?');
                    $.ajax({
                        url: url1,
                        success: function (html) {
                            $('#LoadMoreBtnContainer' + catid).remove();
                            if (html) {
                                $('.nxtpage_' + catid).remove();
                                $("#loadmenus_" + catid).append(html);
                                $('.overlay_loader').hide();
                            } else {
                                $('div#loadmoreajaxloader_' + catid).html('<center>No more menus to show.</center>');
                            }
                        }
                    });
                } else {
                    $('div#loadmoreajaxloader_' + catid).html('<center>No more menus to show.</center>');
                    $(this).parent().remove();
                }
            });
            $(".sorting_parent").live('click', function () {
                var path = window.location.pathname + '?sorted';
                //alert(path);
                $('.overlay_loader').show();
                var pid = $(this).attr('id').replace('up_parent_', '').replace('down_parent_', '');
                var arr_pid = pid.split('_');
                pid = arr_pid[0];
                var cid = arr_pid[1];
                if ($(this).attr('id') == 'up_parent_' + pid + '_' + cid) {
                    var sort = 'up';
                } else {
                    var sort = 'down';
                }
                var order = '';// array to hold the id of all the child li of the selected parent
                $('#loadmenus_' + cid + ' .parents').each(function (index) {
                    var val = $(this).attr('id').replace('parent', '');
                    if (order == '') {
                        order = val;
                    } else {
                        order = order + ',' + val;
                    }
                });
                $.ajax({
                    url: '<?php echo url('restaurant/orderCat/'); ?>/' + pid + '/' + sort,
                    data: 'ids=' + order + '&_token=<?php echo csrf_token(); ?>',
                    type: 'post',
                    success: function () {
                        window.location = path;
                    }
                });
            });
        });
        updatecart();
    </script>
    <script type="text/javascript">
        //Google Api Codes.
        $('body').on('change', '#formatted_address', function () {
            if ($(this).val()) {
                window.location = "{{ url('restaurants') }}/" + $(this).val();
            }
        });

    </script>
@stop