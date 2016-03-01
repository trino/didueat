<?php
	printfile("views/home/stripe.blade.php");
	// sample values to be added to Stripe form
	$orderDesc="2 Sandwiches ($26.00)";
	$currencyType="cad";
?>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<!--script src="{{ asset('assets/global/scripts/stripe.js') }}"></script-->
<script src="{{ asset('assets/global/scripts/form-validation.js') }}"></script>

<?php if(!isset($loaded_from)){?>
{!! Form::open(array('id'=>'payment-form','class'=>'form-horizontal','method'=>'post','role'=>'form')) !!}
<br/>
<?php }?>

<div class="col-xs-12 p-t-1">

<span class="payment-errors instruct"></span>
<input name="user_id" type="hidden" class="S_user_id" value='{{ Session::get("session_id") }}' />
<input name="chargeamt" type="hidden" class="S_chargeamt" value='{{ (isset($invoiceCents))?$invoiceCents:"" }}' />
<input name="description" type="hidden" class="S_description" value='{{ (isset($orderDesc))?$orderDesc:"" }}' />
<input name="currencyType" type="hidden" class="S_currencyType" value='{{ $currencyType }}' />
<input name="taxpd" type="hidden" class="S_taxpd" value='{{ (isset($salesTax))?$salesTax:"" }}' />
<input name="orderID" type="hidden" class="S_orderID" value='{{ (isset($orderID))?$orderID:"" }}' />
<input type="hidden" name="stripeToken" value=""/>

<div class="form-group row editaddress 2">
	<label aria-required="true" class="col-xs-5 text-xs-right required" id="card_number">Card Number</label>
	<div class="col-xs-7">
		<div class="input-icon">
			<input aria-required="true" autocomplete="off" name="cardnumber" class="form-control" type="text" size="20" data-stripe="number" required/>
		</div>
	</div>
</div>
    
<div class="form-group row editaddress 2">
	<label aria-required="true" class="col-xs-5 text-xs-right required" id="cvc">CVC</label>
	<div class="col-xs-4">
		<div class="input-icon">
			<input aria-required="true" autocomplete="off"  name="cardcvc" class="form-control" type="text" size="4" data-stripe="cvc" required/>
		</div>
	</div>
</div>
    
<div class="form-group row editaddress 2">
	<label aria-required="true" class="col-xs-5 text-xs-right required" id="expiry">Expiry</label>
	<div class="col-xs-4">
		<div class="input-icon">
			<SELECT aria-required="true" name="cardmonth" class="form-control lesspadding" data-stripe="exp-month">
				<OPTION value="01">January</OPTION>
				<OPTION value="02">February</OPTION>
				<OPTION value="03">March</OPTION>
				<OPTION value="04">April</OPTION>
				<OPTION value="05">May</OPTION>
				<OPTION value="06">June</OPTION>
				<OPTION value="07">July</OPTION>
				<OPTION value="08">August</OPTION>
				<OPTION value="09">September</OPTION>
				<OPTION value="10">October</OPTION>
				<OPTION value="11">November</OPTION>
				<OPTION value="12">December</OPTION>
			</SELECT>
		</div>
	</div>
	<div class="col-xs-3 p-l-0">
		<div class="input-icon">
			<SELECT aria-required="true" name="cardyear" class="form-control lesspadding" data-stripe="exp-year">
				<?php
					$current_year = date("Y");//2 digits
					for($now = $current_year; $now < $current_year + 10; $now++){
						echo '<OPTION VALUE="' . $now. '">' . $now . '</OPTION>';
					}
				?>
			</SELECT>
		</div>
	</div>
</div>


<?php if(!isset($loaded_from)){?>
<div class="form-group row editaddress 2">
	<div class="col-xs-9">
		<div class="input-icon">
			<button type="submit" class="btn btn-primary pull-right">Pay For Order</button>
		</div>
	</div>
</div>
{!! Form::close() !!}
<?php }?>
<SCRIPT>
	validateform("payment-form", {cardnumber: "creditcard"});
</SCRIPT>
<!--
<div class="col-xs-12">
            <div class="form-group">
            Pay:
    <label class="radio-inline c-input c-radio">
            <input type="radio" name="paywhen" VALUE="now" onclick="payclicked();">
            <span class="c-indicator"></span>
            <strong>Now</strong>
            </label>
            <label class="radio-inline c-input c-radio">
            <input type="radio" name="paywhen" VALUE="later" CHECKED onclick="payclicked();">
            <span class="c-indicator"></span>
            <strong>On arrival</strong>
    </label>
    </DIV>
    <div class="form-group" ID="payment" style="display:none;">
            include("home.stripe")
		</div>
            </div>
    function payclicked(){
        var selected = $('input:radio[name=paywhen]:checked').val();
        if(selected=="now"){
            $("#payment").show();
        } else {
            $("#payment").hide();
        }
    }
-->

    
