//get an element by it's ID
function getelement(name) {
    return document.getElementById(name);
}

//Google Api Codes.
$('#formatted_address, #formatted_address1, #formatted_address2, #formatted_address3, #formatted_address4').keydown(function (e) {
  if (e.which == 13 && $('.pac-container:visible').length) return false;
});
$('#formatted_address, #formatted_address1, #formatted_address2, #formatted_address3, #formatted_address4').change(function () {
  return false;
});

var placeSearch, formatted_address;

function initAutocompleteWithID(ID){
    var element = document.getElementById(ID);
    if(element)
    if (!element.hasAttribute("hasgeocode")) {
        var formatted_address = new google.maps.places.Autocomplete(
            (element), {
		      types: ['geocode'],
		      componentRestrictions: {country: "ca"}
      });
        formatted_address.addListener('place_changed', fillInAddress);
        element.setAttribute("hasgeocode", true);
        
        var input= document.getElementById('formatted_address2');
        google.maps.event.addDomListener(input, 'keydown', function(e) { 
        if (e.keyCode == 13 && $('.pac-container:visible').length) {
            setTimeout(function(){
                submitform(e, 0, "provinces.js");
            }, 200);
        }
}); 
        
        return formatted_address;
    }
}

function initAutocomplete(){
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

//check if an element is defined and has a value
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
    console.log("fillInAddress1");
    //this should be merged with fillInAddress, there should be no duplicate code
    // Get the place details from the formatted_address object.
    var place = formatted_address.getPlace();
    var lat = place.geometry.location.lat();
    var lng = place.geometry.location.lng();
    var pcFnd=false;
    
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
    $('#postal_code').val('');
    $(".commas").show();

    $('span.country').text("[Missing Country]");
    $('span.city').text("[Missing City]");
    $('span.postal_code').text("[Missing Postal Code]");
    $('#street_num').val("");

    for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];

        //alert(addressType +  " is not on record, is: ");

        if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            if(debugmode) {console.log(addressType + " = " + val);}
            if(addressType == "country"){
                $('#country').val(val);
                $('span.country').text(val);
            }

            $("#ordered_province option").filter(function() {
                    return this.text == val;
            }).attr('selected', true);

            if(addressType == "administrative_area_level_1"){
                $('#province').val(val);
                $('span.province').text(val);
            }
            if(addressType == "street_number"){
                $('#street_num').val(val);
            }

            if(addressType == "locality"){
                $('#city').val(val);
                $('span.city').text(val);
            }
            if(addressType == "postal_code"){
                $('#postal_code').val(val);
                $('span.postal_code').text(val);
                pcFnd=true;
            }

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
}

function fillInAddress() {
    console.log("fillInAddress");
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

    createCookieValue('longitude', lng);
    createCookieValue('latitude', lat);

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
    var streetformat = "[street_number] [route], [locality]";
    //provinces('{{ addslashes(url("ajax")) }}', '');

    for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];
        if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            log(addressType + " = " + val);
            streetformat = streetformat.replace("[" + addressType + "]", val);

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
                if($('#ordered_city').is(':visible')) {
                    $('#ordered_city').val(val);
                }
            }
            if(addressType == "postal_code"){
                $('#postal_code').val(val);
                if($('#ordered_code').is(':visible')) {
                    $('#ordered_code').val(val);
                }
            }
            if(addressType == "street_number"){
                $('#formatted_address').val(val);
                if($('#ordered_street').is(':visible')) {
                    $('#ordered_street').val(val);
                }
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

    log("streetformat = " + streetformat);
    $('#formatted_address2').val(streetformat);
    return place;
}

//returns true if a variable is not defined
function isundefined(variable){
    return typeof variable === 'undefined';
}

//stringify any variable
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

//make a cookie value that expires in exdays
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 86400000));//24 * 60 * 60 * 1000
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

//gets a cookie value
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

//deletes a cookie valie
function removeCookie(cname) {
    $.removeCookie(cname);
    $('#search-form #name').val('');
    $('#search-form #' + cname).val('');
    //createCookie(cname, "", -1);
}

//creates a cookie value that expires in 1 year
function createCookieValue(cname, cvalue) {
    setCookie(cname, cvalue, 365);
}

//calculates the distance between 2 GPS coordinates in KM
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

//unescapes javascript text
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

//lets you change the url without reloading
function ChangeUrl(page, url) {
    if (typeof (history.pushState) != "undefined") {
        var obj = {Page: page, Url: url};
        history.pushState(obj, obj.Page, obj.Url);
        return true;
    }
}

$.fn.hasAttr = function(name) {
    return this.attr(name) !== undefined;
};

//usage: $('#yourDiv').followTo(250);
$.fn.followTo = function (pos) {
    var $this = this, $window = $(window);

    $window.scroll(function (e) {
        var top = $window.scrollTop();
        if (top > pos) {
            $this.css({
                position: 'fixed',
                top: pos
            });
        } else {
            $this.css({
                position: 'relative',
                top: 0
            });
        }
    });
};

$(document).ready(function() {
    $(".followTo").each(function() {
        var Y = 0;
        if ($(this).hasAttr("followy") ){
            Y = $(this).attr("followy");
        }
        $(this).attr("oldY", $(this).position().top );
        $(this).followTo(Y);
    });
});