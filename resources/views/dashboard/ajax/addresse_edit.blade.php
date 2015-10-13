<div class="modal-dialog">
    <div class="fancy-modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Update Address</h4>
        </div>
        {!! Form::open(array('url' => 'user/addresses/', 'id'=>'addressesEditForm', 'class'=>'form-horizontal','method'=>'post','role'=>'form')) !!}
        <div class="form-body">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-5 col-xs-12">Street Address <span class="required">*</span></label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <input type="text" name="street" class="form-control" placeholder="Street address" value="{{ (isset($addresse_detail->street))?$addresse_detail->street:'' }}" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-5 col-xs-12">Postal Code</label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <input type="text" name="post_code" class="form-control" placeholder="Postal Code" value="{{ (isset($addresse_detail->post_code))?$addresse_detail->post_code:'' }}">
                        </div>
                    </div>
                </div>
            </div>
            <!--/row-->
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-5 col-xs-12">Apartment/Unit/ Room <span class="required">*</span></label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <input type="text" name="apt" class="form-control" placeholder="Name of the address" value="{{ (isset($addresse_detail->apt))?$addresse_detail->apt:'' }}" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-5 col-xs-12">Buzz code/door bell number</label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <input type="text" name="buzz" class="form-control" placeholder="Buzz code or door bell number" value="{{ (isset($addresse_detail->buzz))?$addresse_detail->buzz:'' }}">
                        </div>
                    </div>
                </div>
            </div>
            <!--/row-->
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-5 col-xs-12">Mobile Number</label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <input type="text" name="number" class="form-control" placeholder="Mobile Number" value="{{ (isset($addresse_detail->number))?$addresse_detail->number:'' }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-5 col-xs-12">Phone Number</label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <input type="text" name="phone_no" class="form-control" placeholder="Phone Number" value="{{ (isset($addresse_detail->phone_no))?$addresse_detail->phone_no:'' }}">
                        </div>
                    </div>
                </div>
            </div>
            <!--/row-->
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-5 col-xs-12">City <span class="required">*</span></label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <input type="text" name="city" class="form-control" placeholder="City" value="{{ (isset($addresse_detail->city))?$addresse_detail->city:'' }}" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-5 col-xs-12">Province <span class="required">*</span></label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <input type="text" name="province" class="form-control" placeholder="Province" value="{{ (isset($addresse_detail->province))?$addresse_detail->province:'' }}" required>
                        </div>
                    </div>
                </div>
            </div>
            <!--/row-->
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-5 col-xs-12">Country <span class="required">*</span></label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <select name="country" class="form-control" required>
                                <option value="">-Select One-</option>
                                @foreach($countries_list as $value)
                                <option value="{{ $value->id }}" {{ (isset($addresse_detail->country) && $addresse_detail->country == $value->id)? 'selected' :'' }}>{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-5 col-xs-12">Notes</label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <input type="text" name="notes" class="form-control" placeholder="Notes" value="{{ (isset($addresse_detail->notes))?$addresse_detail->notes:'' }}">
                        </div>
                    </div>
                </div>
            </div>
            <!--/row-->
        </div>
        <div class="form-actions">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9 col-sm-9 col-xs-12">
                            <button type="submit" class="btn red">Submit</button>
                            <input type="hidden" name="id" value="{{ (isset($addresse_detail->id))?$addresse_detail->id:'' }}" />
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <!-- /.modal-content -->
</div>