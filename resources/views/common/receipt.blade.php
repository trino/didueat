<?php printfile("views/common/receipt.blade.php (top-cart-info)"); ?>

@if(!isset($order))
    <div class="top-cart-info">
        <a href="javascript:void(0);" class="top-cart-info-count" id="cart-items">3 items</a>
        <a href="javascript:void(0);" class="top-cart-info-value" id="cart-total">$1260</a>
        <a href="javascript:void(0);" onclick="$('#cartsz').modal();$('#cartsz').addClass('modal');$('#cartsz').attr('style',$('#cartsz').attr('style')+'padding-left:15px;'); "><i class="fa fa-shopping-cart"></i>Cart</a>
    </div>
@endif


<div class="clearfix" id="cartsz">

    @if(!isset($order))


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
                                            <input type="radio" id="delivery1" name="delevery_type"
                                                   onclick="delivery('show');$('#pickup1').removeClass('deliverychecked');">
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
                                    <input type="hidden" name="subtotal" class="subtotal" id="subtotal1"
                                           value="{{ (isset($order)) ? number_format($order->subtotal,2) : '0.00' }}"/>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Tax</strong></td>
                                <td>
                                    <span class="tax inlineblock">&nbsp;${{ (isset($order)) ? number_format($order->tax,2) : '0.00' }}</span>
                                    (<span id="tax inlineblock">13</span>%)
                                    <input type="hidden"
                                           value="{{ (isset($order)) ? number_format($order->tax,2) : '0.00' }}"
                                           name="tax" class="maintax tax"/>
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
                                    <div class="grandtotal inlineblock">
                                        &nbsp;${{ (isset($order)) ? number_format($order->g_total,2) : '0.00' }}</div>
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
                        <div class="form-group   pull-right ">
                            <a href="javascript:void(0)" class="btn  btn-secondary clearitems" onclick="clearCartItems();">Clear</a>
                            <a href="javascript:void(0)" class="btn btn-primary " onclick="checkout();">Checkout</a>
                        </div>
                    @endif

                    <div class="clearfix"></div>
                </div>


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
                                $profile = \DB::table('profiles')->select('profiles.id', 'profiles.name', 'profiles.email','profiles.phone')->where('profiles.id', \Session::get('session_id'))->first();
                                echo "<p>Welcome " . $profile->name . "</p>";
                                ?>
                            @else
                                <a class="btn btn-danger reserve_login" data-target="#loginModal" data-toggle="modal" onclick="$('#login-ajax-form').attr('data-route','reservation')">Log in</a>
                            @endif
                        </div>
                    </div>

                    @include('popups.addaddress',['loaded_from'=>'reservation'])
                    <form name="checkout_form" id="profiles"  class="m-b-0">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                        <input type="hidden" name="user_id" id="ordered_user_id"
                               value="{{ (isset($profile)) ? $profile->id : 0 }}"/>

                        <div class="col-sm-12">
                            <input type="text" placeholder="Full Name"
                                   class="form-control form-control--contact" name="ordered_by"
                                   id="fullname" value="{{ (isset($profile))? $profile->name : '' }}" required="" <?php if((isset($profile)))echo "disabled";?> >
                        </div>

                        <div class="col-sm-12">
                            <input type="email" placeholder="Email" class="form-control  form-control--contact"
                                   name="email" id="ordered_email" required=""
                                   value="{{ (isset($profile))? $profile->email : '' }}" <?php if((isset($profile)))echo "disabled";?> />
                        </div>

                        @if(!Session::has('is_logged_in'))
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input type="password" name="password" id="password"
                                           class="form-control  form-control--contact password_reservation" placeholder="Provide a password"
                                           onkeyup="check_val(this.value);" required="required" />
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        @endif

                          <div class="form-group">
                                <div class="col-xs-12 col-sm-12 margin-bottom-10">
                                    <input type="text"  maxlength="10" min="10"
                                           placeholder="Cell Phone" id="phone"
                                           class="form-control form-control--contact phone" name="contact"
                                           id="ordered_contact" required="" value="{{ (isset($profile))? $profile->phone : '' }}" <?php if((isset($profile)&& $profile->phone!=''))echo "disabled";?> />
                                </div>
                            </div>


                        <div class="profile_delivery_detail" style="display: none;">


                          
                            @include('common.editaddress',['type'=>'reservation'])
                            <?php if(false){  ?>
                            <div class="form-group">
                                <div class="col-xs-12 col-sm-12 margin-bottom-10">
                                    <input type="text" placeholder="Address" id="ordered_street"
                                           class="form-control form-control--contact resetme" name="address">
                                </div>
                            </div>

                            <div class="col-xs-6">
                                <input type="text" id="apartment" placeholder="Apartment" id="ordered_apartment"
                                       class="form-control form-control--contact resetme" name="apartment">
                            </div>

                            <div class="col-xs-12">
                                <input type="text" placeholder="City" id="ordered_city"
                                       class="form-control form-control--contact resetme" name="city">
                            </div>

                            <div class="col-xs-12">
                                <select class="form-control form-control--contact resetme" name="province"
                                        id="ordered_province">
                                    <option value="ON" SELECTED>Ontario</option>

                                    <?php
                                        /*foreach($states_list as $value)
                                        <option value="{{ $value->id }}"
                                                if(isset($profile->province) && $profile->province == $value->id) selected endif>$value->name</option>
                                        endforeach */
                                    ?>
                                </select>
                            </div>

                            <div class="col-xs-12">
                                <input type="text" maxlength="7" min="3" id="ordered_code" placeholder="Postal Code" class="form-control form-control--contact resetme" name="postal_code">
                            </div>
                            <?php } ?>
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

    <!-- add addresss modal -->
