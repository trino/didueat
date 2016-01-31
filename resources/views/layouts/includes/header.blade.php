<?php
printfile("views/dashboard/layouts/includes/header.blade.php");
$first = false; $type = "hidden";
?>

<nav class="navbar navbar-default navbar-dark navbar-fixed-top bg-danger" role="navigation">

    <div class="">


        <a class="navbar-brand" href="{{ url('/') }}">
            <i class="fa fa-arrow-left pull-left" style="padding-top:5px;"></i>
            <img src="{{ asset('assets/images/logos/logo.png') }}" alt="diduEAT" style="height: 30px;"/>
        </a>
        <ul class="nav navbar-nav">
            @if(Request::path() == '/' || (isset($searchTerm) && Request::path() == "restaurants/".$searchTerm) || (isset($slug) && Request::path() == "restaurants/".$slug."/menus"))
                <li class="nav-item" style="width: 300px;">
                    <div class="input-group">
                        <div class="input-group-btn">
                            @if(read("id"))
                                <?php
                                    $addresses = \App\Http\Models\ProfilesAddresses::where('user_id', read("id"))->orderBy('order', 'ASC')->get();
                                    if($addresses->count()){
                                ?>
                                <button style="border-right:0;" type="button" class="btn btn-secondary " data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false"><span
                                            class="sr-only">Toggle Dropdown</span>&nbsp;<i class="fa fa-caret-down"></i>&nbsp;
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
                            @else
                                <button style="border-right:0;" class="btn  btn-secondary" onclick="geolocate(formatted_address2)" title="Get location from your browser">
                                    &nbsp;<i class="fa fa-map-marker"></i>&nbsp;</button>
                            @endif
                        </div>
                        <input style="width: 300px;" type="text" name="formatted_address" id="formatted_address2"
                               class="form-control formatted_address" placeholder="Address, City or Postal Code"
                               onchange="changeevent();" ignore_onkeyup="this.onchange();" onpaste="this.onchange();"
                               ignore_oninput="this.onchange();">
                        <input type="{{ $type }}" name="latitude2" id="latitude2">
                        <input type="{{ $type }}" name="latitude2" id="longitude2">
                        <div class="input-group-btn">
                            <button class="btn  btn-primary" oldstyle="display: none;" id="header-search-button"
                                    onclick="$('#search-form-submit').trigger('click');">
                                &nbsp;<i class="fa fa-search"></i>&nbsp;
                            </button>
                        </div>
                    </div>
                </li>

                <script>
                    var formatted_address2,  formatted_address3,  formatted_address;
                    function initAutocomplete2() {
                        formatted_address2 = initAutocompleteWithID('formatted_address2');
                        formatted_address3 = initAutocompleteWithID('formatted_address3');
                        foramtteed_address = initAutocompleteWithID('formatted_address')
                    }
                    function setaddress(Address) {
                        document.getElementById("formatted_address2").value = Address;
                        $("#formatted_address2").trigger("focus");
                        $("#formatted_address2").trigger("change");
                    }
                    function changeevent() {
                        //document.getElementById("formatted_address2").setAttribute("style", "background-color: red;");//debug
                        setTimeout(function () {
                            //document.getElementById("formatted_address2").setAttribute("style", "background-color: white;");//debug
                            if ($("#search-form").length) {
                                $("#header-search-button").show();
                            }
                        }, 100);
                    }

                </script>
                <?php
                includeJS(url("assets/global/scripts/provinces.js"));
                if (!includeJS("https://maps.googleapis.com/maps/api/js?signed_in=true&libraries=places&callback=initAutocomplete2&source=header", "async defer")) {
                    echo '<SCRIPT>initAutocomplete2();</SCRIPT>';
                }
                ?>
            @endif
        </ul>

        <div class="collapse navbar-toggleable-xs pull-right" id="exCollapsingNavbar2" style="">
            <ul class="nav navbar-nav">

                <li class="nav-item">
                    <h3>
                        Logged in as {{Session::get('session_type_user')}}
                    </h3>
                </li>



                @if(Session::has('is_logged_in'))
                    <li class="nav-item">
                        <a href="{{ url('dashboard') }}" class="nav-link">Hi, {{ explode(' ', Session::get('session_name'))[0] }} </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('dashboard') }}" class="nav-link">
                            <img src="<?php
                            $filename = 'assets/images/users/' . read("id") . "/" . Session::get('session_photo', "");
                            if (Session::has('session_photo') && file_exists(public_path($filename))) {
                                echo asset($filename);
                            } else {
                                echo asset('assets/images/default.png');
                            }
                            ?>" class="" style="height: 20px;">
                        </a>
                    </li>
                    @if (read("oldid"))
                        <li class="nav-item"><a href="{{ url('restaurant/users/action/user_depossess/' . read("oldid")) }} " class="nav-link">De-possess</a></li>
                    @endif
                    <li class="nav-item"><a href="{{ url('auth/logout') }}" class="nav-link">Log Out</a></li>
                @else
                    <li class="nav-item">
                        <a class="btn btn-danger" data-toggle="modal" data-target="#loginModal">Log in</a>
                        <a class="btn btn-danger" data-toggle="modal" data-target="#signupModal">Sign up</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>