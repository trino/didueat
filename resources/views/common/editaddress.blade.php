<?php printfile("resources/views/common/editaddress.blade.php"); ?>

<?php
if (isset($GLOBALS["editaddress"])) {
    return "editaddress.blade was included twice! This time is from: " . $GLOBALS["currentfile"];
}

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
$isUser = isset($apartment); // set by addressesFind
$needsmobile = isset($mobile);
$restSignUp = !isset($addresse_detail);//no idea what this needs to be
?>

<input type="hidden" name="latitude" id="latitude"
       value="{{ (isset($addresse_detail->latitude))?$addresse_detail->latitude: old('latitude') }}"/>
<input type="hidden" name="longitude" id="longitude"
       value="{{ (isset($addresse_detail->longitude))?$addresse_detail->longitude: old('longitude') }}"/>
<input type="hidden" name="formatted_addressForDB" id="formatted_addressForDB"/>

<div class="<?php if (!isset($type)) echo "nput-group-btn";?> addressdropdown">


    <?php 
    
    echo newrow($new, (!isset($type)) ? "Address" : "Address", "", true);
    if(read('id')){
            
        ?>
            <!--div class="input-group-btn addressdropdown"-->

    @if( (Request::path() == '/' || Request::path()=='restaurants/chuck-burger-bar/menus' || (isset($searchTerm) && Request::path() == "restaurants/".$searchTerm) || (isset($slug) && Request::path() == "restaurants/".$slug."/menus")))
        
            <?php
            $addresses = \App\Http\Models\ProfilesAddresses::where('user_id', read("id"))->orderBy('order', 'ASC')->get();
            
            if(!isset($type)){
                
            if($addresses->count()){
            ?>
            <button style="border-right:0;" type="button" class="btn btn-secondary " data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                <span class="sr-only">Toggle Dropdown</span>&nbsp;<i class="fa fa-caret-down"></i>&nbsp;
            </button>
            <div class="dropdown-menu dropdown-menu-left">
                <?php
                foreach ($addresses as $address) {
                    if (!$sec) {
                        $sec = $address->id;
                    }
                    if (!trim($address->location)) {
                        $address->location = "Address: " . $address->id;
                    }
                    echo '  <a class="dropdown-item" ';
                    echo ' VALUE="' . $address->id . '" CITY="' . $address->city . '" PROVINCE="' . $address->province . '" APARTMENT="' . $address->apartment . '" ';
                    echo 'COUNTRY="' . $address->country . '" PHONE="' . $address->phone . '" MOBILE="' . $address->mobile . '" ';
                    echo 'ID="add' . $address->id . '" ADDRESS="' . $address->address . '" POSTAL="' . $address->postal_code . '" NOTES="' . $address->notes . '" onclick="addresschanged(this)">';
                    echo $address->location . ' [' . $address->address . ']';
                    echo '</a>';
                }
                ?>
                <a href="#" data-target="#editModel" data-toggle="modal" data-route="reservation" id="addNew"
                   class="dropdown-item">Add New Address</a>

            </div>
            <?php }
            }
            else
            {
            ?>
            <select name="reservation_address_dropdown" class="col-md-11 form-control reservation_address_dropdown">
                <option value="">Select Address</option>
                <?php
                $sec = false;
                foreach ($addresses as $address) {
                    if (!$sec) {
                        $sec = $address->id;
                    }
                    if (!trim($address->location)) {
                        $address->location = "Address: " . $address->id;
                    }
                    echo '<option class="dropdown-item" ';
                    echo ' VALUE="' . $address->id . '" CITY="' . $address->city . '" PROVINCE="' . $address->province . '" APARTMENT="' . $address->apartment . '" ';
                    echo 'COUNTRY="' . $address->country . '" PHONE="' . $address->phone . '" MOBILE="' . $address->mobile . '" ';
                    echo 'ID="add' . $address->id . '" ADDRESS="' . $address->address . '" POSTAL="' . $address->postal_code . '" NOTES="' . $address->notes . '" onclick="addresschanged(this)">';
                    echo $address->location . ' [' . $address->address . ']';
                    echo '</option>';
                }
                ?>
                <!--option data-target="#editModel" data-toggle="modal" data-route="reservation" 
                        class="dropdown-item addNew" data-id='0' value="add_address">Add New Address
                </option-->
            </select>
            OR 
            <a data-target="#editModel" data-toggle="modal" data-route="reservation" 
                        class=" addNew btn btn-primary" data-id='0' value="add_address">Add New Address
                </a>
            <?php
            }
            ?>

    
    @endif
<?php }?>
@if($is_disabled)
        <input type="text" id="formatted_address<?php if (isset($type)) echo '';?>" disabled name="formatted_address"
               class="form-control"
               value="{{ (isset($addresse_detail->address))?$addresse_detail->address: old('address') }}" />
    @else
        <div class="nowrap <?php if (isset($type)) echo 'col-md-12';?>" <?php if (isset($type)&& read('id')) echo "style='display:none'";?>>
            <input type="text" name="<?php echo (isset($type)) ? 'address' : 'formatted_address';?>"
                   id="formatted_address<?php if (isset($type)) echo '';?>" class="form-control formatted_address"
                   placeholder="Enter your full address" value="<?php
            if (old('formatted_address')) {
                echo old('formatted_address');
                //} else if(isset($addresse_detail->address) && isset($addresse_detail->city) && isset($addresse_detail->province) && isset($addresse_detail->country)) {
            } else if (isset($addresse_detail->address)) {
                $country = "Canada";// select_field("countries", "id", $addresse_detail->country, "name");
                //echo $addresse_detail->address . ", " . $addresse_detail->city . ', ' . $addresse_detail->province . ', ' . $country;
                echo $addresse_detail->address;
            }
            ?>" autocomplete="off" />
        </div>
    @endif
