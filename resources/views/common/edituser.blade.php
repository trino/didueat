<?php printfile("views/common/edituser.blade.php"); ?>
<script src="{{ url("assets/global/scripts/provinces.js") }}" type="text/javascript"></script>
<meta name="_token" content="{{ csrf_token() }}" />

<div class="form-group">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <select name="profile_type" class="form-control">
            <?php
                $profiletypes = array(1 => "Super", 2 => "User", 3 => "Owner", 4 => "Employee");
                foreach($profiletypes as $ID => $title){
                    echo '<option value="' . $ID . '"';
                    if(isset($user_detail->profile_type) && $user_detail->profile_type == $ID) {echo ' selected';}
                    echo '>' . $title . '</option>';
                }
            ?>
        </select>
    </div>
</div>

<div class="clearfix"></div>
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="name" class="col-md-12 col-sm-12 col-xs-12 control-label">Name </label>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
                <input type="text" name="name" class="form-control" id="name" placeholder="Full Name" value="{{ (isset($user_detail->name))?$user_detail->name:'' }}" required="">
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="email" class="col-md-12 col-sm-12 col-xs-12 control-label">Email </label>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
                <input type="email" name="email" class="form-control" id="email" placeholder="Email Address" value="{{ (isset($user_detail->email))?$user_detail->email:'' }}" required="">
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="email" class="col-md-12 col-sm-12 col-xs-12 control-label">Restaurant</label>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
                <select name="restaurant_id" id="restaurant_id" class="form-control">
                    <option value="">-Select-</option>
                    @foreach($restaurants_list as $value)
                        <option value="{{ $value->id }}" @if(isset($user_detail->restaurant_id) && $value->id == $user_detail->restaurant_id) selected @endif>{{ $value->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>
<div class="modal-header">
    <h4 class="modal-title">Address Information</h4>
</div>

@include("common.editaddress", array("new" => true, "dontinclude" => true))

<div class="clearfix"></div>
<div class="modal-header">
    <h4 class="modal-title">Create a Password</h4>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="password" class="col-md-12 col-sm-12 col-xs-12 control-label">New Password</label>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
                <input type="password" name="password" class="form-control" id="password" placeholder="Create Password" required>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="confirm_password" class="col-md-12 col-sm-12 col-xs-12 control-label">Re-type Password</label>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
                <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Re-type Password" required>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="subscribed" class="col-md-12 col-sm-12 col-xs-12 control-label">&nbsp;</label>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <label>
                <input type="checkbox" name="subscribed" id="subscribed" value="1" @if(isset($user_detail->subscribed) && $user_detail->subscribed == "1") checked @endif />
                Sign up for our Newsletter
            </label>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<input type="hidden" name="id" value="{{ (isset($user_detail->id))?$user_detail->id:'' }}" />
<input type="hidden" name="status" value="{{ (isset($user_detail->status))?$user_detail->status:'' }}" />
<input type="hidden" name="adid" value="{{ (isset($address_detail->id))?$address_detail->id:'' }}" />

@if(isset($address_detail->id))
    <script type="text/javascript">
        $(document).ready(function(){
               //cities("{{ url('ajax') }}", '{{ (isset($address_detail->city))?$address_detail->city:0 }}');
        });
    </script>
@endif