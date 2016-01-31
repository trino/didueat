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
$restSignUp = !isset($addresse_detail);//no idea what this needs to be
?>
<input type="hidden" name="latitude" id="latitude" value=""/>
<input type="hidden" name="longitude" id="longitude" value=""/>
<input type="hidden" name="formatted_addressForDB" id="formatted_addressForDB"/>

<?php echo newrow($new, "Address", "", 9); ?>

@if($is_disabled)
    <input required type="text" id="formatted_address" disabled name="formatted_address" class="form-control"
           value="{{ (isset($addresse_detail->address))?$addresse_detail->address: old('address') }}">
@else

        <input type="text" name="formatted_address" id="formatted_address" class="form-control formatted_address"
               placeholder="Start by typing in your address" value="<?php
        if (old('formatted_address')) {
            echo old('formatted_address');
        } else if (isset($addresse_detail->address)) {
            $country = select_field("countries", "id", $addresse_detail->country, "name");
            echo $addresse_detail->address;
        }
        ?>" required autocomplete="off">



@endif

<?php echo newrow();?>




<?php echo newrow($new, "Apartment", "", false, 5); ?>
<input type="text" name="apartment" class="form-control" {{ $is_disabled }} placeholder="Apartment/Unit/Townhouse"
       value="{{ (isset($addresse_detail->apartment))?$addresse_detail->apartment:old('apartment') }}">
</div></div>


<?= newrow($new, "City", "", $required, 5); ?>
<input required disabled type="text" id="city" name="city" class="form-control" onfocus="this.blur();"
       value="{{ (isset($addresse_detail->city))?$addresse_detail->city:old('city') }}" {{$required}}>
</div></div>

<?= newrow($new, "Province", "", $required, 5); ?>
<input required disabled type="text" id="province" name="province" class="form-control" onfocus="this.blur();"
       value="{{ (isset($addresse_detail->province))?$addresse_detail->province:old('province') }}" {{$required}}>
</div></div>

<?= newrow($new, "Postal Code", "", true, 5); ?>
<input required disabled type="text" name="postal_code" id="postal_code" onfocus="this.blur();" class="form-control"
       placeholder="Postal Code"
       value="{{ (isset($addresse_detail->postal_code))?$addresse_detail->postal_code: old('postal_code') }}">
</div></div>

<?= newrow($new, "Country", "", $required, 5); ?>
<input disabled type="text" id="country" name="country" class="form-control" onfocus="this.blur();"
       value="{{ (isset($addresse_detail->country))?$addresse_detail->country:old('country') }}" {{$required}}>
</div></div>


<!--?php echo newrow($new, "Cell Phone", "", $required, 5); ?>
    <input type="text" name="mobile" class="form-control" {{ $is_disabled }} placeholder=""
           value="{{ (isset($addresse_detail->mobile))?$addresse_detail->mobile: old('mobile') }}" {{$required}}>
</div></div-->


<?php

if($isUser){
echo newrow($new, "Notes", "", false, 9);
?>
<input type="text" name="notes" class="form-control" {{ $is_disabled }} placeholder="Buzz Code, Side door, etc"
       value="{{ (isset($addresse_detail->notes))?$addresse_detail->notes:old('notes') }}">
</div></div>
<?php }

?>
@if(isset($dontinclude))
<SCRIPT>
    $(document).ready(function () {
        if (typeof(initAutocomplete) == "function") {
            initAutocomplete();//editaddress
        }
    });
</SCRIPT>
@else
    <?php
   
    if (!isset($_GET['route'])) {
        includeJS(url("assets/global/scripts/provinces.js"));
        if (!includeJS("https://maps.googleapis.com/maps/api/js?signed_in=true&libraries=places&callback=initAutocomplete", "async defer")) {
            //echo "<script>initAutocomplete();</script>";
        }
        
    }
    else
        echo "<script>initAutocomplete();</script>";
    ?>

   @endif
    