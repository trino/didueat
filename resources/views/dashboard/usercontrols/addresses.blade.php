<select class="form-control reservation_address_dropdown required" name="reservation_address" id="reservation_address" required ONCHANGE="addresschange('editaddress');">
    <option selected="selected">Select Address</option>
    <?php //address selection dropdown, could use common.addressbar
        if(!isset($addresses)){
            $addresses = select_field("profiles_addresses", "user_id", read("id"), false);
        }
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