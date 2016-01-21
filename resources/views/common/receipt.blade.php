<?php printfile("views/common/receipt.blade.php (top-cart-info)"); ?>

@if(!isset($order))
    <div class="top-cart-info">
        <a href="javascript:void(0);" class="top-cart-info-count" id="cart-items">3 items</a>
        <a href="javascript:void(0);" class="top-cart-info-value" id="cart-total">$1260</a>
        <a href="#cartsz" class="fancybox-fast-view"><i class="fa fa-shopping-cart"></i>Cart</a>
    </div>
@endif

<div id="cartsz">
    @if(!isset($order))
        <div class="card card-inverse card-primary " style="">
            <div class="card-block">
                <img style="" class="pull-right"
                     @if(isset($restaurant->logo) && !empty($restaurant->logo))
                     src="{{ asset('assets/images/restaurants/'.$restaurant->id.'/'.$restaurant->logo) }}"
                     @else
                     src="{{ asset('assets/images/default.png') }}"
                     @endif
                     alt="Card image cap">

                <h4 class="card-title">{!! (isset($restaurant->name))?$restaurant->name:'' !!}</h4>

                <p class="card-text" style="font-size:90%;">
                    {!! (isset($restaurant->address))?$restaurant->address.',':'' !!}
                    {!! (isset($restaurant->city))?$restaurant->city.', ':'' !!}
                    {!! (isset($restaurant->province))? mapcountryprovince($restaurant->province, true) .' ':'' !!}
                    {!! (isset($restaurant->postal_code))?$restaurant->postal_code.' ':'' !!}
                    <br>{!! (isset($restaurant->phone))?$restaurant->phone:'' !!}
                    <br>Wed: 8am - 8pm
                    <br>Views: {!! (isset($total_restaurant_views))?$total_restaurant_views:0 !!}
                </p>

                <div class="clearfix"></div>

                <a style="color:white;" class="btn btn-info-outline pull-right" href="#" data-toggle="modal" data-target="#viewMapModel">More Detail</a>
                <div id="restaurant_rating">
                    {!! rating_initialize((session('session_id'))?"static-rating":"static-rating", "restaurant", $restaurant->id) !!}
                </div>
                <div class="clearfix"></div>
            </div>
        </div>


        <div class="card card-inverse card-danger " style="">
            <div class="card-block ">
                <h4 class="card-title text-xs-center m-b-0">Restaurant doesn't offer online ordering</h4>
                <p class="card-title text-xs-center m-b-0">Please call to place your order</p>
            </div>
        </div>
    @endif

    <div class="card " style="">
        <div class="card-block ">
            <div class="top-cart-content ">
                <div class="receipt_main">
                    <h4 class="card-title">Receipt</h4>
                    @include('common.items')

                    <div class="totals">
                        <table class="table">
                            <tbody>
                            @if(!isset($order))
                                <tr>
                                    <td colspan="2">
                                        <label class="radio-inline c-input c-radio">
                                            <input type="radio" id="delivery1" name="delevery_type" onclick="delivery('show');$('#pickup1').removeClass('deliverychecked');">
                                            <span class="c-indicator"></span>
                                            <strong>Delivery</strong>
                                        </label>

                                        <label class="radio-inline c-input c-radio">
                                            <input type="radio" id="pickup1" name="delevery_type"
                                                   class="deliverychecked"
                                                   checked='checked'
                                                   onclick="delivery('hide'); $(this).addClass('deliverychecked');">
                                            <span class="c-indicator"></span>
                                            <strong>Pickup</strong>
                                        </label>
                                    </td>

                                </tr>
                            @endif


                            <tr>
                                <td><strong>Subtotal</strong></td>
                                <td>
                                    <div class="subtotal inlineblock">
                                        ${{ (isset($order)) ? number_format($order->subtotal,2) : '0.00' }}
                                    </div>
                                    <input type="hidden" name="subtotal" class="subtotal" id="subtotal1" value="{{ (isset($order)) ? number_format($order->subtotal,2) : '0.00' }}"/>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Tax</strong></td>
                                <td>
                                    <span class="tax inlineblock">&nbsp;${{ (isset($order)) ? number_format($order->tax,2) : '0.00' }}</span>
                                    (<span id="tax inlineblock">13</span>%)
                                    <input type="hidden" value="{{ (isset($order)) ? number_format($order->tax,2) : '0.00' }}" name="tax" class="maintax tax"/>
                                </td>
                            </tr>
                            <tr <?php if (isset($order) && $order->order_type == '1') echo ''; else echo "style='display:none'"; ?> id="df">
                                <td><strong>Delivery Fee</strong></td>
                                <td>
                                    <span class="df">${{ (isset($order)) ? number_format($order->delivery_fee,2) :(isset($restaurant->delivery_fee))?number_format($restaurant->delivery_fee,2):'0.00' }}</span>
                                    <input type="hidden"
                                           value="{{ (isset($order)) ? number_format($order->delivery_fee,2) : (isset($restaurant->delivery_fee))?number_format($restaurant->delivery_fee,2):'0.00' }}"
                                           class="df" name="delivery_fee"/>
                                    <input type="hidden" value="0" id="delivery_flag" name="order_type"/>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Total</strong></td>
                                <td>
                                    <div class="grandtotal inlineblock">&nbsp;${{ (isset($order)) ? number_format($order->g_total,2) : '0.00' }}</div>
                                    <input type="hidden" name="g_total" class="grandtotal" value="{{ (isset($order)) ? number_format($order->g_total,2) : '0.00' }}"/>
                                    <input type="hidden" name="res_id" value="{{ (isset($restaurant->id))? $restaurant->id : '' }}"/>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    @if(!isset($order))
                        <!--input  class="btn  btn-secondary " type="button" onclick="printDiv('cartsz')" value="Print"/-->
                        <div class="form-group   pull-right ">
                            <a href="javascript:void(0)" class="btn  btn-secondary clearitems" onclick="clearCartItems();">Clear</a>
                            <a href="javascript:void(0)" class="btn btn-primary " onclick="checkout();">Checkout</a>
                        </div>
                    @endif

                    <div class="clearfix"></div>
                </div>


                <!-- display profile info -->
                <!-- display profile info -->
                <!-- display profile info -->

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
                                    $profile = \DB::table('profiles')->select('profiles.id', 'profiles.name', 'profiles.email')->where('profiles.id', \Session::get('session_id'))->first();

                                    /*
                                     *  'profiles_addresses.phone as phone', 'profiles_addresses.address as street', 'profiles_addresses.postal_code', 'profiles_addresses.city', 'profiles_addresses.province'
                                     * LeftJoin('profiles_addresses', 'profiles.id', '=', 'profiles_addresses.user_id')->first();
                                     * DO NOT ASSUME THE CUSTOMERS ADDRESS!!!
                                     */
                                    echo "<p>Welcome " . $profile->name . "</p>";
                                ?>
                            @else
                                <a class="btn btn-danger" data-target="#loginModal" data-toggle="modal">Log in</a>
                            @endif
                        </div>
                    </div>


                    <form name="checkout_form" id="profiles" novalidate class="m-b-0">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                        <input type="hidden" name="user_id" id="ordered_user_id" value="{{ (isset($profile)) ? $profile->id : 0 }}"/>

                            <div class="col-sm-12">
                                <input type="text" placeholder="Full Name"
                                       class="form-control form-control--contact" name="ordered_by"
                                       id="fullname" value="{{ (isset($profile))? $profile->name : '' }}" required="">
                            </div>

                            <div class="col-sm-12">
                                <input type="email" placeholder="Email" class="form-control  form-control--contact"
                                       name="email" id="ordered_email" required=""
                                       value="{{ (isset($profile))? $profile->email : '' }}">
                            </div>

                            @if(!Session::has('is_logged_in'))
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <input type="password" name="password" id="password"
                                               class="form-control  form-control--contact" placeholder="Provide a password"
                                               onkeyup="check_val(this.value);">
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            @endif


                        <div class="profile_delivery_detail" style="display: none;">
                            @if(isset($profile))
                                <div class="col-xs-12">
                                    <SELECT CLASS="form-control form-control--contact" ONCHANGE="addresschanged(event);">
                                        <OPTION VALUE="0" ID="add0">Select Address</OPTION>
                                        <?php
                                            //NOTE: AT NO POINT SHOULD WE ASSUME WHAT ADDRESS THE CUST WANTS TO USE, NO DEFAULTS
                                            $addresses = select_field("profiles_addresses", "user_id", $profile->id, false, "order");
                                            foreach($addresses as $address){
                                                echo '<OPTION VALUE="' .$address->id . '" CITY="' .$address->city . '" PROVINCE="' .$address->province . '" APARTMENT="' . $address->apartment . '" ';
                                                echo 'BUZZ="' . $address->buzz . '" COUNTRY="' .$address->country . '" PHONE="' .$address->phone . '" MOBILE="' .$address->mobile . '" ';
                                                echo 'ID="add' .$address->id . '" ADDRESS="' . $address->address . '" POSTAL="' . $address->postal_code . '" NOTES="' .$address->notes . '">';
                                                echo $address->address;
                                                echo '</OPTION>';
                                            }
                                        ?>
                                    </SELECT>
                                    <SCRIPT>
                                        function addresschanged(event){
                                            var element = event.target;
                                            var selected = element.options[element.selectedIndex];
                                            if(selected.value) {
                                                var value = selected.text;
                                                selected = document.getElementById("add" + selected.value);
                                                $(".resetme").val(' ');

                                                $("#phone").val(selected.getAttribute("PHONE"));//if(!$("#phone").val()){ }
                                                $("#ordered_street").val(selected.getAttribute("ADDRESS"));
                                                $("#ordered_city").val(selected.getAttribute("CITY"));
                                                $("#ordered_province").val(selected.getAttribute("PROVINCE"));
                                                $("#ordered_apartment").val(selected.getAttribute("APARTMENT"));
                                                $("#ordered_buzz").val(selected.getAttribute("BUZZ"));
                                                $("#ordered_code").val(selected.getAttribute("POSTAL"));
                                                $("#ordered_notes").val(selected.getAttribute("NOTES"));
                                            }
                                        }
                                    </SCRIPT>
                                </div>
                            @endif

                            <div class="form-group">
                                <div class="col-xs-12 col-sm-12 margin-bottom-10">
                                    <input type="number" pattern="[0-9]*" maxlength="10" min="10" placeholder="Cell Phone" id="phone"
                                       class="form-control form-control--contact" name="contact" id="ordered_contact" required="">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-12 col-sm-12 margin-bottom-10">
                                    <input type="text" placeholder="Address" id="ordered_street" class="form-control form-control--contact resetme" name="address">
                                </div>
                            </div>

                            <div class="col-xs-6">
                                <input type="text" placeholder="Apartment" id="ordered_apartment" class="form-control form-control--contact resetme" name="apartment">
                            </div>
                            <div class="col-xs-6">
                                <input type="text" placeholder="Buzz" id="ordered_buzz" class="form-control form-control--contact resetme" name="buzz">
                            </div>

                            <div class="col-xs-12">
                                <input type="text" placeholder="City" id="ordered_city" class="form-control form-control--contact resetme" name="city">
                            </div>

                            <div class="col-xs-12">
                                <select class="form-control form-control--contact resetme" name="province" id="ordered_province">
                                    <option value="">Province</option>
                                    @foreach($states_list as $value)
                                        <option value="{{ $value->id }}"
                                                @if(isset($profile->province) && $profile->province == $value->id) selected @endif>{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-xs-12">
                                <input type="text" maxlength="7" min="3" id="ordered_code" placeholder="Postal Code" class="form-control form-control--contact resetme" name="postal_code">
                            </div>

                            <!--div class="col-xs-12 col-sm-6  margin-bottom-10">
                                <select name="country" id="country" class="form-control"
                                        onchange="provinces('{{ addslashes(url("ajax")) }}', '{{ old('province') }}');"
                                        required>
                                    <option value="">-Select One-</option>
                                    @foreach(select_field_where('countries', '', false, "name", "ASC") as $value)
                                    <option value="{{ $value->id }}"
                                                @if(isset($profile->country) && $profile->country == $value->id) selected @endif>{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div-->

                            <div class="clearfix"></div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <select class="form-control  form-control--contact" name="order_till" id="ordered_on_time" required="">
                                    <option value="Order ASAP">Order ASAP</option>
                                    {{ get_time_interval() }}
                                </select>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <textarea placeholder="Additional Notes" id="ordered_notes" class="form-control form-control--contact resetme" name="remarks"></textarea>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <div class="form-group   pull-right ">
                            <div class="col-xs-12">
                                <a href="javascript:void(0)" class="btn btn-secondary  back back-btn">Back</a>
                                <button type="submit" class="btn btn-primary">Checkout</button>
                                <input type="hidden" name="hidden_rest_id" id="hidden_rest_id" value="{{ (isset($restaurant->id))?$restaurant->id:0 }}"/>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>

<div class=" modal  fade clearfix" id="viewMapModel" tabindex="-1" role="dialog" aria-labelledby="viewMapModalLabel"
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
                <h3>Location On Map: </h3>
                <div style="height:500px;max-width:100%;list-style:none; transition: none;overflow:hidden;">
                    <div id="gmap_display" style="height:100%; width:100%;max-width:100%;">
                        <iframe style="height:100%;width:100%;border:0;" frameborder="0" src="https://www.google.com/maps/embed/v1/place?q={{ $restaurant->formatted_address }}&key=AIzaSyAN0om9mFmy1QN6Wf54tXAowK4eT0ZUPrU"></iframe>
                    </div>
                </div>

                <!--script src="https://www.bootstrapskins.com/google-maps-authorization.js?id=35f94ed7-b93b-cf0a-e541-80e3b29c8a7d&c=google-html&u=1450094358" defer="defer" async="async"></script-->

                <h3>Description: </h3>
                <p>{!! (isset($restaurant->description))?$restaurant->description:'' !!}</p>

                <h3>Tags: </h3>

                <p>{!! (isset($restaurant->tags))?$restaurant->tags:'' !!}</p>

                <h3>Hours: </h3>
                <TABLE WIDTH="100%">
                    <?php
                        $days = getweekdays();
                        foreach($days as $day){
                            echo '<TR><TD>' . $day . '</TD><TD>' . getfield($restaurant, $day . "_open") . '</TD><TD>' . getfield($restaurant, $day . "_close") . '</TD></TR>';
                        }
                    ?>
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