<?php
	printfile("views/home/stripe.blade.php");
	$orderDesc= DIDUEAT . " order";
	$currencyType="cad";

	$CanSaveCard = false;//set to true to allow saving cards
	$CreditCards = false;
	if($CanSaveCard){
		$CreditCards = select_field_where("credit_cards", array("user_id" => read("id"), "user_type" => "user"), false);
	}
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
	<input type="hidden" name="stripeToken" value="" class="stripeToken"/>

	@if($CreditCards)
		<div class="form-group row editcard">
			<label class="col-xs-5 text-xs-right">
				Saved Card
			</label>
			<div class="col-xs-7">
				<div class="input-icon">
					<SELECT name="cardid" ID="cardid" class="form-control" onchange="changecard();">
						<OPTION VALUE="">New Card</OPTION>
						<?php
							foreach($CreditCards as $CreditCard){
								$CardNumber = obfuscate(\Crypt::decrypt($CreditCard->card_number));
								$Month = \Crypt::decrypt($CreditCard->expiry_month);
								$Year = \Crypt::decrypt($CreditCard->expiry_year);
								if($Year > date("y") || ($Year == date("y") && $Month >= date("n")) ){//check if it's expired
									echo '<OPTION VALUE="' . $CreditCard->id . '">' . $CardNumber . '</OPTION>';//card number never reaches the user
								}
							}
						?>
					</SELECT>
				</div>
			</div>
		</div>
	@endif

	<div class="form-group row editcard">
		<label aria-required="true" class="col-xs-3 text-xs-right required" id="card_number">Card #@if(debugmode())<i class="fa fa-credit-card" onclick="$('#cardnumber').val('4242424242424242');" TITLE="Click to use DEBUG MODE card"></i>@endif</label>
		<div class="col-xs-9">
			<div class="input-icon">
				<input aria-required="true" autocomplete="off" name="cardnumber" id="cardnumber" class="form-control" type="text" size="20" data-stripe="number" required/>
			</div>
		</div>
	</div>

	<div class="form-group row editcard">
		<label aria-required="true" class="col-xs-3 text-xs-right required" id="cvc">CVC</label>
		<div class="col-xs-4">
			<div class="input-icon">
				<input aria-required="true" autocomplete="off"  name="cardcvc" class="form-control" type="text" size="4" data-stripe="cvc" required/>
			</div>
		</div>
	</div>

	<div class="form-group row editcard">
		<label aria-required="true" class="col-xs-3 text-xs-right required" id="expiry">Expiry</label>
		<div class="col-xs-5">
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
		<div class="col-xs-4 p-l-0">
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

	@if($CanSaveCard)
		<div class="form-group row editcard">
			<label class="col-xs-5 text-xs-right"></label>
			<div class="col-xs-4">
				<div class="input-icon">
					<label class="radio-inline c-input c-checkbox">
						<input type="checkbox" name="savecard">
						<span class="c-indicator"></span>
						<strong>Save</strong>
					</label>
				</div>
			</div>
		</div>
	@endif

	<?php if(!isset($loaded_from)){?>
		<div class="form-group row editaddress">
			<div class="col-xs-9">
				<div class="input-icon">
					<button type="submit" class="btn btn-primary pull-right">Pay For Order</button>
				</div>
			</div>
		</div>
		{!! Form::close() !!}
		<SCRIPT>
			validateform("payment-form", {cardnumber: "creditcard"});
		</SCRIPT>
	<?php }?>
</div>
<SCRIPT>
	function changecard(){
		if ($("#cardid").val()){
			$(".editcard").hide();
		} else {
			$(".editcard").show();
		}
	}
</SCRIPT>