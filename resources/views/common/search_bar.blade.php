@if(Request::path() == '/' || (isset($searchTerm) && Request::path() == "restaurants/".$searchTerm) || (isset($slug) && Request::path() == "restaurants/".$slug."/menu"))
    <div>
        <FORM ID="addressbar" onsubmit="return false;">
        <div class="input-group input-group-lg">
            @if(read("id") && false)
                <div class="input-group-btn">
                    <?php
                        //this is the address dropdown search bar that used to go in the header
                        $addresses = \App\Http\Models\ProfilesAddresses::where('user_id', read("id"))->orderBy('order', 'ASC')->get();
                        if($addresses->count()){ ?>
                            <button type="button" class="btn btn-secondary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="sr-only">Toggle Dropdown</span>&nbsp;<i class="fa fa-caret-down"></i>&nbsp;
                            </button>
                            <div class="dropdown-menu dropdown-menu-left">
                                <?php
                                    foreach ($addresses as $address) {
                                        if (!$first) {
                                            $first = $address->id;
                                        }
                                        if (!trim($address->location)) {
                                            $address->location = "Address: " . $address->id;
                                        }
                                        echo '  <a class="dropdown-item" href="#" id="addy' . $address->id . '" onclick="setaddress(' . "'" . addslashes($address->address) . "'" . ');">';
                                        echo $address->location . ' [' . $address->address . ']</a>';
                                    }
                                ?>
                            </div>
                    <?php } ?>
                </div>
            @endif

            <?php
                $Type = iif(debugmode(), 'TEXT" TITLE="THESE ARE ONLY VISIBLE IN DEBUG MODE', 'HIDDEN'); //address search bar
                $alts = array(
                    "search" => "Search for this address"
                );
            ?>
            <input type="text" name="formatted_address" id="formatted_address2"
                   class="form-control formatted_address" placeholder="Enter your address"
                   onchange="change_address_event();"
                   @if(isset($_GET["search"]))
                           value="{{ $_GET["search"] }}"
                   @endif
                   onpaste="this.onchange();">
            <script>
                    (window.navigator.userAgent.indexOf("MSIE")!=-1 || !!navigator.userAgent.match(/Trident.*rv\:11\./))? document.getElementById('formatted_address2').style.height='53px' :'';
            </script>
            <input type="{{ $Type }}" name="latitude" id="latitude" style="color: black;" placeholder="latitude">
            <input type="{{ $Type }}" name="longitude" id="longitude" style="color: black;" placeholder="longitude">

            <input type="{{ $Type }}" name="city" id="city" style="color: black;" placeholder="city">
            <input type="{{ $Type }}" name="province" id="province" style="color: black;" placeholder="province">
            <input type="{{ $Type }}" name="postal_code" id="postal_code" style="color: black;" placeholder="postal_code">
            <input type="{{ $Type }}" name="country" id="country" style="color: black;" placeholder="country">

            @if(debugmode())
                <A class="btn" onclick="googlemap(this);" target="_blank"><i class="fa fa-globe" style="color:blue;"></i></A>
            @endif
            <span class="input-group-btn" style="vertical-align: top;">
                <button style="border: 1px solid #5cb85c !important;" class="btn  btn-success dueBtn" oldstyle="display: none;" id="header-search-button" onclick="$('#search-form-submit').trigger('click');" title="{{ $alts["search"] }}">
                    <i class="fa fa-search"></i>
                </button>
            </span>
        </div>
        </FORM>
       <!-- Or view all restaurants from <A class="stroke-black-1px" onclick="setaddress('Hamilton, ON, Canada');">Hamilton</A> or <A class="stroke-black-1px" onclick="cities();">a list of cities</A> -->
    </div>

    <script>
        var formatted_address2, formatted_address3;

        function googlemap(element){
            $(element).attr("href", 'http://maps.google.com/?q=' + $("#latitude").val() + ',' + $("#longitude").val() );
        }

        function initAutocomplete2() {
            formatted_address2 = initAutocompleteWithID('formatted_address2');
            formatted_address3 = initAutocompleteWithID('formatted_address3');
        }

        function setaddress(Address) {
            document.getElementById("formatted_address2").value = Address;
            $("#formatted_address2").trigger("focus");
            $("#formatted_address2").trigger("change");

            setTimeout(function () {
                $(".pac-container.pac-logo").hide();
            }, 100);

            $('#formatted_address2').trigger('blur');
        }

        function change_address_event() {
            setTimeout(function () {
                if ($("#search-form").length) {
                    $("#header-search-button").show();
                }

                if ($("#formatted_address2").val()) {
                    $('#search-form-submit').trigger('click');
                }
            }, 100);
        }

        function cities(){
            $('#restuarant_bar').html('');
            $('#parentLoadingbar').show();
            $('#start_up_message').hide();
           // $('#icons_show').hide();
            $('#results_show').show();
            $.post("{{ url('/restaurant/cities') }}", {token: token}, function (result) {
                var quantity = 0;
                $('#parentLoadingbar').hide();
                $('#restuarant_bar').html(result);
            });
        }
    </script>

    <?php
        printfile("views/common/search_bar.blade.php");
        includeJS(url("assets/global/scripts/provinces.js"));
        if (!includeJS("https://maps.googleapis.com/maps/api/js?signed_in=true&libraries=places&callback=initAutocomplete2&source=header", "async defer")) {
            echo '<SCRIPT>initAutocomplete2();</SCRIPT>';
        }
    ?>
    <script>
        <?php if ($first) {
            echo '$("#addy' . $first . '").trigger("click");';
        } ?>
    </script>
@endif