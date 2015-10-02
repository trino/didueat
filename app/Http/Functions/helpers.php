<?php

function test(){
    DB::enableQueryLog();
    return;

    $Test = enum_genres();
    debug($Test);
    die();
}



//func count orders
function countOrders($type='pending'){
    return DB::table('reservations')->where('status', $type)->count();
}

//////////////////////////////////////////////////PROFILE TYPES API/////////////////////////////////////////////////////
function new_profiletype($Name){
    logevent("Made a new profile type: " . $Name, false);
    return new_anything("profiletypes", $Name);
}

function get_profile_permissions(){//lists all permissions
    return getColumnNames("profiletypes", array("ID", "Name", "Hierarchy"));
}

function enum_profiletypes($Hierarchy = "", $toArray = true){
    $Condition = "1=1";
    if($Hierarchy){
        $Condition = "Hierarchy > " . $Hierarchy;
    }
    $entries = enum_all("profiletypes", $Condition);
    if($toArray) {return my_iterator_to_array($entries, "ID", "Name");}
    return $entries;
}

function fileinclude($Filename){//pass __FILE__
    if ($_SERVER["SERVER_NAME"]){
        return '<FONT COLOR="RED">Include: ' . $Filename . '</FONT>';
    }
}

function edit_profiletype($ID = "", $Name, $Hierarchy, $Permissions = ""){
    if(!$ID){
        $ID = new_profiletype($Name);
    }
    logevent("Changed profile type: " . $ID . " (" . $Name . ", " . $Hierarchy . ", " . print_r($Permissions, true) . ")", false);
    $data = array("Name" => $Name, "Hierarchy" => $Hierarchy);
    if ($Permissions == "ALL"){
        $Permissions = get_profile_permissions();
    }
    if (is_array($Permissions)) {
        foreach ($Permissions as $Permission) {
            $data[$Permission] = "1";
        }
    }
    update_database("profiletypes", "ID", $ID, $data);
    return $ID;
}

////////////////////////////////////Profile API/////////////////////////////////////////
function read($Name){
    return Session::get('Profile.' . $Name);
}
function write($Name, $Value){
    Session::put('Profile.' . $Name, $Value);
}
function salt(){
    return "18eb00e8-f835-48cb-bbda-49ee6960261f";
}

function enum_profiles($Key, $Value){
    return enum_all('profiles', $Key, $Value);
}

function get_profile($ID = ""){
    if(!$ID){$ID=read("ID");}
    return get_entry("profiles", $ID);
}

function is_email_in_use($EmailAddress, $NotByUserID=0){
    $EmailAddress = clean_email($EmailAddress);
    if($NotByUserID) {
        return first("SELECT * FROM profiles WHERE Email = '" . $EmailAddress. "' AND ID != " . $NotByUserID);
    } else {
        return get_entry("profiles",$EmailAddress, "Email");
    }
}

function get_profile_type($ProfileID, $GetByType = false){
    if($GetByType){return get_entry("profiletypes", $ProfileID);}
    $profiletype = get_entry("profiles", $ProfileID, "ID")->profileType;
    return get_entry("profiletypes", $profiletype);
}

function can_profile_create($ProfileID, $ProfileType){
    $creatorprofiletype = get_profile_type($ProfileID);
    if($creatorprofiletype->CanCreateProfiles){
        $ProfileType = get_profile_type($ProfileType, true);
        return $creatorprofiletype->Hierarchy < $ProfileType->Hierarchy;
    }
}

function randomPassword($Length=8) {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = "";
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < $Length; $i++) {
        $n = rand(0, $alphaLength);
        $pass .= $alphabet[$n];
    }
    return $pass;
}

function is_valid_email($EmailAddress){
    //http://php.net/manual/en/function.filter-var.php
    //filter_var can also validate: FILTER_VALIDATE_IP FILTER_VALIDATE_INT FILTER_VALIDATE_BOOLEAN FILTER_VALIDATE_URL FILTER_SANITIZE_STRING
    //flags FILTER_NULL_ON_FAILURE FILTER_FLAG_PATH_REQUIRED FILTER_FLAG_STRIP_LOW FILTER_FLAG_STRIP_HIGH
    $EmailAddress = clean_email($EmailAddress);
    if ($EmailAddress && filter_var($EmailAddress, FILTER_VALIDATE_EMAIL)) {
        return $EmailAddress;
    }
}

function find_profile($EmailAddress, $Password){
    //echo salt();die();
    $EmailAddress = clean_email($EmailAddress);
    $Password = md5($Password . salt());
    return enum_all("profiles", array("Email" => $EmailAddress, "Password" => $Password))->first();
}

function new_profile($CreatedBy, $Name, $Password, $ProfileType, $EmailAddress, $Phone, $RestaurantID, $Subscribed = ""){
    $EmailAddress = is_valid_email($EmailAddress);
    $Phone=clean_phone($Phone);
    if(!$EmailAddress){return false;}
    if(get_entry("profiles", $EmailAddress, "Email")){return false;}
    if(!$Password){$Password=randomPassword();}
    if($Subscribed){$Subscribed=1;} else {$Subscribed =0;}
    $data = array("Name" => trim($Name), "ProfileType" => $ProfileType, "Phone" => $Phone, "Email" => $EmailAddress, "CreatedBy" => 0, "RestaurantID" => $RestaurantID, "Subscribed" => $Subscribed, "Password" => md5($Password . salt()));
    if($CreatedBy){
        if(!can_profile_create($CreatedBy, $ProfileType)){return false;}
        $data["CreatedBy"] = $CreatedBy;
    }
    $data = edit_database("profiles", "ID", "", $data);
    if($CreatedBy){
        logevent("Created user: " . $data["ID"] . " (" . $data["Name"] . ")");
    }
    $data["Password"] = $Password;
    handleevent($EmailAddress, "new_profile", array("Profile" => $data));
    set_subscribed($EmailAddress,$Subscribed);
    return $data;
}

