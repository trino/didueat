@if(!isset($checkout_modal) || $checkout_modal)
<div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="simpleModalLabel">Checkout</h4>
            </div>

            <div class="modal-body">
@endif

                <?php
                    printfile("views/popups/checkout.blade.php");
                    if(!$profile){unset($profile);}
                    if(!$type){unset($type);}
                ?>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12" id="modal_contents">

                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                        <input type="hidden" name="user_id" id="ordered_user_id" value="{{ (isset($profile)) ? $profile->id : 0 }}"/>
                        <input type="hidden" name="added_address" value="" class="added_address"/>

                        <div class="col-sm-12">
                            <input type="text" placeholder="Full Name"
                                   class="form-control" name="ordered_by"
                                   id="fullname" value="{{ (isset($profile))? $profile->name : '' }}"
                                   required="" <?php if ((isset($profile))) echo "readonly";?> />
                        </div>

                        <div class="col-sm-12">
                            <input type="email" placeholder="Email" class="form-control "
                                   name="email" id="ordered_email" required=""
                                   value="{{ (isset($profile))? $profile->email : '' }}" <?php if ((isset($profile))) echo "readonly";?> />
                        </div>

                        <div class="col-sm-12 email_error" style="display: none; color: red;"></div>

                        @if(!Session::has('is_logged_in'))
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input type="password" name="password" id="password"
                                           class="form-control  password_reservation" placeholder="Create Password"
                                           onkeyup="check_val(this.value);" required="required"/>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        @endif

                        <div class="form-group">
                            <div class="col-xs-12 col-sm-12 margin-bottom-10">
                                <input type="text"
                                       name="phone"
                                       placeholder="Cell Phone"
                                       class="form-control" name="contact"
                                       id="ordered_contact" required=""
                                       value="{{ (isset($profile))? $profile->phone : '' }}" <?php if ((isset($profile) && $profile->phone != '')) echo "readonly";?> />
                            </div>
                        </div>

                        <div class="profile_delivery_detail" style="display: none;">
                            @if(!isset($type) || $type != "report")
                                @include('common.editaddress',['type'=>'reservation'])
                            @endif
                            <div class="clearfix"></div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <select class="form-control " name="order_till" id="ordered_on_time" required="">
                                    <option value="Order ASAP">Order ASAP</option>
                                    {{ get_time_interval($restaurant) }}
                                </select>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <textarea placeholder="Additional Notes" id="ordered_notes" class="form-control resetme" name="remarks"></textarea>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <div class="form-group pull-right m-b-0">
                            <div class="col-xs-12">
                                @if(!read("id"))
                                    <a class="btn btn-danger reserve_login" data-target="#loginModal" data-toggle="modal" onclick="checkout_login();">Log in</a>
                                @endif

                                    <!--div class="alert alert-success alert-dismissible fade in" role="alert">No items yet</div-->

                                <button type="submit" class="btn btn-primary">Complete</button>
                                <input type="hidden" name="hidden_rest_id" id="hidden_rest_id" value="{{ (isset($restaurant->id))?$restaurant->id:0 }}"/>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                </div>

@if(!isset($checkout_modal) || $checkout_modal)
            </div>
        </div>
    </div>
</div>
@endif

<SCRIPT>
    function checkout_login(){
        $('#login-ajax-form').attr('data-route','reservation');
        $('#checkoutModal').modal('hide');
    }
</SCRIPT>