<div class="my-navbar">
  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"
                aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{ url('restaurants') }}"><img src="{{ asset('assets/images/logos/logo.png') }}" alt="DidUEat?"/></a>
      </div>



      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        @if( (Request::path() == 'restaurants' || (isset($slug) && Request::path() == 'restaurants/' . $slug . '/menus')) )
        <ul class="nav navbar-nav">
          <li id="top-address-search-input">
            <input name="addressInput" type="text" id="addressInput" class="form-control address-input" placeholder="Address, City or Postal Code"
                   value="{{ $userAddress }}">
          </li>
          <li id="top-address-search-select">
            <select id="radiusSelect" class="topbar-select" onchange="radiusChng(this.value)">
              <option value="1">1 km</option>
              <option value="2">2 km</option>
              <option value="5">5 km</option>
              <option value="10">10 km</option>
              <option value="20">20 km</option>
            </select>
          </li>
          <li id="top-address-search-submit">
            <input class="btn btn-default nearby-res-btn" id="searchBtn" type="button" title="Click to Search" onclick="addressChngd()"
                   value="Find Nearby Restaurants">
          </li>
        </ul>
        @endif
        <ul class="nav navbar-nav navbar-right">
          @if(Session::has('is_logged_in'))
            <li><a href="{{ url('dashboard') }}">Hi, {{ explode(' ', Session::get('session_name'))[0] }}
                <img src="<?php
                $Image = asset('assets/images/default.png');
                if (Session::has('session_photo')) {
                  if (Session::get('session_photo')) {
                    $Image = asset('assets/images/users/' . Session::get('session_photo'));
                  }
                }
                echo $Image;
                ?>" id="avatarImage"></a>
            </li>
            <li><a href="{{ url('auth/logout') }}">Log Out</a></li>
          @else
            <li><a href="#login-pop-up" class="fancybox-fast-view">Log In</a></li>
          @endif
        </ul>
      </div><!-- /.navbar-collapse -->


    </div><!-- /.container-fluid -->
  </nav>
</div>


<script src="https://maps.googleapis.com/maps/api/js?signed_in=true&libraries=places&callback=initAutocomplete" async defer></script>
<script>
    <?php
    if(!isset($radiusSelect) || $radiusSelect == "") {
        $radiusSelect = 2;
    }
    ?>
    var radiusSelectV =<?php echo $radiusSelect; ?>;
  var radObj = document.getElementById('radiusSelect');
  if (radObj){
  for (var i = 0; i < radObj.length; i++) {
    if (radObj.options[i].value == radiusSelectV) {
      radObj.selectedIndex = i;
      break;
    }
  }
}

  var placeSearch, autocomplete;
  var componentForm = {
    locality: 'long_name',
    administrative_area_level_1: 'short_name',
    country: 'long_name',
    postal_code: 'short_name',
  }; // locality = city; administrative_area_level_1 = state/prov


  function fillInAddress() {

    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({address: document.getElementById('addressInput').value}, function (results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        // retrieves from browser geopositioning function, if enabled and available
        var latlngSpl = results[0].geometry.location.toString().split(",")
        thisLat = latlngSpl[0].substring(1);
        thisLng = latlngSpl[1].substring(0, latlngSpl[1].length - 1);
      }

    });

    // Get the place details from the autocomplete object.
    var place = autocomplete.getPlace();

    // Get each component of the address from the place details
    for (var i = 0; i < place.address_components.length; i++) {
      var addressType = place.address_components[i].types[0];
      if (addressType == "locality") {
        thisCity = place.address_components[i][componentForm[addressType]];
        continue;
      }
      if (addressType == "administrative_area_level_1") {
        thisState = place.address_components[i][componentForm[addressType]];
        continue;
      }
      if (addressType == "country") {
        thisCountry = place.address_components[i][componentForm[addressType]];
        continue;
      }
      if (addressType == "postal_code") {
        thisPostal = place.address_components[i][componentForm[addressType]];
      }
    }

    searchLocationsNear(thisLat, thisLng, thisCity, thisState, thisPostal, thisCountry);

  }


  function initAutocomplete() {
    // Create the autocomplete object, restricting the search to geographical
    // location types.
    autocomplete = new google.maps.places.Autocomplete(
      /** @type {!HTMLInputElement} */(document.getElementById('addressInput')),
      {types: ['geocode']});

    // When the user selects an address from the dropdown, populate the address
    // fields in the form.
    autocomplete.addListener('place_changed', fillInAddress);
  }

  function radiusChng(v) {
    if (thisLat != "" && thisLng != "") {
      searchLocationsNear(thisLat, thisLng, thisCity, thisState, thisPostal, thisCountry)
    }
    ////
  }
</script>