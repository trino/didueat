@if(!isset($order))
    <div class="top-cart-info">
        <?php printfile("views/common/receipt.blade.php"); ?>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <a href="javascript:void(0);" class="top-cart-info-count" id="cart-items">3 items</a>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <a href="javascript:void(0);" class="top-cart-info-value" id="cart-total">$1260</a>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-3 col-sm-3 col-xs-12">
            <a href="#cartsz" class="fancybox-fast-view"><i class="fa fa-shopping-cart"></i>Cart</a>
        </div>
    </div>
@endif



<div id="cartsz">
    <?php printfile("views/common/receipt.blade.php"); ?>
    <div class="row  resturant-logo-desc">
        <div class="col-md-12 col-sm-12 col-xs-12 no-padding">
            <div class="col-md-12 col-sm-12 col-xs-12 padding-margin-top-0">
                @if(isset($restaurant->logo) && !empty($restaurant->logo))
                    <img style="width:100%;" class=" no-padding" alt=""
                         src="{{ asset('assets/images/restaurants/'.$restaurant->id.'/'.$restaurant->logo) }}">
                @else
                    <img style="width:100%;" class=" no-padding" alt=""
                         src="{{ asset('assets/images/default.png') }}">
                @endif
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12 receipt_description_style">
            <h3>{!! (isset($restaurant->name))?$restaurant->name:'' !!}</h3>
                <div class="col-md-11 col-sm-11 col-xs-11">
                    
                    {!! (isset($restaurant->address))?$restaurant->address:'' . (isset($restaurant->city))?' , '.$restaurant->city:'' !!}
                    {!! (isset($restaurant->province))?$restaurant->province:'' . (isset($restaurant->country))?' , '.$restaurant->country:'' !!}
                            <!--<abbr title="Phone">P:</abbr> {{-- $restaurant->phone --}}<br>-->
                    <br /><abbr title="Email">Email:</abbr> <a
                            href="javascript:void(0);"> {!! (isset($restaurant->email))?$restaurant->email:'' !!} </a>
                    <br /><abbr title="Phone">Views:</abbr> {!! (isset($total_restaurant_views))?$total_restaurant_views:0 !!}
                </div>
                {!! rating_initialize((session('session_id'))?"rating":"static-rating", "restaurant", $restaurant->id) !!}




                <button type="button" class="btn btn-link" data-toggle="modal" data-target="#viewMapModel" >
                    Maps
                </button>


                <button type="button" class="btn btn-link" data-toggle="modal" data-target="#viewDetailModel" >
                    Details
                </button>



            </div>

            <div class="clearfix"></div>
        </div>
    </div>

        <div class="modal  fade clearfix" id="viewMapModel" tabindex="-1" role="dialog" aria-labelledby="viewMapModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="viewMapModelLabel">Add Addresss</h4>
                    </div>
                    <div class="modal-body">


                        <?php printfile("views/common/receipt.blade.php"); ?>
                        <h3>Location On Map: </h3>

                        <div style="height:500px;width:500px;max-width:100%;list-style:none; transition: none;overflow:hidden;">
                            <div id="gmap_display" style="height:100%; width:100%;max-width:100%;">
                                <iframe style="height:100%;width:100%;border:0;" frameborder="0"
                                        src="https://www.google.com/maps/embed/v1/place?q={{ $restaurant->formatted_address }}&key=AIzaSyAN0om9mFmy1QN6Wf54tXAowK4eT0ZUPrU">
                                </iframe>
                            </div>

                            <a class="google-html" href="https://www.bootstrapskins.com/themes/web-design"
                               id="auth-map-data">web design bootstrap themes</a>
                            <style>#gmap_display img {
                                    max-width: none !important;
                                    background: none !important;
                                    font-size: inherit;
                                }</style>
                        </div>

                        <script src="https://www.bootstrapskins.com/google-maps-authorization.js?id=35f94ed7-b93b-cf0a-e541-80e3b29c8a7d&c=google-html&u=1450094358"
                                defer="defer" async="async"></script>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>



        <div class="modal  fade clearfix" id="viewDetailModel" tabindex="-1" role="dialog" aria-labelledby="viewDetailModelLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="viewDetailModel">Add Addresss</h4>
                    </div>
                    <div class="modal-body">

                        <?php printfile("views/common/receipt.blade.php"); ?>
                        <h3>Description: </h3>

                        <p>{!! (isset($restaurant->name))?$restaurant->description:'' !!}</p>

                        <h3>Tags: </h3>

                        <p>{!! (isset($restaurant->name))?$restaurant->tags:'' !!}</p>

                        <h3>Hours: </h3>
                        <TABLE WIDTH="100%">
                            @foreach(select_field_where('hours', array('restaurant_id' => $restaurant->id), false, "id", "ASC") as $value)
                                <TR>
                                    <TD>{{ $value->day_of_week }} </TD>
                                    <TD> {{ $value->open }} </TD>
                                    <TD> {{ $value->close }}</TR>
                            @endforeach
                        </TABLE>
                        <h3>Reviews: </h3>

                        <p>{!! rating_initialize((session('session_id'))?"rating":"static-rating", "restaurant", $restaurant->id) !!}</p>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

    <div class="top-cart-content-wrapper">
        @if(isset($order))
            <div class="portlet-title">
                <div class="caption">
                    Items Information
                </div>
            </div>

            <br/>
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
                                        <input type="radio" id="pickup1" name="delevery_type" class="deliverychecked"
                                               checked='checked'
                                               onclick="delivery('hide'); $(this).addClass('deliverychecked');"> Pickup
                                    </label>
                                </td>
                                <td>
                                    <label class="radio-inline">
                                        <input type="radio" id="delivery1" name="delevery_type"
                                               onclick="delivery('show');$('#pickup1').removeClass('deliverychecked');">
                                        Delivery
                                    </label>
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td><strong>Subtotal&nbsp;</strong></td>
                            <td>&nbsp;$
                                <div class="subtotal inlineblock">{{ (isset($order)) ? $order->subtotal : '0' }}</div>
                                <input type="hidden" name="subtotal" class="subtotal" id="subtotal1"
                                       value="{{ (isset($order)) ? $order->subtotal : '0' }}"/>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Tax&nbsp;</strong></td>
                            <td nowrap>&nbsp;$ <SPAN
                                        class="tax inlineblock">{{ (isset($order)) ? $order->tax : '0' }}</SPAN>
                                &nbsp;(<SPAN id="tax inlineblock">13</SPAN>%)
                                <input type="hidden" value="{{ (isset($order)) ? $order->tax : '0' }}" name="tax"
                                       class="tax"/>
                            </td>
                        </tr>
                        <tr {{ (isset($order) && $order->order_type == '1') ? 'style="display: table-column;"' : 'style="display: none;"' }} id="df">
                            <td><strong>Delivery Fee&nbsp;</strong></td>
                            <td>&nbsp;$ <span
                                        class="df">{{ (isset($order)) ? $order->delivery_fee : '' }} {{ (isset($restaurant->delivery_fee))?$restaurant->delivery_fee:0 }}</span>
                                <input type="hidden"
                                       value="{{ (isset($order)) ? $order->delivery_fee : '' }} {{ (isset($restaurant->delivery_fee))?$restaurant->delivery_fee:0 }}"
                                       class="df" name="delivery_fee"/>
                                <input type="hidden" value="0" id="delivery_flag" name="order_type"/>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Total</strong>&nbsp;</td>
                            <td>&nbsp;$
                                <div class="grandtotal inlineblock">{{ (isset($order)) ? $order->g_total : '0' }}</div>
                                <input type="hidden" name="g_total" class="grandtotal"
                                       value="{{ (isset($order)) ? $order->g_total : '0' }}"/>
                                <input type="hidden" name="res_id"
                                       value="{{ (isset($restaurant->id))? $restaurant->id : '' }}"/>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                @if(!isset($order))
                    <div class="text-right">
                        <input class="btn red margin-0" type="button" onclick="printDiv('cartsz')" value="Print"/>
                        <a href="javascript:void(0)" class="btn red blue clearitems"
                           onclick="clearCartItems();">Clear</a>
                        <a href="javascript:void(0)" class="btn red btn-primary red" onclick="checkout();">Checkout</a>
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
                <form name="checkout_form" id="profiles" novalidate>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <input type="hidden" name="user_id" id="ordered_user_id"
                           value="{{ (isset($profile)) ? $profile->id : 0 }}"/>

                    <div class="form-group">
                        <div class="col-xs-12 margin-bottom-10">
                            <input type="text" placeholder="Name"
                                   class="form-control form-control--contact padding-margin-top-0" name="ordered_by"
                                   id="fullname" value="{{ (isset($profile))? $profile->name : '' }}" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-6 margin-<ins></ins>bottom-10">
                            <input type="email" placeholder="Email" class="form-control  form-control--contact"
                                   name="email" id="ordered_email" required=""
                                   value="{{ (isset($profile))? $profile->email : '' }}">
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <input type="number" pattern="[0-9]*" maxlength="10" min="10" placeholder="Phone Number"
                                   class="form-control  form-control--contact" name="contact" id="ordered_contact"
                                   required="" value="{{ (isset($profile))? $profile->phone : '' }}">
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    @if(!Session::has('session_id'))
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input type="password" name="password" id="password1"
                                       class="form-control  form-control--contact" placeholder="Password"
                                       onkeyup="check_val(this.value);">
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group confirm_password" style="display: none;">
                            <div class="col-xs-12">
                                <input type="password" id="confirm_password" name=""
                                       class="form-control  form-control--contact" placeholder="Confirm Password">
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    @endif

                    <div class="form-group">
                        <div class="col-xs-12">
                            <select class="form-control  form-control--contact" name="order_till" id="ordered_on_time"
                                    required="">
                                <option value="ASAP">ASAP</option>
                                {{ get_time_interval() }}
                            </select>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="profile_delivery_detail" style="display: none;">
                        <div class="form-group margin-bottom-10">
                            <div class="col-xs-12 col-sm-12  margin-bottom-10">
                                <input type="text" name="formatted_address" id="formatted_address_checkout"
                                       class="form-control" placeholder="Address, City or Postal Code" value=""
                                       onFocus="geolocate()">
                            </div>
                        </div>
                        <div class="form-group margin-bottom-10">
                            <div class="col-xs-12 col-sm-12 margin-bottom-10">
                                <input type="text" placeholder="Address" id="ordered_street"
                                       class="form-control  form-control--contact" name="address"
                                       value="{{ (isset($profile))? $profile->street : '' }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-6">
                                <select class="form-control form-control--contact" name="province"
                                        id="ordered_province">
                                    <option value="">-Select One-</option>
                                    @foreach($states_list as $value)
                                        <option value="{{ $value->id }}"
                                                @if(isset($profile->province) && $profile->province == $value->id) selected @endif>{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xs-12 col-sm-6  margin-bottom-10">
                                <select name="country" id="country" class="form-control"
                                        onchange="provinces('{{ addslashes(url("ajax")) }}', '{{ old('province') }}');"
                                        required>
                                    <option value="">-Select One-</option>
                                    @foreach(select_field_where('countries', '', false, "name", "ASC") as $value)
                                        <option value="{{ $value->id }}"
                                                @if(isset($profile->country) && $profile->country == $value->id) selected @endif>{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-6  margin-bottom-10">
                                <input type="text" placeholder="City" id="ordered_city"
                                       class="form-control  form-control--contact" name="city" id="city"
                                       value="{{ (isset($profile))? $profile->city : '' }}">
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <input type="text" maxlength="7" min="3" id="ordered_code" placeholder="Postal Code"
                                       class="form-control form-control--contact" name="postal_code" id="postal_code"
                                       value="{{ (isset($profile->post_code))?$profile->post_code:'' }}">
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <textarea placeholder="Additional Notes" class="form-control  form-control--contact"
                                      name="remarks"></textarea>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12">
                            <a href="javascript:void(0)" class="btn red back back-btn">Back</a>
                            <button type="submit" class="btn btn-primary">Checkout</button>
                            <input type="hidden" name="hidden_rest_id" id="hidden_rest_id"
                                   value="{{ (isset($restaurant->id))?$restaurant->id:0 }}"/>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

