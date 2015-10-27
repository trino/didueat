<div class="form-group">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <select name="profile_type" class="form-control">
            <option value="1" @if(isset($user_detail->profile_type) && $user_detail->profile_type == 1) selected @endif>Super</option>
            <option value="2" @if(isset($user_detail->profile_type) && $user_detail->profile_type == 2) selected @endif>User</option>
            <option value="3" @if(isset($user_detail->profile_type) && $user_detail->profile_type == 3) selected @endif>Owner</option>
            <option value="4" @if(isset($user_detail->profile_type) && $user_detail->profile_type == 4) selected @endif>Employee</option>
        </select>
    </div>
</div>

<div class="clearfix"></div>
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="name" class="col-md-12 col-sm-12 col-xs-12 control-label">Name<span class="require">*</span></label>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
                <input type="text" name="name" class="form-control" id="name" placeholder="Full Name" value="{{ (isset($user_detail->name))?$user_detail->name:'' }}" required="">
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="email" class="col-md-12 col-sm-12 col-xs-12 control-label">Email<span class="require">*</span></label>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
                <input type="email" name="email" class="form-control" id="email" placeholder="Email Address" value="{{ (isset($user_detail->email))?$user_detail->email:'' }}" required="">
            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>
<div class="modal-header">
    <h4 class="modal-title">Addressing Information</h4>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="address" class="col-md-12 col-sm-12 col-xs-12 control-label">Street Address <span class="require">*</span></label>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
                <input type="text" name="address" class="form-control" id="address" placeholder="Street Address" value="{{ (isset($address_detail->address))?$address_detail->address:'' }}" required>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="post_code" class="col-md-12 col-sm-12 col-xs-12 control-label">Postal Code <span class="require">*</span></label>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
                <input type="text" name="post_code" class="form-control" id="post_code" placeholder="Postal Code" value="{{ (isset($address_detail->post_code))?$address_detail->post_code:'' }}" required>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="city" class="col-md-12 col-sm-12 col-xs-12 control-label">City <span class="require">*</span></label>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
                <input type="text" name="city" class="form-control" id="city" placeholder="City" value="{{ (isset($address_detail->city))?$address_detail->city:'' }}" required>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="phone_no" class="col-md-12 col-sm-12 col-xs-12 control-label">Phone Number <span class="require">*</span></label>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
                <input type="text" name="phone_no" class="form-control" id="phone_no" placeholder="Phone Number" value="{{ (isset($address_detail->phone_no))?$address_detail->phone_no:'' }}" required>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="province" class="col-md-12 col-sm-12 col-xs-12 control-label">Province <span class="require">*</span></label>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
                <input type="text" name="province" class="form-control" id="province" placeholder="Province" value="{{ (isset($address_detail->province))?$address_detail->province:'' }}" required>
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
                        <option value="{{ $value->id }}" @if(isset($address_detail->country) && $address_detail->country == $value->id) selected @endif>{{ $value->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>

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

<div class="modal-footer">
    <button type="submit" class="btn red">Save changes</button>
    <input type="hidden" name="id" value="{{ (isset($user_detail->id))?$user_detail->id:'' }}" />
    <input type="hidden" name="adid" value="{{ (isset($address_detail->id))?$address_detail->id:'' }}" />
</div>
