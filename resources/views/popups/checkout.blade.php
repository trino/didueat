@if(!isset($checkout_modal) || $checkout_modal)
    <div class="modal" id="checkoutModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="simpleModalLabel">Checkout</h4>
                </div>

                <div class="modal-body ">
@endif

<div class="p-b-0 " id="modal_contents">
    <div class="row">
        <?php
            printfile("views/popups/checkout.blade.php");
            if (!$profile) {
                unset($profile);
            }
            if (!$type) {
                unset($type);
            }
            $alts = array(
                "login" => "Log in as an existing user",
                "checkout" => "Send the order to the store"
            );
        ?>

        @if(!read("id"))
            <div class="col-sm-12">
                <div class="form-group">
                   <span class="reserve_login">Please </span>
                    <a class="reserve_login" href="#" data-target="#loginModal" data-toggle="modal" onclick="checkout_login();" title="{{ $alts["login"] }}">Log in</a>
                    <span class="reserve_login">or Sign up below:</span>
                </div>
            </div>
        @endif

        <input type="hidden" name="_token" class="csrftoken" value="{{ csrf_token() }}"/>
        <input type="hidden" name="user_id" id="ordered_user_id" value="{{ (isset($profile)) ? $profile->id : 0 }}"/>
        <input type="hidden" name="added_address" value="" class="added_address"/>

        <div class="col-sm-12">
            <div class="form-group">
                <input type="text" placeholder="Full Name"
                       class="form-control" name="ordered_by"
                       id="fullname" value="{{ (isset($profile))? $profile->name : '' }}"
                       required="" <?php if ((isset($profile))) echo "readonly";?> />
            </div>
        </div>

        <div class="col-sm-12" <?php if ((isset($profile))) echo "hidden";?>>
            <div class="form-group">
                <input type="text"
                       name="phone"
                       placeholder="Cell Phone"
                       class="form-control" name="contact"
                       id="ordered_contact" required=""
                       value="{{ (isset($profile))? $profile->phone : '' }}" <?php if ((isset($profile))) echo "hidden";?> />
            </div>
        </div>


        <div class="col-sm-12" <?php if ((isset($profile))) echo "hidden";?>>
            <div class="form-group">
                <input type="email" placeholder="Email" class="form-control "
                       name="email" id="ordered_email" required=""
                       value="{{ (isset($profile))? $profile->email : '' }}" <?php if ((isset($profile))) echo "hidden";?> />
            </div>
        </div>

        <div class="col-sm-12 email_error" style="display: none; color: red;"></div>

        @if(!Session::has('is_logged_in'))
            <div class="col-xs-12">
                <div class="form-group">
                    <input type="password" name="password" id="password"
                           class="form-control  password_reservation" placeholder="Create Password"
                           onkeyup="check_val(this.value);" required="required"/>
                </div>
                <div class="clearfix"></div>
            </div>
        @endif

        <div class="profile_delivery_detail" style="display: none;">
            <div class="col-xs-12">
                <div class=" ">
                    @if(!isset($type) || $type != "report")
                        @include('common.editaddress', array('type'=>'reservation', "mini" => true))
                    @endif
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>

    </div>

    <DIV>
        <div class="col-xs-12">
            <div class="form-group">
                <select class="form-control" name="order_till" id="ordered_on_time">
                    <option value="">Order ASAP</option>
                    {{ get_time_interval($restaurant) }}
                </select>

                <div class="clearfix"></div>
            </div>
        </div>

        <div class="col-xs-12">
            <div class="form-group">
                <textarea placeholder="Additional Notes" id="ordered_notes" class="form-control resetme" name="remarks"></textarea>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
<div class="form-group">
        <div class="col-xs-4">
            <label class="radio-inline c-input c-radio">
                <input type="radio" name="payment_type" checked="checked" onclick="$('.CC').hide();" value="cash"/>
                <span class="c-indicator"></span>
                Cash
            </label>
        </div>
        <div class="col-xs-8">
            <label class="radio-inline c-input c-radio">
                <input type="radio" name="payment_type" onclick="$('.CC').show();" value="cc"/>
                <span class="c-indicator"></span>
                Debit/Credit</label>
        </div>
    <div class="clearfix"></div>

</div>
        <div class="CC" style="display: none;">
            @include('home.stripe',['loaded_from'=>'reservation'])
        </div>
        <div class="clearfix"></div>
    </div>

    <!--div class="col-xs-12 form-group text-xs-center p-a-0 m-t-1" style="color: red;font-size:90%;">
        Please review your order before proceeding!
    </div-->

    <div class="col-xs-12">
            <!--a href="javascript:history.go(0)" class="btn  btn-secondary clearitems">Cancel</a-->
            <button type="submit" class="btn btn-primary btn-block " onclick="return addresscheck();" id="chkOut" title="{{ $alts["checkout"] }}">Place Order</button>
            <input type="hidden" name="hidden_rest_id" id="hidden_rest_id" value="{{ (isset($restaurant->id))?$restaurant->id:0 }}"/>
    </div>

</div>
</div>

@if(!isset($checkout_modal) || $checkout_modal)
            </div>
        </div>
    </div>
@endif

<SCRIPT>
    function checkout_login() {
        $('#login-ajax-form').attr('data-route', 'reservation');
        $('#checkoutModal').modal('hide');
    }

    function addresscheck() {
        if (!addresschange('addresscheck')) {
            return false;
        }
    }
</SCRIPT>