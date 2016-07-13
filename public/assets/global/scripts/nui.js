//natural user interface

var synonyms = [//multi-dimensional array of multi-word terms, the first term is the primary terms, followed by the secondary terms
    ["jalapenos", "jalapeno", "jalapeño", "jalapeños"],
    ["green peppers"],
    ["red peppers"],
    ["black olives", "kalamata olives"],
    ["tomatoes", "tomatos"],
    ["sun dried tomatoes", "sun dried tomatoes", "sundried tomatoes"],
    ["pepperoni", "pepperonis"],
    ["red onions"],
    ["extra large", "x-large"],
    ["anchovies", "anchovy"]
];

function findlabel(element){
    var label = $("label[for='"+element.attr('id')+"']");
    if (label.length == 0) {
        label = element.closest('label')
    }
    return label;
}

function replacesynonyms(searchstring){
    //replace synonyms with the first term to normalize the search
    searchstring = searchstring.trim().toLowerCase().replaceAll("-", " ");
    for(var synonymparentindex = 0; synonymparentindex< synonyms.length; synonymparentindex++){
        for(var synonymchildindex = 0; synonymchildindex < synonyms[synonymparentindex].length; synonymchildindex++){
            searchstring = searchstring.replaceAll(synonyms[synonymparentindex][synonymchildindex], synonyms[synonymparentindex][0].replaceAll(" ", "-"));
        }
    }
    return searchstring;
}

function assimilate(ID){
    var searchstring = replacesynonyms($("#textsearch").val()).split(" ");
    log("Starting with: " + searchstring);
    //quantity
    for(var searchindex = 0; searchindex<searchstring.length; searchindex++){
        log("Checking: " + searchstring[searchindex]);
        if(!isNaN( searchstring[searchindex] )){
            if($("#select" + ID + " option:contains('" + searchstring[searchindex] + "')").length > 0) {//make sure the quantity even exists
                $("#select" + ID).val(searchstring[searchindex]);
            }
        }
    }

    //add ons/toppings
    $("#product-pop-up_" + ID  + " input").filter(":visible").each(function () {
        var Found = -1;
        var label = findlabel($(this)).find(".ver");
        if( !$(this).hasAttr("normalized") ){
            $(this).attr("normalized", replacesynonyms(label.contents().get(0).nodeValue));//cache results
        }
        label = $(this).attr("normalized");
        for(var searchindex = 0; searchindex<searchstring.length; searchindex++){
            if(searchstring[searchindex]) {
                if (label.indexOf(searchstring[searchindex]) > -1) {
                    Found = searchindex;
                    searchstring[searchindex] = false;//remove it from the search, no need to check it twice
                    searchindex = searchstring.length;
                }
            }
        }
        if(Found > -1){
            $(this).prop('checked', true);
        }
    });
}