<?php printfile("views/common/signupform.blade.php"); ?>
@if(!read("id") || isset($user_detail))
    <div id="registration-error" class="alert alert-danger" style="display: none;"></div>

    <div class="form-group row">
        <label for="name" class="col-sm-3">Name</label>
        <div class="col-sm-9">
            <input type="text" name="name" class="form-control" id="name" placeholder="Full Name" value="{{ (isset($user_detail->name))?$user_detail->name: priority(old('name'), read('name')) }}" required="">
        </div>
    </div>

    <div class="form-group row">
        <label for="email" class="col-sm-3">Email</label>
        <div class="col-sm-9">
            <input type="email" name="email" class="form-control" id="email" placeholder="Email Address" value="{{ (isset($user_detail->email))?$user_detail->email: priority(old('email'), read('email')) }}" required="">
        </div>
    </div>

    <!--div class="form-group row">
        <label for="phone" class="col-sm-3">Phone Number</label>
        <div class="col-sm-9">
            <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone Number" value="{{ (isset($user_detail->phone))?$user_detail->phone: priority(old('phone'), read('phone')) }}">
        </div>
    </div-->

    @if(Session::has('session_id') && !isset($needsoldpassword))
        <div class="form-group row">
            <label for="password" class="col-sm-3">Old Password</label>
            <div class="col-sm-9">
                <input type="password" name="old_password" class="form-control" id="old_password" placeholder="Old Password">
            </div>
        </div>
    @endif

    <div class="form-group row">
        <label for="password" class="col-sm-3">Password</label>
        <div class="col-sm-9">
            <input type="password" name="password" class="form-control" id="password" placeholder="Password">
        </div>
    </div>

    <div class="form-group row">
        <label for="confirm_password" class="col-sm-3">Re-type Password</label>
        <div class="col-sm-9">
            <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Re-type Password">
        </div>
    </div>

    @include('common.editaddress', array("required" => false, "apartment" => true, "new" => true, "dontinclude" => true))

    <div class="form-group row">
        <div class="col-sm-12">
            <LABEL>
                <input type="checkbox" name="subscribed" id="subscribed" value="1" @if(isset($user_detail->subscribed) && $user_detail->subscribed == "1") checked @endif />
                Sign up for our Newsletter
            </LABEL>
        </div>
    </div>
@endif