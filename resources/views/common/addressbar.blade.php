        <?php $sec =false; $type1 = "hidden";?>
        <ul class="nav navbar-nav">
            @if(Request::path() == '/' || (isset($searchTerm) && Request::path() == "restaurants/".$searchTerm) || (isset($slug) && Request::path() == "restaurants/".$slug."/menus"))
                <li class="nav-item" style="width: 100%;">
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
                                            echo  $address->location . ' [' . $address->address . ']';
                                            echo '</a>';
                                        }
                                    ?>
                                        <a  href="javascript:void(0);"data-target="#editModel" data-toggle="modal" id="addNew" class="dropdown-item">Add New Address</a>
                                        
                                </div>
                                <?php } ?>
                            @else
                                <button style="border-right:0;" class="btn  btn-secondary" onclick="geolocate(formatted_address3)" title="Get location from your browser">
                                    &nbsp;<i class="fa fa-map-marker"></i>&nbsp;</button>
                            @endif
                        </div>
                        <input style="width: 100%;" type="text" name="formatted_address" id="formatted_address3"
                               class="form-control formatted_address" placeholder="Address, City or Postal Code"
                               onchange="changeevent();" ignore_onkeyup="this.onchange();" onpaste="this.onchange();"
                               ignore_oninput="this.onchange();" data-route="reservation" />
                       
                   
                    </div>
                </li>
              
                 <?php
                //includeJS(url("assets/global/scripts/provinces.js"));
                //if (!includeJS("https://maps.googleapis.com/maps/api/js?signed_in=true&libraries=places&callback=initAutocomplete2&source=header", "async defer")) {
                   // echo '<SCRIPT>initAutocomplete2("formatted_address2","1");</SCRIPT>';
                //}
                ?>
            @endif
        </ul>