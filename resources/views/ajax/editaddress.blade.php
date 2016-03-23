<div class="modal-body">
    <?php
        printfile("views/ajax/editaddress.blade.php");
        //seems to be a duplicate of views/dashboard/notifications_address/ajax/editaddress.blade.php. merge if it is
        $alts = array(
            "save" => "Save all changes"
        );
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label col-md-3">Phone / Email</label>
                <div class="col-md-9">
                    <input type="text" name="address" class="form-control address" value="{{ $address_detail->address }}" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">&nbsp;</label>
                <div class="col-md-9 reach_type" style="display: @if($address_detail->is_call == 1 || $address_detail->is_sms == 1) block @else none @endif;">
                    <label class="c-input c-radio"><input type="checkbox" name="is_call" value="1" @if($address_detail->is_call == 1) checked @endif> Call</label> &nbsp;
                    <label class="c-input c-radio"><input type="checkbox" name="is_sms" value="1" @if($address_detail->is_sms == 1) checked @endif> SMS</label>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<div class="modal-footer">
    <input type="hidden" name="id" value="{{ $address_detail->id }}" />
    <input type="hidden" name="is_contact_type" class="is_contact_type" value="@if($address_detail->is_call == 1 || $address_detail->is_sms == 1) 1 @endif" />
    <button type="submit" class="btn custom-default-btn saveNewBtn" title="{{ $alts["save"] }}">Save changes</button>
</div>