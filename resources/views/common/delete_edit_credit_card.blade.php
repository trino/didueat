<?php
    printfile("views/common/edit_credit_card.blade.php");

    //Days list
    $starting_day = 01;
    $ending_day = 31;
    $already_selected_day = (isset($credit_cards_list->expiry_date)) ? $credit_cards_list->expiry_date : '';

    for ($starting_day; $starting_day <= $ending_day; $starting_day++) {
        $selected = ($already_selected_day == $starting_day) ? 'selected' : '';
        $days[] = '<option value="' . $starting_day . '" ' . $selected . ' >' . $starting_day . '</option>';
    }
    //Year List
    $starting_year = 2016;
    $ending_year = 2035;

    $already_selected_year = (isset($credit_cards_list->expiry_year)) ? $credit_cards_list->expiry_year : '';
    for ($starting_year; $starting_year <= $ending_year; $starting_year++) {
        $selected = ($already_selected_year == $starting_year) ? 'selected' : '';
        $years[] = '<option value="' . $starting_year . '" ' . $selected . '  >' . $starting_year . '</option>';
    }

    $encryptedfields = array("first_name", "last_name", "card_number", "expiry_date", "expiry_month", "expiry_year", "ccv");
    foreach ($encryptedfields as $field) {
        if (isset($credit_cards_list->$field) && is_encrypted($credit_cards_list->$field)) {
            $credit_cards_list->$field = \Crypt::decrypt($credit_cards_list->$field);
        }
    }

    if(!isset($users_list)) {$users_list = \App\Http\Models\Profiles::orderBy('id', 'DESC')->get();}
    if(!isset($restaurants_list)) {$restaurants_list = \App\Http\Models\Restaurants::orderBy('id', 'DESC')->get();}
?>
<meta name="_token" content="{{ csrf_token() }}"/>

@if(\Session::has('session_profiletype') && \Session::get('session_profiletype') == 1 && (! isset($credit_cards_list->id)))
    <INPUT TYPE="HIDDEN" name="user_type" value="restaurant">
    <!--div class="form-group row">
        <label for="user_type" class="col-sm-3">User Type </label>
        <div class="col-sm-9">
            <LABEL>
                <input type="radio" name="user_type" value="restaurant" ONCLICK="switchdivs(event);"
                   @if(isset($credit_cards_list->user_type) && $credit_cards_list->user_type == 'restaurant') checked @endif >
                Restaurant
            </LABEL>
            <LABEL>
                <input type="radio" name="user_type" value="user" ONCLICK="switchdivs(event);"
                   @if(isset($credit_cards_list->user_type) && $credit_cards_list->user_type == 'user') checked @endif >
                User
            </LABEL>
        </div>
    </div-->

    <div class="form-group row">
        <label class="col-sm-3">Restaurant</label>
        <div class="col-sm-9">
            <div id="restaurant_id" class="restaurant_id">
                <select name="user_id" class="form-control">
                    @foreach($restaurants_list as $restaurant)
                        <option value="{{$restaurant->id}}">{{$restaurant->name}}</option>
                    @endforeach
                </select>
            </div>

            <!--div id="user_id" class="user_id">
                <select name="user_id" class="form-control">
                    foreach($users_list as $user)
                        <option value=" $user->id}}">   $user->name}}</option>
                    endforeach
                </select>
            </div-->

        </div>
    </div>
@endif

@if(\Session::has('session_type_user') && (\Session::get('session_type_user') == "user" || \Session::get('session_type_user') == "restaurant") && (! isset($credit_cards_list->id)))
    <input type="hidden" name="user_id" value="{{ \Session::get('session_id') }}"/>
    <input type="hidden" name="user_type" value="{{ \Session::get('session_type_user') }}"/>
@endif

<div class="form-group row">
    <label for="first_name" class="col-sm-3">First Name </label>
    <div class="col-sm-9">
        <div class="input-icon">
            <input type="text" name="first_name" class="form-control" value="{{ (isset($credit_cards_list->first_name))?$credit_cards_list->first_name:'' }}" id="first_name" placeholder="First Name" required="">
        </div>
    </div>