function edit_profile($ID, $Name, $EmailAddress, $Phone, $Password, $Subscribed = 0, $ProfileType = 0){
    $data = array("Name" => trim($Name), "Email" => clean_email($EmailAddress), "Phone" => clean_phone($Phone), "Subscribed" => $Subscribed);
    if($Password){
        $data["Password"] = md5($Password . salt());
    }
    if($ProfileType){
        $data["ProfileType"] = $ProfileType;
    }
    set_subscribed($EmailAddress,$Subscribed);
    return update_database("profiles", "ID", $ID, $data);
}

function login($Profile){
    if (is_numeric($Profile)){
        $Profile = get_profile($Profile);
    } else if (is_array($Profile)){
        $Profile = (object) $Profile;
    }
    write('ID',            $Profile->ID);
    write('Name',          $Profile->Name);
    write('Email',         $Profile->Email);
    write('Type',          $Profile->ProfileType);
    write('Restaurant',    $Profile->RestaurantID);
    return $Profile->ID;
}

function forgot_password($Email){
    $Email = clean_email($Email);
    $Profile = get_entry("profiles", $Email, "Email");
    if ($Profile){
        $Password = randomPassword();
        update_database("profiles", "ID", $Profile->ID, array("Password" => md5($Password . salt())));
        return $Password;
    }
}



////////////////////////////////////////Profile Address API ////////////////////////////////////
function enum_profile_addresses($ProfileID){
    return enum_all("profiles_addresses", array("UserID" => $ProfileID));
}
function delete_profile_address($ID){
    delete_all("profiles_addresses", array("ID" => $ID));
}
function get_profile_address($ID){
    return get_entry("profiles_addresses", $ID);
}
function edit_profile_address($ID, $UserID, $Name, $Phone, $Number, $Street, $Apt, $Buzz, $City, $Province, $PostalCode, $Country, $Notes){
    $Data = array("UserID" => $UserID, "Name" => $Name, "Phone" => clean_phone($Phone), "Number" => $Number, "Street" => $Street, "Apt" => $Apt, "Buzz" => $Buzz, "City" => $City, "Province" => $Province, "PostalCode" => clean_postalcode($PostalCode), "Country" =>$Country, "Notes" =>$Notes);
    return edit_database("profiles_addresses", "ID", $ID, $Data);
}

function check_permission($Permission, $UserID = ""){
    if(!$UserID){$UserID = read("ID");}
    return get_profile_type($UserID)->$Permission;
}


////////////////////////////////////profile image API///////////////////////////////////
function get_profile_image($Filename, $UserID = ""){
    if(!$UserID){$UserID = read("ID");}
    if (strpos($Filename, "/")){$Filename = pathinfo($Filename, PATHINFO_BASENAME);}
    return enum_all("profiles_images", array("UserID" => $UserID, "Filename" => $Filename))->first();
}

function delete_profile_image($Filename, $UserID = "") {
    if (!$UserID) {$UserID = read("ID");}
    if (strpos($Filename, "/")){$Filename = pathinfo($Filename, PATHINFO_BASENAME);}
    $dir = "img/users/" . $UserID . "/" . $Filename;
    if (file_exists($dir)) {unlink($dir);}
    delete_all("profiles_images", array("UserID" => $UserID, "Filename" => $Filename));
}

function edit_profile_image($UserID, $Filename, $RestaurantID, $Title, $OrderID){
    $Entry = get_profile_image($Filename, $UserID);
    $Data = array("RestaurantID" => $RestaurantID, "Title" => $Title, "OrderID" => $OrderID);
    if($Entry){
        edit_database("profiles_images", "ID", $Entry->ID, $Data);
    } else {
        $Data["UserID"] = $UserID;
        $Data["Filename"] = $Filename;
        new_entry("profiles_images", "ID", $Data);
    }
}


////////////////////////////////////Newsletter API//////////////////////////////////
function add_subscriber($EmailAddress, $authorized = false){
    $EmailAddress = clean_email($EmailAddress);
    if(is_valid_email($EmailAddress)) {
        $Entry = get_entry("newsletter", $EmailAddress, "Email");
        $GUID="";
        if ($Entry) {
            if (!$Entry->GUID) { return true; }
            if(!$authorized){$GUID = $Entry->GUID;}
            update_database("newsletter", "ID", $Entry->ID, array("GUID" => $GUID));
        } else {
            if(!$authorized){$GUID = com_create_guid();}
            new_entry("newsletter", "ID", array("GUID" => $GUID, "Email" => $EmailAddress));
        }
        $path = '<A HREF="' . webroot() . "cuisine?action=subscribe&key=" . $GUID . '">Click here to finish registration</A>';
        return handleevent($EmailAddress, "subscribe", array("Path" => $path));
    }
}

function remove_subscriber($EmailAddress){
    $EmailAddress = clean_email($EmailAddress);
    delete_all("newsletter", array("Email" => $EmailAddress));
}

function is_subscribed($EmailAddress){
    $EmailAddress = clean_email($EmailAddress);
    return get_entry("newsletter", $EmailAddress, "Email");
}