<div class=" modal  fade clearfix" id="viewMapModel" tabindex="-1" role="dialog" aria-labelledby="viewMapModalLabel" aria-hidden="true">
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
                        @if(!empty($restaurant->formatted_address))
                            <iframe style="height:100%;width:100%;border:0;" frameborder="0"
                                    src="https://www.google.com/maps/embed/v1/place?q={{ $restaurant->formatted_address }}&key=AIzaSyAN0om9mFmy1QN6Wf54tXAowK4eT0ZUPrU"></iframe>
                        @endif
                    </div>
                </div>

                <h3>Description: </h3>
                <p>{!! (isset($restaurant->description))?$restaurant->description:'' !!}</p>

                <h3>Tags: </h3>

                <p>{!! (isset($restaurant->tags))?$restaurant->tags:'' !!}</p>

                <h3>Hours: </h3>
                <TABLE WIDTH="100%">
                    <?php
                    $days = getweekdays();
                    foreach ($days as $day) {
                        echo '<TR><TD>' . $day . '</TD><TD>' . getfield($restaurant, $day . "_open") . '</TD><TD>' . getfield($restaurant, $day . "_close") . '</TD></TR>';
                    }
                    ?>
                </TABLE>

                <h3>Reviews: </h3>

                <p>{!! rating_initialize((session('session_id'))?"rating":"static-rating", "restaurant", $restaurant->id) !!}</p>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary pull-right">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script> 
    function addresschanged(thiss) {

            $("#phone").val(thiss.getAttribute("PHONE"));//if(!$("#phone").val()){ }
            $("#formatted_address3").val(thiss.getAttribute("ADDRESS"));
            $(".city").val(thiss.getAttribute("CITY"));
            $(".province").val(thiss.getAttribute("PROVINCE"));
            $(".apartment").val(thiss.getAttribute("APARTMENT"));
            $(".postal_code").val(thiss.getAttribute("POSTAL"));
            $("#ordered_notes").val(thiss.getAttribute("NOTES"));
            //$('#formatted_address3').val('');


    }
    
    $(function(){
        $('#delivery1').click();
        //save address
        $('#edit-form').submit(function(e){
            if($(this).hasClass('reservation'))
            {
                e.preventDefault();
                var url = $(this).attr('action');
                var datas = $(this).serialize();
                
                $.ajax({
                    url:url+'?ajax',
                    type:"post",
                    data:datas,
                    dataType:"json",
                    success:function(msg)
                    {
                        
                        $('.close').click();
                        $('#formatted_address3').val(msg['formatted_address']);
                        $('.apratment').val(msg['apartment']);
                        $('.city').val(msg['city']);
                        $('.province').val(msg['province']);
                        $('.postal_code').val(msg['postal_code']);
                        $('#ordered_notes').text(msg['notes'])
                        
                        
                    }
                    
                })
                
            }
        })
        
        
        
    })
</script>