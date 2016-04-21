<?php
    printfile("views/common/editaddress.blade.php");

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
    $aptUnit="Unit/Apt";
    $GUID = "";//guidv4();
    if(!isset($mini)){$mini = false;}
    $Commas = false;

    $alts = array(
            "contactus" => "Contact us",
            "add" => "Create a new address"
    );
?>

<input type="hidden" name="latitude" id="latitude" value="{{ (isset($addresse_detail->latitude))?$addresse_detail->latitude: old('latitude') }}"/>
<input type="hidden" name="longitude" id="longitude" value="{{ (isset($addresse_detail->longitude))?$addresse_detail->longitude: old('longitude') }}"/>
<input type="hidden" name="formatted_addressForDB" id="formatted_addressForDB"/>

<div class="<?php if (!isset($type)) echo "";?> addressdropdown">

    @if(isset($GLOBALS['thisIdentity']))
        <div class="form-group">
            <div class="col-sm-12">
                <p class="">If the restaurant's address needs changing, please <a href="mailto:info@didueat.ca?subject=Address%20Change%20On%20Didu%20Eat&amp;body=Please Update the Address as Follows:%0A%0A
{{ $GLOBALS['thisIdentity'] }}
                            %0A%0A
                            Full Updated Address:
                            %0A%0A
                            %0A%0A
                            %0A%0A
                            %0A%0A
                            %0A%0A
                            Your Name:
                            %3A%0A%0A
                            Contact Number:
                            %3A%0A%0A
                            Thank you" style="text-decoration:underline" title="{{ $alts["contactus"] }}">Email Support</a></p>

            </div>
        </div>
    @endif

<?php
    echo newrow($new, (!isset($type)) ? "Address" : "Address", "", true);
    if(read('id')){
        ?>
    @if( (Request::path() == '/' || Request::path()=='restaurants/chuck-burger-bar/menu' || (isset($searchTerm) && Request::path() == "restaurants/".$searchTerm) || (isset($slug) && Request::path() == "restaurants/".$slug."/menu")))

        <?php
            $addresses = \App\Http\Models\ProfilesAddresses::where('user_id', read("id"))->orderBy('order', 'ASC')->get();
            if(!isset($type)){
                if($addresses->count()){
        ?>
            <button style="border-right:0;" type="button" class="btn btn-secondary " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="sr-only">Toggle Dropdown</span>&nbsp;<i class="fa fa-caret-down"></i>&nbsp;
            </button>
            <div class="dropdown-menu dropdown-menu-left">
                <?php //address dropdown as an A HREF instead of SELECT OPTION
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
                <a href="#" data-target="#editModel" data-toggle="modal" data-route="reservation" id="addNew" title="{{ $alts["add"] }}" class="dropdown-item">Add New Address</a>
            </div>
            <?php }
            }else{

            ?>

            <SPAN @if(!$addresses->count()) id="show-addaddress" style="display:none;" @endif >
                <select class=" form-control reservation_address_dropdown required" name="reservation_address" id="reservation_address" required ONCHANGE="addresschange('editaddress');">
                    <option value="">Select Address</option>
                    <?php //address selection dropdown, could use common.addressbar
                        $sec = false;
                        foreach ($addresses as $address) {
                            if (!$sec) {
                                $sec = $address->id;
                            }
                            echo '<option class="dropdown-item" REQUIRED';
                            echo ' VALUE="' . $address->id . '" CITY="' . $address->city . '" PROVINCE="' . $address->province . '" APARTMENT="' . $address->apartment . '" ';
                            echo ' COUNTRY="' . $address->country . '" PHONE="' . $address->phone . '" MOBILE="' . $address->mobile . '" LATITUDE="' . $address->latitude . '" LONGITUDE="' . $address->longitude . '"';
                            echo ' ID="add' . $address->id . '" ADDRESS="' . $address->address . '" POSTAL="' . $address->postal_code . '" NOTES="' . $address->notes . '" onclick="addresschanged(this)">';
                            echo $address->address . '</option>';
                        }
                    ?>

                </select>
                or
            </SPAN>
        
            <a href="#" data-target="#editModel" data-toggle="modal" data-route="reservation" class="addNew" title="{{ $alts["add"] }}" data-id='0' value="add_address">Add New Address</a>
            <?php
            }
            ?>


    @endif
<?php }?>
    <INPUT TYPE="HIDDEN" NAME="GUID" VALUE="{{ $GUID }}">
    @if($is_disabled)
        <input type="text" id="formatted_address" disabled name="formatted_address{{ $GUID }}"
               class="form-control"
               value="{{ (isset($addresse_detail->address))?$addresse_detail->address: old('address') }}" />
    @else
        <div class="nowrap <?php if (isset($type)) echo '';?>" <?php if (isset($type)&& read('id')) echo "style='display:none'";?>>
            <input type="text" name="<?php echo (isset($type)) ? 'address' : 'formatted_address' . $GUID;?>" required
                   id="formatted_address" class="form-control formatted_address"
                   placeholder="Enter your address"
                   autocomplete="off"
                   onclick="$(this).attr('autocomplete', 'false');"  
                   value="<?php
            $checkCookie = true;
            if (old('formatted_address')) {
                echo old('formatted_address');
                //} else if(isset($addresse_detail->address) && isset($addresse_detail->city) && isset($addresse_detail->province) && isset($addresse_detail->country)) {
            } else if (isset($addresse_detail->address)) {
                $country = "Canada";// select_field("countries", "id", $addresse_detail->country, "name");
                //echo $addresse_detail->address . ", " . $addresse_detail->city . ', ' . $addresse_detail->province . ', ' . $country;
                echo $addresse_detail->address;
            }
            ?>"/>
        </div>
    @endif
