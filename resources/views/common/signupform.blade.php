<?php printfile("views/common/signupform.blade.php"); if(!isset($new)){$new=false;} ?>
@if(!read("id") || isset($user_detail))
    <div id="registration-error" class="alert alert-danger" style="display: none;"></div>

    <?= newrow($new, "Name"); ?>
        <input type="text" name="name" class="form-control" id="name" placeholder="Full Name" value="{{ (isset($user_detail->name))?$user_detail->name: priority(old('name'), read('name')) }}" required>
    </div></div>

    <?= newrow($new, "Email"); ?>
<input type="email" name="email" class="form-control" id="email" placeholder="Email Address" value="{{ (isset($user_detail->email))?$user_detail->email: priority(old('email'), read('email')) }}" required onkeyup="validationOnkeyup()">
    </div></div>

    <!--newrow($new, "Phone Number"); ?>
            <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone Number" value="{{ (isset($user_detail->phone))?$user_detail->phone: priority(old('phone'), read('phone')) }}">
    </div></div-->

    @if(Session::has('session_id') && !isset($needsoldpassword))
        <?= newrow($new, "Old Password"); ?>
            <input type="password" name="old_password" class="form-control" id="old_password" placeholder="Old Password">
        </div></div>
    @endif

    <?= newrow($new, "Password"); ?>
        <input type="password" name="password0" class="form-control" id="password0" placeholder="Password" required onkeyup="validationOnkeyup()">
    </div></div>

    <?= newrow($new, "Re-type Password"); ?>
        <input type="password" name="confirm_password0" class="form-control" id="confirm_password0" placeholder="Re-type Password" required onkeyup="validationOnkeyup()">
    </div></div>

    <!-- include('common.editaddress', array("required" => false, "apartment" => true, "new" => $new, "dontinclude" => true)) -->

    <div class="form-group row">
        <div class="col-sm-12">
            <LABEL>
                <input type="checkbox" name="subscribed" id="subscribed" value="1" @if(isset($user_detail->subscribed) && $user_detail->subscribed == "1") checked @endif />
                Sign up for our Newsletter
            </LABEL>
        </div>
    </div>
@endif