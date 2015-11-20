@if(!isset($order))
<div class="top-cart-info">
    <div class="col-md-6 col-sm-6 col-xs-12">
        <a href="javascript:void(0);" class="top-cart-info-count" id="cart-items">3 items</a>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <a href="javascript:void(0);" class="top-cart-info-value" id="cart-total">$1260</a>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-3 col-sm-3 col-xs-12">
        <a href="#cartsz" class="fancybox-fast-view"><i class="fa fa-shopping-cart" onclick="#cartsz">Cart</i></a>
    </div>
</div>
@endif
<div id="cartsz">
    <div class="row  resturant-logo-desc">
        <div class="col-md-12 col-sm-12 col-xs-12 no-padding">
            <div class="col-md-12 col-sm-12 col-xs-12 padding-margin-top-0">
                @if(isset($restaurant->logo) && !empty($restaurant->logo))
                    <img style="height: 100px;width:100%;" class=" no-padding" alt="" src="{{ asset('assets/images/restaurants/'.$restaurant->id.'/'.$restaurant->logo) }}">
                @else
                    <img  style="height: 100px;width:100%;"class=" no-padding" alt="" src="{{ asset('assets/images/default.png') }}">
                @endif
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12 receipt_description_style">
                <div class="col-md-1 col-sm-1 col-xs-1">
                    <span class="font-size"><</span>
                </div>
                <div  class="col-md-11 col-sm-11 col-xs-11">
                    <h3>{!! (isset($restaurant->name))?$restaurant->name:'' !!}</h3>
                    {!! (isset($restaurant->address))?$restaurant->address:'' . (isset($restaurant->city))?' , '.$restaurant->city:'' !!}
                    {!! (isset($restaurant->province))?$restaurant->province:'' . (isset($restaurant->country))?' , '.$restaurant->country:'' !!}
                    <!--<abbr title="Phone">P:</abbr> {{-- $restaurant->phone --}}<br>-->
                    <abbr title="Email">Email:</abbr> <a href="javascript:void(0);"> {!! (isset($restaurant->email))?$restaurant->email:'' !!} </a>
                    <abbr title="Phone">Views:</abbr> {!! (isset($total_restaurant_views))?$total_restaurant_views:0 !!}
                </div>
                {!! rating_initialize("static-rating", '2.5') !!}
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    
    <div class="top-cart-content-wrapper">
        @if(isset($order))
        <div class="portlet-title">
            <div class="caption">
                Items Information
            </div>
        </div>

        <br />
        @endif

        <div class="top-cart-content ">
            <div class="receipt_main">

                @include('common.items')

                <div class="totals col-md-12 col-sm-12 col-xs-12">
                    <table class="table">
                        <tbody>
                        @if(!isset($order))
                        <tr>
                            <td>
                                <label class="radio-inline">
                                    <input type="radio" id="pickup1" name="delevery_type" class="deliverychecked" checked='checked' onclick="delivery('hide'); $(this).addClass('deliverychecked');"> Pickup
                                </label>
                            </td>
                            <td>
                                <label class="radio-inline">
                                    <input type="radio" id="delivery1" name="delevery_type" onclick="delivery('show');$('#pickup1').removeClass('deliverychecked');"> Delivery
                                </label>
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td><strong>Subtotal&nbsp;</strong></td>
                            <td>&nbsp;$ <div class="subtotal inlineblock">{{ (isset($order)) ? $order->subtotal : '0' }}</div>
                                <input type="hidden" name="subtotal" class="subtotal" id="subtotal1" value="{{ (isset($order)) ? $order->subtotal : '0' }}" />
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Tax&nbsp;</strong></td>
                            <td>&nbsp;$ <div class="tax inlineblock">{{ (isset($order)) ? $order->tax : '0' }}</div>
                                &nbsp;(<div id="tax inlineblock">13</div>%)
                                <input type="hidden" value="{{ (isset($order)) ? $order->tax : '0' }}" name="tax" class="tax" />
                            </td>
                        </tr>
                        <tr {{ (isset($order) && $order->order_type == '1') ? 'style="display: table-column;"' : 'style="display: none;"' }} id="df">
                            <td><strong>Delivery Fee&nbsp;</strong></td>
                            <td>&nbsp;$ <span class="df">{{ (isset($order)) ? $order->delivery_fee : '' }} {{ (isset($restaurant->delivery_fee))?$restaurant->delivery_fee:0 }}</span>
                                <input type="hidden" value="{{ (isset($order)) ? $order->delivery_fee : '' }} {{ (isset($restaurant->delivery_fee))?$restaurant->delivery_fee:0 }}" class="df" name="delivery_fee"/>
                                <input type="hidden" value="0" id="delivery_flag" name="order_type" />
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Total</strong>&nbsp;</td>
                            <td>&nbsp;$ <div class="grandtotal inlineblock">{{ (isset($order)) ? $order->g_total : '0' }}</div>
                                <input type="hidden" name="g_total" class="grandtotal" value="{{ (isset($order)) ? $order->g_total : '0' }}"/>
                                <input type="hidden" name="res_id" value="{{ (isset($restaurant->id))? $restaurant->id : '' }}"/>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                @if(!isset($order))
                    <div class="text-right">
                        <input class="btn red margin-0" type="button" onclick="printDiv('cartsz')" value="Print" />
                        <a href="javascript:void(0)" class="btn blue clearitems" onclick="clearCartItems();">Clear</a>
                        <a href="javascript:void(0)" class="btn btn-primary red" onclick="checkout();">Checkout</a>
                    </div>
                @endif
            </div>
            <div class="profiles" style="display: none;">
                <div class="form-group">
                    <div class="col-xs-12">
                        <h2 class="profile_delevery_type"></h2>
                    </div>
                </div>
                @if(\Session::has('session_id'))
                <?php
                $profile = \DB::table('profiles')->select('profiles.id', 'profiles.name', 'profiles.email', 'profiles_addresses.phone_no as phone', 'profiles_addresses.address as street', 'profiles_addresses.post_code', 'profiles_addresses.city', 'profiles_addresses.province')->where('profiles.id', \Session::get('session_id'))->LeftJoin('profiles_addresses', 'profiles.id', '=', 'profiles_addresses.user_id')->first();
                ?>
                @else
                <div class="form-group reservation_signin">
                    <div class="col-xs-12">
                        <a href="#login-pop-up" class="btn btn-danger fancybox-fast-view"
                           onclick="$('#login_type').val('reservation')">Sign In</a>
                        <span>(Provide Password to Create a Profile.)</span>
                    </div>
                </div>
                <div class="clearfix"></div>
                @endif
                <form id="profiles">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <input type="hidden" name="user_id" id="ordered_user_id" value="{{ (isset($profile)) ? $profile->id : 0 }}" />
                    <div class="form-group">
                        <div class="col-xs-12 margin-bottom-10">
                            <input type="text" placeholder="Name" class="form-control form-control--contact padding-margin-top-0" name="ordered_by" id="fullname" value="{{ (isset($profile))? $profile->name : '' }}" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-6 margin-<ins></ins>bottom-10">
                            <input type="email" placeholder="Email" class="form-control  form-control--contact" name="email" id="ordered_email" required="" value="{{ (isset($profile))? $profile->email : '' }}">
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <input type="number" pattern="[0-9]*" maxlength="10" min="10" placeholder="Phone Number" class="form-control  form-control--contact" name="contact" id="ordered_contact" required="" value="{{ (isset($profile))? $profile->phone : '' }}">
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="form-group" @if(isset($profile)) 'style="display:none;"' @endif>
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
                                {{ get_time_interval() }}
                            </select>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="profile_delivery_detail" style="display: none;">
                        <div class="form-group margin-bottom-10">
                            <div class="col-xs-12 col-sm-6  margin-bottom-10">
                                <input type="text" placeholder="Address 2" id="ordered_street" class="form-control  form-control--contact" name="address2" value="{{ (isset($profile))? $profile->street : '' }}">
                            </div>

                            <div class="col-xs-12 col-sm-6  margin-bottom-10">
                                <input type="text" placeholder="City" id="ordered_city" class="form-control  form-control--contact" name="city" id="city" value="{{ (isset($profile))? $profile->city : '' }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-6">
                                <select class="form-control form-control--contact" name="province" id="ordered_province">
                                    <option value="">-Select One-</option>
                                    @foreach($states_list as $value)
                                        <option value="{{ $value->id }}" @if(isset($profile->province) && $profile->province == $value->id) selected @endif>{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <input type="text" maxlength="7" min="3" id="ordered_code" placeholder="Postal Code" class="form-control form-control--contact" name="postal_code" id="postal_code" value="{{ (isset($profile->post_code))?$profile->post_code:'' }}">
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
                            <a href="javascript:void(0)" class="btn red back back-btn">Back</a>
                            <button type="submit" class="btn btn-primary">Checkout</button>
                            <input type="hidden" name="hidden_rest_id" id="hidden_rest_id" value="{{ (isset($restaurant->id))?$restaurant->id:0 }}" />
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
