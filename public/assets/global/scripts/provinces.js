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
            (element),
            {types: ['geocode']});
        formatted_address.addListener('place_changed', fillInAddress);
        element.setAttribute("hasgeocode", true);
        return formatted_address;
    }
}

function initAutocomplete(){
    
     formatted_address = new google.maps.places.Autocomplete(
      /** @type {!HTMLInputElement} */(document.getElementById('formatted_address')),
      {types: ['geocode']});

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
            if(addressType == "formatted_address"){
                $('#formatted_addressForDB').val(val);
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
    return place;
}

function fillInAddress() {

    if($('#formatted_address').is(':visible')){
     // meaning edit page is showing, as the top search field uses formatted_address2
     document.getElementById('verifyAddress').style.display="block";
    }

    // Get the place details from the formatted_address object.
    if(isundefined(formatted_address))
    {
        
        var place = formatted_address2.getPlace();
        if(isundefined(place))
            var place = formatted_address3.getPlace();
        else
            var place = formatted-address.getPlace();
       
    }
    else
    {
        var place = formatted_address.getPlace();
    }
    
    var lat = place.geometry.location.lat();
    var lng = place.geometry.location.lng();
    
    if(!isundefined(formatted_address)){
     $('#formatted_addressForDB').val(place.formatted_address); // this formatted_address is a google maps object
    }
    
    $('#latitude').val(lat);
    $('#longitude').val(lng);
    $('#latitude2').val(lat);
    $('#longitude2').val(lng);
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
                    var data = JSON.parse(msg).results[0];
                    var street_number = 0;
                    //$(".formatted_address").val(data.formatted_address);

                    for(i = 0; i < data.address_components.length; i++){
                        var withdata = data.address_components[i];
                        var value = withdata.long_name;//also accepts short_name
                        switch (withdata.types[0]){
                            case "street_number":
                                street_number = value;
                                break;
                            case "route":
                                $(".formatted_address").val(street_number + " " + value);
                                //$("#rout_street_number").val(street_number + " " + value);
                                break;
                            case "postal_code":
                                $("#postal_code").val(value);
                                break;
                            case "country":
                                $("#country option").filter(function() {return this.text == value;}).attr('selected', true);
                                break;
                            case "locality":
                                $("#city").val(value);
                                break;
                            case "administrative_area_level_1":
                                $("#province option").filter(function() {return this.text == value;}).attr('selected', true);
                                break;
                        }
                    }

                    $(".formatted_address").attr("title", position.coords.latitude + ',' + position.coords.longitude)
                    $(".formatted_address").trigger("change");
                    alert('Please make sure the address is correct');
                },
                error: function(msg){
                    alert("ERROR: " + msg);
                }
            });

            var circle = new google.maps.Circle({
                center: geolocation,
                radius: position.coords.accuracy
            });
            formatted_address.setBounds(circle.getBounds());
        });
    } else {
        alert("Sorry. Your browser does not support geo-location");
    }
}