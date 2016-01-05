<?php printfile("views/dashboard/notifications_address/ajax/editaddress.blade.php"); ?>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label col-md-3">Phone / Email</label>
                <div class="col-md-9">
                    <input type="text" name="address" class="form-control" value="{{ (isset($address_detail->address))?$address_detail->address:'' }}" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">&nbsp;</label>
                <div class="col-md-9 reach_type" style="display: @if(isset($address_detail) && ($address_detail->is_call == 1 || $address_detail->is_sms == 1)) block @else none @endif;">
                    <label><input type="checkbox" name="is_call" value="1" @if(isset($address_detail->is_call) && $address_detail->is_call == 1) checked @endif> Call</label> &nbsp;
                    <label><input type="checkbox" name="is_sms" value="1" @if(isset($address_detail->is_sms) && $address_detail->is_sms == 1) checked @endif> SMS</label>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label col-md-3">Note</label>
                <div class="col-md-9">
                    <input type="text" name="note" class="form-control" value="{{ (isset($address_detail->note))?$address_detail->note:'' }}" required>
                </div>
            </div>
        </DIV>
    </div>
    <div class="clearfix"></div>
    <input type="hidden" name="id" value="{{ (isset($address_detail->id))?$address_detail->id:'' }}" />
    <input type="hidden" name="is_contact_type" class="is_contact_type" value="@if(isset($address_detail) && ($address_detail->is_call == 1 || $address_detail->is_sms == 1)) 1 @endif" />
</div>