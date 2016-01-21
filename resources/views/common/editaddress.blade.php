<?php
    if(isset($GLOBALS["editaddress"])){
        return "editaddress.blade was included twice! This time is from: " . $GLOBALS["currentfile"];
    }
    printfile("views/common/editaddress.blade.php");
    $GLOBALS["editaddress"] = true;
    //$countries_list = \App\Http\Models\Countries::get();//load all countries
    if(!isset($new)){$new=false;}
    if(!isset($addresse_detail) && isset($address_detail)){$addresse_detail = $address_detail;}
    if(!isset($required)){$required = true;}
    $required = iif($required , " required");
    if(!isset($is_disabled)){$is_disabled=false;}
    $isUser = isset($apartment);
?>
<input type="hidden" name="latitude" id="latitude" value=""/>
<input type="hidden" name="longitude" id="longitude" value=""/>
<?php echo newrow($new, "Search Address <span style='font-size:11px;font-weight:normal;color:#f00'>(Start typing address then click from dropdown to populate all address fields)</span>", "", false); ?>
        @if($is_disabled)
            <input type="text" id="formatted_address" disabled name="formatted_address" class="form-control" value="{{ (isset($addresse_detail->address))?$addresse_detail->address: old('address') }}">
        @else
            <DIV CLASS="nowrap">
                <input type="text" name="formatted_address" id="formatted_address" class="form-control formatted_address" placeholder="Address, City or Postal Code" value="<?php
                if (old('formatted_address')){
                    echo old('formatted_address');
                //} else if(isset($addresse_detail->address) && isset($addresse_detail->city) && isset($addresse_detail->province) && isset($addresse_detail->country)) {
                } else if(isset($addresse_detail->address)) {
                    $country = select_field("countries", "id", $addresse_detail->country, "name");
                    //echo $addresse_detail->address . ", " . $addresse_detail->city . ', ' . $addresse_detail->province . ', ' . $country;
                    echo $addresse_detail->address;
                }
                $width=59;
                ?>" autocomplete="off" style="width: -moz-calc(100% - {{$width}}px); width: -webkit-calc(100% - {{$width}}px); width: calc(100% - {{$width}}px);">
                <a class="btn btn-primary headerbutton" oldstyle="display: none;" id="header-search-button" onclick="geolocate(formatted_address);" style="padding-top: 0px;position:relative;top:-2px;">
                    <i class="fa fa fa-compass"></i>
                </a>
            </DIV>
        @endif
    </div>
</div>
<HR>

<!--  newrow($new, "Street Address", "", $required); ?>
        <input type="text" id="rout_street_number" {{ $is_disabled }} name="address" class="form-control" placeholder="Street address" value="{{ (isset($addresse_detail->address))?$addresse_detail->address: old('address') }}" {{$required}}>
    </div>
</div-->


<?php echo newrow($new, "Address", "", $required, 4); ?>
        <input type="text" id="address" name="address" class="form-control" {{ $is_disabled }} {{$required}} value="{{ (isset($addresse_detail->address))?$addresse_detail->address:old('address') }}" {{$required}}>
    </div>
</div>

<?php echo newrow($new, "City", "", $required, 4); ?>
        <input type="text" id="city" name="city" class="form-control" {{ $is_disabled }} {{$required}} value="{{ (isset($addresse_detail->city))?$addresse_detail->city:old('city') }}" {{$required}}>
    </div>
</div>

<?php echo newrow($new, "Province", "", true, 4); ?>
        <select name="province" id="province" class="form-control" {{ $is_disabled }} {{$required}}>
            <option value="">-Select One-</option>
            @foreach(select_field_where("states", "", false, "name", "ASC") as $value)
                <option value="{{ $value->id }}" {{ ( (isset($addresse_detail->state) && $addresse_detail->state == $value->id) || old('province') == $value->name || old('province') == $value->id )? 'selected' :'' }}>{{ $value->name }}</option>
            @endforeach
        </select>
        <!--input type="text" id="province" name="province" class="form-control" {{$required}} value="{{ (isset($addresse_detail->province))?$addresse_detail->province:old('province') }}"-->
    </div>
