@extends('layouts.default')
@section('content')
    <script src="{{ asset('assets/global/scripts/provinces.js') }}"></script>
    <script src="{{ asset('assets/global/scripts/form-validation.js') }}"></script>
    @include("popups.rating")

    <?php
        $orderID = 0;
        if(ReceiptVersion){
            $orderID = \App\Http\Models\Orders::newid();
            if(isset($_GET["orderid"])){
                $order = select_field("orders", "id", $orderID);
                $items = enum_all("orderitems", "order_id=" . $orderID);
            }
        }
        $checkout_modal = false;
        $menu_id = iif($restaurant->franchise > 0, $restaurant->franchise, $restaurant->id);

        if (read("restaurant_id") && read("restaurant_id") != $restaurant->id) {
            popup(false, "You can not place orders as a restaurant owner", "Oops");
        }
        if($menu_id != $restaurant->id){
            popup(false, "Only the parent store can be edited", "Oops");
        }

        $is_my_restro = false;
        if (Session::has('session_restaurant_id') && Session::get('session_restaurant_id') == $restaurant->id) {
            $is_my_restro = true;
        }

        $business_day = \App\Http\Models\Restaurants::getbusinessday($restaurant);

        $alts = array(
            "add_item" => "Add Item"
        );

        $allowedtoupload = $is_my_restro;
        if (read("profiletype") == 1 || read("profiletype") == 3) {$allowedtoupload = true;}

        if(!$restaurant->latitude || !$restaurant->longitude){
            $restaurant->longitude = 0;
            $restaurant->latitude = 90;
        }
    ?>


    <div class="container" >
        <?php printfile("views/restaurants-menus.blade.php"); ?>
        <div class="row">

            <div class="col-lg-8 col-md-7 col-sm-12 ">

                @include("dashboard.restaurant.restaurantpanel", array("Restaurant" => $restaurant, "details" => true, "showtoday" => true))

                @if($allowedtoupload && $menu_id == $restaurant->id)
                        <a href="#" id="add_item0" type="button"
                           class="btn btn-success btn-lg additem  btn-block m-b-1"
                           data-toggle="modal"
                           title="{{ $alts["add_item"] }}"
                           data-target="#addMenuModel">
                            Upload Menu Item
                        </a>
                @endif

                <div class="overlay overlay_reservation">
                        <div class="loadmoreajaxloader"></div>
                    </div>
                    <div id="saveOrderChngBtn" style="display:none">
                        <input name="saveOrderChng" type="button" value="Save All Category Order Changes" onclick="saveCatOrderChngs()" /><span id="saveCatOrderMsg"></span>
                    </div>

                    <div class="clearfix"></div>
                    <div class=" menu_div">
                        @if(isset($restaurant))
                            <input type="hidden" id="res_id" value="{{ $restaurant->id }}"/>
                        @endif

                        <?php
                            $cats=[];
                            $catsOrder=[];
                            $catCnt=0;
                            foreach ($category as $cat) {
                                $cats[$catCnt]=$cat->id;
                                $catsOrder[$catCnt]=$cat->display_order;
                                $catCnt++;
                            }

                            if(read('restaurant_id') == $restaurant->id || read("profiletype") != 2) {//is yours, doesnt need to be active
                               $menus_list = App\Http\Models\Menus::where('restaurant_id', $menu_id)->where('parent', '0')->whereIn('cat_id', $cats)->orderBy('cat_id', 'ASC')->orderBy('display_order', 'ASC')->get();
                            } else{//is not yours, needs to be active
                               $menus_list = App\Http\Models\Menus::where('restaurant_id', $menu_id)->where('parent', '0')->whereIn('cat_id', $cats)->where('is_active', 1)->orderBy('display_order', 'ASC')->get();
                            }

                        ?>

                        @if(count($menus_list))
                            @include('menus',$menus_list)
                        @endif

                        @if($allowedtoupload && $menu_id == $restaurant->id)
                                <a href="#" id="add_item0" type="button"
                                   class="btn btn-success btn-lg additem  btn-block m-b-1"
                                   data-toggle="modal"
                                   title="{{ $alts["add_item"] }}"
                                   data-target="#addMenuModel">
                                    Upload Menu Item
                                </a>
                        @endif
                    </div>


                <div class="col-lg-4 col-md-5 col-sm-12" id="printableArea">
                    @include('common.receipt', array("is_my_restro" => $is_my_restro, "is_open"=>$business_day, "checkout_modal" => $checkout_modal, "ordering" => true))
                </div>

                <div class="modal clearfix" id="addMenuModel" tabindex="-1" role="dialog" aria-labelledby="addMenuModelLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="addMenuModelLabel">Add Menu Item</h4>
                            </div>
                            <div class="modal-body" id="menumanager2"></div>
                            <div class="modal-footer">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal clearfix" id="editCatModel" tabindex="-1" role="dialog" aria-labelledby="editCatModelLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="editCatModelLabel">Edit Category</h4>
                            </div>
                            <div class="modal-body" id="categoryeditor"></div>
                            <div class="modal-footer">
                                <a id="saveeditor" class="btn btn-primary savebtn" debug="uses savebtn in additional.js" onclick="savecat();">Save</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
          </div>
      </div>
    </div>
