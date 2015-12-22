@extends('layouts.default')
@section('content')
<link rel="stylesheet" href="{{ asset('assets/global/css/popstyle.css') }}">

<div class="margin-bottom-40 clearfix">
    <div class="col-md-9 col-md-offset-3 col-sm-9 col-xs-12 menu_div">
        <?php printfile("views/restaurants-menus.blade.php"); ?>

        @if(Session::has('session_restaurant_id') && Session::get('session_restaurant_id') == $restaurant->id)
            <div class="category_btns margin-bottom-15">
                <a href="#menumanager2" class="btn red fancybox-fast-view additem" id="add_item0">Add Menu Item</a>
                <input type="hidden" id="res_id" value="{{ $restaurant->id }}" />
            </div>
            <div id="menumanager2" style="display: none;width:800px;"></div>
        @endif
        
        @foreach($category as $cat)
            <div class="box-shadow clearfix">
                <div class="portlet-title">
                    <div class="caption">
                        {{ $cat->title }}
                    </div>
                </div>
                <div class="portlet-body no-padding">
                    <div id="postswrapper_{{ $cat->id }}" class="loadcontent"></div>
                    <div class="clearfix"></div>
                    <div id="loadmoreajaxloader_{{ $cat->id }}" style="display:none;">
                        <img src="{{ asset('assets/images/ajax-loader.gif') }}"/>
                    </div>
                    <div class="clearfix"></div>
                    <br style="clear: both;">
                </div>
            </div>

            <script>
                $(function() {
                    $("#postswrapper_{{ $cat->id }}").load("{{ url('/restaurants/loadmenus/' . $cat->id . '/' . $restaurant->id) }}");
                });
            </script>
        @endforeach
    </div>


    <!-- BEGIN CART -->
    <div class="top-cart-block col-md-3 col-sm-3" id="printableArea">
        <div class="overlay overlay_reservation">
            <div class="clearfix"></div>
            <div id="loadmoreajaxloader">
                <img src="{{ asset('assets/images/ajax-loading.gif') }}">
            </div>
        </div>

        @include('common.receipt')

    </div>
</div>
<!-- END SIDEBAR & CONTENT -->


