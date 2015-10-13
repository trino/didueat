<?php
    if(!function_exists("priority")){
        function priority($Alpha, $Beta = false){
            if($Alpha){return $Alpha;}
            if($Beta){return $Beta;}
            return "";
        }
    }
    $fullname = priority(old('name'), read('name'));
    $emailaddress = priority(old('email'), read('email'));
    $phonenumber = priority(old('phone'), read('phone'));
?>
<div class="alert alert-danger display-hide">
    <button class="close" data-close="alert"></button>
    You have some form errors. Please check below.
</div>
<div class="alert alert-success display-hide">
    <button class="close" data-close="alert"></button>
    Your form validation is successful!
</div>
<div class="form-group">
    <label for="name" class="col-md-2 col-sm-2 col-xs-4 control-label">Name<span class="require">*</span></label>
    <div class="col-md-10 col-sm-10 col-xs-8">
        <div class="input-icon">
            <i class="fa fa-user"></i>
            <input type="text" name="name" class="form-control" id="name" placeholder="Full Name" value="<?= $fullname; ?>" required="">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="phone" class="col-md-2 col-sm-2 col-xs-4 control-label">Phone<span class="require">*</span></label>
    <div class="col-md-10 col-sm-10 col-xs-8">
        <div class="input-icon">
            <i class="fa fa-phone"></i>
            <input type="number" name="phone" class="form-control" id="phone" placeholder="Phone number" value="<?= $phonenumber; ?>" required="">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="email" class="col-md-2 col-sm-2 col-xs-4 control-label">Email<span class="require">*</span></label>
    <div class="col-md-10 col-sm-10 col-xs-8">
        <div class="input-icon">
            <i class="fa fa-envelope"></i>
            <input type="email" name="email" class="form-control" id="email" placeholder="Email Address" value="<?= $emailaddress; ?>" required="">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="password" class="col-md-2 col-sm-2 col-xs-4 control-label">Password<span class="require">*</span></label>
    <div class="col-md-10 col-sm-10 col-xs-8">
        <div class="input-icon">
            <i class="fa fa-key"></i>
            <input type="password" name="password" class="form-control" id="password" placeholder="Password" required="">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="confirm_password" class="col-md-2 col-sm-2 col-xs-4 control-label">Re-type Password<span class="require">*</span></label>
    <div class="col-md-10 col-sm-10 col-xs-8">
        <div class="input-icon">
            <i class="fa fa-key"></i>
            <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Re-type Password" required="">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="subscribed" class="col-md-2 col-sm-2 col-xs-4 control-label">&nbsp;</label>
    <div class="col-md-10 col-sm-10 col-xs-8">
        <label>
            <input type="checkbox" name="subscribed" id="subscribed" value="1" <?php
                if(read('subscribed')) { echo ' checked';}
            ?>>
            Sign up for our Newsletter
        </label>
    </div>
</div>