<?php
    printfile("views/common/edit_credit_card.blade.php");
    $new = false;
    //Days list
    $starting_day = 01;
    $ending_day = 31;

    //decrypt the data
    $encryptedfields = array("first_name", "last_name", "card_number", "expiry_date", "expiry_month", "expiry_year", "ccv");
    foreach ($encryptedfields as $field) {
        if (isset($credit_cards_list->$field) && is_encrypted($credit_cards_list->$field)) {
            $credit_cards_list->$field = \Crypt::decrypt($credit_cards_list->$field);
        }
    }

    //Year List
    $starting_year = date("Y");
    $ending_year = $starting_year + 10;

    if (!isset($users_list)) {
        $users_list = \App\Http\Models\Profiles::orderBy('id', 'DESC')->get();
    }
    if (!isset($restaurants_list)) {
        $restaurants_list = \App\Http\Models\Restaurants::orderBy('id', 'DESC')->get();
    }
?>
<meta name="_token" class="csrftoken" content="{{ csrf_token() }}"/>

@if(\Session::has('session_profiletype') && \Session::get('session_profiletype') == 1 && (! isset($credit_cards_list->id)))
    <INPUT TYPE="HIDDEN" name="user_type" value="{{  $type }}">

    @if($type == "admin")
        <div class="form-group row">
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
        </div>

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

                <div id="user_id" class="user_id">
                    <select name="user_id" class="form-control">
                        foreach($users_list as $user)
                            <option value="{{  $user->id }}">   $user->name}}</option>
                        endforeach
                    </select>
                </div>

            </div>
        </div>
    @elseif($type == "restaurant")
        <INPUT TYPE="HIDDEN" NAME="restaurant_id" VALUE="{{  $user_id }}">
    @else
        <INPUT TYPE="HIDDEN" NAME="user_id" VALUE="{{  $user_id }}">
    @endif
@endif

@if(\Session::has('session_type_user') && (\Session::get('session_type_user') == "user" || \Session::get('session_type_user') == "restaurant") && (! isset($credit_cards_list->id)))
    <input type="hidden" name="user_id" value="{{ \Session::get('session_id') }}"/>
    <input type="hidden" name="user_type" value="{{ \Session::get('session_type_user') }}"/>
@endif

<?= newrow($new, "First Name", "", true, 5); ?>
<input type="text" name="first_name" class="form-control"
       value="{{ (isset($credit_cards_list->first_name))?$credit_cards_list->first_name:'' }}" id="first_name"
       placeholder="" required>
</div></div>

<?= newrow($new, "Last Name", "", true, 5); ?>
<input type="text" name="last_name" class="form-control"
       value="{{ (isset($credit_cards_list->last_name))?$credit_cards_list->last_name:'' }}" id="last_name"
       placeholder="" required>
</div></div>

<?= newrow($new, "Card Number", "", true, 5); ?>
<input type="text" name="card_number" class="form-control"
       value="{{ (isset($credit_cards_list->card_number))?$credit_cards_list->card_number:'' }}" id="card_number"
       placeholder="" required>
</div></div>


<?= newrow($new, "Expiry Month", "", true,5); ?>
    <select name="expiry_month" class="form-control" id="expiry_month" required>
        <option value="">Select Month</option>
            <?php
            $months = array("01" => "January", "02" => "February", "03" => "March", "04" => "April", "05" => "May", "06" => "June", "07" => "July", "08" => "August", "09" => "September", "10" => "October", "11" => "November", "12" => "December");
            foreach ($months as $index => $month) {
                echo '<option value="' . $index . '"';
                if (isset($credit_cards_list->expiry_month) && $credit_cards_list->expiry_month == $index) {
                    echo ' selected';
                }
                echo '>' . $index . " (" . $month . ')</option>';
            }
            ?>
    </select>
</div></div>

<?= newrow($new, "Expiry Year", "", true, 5); ?>
    <select name="expiry_year" class="form-control" id="expiry_year" required>
    <option value="">Select Year</option>
        <?php
            $already_selected_year = (isset($credit_cards_list->expiry_year)) ? $credit_cards_list->expiry_year : '';
            for ($starting_year; $starting_year <= $ending_year; $starting_year++) {
                $selected = ($already_selected_year == $starting_year) ? ' selected' : '';
                echo "\r\n".  '<option value="' . $starting_year . '" ' . $selected . ' >' . $starting_year . '</option>';
            }
        ?>
    </select>
</div></div>

<?= newrow($new, "CCV", "", true, 5); ?>
<input type="text" name="ccv" class="form-control"
       value="{{ (isset($credit_cards_list->ccv))?$credit_cards_list->ccv:'' }}" id="ccv" placeholder="" required size="3" maxlength="3"><img src="{{ asset('assets/images/ccvimgph.gif') }}" id="ccvimgid" border="0" style="position:relative;z-index:250;left:100px"/><br/><a href="#" onclick="return false" onmouseout="document.getElementById('ccvimgid').src=ccvimgph.src;document.getElementById('ccvimgid').style.marginBottom='0px';document.getElementById('ccvimgid').style.top='0px';" onmouseover="document.getElementById('ccvimgid').src=ccvimg.src;document.getElementById('ccvimgid').style.top='-206px';document.getElementById('ccvimgid').style.marginBottom='-206px';"><u>Where is this located?</u></a>
</div></div>

@if ( isset($credit_cards_list->id))
    <input type="hidden" name="id" value="{{ (isset($credit_cards_list->id))?$credit_cards_list->id:'' }}"/>
    <input type="hidden" name="user_id" value="{{ (isset($credit_cards_list->user_id))?$credit_cards_list->user_id:'' }}"/>
    <input type="hidden" name="user_type" value="{{ (isset($credit_cards_list->user_type))?$credit_cards_list->user_type:'' }}"/>
@endif

<script type="text/javascript">
    ccvimg = new Image();
    ccvimg.src = base_url+"assets/images/security_code_sample.png";
    ccvimgph = new Image();
    ccvimgph.src = base_url+"assets/images/ccvimgph.gif";

    //$(".restaurant_id").hide();
    $(".user_id").hide();

    function switchdivs() {
        $(".restaurant_id").hide();
        $(".user_id").hide();
        if ($(event.target).val() == "restaurant") {
            $(".restaurant_id").show();
        } else {
            $(".user_id").show();
        }
    }
</script>