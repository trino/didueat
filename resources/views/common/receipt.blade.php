<?php
    printfile("views/common/receipt.blade.php");
    //the receipt that goes in an order
    $ordertype = false;
    $em=0;
    if(isset($email_msg)){
        $em = 1;
    }
    if (isset($order)) {
        if ($order->order_type) {
            $ordertype = "Delivery";
        } else {
            $ordertype = "Pickup";
        }
    }
    if(isset($_GET["delivery_type"])){
        $ordertype = $_GET["delivery_type"];
    }
    if (!isset($profile)) {
        $profile = false;
    }
    if(!isset($showCSR)){
        $showCSR = false;
    }
    if (!isset($type)) {
        $type = false;
    }
    if (!isset($checkout_modal)) {
        $checkout_modal = true;
    }

    $checkout = "Checkout";
    $is_my_restro = false;
    $business_day = \App\Http\Models\Restaurants::getbusinessday($restaurant->id);

    if(read("restaurant_id")){
        $is_my_restro = $restaurant->id == read("restaurant_id");
        if(!$is_my_restro && !debugmode() && Session::get('session_type_user') != "super"){
            $business_day = false;
        }
    }

    $title = "";
    if(!$business_day || !$restaurant->open){
        $reason = "";
        if(Session::get('session_type_user') == "super"){
            $reason = "SUPER";
        } else if(debugmode()){
            $reason = "DEBUG MODE";
        } else if ($is_my_restro) {
            $reason = "OWNER";
        }
        $title = "Closed, but bypassing because: " . $reason;
        $checkout .= " (" . $reason . ")";
    }

    $alts = array(
            "cart-items" => "Number of items in your cart",
            "cart-total" => "Total cost of your cart",
            "cartsz" => "View the contents of your cart",
            "call" => "Call the store (Only works on cellphones, or if you have Skype installed)",
            "closed" => "This restaurant is currently closed"
    );
?>

@if(false && !isset($order))
    <div class="top-cart-info">
        <a href="javascript:void(0);" class="top-cart-info-count" id="cart-items" title="{{ $alts["cart-items"] }}">0 items</a>
        <a href="javascript:void(0);" class="top-cart-info-value" id="cart-total" title="{{ $alts["cart-total"] }}">$0.00</a>
        <a href="javascript:void(0);" onclick="$('#cartsz').modal();$('#cartsz').addClass('modal');$('#cartsz').attr('style',$('#cartsz').attr('style')+'padding-left:15px;');" title="{{ $alts["cartsz"] }}">
            <i class="fa fa-shopping-cart"></i>Cart
        </a>
    </div>
@endif

