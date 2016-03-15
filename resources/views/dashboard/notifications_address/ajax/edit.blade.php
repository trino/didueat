<?php printfile("views/dashboard/notifications_address/ajax/edit.blade.php"); ?>
<div class="modal-body">
    <div class="row">
        <?= newrow(false, "Contact me by", "", true); ?>
            <div class="reach_type">
                <label class="form-control-nobord c-input c-radio">
                    <input type="radio" value="1" id="is_email"
                           @if(isset($address_detail->is_call) && !$address_detail->is_call && !$address_detail->is_sms) checked @endif
                           onchange="uncheck('is_sms');uncheck('is_call');"> Email
                    <span class="c-indicator"></span>
                </label>
                <label class="form-control-nobord c-input c-radio">
                    <input type="radio" name="is_call" id="is_call" value="1"
                           @if(isset($address_detail->is_call) && $address_detail->is_call == 1) checked @endif
                           onchange="uncheck('is_sms');uncheck('is_email');"> Phone Call
                    <span class="c-indicator"></span>
                </label>
                <label class="form-control-nobord c-input c-radio">
                    <input type="radio" name="is_sms" id="is_sms" value="1"
                           @if(!isset($address_detail) || (isset($address_detail->is_sms) && $address_detail->is_sms == 1)) checked @endif
                           onchange="uncheck('is_call');uncheck('is_email');"> Text Message
                    <span class="c-indicator"></span>
                </label>
            </div>
        <?= newrow(); ?>

        <?= newrow(false, "Phone or Email", "", true); ?>
            <input type="text" placeholder="" name="address" class="form-control" value="{{ (isset($address_detail->address))?$address_detail->address:'' }}" required onblur="validateall();">
        <?= newrow(); ?>

        <?= newrow(false, "Notes", "", false); ?>
            <input type="text" placeholder="Optional" name="note" class="form-control" value="{{ (isset($address_detail->note))?$address_detail->note:'' }}">
        <?= newrow(); ?>

        <input type="hidden" name="id" value="{{ (isset($address_detail->id))?$address_detail->id:'' }}"/>
        <input type="hidden" name="is_contact_type" class="is_contact_type" value="@if(isset($address_detail) && ($address_detail->is_call == 1 || $address_detail->is_sms == 1)) 1 @endif"/>

    </div>
</div>

<SCRIPT>
    function uncheck(ID) {
        $('#' + ID).attr('checked', false);
    }

    //makesure the notification method is valid
    function validateNotif(f){
        toast("");
        if(!f.is_email.checked && !f.is_call.checked && !f.is_sms.checked){
            toast("Please select one of the options for Contact Me By");
            return false;
        }
        phonetype="";
        notifType="";
        if(f.is_call.checked){
            phonetype="Phone";
            notifType="Phone";
        } else if(f.is_sms.checked){
            phonetype="Cellphone";
            notifType="Text Msg";
        } else {
            notifType="Email";
        }

        f.type.value=notifType;
        var x=f.address.value;

        if(f.is_email.checked){
            // email
            var filter=/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            if(!filter.test(x)){
                if(x) {toast("Please Enter a Valid Email Address");}
                f.address.focus()
                return false;
            }
        } else{
            // verify it is a number, at the correct length
            var cleanedPhone = x.replace(/\D/g,'');
            if(cleanedPhone.length != 10){
                if(x) {toast("Your " + phonetype + " Number must have exactly 10 digits.");}
                f.address.focus();
                return false
            }
            //don't worry about invalid characters, the model will remove them all
            return true;
        }
    }

</SCRIPT>