</div>
</div>



    @include('popups.more_detail')



    <script type="text/javascript">
        var checkout_modal = "{{ $checkout_modal }}";
        var order_id = "{{ $orderID }}";
        console.log("Order ID " + order_id);

        function addresschange(where) {
            //code for adding addresses to the drop down is in views/common/receipt.blade.php
            if ($("#delivery1").is(":checked")) {
                var found = false;
                var element = false;
                var address = "your address";
                if ($("#delivery1").is(":checked")) {
                    if ($("#reservation_address").length) {
                        var value = $("#reservation_address").val();
                        address = "Address ID: " + value;
                        var element = $("#reservation_address option").filter(":selected");
                        if (element) {
                            var address_latitude = element.attr("latitude");
                            var address_longitude = element.attr("longitude");
                            found = !isundefined(element.attr("latitude"));
                            address = element.text();
                        }
                    } else {
                        address = $("#formatted_address").val();
                        var address_latitude = Number( $("#latitude").val());
                        var address_longitude = Number($("#longitude").val());
                        found = address && address_latitude && address_longitude;
                    }
                } else {
                    var address_latitude = $("#latitude").val();
                    var address_longitude = $("#longitude").val();
                    found = address_latitude && address_longitude && !$("#ordered_email-error").is(":visible");
                }

                if (found) {
                    var distance = calcdistance({{ $restaurant->latitude }}, {{ $restaurant->longitude }}, address_latitude, address_longitude);
                    if (distance > {{ $restaurant->max_delivery_distance }}) {
                        var message = unescapetext("{{ $restaurant->name }}") + " will only deliver within {{ $restaurant->max_delivery_distance }} km<BR>" + address + " is " + distance.toFixed(2) + " km away.";
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
                    if(element) {
                        element.trigger("click");
                    }
                    return true;
                } else if (where == "addresscheck") {
                    alert("No Address Specified");
                    return false;
                }
            }
            return true;
        }

        function check_val(v) {
        }


    <?php if(!islive()){
        echo "Stripe.setPublishableKey('pk_rlgl8pX7nDG2JA8O3jwrtqKpaDIVf'); //test";
    } else {
        echo "Stripe.setPublishableKey('pk_vnR0dLVmyF34VAqSegbpBvhfhaLNi'); //live";
    }?>

        var stripeResponseHandler = function (status, response) {
            //var $form = $('#payment-form');
            var $form = $('#profiles');
            if (response.error) {
                // Show the errors on the form
                $form.find('.payment-errors').text(response.error.message);
                $form.find('button').prop('disabled', false);
                overlay_loader_hide();
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
                        $('#chkOut').removeAttr('disabled');
                        var hide=true;
                        if (msg == '1') {
                            $('#ordered_email').focus();
                            $('.email_error').show();
                            $('.email_error').html('Email Already Registered.');
                        } else if (msg == '6') {
                            window.location = "{{url('orders/list/user?flash=1')}}";
                            hide=false;
                            $('.top-cart-content ').html("<span class='thankyou'>Thank you! Your order has been received</span>");
                        } else if (msg == '786') {
                            hide=false;
                            window.location = "{{url('orders/list/user?flash=2')}}";
                            $('.top-cart-content ').html("<span class='thankyou'>Thank you! Your order has been received and your account has been created</span>");
                        } else {
                            $('.payment-errors').html(msg);
                            console.log("stripeResponseHandler");
                            //alert( msg, "stripeResponseHandler" );
                        }
                        if(hide){overlay_loader_hide();}
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
                log(".back event");
                $('.receipt_main').show();
                $('.profiles').hide();
            });

            //submission of order
            $('#profiles').submit(function (e) {
                log("'#profiles submit event in restaurants-menus");
                if( $("#cardnumber-error").length ||  $("#cvc-error").length ){
                    if($("#cardnumber-error").length) {
                        if($("#cvc-error").length){
                            $("#cardnumber-error").text("These fields are required.");
                        }
                        var tempstr = $("#cardnumber-error")[0];
                    } else {
                        var tempstr = $("#cvc-error")[0];
                    }
                    $("#cardnumber-error").remove();
                    $("#cvc-error").remove();
                    $("#cardcvc").html( tempstr );
                }

                var errors = $("label.error[for!='cardnumber'][for!='cvc']").filter(":visible").length;
                if(errors) {
                    console.log("form validation detected " + errors + " errors");
                    return false;
                }

                e.preventDefault();
                $('#chkOut').attr('disabled','disabled');
                overlay_loader_show();
                if ($('.CC').is(':visible')) {
                    Stripe.card.createToken($('#profiles'), stripeResponseHandler);
                } else {
                    //why are there 2 huge identical blocks of code?
                    var token = $('#profiles input[name=_token]').val();
                    var datas = $('#profiles input, select, textarea').serialize();
                    var order_data = $('.receipt_main input').serialize();
                    $.ajax({
                        type: 'post',
                        url: '<?php echo url(); ?>/user/ajax_register',
                        data: datas + '&' + order_data + '&_token=' + token + '&order_id=' + order_id ,
                        success: function (msg) {
                            msg = msg.trim();
                            $('#chkOut').removeAttr('disabled');
                            var hide = true;
                            if (msg == '1') {
                                $('#ordered_email').focus();
                                $('.email_error').show();
                                $('.email_error').html('Email Already Registered.');
                            } else if (msg == '6') {
                                hide=false;
                                checkingout=true;
                                window.location = "{{url('orders/list/user?flash=1')}}";
                                $('.top-cart-content ').html("<span class='thankyou'>Thank you! Your order has been received</span>");
                            } else if (msg == '786') {
                                hide=false;
                                checkingout=true;
                                window.location = "{{url('orders/list/user?flash=2')}}";
                                $('.top-cart-content ').html("<span class='thankyou'>Thank you! Your order has been received and your account has been created</span>");
                            } else {
                                log("$('#profiles').submit in restaurants-menus.blade.php: " + msg);
                                msg = jQuery(msg).text().trim();
                                if(msg) {
                                    alert(jQuery(msg).text(), "$('#profiles').submit(function (e) {");
                                }
                            }
                            if(hide){overlay_loader_hide();}
                        }
                    })
                }

            });

            function ordererror(err, catid, td_index, td_temp, text){
                err++;
                td_index = $('#td_' + catid).index();
                if (td_temp >= td_index) {
                    td_temp = td_index;
                } else {
                    td_temp = td_temp;
                }
                $('.error_' + catid).html(text);
                return err;
            }

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
                log(".resetslider event");
                var menu = $(this).attr('id');
                menu = menu.replace('clear_', '');
                $('.number' + menu).html('1');
                $('#select' + menu).val('1');
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
                log(".add_menu_profile event");
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
                var csr = $("#csr" + menu_id).val();

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
                            if (extra_no == 0) {
                                extra_no = 1;
                            }
                            var multiples = $('#multiple_' + catid).val();
                            var upto = $('#upto_' + catid).val();
                            var ary_qty = "";
                            var ary_price = "";
                            $('.extra-' + catid).each(function () {
                                if ($(this).is(":checked")) {
                                    var mid = $(this).attr('id').replace('extra_', '');
                                    var qty = Number($(this).parents().find('.span_' + mid).text().trim());
                                   
                                    if (qty != "") {
                                        cnn += Number(qty);
                                    } else {
                                        cnn++;
                                    }
                                }
                            });

                            //cnn = how many are selected
                            //is_required: 1 if required, 0 if not
                            //extra_no: quantity limit
                            //upto: 0 if up to extra_no, 1 if exactly extra_no, 2 if unlimited
                            //multiples: 1 if can only select a single item, 0 if multiple items are allowed
                            //alert("is_required " + is_required + " upto " + upto + " multiples " + multiples + " cnn " + cnn + " extra_no " + extra_no);

                            $('.error_' + catid).html("");
                            if (is_required == '1') {//if items are required
                                if (cnn == 0) {//no items are selected
                                    err = ordererror(err, catid, td_index, td_temp, "Options are required");
                                } else if (multiples == 0 && cnn > extra_no && upto <2) {//multiple items are allowed, selected is above the limit, limit is not unlimited
                                    err = ordererror(err, catid, td_index, td_temp, "Select up to " + extra_no + " Options");
                                }
                            } else if (upto <2) {//if items are not required, and limit is not unlimited
                                if (multiples == 0 && cnn > 0 && cnn != extra_no) {//multiple items are allowed, selected is above the limit
                                    err = ordererror(err, catid, td_index, td_temp, "Select " + extra_no + " Options");
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
                    scrollto( $(".errormsg").filter(":visible").first() );
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

                additemtoreceipt(menu_id, ids, pre_cnt, price, csr, app_title, extratitle, dbtitle);

                showloader();
                $('.allspan').html('0');
                $('.close' + menu_id).click();

                show_header();
                total_items = "(" + (parseInt(Number(total_items)) + parseInt(Number(n))) + ")";

                updatecart("add_menu_profile click");
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
                overlay_loader_show();
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
                                overlay_loader_hide();
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

            <?php if(isset($_GET["menuitem"]) && $_GET["menuitem"]): ?>
                setTimeout(function(){
                    $("#add_item<?php echo e($_GET["menuitem"]); ?>").trigger("click");
                }, 500);
            <?php endif; ?>
            //updatecart();
        });
        //updatecart("restaurants-menus.blade.php");

        function changeitem(id){
            var CURRENT = $('#qty'+ id).val(), DESIRED = $('#itemsel'+ id).val(), QTY = 0, DIR = "";
            if(CURRENT > DESIRED){
                DIR = "dec" + id;
                QTY = CURRENT - DESIRED;
            } else if (CURRENT < DESIRED) {
                DIR = "inc" + id;
                QTY = DESIRED - CURRENT;
            }
            if(QTY){
                for(i=0; i<QTY; i++){
                    $("#" + DIR).trigger("click");
                }
            }
        }

        function makeselect(start, end, selected){
            var tempstr, tempstr2;
            for(i=start; i<=end; i++){
                tempstr = tempstr + '<OPTION VALUE="' + i + '"';
                if(selected == i){
                    tempstr = tempstr + ' SELECTED';
                }
                tempstr = tempstr + '>' + i + '</OPTION>';
            }
            return tempstr;
        }
    </script>
    <script type="text/javascript">
        //Google Api Codes.
        $('body').on('change', '#formatted_address', function () {
            if ($(this).val()) {
                window.location = "{{ url('restaurants') }}/" + $(this).val();
            }
        });

        function onheaderload(){
            setTimeout(function() {
                updatecart("onlogin rest");
            }, 1500);
        }
    </script>
@stop