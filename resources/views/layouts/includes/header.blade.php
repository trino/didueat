<?php printfile("views/dashboard/layouts/includes/header.blade.php"); $first = false; ?>

<nav class="navbar navbar-default navbar-dark navbar-fixed-top primary_red" role="navigation">
    <button class="navbar-toggler hidden-xs-up" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar2">
        &#9776;
    </button>

    <a class="navbar-brand" href="{{ url('/') }}">
        <img src="{{ asset('assets/images/logos/logo.png') }}" alt="diduEAT" style="height: 30px;"/>
    </a>
    <ul class="nav navbar-nav">

        @if(Request::path() == '/' || (isset($searchTerm) && Request::path() == "restaurants/".$searchTerm) || (isset($slug) && Request::path() == "restaurants/".$slug."/menus"))
            <LI class="nav-item">
                <button class="btn btn-primary headerbutton" onclick="geolocate(formatted_address2)" title="Get location from your browser">
                    <i class="fa fa-compass"></i>
                </button>
            </LI>
            <li class="nav-item">
                <input type="text" name="formatted_address" id="formatted_address2" class="form-control formatted_address" placeholder="Address, City or Postal Code"
                       onchange="changeevent();" ignore_onkeyup="this.onchange();" onpaste="this.onchange();" ignore_oninput="this.onchange();">
            </li>
            @if(read("id"))
                <?php
                    $addresses = \App\Http\Models\ProfilesAddresses::where('user_id', read("id"))->orderBy('order', 'ASC')->get();
                    if($addresses->count()){
                ?>
                    <LI class="nav-item" style="margin-left: 0px;">
                        <div class="dropdown">
                            <button class="btn btn-primary " type="button" data-toggle="dropdown"  style="height:38px;">
                                <i class="fa fa-caret-down"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <?php
                                    foreach($addresses as $address){
                                        if(!$first){$first = $address->id;}
                                        if(!trim($address->location)){
                                            $address->location = "Address: " . $address->id;
                                        }
                                        echo '<LI><DIV CLASS="nowrap"><A ID="addy' . $address->id . '" ONCLICK="setaddress(' . "'" . addslashes($address->address) . "'" . ');">' . $address->location . '</A> [<font size="2">' . $address->address . '</font>]</DIV></LI>';
                                    }
                                ?>
                            </ul>
                        </div>
                    </LI>
                <?php } ?>
            @endif
            <LI class="nav-item">
                <button class="btn btn-primary headerbutton" oldstyle="display: none;" id="header-search-button" onclick="$('#search-form-submit').trigger('click');">
                    <i class="fa fa-search"></i>
                </button>
            </LI>
            <script>
                var formatted_address2;
                function initAutocomplete2(){
                    formatted_address2 = initAutocompleteWithID('formatted_address2');
                }
                function setaddress(Address){
                    document.getElementById("formatted_address2").value = Address;
                    $("#formatted_address2").trigger("focus");
                    $("#formatted_address2").trigger("change");
                }
                function changeevent(){
                    //document.getElementById("formatted_address2").setAttribute("style", "background-color: red;");//debug
                    setTimeout(function() {
                        //document.getElementById("formatted_address2").setAttribute("style", "background-color: white;");//debug
                        if($("#search-form").length) {
                            $("#header-search-button").show();
                        }
                    }, 100);
                }
                @if($first)
                    //$("#addy{{ $first }}").trigger("click");
                @endif
            </script>
            <?php
                includeJS(url("assets/global/scripts/provinces.js"));
                if (!includeJS("https://maps.googleapis.com/maps/api/js?signed_in=true&libraries=places&callback=initAutocomplete2&source=header", "async defer")){
                    echo '<SCRIPT>initAutocomplete2();</SCRIPT>';
                }
            ?>
        @endif
    </ul>

    <div class="collapse navbar-toggleable-xs pull-right" id="exCollapsingNavbar2">
        <ul class="nav navbar-nav">

            @if(Session::has('is_logged_in'))

                <li class="nav-item">
                    <a href="{{ url('dashboard') }}" class="nav-link">
                        Hi, {{ explode(' ', Session::get('session_name'))[0] }} </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('dashboard') }}" class="nav-link">
                        <img src="<?php if (Session::has('session_photo')) {
                            echo asset('assets/images/users/' . Session::get('session_photo'));
                        } else {
                            echo asset('assets/images/default.png');
                        } ?>" class="" style="height: 20px;">
                    </a>
                </li>

                @if (read("oldid"))
                     <li class="nav-item"><a href="{{ url('restaurant/users/action/user_depossess/' . read("oldid")) }} " class="nav-link">De-possess</a></li>
                @endif

                <li class="nav-item"><a href="{{ url('auth/logout') }}" class="nav-link">Log Out</a></li>

            @else
                <li class="nav-item">
                    <a class="btn btn-danger secondary_red pull-right" data-toggle="modal" data-target="#loginModal">
                        Log in
                    </a>
                </li>

                <li class="nav-item">
                    <a class="btn btn-danger secondary_red pull-right" data-toggle="modal" data-target="#signupModal">
                        Sign up
                    </a>
                </li>
            @endif
        </ul>
    </div>
</nav>