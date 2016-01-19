<?php printfile("views/ajax/addresse_edit.blade.php"); ?>

<div id="message" class="alert alert-danger" style="display: none;">
    <h1 class="block">Error</h1>
</div>

{!! Form::open(array('url' => 'user/addresses/', 'id'=>'addressesEditForm', 'class'=>'form-horizontal','method'=>'post','role'=>'form')) !!}

<!--div class="form-group row">
    <label class=" col-sm-3">Address</label>
    <div class="col-sm-9">
        <input type="text" name="location" class="form-control" placeholder="Address" value="{{ (isset($addresse_detail->location))? $addresse_detail->location : old('location') }}">
    </div>
</div>
<div class="form-group row">
    <label class=" col-sm-3">Format Address</label>
    <div class="col-sm-9">
        <input type="text" name="formatted_address" id="formatted_address" class="form-control" placeholder="Address, City or Postal Code" value="{{ (isset($addresse_detail->formatted_address))? $addresse_detail->formatted_address : old('formatted_address') }}" onkeyup="geolocate()">
    </div>
</div>
<div class="form-group row">
    <label class=" col-sm-3">Street Address</label>
    <div class="col-sm-9">
        <input type="text" id="rout_street_number" name="address" class="form-control" placeholder="" value="{{ (isset($addresse_detail->address))?$addresse_detail->address: old('address') }}" required>
    </div>
</div>
<div class="form-group row">
    <label class=" col-sm-3">Postal Code</label>
    <div class="col-sm-9">
        <input type="text" name="postal_code" id="postal_code" class="form-control" placeholder="" value="{{ (isset($addresse_detail->postal_code))?$addresse_detail->postal_code: old('postal_code') }}">
    </div>
</div>
<div class="form-group row">
    <label class=" col-sm-3">Phone Number</label>
    <div class="col-sm-9">
        <input type="number" name="phone" class="form-control" placeholder="" value="{{ (isset($addresse_detail->phone))?$addresse_detail->phone: old('phone') }}">
    </div>
</div>
<div class="form-group row">
    <label class=" col-sm-3">Cell Phone</label>
    <div class="col-sm-9">
        <input type="number" name="mobile" class="form-control" placeholder="" value="{{ (isset($addresse_detail->mobile))?$addresse_detail->mobile: old('mobile') }}">
    </div>
</div>
<div class="form-group row">
    <label class=" col-sm-3">Country</label>
    <div class="col-sm-9">
        <select name="country" id="country" class="form-control" required onchange="provinces('{{ addslashes(url("ajax")) }}', '{{ (isset($addresse_detail->province))? $addresse_detail->province : old('province') }}');">
            <option value="">Select Country</option>
            @foreach(select_field_where('countries', '', false, 'name', 'ASC') as $value)
                <option value="{{ $value->id }}" {{ (isset($addresse_detail->country) && $addresse_detail->country == $value->id)? 'selected' :'' }}>{{ $value->name }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group row">
    <label class=" col-sm-3">Province</label>
    <div class="col-sm-9">
        <input type="text" id="province" name="province" class="form-control" {{$required}} value="{{ (isset($addresse_detail->province))?$addresse_detail->province:old('province') }}">
    </div>
</div>
<div class="form-group row">
    <label class=" col-sm-3">City </label>
    <div class="col-sm-9">
        <input type="text" id="city" name="city" class="form-control" id="city2" required value="{{ (isset($addresse_detail->city))?$addresse_detail->city:old('city') }}">
    </div>
</div-->

<?php echo view("common.editaddress", array("addresse_detail" => $addresse_detail, "apartment" => true, "dontinclude" => true)); ?>

<input type="hidden" name="id" value="{{ (isset($addresse_detail->id))?$addresse_detail->id:'' }}" />
<input type="hidden" name="latitude" id="latitude" value=""/>
<input type="hidden" name="longitude" id="longitude" value=""/>
{!! Form::close() !!}
<div class="clearfix"></div>

<script type="text/javascript">
// This example displays an address form, using the formatted_address feature
// of the Google Places API to help users fill in the information.

var placeSearch, formatted_address;
var componentForm = {
  street_number: 'short_name',
  route: 'long_name',
  locality: 'long_name',
  administrative_area_level_1: 'short_name',
  country: 'long_name',
  postal_code: 'short_name'
};

function initAutocomplete() {
  // Create the formatted_address object, restricting the search to geographical
  // location types.
  formatted_address = new google.maps.places.Autocomplete(
      /** @type {!HTMLInputElement} */(document.getElementById('formatted_address')),
      {types: ['geocode']});

  // When the user selects an address from the dropdown, populate the address
  // fields in the form.
  formatted_address.addListener('place_changed', fillInAddress);
}

// [START region_fillform]
function fillInAddress() {
    // Get the place details from the formatted_address object.
    var place = formatted_address.getPlace();
    var lat = place.geometry.location.lat();
    var lng = place.geometry.location.lng();
    $('#latitude').val(lat);
    $('#longitude').val(lng);
    var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'long_name',
        country: 'long_name',
        postal_code: 'short_name'
    };
    $('#city').val('');
    //$('#rout_street_number').val('');
    $('#postal_code').val('');
    //provinces('{{ addslashes(url("ajax")) }}', '');

    for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];

        //alert(addressType +  " is not on record, is: ");

        if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            if(addressType == "country"){
                $("#country  option").filter(function() {
                    return this.text == val;
                }).attr('selected', true);
            }
            if(addressType == "administrative_area_level_1"){
                $("#province option").filter(function() {
                    return this.text == val;
                }).attr('selected', true);
            }
            if(addressType == "locality"){
                $('#city').val(val);
            }
            if(addressType == "postal_code"){
                $('#postal_code').val(val);
            }
            if(addressType == "street_number"){
                $('#formatted_address').val(val);
            }
            if(addressType == "route"){
                if($('#formatted_address').val() != ""){
                    $('#formatted_address').val($('#formatted_address').val()+", "+val);
                } else {
                    $('#formatted_address').val(val);
                }
            }
        }
    }
    return place;
}
// [END region_fillform]

// [START region_geolocation]
// Bias the formatted_address object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position){
      var geolocation = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };
      var circle = new google.maps.Circle({
        center: geolocation,
        radius: position.coords.accuracy
      });
      formatted_address.setBounds(circle.getBounds());
    });
  } else {
      alert("Your browser does not support geolocation");
  }
}
// [END region_geolocation]
</script>
<script src="https://maps.googleapis.com/maps/api/js?signed_in=true&libraries=places&callback=initAutocomplete" async defer></script>

<!--<script src="{{ url("assets/global/scripts/provinces.js") }}" type="text/javascript"></script>-->
