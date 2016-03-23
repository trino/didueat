<?php
    printfile("views/common/addressbar.blade.php");
    $sec = false;
    $type1 = "hidden";
    $alts = array(
            "add" => "Create a new address",
            "thisaddress" => "Select this address",
            "toggle" => "Show/Hide the dropdown"
    );
?>
<ul class="nav navbar-nav">

    <li class="nav-item" style="width: 100%;">
        <div class="input-group">
            <div class="input-group-btn addressdropdown">
            @if(Request::path() == '/' || (isset($searchTerm) && Request::path() == "restaurants/".$searchTerm) || (isset($slug) && Request::path() == "restaurants/".$slug."/menu"))
                @if(read("id"))
                    <?php
                        $addresses = \App\Http\Models\ProfilesAddresses::where('user_id', read("id"))->orderBy('order', 'ASC')->get();
                        if($addresses->count()){
                    ?>

                    <button style="border-right:0;" type="button" class="btn btn-secondary " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="{{ $alts["toggle"] }}">
                        <span class="sr-only">Toggle Dropdown</span>&nbsp;
                        <i class="fa fa-caret-down"></i>&nbsp;
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
                                echo '  <a class="dropdown-item" title="' . $alts["thisaddress"] . '"';
                                echo ' VALUE="' . $address->id . '" CITY="' . $address->city . '" PROVINCE="' . $address->province . '" APARTMENT="' . $address->apartment . '" ';
                                echo 'COUNTRY="' . $address->country . '" PHONE="' . $address->phone . '" MOBILE="' . $address->mobile . '" ';
                                echo 'ID="add' . $address->id . '" ADDRESS="' . $address->address . '" POSTAL="' . $address->postal_code . '" NOTES="' . $address->notes . '" onclick="addresschanged(this)">';
                                echo  $address->location . ' [' . $address->address . ']';
                                echo '</a>';
                            }
                        ?>
                        <a href="#" data-target="#editModel" data-toggle="modal" data-route="reservation" title="{{ $alts["add"] }}" id="addNew" class="dropdown-item">Add New Address</a>
                    </div>

                    <?php } ?>

                @endif
            @endif
            </div>
            <input style="width: 100%;" type="text" name="formatted_address" id="formatted_address3"
                   class="form-control formatted_address" placeholder="Enter Your Address"
                   ignore_onkeyup="this.onchange();" onpaste="this.onchange();"
                   ignore_oninput="this.onchange();" data-route="reservation" />
           <input id="latitude3" type="hidden" name="latitude3" value="">
           <input id="longitude3" type="hidden" name="latitude3" value="">

        </div>
    </li>
</ul>