<div id="cartsz">

    <div class="card">

        <div class="card-header">
            <h4 class="card-title">Your Order</h4>
        </div>

        <div class="card-block">

            <div class="receipt_main">
                @if(!isset($order))
                    <table style="<?php if(!isset($em)){?>width:100%;<?php }else{?>width:100%;padding:22px 0<?php }?>">
                    <tr>
                        <td colspan="2">
                            @if(isset($restaurant->is_delivery) && $restaurant->is_delivery == 1)
                                <label class="radio-inline c-input c-radio">
                                    <input type="radio" id="delivery1" name="delevery_type"
                                           onclick="delivery('show');"
                                           @if(!isset($restaurant->is_pickup) || !$restaurant->is_pickup)
                                           CHECKED TITLE="Only does delivery"
                                            @endif
                                            >
                                    <span class="c-indicator"></span>
                                    <strong>Delivery</strong>
                                </label>
                            @endif

                            @if(isset($restaurant->is_pickup) && $restaurant->is_pickup == 1)
                                <label class="radio-inline c-input c-radio">
                                    <input type="radio" id="pickup1" name="delevery_type"
                                           class="deliverychecked"
                                           onclick="delivery('hide');"
                                           @if(!isset($restaurant->is_delivery) || !$restaurant->is_delivery)
                                           CHECKED TITLE="Only does pickup"
                                            @endif
                                            >
                                    <span class="c-indicator"></span>
                                    <strong>Pickup</strong>
                                </label>
                            @endif
                        </td>

                    </tr>
                    </table>
                @endif

                @include('common.items')

                <div class="totals form-group" style=" width:100%;">
                    <table style="<?php if(!isset($em)){?>width:100%;<?php }else{?>width:100%;padding:22px 0<?php }?>">
                        <tbody>
                        <tr>
                            <td width=" @if(isset($order)) 75% @else 50% @endif "><strong>Subtotal</strong></td>
                            <td width=" @if(isset($order)) 25% @else 50% @endif ">
                                <div class="pull-right subtotal inlineblock">
                                    ${{ (isset($order)) ? number_format($order->subtotal,2) : '0.00' }}
                                </div>

                                <input type="hidden" name="subtotal" class="subtotal" id="subtotal1" value="{{ (isset($order)) ? number_format($order->subtotal,2) : '0.00' }}"/>
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
                            <td><strong>Delivery</strong></td>
                            <td>
                                <div class="pull-right ">
                                    <span class="df">${{ (isset($order)) ? number_format($order->delivery_fee,2) :(isset($restaurant->delivery_fee))?number_format($restaurant->delivery_fee,2):'0.00' }}</span>
                                    <input type="hidden"
                                           value="{{ (isset($order)) ? number_format($order->delivery_fee,2) : (isset($restaurant->delivery_fee))?number_format($restaurant->delivery_fee,2):'0.00' }}"
                                           class="df" name="delivery_fee"/>
                                    <input type="hidden" value="0" id="delivery_flag" name="order_type"/>
                                </div>
                            </td>
                        </tr>
                        <!--tr <?php if (isset($order) && $order->order_type == '1') echo ''; else echo "style='display:none'"; ?> id="df2">
                            <td><strong>Minimum</strong></td>
                            <td>
                                <div class="pull-right ">
                                    <span class="df">${{ number_format($restaurant->minimum,2) }}</span>
                                </div>
                            </td>
                        </tr-->


                        <tr>
                            <td><strong>Total</strong></td>
                            <td>
                                <div class="grandtotal inlineblock pull-right">${{ (isset($order)) ? number_format($order->g_total,2) : '0.00' }}</div>
                                <input type="hidden" name="g_total" class="grandtotal" value="{{ (isset($order)) ? number_format($order->g_total,2) : '0.00' }}"/>
                                <input type="hidden" name="res_id" value="{{ (isset($restaurant->id))? $restaurant->id : '' }}"/>
                                <input type="hidden" id="minimum_delivery" value="{{(isset($restaurant->minimum))?$restaurant->minimum:'0'}}"/>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                @if(!isset($order))
                    <div class="form-group" style="margin-bottom: 0 !important;">
                        @if($is_my_restro || ($business_day && $restaurant->open) || debugmode())
                            <a href="javascript:void(0)" class="btn btn-primary  btn-block" onclick="checkout();" TITLE="{{ $title }}">{{ $checkout }}</a>
                        @elseif($business_day && !$restaurant->open)
                            <a class="btn btn-primary btn-lg btn-block" title="{{ $alts["call"] }}" href="tel:{{ $restaurant->phone }}"><!--i class="fa fa-phone fa-2x"></i-->Call: {{ phonenumber($restaurant->phone, true) }}</a>
                        @else
                            <a class="btn btn-danger disabled  btn-block" href="#"title="{{ $alts["closed"] }}">Currently Closed</a>
                        @endif
                    </div>
                @endif

                <div class="clearfix"></div>
            </div>

            <!-- display profile info -->
            @if(!isset($email))
                <div class="profiles p-t-1" style="display: none;">

                    <div class="form-group">
                        <h4 style="padding-top: 60px; margin-top: -60px;" class="profile_delevery_type"></h4>
                    </div>

                    <!--div class="form-group ">
                        <div class="col-xs-12">
                    @if(\Session::has('is_logged_in'))
                        <?php
                            $profile = \DB::table('profiles')->select('profiles.id', 'profiles.name', 'profiles.email', 'profiles.phone')->where('profiles.id', \Session::get('session_id'))->first();
                            if($profile) {echo "<p>Welcome " . $profile->name . "</p>";}
                        ?>
                    @endif

                            </div>
                        </div-->

                    @include('popups.addaddress',['loaded_from'=>'reservation'])


                    <form name="checkout_form" id="profiles" class="m-b-0">
                        @include('popups.checkout',['profile' => $profile, "type" => $type, "restaurant" => $restaurant, "checkout_modal" => $checkout_modal])
                    </form>

                </div>

            @endif
        </div>
    </div>

    <div class="clearfix"></div>
    @if(!isset($order))

    <div class="col-lg-4 hidden-md-down">
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    </div>
@endif

