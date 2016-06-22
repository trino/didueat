<script src="{{ asset('assets/global/scripts/jquery.timepicker.js') }}"></script>
<link href="{{ asset('assets/global/css/timepicker.css') }}" rel="stylesheet"/>

@if(Request::path() == '/' || (isset($searchTerm) && Request::path() == "restaurants/".$searchTerm) || (isset($slug) && Request::path() == "restaurants/".$slug."/menu"))
    @if(read("id") && false)
        <div class="input-group-btn">
            <?php
            //this is the address dropdown search bar that used to go in the header
            $addresses = \App\Http\Models\ProfilesAddresses::where('user_id', read("id"))->orderBy('order', 'ASC')->get();
            if($addresses->count()){
            ?>
            <button type="button" class="btn btn-secondary" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
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
    <FORM ID="addressbar" onsubmit="return false;">

      Bring

        <select name="cuisine" id="cuisine" onchange="createCookieValue('cuisine', this.value)">
            <option value="">All Cuisine</option>
            @foreach($cuisine as $value)
                <option>{{ $value }}</option>
            @endforeach
        </select>
        To
        <?php
            $Type = 'HIDDEN';// iif(debugmode(), 'TEXT" TITLE="THESE ARE ONLY VISIBLE IN DEBUG MODE', 'HIDDEN'); //address search bar
            $alts = array(
                    "search" => "Search for this address"
            );
        ?>

        <input STYLE="width: 300px;" type="text" name="formatted_address" id="formatted_address2"
               class="formatted_address" placeholder="Enter your address"
               onchange="change_address_event();"
               @if(isset($_GET["search"]))
               value="{{ $_GET["search"] }}"
               @endif
               onpaste="this.onchange();">

<BR>
        At
        <select style="width:120px;" name="delivery-time" id="delivery-time" onchange="searchtimechange();">
            <option value="">Order ASAP</option>
            {{ get_time_interval() }}
        </select>


        <!--script>
            (window.navigator.userAgent.indexOf("MSIE") != -1 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) ? document.getElementById('formatted_address2').style.height = '53px' : '';
        </script-->

        <input type="{{ $Type }}" name="latitude" id="latitude" style="color: black;" placeholder="latitude">
        <input type="{{ $Type }}" name="longitude" id="longitude" style="color: black;" placeholder="longitude">
        <input type="{{ $Type }}" name="city" id="city" style="color: black;" placeholder="city">
        <input type="{{ $Type }}" name="province" id="province" style="color: black;" placeholder="province">
        <input type="{{ $Type }}" name="postal_code" id="postal_code" style="color: black;" placeholder="postal_code">
        <input type="{{ $Type }}" name="country" id="country" style="color: black;" placeholder="country">

        @if(debugmode())
            <A class="btn" onclick="googlemap(this);" target="_blank"><i class="fa fa-globe" style="color:blue;"></i></A>
        @endif
        <button style="" class="btn btn-success dueBtn"
                oldstyle="display: none;" id="header-search-button"
                onclick="$('#search-form-submit').trigger('click');" title="{{ $alts["search"] }}">
            <i class="fa fa-search"></i>
        </button>


        <!--div class="input-group" style="margin-bottom:0 !important; width: 100%">
            <TABLE class="searchtable" width="100%">
                    <TD width="15%"> At </TD>
                    <TD width="20%">
                        <INPUT TYPE="TEXT" CLASS="form-control time col-xs-4" name="delivery-time" id="delivery-time" placeholder="ASAP" onchange="$('#ordered_on_time').val( $('#delivery-time').val() );">
                    </TD>
                    <TD width="20%"> Bring </TD>
                    <TD width="25%">
                        <select name="cuisine" id="cuisine" class="form-control" onchange="createCookieValue('cuisine', this.value)">
                            <option value="">All Cuisine</option>
                            @foreach($cuisine as $value)
                                <option>{{ $value }}</option>
                            @endforeach
                        </select>
                    </TD>
                    <TD width="20%"> To </TD>
            </TABLE>
        </div-->

        
    </FORM>
    <!-- Or view all restaurants from <A class="stroke-black-1px" onclick="setaddress('Hamilton, ON, Canada');">Hamilton</A> or <A class="stroke-black-1px" onclick="cities();">a list of cities</A> -->

    <script>
        var formatted_address2, formatted_address3;

        function googlemap(element) {
            $(element).attr("href", 'http://maps.google.com/?q=' + $("#latitude").val() + ',' + $("#longitude").val());
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

        function cities() {
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

        function searchtimechange(){
            $("#ordered_on_time").val( $("#delivery-time").val() );
        }

        if(getCookie("cuisine")){
            $("#cuisine").val(getCookie("cuisine"));
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