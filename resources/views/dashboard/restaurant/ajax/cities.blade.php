<?php
    printfile("views/common/search_bar.blade.php");
    $provinces = array(
            "ON" => "Ontario",
            "QC" => "Quebec",
            "NS" => "Nova Scotia",
            "NB" => "New Brunswick",
            "MB" => "Manitoba",
            "BC" => "British Columbia",
            "PE" => "Prince Edward Island",
            "SK" => "Saskatchewan",
            "AB" => "Alberta",
            "NL" => "Newfoundland and Labrador",
            "NT" => "Northwest Territories",
            "YT" => "Yukon",
            "NU" => "Nunavut"
    );
    foreach($cities as $city){
        if(!$city->country){$city->country = "Canada";}
        if (isset($provinces[$city->province])){
            $city->province = $provinces[$city->province];
        }
        echo '<BR><A province="' . $city->province . '" country="' . $city->country . '" city="' . $city->city . '" onclick="searchcity(event);">' .  $city->city . ', ' . $city->province . '</A>';
    }
?>
<SCRIPT>
    function searchcity(event){
        var city = $(event.target).attr("city");
        var province = $(event.target).attr("province");
        var country = $(event.target).attr("country");

        $("#latitude").val("");
        $("#longitude").val("");
        $("#city").val(city);
        $("#province").val(province);
        $("#postal_code").val("");
        $("#country").val(country);

        setaddress(city + ", " + province);
    }
</SCRIPT>