function finish_subscription($Key){
    $Entry = get_entry("newsletter", $Key, "GUID");
    if($Entry){
        update_database("newsletter", "ID", $Entry->ID, array("GUID" => ""));
        update_database("profiles", "Email", $Entry->Email, array("subscribed" => 1));
        return $Entry->Email;
    }
}

function set_subscribed($EmailAddress, $Status){
    $EmailAddress = clean_email($EmailAddress);
    $is_subscribed = is_subscribed($EmailAddress);
    if($is_subscribed != $Status){
        if($Status){
            add_subscriber($EmailAddress, True);
        } else {
            remove_subscriber($EmailAddress);
        }
    }
}
function enum_subscribers(){
    $Data = enum_all("newsletter", array("GUID" => ""));
    return my_iterator_to_array($Data, "ID", "Email");
}

function webroot(){
    return URL::to('/');
}

//////////////////////////////////////Genre API//////////////////////////////////////
function add_genre($Name){
    if(is_array($Name)){
        $Ret=array();
        foreach($Name as $Key => $Genre){
            $Ret[$Genre] = add_genre($Genre);
        }
        return $Ret;
    } else {
        if(genre_exists($Name)){return false;}//don't allow duplicates
        new_anything("genres", $Name);
        return true;
    }
}

function genre_exists($Name){
    if(get_entry("genres", $Name, "Name")){return true;}
}

function rename_genre($ID, $NewName){
    if(genre_exists($NewName)){return false;}
    update_database('genres', "ID", $ID, array("Name" => $NewName));
    return true;
}
function enum_restaurants($Genre = ""){
    if($Genre) {
        return enum_anything("restaurants", "Genre", $Genre);
    }
    return enum_table("restaurants");
}

function enum_genres(){
    $entries = enum_all('genres');
    return my_iterator_to_array($entries, "ID", "Name");
}

//////////////////////////////////////Restaurant API/////////////////////////////////

function blank_restaurant(){
    $Restaurant = (object) ['ID' => 0, 'Name' => '', 'Email' => '', 'Phone' => '', 'Address' => '', 'PostalCode' => '', 'City' => 'HAMILTON', 'Province' => 'ON', 'Country' => 'Canada', 'Genre' => 0, 'Hours' => array(), 'DeliveryFee' => 0, 'Minimum' => 0, 'Description' => ''];
    return $Restaurant;
}

function get_restaurant($ID = "", $IncludeHours = False, $IncludeAddresses = False){
    if(!$ID){$ID = get_current_restaurant();}
    if (is_numeric($ID)) {
        $restaurant = get_entry("restaurants", $ID);
    } else {
        $restaurant = get_entry('restaurants', $ID, 'Slug');
    }
    if($restaurant){
        if($IncludeHours) {$restaurant->Hours = get_hours($ID);}
        if($IncludeAddresses){$restaurant->Addresses = iterator_to_array(enum_notification_addresses($ID), "", "Address");}
    }
    return $restaurant;
}

function edit_restaurant($ID, $Name, $GenreID, $Email, $Phone, $Address, $City, $Province, $Country, $PostalCode, $Description, $DeliveryFee, $Minimum){
    if(!$ID){$ID = new_anything("restaurants", $Name);}
    $C = ', ';
    $PostalCode = clean_postalcode($PostalCode);
    logevent("Edited restaurant: " . $Name .$C. $GenreID .$C. $Email .$C. clean_phone($Phone) .$C. $Address .$C. $City .$C. $Province .$C. $Country .$C. $PostalCode .$C. $Description .$C. $DeliveryFee .$C. $Minimum);
    $data = array("Name" => $Name, "Genre" => $GenreID, "Email" => $Email, "Phone" => clean_phone($Phone), "Address" => $Address, "City" => $City, "Province" => $Province, "Country" => $Country, "PostalCode" => $PostalCode, "Description" => $Description, "DeliveryFee" => $DeliveryFee, "Minimum" => $Minimum);
    update_database("restaurants", "ID", $ID, $data);
    return $ID;
}

function enum_employees($ID = "", $Hierarchy = ""){
    if(!$ID){
        $ID = get_current_restaurant();
    }
    if($Hierarchy){
        return enum_all("Profiles", array("RestaurantID" => $ID, "Hierarchy >" => $Hierarchy));
    }
    return enum_profiles("RestaurantID", $ID);//->order("Hierarchy" , "ASC");
}

function get_current_restaurant(){
    $Profile = read('ID');
    if($Profile) {
        if (isset($_GET["RestaurantID"])) {
            $ProfileType = get_profile_type($Profile);
            if ($ProfileType->CanEditGlobalSettings) {
                return $_GET["RestaurantID"];
            }
        }
        return get_profile($Profile)->RestaurantID;
    }
}

function hire_employee($UserID, $RestaurantID = 0, $ProfileType = ""){
    if(!check_permission("CanHireOrFire")){return false;}

    $Profile = get_profile($UserID);
    if(!$ProfileType){$ProfileType=$Profile->ProfileType;}
    $Name = "";
    if($RestaurantID){//hire
        if (!$Profile->RestaurantID) { $Name = "Hired"; }
    } else {//fire
        if ($Profile->RestaurantID) { $Name = "Fired"; }
    }
    if($Name){
        update_database("profiles", "ID", $UserID, array("RestaurantID" => $RestaurantID, "ProfileType" => $ProfileType));
        logevent($Name . ": " . $Profile->ID . " (" . $Profile->Name . ")" );
        return true;
    }
}

function openclose_restaurant($RestaurantID, $Status = false){
    if($Status){$Status=1;} else {$Status = 0;}
    logevent("Set status to: " . $Status, true, $RestaurantID);
    update_database("restaurants", "ID", $RestaurantID, array("Open" => $Status));
}

