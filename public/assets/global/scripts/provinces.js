function getelement(name) {
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
$('#formatted_address, #formatted_address1, #formatted_address2, #formatted_address3, #formatted_address4').keydown(function (e) {
  if (e.which == 13 && $('.pac-container:visible').length) return false;
});
$('#formatted_address, #formatted_address1, #formatted_address2, #formatted_address3, #formatted_address4').change(function () {
  return false;
});

var placeSearch, formatted_address;

function initAutocompleteWithID(ID){
    console.log("initAutocompleteWithID: " + ID);
    var element = document.getElementById(ID);
    if(element)
    if (!element.hasAttribute("hasgeocode")) {
        var formatted_address = new google.maps.places.Autocomplete(
            (element),
      {
		      types: ['geocode'],
		      componentRestrictions: {country: "ca"}
      });
        formatted_address.addListener('place_changed', fillInAddress);
        element.setAttribute("hasgeocode", true);
        return formatted_address;
    }
}

function initAutocomplete(){
    console.log("initAutocomplete");
    formatted_address = new google.maps.places.Autocomplete(
      /** @type {!HTMLInputElement} */(document.getElementById('formatted_address')),
      {
		      types: ['geocode'],
		      componentRestrictions: {country: "ca"}
      });

    // When the user selects an address from the dropdown, populate the address
    // fields in the form.
    formatted_address.addListener('place_changed', fillInAddress1);
}

function isvalid(variable, element){
    if( !isundefined(variable) && $("#" + element).is(':visible') ){
        var element = document.getElementById(element);
        if( element && element.value ){
            return true;
        }
    }
}

function getplace(){
    if(isvalid(formatted_address, "formatted_address")){ return formatted_address; }
    if(isvalid(formatted_address2, "formatted_address2")){ return formatted_address2; }
    if(isvalid(formatted_address3, "formatted_address3")){ return formatted_address3; }
    if(isvalid(formatted_address4, "formatted_address4")){ return formatted_address4; }
    if(isvalid(formatted_address5, "formatted_address5")){ return formatted_address5; }
    return formatted_address;
}

function fillInAddress1() {
    //this should be merged with fillInAddress, there should be no duplicate code
    // Get the place details from the formatted_address object.
    var place = formatted_address.getPlace();
    var lat = place.geometry.location.lat();
    var lng = place.geometry.location.lng();    
    
    if(!isundefined(formatted_address)){
        $('#formatted_addressForDB').val(place.formatted_address); // formatted_address is google maps variable, and not part of address_components
    }
    
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
                $('#country').val(val);
            }

            $("#ordered_province option").filter(function() {
                    return this.text == val;
            }).attr('selected', true);

            if(addressType == "administrative_area_level_1"){
                $('#province').val(val);
            }
            if(addressType == "locality"){
                $('#city').val(val);
            }
            if(addressType == "postal_code"){
                $('#postal_code').val(val);
            }
            
/*  formatted_address is not part of the google maps address_components array

            if(addressType == "formatted_address"){
                $('#formatted_addressForDB').val(val);
            }
*/

            if(addressType == "street_number"){
                $('#formatted_address').val(val);                
            }
            if(addressType == "route"){
                if($('#formatted_address').val() != ""){
                    $('#formatted_address').val($('#formatted_address').val()+" "+val);
                } else {
                    $('#formatted_address').val(val);
                }
            }
        }
    }
    return place;
}

function fillInAddress() {

    if($('#formatted_address').is(':visible')){
        // meaning edit page is showing, as the top search field uses formatted_address2
        document.getElementById('verifyAddress').style.display="block";
    }

    // Get the place details from the formatted_address object.
    if(isundefined(formatted_address)) {
        var place = formatted_address2.getPlace();
        if(isundefined(place)) {
            var place = formatted_address3.getPlace();
        }else {
            var place = formatted_address2.getPlace();
        }
    } else {
        var place = formatted_address.getPlace();
    }
    
    var lat = place.geometry.location.lat();
    var lng = place.geometry.location.lng();
    
    if(!isundefined(formatted_address)){
        $('#formatted_addressForDB').val(place.formatted_address); // this formatted_address is a google maps object
    }

    //createCookieValue('longitude', lng);
    //createCookieValue('latitude', lat);

    $('#latitude').val(lat);
    $('#longitude').val(lng);
    $('#latitude3').val(lat);
    $('#longitude3').val(lng);
    
    var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'long_name',
        country: 'long_name',
        postal_code: 'short_name'
    };
    $('#city').val('');
    $('#formatted_address').val('');
    $('#postal_code').val('');
    $("#province").val('');
    //provinces('{{ addslashes(url("ajax")) }}', '');

    for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];
        if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];

            if(addressType == "country"){
                $('#country').val(val);
            }

            if(addressType == "administrative_area_level_1"){
                $('#province').val(val);
                if($('#ordered_province').is(':visible')){
                    $('#ordered_province').val(val);
                }
            }


            if(addressType == "locality"){
                $('#city').val(val);
                if($('#ordered_city').is(':visible'))
                    $('#ordered_city').val(val);
            }
            if(addressType == "postal_code"){
                $('#postal_code').val(val);
                if($('#ordered_code').is(':visible'))
                    $('#ordered_code').val(val);
            }
            if(addressType == "street_number"){
                $('#formatted_address').val(val);
                if($('#ordered_street').is(':visible'))
                    $('#ordered_street').val(val);
                
            }
            if(addressType == "route"){
                if($('#formatted_address').val() != ""){
                    $('#formatted_address').val($('#formatted_address').val()+" "+val);
                } else {
                    $('#formatted_address').val(val);
                }
                if($('#ordered_street').is(':visible'))
                if($('#ordered_street').val() != ""){
                    $('#ordered_street').val($('#ordered_street').val()+" "+val);
                } else {
                    $('#ordered_street').val(val);
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
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 86400000));//24 * 60 * 60 * 1000
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
    }
    return "";
}

function removeCookie(cname) {
    $.removeCookie(cname);
    $('#search-form #name').val('');
    $('#search-form #' + cname).val('');
    //createCookie(cname, "", -1);
}

function createCookieValue(cname, cvalue) {
    setCookie(cname, cvalue, 1);
}

function calcdistance(lat1, lon1, lat2, lon2) {
    var R = 6371; // km
    var dLat = toRad(lat2-lat1);
    var dLon = toRad(lon2-lon1);
    lat1 = toRad(lat1);
    lat2 = toRad(lat2);

    var a = Math.sin(dLat/2) * Math.sin(dLat/2) + Math.sin(dLon/2) * Math.sin(dLon/2) * Math.cos(lat1) * Math.cos(lat2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    return R * c;
}

// Converts numeric degrees to radians
function toRad(Value) {
    return Value * Math.PI / 180;
}

function unescapetext (str) {
    // this prevents any overhead from creating the object each time
    var element = document.createElement('div');
    if (str && typeof str === 'string') {
        // strip script/html tags
        str = str.replace(/<script[^>]*>([\S\s]*?)<\/script>/gmi, '');
        str = str.replace(/<\/?\w(?:[^"'>]|"[^"]*"|'[^']*')*>/gmi, '');
        element.innerHTML = str;
        str = element.textContent;
        element.textContent = '';
    }
    return str;
}