</div>
<?= newrow(); ?>


<div class="hidden_elements" <?php if (isset($type) && $type == 'reservation'&& read('id')) echo "style='display:none;'";?> >
    <?= newrow($new, $aptUnit, "", false, 5); ?>
    <input type="text" name="apartment" class="form-control" {{ $is_disabled }} placeholder=""
           value="{{ (isset($addresse_detail->apartment))?$addresse_detail->apartment:old('apartment') }}">
        <?= newrow(); ?>

@if($mini)
    <?php echo newrow($new, " ", "", false, 9);
    $WasVisible = false;
    foreach(array("city" => true, "province" => true, "postal_code" => true, "country" => false) as $field => $visible){
        $Value = (isset($addresse_detail->$field))?$addresse_detail->$field:old($field);
        if($visible){
            if ($visible && $WasVisible){echo '<SPAN CLASS="commas">, </SPAN>';}
            echo '<span class="' . $field . '" value="' . $Value . '">' . $Value . '</SPAN>';
        }
        echo '<INPUT TYPE="HIDDEN" VALUE="' . $Value . '" ID="' . $field . '" CLASS="' . $field . '" NAME="' . $field . '">';
        if($Value){$Commas  = true;}
        $WasVisible=$visible;
    } ?>
    </DIV></DIV>
@else
    <?= newrow($new, "City", "", $required, 5); ?>
    <input required <?= $readonly; ?> type="text" id="city" name="city" class="form-control city"
           value="{{ (isset($addresse_detail->city))?$addresse_detail->city:old('city') }}" {{$required}}>
    </div></div>

    <?= newrow($new, "Province", "", $required, 5); ?>
    <input required <?= $readonly; ?> type="text" id="province" name="province" class="form-control province"
           onfocus="this.blur();"
           value="{{ (isset($addresse_detail->province))?$addresse_detail->province:old('province') }}" {{$required}}>
    </div></div>

    <?= newrow($new, "Postal Code", "", $required, 5); ?>
    <input <?= $readonly; ?> type="text" name="postal_code" id="postal_code" 
           class="form-control postal_code" placeholder="" {{$required}}
           value="{{ (isset($addresse_detail->postal_code))?$addresse_detail->postal_code: old('postal_code') }}">
    </div></div>
    <DIV id="pcNotFnd" style="display:none;margin-top:0px;margin-bottom:10px;color: red" class="col-md-12 pull-right"></div>

    <?= newrow($new, "Country", "", $required, 5); ?>
    <input <?= $readonly; ?> type="text" id="country" name="country" class="form-control"
           value="{{ (isset($addresse_detail->country))?$addresse_detail->country:old('country') }}" {{$required}}>
    </div></div>
    </div>
@endif

<?php if(isset($restSignUp)){ ?>
<div id="verifyAddress" style="display:none">
    <?= newrow($new, "Important", "", true, 10, true); ?>
    <div class="instruct">Please Ensure Address was Correctly Filled Out</div>
</div>

<?php
    echo newrow();
}

if($isUser){
    echo newrow($new, "Notes", "", false, 9); ?>
        <input type="text" name="notes" class="form-control" {{ $is_disabled }} placeholder="Buzz Code, Side door, etc" value="{{ (isset($addresse_detail->notes))?$addresse_detail->notes:old('notes') }}">
    </div></div>
<?php }

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
    <?php //handle initializing the autocomplete
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

<DIV id="error-message" style="color: red" class="col-md-12"></div>
<DIV CLASS="clearfix"></DIV>
<SCRIPT>
    //check if the address is complete
    function isaddress_incomplete(){
        var incomplete = !$("#formatted_address").val() || !$("#city").val() || !$("#province").val() || !$("#postal_code").val() || !$("#country").val();
        $("#error-message").text("");
        if(incomplete){
            var error = "Please input your exact address";
            if(!$("#postal_code").val()){
                error = "Part of your address is missing!";
            }
            $("#error-message").text(error);
        }
        return incomplete;
    }

    @if($mini && !$Commas)
        $(".commas").hide();//hide the commas if there is no data yet
    @endif

    @if(isset($checkCookie) && $checkCookie)
        if(getCookie("address")){
            $("#formatted_addressForDB").val(getCookie("address"));
            $("#formatted_address").val(getCookie("address"));
            $("#city").val(getCookie("city"));
            $("#country").val(getCookie("country"));
            $("#postal_code").val(getCookie("postal_code"));
            $("#province").val(getCookie("province"));
            $("#latitude").val(getCookie("latitude"));
            $("#longitude").val(getCookie("longitude"));
        }
    @endif
</SCRIPT>