</div>
</div>


<script>
    function show_header() {
        if ($('#subtotal1').val() == '0.00' || $('#subtotal1').val() == '0') {
            $('.itmQty').hide();
        } else {
            $('.itmQty').show();
        }
    }

    //handles changes of addresses
    function addresschanged(thiss) {
        $("#phone").val(thiss.getAttribute("PHONE"));//if(!$("#phone").val()){ }
        $("#formatted_address").val(thiss.getAttribute("ADDRESS"));
        $(".city").val(thiss.getAttribute("CITY"));
        $(".province").val(thiss.getAttribute("PROVINCE"));
        $(".apartment").val(thiss.getAttribute("APARTMENT"));
        $(".postal_code").val(thiss.getAttribute("POSTAL"));
        //$("#ordered_notes").val(thiss.getAttribute("NOTES"));
    }

    var ignoreone = false;
    $(function () {
        show_header();

        @if($ordertype)
            @if($ordertype == "Delivery" || $ordertype == "is_delivery")
                var ordertype = "is_delivery";
            @else
                var ordertype = "is_pickup";
            @endif
        @else
            var ordertype = getCookie("delivery_type");
        @endif

        if (ordertype == "is_delivery"){
            $('#delivery1').click();
        } else {
            $('#pickup1').click();
        }

        //handles any address additions, adds them to the SELECT dropdown
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
                        $("#reservation_address").val([]);
                        $("#show-addaddress").show();
                        var HTML = '<option class="dropdown-item" value="' + msg['id'] + '" city="' + msg['city'] + '" province="' + msg['province'] + '" apartment="' + msg['apartment'] + '" country="' + msg['country'] + '" phone="' + msg['phone'] + '" mobile="' + msg['mobile'] + '" latitude="' + msg['latitude'] + '" longitude="' + msg['longitude'] + '" id="add' + msg['id'] + '" address="' + msg['address'] + '" postal="' + msg['id'] + '" notes="" onclick="addresschanged(this)" SELECTED>' + msg['address'] + '</option>';
                        $("#reservation_address").append(HTML);
                        if (!ignoreone) {
                            ignoreone = true;
                            addresschange("receipt");
                        } else {
                            ignoreone = false;
                        }

                        $('.formatted_address').val(msg['formatted_address']);
                        $('.added_address').val(msg['address']);
                        $('.apartment').val(msg['apartment']);
                        $('.city').val(msg['city']);
                        $('.province').val(msg['province']);
                        $('.postal_code').val(msg['postal_code']);
                        //$('#ordered_notes').text(msg['notes'])
                    }
                });
            }
        })
    });

    //form validation
    $(document).ready(function () {
        if (typeof validateform != "undefined") {
            validateform("profiles", {
                phone: "phone required",
                mobile: "phone",
                reservation_address: "required",
                @if(!read("id"))
                    email: "email required",
                password: "required minlength 3",
                @endif
            });
        }
    });
</script>