<?php printfile("views/ajax/addresse_edit.blade.php"); ?>

<div id="message" class="alert alert-danger" style="display: none;">
    <h1 class="block">Error</h1>
</div>

{!! Form::open(array('url' => 'user/addresses/', 'id'=>'addressesEditForm', 'class'=>'form-horizontal','method'=>'post','role'=>'form', 'autocomplete' => 'false')) !!}
    <?php echo view("common.editaddress", array("addresse_detail" => $addresse_detail, "apartment" => true, "dontinclude" => true, "restSignUp" => false)); ?>

    <input type="hidden" name="id" value="{{ (isset($addresse_detail->id))?$addresse_detail->id:'' }}" />
    <input type="hidden" name="latitude" id="latitude" value="{{ (isset($addresse_detail->latitude))?$addresse_detail->latitude: old('latitude') }}"/>
    <input type="hidden" name="longitude" id="longitude" value="{{ (isset($addresse_detail->longitude))?$addresse_detail->longitude: old('longitude') }}"/>
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
    console.log("edit.blade@fillInAddress");
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
            if(addressType == "formatted_address"){
                $('#formatted_addressForDB').val(val);
            }
            if(addressType == "formatted_address"){
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
