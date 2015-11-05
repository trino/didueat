function getelement(name){
    var element = document.getElementById(name + "2");
    if(element){return element;}
    var element = document.getElementById(name);
    return element;
}

function provinces(webroot, value){
    var country = 40;//Canada
    var element = getelement("country");
    if (element){
        country = element.value;
        if(isNaN(country)){
            return false;
        }
    }

    $.ajaxSetup({
        headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
    });

    $.ajax({
        url: webroot,
        type: "post",
        dataType: "HTML",
        data: "type=provinces&country=" + country + "&value=" + value,
        success: function (msg) {
            element = getelement("province");
            element.innerHTML = msg;
        }
    })
}

$( document ).ready(function() {
    var element = getelement("country");
    if (element){
        var evnt = element["onchange"];
        if (typeof(evnt) == "function") {
            evnt.call(element);
        }
    }
});