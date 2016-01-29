<?php
if (isset($GLOBALS["editaddress"])) {
    return "editaddress.blade was included twice! This time is from: " . $GLOBALS["currentfile"];
}
printfile("views/common/editaddress.blade.php");
$GLOBALS["editaddress"] = true;
//$countries_list = \App\Http\Models\Countries::get();//load all countries
if (!isset($new)) {
    $new = false;
}
if (!isset($addresse_detail) && isset($address_detail)) {
    $addresse_detail = $address_detail;
}
if (!isset($required)) {
    $required = true;
}
$required = iif($required, " required");
if (!isset($is_disabled)) {
    $is_disabled = false;
}
$isUser = isset($apartment);
$needsmobile = isset($mobile);
$restSignUp=!isset($addresse_detail);//no idea what this needs to be
?>
<input type="hidden" name="latitude" id="latitude" value=""/>
<input type="hidden" name="longitude" id="longitude" value=""/>
<input type="hidden" name="formatted_addressForDB" id="formatted_addressForDB" />
    
<?php echo newrow($new, "Street Address", "", false); ?>
    @if($is_disabled)
        <input type="text" id="formatted_address" disabled name="formatted_address" class="form-control" value="{{ (isset($addresse_detail->address))?$addresse_detail->address: old('address') }}">
    @else
        <DIV CLASS="nowrap">
            <input type="text" name="formatted_address" id="formatted_address" class="form-control formatted_address" placeholder="Address, City or Postal Code" value="<?php
            if (old('formatted_address')) {
                echo old('formatted_address');
                //} else if(isset($addresse_detail->address) && isset($addresse_detail->city) && isset($addresse_detail->province) && isset($addresse_detail->country)) {
            } else if (isset($addresse_detail->address)) {
                $country = select_field("countries", "id", $addresse_detail->country, "name");
                //echo $addresse_detail->address . ", " . $addresse_detail->city . ', ' . $addresse_detail->province . ', ' . $country;
                echo $addresse_detail->address;
            }
            $width = 59;
            ?>" autocomplete="off" style="width: -moz-calc(100% - {{$width}}px); width: -webkit-calc(100% - {{$width}}px); width: calc(100% - {{$width}}px);">

        </DIV>

        <DIV>
            <span class="alldays">(Start typing the address then click from the dropdown to populate all address fields)</span>
        </DIV>
    @endif
</div></div>

<?php

    if($isUser){
        echo newrow($new, "Apartment/Unit", "", false, 5); ?>
            <input type="text" name="apartment" class="form-control" {{ $is_disabled }} placeholder="Apartment/Unit/Townhouse"
           value="{{ (isset($addresse_detail->apartment))?$addresse_detail->apartment:old('apartment') }}">
        </div></div>
<?php
    }

?>
    <!--  newrow($new, "Street Address", "", $required); ?>
        <input type="text" id="rout_street_number" {{ $is_disabled }} name="address" class="form-control" placeholder="Street address" value="{{ (isset($addresse_detail->address))?$addresse_detail->address: old('address') }}" {{$required}}>
    </div>
</div-->

<?= newrow($new, "City", "", $required, 4); ?>
    <input type="text" id="city" name="city" class="form-control2" onfocus="this.blur();"
           value="{{ (isset($addresse_detail->city))?$addresse_detail->city:old('city') }}" {{$required}}>
</div></div>

<?= newrow($new, "Postal Code", "", true, 4); ?>
    <input type="text" name="postal_code" id="postal_code" onfocus="this.blur();" class="form-control2"
           placeholder="Postal Code"
           value="{{ (isset($addresse_detail->postal_code))?$addresse_detail->postal_code: old('postal_code') }}" >
</div></div>

<?= newrow($new, "Country", "", $required, 4); ?>
    <input type="text" id="country" name="country" class="form-control2" onfocus="this.blur();"
           value="{{ (isset($addresse_detail->country))?$addresse_detail->country:old('country') }}" {{$required}}>
</div></div>


<?php echo newrow($new, "Phone Number", "", $required, 7); ?>
    <input type="text" name="phone" class="form-control"
           {{ $is_disabled }} placeholder="Must be a valid, in-service, Canadian number"
           value="{{ (isset($addresse_detail->phone))?$addresse_detail->phone: old('phone') }}" {{$required}}>
</div></div>


<?php echo newrow($new, "Cellphone Number", "", $required, 7); ?>
    <input type="text" name="mobile" class="form-control" {{ $is_disabled }} placeholder="Cellphone Number"
           value="{{ (isset($addresse_detail->mobile))?$addresse_detail->mobile: old('mobile') }}" {{$required}}>
</div></div>


<?php
    
    if($isUser){
        echo newrow($new, "Notes", "", false, 9); 
?>
        <input type="text" name="notes" class="form-control" {{ $is_disabled }} placeholder="eg. Buzz Code, Side door etc."
               value="{{ (isset($addresse_detail->notes))?$addresse_detail->notes:old('notes') }}">
        </div></div>
    <?php }

/*

    if(!$restSignUp){
		    echo newrow($new,"Save","","",12,true); 
            echo '<hr width="100%" align="center" /><button type="submit" class="btn btn-primary pull-right" style="margin-left:auto;margin-right:auto;">Save</button></div></div>';
    }

*/

    if (isset($disclaimer)) {
        echo 'The entrance must be safe (ie: well-lit, clear of ice';
        if (date("md") == "0401") {
            echo ' and Macaulay Culkin-esque traps';
        }
        echo ') Drivers are not required to go up stairs, any time guarantees a store may have ends at the lobby, or when they call on arrival (whether or not they are able to reach you)';
    }
    if(isset($dontinclude)) { ?>
        <SCRIPT>
            $(document).ready(function () {
                if (typeof(initAutocomplete) == "function") {
                    initAutocomplete();//editaddress
                }
            });
        </SCRIPT>
    <?php } else {
        echo '<script src="' . url("assets/global/scripts/provinces.js") . '" type="text/javascript"></script>';
        if (!includeJS("https://maps.googleapis.com/maps/api/js?signed_in=true&libraries=places&callback=initAutocomplete", "async defer")) {
            //echo '<script>initAutocomplete();</script>';
        }
        ?>
        <SCRIPT>
            $(document).ready(function () {
                cities("{{ url('ajax') }}", '{{ (isset($addresse_detail->city))?$addresse_detail->city:0 }}');
            });
        </SCRIPT>
    <?php } ?>