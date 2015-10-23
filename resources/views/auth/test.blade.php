<?php $APIkey = "AIzaSyAwyeePUZrNGd1UMUd5T1WDfBLSeaQ5ids"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Place Autocomplete Address Form</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        #map { height: 100%; }
    </style>
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
    <style>
        #locationField, #controls {
            position: relative;
            width: 480px;
        }
        #autocomplete {
            position: absolute;
            top: 0px;
            left: 0px;
            width: 99%;
        }
        .label {
            text-align: right;
            font-weight: bold;
            width: 100px;
            color: #303030;
        }
        #address {
            border: 1px solid #000090;
            background-color: #f0f0ff;
            width: 480px;
            padding-right: 2px;
        }
        #address td {
            font-size: 10pt;
        }
        .field {
            width: 99%;
        }
        .slimField {
            width: 80px;
        }
        .wideField {
            width: 200px;
        }
        #locationField {
            height: 20px;
            margin-bottom: 2px;
        }
    </style>
</head>

<body>
<div id="locationField">
    <input id="autocomplete" placeholder="Enter your address" onFocus="geolocate()" type="text"></input>
</div>

<table id="address">
    <tr>
        <td class="label">Street address</td>
        <td class="slimField"><input class="field" id="street_number" disabled="true"></input></td>
        <td class="wideField" colspan="2"><input class="field" id="route" disabled="true"></input></td>
    </tr>
    <tr>
        <td class="label">City</td>
        <td class="wideField" colspan="3"><input class="field" id="locality" disabled="true"></input></td>
    </tr>
    <tr>
        <td class="label">State</td>
        <td class="slimField"><input class="field" id="administrative_area_level_1" disabled="true"></input></td>
        <td class="label">Zip code</td>
        <td class="wideField"><input class="field" id="postal_code" disabled="true"></input></td>
    </tr>
    <tr>
        <td class="label">Country</td>
        <td class="wideField" colspan="3"><input class="field" id="country" disabled="true"></input></td>
    </tr>
</table>

<script>
    var placeSearch, autocomplete;
    var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
    };

    function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
                /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
                {types: ['geocode']});
        autocomplete.addListener('place_changed', fillInAddress);
    }

    // [START region_fillform]
    function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

        for (var component in componentForm) {
            document.getElementById(component).value = '';
            document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (componentForm[addressType]) {
                var val = place.address_components[i][componentForm[addressType]];
                document.getElementById(addressType).value = val;
            }
        }
    }
    // [END region_fillform]

    // [START region_geolocation]
    // Bias the autocomplete object to the user's geographical location,
    // as supplied by the browser's 'navigator.geolocation' object.
    function geolocate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var geolocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                var circle = new google.maps.Circle({
                    center: geolocation,
                    radius: position.coords.accuracy
                });
                autocomplete.setBounds(circle.getBounds());
            });
        }
    }
    // [END region_geolocation]

    //FUNCTION TO LOAD THE GOOGLE MAPS API
    function loadScript() {
        var script  = document.createElement("script");
        script.type = "text/javascript";
        script.src  = "http://maps.googleapis.com/maps/api/js?key=<?= $APIkey; ?>&sensor=false&callback=initialize";
        document.body.appendChild(script);
    }
    //FUNCTION TO INITIALIZE THE GOOGLE MAP
    function initialize() {
        var mapOptions = {
            zoom:      8,
            center:    new google.maps.LatLng(43.2500, -79.8667),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
    }

    function getdistance(PointA, PointB){
        //INITIALIZE GLOBAL VARIABLES
        var zipCodesToLookup = new Array(PointA, PointB);
        var output           = '<tr><th scope="col">From</th><th scope="col">To</th><th scope="col">KM</th></tr>';

        //EXECUTE THE DISTANCE MATRIX QUERY
        var service = new google.maps.DistanceMatrixService();
        service.getDistanceMatrix({
            origins:      zipCodesToLookup,
            destinations: zipCodesToLookup,
            travelMode:   google.maps.TravelMode.DRIVING,
            unitSystem:   google.maps.UnitSystem.METRIC
        }, function(response, status) {
            //...response processed here...//
            if(status == google.maps.DistanceMatrixStatus.OK) {
                var origins = response.originAddresses;
                var destinations = response.destinationAddresses;
                var distance = 0;
                for(var i=0; i < origins.length; i++) {
                    var results = response.rows[i].elements;
                    for(var j=0; j < results.length; j++) {
                        output += '<tr><td>' + origins[i] + '</td><td>' + destinations[j] + '</td><td>' + results[j].distance.text + '</td></tr>';
                        distance += results[j].distance.value;
                    }
                }
                distance = distance/1000;//convert to KM
                document.getElementById('zip_code_output').innerHTML = '<table cellpadding="5">' + output + '<TR><TD COLSPAN=2>Total Distance</TD><TD>' + distance.toFixed(2) + ' km</TD></TR></table>';
            }
        });
    }

    function getvalue(ID){
        return document.getElementById(ID).value;
    }
    window.onload = loadScript;
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?= $APIkey; ?>&signed_in=true&libraries=places&callback=initAutocomplete" async defer></script>
<div id="zip_code_output"></div><div id="map_canvas" style="width:650px; height:600px;"></div>
<INPUT TYPE="TEXT" ID="pointa" placeholder="Start" value="L8L6V6"><INPUT TYPE="TEXT" ID="pointb" placeholder="End" value="L7P3C3">
<INPUT TYPE="BUTTON" VALUE="Get Distance" ONCLICK="getdistance(getvalue('pointa'), getvalue('pointb'));" />
</body>
</html>