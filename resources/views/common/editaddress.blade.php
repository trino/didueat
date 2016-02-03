<?php
if (isset($GLOBALS["editaddress"])) {
    return "editaddress.blade was included twice! This time is from: " . $GLOBALS["currentfile"];
}
printfile("views/common/editaddress.blade.php");
$GLOBALS["editaddress"] = true;

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
} else {
    $is_disabled = " readonly";
}

$readonly = " readonly";
$isUser = isset($apartment);
$needsmobile = isset($mobile);
$restSignUp = !isset($addresse_detail);//no idea what this needs to be
?>

<input type="hidden" name="latitude" id="latitude" value="{{ (isset($addresse_detail->latitude))?$addresse_detail->latitude: old('latitude') }}"/>
<input type="hidden" name="longitude" id="longitude" value="{{ (isset($addresse_detail->longitude))?$addresse_detail->longitude: old('longitude') }}"/>
<input type="hidden" name="formatted_addressForDB" id="formatted_addressForDB" />
    
<?php echo newrow($new, "Street Address", "", true); ?>
    @if($is_disabled)
        <input type="text" id="formatted_address" disabled name="formatted_address" class="form-control" value="{{ (isset($addresse_detail->address))?$addresse_detail->address: old('address') }}">
    @else
        <DIV CLASS="nowrap">
            <input type="text" name="formatted_address" id="formatted_address" class="form-control formatted_address" placeholder="Address, City or Postal Code" value="<?php
            if (old('formatted_address')) {
                echo old('formatted_address');
                //} else if(isset($addresse_detail->address) && isset($addresse_detail->city) && isset($addresse_detail->province) && isset($addresse_detail->country)) {
            } else if (isset($addresse_detail->address)) {
//                $country = select_field("countries", "id", $addresse_detail->country, "name");
                //echo $addresse_detail->address . ", " . $addresse_detail->city . ', ' . $addresse_detail->province . ', ' . $country;
                echo $addresse_detail->address;
            }
            $width = 59;
            ?>" autocomplete="off" style="width: -moz-calc(100% - {{$width}}px); width: -webkit-calc(100% - {{$width}}px); width: calc(100% - {{$width}}px);">
        </DIV>

    @endif
<?php echo newrow(); 

    echo newrow($new, "Unit #", "", false, 5); ?>
    <input type="text" name="unit" class="form-control" {{ $is_disabled }} placeholder="Unit #"
           value="{{ (isset($addresse_detail->unit))?$addresse_detail->unit:old('unit') }}">
    </div></div>

<?php
echo newrow($new, "City", "", $required, 5); ?>
<input required <?= $readonly; ?> type="text" id="city" name="city" class="form-control" onfocus="this.blur();"
       value="{{ (isset($addresse_detail->city))?$addresse_detail->city:old('city') }}" {{$required}}>
</div></div>

<?= newrow($new, "Province", "", $required, 5); ?>
<input required <?= $readonly; ?> type="text" id="province" name="province" class="form-control" onfocus="this.blur();"
       value="{{ (isset($addresse_detail->province))?$addresse_detail->province:old('province') }}" {{$required}}>
</div></div>

<?= newrow($new, "Postal Code", "", true, 5); ?>
<input required <?= $readonly; ?> type="text" name="postal_code" id="postal_code" onfocus="this.blur();" class="form-control"
       placeholder=""
       value="{{ (isset($addresse_detail->postal_code))?$addresse_detail->postal_code: old('postal_code') }}">
</div></div>

<?= newrow($new, "Country", "", $required, 5); ?>
<input <?= $readonly; ?> type="text" id="country" name="country" class="form-control" onfocus="this.blur();"
       value="{{ (isset($addresse_detail->country))?$addresse_detail->country:old('country') }}" {{$required}}>
</div></div>

<?php 
    if(isset($restSignUp)){
      echo newrow($new, "Important", "", true, 10, true);
?>
    <div id="verifyAddress" style="display:none">
        <div class="instruct">Please Ensure Address was Correctly Filled-out</div>
    </div>
<?php 
echo newrow(); 
}
?>

<!--?php echo newrow($new, "Cell Phone", "", $required, 5); ?>
    <input type="text" name="mobile" class="form-control" {{ $is_disabled }} placeholder=""
           value="{{ (isset($addresse_detail->mobile))?$addresse_detail->mobile: old('mobile') }}" {{$required}}>
</div></div-->



<?php
    if(isset($restEdit)){
		    echo newrow($new,"Save","","",12,"Save"); 
            echo '<hr width="100%" align="center" /><span class="pull-right"><button type="submit" class="btn btn-primary pull-right">Save</button></span></div></div>';
    }

if($isUser){
    echo newrow($new, "Notes", "", false, 9);
    ?>
    <input type="text" name="notes" class="form-control" {{ $is_disabled }} placeholder="Buzz Code, Side door, etc"
           value=""{{ (isset($addresse_detail->notes))?$addresse_detail->notes:old('notes') }}"">
    </div></div>

<?php } ?>

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

        } else{
            includeJS(url("assets/global/scripts/provinces.js"));
            if (!includeJS("https://maps.googleapis.com/maps/api/js?signed_in=true&libraries=places&callback=initAutocomplete", "async defer")) {
                echo '<SCRIPT>initAutocomplete2();</SCRIPT>';
            }
       }
    ?>
@endif