<script type="text/javascript">
    function check_val(v) {
        if (v != '') {
            $('.confirm_password').show();
            $('#confirm_password').attr('required', 'required');
        } else {
            $('#confirm_password').removeAttr('required');
        }
    }
    $(document).ready(function() {
        $('body').on('click', '.insert-stats', function() {
            var id = $(this).attr('data-id');
            $.get("{{ url('restaurants/menu/stats') }}/" + id, {}, function(result) {
                $('#product-pop-up_' + id + " #stats_block").show();
                $('#product-pop-up_' + id + " #stats_block #view_stats").text(result);
            });
        });

        function validatePassword() {
            var password = document.getElementById("password1"), confirm_password = document.getElementById("confirm_password");
            if (password.value != confirm_password.value) {
                confirm_password.setCustomValidity("Passwords Don't Match");
            } else {
                confirm_password.setCustomValidity('');
                $('#confirm_password').removeAttr('required');
            }

            password.onchange = validatePassword;
            confirm_password.onkeyup = validatePassword;
        }
        
        $('.back').live('click', function() {
            $('.receipt_main').show();
            $('.profiles').hide();
        });
        $('#profiles').submit(function(e) {
            e.preventDefault();
            $('.overlay_reservation').show();
            var token = $('#profiles input[name=_token]').val();
            var datas = $('#profiles input, select, textarea').serialize();
            var order_data = $('.receipt_main input').serialize();
            $.ajax({
                type: 'post',
                url: '<?php echo url(); ?>/user/ajax_register',
                data: datas + '&' + order_data + '&_token='+token,
                success: function(msg) {
                    $('.overlay_reservation').hide();
                    if (msg == '1') {
                        alert('Email Already Registred.');
                    } else if (msg == '6') {
                        $('.top-cart-content ').html("<span class='thankyou'>Thank you! your order has been received.</span>");
                    } else if (msg == '786') {
                        $('.top-cart-content ').html("<span class='thankyou'>Thank you! your order has been received and your account has been created successfully and you'll receive an activation email in shortly. Check your email to validate your account and login.</span>");
                    } else {
                        alert(msg);
                    }
                }
            })
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
            img = img.replace('thumb', 'thumb2');
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

            if ($('#delivery_flag').val() == '1'){
                var del_fee = $('.df').val();
            } else {
                var del_fee = 0;
            }
            del_fee = parseFloat(del_fee);
            //alert(del_fee);

            var gtotal = Number(subtotal) + Number(tax) + Number(del_fee);
            gtotal = gtotal.toFixed(2);

            $('div.grandtotal').text(gtotal);
            $('input.grandtotal').val(gtotal);
            $('#cart-total').text(gtotal);
            $('.subitems_' + menu_id).find('input:checkbox, input:radio').each(function() {
                if (!$(this).hasClass('chk')) {
                    $(this).removeAttr("checked");
                }
            });

            $('.number' + menu_id).text('1');
            //$('#clear_' + menu_id).click();
            $('.fancybox-close').click();
            //$('.subitems_'+menu_id).hide();
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
        
        $(document).on('click', '.loadmore', function(){
            var catid = $(this).attr('title');
            $('div#loadmoreajaxloader_' + catid).show();
            ur = $('.next_' + catid + ' a').attr('href');
            if (ur != '') {
                url1 = ur.replace('/?', '?');
                $.ajax({
                    url: url1,
                    success: function(html) {
                        $('#LoadMoreBtnContainer'+catid).remove();
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

        $(".sorting_parent").live('click', function() {
            $('.overlay_loader').show();
            //alert('test');
            var pid = $(this).attr('id').replace('up_parent_', '').replace('down_parent_', '');
            var arr_pid = pid.split('_');
            pid = arr_pid[0];
            var cid = arr_pid[1];
            if ($(this).attr('id') == 'up_parent_' + pid) {
                var sort = 'up';
            } else {
                var sort = 'down';
            }
            var order = '';// array to hold the id of all the child li of the selected parent
            $('#loadmenus_' + cid + ' .parents').each(function(index) {
                var val = $(this).attr('id').replace('parent', '');
                //var val=item[1];
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
                success: function() {
                    location.reload();
                }
            });

        });
        //$( "#sortable" ).disableSelection();
    });
</script>
<script type="text/javascript">
    //Google Api Codes.
    $('body').on('change', '#formatted_address', function(){
        if($(this).val()){
            window.location = "{{ url('restaurants') }}/"+$(this).val();
        }
    });
    
    //Google Api Codes.
    var formatted_address, formatted_address_checkout;
    function initAutocompleteCheckOut(){
      formatted_address = new google.maps.places.Autocomplete(
          (document.getElementById('formatted_address')), 
          {types: ['geocode']}
      );
      formatted_address_checkout = new google.maps.places.Autocomplete(
          (document.getElementById('formatted_address_checkout')), 
          {types: ['geocode']}
      );
      formatted_address_checkout.addListener('place_changed', fillInAddress2);
    }
    
    function fillInAddress2() {
      var place = formatted_address_checkout.getPlace();
      var lat = place.geometry.location.lat();
      var lng = place.geometry.location.lng();
      $('#latitude').val(lat);
      $('#longitude').val(lng);
      var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'long_name',
        country: 'long_name',
        postal_code: 'short_name'
      };
      $('#ordered_city').val('');
      $('#ordered_street').val('');
      $('#ordered_code').val('');
      //provinces('{{ addslashes(url("ajax")) }}', '');
      $("#ordered_province option").attr("selected", false);
      
      for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];
        if (componentForm[addressType]) {
          var val = place.address_components[i][componentForm[addressType]];
          if(addressType == "country"){
            $("#country  option").filter(function() {
                return this.text == val; 
            }).attr('selected', true);
          }
          if(addressType == "administrative_area_level_1"){
            $("#ordered_province option").filter(function() {
                return this.text == val; 
            }).attr('selected', true);
          }
          if(addressType == "locality"){
            $('#ordered_city').val(val);
          }
          if(addressType == "postal_code"){
            $('#ordered_code').val(val);
          }
          if(addressType == "street_number"){
            $('#ordered_street').val(val);
          }
          if(addressType == "route"){
              if($('#ordered_street').val() != ""){
                $('#ordered_street').val($('#ordered_street').val()+", "+val);
              } else {
                  $('#ordered_street').val(val);
              }
          }
        }
      }
    }
    
    function geolocate() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
          var geolocation = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
          };
          var circle = new google.maps.Circle({
            center: geolocation,
            radius: position.coords.accuracy
          });
          formatted_address.setBounds(circle.getBounds());
          formatted_address_checkout.setBounds(circle.getBounds());
        });
      }
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?signed_in=true&libraries=places&callback=initAutocompleteCheckOut" async defer></script>
@stop