<?php
printfile("views/home/stripe.blade.php");

// sample values to be added to Stripe form
 $salesTax=2.99;
 $orderID=110;
 $invoiceCents=2600; // must be in cents
 $orderDesc="2 Sandwiches ($26.00)";
 $currencyType="cad";

?> 
<br/>
   <span class="payment-errors instruct"></span>
   <input name="chargeamt" type="hidden" value='{{ $invoiceCents }}' />
   <input name="description" type="hidden" value='{{ $orderDesc }}' />
   <input name="currencyType" type="hidden" value='{{ $currencyType }}' />
   <input name="taxpd" type="hidden" value='{{ $salesTax }}' />
   <input name="orderID" type="hidden" value='{{ $orderID }}' />
			<div class="form-group row editaddress 2"><label aria-required="true" class="col-sm-5 text-sm-right required" id="card_number">Card Number</label><div class="col-sm-7"><div class="input-icon">
			<input aria-required="true"  class="form-control" type="text" size="20" data-stripe="number"/>
			</div>
			</div></div>
    
			<div class="form-group row editaddress 2"><label aria-required="true" class="col-sm-5 text-sm-right required" id="cvc">CVC</label><div class="col-sm-3"><div class="input-icon">
			<input aria-required="true"  class="form-control" type="text" size="4" data-stripe="cvc"/>
			</div>
			</div></div>
    
			<div class="form-group row editaddress 2"><label aria-required="true" class="col-sm-5 text-sm-right required" id="expiry">Expiration (MM/YYYY)</label><div class="col-sm-2"><div class="input-icon">
<input aria-required="true"  class="form-control" type="text" size="2" data-stripe="exp-month" /></div></div>
<div class="col-sm-1"><div class="input-icon"><div class="bigT"> / </div></div></div>
<div class="col-sm-3"><div class="input-icon"><input aria-required="true"  class="form-control" type="text" size="6" data-stripe="exp-year" />			
			</div>
			</div></div>
        
			<div class="form-group row editaddress 2"><div class="col-sm-9"><div class="input-icon">
			<button type="submit" class="btn btn-primary pull-right">Pay For Order</button>
			</div>
			</div></div>



        


    
