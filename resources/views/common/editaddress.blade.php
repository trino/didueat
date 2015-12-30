<?php
    printfile("views/common/editaddress.blade.php");
    $countries_list = \App\Http\Models\Countries::get();//load all countries
    if(!isset($new)){$new=false;}
    if(!isset($addresse_detail) && isset($address_detail)){$addresse_detail = $address_detail;}
    if(!isset($required)){$required = true;}
    $required = iif($required , " required");
?>
<input type="hidden" name="lat" id="latitude" value="" />
<input type="hidden" name="lng" id="longitude" value="" />
<input type="hidden" name="latitude" id="latitude" value=""/>
<input type="hidden" name="longitude" id="longitude" value=""/>
<?= newrow($new, "Format Address"); ?>
        <input type="text" name="formatted_address" id="formatted_address" class="form-control formatted_address" placeholder="Address, City or Postal Code" value="{{ old('formatted_address') }}" onFocus="geolocate()" autocomplete="off">
        <!--INPUT TYPE="button" onclick="getplace('formatted_address');" value="AUTOCOMPLETE"-->
    </div>
</div>

<?= newrow($new, "Street Address"); ?>
        <input type="text" id="rout_street_number" name="address" class="form-control" placeholder="Street address" value="{{ (isset($addresse_detail->address))?$addresse_detail->address: old('address') }}" {{$required}} >
    </div>
</div>

<?= newrow($new, "Postal Code"); ?>
        <input type="text" name="postal_code" id="postal_code" class="form-control" placeholder="Postal Code" value="{{ (isset($addresse_detail->postal_code))?$addresse_detail->postal_code: old('postal_code') }}">
    </div>
</div>

<?= newrow($new, "Phone Number"); ?>
        <input type="text" name="phone" class="form-control" placeholder="Phone Number" value="{{ (isset($addresse_detail->phone))?$addresse_detail->phone: old('phone') }}">
    </div>
</div>

<?= newrow($new, "Country"); ?>
        <select name="country" id="country" class="form-control" id="country2" {{$required}} onchange="provinces('{{ addslashes(url("ajax")) }}', '{{ (isset($addresse_detail->province))?$addresse_detail->province: old('province') }}');">
            <option value="">-Select One-</option>
            @foreach($countries_list as $value)
                <option value="{{ $value->id }}" {{ (isset($addresse_detail->country) && $addresse_detail->country == $value->id)? 'selected' :'' }}>{{ $value->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<?= newrow($new, "Province"); ?>
        <select name="province" id="province" class="form-control" id="province2" {{$required}} onchange="cities('{{ addslashes(url("ajax")) }}', '{{ old('province') }}');">
            <option value="">-Select One-</option>
        </select>
    </div>
</div>

<?= newrow($new, "City"); ?>
        <input type="text" id="city" name="city" class="form-control" id="city2" {{$required}} value="{{ (isset($addresse_detail->city))?$addresse_detail->city:old('city') }}">
    </div>
</div>

<?php if(isset($apartment)){ ?>
    <?= newrow($new, "Apartment"); ?>
            <input type="text" name="apartment" class="form-control" placeholder="Apartment" value="{{ (isset($addresse_detail->apartment))?$addresse_detail->apartment:old('apartment') }}" {{$required}}>
        </div>
    </div>

    <?= newrow($new, "Buzz Code"); ?>
            <input type="text" name="buzz" class="form-control" placeholder="Buzz Code" value="{{ (isset($addresse_detail->buzz))?$addresse_detail->buzz:old('buzz') }}" {{$required}}>
        </div>
    </div>
<?php }?>
<?php if(isset($dontinclude)) { ?>
    <SCRIPT>
        $(document).ready(function() {
            initAutocomplete();
        });
    </SCRIPT>
<?php } else {
    echo '<script src="' . url("assets/global/scripts/provinces.js") . '" type="text/javascript"></script>';
    if(!includeJS("https://maps.googleapis.com/maps/api/js?signed_in=true&libraries=places&callback=initAutocomplete", "async defer")){
        echo '<script>initAutocomplete();</script>';
    }
?>
    <SCRIPT>
        $(document).ready(function () {
            cities("{{ url('ajax') }}", '{{ (isset($addresse_detail->city))?$addresse_detail->city:0 }}');
        });
    </SCRIPT>
<?php } ?>