</div>
</div></div>

    


<div class="hidden_elements" <?php if (isset($type) && $type == 'reservation'&& read('id')) echo "style='display:none;'";?> >

    <?php
    if ($isUser) {
        $aptUnit = "Apartment";
    } else {
        $aptUnit = "Unit";
    }
    echo newrow($new, $aptUnit . " #", "", false, 5); ?>
    <input type="text" name="apartment" class="form-control" {{ $is_disabled }} placeholder=""
           value="{{ (isset($addresse_detail->apartment))?$addresse_detail->apartment:old('apartment') }}">
</div></div>


<?= newrow($new, "City", "", $required, 5); ?>
<input required <?= $readonly; ?> type="text" id="city" name="city" class="form-control city" onfocus="this.blur();"
       value="{{ (isset($addresse_detail->city))?$addresse_detail->city:old('city') }}" {{$required}}>
</div></div>

<?= newrow($new, "Province", "", $required, 5); ?>
<input required <?= $readonly; ?> type="text" id="province" name="province" class="form-control province"
       onfocus="this.blur();"
       value="{{ (isset($addresse_detail->province))?$addresse_detail->province:old('province') }}" {{$required}}>
</div></div>

<?= newrow($new, "Postal Code", "", $required, 5); ?>
<input <?= $readonly; ?> type="text" name="postal_code" id="postal_code" onfocus="this.blur();"
       class="form-control postal_code" placeholder=""
       value="{{ (isset($addresse_detail->postal_code))?$addresse_detail->postal_code: old('postal_code') }}">
</div></div>

<?= newrow($new, "Country", "", $required, 5); ?>
<input <?= $readonly; ?> type="text" id="country" name="country" class="form-control" onfocus="this.blur();"
       value="{{ (isset($addresse_detail->country))?$addresse_detail->country:old('country') }}" {{$required}}>
</div></div>
</div>

<?php
if(isset($restSignUp)){

?>
<div id="verifyAddress" style="display:none">
    <?
    echo newrow($new, "Important", "", true, 10, true);
    ?>
    <div class="instruct">Please Ensure Address was Correctly Filled Out</div>
</div>

<?php
echo newrow();
}

if($isUser){
echo newrow($new, "Notes", "", false, 9);
?>

<input type="text" name="notes" class="form-control" {{ $is_disabled }} placeholder="Buzz Code, Side door, etc"
       value="{{ (isset($addresse_detail->notes))?$addresse_detail->notes:old('notes') }}">
</div></div>
<?php }
?>


<?php
if (isset($restEdit)) {
    /*
    echo newrow($new, "Save", "", "", 12, "Save");
    echo '<hr width="100%" align="center" /><span class="pull-right"><button type="submit" class="btn btn-primary pull-right">Save</button></span></div></div>';
    */
}

?>

<?php 

similar_text(\Request::path(),'user/addresses/edit', $per);

if(!read('id') || \Route::currentRouteName() == 'restaurants.signup.index' || $per >80){?>
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

    } else {
        includeJS(url("assets/global/scripts/provinces.js"));
        if (!includeJS("https://maps.googleapis.com/maps/api/js?signed_in=true&libraries=places&callback=initAutocomplete", "async defer")) {
            echo '<SCRIPT>initAutocomplete2();</SCRIPT>';
        }
    }
    ?>
@endif
<?php }?>