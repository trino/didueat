<?php printfile("views/dashboard/notifications_address/ajax/editaddress.blade.php"); ?>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">

            <div class="form-group">
















                <label class="control-label col-md-3">Contact Me By:</label>

                <div class="col-md-9 reach_type">

                    <label class="form-control-nobord">
                        <input type="radio" value="1" id="is_email"
                               @if(isset($address_detail->is_call) && !$address_detail->is_call && !$address_detail->is_sms) checked
                               @endif
                               onchange="uncheck('is_sms');uncheck('is_call');" style="border:none"> Email
                    </label>
                    <label class="form-control-nobord">
                        <input type="radio" name="is_call" id="is_call" value="1"
                               @if(isset($address_detail->is_call) && $address_detail->is_call == 1) checked @endif
                               onchange="uncheck('is_sms');uncheck('is_email');"> Phone Call
                    </label>
                    <label class="form-control-nobord">
                        <input type="radio" name="is_sms" id="is_sms" value="1"
                               @if(!isset($address_detail) || (isset($address_detail->is_sms) && $address_detail->is_sms == 1)) checked
                               @endif
                               onchange="uncheck('is_call');uncheck('is_email');"> Text Message
                    </label>
                </div>
            </div>


        </div>
    </div>





</div>


        <?php
        echo newrow(false, "Phone or Email", "", false); ?>
        <input type="text" placeholder="" name="address" class="form-control"
               value="{{ (isset($address_detail->address))?$address_detail->address:'' }}" required style="width:175px">
    </div>
</div>


<?php

echo newrow(false, "Notes", "", false); ?>
<input type="text" placeholder="Optional" name="note" class="form-control"
       value="{{ (isset($address_detail->note))?$address_detail->note:'' }}">
</div>
</div>


</div>
<div class="clearfix"></div>
<input type="hidden" name="id" value="{{ (isset($address_detail->id))?$address_detail->id:'' }}"/>
<input type="hidden" name="is_contact_type" class="is_contact_type"
       value="@if(isset($address_detail) && ($address_detail->is_call == 1 || $address_detail->is_sms == 1)) 1 @endif"/>
</div>
<SCRIPT>
    function uncheck(ID) {
        $('#' + ID).attr('checked', false);
    }
</SCRIPT>