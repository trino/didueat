@if(!isset($_GET['page']))
    <div id="loadmenus_{{ $catid }}">
@endif

<?php printfile("views/old-menus.blade.php"); ?>

    @foreach($menus_list as $value)
    <?php
    $item_image = asset('assets/images/default_menu.jpg');
    $item_image1 = asset('assets/images/default_menu.jpg');
    if ($value->image != '' && file_exists(public_path('assets/images/restaurants/' . $value->restaurant_id . '/menus/' . $value->id . '/thumb1_' . $value->image))) {
        $item_image1 = asset('assets/images/restaurants/' . $value->restaurant_id . '/menus/' . $value->id . '/thumb1_' . $value->image);
    }
    if ($value->image != '' && file_exists(public_path('assets/images/restaurants/' . $value->restaurant_id . '/menus/' . $value->id . '/thumb_' . $value->image))) {
        $item_image = asset('assets/images/restaurants/' . $value->restaurant_id . '/menus/' . $value->id . '/thumb_' . $value->image);
    }
    $submenus = \App\Http\Models\Menus::where('parent', $value->id)->get();
    ?>
    <div class="col-md-6 col-sm-6 col-xs-12 parents menus-parent" id="parent{{ $value->id }}">
        <div class="product-item">
            <a href="{{ (Request::is('restaurants/*')) ? '#product-pop-up_' . $value->id : url('restaurants/' . select_field('restaurants', 'id', $value->restaurant_id, 'slug') . '/menus') }}" data-id="{{ $value->id }}" data-res-id="{{ $value->restaurant_id }}" class="insert-stats {{ (Request::is('restaurants/*')) ? 'fancybox-fast-view' : '' }}">
                <div class="col-md-8 col-sm-7 col-xs-6 no-padding">
                    <h2 class="padding-top-5 menu-title">{{ $value->menu_item }}</h2>
                    <p class="menu-description">{{ $value->description }}</p>
                    @if(Session::has('is_logged_in'))
                    <div class="pull-left">
                        <a href="{{ url('restaurant/deleteMenu/' . $value->id . '/' . $restaurant->slug) }}" class="btn-sm red">Remove</a>
                        <a href="#menumanager2" id="add_item{{ $value->id }}" class="btn-small blue fancybox-fast-view additem">Edit</a>
                        <a id="up_parent_{{ $value->id.'_'.$catid }}" class="sorting_parent" href="javascript:void(0);"><i class="fa fa-angle-left"></i></a>
                        <a id="down_parent_{{ $value->id.'_'.$catid }}" class="sorting_parent" href="javascript:void(0);"><i class="fa fa-angle-right"></i></a>
                    </div>
                    @endif
                </div>
                <div class="col-md-2 col-sm-3 col-xs-3 menu-price">${{ $value->price }}</div>
                <div class="col-md-2 col-sm-2 col-xs-3 menu-image">
                    <img style="height:60px;" src="{{ $item_image1 }}" class="img-responsive" alt="{{ $value->menu_item }}" />
                </div>
            </a>
            {!! rating_initialize((session('session_id'))?"rating":"static-rating", "menu", $value->id) !!}
        </div>
    </div>


    <div id="product-pop-up_{{ $value->id }}" class="product-popup" style="display: none;">
        <div class="product-page product-pop-up">
            <div class="modal-body">
                <div class="col-sm-12 col-xs-12 title">
                    <h2>{{ $value->menu_item }}: $ {{ $value->price }}</h2>
                </div>
                <div class="col-sm-12 col-xs-12" id="stats_block" style="display: none;">
                    <strong>Menu Views:</strong>
                    <span id="view_stats"></span>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <img class="popimage_{{ $value->id }}" width="150" src="{{ $item_image }}" />
                </div>
                <div class="clearfix"></div>

                <div class="product-titles">
                    <h2>{{ $value->description }}</h2>
                    {!! rating_initialize("static-rating", "menu", $value->id) !!}
                </div>

                <div class="subitems_{{ $value->id }} optionals">
                    <div class="clearfix space10"></div>
                    <div style="display:none;">
                        <input type="checkbox" style="display: none;" checked="checked" title="{{ $value->id.'_'.$value->menu_item.'-_'.$value->price.'_' }}" value="" class="chk">
                    </div>
                    <div class="banner bannerz">
                        <table width="100%">
                            <tbody>    
                                @foreach ($submenus as $sub)
                                <tr class="zxcx">
                                    <td width="100%" id="td_{{ $sub->id }}" class="valign-top">
                                        <input type="hidden" value="{{ $sub->exact_upto_qty }}" id="extra_no_{{ $sub->id }}">
                                        <input type="hidden" value="{{ $sub->req_opt }}" id="required_{{ $sub->id }}">
                                        <input type="hidden" value="{{ $sub->sing_mul }}" id="multiple_{{ $sub->id }}">
                                        <input type="hidden" value="{{ $sub->exact_upto }}" id="upto_{{ $sub->id }}">

                                        <div style="" class="infolist col-xs-12">
                                            <div style="display: none;">
                                                <input type="checkbox" value="{{ $sub->menu_item }}" title="___" id="{{ $sub->id }}" style="display: none;" checked="checked" class="chk">
                                            </div>
                                            <a href="javascript:void(0);"><strong>{{ $sub->menu_item }}</strong></a>
                                            <span><em> </em></span>
                                            <span class="limit-options">
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
                                                }
                                                ?>
                                            </span>
                                            <div class="clearfix"></div>
                                            <span class="error_{{ $sub->id }} errormsg"></span>
                                            <div class="list clearfix">
                                                <?php $mini_menus = \App\Http\Models\Menus::where('parent', $sub->id)->get(); ?>
                                                @foreach($mini_menus as $mm)
                                                <div class="col-xs-6 col-md-6 subin btn default btnxx">
                                                    <div class="btnxx-inner">
                                                        <a id="buttons_{{ $mm->id }}" class="buttons" href="javascript:void(0);">
                                                            <button class="btn btn-primary"></button>
                                                            <input type="{{ ($sub->sing_mul == '1') ? 'radio' : 'checkbox' }}"
                                                                   id="extra_{{ $mm->id }}" title="{{ $mm->id.'_<br/> '.$mm->menu_item.'_'.$mm->price.'_'.$sub->menu_item }}"
                                                                   class="extra-{{ $sub->id }}" name="extra_{{ $sub->id }}" value="post" />
                                                            &nbsp;&nbsp; {{ $mm->menu_item }}
                                                            &nbsp;&nbsp; <?php if ($mm->price) echo "(+ $" . number_format(str_replace('$', '', $mm->price), 2) . ")"; ?>
                                                        </a>
                                                        <b style="display:none;">
                                                            <a id="remspan_{{ $mm->id }}" class="remspan" href="javascript:;"><b>&nbsp;&nbsp;-&nbsp;&nbsp;</b></a>
                                                            <span id="sprice_0" class="span_{{ $mm->id }} allspan">&nbsp;&nbsp;1&nbsp;&nbsp;</span>
                                                            <a id="addspan_{{ $mm->id }}" class="addspan" href="javascript:;"><b>&nbsp;&nbsp;+&nbsp;&nbsp;</b></a>
                                                        </b>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                                @endforeach
                                                <input type="hidden" value="" class="chars_{{ $sub->id }}">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="clearfix"></div>
                    <div class="col-xs-12 add-btn">
                        <div class="add-minus-btn">
                            <a class="btn btn-primary minus" href="javascript:void(0);" onclick="changeqty('{{ $value->id }}', 'minus')">-</a>
                            <div class="number{{ $value->id }}">1</div>
                            <a class="btn btn-primary add" href="javascript:void(0);" onclick="changeqty('{{ $value->id }}', 'plus')">+</a>
                        </div>
                        <a id="profilemenu{{ $value->id }}" class="btn btn-primary add_menu_profile add_end" href="javascript:void(0);">Add</a>
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
    @if(!isset($_GET['page']))
