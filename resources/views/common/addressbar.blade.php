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