function delete_restaurant($RestaurantID, $NewProfileType = 2){
    logevent("Deleted restaurant", true, $RestaurantID);
    delete_all("restaurants", array("ID" => $RestaurantID));
    update_database("profiles", "RestaurantID", $RestaurantID, array("RestaurantID" => 0, "ProfileType" => $NewProfileType));
}

/////////////////////////////////////days off API////////////////////////////////////
function add_day_off($RestaurantID, $Day, $Month, $Year){
    delete_day_off($RestaurantID, $Day, $Month, $Year, false);
    logevent("Added a day off on: " . $Day . "-" . $Month . "-" . $Year);
    new_entry("daysoff", "ID", array("RestaurantID" => $RestaurantID, "Day" => $Day, "Month" => $Month, "Year" => $Year));
}
function delete_day_off($RestaurantID, $Day, $Month, $Year, $IsNew = true){
    if ($IsNew){
        logevent("Deleted a day off on: " . $Day . "-" . $Month . "-" . $Year);
    }
    delete_all("daysoff", array("RestaurantID" => $RestaurantID, "Day" => $Day, "Month" => $Month, "Year" => $Year));
}
function enum_days_off($RestaurantID){

}
function is_day_off($RestaurantID, $Day, $Month, $Year){
    return enum_all("daysoff", array("RestaurantID" => $RestaurantID, "Day" => $Day, "Month" => $Month, "Year" => $Year))->first();
}



////////////////////////////////////////Menus API/////////////////////////////////
function enum_menus($RestaurantID = "", $Sort = ""){
    if($RestaurantID=="all"){
        return enum_all('menus',['parent'=>'0','image <> "undefined"']);
    }
    if(!$RestaurantID) {$RestaurantID = get_current_restaurant();}
    if($Sort){$order = array('display_order' => $Sort);} else {$order = "";}
    return enum_all("menus", array('res_id' => $RestaurantID, 'parent' => '0','image<>"undefined"'), $order);
}












/////////////////////////////////////Date API////////////////////////////////////////
function now(){
    return date("Y-m-d H:i:s");
}

//returns date stamp
function parse_date($Date){
    if(strpos($Date, "-")) {
        return strtotime($Date);
    }
    return $Date;
}

function get_day_of_week($Date){//0 is sunday, 6=saturday
    return date('w', parse_date($Date));
}
function get_time($Date){//800
    return date('Gi', parse_date($Date));
}
function get_year($Date){//2015
    return date('Y', parse_date($Date));
}
function get_month($Date){//01-12
    return date('m', parse_date($Date));
}
function get_day($Date){//3 (no leading zero)
    return date('j', parse_date($Date));
}


/////////////////////////////////////Notification addresses API///////////////////////
function enum_notification_addresses($RestaurantID = "", $Type = ""){
    if(!$RestaurantID){$RestaurantID = get_current_restaurant();}
    $conditions = array("RestaurantID" => $RestaurantID);
    if (is_numeric($Type)){$conditions["Type"] = $Type;}
    return enum_all("notification_addresses", $conditions);
}
function count_notification_addresses($RestaurantID = "", $Type = "") {
    if (!$RestaurantID) {$RestaurantID = get_current_restaurant();}
    $conditions = array("RestaurantID" => $RestaurantID);
    if (is_numeric($Type)){$conditions["Type"] = $Type;}
    return get_row_count("notification_addresses", $conditions);
}

function sort_notification_addresses($RestaurantID = ""){
    if(!$RestaurantID){$RestaurantID = get_current_restaurant();}
    $Addresses = enum_notification_addresses($RestaurantID);
    if($Addresses) {
        $Types = array("Email", "Phone");
        $Data = array();
        foreach ($Types as $Type) {
            $Data[$Type] = array();
        }
        foreach ($Addresses as $Address) {
            $Data[$Types[$Address->Type]][] = $Address->Address;
        }
        return $Data;
    }
}
function find_notification_address($RestaurantID, $Address){
    $Type = data_type($Address);
    if ($Type == 0 || $Type == 1) {//email and phone whitelisted
        $Address = clean_data($Address);
        return enum_all("notification_addresses", array("RestaurantID" => $RestaurantID, "Type" => $Type, "Address" => $Address))->first();
    }
}
function delete_notification_address($RestaurantID, $Address = "") {
    if(!$RestaurantID){$RestaurantID = get_current_restaurant();}
    if($Address) {
        $Type = data_type($Address);
        if ($Type == 0 || $Type == 1) {//email and phone whitelisted
            $Address = clean_data($Address);
            delete_all("notification_addresses", array("RestaurantID" => $RestaurantID, "Type" => $Type, "Address" => $Address));
        }
    } else {//delete all
        delete_all("notification_addresses", array("RestaurantID" => $RestaurantID));
    }
}

function add_notification_addresses($RestaurantID, $Address){
    $Type = data_type($Address);
    if ($Type == 0 || $Type == 1){//email and phone whitelisted
        $Address = clean_data($Address);
        if(!find_notification_address($RestaurantID, $Address)){
            $Data = array("RestaurantID" => $RestaurantID, "Type" => $Type, "Address" => $Address);
            new_entry("notification_addresses", "ID", $Data);
            return true;
        }
    }
}


/////////////////////////////////////Hours API///////////////////////////////////////

function to_time($Time){
    if($Time){
        if (substr_count($Time, ":") == 2) {
            $Time = left($Time, strlen($Time) - 3);
        }
        return str_replace(":", "", $Time);
    }
}

