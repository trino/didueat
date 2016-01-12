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
    if( !isundefined(variable) && $("#" + element).is(':visible') ){
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
    $('#rout_street_number').val('');
    $('#postal_code').val('');
    $("#province").val('');
    //provinces('{{ addslashes(url("ajax")) }}', '');

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
                    var data = JSON.parse(msg).results[0];
                    var street_number = 0;
                    $(".formatted_address").val(data.formatted_address);
                    $(".formatted_address").attr("title", position.coords.latitude + ',' + position.coords.longitude)
                    $(".formatted_address").trigger("change");

                    for(i = 0; i < data.address_components.length; i++){
                        var withdata = data.address_components[i];
                        var value = withdata.long_name;//also accepts short_name
                        switch (withdata.types[0]){
                            case "street_number":
                                street_number = value;
                                break;
                            case "route":
                                $("#rout_street_number").val(street_number + " " + value);
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

var TimeFormat = 24;//valid options are 12 and 24
$(document).ready(function () {
    $('.time').timepicker();
    $('.time').click(function () {
        $('.ui-timepicker-hour-cell .ui-state-default').each(function () {
            var t = parseFloat($(this).text());
            if (t > 12) {
                if (t < 22) {
                    $(this).text('0' + (t - 12));
                } else {
                    $(this).text(t - 12);
                }
            }
        });
    });

    $('.time').change(function () {
        var t = $(this).val();
        var arr = t.split(':');
        var h = arr[0];
        var t = parseFloat(h);//hour
        var format = ":00";// + arr[2];
        var ho = arr[0];

        if(TimeFormat == 12) {
            if (t > 11) {
                format = ' PM';
                if (t < 22) {
                    if (t != 12) {
                        var ho = '0' + (t - 12);
                    } else {
                        var ho = 12;
                    }
                } else {
                    var ho = t - 12;
                }
            } else {
                format = ' AM';
                if (arr[0] == '00') {
                    var ho = '12';
                }
            }
        }

        var tm = ho + ':' + arr[1] + format;
        $(this).val(tm);
    });
});