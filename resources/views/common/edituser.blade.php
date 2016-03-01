<?php printfile("views/common/edituser.blade.php"); ?>
<script src="{{ url("assets/global/scripts/provinces.js") }}" type="text/javascript"></script>
<meta name="_token" class="csrftoken" content="{{ csrf_token() }}" />

<div class="form-group">
    <div class="col-md-12 col-sm-12 col-xs-12 row">
        <label class="control-label">User Type</label>
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

<div class="form-group">
    <div class="col-md-12 col-sm-12 col-xs-12 row">
        <label class="control-label">Restaurant</label>
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
@include('common.contactinfo', array("user_detail" => $user_detail, "needsoldpassword" => false))

<div class="clearfix"></div>

<input type="hidden" name="id" value="{{ (isset($user_detail->id))?$user_detail->id:'' }}" />
<input type="hidden" name="status" value="{{ (isset($user_detail->status))?$user_detail->status:'' }}" />
<input type="hidden" name="adid" value="{{ (isset($address_detail->id))?$address_detail->id:'' }}" />