function edit_hours($RestaurantID, $Data){
    $Days = array();
    for ($DayOfWeek = 1; $DayOfWeek < 8; $DayOfWeek++){
        $Open = to_time($Data[$DayOfWeek . "_Open"]);
        $Close = to_time($Data[$DayOfWeek . "_Close"]);
        $Days[$DayOfWeek] = $Open . " to " . $Close;
        edit_hour($RestaurantID, $DayOfWeek, $Open, $Close);
    }
    logevent("Edited hours: " . print_r($Days, true));
}


function is_restaurant_open_now($RestaurantID, $date = ""){
    if(!$date){ $date = now();}
    if(strpos($date, "-")){$date = strtotime($date);}
    if(!is_day_off($RestaurantID, get_day($date), get_month($date), get_year($date))) {
        $dayofweek = date('w', $date);
        $time = date('Gi', $date);
        return is_restaurant_open($RestaurantID, $dayofweek, $time);
    }
}

function get_hours($RestaurantID){
    $ret = array();
    $Data = enum_all('hours', ['RestaurantID' => $RestaurantID], 'DayOfWeek');
    $HasHours = false;
    foreach($Data as $Day){
        $ret[$Day->DayOfWeek . ".Open"] = $Day->Open;
        $ret[$Day->DayOfWeek . ".Close"] = $Day->Close;
        if($Day->Open <> 0 || $Day->Close <> 2359){$HasHours=true;}
    }
    $ret["HasHours"] = $HasHours;
    return $ret;
}

function edit_hour($RestaurantID, $DayOfWeek, $Open, $Close){
    $data = array('RestaurantID'=>$RestaurantID, 'DayOfWeek'=>$DayOfWeek);
    delete_all('hours', $data);
    if(!$Open){$Open = "";}
    if(!$Close){$Close = "";}
    $data["Open"] = $Open;
    $data["Close"] = $Close;
    if($Open && $Close) {new_entry("hours", "ID", $data);}
}

function is_restaurant_open($RestaurantID, $DayOfWeek, $Time){
    if (get_restaurant($RestaurantID)->Open) {
        $Data = enum_all('hours', ['RestaurantID' => $RestaurantID, "DayOfWeek" => $DayOfWeek])->first();
        if ($Data) {
            return $Data->Open <= $Time && $Data->Close >= $Time;
        }
    }
}


/////////////////////////////////Event log API////////////////////////////////////
function logevent($Event, $DoRestaurant = true, $RestaurantID = 0){
    $UserID = read('ID');
    if(!$UserID){
        $UserID=0;
        $DoRestaurant=false;
    }
    if ($DoRestaurant) {
        if (!$RestaurantID) {
            $RestaurantID = get_profile($UserID)->RestaurantID;
        }
    }
    $Date = now();
    new_entry("eventlog", "ID", array("UserID" => $UserID, "RestaurantID" => $RestaurantID, "Date" => $Date, "Text" => $Event));
}
function enum_events($RestaurantID){
    return enum_all("eventlog", array("RestaurantID" => $RestaurantID));
}

/////////////////////////////////Orders API/////////////////////////////////////
function enum_orders($ID = "", $IsUser = false, $Approved = false){
    $Conditions = array();
    $OrderBy = array('order_time'=>'desc');
    if($IsUser){
        if(!$ID){$ID = read("ID");}
        $Conditions["ordered_by"] = $ID;
    } else {
        if(!$ID){$ID = get_current_restaurant();}
        $Conditions["res_id"] = $ID;
    }
    if (strtolower($Approved != "any")) {
        if ($Approved) {
            $Conditions[] = '(approved = 1 OR cancelled=1)';
        } else {
            $Conditions['approved'] = 0;
            $Conditions['cancelled'] = 0;
        }
    }
    return enum_all("reservations", $Conditions, $OrderBy);
}
function delete_order($ID){
    delete_all("reservations", array('id' => $ID));
}
function pending_order_count($RestaurantID = ""){
    return iterator_count(enum_orders($RestaurantID, false, false));
}
function get_order($ID){
    return get_entry("reservations", $ID, "id");
}
function order_status($Order){
    if (!is_object($Order)){$Order = get_order($Order);}
    if($Order->cancelled == 1) {
        return 'Cancelled';
    }else if($Order->approved == 1) {
        return 'Approved';
    }else {
        return 'Pending';
    }
}
function approve_order($OrderID, $Status=true){
    if($Status){$Status = 'approved';} else {$Status = 'cancelled';}
    edit_database('reservations', "ID", $OrderID, array($Status=>1));
}

function implode_data($Data, $Delimeter = ","){
    if (is_array($Data)){return implode($Delimeter, $Data);}
    return $Data;
}

function new_order($menu_ids, $prs, $qtys, $extras, $listid, $order_type, $delivery_fee, $res_id, $subtotal, $g_total, $tax){
    $Data = array();
    $Data['menu_ids'] = implode_data($menu_ids);
    $Data['prs'] = implode_data($prs);
    $Data['qtys'] = implode_data($qtys);
    $Data['extras'] = implode_data($extras);
    $Data['listid'] = implode_data($listid);
    $Data['delivery_fee'] = $delivery_fee;

    date_default_timezone_set('Canada/Eastern');
    $Data['order_time'] = new \DateTime('NOW');
    $Data['res_id'] = $res_id;
    $Data['subtotal'] = $subtotal;
    $Data['g_total'] = $g_total;
    $Data['tax'] = $tax;

    if ($order_type == '0'){$order_type = "0.00";}
    $Data['order_type'] = $order_type;

    //convert to a Manager API call
    $ord = TableRegistry::get('reservations');
    $att = $ord->newEntity($Data);
    $ord->save($att);
    return $att->id;
}
function edit_order_profile($OrderID, $email, $address2, $city, $ordered_by, $postal_code, $remarks, $order_till, $province, $Phone){
    $Data = array();
    $Data['email'] = $email;
    $Data['address2'] = $address2;
    $Data['city'] = $city;
    $Data['ordered_by'] = $ordered_by;
    $Data['postal_code'] = $postal_code;
    $Data['remarks'] = $remarks;
    $Data['order_till'] = $order_till;
    $Data['province'] = $province;
    $Data['contact'] = $Phone;

    edit_database('reservations', 'id', $OrderID, $Data);
}

