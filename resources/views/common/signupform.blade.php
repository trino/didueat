<?php printfile("views/common/signupform.blade.php"); ?>
<h1>Sign up</h1>
<div id="registration-error" class="alert alert-danger" style="display: none;"></div>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="name" class="col-md-12 col-sm-12 col-xs-12 control-label">Name <span class="required">*</span></label>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
                <input type="text" name="name" class="form-control" id="name" placeholder="Full Name" value="{{ priority(old('name'), read('name')) }}" required="">
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="email" class="col-md-12 col-sm-12 col-xs-12 control-label">Email <span class="required">*</span></label>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
                <input type="email" name="email" class="form-control" id="email" placeholder="Email Address" value="{{ priority(old('email'), read('email')) }}" required="">
            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>
<h1>Addressing Information</h1>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="phone_no" class="col-md-12 col-sm-12 col-xs-12 control-label">Phone Number</label>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
                <input type="text" name="phone_no" class="form-control" id="phone_no" placeholder="Phone Number" value="{{ priority(old('phone_no'), read('phone')) }}">
            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>
<h1>Create Password</h1>

@if(Session::has('session_id'))
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="password" class="col-md-12 col-sm-12 col-xs-12 control-label">Old Password <span class="required">*</span></label>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
                <input type="password" name="old_password" class="form-control" id="old_password" placeholder="Old Password">
            </div>
        </div>
    </div>
</div>
@endif

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="password" class="col-md-12 col-sm-12 col-xs-12 control-label">Choose Password <span class="required">*</span></label>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
                <input type="password" name="password" class="form-control" id="password" placeholder="Password">
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="confirm_password" class="col-md-12 col-sm-12 col-xs-12 control-label">Re-type Password <span class="required">*</span></label>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
                <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Re-type Password">
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="subscribed" class="col-md-12 col-sm-12 col-xs-12 control-label">&nbsp;</label>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <label>
                <input type="checkbox" name="subscribed" id="subscribed" value="1" />
                Sign up for our Newsletter
            </label>
        </div>
    </div>
</div>