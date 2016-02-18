<?php
    printfile("views/common/receipt.blade.php");
    $ordertype = "Pickup";
    if (isset($order)) {
        if ($order->order_type) {
            $ordertype = "Delivery";
        }
    }
    if (!isset($profile)) {
        $profile = false;
    }
    if (!isset($type)) {
        $type = false;
    }
    if(!isset($checkout_modal)){
        $checkout_modal = true;
    }
?>

@if(false && !isset($order))
    <div class="top-cart-info">
        <a href="javascript:void(0);" class="top-cart-info-count" id="cart-items">0 items</a>
        <a href="javascript:void(0);" class="top-cart-info-value" id="cart-total">$0.00</a>
        <a href="javascript:void(0);" onclick="$('#cartsz').modal();$('#cartsz').addClass('modal');$('#cartsz').attr('style',$('#cartsz').attr('style')+'padding-left:15px;'); ">
            <i class="fa fa-shopping-cart"></i>Cart
        </a>
    </div>
@endif


<div class="clearfix" id="cartsz">

    <div class="card" style="">

        <div class="card-header">
            <h4 class="card-title">Receipt</h4>
        </div>


        <div class="card-block">

            <div class="receipt_main">

                @include('common.items')

                <div class="totals form-group  " style="width:100%;">
                    <table class="" style="width:100%;">
                        <tbody>
                        @if(!isset($order))
                            <tr>
                                <td colspan="2">
                                    <label class="radio-inline c-input c-radio">
                                        <input type="radio"
                                               id="delivery1"
                                               name="delevery_type"
                                               onclick="delivery('show');$('#pickup1').removeClass('deliverychecked');"
                                                >
                                        <span class="c-indicator"></span>
                                        <strong>Delivery</strong>

                                    </label>

                                    <label class="radio-inline c-input c-radio">
                                        <input type="radio" id="pickup1" name="delevery_type"
                                               class="deliverychecked"
                                               onclick="delivery('hide'); $(this).addClass('deliverychecked');">
                                        <span class="c-indicator"></span>
                                        <strong>Pickup</strong>
                                    </label>
                                </td>

                            </tr>
                        @endif


                        <tr>
                            <td width="50%"><strong>Subtotal</strong></td>
                            <td width="50%">
                                <div class="pull-right subtotal inlineblock">
                                    ${{ (isset($order)) ? number_format($order->subtotal,2) : '0.00' }}
                                </div>
                                <input type="hidden" name="subtotal" class="subtotal" id="subtotal1"
                                       value="{{ (isset($order)) ? number_format($order->subtotal,2) : '0.00' }}"/>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Tax (<span id="tax inlineblock">13</span>%)</strong></td>
                            <td>
                                <div class="pull-right ">
                                    <span class="tax inlineblock">${{ (isset($order)) ? number_format($order->tax,2) : '0.00' }}</span>
                                    <input type="hidden"
                                           value="{{ (isset($order)) ? number_format($order->tax,2) : '0.00' }}"
                                           name="tax"
                                           class="maintax tax"/></div>
                            </td>
                        </tr>
                        <tr <?php if (isset($order) && $order->order_type == '1') echo ''; else echo "style='display:none'"; ?> id="df">
                            <td><strong>Delivery Fee</strong></td>
                            <td>
                                <div class="pull-right ">
                                    <span class="df">${{ (isset($order)) ? number_format($order->delivery_fee,2) :(isset($restaurant->delivery_fee))?number_format($restaurant->delivery_fee,2):'0.00' }}</span>
                                    <input type="hidden"
                                           value="{{ (isset($order)) ? number_format($order->delivery_fee,2) : (isset($restaurant->delivery_fee))?number_format($restaurant->delivery_fee,2):'0.00' }}"
                                           class="df" name="delivery_fee"/>
                                    <input type="hidden" value="0" id="delivery_flag" name="order_type"/></div>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Total</strong></td>
                            <td>
                                <div class="grandtotal inlineblock pull-right">
                                    ${{ (isset($order)) ? number_format($order->g_total,2) : '0.00' }}</div>
                                <input type="hidden" name="g_total" class="grandtotal"
                                       value="{{ (isset($order)) ? number_format($order->g_total,2) : '0.00' }}"/>
                                <input type="hidden" name="res_id"
                                       value="{{ (isset($restaurant->id))? $restaurant->id : '' }}"/>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                @if(!isset($order))
                    <div class="form-group   pull-right " style="margin-bottom: 0 !important;">
                        <a href="javascript:void(0)" class="btn  btn-secondary clearitems" onclick="clearCartItems();">Clear</a>
                        @if(!isset($is_open) || $is_open)
                            <a href="javascript:void(0)" class="btn btn-primary " onclick="checkout();">Checkout</a>
                        @endif
                    </div>
                @endif

                <div class="clearfix"></div>
            </div>

            <!-- display profile info -->

            @if(!isset($email))
                <div class="profiles row" style="display: none;">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <h2 class="profile_delevery_type"></h2>
                        </div>
                    </div>

                    <div class="form-group ">
                        <div class="col-xs-12">
                            @if(\Session::has('is_logged_in'))
                                <?php
                                $profile = \DB::table('profiles')->select('profiles.id', 'profiles.name', 'profiles.email', 'profiles.phone')->where('profiles.id', \Session::get('session_id'))->first();
                                echo "<p>Welcome " . $profile->name . "</p>";
                                ?>
                            @endif
                        </div>
                    </div>

                    @include('popups.addaddress',['loaded_from'=>'reservation'])

                    <form name="checkout_form" id="profiles" class="m-b-0">
                        @include('popups.checkout',['profile' => $profile, "type" => $type, "restaurant" => $restaurant, "checkout_modal" => $checkout_modal])
                    </form>
                </div>
            @endif
        </div>
    </div>

    <div class="clearfix"></div>
