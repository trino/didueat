<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<!--script src="{{ asset('assets/global/scripts/stripe.js') }}"></script-->
<script src="{{ asset('assets/global/scripts/form-validation.js') }}"></script>
<?php
printfile("views/home/stripe.blade.php");
$orderDesc = DIDUEAT . " order";
$currencyType = "cad";

$CanSaveCard = false;//set to true to allow saving cards
$CreditCards = false;
if ($CanSaveCard) {
    $CreditCards = select_field_where("credit_cards", array("user_id" => read("id"), "user_type" => "user"), false);
}
if(read('id'))
{
    $cc = \App\Http\Models\CreditCard::where('user_id',read('id'))->get();
    if($cc->count()>0)
    {
        echo '<div class="col-xs-12 form-group ">';
        foreach($cc as $c)
        {
            $CardNumber = (\Crypt::decrypt($c->card_number));
            $Month = \Crypt::decrypt($c->expiry_month);
            $Year = \Crypt::decrypt($c->expiry_year);
            $cvc = \Crypt::decrypt($c->ccv);
            echo '<input type="hidden" id="CC'.$c->id.'" value="'.$CardNumber.'_'.$Month.'_'.$Year.'_'.$cvc.'" />';
        }
        echo "<select class='changeCC form-control'>";
        echo "<option value='0'>Choose Credit Card</option>";
        foreach($cc as $c)
        {
            $CardNumber = obfuscate(\Crypt::decrypt($c->card_number));
            $Month = \Crypt::decrypt($c->expiry_month);
            $Year = \Crypt::decrypt($c->expiry_year);
            $cvc = \Crypt::decrypt($c->ccv);
            if ($Year > date("y") || ($Year == date("y") && $Month >= date("n"))) {
                echo '<option value="' . $c->id . '">' . $CardNumber . '('.$c->first_name.' '.substr($c->last_name,0,1).'.)</option>';
                
            }
        }
        echo "</select> </div>";
    }
}
if(!isset($loaded_from)){ ?>
{!! Form::open(array('id'=>'payment-form','class'=>'form-horizontal','method'=>'post','role'=>'form')) !!}<br/>
<?php } ?>

<div class="col-xs-12">
    <span class="payment-errors instruct"></span>
    <input name="user_id" type="hidden" class="S_user_id" value='{{ Session::get("session_id") }}'/>
    <input name="chargeamt" type="hidden" class="S_chargeamt" value='{{ (isset($invoiceCents))?$invoiceCents:"" }}'/>
    <input name="description" type="hidden" class="S_description" value='{{ (isset($orderDesc))?$orderDesc:"" }}'/>
    <input name="currencyType" type="hidden" class="S_currencyType" value='{{ $currencyType }}'/>
    <input name="taxpd" type="hidden" class="S_taxpd" value='{{ (isset($salesTax))?$salesTax:"" }}'/>
    <input name="orderID" type="hidden" class="S_orderID" value='{{ (isset($orderID))?$orderID:"" }}'/>
    <input type="hidden" name="stripeToken" value="" class="stripeToken"/>



    <div class="row ">

        <div class="col-xs-12 form-group ">
            <!--label aria-required="true" class="col-xs-3 text-xs-right required" id="card_number">Card #@if(debugmode())<i class="fa fa-credit-card" onclick="$('#cardnumber').val('4242424242424242');" TITLE="Click to use DEBUG MODE card"></i>@endif</label-->

            <div class="input-group" style="width:100% !important;">
                <!--span class="input-group-addon" id="credit-card-addon"><i class="fa fa-fw fa-credit-card" onclick="$('#cardnumber').val('4242424242424242');" TITLE="Click to use DEBUG MODE card"></i></span-->
                <input aria-required="true" autocomplete="off" name="cardnumber" placeholder="Card Number"
                       id="cardnumber" class="form-control" type="text" size="20" data-stripe="number" required
                       aria-describedby="credit-card-addon" style="width:75%;"/>

                <input aria-required="true" autocomplete="off" placeholder="CVC" name="cardcvc" class="form-control"
                       type="text" size="4" data-stripe="cvc" required aria-describedby="cvc-addon"
                       style="border-left:0 !important;width:25%;" id="cvc"/>

            </div>
        </div>


        <div class=" col-xs-12 form-group ">
            <!--label aria-required="true" class="col-xs-3 text-xs-right required" id="cvc">CVC</label-->
            <!--label aria-required="true" class="col-xs-3 text-xs-right required" id="expiry">Expiry</label-->

            <div class="input-group double-input">

                <span class="input-group-addon">Expires</span>

                <SELECT aria-required="true" name="cardmonth" class="form-control" data-stripe="exp-month" id="exp-month">
                    <?php
                    $Months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                    foreach ($Months as $Number => $Month) {
                        $Number++;
                        if ($Number < 10) {
                            $Number = "0" . $Number;
                        }
                        echo '<OPTION value="' . $Number . '">' . $Month . '</OPTION>';
                    }
                    ?>
                </SELECT>

                <SELECT aria-required="true" name="cardyear" class="form-control" data-stripe="exp-year"
                        style="border-left:0 !important;" id="exp-year">
                    <?php
                    $current_year = date("Y");//2 digits
                    for ($now = $current_year; $now < $current_year + 10; $now++) {
                        echo '<OPTION VALUE="' . $now . '">' . $now . '</OPTION>';
                    }
                    ?>
                </SELECT>

            </div>
        </div>
    </div>



    <?php if($CreditCards){ ?>
    <div class="form-group row editcard">
        <label class="col-xs-4 text-xs-right">
            Saved Card
        </label>

        <div class="col-xs-8">
            <div class="input-icon">
                <SELECT name="cardid" ID="cardid" class="form-control" onchange="changecard();">
                    <OPTION VALUE="">New Card</OPTION>
                    <?php
                    foreach ($CreditCards as $CreditCard) {
                        $CardNumber = obfuscate(\Crypt::decrypt($CreditCard->card_number));
                        $Month = \Crypt::decrypt($CreditCard->expiry_month);
                        $Year = \Crypt::decrypt($CreditCard->expiry_year);
                        if ($Year > date("y") || ($Year == date("y") && $Month >= date("n"))) {
                            echo '<OPTION VALUE="' . $CreditCard->id . '">' . $CardNumber . '</OPTION>';
                        }
                    }
                    ?>
                </SELECT>
            </div>
        </div>
    </div>
    <? } ?>



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
<script>
    $(function(){
        $('.changeCC').live('change',function(){
            var cc_id = $(this).val();
            var cc = $('#CC'+cc_id).val().split('_');
            $('#cardnumber').val(cc[0]);
            $('#exp-month').val(cc[1]);
            $('#exp-year').val(cc[2]);
            $('#cvc').val(cc[3]);
            
        })
    })
    function changecard() {
        if ($("#cardid").val()) {
            $(".editcard").hide();
        } else {
            $(".editcard").show();
        }
    }
</script>