</div>

<div class="form-group row">
    <label for="last_name" class="col-sm-3">Last Name </label>
    <div class="col-sm-9">
        <input type="text" name="last_name" class="form-control" value="{{ (isset($credit_cards_list->last_name))?$credit_cards_list->last_name:'' }}" id="last_name" placeholder="Last Name" required="">
    </div>
</div>

<div class="form-group row">
    <label for="card_type" class="col-sm-3">Card Type </label>
    <div class="col-sm-9">
        <select name="card_type" class="form-control" id="card_type">
            <?php
                $cards = array("visa" => "Visa", "mastercard" => "Master Card", "americanExpress" => "American Express", "discover" => "Discover");
                foreach ($cards as $short => $long) {
                    echo '<option value="' . $short . '"';
                    if (isset($credit_cards_list->card_type) && $credit_cards_list->card_type == $short) {
                        echo ' selected';
                    }
                    echo '>' . $long . '</option>';
                }
            ?>
        </select>
    </div>
</div>

<div class="form-group row">
    <label for="card_number" class="col-sm-3">Card Number </label>
    <div class="col-sm-9">
        <input type="number" name="card_number" class="form-control" value="{{ (isset($credit_cards_list->card_number))?$credit_cards_list->card_number:'' }}" id="card_number" placeholder="Card Number" required="">
    </div>
</div>

<div class="form-group row">
    <label for="expiry_date" class="col-sm-3">Expiry Day </label>
    <div class="col-sm-9">
        <select name="expiry_date" class="form-control" id="expiry_date">
            <?php echo implode("\n\r", $days);  ?>
        </select>
    </div>
</div>

<div class="form-group row">
    <label for="expiry_month" class="col-sm-3">Expiry Month </label>

    <div class="col-sm-9">
        <select name="expiry_month" class="form-control" id="expiry_month">
            <?php
                $months = array("01" => "January", "02" => "February", "03" => "March", "04" => "April", "05" => "May", "06" => "June", "07" => "July", "08" => "August", "09" => "September", "10" => "October", "11" => "November", "12" => "December");
                foreach ($months as $index => $month) {
                    echo '<option value="' . $index . '"';
                    if (isset($credit_cards_list->expiry_month) && $credit_cards_list->expiry_month == $index) {
                        echo ' selected';
                    }
                    echo '>' . $month . '</option>';
                }
            ?>
        </select>
    </div>
</div>

<div class="form-group row">
    <label for="expiry_year" class="col-sm-3">Expiry Year </label>
    <div class="col-sm-9">
        <select name="expiry_year" class="form-control" id="expiry_year">
            <?php echo implode("\n\r", $years);  ?>
        </select>
    </div>
</div>

<div class="form-group row">
    <label for="ccv" class="col-sm-3">CCV </label>
    <div class="col-sm-9">
        <input type="number" name="ccv" class="form-control" value="{{ (isset($credit_cards_list->ccv))?$credit_cards_list->ccv:'' }}" id="ccv" placeholder="CCV" required="">
    </div>
</div>

@if ( isset($credit_cards_list->id))
    <input type="hidden" name="id" value="{{ (isset($credit_cards_list->id))?$credit_cards_list->id:'' }}"/>
    <input type="hidden" name="user_id" value="{{ (isset($credit_cards_list->user_id))?$credit_cards_list->user_id:'' }}"/>
    <input type="hidden" name="user_type" value="{{ (isset($credit_cards_list->user_type))?$credit_cards_list->user_type:'' }}"/>
@endif

<script type="text/javascript">
    //$(".restaurant_id").hide();
    $(".user_id").hide();

    function switchdivs(){
        $(".restaurant_id").hide();
        $(".user_id").hide();
        if ($(event.target).val() == "restaurant") {
            $(".restaurant_id").show();
        } else {
            $(".user_id").show();
        }
    }
</script>