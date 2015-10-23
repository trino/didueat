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

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="name" class="col-md-12 col-sm-12 col-xs-12 control-label">Name<span class="require">*</span></label>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
                <i class="fa fa-user"></i>
                <input type="text" name="name" class="form-control" id="name" placeholder="Full Name"
                       value="<?= $fullname; ?>" required="">
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="phone" class="col-md-12 col-sm-12 col-xs-12 control-label">Phone<span
                    class="require">*</span></label>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
                <i class="fa fa-phone"></i>
                <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone number"
                       value="<?= $phonenumber; ?>" required="">
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="email" class="col-md-12 col-sm-12 col-xs-12 control-label">Email<span
                    class="require">*</span></label>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
                <i class="fa fa-envelope"></i>
                <input type="email" name="email" class="form-control" id="email" placeholder="Email Address"
                       value="<?= $emailaddress; ?>" required="">
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i> Change Password
        </div>
    </div>

    <div class="form-group clearfix">
        <label for="password" class="col-md-12 col-sm-12 col-xs-12 control-label">Old Password<span
                    class="require">*</span></label>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
                <i class="fa fa-key"></i>
                <input type="password" name="old_password" class="form-control" id="old_password"
                       placeholder="Old Password">
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="password" class="col-md-12 col-sm-12 col-xs-12 control-label">New Password<span
                    class="require">*</span></label>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
                <i class="fa fa-key"></i>
                <input type="password" name="password" class="form-control" id="password" placeholder="Password">
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="confirm_password" class="col-md-12 col-sm-12 col-xs-12 control-label">Re-type Password<span
                    class="require">*</span></label>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
                <i class="fa fa-key"></i>
                <input type="password" name="confirm_password" class="form-control" id="confirm_password"
                       placeholder="Re-type Password">
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="subscribed" class="col-md-12 col-sm-12 col-xs-12 control-label">&nbsp;</label>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <label>
                <input type="checkbox" name="subscribed" id="subscribed" value="1" <?php if (read('subscribed')) {
                    echo ' checked';
                } ?> />
                Sign up for our Newsletter
            </label>
        </div>
    </div>
</div>