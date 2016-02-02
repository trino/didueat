<?php printfile("views/dashboard/notifications_address/ajax/edit.blade.php"); ?>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label col-md-4 text-xs-right">Contact Me By:</label>
                <div class="col-md-8 reach_type">
                    <label class="form-control-nobord c-input c-radio">
                        <input type="radio" value="1" id="is_email"
                               @if(!$address_detail->is_call && !$address_detail->is_sms) checked
                               @endif
                               onchange="uncheck('is_sms');uncheck('is_call');document.getElementById('phone_or_email_label').innerHTML='Email Address:'" style="border:none"> Email
                        <span class="c-indicator"></span>
                    </label>
                    <label class="form-control-nobord c-input c-radio">
                        <input type="radio" name="is_call" id="is_call" value="1"
                               @if($address_detail->is_call == 1) checked @endif
                               onchange="uncheck('is_sms');uncheck('is_email');document.getElementById('phone_or_email_label').innerHTML='Phone Number:';"> Phone Call
                        <span class="c-indicator"></span>
                    </label>
                    <label class="form-control-nobord c-input c-radio">
                        <input type="radio" name="is_sms" id="is_sms" value="1"
                               @if($address_detail->is_sms == 1)) checked
                               @endif
                               onchange="uncheck('is_call');uncheck('is_email');document.getElementById('phone_or_email_label').innerHTML='Cellphone Number:';"> Text Message
                        <span class="c-indicator"></span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group row editaddress "><label class="col-sm-4 text-xs-right" id="phone_or_email_label">Phone or Email:</label><div class="col-sm-8"><input type="text" placeholder="" name="address" class="form-control" value="{{ (isset($address_detail->address))?$address_detail->address:'' }}" required style="width:175px">
</div></div>



<?= newrow(false, "Notes", "", false); ?>
    <input type="text" placeholder="Optional" name="note" class="form-control" value="{{ (isset($address_detail->note))?$address_detail->note:'' }}">
</div></div>

</div>

<div class="clearfix"></div>
<input type="hidden" name="id" value="{{ (isset($address_detail->id))?$address_detail->id:'' }}"/>
<input type="hidden" name="is_contact_type" class="is_contact_type" value="@if(isset($address_detail) && ($address_detail->is_call == 1 || $address_detail->is_sms == 1)) 1 @endif"/>
</div>
<SCRIPT>
    function uncheck(ID) {
        $('#' + ID).attr('checked', false);
    }
</SCRIPT>