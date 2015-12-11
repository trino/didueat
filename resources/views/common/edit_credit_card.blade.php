<?php
//Days list
$starting_day  = 01;
$ending_day    = 31;
$already_selected_day = (isset($credit_cards_list->expiry_date))?$credit_cards_list->expiry_date:'';

for($starting_day; $starting_day <= $ending_day; $starting_day++) {
    $selected = ($already_selected_day == $starting_day) ? 'selected':'';    
    $days[] = '<option value="'.$starting_day .'" '. $selected .' >'.$starting_day.'</option>';
}
//Year List
$starting_year  = 2016;
$ending_year    = 2035;

$already_selected_year = (isset($credit_cards_list->expiry_year))?$credit_cards_list->expiry_year:'';
for($starting_year; $starting_year <= $ending_year; $starting_year++) {
    $selected = ($already_selected_year == $starting_year) ? 'selected':'';   
    $years[] = '<option value="'.$starting_year .'" '. $selected .'  >'.$starting_year.'</option>';
}
?>
<meta name="_token" content="{{ csrf_token() }}" />

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="user_type" class="col-md-12 col-sm-12 col-xs-12 control-label">User Type <span class="required">*</span></label>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
                 <select name="user_type" class="form-control" id="user_type" >

                    <option value="restaurant" @if(isset($credit_cards_list->user_type) && $credit_cards_list->user_type == 'restaurant') selected @endif >Restaurant</option>
                    <option value="user" @if(isset($credit_cards_list->user_type) && $credit_cards_list->user_type == 'user') selected @endif >User</option>
                   
                </select>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="first_name" class="col-md-12 col-sm-12 col-xs-12 control-label">First Name <span class="required">*</span></label>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
                <input type="text" name="first_name" class="form-control" value="{{ (isset($credit_cards_list->first_name))?$credit_cards_list->first_name:'' }}" id="first_name" placeholder="First Name" required="">
            </div>
        </div>
    </div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="last_name" class="col-md-12 col-sm-12 col-xs-12 control-label">Last Name <span class="required">*</span></label>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
                <input type="text" name="last_name" class="form-control" value="{{ (isset($credit_cards_list->last_name))?$credit_cards_list->last_name:'' }}" id="last_name" placeholder="Last Name" required="">
            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>
<div class="modal-header">
    <h4 class="modal-title">Credit Card Details</h4>
</div>
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="card_type" class="col-md-12 col-sm-12 col-xs-12 control-label">Card Type <span class="required">*</span></label>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
                 <select name="card_type" class="form-control" id="card_type" >
                    <option value="visa" @if(isset($credit_cards_list->card_type) && $credit_cards_list->card_type == 'visa') selected @endif >Visa</option>
                    <option value="mastercard" @if(isset($credit_cards_list->card_type) && $credit_cards_list->card_type == 'mastercard') selected @endif >Master Card</option>
                    <option value="americanExpress" @if(isset($credit_cards_list->card_type) && $credit_cards_list->card_type == 'americanExpress') selected @endif >American Express</option>
                    <option value="discover" @if(isset($credit_cards_list->card_type) && $credit_cards_list->card_type == 'discover') selected @endif >Discover</option>
                </select>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="card_number" class="col-md-12 col-sm-12 col-xs-12 control-label">Card Number <span class="required">*</span></label>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
                <input type="number" name="card_number" class="form-control" value="{{ (isset($credit_cards_list->card_number))?$credit_cards_list->card_number:'' }}"  id="card_number" placeholder="Card Number" required="">
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="expiry_date" class="col-md-12 col-sm-12 col-xs-12 control-label">Expiry Date <span class="required">*</span></label>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
                <select name="expiry_date" class="form-control" id="expiry_date" >
                    <?php echo implode("\n\r", $days);  ?>
                </select>
            </div>
        </div>
    </div>
</div>


<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="expiry_month" class="col-md-12 col-sm-12 col-xs-12 control-label">Expiry Month <span class="required">*</span></label>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
                <select name="expiry_month" class="form-control" id="expiry_month">
                    <option value="01" @if(isset($credit_cards_list->expiry_month) && $credit_cards_list->expiry_month == 01 ) selected @endif >January</option>
                    <option value="02" @if(isset($credit_cards_list->expiry_month) && $credit_cards_list->expiry_month == 02 ) selected @endif >February</option>
                    <option value="03" @if(isset($credit_cards_list->expiry_month) && $credit_cards_list->expiry_month == 03 ) selected @endif >March</option>
                    <option value="04" @if(isset($credit_cards_list->expiry_month) && $credit_cards_list->expiry_month == 04 ) selected @endif >April</option>
                    <option value="05" @if(isset($credit_cards_list->expiry_month) && $credit_cards_list->expiry_month == 05 ) selected @endif >May</option>
                    <option value="06" @if(isset($credit_cards_list->expiry_month) && $credit_cards_list->expiry_month == 06 ) selected @endif >June</option>
                    <option value="07" @if(isset($credit_cards_list->expiry_month) && $credit_cards_list->expiry_month == 07 ) selected @endif >July</option>
                    <option value="08" @if(isset($credit_cards_list->expiry_month) && $credit_cards_list->expiry_month == 08 ) selected @endif >August</option>
                    <option value="09" @if(isset($credit_cards_list->expiry_month) && $credit_cards_list->expiry_month == 09 ) selected @endif >September</option>
                    <option value="10" @if(isset($credit_cards_list->expiry_month) && $credit_cards_list->expiry_month == 10 ) selected @endif >October</option>
                    <option value="11" @if(isset($credit_cards_list->expiry_month) && $credit_cards_list->expiry_month == 11 ) selected @endif >November</option>
                    <option value="12" @if(isset($credit_cards_list->expiry_month) && $credit_cards_list->expiry_month == 12 ) selected @endif >December</option>
                </select>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="expiry_year" class="col-md-12 col-sm-12 col-xs-12 control-label">Expiry Year <span class="required">*</span></label>
        <div class="col-md-12 col-sm-12 col-xs-12">
               <select name="expiry_year" class="form-control" id="expiry_year">
                   <?php echo implode("\n\r", $years);  ?>
               </select>            
        </div>
    </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="ccv" class="col-md-12 col-sm-12 col-xs-12 control-label">CCV <span class="required">*</span></label>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-icon">
                <input type="number" name="ccv" class="form-control" value="{{ (isset($credit_cards_list->ccv))?$credit_cards_list->ccv:'' }}" id="ccv" placeholder="CCV" required="">
            </div>
        </div>
    </div>
</div>


<div class="clearfix"></div>

<div class="modal-footer">
    <button type="submit" class="btn red">Save changes</button>
    <input type="hidden" name="id" value="{{ (isset($credit_cards_list->id))?$credit_cards_list->id:'' }}" />
    
</div>
