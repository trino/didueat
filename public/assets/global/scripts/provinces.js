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
    var element = document.getElementById("country");
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



//Google Api Codes.
var placeSearch, formatted_address;

function initAutocompleteWithID(ID){
    var element = document.getElementById(ID);
    if (!element.hasAttribute("hasgeocode")) {
        var formatted_address = new google.maps.places.Autocomplete(
            (element),
            {types: ['geocode']});
        formatted_address.addListener('place_changed', fillInAddress);
        element.setAttribute("hasgeocode", true);
        return formatted_address;
    }
}

function initAutocomplete(){
    formatted_address = initAutocompleteWithID('formatted_address');
    return formatted_address;
}

function isvalid(variable, element){
    if( !isundefined(variable) ){
        var element = document.getElementById(element);
        if( element && element.value ){
            return true;
        }
    }
}

function getplace(){
    if(isvalid(formatted_address2, "formatted_address2")){ return formatted_address2; }
    if(isvalid(formatted_address3, "formatted_address3")){ return formatted_address3; }
    if(isvalid(formatted_address4, "formatted_address4")){ return formatted_address4; }
    if(isvalid(formatted_address5, "formatted_address5")){ return formatted_address5; }
    return formatted_address;
}

function fillInAddress() {
    var place = getplace().getPlace();
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

function isundefined(variable){
    return typeof variable === 'undefined';
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

function geolocate(formatted_address) {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            $('#latitude').val( position.coords.latitude );
            $('#longitude').val( position.coords.longitude );

            $.ajax({
                url: 'http://maps.googleapis.com/maps/api/geocode/json',
                type: "get",
                dataType: "HTML",
                data: 'sensor=false&latlng=' + position.coords.latitude + ',' + position.coords.longitude,
                success: function(msg) {
                    var data = JSON.parse(msg);
                    data = data.results[0].formatted_address;
                    $(".formatted_address").val(data);
                    $(".formatted_address").attr("title", position.coords.latitude + ',' + position.coords.longitude)
                    $(".formatted_address").trigger("change");
                }
            });

            var circle = new google.maps.Circle({
                center: geolocation,
                radius: position.coords.accuracy
            });
            formatted_address.setBounds(circle.getBounds());
        });
    }
}