////////////////////////////////////////////////////menu API////////////////////////////////////////////////////
function get_menu($RestaurantID){
    return enum_all('menus', array('res_id'=>$RestaurantID));
}
















function data_type_name($Type){
    $Values = array("Email Address", "Phone Number", "Postal Code");
    if ($Type <0 or $Type >= count($Values)){ return "Unknown";}
    return $Values[$Type];
}
function data_type($Data){
    if (strpos($Data, "@")){return 0;} //email
    if (clean_postalcode($Data)) { return 2;}//postal code
    if(clean_phone($Data)) { return 1;} //phone number

    return -1;
}
function clean_data($Data){
    switch(data_type($Data)){
        case -1: return trim($Data); break;
        case 0: return clean_email($Data); break;
        case 1: return clean_phone($Data); break;
        case 2: return clean_postalcode($Data); break;
    }
}












function tableexists($Table, $Column = ""){
    if($Column){
        return \Schema::hasColumn($Table, $Column);
    }
    return \Schema::hasTable($Table);
}

function getColumnNames($Table, $Ignore ="", $Full = false){
    if(!is_array($Ignore)){$Ignore = array($Ignore);}
    if($Full){
        $Cols = select_query("SHOW columns FROM " . $Table);
    } else {
        $Cols = \Schema::getColumnListing($Table);
    }
    if(!count($Ignore)) {return $Cols;}
    $Columns = array();
    foreach ($Cols as $Key => $ColData) {
        if($Full){$ColumnName = $ColData["Field"];} else {$ColumnName = $ColData;}
        if (!in_array($ColumnName, $Ignore)) {
            $Columns[] = $ColData;
        }
    }
    return $Columns;
}

























function clean_phone($Phone){
    $Phone = kill_non_numeric($Phone, "+");//add a check to be sure only the first digit is a +
    if($Phone != "+") {
        return $Phone;
    }
}
function clean_email($Email){
    return strtolower(trim($Email));
}
function clean_postalcode($PostalCode){
    $PostalCode = str_replace(" ", "", strtoupper(trim($PostalCode)));
    if(validateCanadaZip($PostalCode)){
        $delimeter = "";//" "
        return left($PostalCode, 3) . $delimeter . right($PostalCode, 3);
    }
}
function validateCanadaZip($PostalCode)  {//function by Roshan Bhattara(http://roshanbh.com.np)
    return preg_match("/^([a-ceghj-npr-tv-z]){1}[0-9]{1}[a-ceghj-npr-tv-z]{1}[0-9]{1}[a-ceghj-npr-tv-z]{1}[0-9]{1}$/i", $PostalCode);
}


function debug_string_backtrace() {
    $BACK = debug_backtrace(0);
    $BACK[2]["line"] = $BACK[1]["line"];
    return $BACK[2];
}

function implode2($Array, $SmallGlue, $BigGlue){
    foreach($Array as $Key => $Value){
        $Array[$Key] = $Key . $SmallGlue. $Value;
    }
    return implode_data($Array,$BigGlue);
}
function debug($Iterator, $DoStacktrace = true){
    if($DoStacktrace) {
        $Backtrace = debug_string_backtrace();
        echo '<B>' . $Backtrace["file"] . ' (line ' . $Backtrace["line"] . ') From function: ' . $Backtrace["function"] . '();</B> ';
    }

    if(is_array($Iterator)){
        echo '(array)<BR>';
        var_dump($Iterator);
    } else if (is_object($Iterator)) {
        if(is_iterable($Iterator)) {
            echo '(object array)<BR>';
            foreach ($Iterator as $It) {
               debug($It, false);
            }
        } else {
            echo '(object)<BR>';
            var_dump($Iterator);
        }
    } else {
        echo '(value)<BR>';
        echo $Iterator;
    }
}
function is_iterable($var) {
    return (is_array($var) || $var instanceof Traversable);
}

// My common functions
function enum_tables(){
    return collapsearray(DB::select('SHOW TABLES'));
}

function collapsearray($Array, $Key = ""){
    $NewArray = array();
    foreach($Array as $Value){
        if($Key){
            $NewArray[] = $Value[$Key];
        } else {
            foreach($Value as $NewValue){
                $NewArray[] = $NewValue;
            }
        }
    }
    return $NewArray;
}


