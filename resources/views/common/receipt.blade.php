<?php if(!isset($order)){?>
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
<?php } ?>
<div id="cartsz">
    <div class="row  resturant-logo-desc padding-top-5">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="col-md-4 col-sm-4 col-xs-4">
                @if(isset($restaurant->logo) && !empty($restaurant->logo))
                    <img class="img-responsive" alt="" src="{{ asset('assets/images/restaurants/'.$restaurant->id.'/thumb1_'.$restaurant->logo) }}">
                @else
                    <img class="img-responsive" alt="" src="{{ asset('assets/images/default.png') }}">
                @endif
            </div>
            <address class="col-md-8 col-sm-8 col-xs-8">
                <h3>{!! (isset($restaurant->name))?$restaurant->name:'' !!}</h3>
                {!! (isset($restaurant->address))?$restaurant->address:'' . (isset($restaurant->city))?' , '.$restaurant->city:'' !!}
                {!! (isset($restaurant->province))?$restaurant->province:'' . (isset($restaurant->country))?' , '.$restaurant->country:'' !!}<br>
                <!--<abbr title="Phone">P:</abbr> {{-- $restaurant->phone --}}<br>-->
                <abbr title="Email">Email:</abbr> <a href="javascript:void(0);"> {!! (isset($restaurant->email))?$restaurant->email:'' !!} </a><br />
                <abbr title="Phone">Views:</abbr> {!! (isset($total_restaurant_views))?$total_restaurant_views:0 !!}
            </address>
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
                        <?php if(!isset($order)){?>
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
                        <?php } ?>
                        <tr>
                            <td><strong>Subtotal&nbsp;</strong></td>
                            <td>&nbsp;$ <div class="subtotal" style="display: inline-block;"><?php echo (isset($order)) ? $order->subtotal : '0';?></div>
                                <input type="hidden" name="subtotal" class="subtotal" id="subtotal1" value="<?php echo (isset($order)) ? $order->subtotal : '0';?>">
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Tax&nbsp;</strong></td>
                            <td>&nbsp;$ <div class="tax" style="display: inline-block;"><?php echo (isset($order)) ? $order->tax : '0';?></div>
                                &nbsp;(<div id="tax" style="display: inline-block;">13</div>%)
                                <input type="hidden" value="<?php echo (isset($order)) ? $order->tax : '0';?>" name="tax" class="tax"/>
                            </td>
                        </tr>
                        <tr <?php echo (isset($order) && $order->order_type == '1') ? 'style="display: table-column;"' : 'style="display: none;"';?> id="df">
                            <td><strong>Delivery Fee&nbsp;</strong></td>
                            <td>&nbsp;$<?php echo (isset($order)) ? $order->delivery_fee : '';?> {{ (isset($restaurant->delivery_fee))?$restaurant->delivery_fee:0 }}
                                <input type="hidden" value="<?php echo (isset($order)) ? $order->delivery_fee : '';?> {{ (isset($restaurant->delivery_fee))?$restaurant->delivery_fee:0 }}" class="df" name="delivery_fee"/>
                                <input type="hidden" value="0" id="delivery_flag" name="order_type"/>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Total</strong>&nbsp;</td>
                            <td>&nbsp;$ <div style="display: inline-block;" class="grandtotal"><?php echo (isset($order)) ? $order->g_total : '0';?></div>
                                <input type="hidden" name="g_total" class="grandtotal" value="<?php echo (isset($order)) ? $order->g_total : '0';?>"/>
                                <input type="hidden" name="res_id" value="<?php if (isset($restaurant->id)) echo $restaurant->id;?>"/>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <?php if(!isset($order)){ ?>
                    <div class="text-right">
                        <input class="btn red" type="button" onclick="printDiv('toprint')" value="Print" style="margin: 0;"/>
                        <a href="javascript:void(0)" class="btn blue clearitems">Clear</a>
                        <a href="javascript:void(0)" class="btn btn-primary red" onclick="checkout();">Checkout</a>
                    </div>
                <?php } ?>
            </div>
            <div class="profiles" style="display: none;">
                <div class="form-group">
                    <div class="col-xs-12">
                        <h2 class="profile_delevery_type"></h2>
                    </div>
                </div>
                <?php
                if(\Session::get('session_id'))
                $profile = \DB::table('profiles')->select('profiles.id', 'profiles.name', 'profiles.email', 'profiles_addresses.phone_no as phone', 'profiles_addresses.address as street', 'profiles_addresses.post_code', 'profiles_addresses.city', 'profiles_addresses.province')->where('profiles.id', \Session::get('session_id'))->LeftJoin('profiles_addresses', 'profiles.id', '=', 'profiles_addresses.user_id')->first();
                else
                {?>
                <div class="form-group reservation_signin">
                    <div class="col-xs-12">
                        <a href="#login-pop-up" class="btn btn-danger fancybox-fast-view"
                           onclick="$('#login_type').val('reservation')">Sign In</a>
                        <span>(Provide Password to Create a Profile.)</span>
                    </div>
                </div>
                <div class="clearfix"></div>
                <?php } ?>
                <form id="profiles">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <input type="hidden" name="user_id" id="ordered_user_id" value="<?php echo (isset($profile)) ? $profile->id : '0';?>"/>

                    <div class="form-group">
                        <div class="col-xs-12 margin-bottom-10">
                            <input type="text" style="padding-top: 0;margin-top: 0;" placeholder="Name" class="form-control  form-control--contact" name="ordered_by" id="fullname" value="<?php if (isset($profile)) echo $profile->name;?>" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-6 margin-<ins></ins>bottom-10">
                            <input type="email" placeholder="Email" class="form-control  form-control--contact" name="email" id="ordered_email" required="" value="<?php if (isset($profile)) echo $profile->email;?>">
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <input type="number" pattern="[0-9]*" maxlength="10" min="10" placeholder="Phone Number" class="form-control  form-control--contact" name="contact" id="ordered_contact" required="" value="<?php if (isset($profile)) echo $profile->phone;?>">
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="form-group" <?php if (isset($profile)) echo 'style="display:none;"'?>>
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
                                <?php get_time_interval();?>
                            </select>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="profile_delivery_detail" style="display: none;">
                        <div class="form-group margin-bottom-10">
                            <div class="col-xs-12 col-sm-6  margin-bottom-10">
                                <input type="text" placeholder="Address 2" id="ordered_street" class="form-control  form-control--contact" name="address2" value="<?php if (isset($profile)) echo $profile->street;?>">
                            </div>

                            <div class="col-xs-12 col-sm-6  margin-bottom-10">
                                <input type="text" placeholder="City" id="ordered_city" class="form-control  form-control--contact" name="city" id="city" value="<?php if (isset($profile)) echo $profile->city;?>">
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
                            <a href="javascript:void(0)" class="btn red back" style="position: relative; top: -7px;">Back</a>
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