</div>


<script>
    function show_header() {
        if ($('#subtotal1').val() == '0.00' || $('#subtotal1').val() == '0') {
            $('.itmQty').hide();
        } else {
            $('.itmQty').show();
        }
    }

    function addresschanged(thiss) {
        $("#phone").val(thiss.getAttribute("PHONE"));//if(!$("#phone").val()){ }
        $("#formatted_address3").val(thiss.getAttribute("ADDRESS"));
        $(".city").val(thiss.getAttribute("CITY"));
        $(".province").val(thiss.getAttribute("PROVINCE"));
        $(".apartment").val(thiss.getAttribute("APARTMENT"));
        $(".postal_code").val(thiss.getAttribute("POSTAL"));
        $("#ordered_notes").val(thiss.getAttribute("NOTES"));
    }

    $(function () {
        show_header();
        @if($ordertype == "Delivery")
            $('#delivery1').click();
        @else
           $('#pickup1').click();
        @endif
        //save address
        $('#edit-form').submit(function (e) {
            if ($(this).hasClass('reservation')) {
                e.preventDefault();
                var url = $(this).attr('action');
                var datas = $(this).serialize();

                $.ajax({
                    url: url + '?ajax',
                    type: "post",
                    data: datas,
                    dataType: "json",
                    success: function (msg) {
                        $('#editModel').modal('hide');
                        $('.addressdropdown').load(document.URL + ' .addressdropdown>', function () {
                            $('.reservation_address_dropdown option[value="' + msg['id'] + '"]').attr('selected', 'selected');
                        });

                        $('.formatted_address').val(msg['formatted_address']);
                        $('.added_address').val(msg['address']);
                        $('.apartment').val(msg['apartment']);
                        $('.city').val(msg['city']);
                        $('.province').val(msg['province']);
                        $('.postal_code').val(msg['postal_code']);
                        $('#ordered_notes').text(msg['notes'])
                    }
                });
            }
        })
    });

    $(document).ready(function () {
        validateform("profiles", {
            phone: "phone required",
            mobile: "phone",
            @if(!read("id"))
                email: "email required",
                password: "required minlength 3",
            @endif
            reservation_address: "required"
        });
    });
</script>