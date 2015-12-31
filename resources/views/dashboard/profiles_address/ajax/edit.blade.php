<?php printfile("views/ajax/addresse_edit.blade.php"); ?>

<div id="message" class="alert alert-danger" style="display: none;">
    <h1 class="block">Error</h1>
</div>

{!! Form::open(array('url' => 'user/addresses/', 'id'=>'addressesEditForm', 'class'=>'form-horizontal','method'=>'post','role'=>'form')) !!}

<div class="form-group row">
    <label class=" col-sm-3">Location Name</label>
    <div class="col-sm-9">
        <input type="text" name="location" class="form-control" placeholder="Location Name" value="{{ (isset($addresse_detail->location))? $addresse_detail->location : old('location') }}">
    </div>
</div>
<!--<div class="form-group row">
    <label class=" col-sm-3">Format Address</label>
    <div class="col-sm-9">
        <input type="text" name="formatted_address" id="formatted_address" class="form-control" placeholder="Address, City or Postal Code" value="{{ (isset($addresse_detail->formatted_address))? $addresse_detail->formatted_address : old('formatted_address') }}" onFocus="geolocate()" autocomplete="off">
    </div>
</div>-->
<div class="form-group row">
    <label class=" col-sm-3">Street Address</label>
    <div class="col-sm-9">
        <input type="text" id="rout_street_number" name="address" class="form-control" placeholder="Street address" value="{{ (isset($addresse_detail->address))?$addresse_detail->address: old('address') }}" required>
    </div>
</div>
<div class="form-group row">
    <label class=" col-sm-3">Postal Code</label>
    <div class="col-sm-9">
        <input type="text" name="postal_code" id="postal_code" class="form-control" placeholder="Postal Code" value="{{ (isset($addresse_detail->postal_code))?$addresse_detail->postal_code: old('postal_code') }}">
    </div>
</div>
<div class="form-group row">
    <label class=" col-sm-3">Phone Number</label>
    <div class="col-sm-9">
        <input type="text" name="phone" class="form-control" placeholder="Phone Number" value="{{ (isset($addresse_detail->phone))?$addresse_detail->phone: old('phone') }}">
    </div>
</div>
<div class="form-group row">
    <label class=" col-sm-3">Mobile Number</label>
    <div class="col-sm-9">
        <input type="text" name="mobile" class="form-control" placeholder="Mobile Number" value="{{ (isset($addresse_detail->mobile))?$addresse_detail->mobile: old('mobile') }}">
    </div>
</div>
<div class="form-group row">
    <label class=" col-sm-3">Country</label>
    <div class="col-sm-9">
        <select name="country" id="country" class="form-control" id="country2" required onchange="provinces('{{ addslashes(url("ajax")) }}', '{{ (isset($addresse_detail->province))?$addresse_detail->province: old('province') }}');">
            <option value="">-Select One-</option>
            @foreach(select_field_where('countries', '', false, 'name', 'ASC') as $value)
                <option value="{{ $value->id }}" {{ (isset($addresse_detail->country) && $addresse_detail->country == $value->id)? 'selected' :'' }}>{{ $value->name }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group row">
    <label class=" col-sm-3">Province</label>
    <div class="col-sm-9">
        <select name="province" id="province" class="form-control" id="province2" required>
            <option value="">-Select One-</option>
        </select>
    </div>
</div>

<div class="form-group row">
    <label class=" col-sm-3">City </label>
    <div class="col-sm-9">
        <input type="text" id="city" name="city" class="form-control" id="city2" required value="{{ (isset($addresse_detail->city))?$addresse_detail->city:old('city') }}">
    </div>
</div>

<?php //echo view("common.editaddress", array("addresse_detail" => $addresse_detail)); ?>

<div class="form-group row">
    <label class=" col-sm-3">Apartment </label>
    <div class="col-sm-9">
        <input type="text" name="apartment" class="form-control" placeholder="Apartment" value="{{ (isset($addresse_detail->apartment))?$addresse_detail->apartment:'' }}" required>
    </div>
</div>

<div class="form-group row">
    <label class=" col-sm-3">Buzz Code </label>
    <div class="col-sm-9">
        <input type="text" name="buzz" class="form-control" placeholder="Buzz Code" value="{{ (isset($addresse_detail->buzz))?$addresse_detail->buzz:'' }}" required>
    </div>
</div>

<button type="submit" class="btn btn-primary pull-right">Submit</button>
<button type="button" class="btn btn-secondary pull-right" data-dismiss="modal">Close</button>

<input type="hidden" name="id" value="{{ (isset($addresse_detail->id))?$addresse_detail->id:'' }}"/>
{!! Form::close() !!}
<div class="clearfix"></div>

<script src="{{ url("assets/global/scripts/provinces.js") }}" type="text/javascript"></script>
<!--<script src="https://maps.googleapis.com/maps/api/js?signed_in=true&libraries=places&callback=initAutocomplete" async defer></script>-->