function message($msgtype, $description) {
    if ($msgtype != "" && $description != "") {
        return '<script type="text/javascript">
                        $(document).ready(function() {
                            Command: toastr["' . $msgtype . '"]("' . $description . '")
                            toastr.options = {
                                "closeButton": true,
                                "debug": true,
                                "newestOnTop": true,
                                "progressBar": true,
                                "positionClass": "toast-bottom-left",
                                "preventDuplicates": true,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                        });
                        </script>';
    }
}


function select_field($table, $column, $value, $getcol = "", $OrderBy="", $Dir="ASC", $GroupBy="") {
    return select_field_where($table, array($column =>$value), $getcol, $OrderBy, $Dir, $GroupBy);
}

function select_field_where($table, $where=array(), $getcol = "", $OrderBy="", $Dir="ASC", $GroupBy="") {
    $query = DB::table($table);
    if($getcol) {
        $query = $query->select($getcol);
    }
    if(!is_array($where)){$where = array($where);}
    foreach ($where as $key => $value) {
        if(is_numeric($key)){
            $query->whereRaw($value);
        } else {
            $query->where($key, $value);
        }
    }

    if($OrderBy){$query = $query->orderBy($OrderBy, $Dir);}
    if($GroupBy){$query = $query->groupBy($GroupBy);}
    if($getcol === true){return $query;}
    if($getcol === false){return $query->get();}
    if ($query->count() > 0) {
        if($getcol) {
            return $query->first()->$getcol;
        }
        return $query->first();
    }
}









function enum_all($Table, $conditions = "1=1", $order = "", $Dir = "ASC"){
    return select_field_where($Table, $conditions, false, $order, $Dir);
}
function enum_anything($Table, $Key, $Value){
    return select_field_where($Table, array($Key => $Value), false);
}
function get_entry($Table, $Value, $PrimaryKey = "ID"){
    if(!$PrimaryKey){$PrimaryKey = get_primary_key($Table);}
    return select_field_where($Table, array($PrimaryKey => $Value));
}




/////////////////////////RAW SQL
function get_primary_key($Table){
    if (is_string($Table)){
        $Table = getColumnNames($Table, "", true);
    }
    if (is_object($Table)) {
        foreach ($Table as $Key => $Value) {
            if($Value["Key"] == "PRI"){
                return $Value["Field"];
            }
        }
    }
}

function enum_table($Table){
    return select_query("SELECT * FROM " . $Table . " WHERE 1=1");
}

function getDatasource(){
    return DB::connection()->getPdo();
}

function select_query($Query){
    $con = getDatasource();
    return $con->query($Query);
}

function first($query) {
    $result = select_query($query);
    if($result) {
        foreach($result as $Data){
            return $Data;
        }
    }
}

function table_count($Table, $Conditions = "1=1"){
    return count(select_field_where($Table, $Conditions, false));
}

function my_iterator_to_array($entries, $PrimaryKey, $Key){
    $data = array();
    foreach($entries as $profiletype){
        if($PrimaryKey) {
            $data[$profiletype->$PrimaryKey] = $profiletype->$Key;
        } else {
            $data[] = $profiletype->$Key;
        }
    }
    return $data;
}

function get_row_count($Table, $Conditions = "1=1"){
   return table_count($Table, $Conditions);
}

function remove_empties($Array){
    foreach($Array as $Key => $Value){
        if (!$Value){
            unset($Array[$Key]);
        }
    }
    return $Array;
}

function getallQueries(){
    $queries = DB::getQueryLog();
    return collapsearray($queries, "query");
}
function lastQuery(){
    $queries = DB::getQueryLog();
    $queries = end($queries);
    if(!$queries){
        echo 'Query log is disabled, run "DB::enableQueryLog();" first';
    }
    return $queries["query"];
}

function isassocarray($my_array){
    if(!is_array($my_array)) {return false;}
    if(count($my_array) <= 0) {return true;}
    return !(array_unique(array_map("is_int", array_keys($my_array))) === array(true));
}

function getIterator($Objects, $Fieldname, $Value){
    foreach($Objects as $Object){
        if ($Object->$Fieldname == $Value){
            return $Object;
        }
    }
    return false;
}

function left($text, $length){
    return substr($text,0,$length);
}
function right($text, $length){
    return substr($text, -$length);
}

function array_to_object($Array){
    $object = (object) $Array;
    return $object;
}

function new_anything($Table, $Data, $Column = "ID"){
    if(!is_array($Data)){$Data = array($Column = $Data);}
    return DB::table($Table)->insertGetId($Data);
}

function delete_all($Table, $Conditions = ""){
    if($Conditions){
        DB::table($Table)->where($Conditions)->delete();
    } else {
        DB::table($Table)->truncate();
    }
}

//only use when you know the primary key value exists
function update_database($Table, $PrimaryKey, $Value, $Data){
    DB::table($Table)->where($PrimaryKey, $Value)->update($Data);
    $Data[$PrimaryKey] = $Value;
    return $Data;
}

function edit_database($Table, $PrimaryKey, $Value, $Data, $IncludeKey = false){
    $entry = false;
    if($PrimaryKey && $Value) {
        $entry = select_field($Table, $PrimaryKey, $Value);
    }
    if($entry) {
        update_database($Table, $PrimaryKey, $Value, $Data);
        $ID = $Value;
    } else {
        $ID = new_anything($Table, $Data);
    }
    if($IncludeKey) {$Data[$PrimaryKey] = $ID;}
    return $Data;
}

function new_entry($Table, $PrimaryKey, $Data){
    return $this->edit_database($Table, $PrimaryKey, "", $Data);
}



function getProtectedValue($obj,$name) {
    $array = (array)$obj;
    $prefix = chr(0).'*'.chr(0);
    if (isset($array[$prefix.$name])) {
        return $array[$prefix . $name];
    }
}
function kill_non_numeric($text, $allowmore = ""){
    return preg_replace("/[^0-9" . $allowmore . "]/", "", $text);
}





function resize($file, $sizes, $CropToFit = false, $delimeter = "x"){
    if (is_array($sizes)){
        $images = array();
        foreach($sizes as $size) {
            $images[] = resize($file, $size, $delimeter);
        }
        return $images;
    } else {
        $newsize = explode($delimeter, $sizes);
        $newfile = getfilename($file) . '-' . $sizes . "." . getextension($file);
        return make_thumb($file, $newfile, $newsize[0], $newsize[1], $CropToFit);
    }
}

function getdirectory($path){
    return pathinfo($path, PATHINFO_DIRNAME);
}

function getfilename($path, $WithExtension = false){
    if ($WithExtension){
        return pathinfo($path, PATHINFO_BASENAME);//filename only, with extension
    } else {
        return pathinfo($path, PATHINFO_FILENAME);//filename only, no extension
    }
}

function getextension($path) {
    return strtolower(pathinfo($path, PATHINFO_EXTENSION));// extension only, no period
}

function loadimage($filename) {
    //get image extension.
    $ext = getExtension($filename);
    //creates the new image using the appropriate function from gd library
    if (!strcmp("jpg", $ext) || !strcmp("jpeg", $ext)) {
        return imagecreatefromjpeg($filename);
    }
    if (!strcmp("png", $ext)) {
        return imagecreatefrompng($filename);
    }
    if (!strcmp("gif", $ext)) {
        return imagecreatefromgif($filename);
    }
    if (!strcmp("bmp", $ext)) {
        return imagecreatefrombmp($filename);
    }
}

function imagecreatefrombmp($filename) {
    $file = fopen($filename, "rb");
    $read = fread($file, 10);
    while (!feof($file) && $read != "") {
        $read .= fread($file, 1024);
    }
    $temp = unpack("H*", $read);
    $hex = $temp[1];
    $header = substr($hex, 0, 104);
    $body = str_split(substr($hex, 108), 6);
    if (substr($header, 0, 4) == "424d") {
        $header = substr($header, 4);
        $header = substr($header, 32);
        $width = hexdec(substr($header, 0, 2));
        $header = substr($header, 8);
        $height = hexdec(substr($header, 0, 2));
        unset($header);
    }
    $x = 0;
    $y = 1;
    $image = imagecreatetruecolor($width, $height);
    foreach ($body as $rgb) {
        $r = hexdec(substr($rgb, 4, 2));
        $g = hexdec(substr($rgb, 2, 2));
        $b = hexdec(substr($rgb, 0, 2));
        $color = imagecolorallocate($image, $r, $g, $b);
        imagesetpixel($image, $x, $height - $y, $color);
        $x++;
        if ($x >= $width) {
            $x = 0;
            $y++;
        }
    }
    return $image;
}

// this is the function that will create the thumbnail image from the uploaded image
// the resize will be done considering the width and height defined, but without deforming the image
function make_thumb($img_name, $filename, $new_width, $new_height, $CropToFit = false) {
    $src_img = loadimage($img_name);
    if ($src_img) {
        //gets the dimmensions of the image
        $old_x = imageSX($src_img);
        $old_y = imageSY($src_img);

        $ratio1 = $old_x / $new_width;
        $ratio2 = $old_y / $new_height;
        if ($ratio1 > $ratio2) {
            $thumb_w = $new_width;
            $thumb_h = $old_y / $ratio1;
        } else {
            $thumb_h = $new_height;
            $thumb_w = $old_x / $ratio2;
        }
        if ($CropToFit) {
            if ($thumb_w < $new_width) {
                $ratio1 = $new_width / $thumb_w;
                $thumb_w = $new_width;
                $thumb_h = $thumb_h * $ratio1;
            } else if ($thumb_h < $new_height) {
                $ratio1 = $new_height / $thumb_h;
                $thumb_w = $thumb_w * $ratio1;
                $thumb_h = $new_height;
            }
            $dst_img = ImageCreateTrueColor($new_width, $new_height);
            imagecopyresampled($dst_img, $src_img, $new_width / 2 - $thumb_w / 2, $new_height / 2 - $thumb_h / 2, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y);
        } else {
            $dst_img = ImageCreateTrueColor($thumb_w, $thumb_h);
            imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y);
        }

        imagedestroy($src_img);
        if ($filename) {
            $ext = getExtension($filename);
            switch ($ext) {
                case "png":
                    imagepng($dst_img, $filename);
                    break;
                default:
                    imagejpeg($dst_img, $filename);
            }
            imagedestroy($dst_img);
        } else {
            return $dst_img;
        }
        return $filename;
    }
}

function handle_upload($Dir){
    if(isset($_FILES['myfile']['name']) && $_FILES['myfile']['name']) {
        if (right($Dir,1) != "/"){$Dir .= "/";}
        $dest = resolve_path(APP . '../webroot/' . left($Dir, strlen($Dir)-1));
        if (!file_exists($dest)){mkdir($dest, 0777, true);}
        $name = $_FILES['myfile']['name'];
        $arr = explode('.', $name);
        $ext = end($arr);
        $file = date('YmdHis') . '.' . $ext;//unique filename
        move_uploaded_file($_FILES['myfile']['tmp_name'], APP . '../webroot/' . $Dir . $file);

        //$file_path = request->webroot . $Dir . $file;

            return $file_path;
        }
}

function resolve_path($str){
    $str = str_replace('\\', '/', $str);
    $array = explode('/', $str);
    $domain = array_shift( $array);
    $parents = array();
    foreach( $array as $dir) {
        switch( $dir) {
            case '.':
                // Don't need to do anything here
                break;
            case '..':
                array_pop( $parents);
                break;
            default:
                $parents[] = $dir;
                break;
        }
    }

    return $domain . '/' . implode( '/', $parents);
}
?>