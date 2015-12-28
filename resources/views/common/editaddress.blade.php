<?php
    printfile("views/common/editaddress.blade.php");
    $countries_list = \App\Http\Models\Countries::get();//load all countries
?>

<div class="form-group row">
    <label class=" col-sm-3">Street Address </label>
    <div class="col-sm-9">
        <input type="text" name="address" class="form-control" placeholder="Street address" value="{{ (isset($addresse_detail->address))?$addresse_detail->address:'' }}" required>
    </div>
</div>

<div class="form-group row">
    <label class=" col-sm-3">Postal Code</label>
    <div class="col-sm-9">
        <input type="text" name="post_code" class="form-control" placeholder="Postal Code" value="{{ (isset($addresse_detail->post_code))?$addresse_detail->post_code:'' }}">
    </div>
</div>

<div class="form-group row">
    <label class=" col-sm-3">Phone Number</label>
    <div class="col-sm-9">
        <input type="text" name="phone_no" class="form-control" placeholder="Phone Number" value="{{ (isset($addresse_detail->phone_no))?$addresse_detail->phone_no:'' }}">
    </div>
</div>

<div class="form-group row">
    <label class=" col-sm-3">Country </label>
    <div class="col-sm-9">
        <select name="country" class="form-control" id="country2" required onchange="provinces('{{ addslashes(url("ajax")) }}', '{{ (isset($addresse_detail->province))?$addresse_detail->province:'' }}');">
            <option value="">-Select One-</option>
            @foreach($countries_list as $value)
                <option value="{{ $value->id }}" {{ (isset($addresse_detail->country) && $addresse_detail->country == $value->id)? 'selected' :'' }}>{{ $value->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group row">
    <label class=" col-sm-3">Province </label>
    <div class="col-sm-9">
        <select name="province" class="form-control" id="province2" required onchange="cities('{{ addslashes(url("ajax")) }}', 'ON');">
            <option value="">-Select One-</option>
        </select>
    </div>
</div>

<div class="form-group row">
    <label class=" col-sm-3">City </label>
    <div class="col-sm-9">
        <input type="text" name="city" class="form-control" id="city2" required>
    </div>
</div>