@extends('layouts.default')
@section('content')
    <script src="{{ asset('assets/global/scripts/form-validation.js') }}"></script>

    @include("popups.rating")

        @if(!isset($order) )
            @if(Session::has('session_restaurant_id') && Session::get('session_restaurant_id') == $restaurant->id)

                <div class="card card-inverse card-danger " style="border-radius:0 !important;">
                    <div class="card-block ">
                        <div class="container" style="margin-top: 0 !important;">

                        <h4 class="card-title text-xs-center m-b-0">Edit Mode</h4>

                        <p class="card-title text-xs-center m-b-0">You may place test orders for your restaurant</p>

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

            @endif
        @endif

        <div class="container" style="">
            <div class="row">

                <?= printfile("views/restaurants-menus.blade.php"); ?>

                <div class="col-md-8 col-xs-12 " style="">

                    <div class="col-md-3 col-xs-3 p-l-0">
                        <img style="max-width:100%;" class="pull-left img-rounded"
                             @if(isset($restaurant->logo) && !empty($restaurant->logo))
                                src="{{ asset('assets/images/restaurants/'.$restaurant->id.'/'.$restaurant->logo) }}"
                             @else
                                src="{{ asset('assets/images/default.png') }}"
                             @endif
                             alt="">

                        <div class="clearfix"></div>
                    </div>


                        <div class="col-md-9 p-a-0" style="">

                            <div class="">
                                <h1 class="card-title">
                                    {!! (isset($restaurant->name))?$restaurant->name:'' !!}
                                </h1>

                                <div id="restaurant_rating">
                                    {!! rating_initialize((session('session_id'))?"static-rating":"static-rating", "restaurant", $restaurant->id, false, 'update-rating', true, false, '') !!}
                                    <div class="clearfix"></div>
                                </div>

                    <span class="card-text m-b-0 p-r-2">
                    <strong>Address</strong> {!! (isset($restaurant->address))?$restaurant->address.',':'' !!}
                        {!! (isset($restaurant->city))?$restaurant->city.', ':'' !!}
                        {!! (isset($restaurant->province))? 'ON':'' !!}
                        {!! (isset($restaurant->postal_code))?$restaurant->postal_code.' ':'' !!}
                    </span>


                    <span class="card-text">



                        <?php
                        $Today = \App\Http\Models\Restaurants::getbusinessday($restaurant);
                        echo "<span class='p-r-2'><strong>Hours</strong> " . converttime(getfield($restaurant, $Today . "_open")) . " - " . converttime(getfield($restaurant, $Today . "_close")) . "</span>";
                        ?>
                        <span class="m-b-0">
                        <strong>Phone</strong> {!! (isset($restaurant->phone))?$restaurant->phone:'' !!}
                    </span>


                        <?


                        echo "<span class='p-r-2'><strong>Delivery</strong> " . converttime(getfield($restaurant, $Today . "_open_del")) . " - " . converttime(getfield($restaurant, $Today . "_close_del")) . "</span>";
                        ?>

                        <span class="p-r-2"><strong>Delivery
                                Fee</strong> {{ asmoney($restaurant->delivery_fee,$free=true) }}</span>
                        <span class="p-r-2"><strong>Minimum</strong> {{ asmoney($restaurant->minimum,$free=false) }}</span>
                            <input type="hidden" id="minimum_delivery" value="{{$restaurant->minimum}}"/>
                        @if (Session::get('session_type_user') == "super" )
                            <span class="p-r-2">
                            <strong class="">Views</strong> {!! (isset($total_restaurant_views))?$total_restaurant_views:0 !!}
                                    </span>
                        @endif
                        <span class="p-r-2">
                        <a class="" style="" class="" href="#" data-toggle="modal" data-target="#viewMapModel">More
                            Detail</a>
</span>

                    </span>

                                <div class="clearfix"></div>


                            </div>
                        </div>



                        <div class="col-md-12 p-a-0 m-t-1">

                            <div class="overlay overlay_reservation">
                                <div class="loadmoreajaxloader">
                                    <img src="{{ asset('assets/images/ajax-loading.gif') }}">
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
                                        <img src="{{ asset('assets/images/ajax-loader.gif') }}"/>
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
                                                        $("#postswrapper_{{ $cat->id }}").html('<div class="alert alert-danger" role="alert">N3o menu items yet<div class="clearfix"></div></div>');
                                                    }
                                                },
                                                error: function (res) {

                                                    if (res != 'no') {
                                                        $("#postswrapper_{{ $cat->id }}").html(res);
                                                    }
                                                    else {
                                                        $("#postswrapper_{{ $cat->id }}").html('<div class="alert alert-danger" role="alert">N4o menu items yet<div class="clearfix"></div></div>');
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
                    @include('common.receipt')
                </div>

            </div>
        </div>
    </div>



    @if(Session::has('session_restaurant_id') && Session::get('session_restaurant_id') == $restaurant->id)

        <div class="modal  fade clearfix" id="addMenuModel" tabindex="-1" role="dialog"
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
        function check_val(v) {
            if (v != '') {
//$('.confirm_password').show();
//$('#confirm_password').attr('required', 'required');
            } else {
//$('#confirm_password').removeAttr('required');
            }
        }
        $(document).ready(function () {

            function validatePassword() {
                var password = document.getElementById("password"), confirm_password = document.getElementById("confirm_password");
                if (password.value != confirm_password.value) {
                    confirm_password.setCustomValidity("Passwords Don't Match");
                } else {
                    confirm_password.setCustomValidity('');
                    $('#confirm_password').removeAttr('required');
                }

//password.onchange = validatePassword;
//confirm_password.onkeyup = validatePassword;
            }

            $('.back').live('click', function () {
                $('.receipt_main').show();
                $('.profiles').hide();
            });
            $('#profiles').submit(function (e) {

                e.preventDefault();
                $('.overlay_loader').show();
                var token = $('#profiles input[name=_token]').val();
                var datas = $('#profiles input, select, textarea').serialize();
                var order_data = $('.receipt_main input').serialize();
                $.ajax({
                    type: 'post',
                    url: '<?php echo url(); ?>/user/ajax_register',
                    data: datas + '&' + order_data + '&_token=' + token,
                    success: function (msg) {
                        msg = msg.trim();
                        $('.overlay_loader').hide();
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
                pre_cnt = Number(pre_cnt.replace('x', ''));
                var n = $('.number' + menu_id).text();
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
                $('#list' + ids).html('<td class="receipt_image" style="width:60px;">' +
                        '<a id="dec' + ids + '" class="decrease  btn btn-xs btn-secondary-outline" href="javascript:void(0);">' +
                        '<i class="fa fa-minus"></i></a>&nbsp;<span class="count">' + pre_cnt + '</span>&nbsp;<input type="hidden" class="count" name="qtys[]" value="' + pre_cnt + '" />' + '<a id="inc' + ids + '" class="increase btn btn-xs btn-secondary-outline  " href="javascript:void(0);">' +
                        '<i class="fa fa-plus"></i></a>' +
                        '<span class="amount" style="display:none;">' + price.toFixed(2) + '</span></td>' +
                        '<td class="innerst" width="50%">' + app_title + '</td>' +
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
                });
                $('.allspan').html('0');
                $('.close' + menu_id).click();

                show_header();

                total_items = Number(total_items) + Number(n);
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
                $('div#loadmoreajaxloader_' + catid).show();
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
                                $('div#loadmoreajaxloader_' + catid).hide();
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
                alert(path);
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