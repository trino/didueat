function getelement(name) {
    var element = document.getElementById(name + "2");
    if (element) {
        return element;
    }
    var element = document.getElementById(name);
    return element;
}

function provinces(webroot, value) {
    var country = 40; //Canada
    var element = getelement("country");
    if (element) {
        country = element.value;
        if (isNaN(country)) {
            return false;
        }
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name=_token]').attr('content')
        }
    });

    $.ajax({
        url: webroot,
        type: "post",
        dataType: "HTML",
        data: "type=provinces&country=" + country + "&value=" + value,
        success: function(msg) {
            element = getelement("province");
            element.innerHTML = msg;
        }
    });
}

function cities(webroot, value) {
    var province = 7; //Canada
    var element = getelement("province");
    if (element) {
        province = element.value;
        if (isNaN(province)) {
            return false;
        }
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name=_token]').attr('content')
        }
    });

    $.ajax({
        url: webroot,
        type: "post",
        dataType: "HTML",
        data: "type=cities&province=" + province + "&value=" + value,
        success: function(msg) {
            element = getelement("city");
            element.innerHTML = msg;
        }
    });
}

$(document).ready(function() {
    var element = getelement("country");
    if (element) {
        var evnt = element["onchange"];
        if (typeof(evnt) == "function") {
            evnt.call(element);
        }
    }
});

//Google Api Codes.
var placeSearch, formatted_address;

function initAutocompleteWithID(ID){
    var formatted_address = new google.maps.places.Autocomplete(
        (document.getElementById(ID)),
        {types: ['geocode']});
    formatted_address.addListener('place_changed', fillInAddress);
    alert("INIT'd " + ID);
    return formatted_address;
}

function initAutocomplete(){
    formatted_address = initAutocompleteWithID('formatted_address');
}

function fillInAddress() {
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
    $('#rout_street_number').val('');
    $('#postal_code').val('');
    provinces('{{ addslashes(url("ajax")) }}', '');
    //$("#province option").attr("selected", false);

    for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];
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
                $('#rout_street_number').val(val);
            }
            if(addressType == "route"){
                if($('#rout_street_number').val() != ""){
                    $('#rout_street_number').val($('#rout_street_number').val()+", "+val);
                } else {
                    $('#rout_street_number').val(val);
                }
            }
        }
    }
    return place;
}

function getplace(ID){
    alert("TESTING FOR: " + initAutocomplete());
    alert(simpleStringify(fillInAddress()));
}

function simpleStringify (object){
    var simpleObject = {};
    for (var prop in object ){
        if (!object.hasOwnProperty(prop)){
            continue;
        }
        if (typeof(object[prop]) == 'object'){
            continue;
        }
        if (typeof(object[prop]) == 'function'){
            continue;
        }
        simpleObject[prop] = object[prop];
    }
    return JSON.stringify(simpleObject); // returns cleaned up JSON
};

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
            formatted_address.setBounds(circle.getBounds());
        });
    }
}