</div>

<?php echo newrow($new, "Postal Code", "", true, 4); ?>
        <input type="text" name="postal_code" id="postal_code" {{ $is_disabled }} class="form-control" placeholder="Postal Code" value="{{ (isset($addresse_detail->postal_code))?$addresse_detail->postal_code: old('postal_code') }}">
    </div>
</div>

<?php echo newrow($new, "Country", "", true, 4); ?>
        <select name="country" id="country" class="form-control" {{ $is_disabled }} id="country2" {{$required}} onOLDchange="provinces('{{ addslashes(url("ajax")) }}', '{{ (isset($addresse_detail->province))?$addresse_detail->province: old('province') }}');">
        
            <option value="">-Select One-</option>
                            <option value="40">Canada</option>
                            <option value="236">United States</option>
                            <option value="">---------------</option>
            @foreach(select_field_where("countries", "", false, "name", "ASC") as $value)
                <option value="{{ $value->id }}" {{ ( (isset($addresse_detail->country) && $addresse_detail->country == $value->id) || old('country') == $value->name || old('country') == $value->id )? 'selected' :'' }}>{{ $value->name }}</option>
            @endforeach
        </select>
    <!--input type="text" id="country" name="country" class="form-control" {{$required}} value="{{ (isset($addresse_detail->country))?$addresse_detail->country:old('country') }}"-->
    </div>
</div>

<?php echo newrow($new, iif($isUser, "Cell Phone", "Phone Number"), "", $required, 4); ?>
        <input type="text" name="phone" class="form-control" {{ $is_disabled }} placeholder="Phone Number must be a valid, in-service, Canadian number" value="{{ (isset($addresse_detail->phone))?$addresse_detail->phone: old('phone') }}" {{$required}}>
    </div>
</div>

<?php if($isUser){ ?>
    <?php echo newrow($new, "Apartment/Unit", "", false, 4); ?>
            <input type="text" name="apartment" class="form-control" {{ $is_disabled }} placeholder="Apartment/Unit/Townhouse" value="{{ (isset($addresse_detail->apartment))?$addresse_detail->apartment:old('apartment') }}">
        </div>
    </div>

    <?php echo newrow($new, "Buzz Code", "", false, 4); ?>
            <input type="text" name="buzz" class="form-control" {{ $is_disabled }} placeholder="Buzz/ringer/doorbell Code" value="{{ (isset($addresse_detail->buzz))?$addresse_detail->buzz:old('buzz') }}">
        </div>
    </div>

    <?php echo newrow($new, "Notes", "", false, 9); ?>
            <input type="text" name="notes" class="form-control" {{ $is_disabled }} placeholder="ie: Side door" value="{{ (isset($addresse_detail->notes))?$addresse_detail->notes:old('notes') }}">
        </div>
    </div>
<?php }
    if(isset($disclaimer)){
        echo 'The entrance must be safe (ie: well-lit, clear of ice';
        if(date("md") == "0401"){ echo ' and Macaulay Culkin-esque traps';}
        echo ') Drivers are not required to go up stairs, any time guarantees a store may have ends at the lobby, or when they call on arrival (whether or not they are able to reach you)';
    }
if(isset($dontinclude)) { ?>
    <SCRIPT>
        $(document).ready(function() {
            if (typeof(initAutocomplete) == "function") {
                initAutocomplete();//editaddress
            }
        });
    </SCRIPT>
<?php } else {
    echo '<script src="' . url("assets/global/scripts/provinces.js") . '" type="text/javascript"></script>';
    if(!includeJS("https://maps.googleapis.com/maps/api/js?signed_in=true&libraries=places&callback=initAutocomplete", "async defer")){
        //echo '<script>initAutocomplete();</script>';
    }
?>
    <SCRIPT>
        $(document).ready(function () {
            cities("{{ url('ajax') }}", '{{ (isset($addresse_detail->city))?$addresse_detail->city:0 }}');
        });
    </SCRIPT>
<?php } ?>
