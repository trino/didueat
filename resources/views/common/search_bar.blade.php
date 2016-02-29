@if(Request::path() == '/' || (isset($searchTerm) && Request::path() == "restaurants/".$searchTerm) || (isset($slug) && Request::path() == "restaurants/".$slug."/menu"))
    <div class="" style="">
        <div class="input-group input-group-lg">

            @if(read("id") && false)
                <div class="input-group-btn">
                    <?php
                        $addresses = \App\Http\Models\ProfilesAddresses::where('user_id', read("id"))->orderBy('order', 'ASC')->get();
                        if($addresses->count()){
                    ?>
                    <button style="" type="button" class="btn btn-secondary" data-toggle="dropdown" aria-haspopup="true"
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
                            echo '  <a class="dropdown-item" href="#" id="addy' . $address->id . '" onclick="setaddress(' . "'" . addslashes($address->address) . "'" . ');">' . $address->location . ' [' . $address->address . ']</a>';
                        }
                        ?>
                    </div>
                    <?php } ?>
                </div>
            @endif

            <input style="" type="text" name="formatted_address" id="formatted_address2"
                   class="form-control formatted_address btn-responsive" placeholder="Enter your address"
                   onchange="change_address_event();"
                   onfocus="hideresults();"
                   onpaste="this.onchange();">
            <input type="HIDDEN" name="latitude" id="latitude" value="{{ (isset($latHam))? $latHam : '' }}">
            <input type="HIDDEN" name="latitude" id="longitude" value="{{ (isset($lonHam))? $lonHam : '' }}">
      <span class="input-group-btn">

                <button class="btn  btn-success dueBtn btn-responsive" oldstyle="display: none;" id="header-search-button"
                        onclick="$('#search-form-submit').trigger('click');"><i class="fa fa-search"></i>
                </button>
</span>
        </div>
    </div>

    <script>
        var formatted_address2, formatted_address3;

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