</div>
@endif

<div style="display: none;" class="nxtpage_{{ $catid }}">
    <li class="next_{{ $catid }}"><a href="{{ $menus_list->nextPageUrl() }}">Next &gt;&gt;</a></li>
</div>

{{--@if(!isset($_GET['page']))--}}
    @if( $menus_list->hasMorePages() === true)
        <div class="row" id="LoadMoreBtnContainer{{ $catid }}">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <button align="center" class="loadmore red btn btn-primary" title="{{ $catid }}">Load More</button>
                </div>
            </div>
        </div>
    @endif
{{--@endif--}}


<div class="clearfix"></div>

<script>
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

function clearCartItems() {
    $('.receipt_main ul.orders li').remove();
    $('.subtotal').val(0);
    $('.subtotal').text('0');
    $('.tax').val(0);
    $('.tax').text('0');
    $('.df').val(0);
    $('.df').text('0');
    $('#delivery_flag').val(0);
    $('.grandtotal').val(0);
    $('.grandtotal').text('0');
}

function checkout() {
    var del = $('#delivery_flag').val();

    if ($('.subtotal').text() == '0' || $('#subtotal1').val() == '0') {
        alert('Please select an item.');
    }
    else {
        $('.receipt_main').hide();
        $('.profiles').show();
    }
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


$('.decrease').live('click', function(){
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

function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}
</script>