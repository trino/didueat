<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label col-md-3">Phone / Email</label>
                <div class="col-md-9">
                    <input type="text" name="address" class="form-control" value="{{ $address_detail->address }}" required>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<div class="modal-footer">
    <input type="hidden" name="id" value="{{ $address_detail->id }}" />
    <button type="submit" class="btn blue">Save changes</button>
</div>