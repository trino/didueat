<?php
if (!function_exists("priority")) {
    function priority($Alpha, $Beta = false)
    {
        if ($Alpha) {
            return $Alpha;
        }
        if ($Beta) {
            return $Beta;
        }
        return "";
    }
}
$fullname = priority(old('name'), read('name'));
$emailaddress = priority(old('email'), read('email'));
$phonenumber = priority(old('phone'), read('phone'));
?>
<h1>Sign up</h1>

<div id="registration-error" class="alert alert-danger" style="display: none;"></div>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="name" class="col-md-12 col-sm-12 col-xs-12 control-label">Name <span class="require">*</span></label>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
                <input type="text" name="name" class="form-control" id="name" placeholder="Full Name" value="<?= $fullname; ?>" required="">
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="email" class="col-md-12 col-sm-12 col-xs-12 control-label">Email <span class="require">*</span></label>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
                <input type="email" name="email" class="form-control" id="email" placeholder="Email Address" value="<?= $emailaddress; ?>" required="">
            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>
<h1>Addressing Information</h1>

<!--<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="address" class="col-md-12 col-sm-12 col-xs-12 control-label">Street Address <span class="require">*</span></label>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
                <input type="text" name="address" class="form-control" id="address" placeholder="Street Address" value="" required>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="post_code" class="col-md-12 col-sm-12 col-xs-12 control-label">Postal Code <span class="require">*</span></label>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
                <input type="text" name="post_code" class="form-control" id="post_code" placeholder="Postal Code" value="" required>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="city" class="col-md-12 col-sm-12 col-xs-12 control-label">City <span class="require">*</span></label>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
                <input type="text" name="city" class="form-control" id="city" placeholder="City" value="" required>
            </div>
        </div>
    </div>
</div>-->

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="phone_no" class="col-md-12 col-sm-12 col-xs-12 control-label">Phone Number</label>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
                <input type="text" name="phone_no" class="form-control" id="phone_no" placeholder="Phone Number" value="">
            </div>
        </div>
    </div>
</div>

<!--<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="province" class="col-md-12 col-sm-12 col-xs-12 control-label">Province <span class="require">*</span></label>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
                <input type="text" name="province" class="form-control" id="province" placeholder="Province" value="" required>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="country" class="col-md-12 col-sm-12 col-xs-12 control-label">Country <span class="require">*</span></label>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
                <select name="country" id="country" class="form-control" required>
                    <option value="">-Select One-</option>
                    @foreach(select_field_where('countries', '', false, "name", $Dir = "ASC", "") as $value)
                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>-->

<div class="clearfix"></div>
<h1>Create Password</h1>

@if(Session::has('session_id'))
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="password" class="col-md-12 col-sm-12 col-xs-12 control-label">Old Password<span class="require">*</span></label>

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
        <label for="password" class="col-md-12 col-sm-12 col-xs-12 control-label">Choose Password<span class="require">*</span></label>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
                <input type="password" name="password" class="form-control" id="password" placeholder="Password">
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="confirm_password" class="col-md-12 col-sm-12 col-xs-12 control-label">Re-type Password<span class="require">*</span></label>

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