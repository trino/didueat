<script src="<?= url("assets/global/scripts/provinces.js"); ?>" type="text/javascript"></script>
<meta name="_token" content="{{ csrf_token() }}"/>
<div class="modal-dialog2">
    <div class="fancy-modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Update Location</h4>
        </div>
        {!! Form::open(array('url' => 'user/addresses/', 'id'=>'addressesEditForm', 'class'=>'form-horizontal','method'=>'post','role'=>'form')) !!}
        <div class="form-body">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-5 col-xs-12">Location Name</label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <input type="text" name="location" class="form-control" placeholder="Location Name" value="{{ (isset($addresse_detail->location))?$addresse_detail->location:'' }}">
                        </div>
                    </div>
                </div>
            </div>
            <!--/row-->
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-5 col-xs-12">Street Address <span class="required">*</span></label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <input type="text" name="address" class="form-control" placeholder="Street address" value="{{ (isset($addresse_detail->address))?$addresse_detail->address:'' }}" required>
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
                            <select name="province" class="form-control" id="province2" required>
                                <option value="">-Select One-</option>
                                @foreach($states_list as $value)
                                    <option value="{{ $value->id }}" {{ (isset($addresse_detail->province) && $addresse_detail->province == $value->id)?'selected':'' }}>{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!--/row-->
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-5 col-xs-12">Phone Number</label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <input type="text" name="phone_no" class="form-control" placeholder="Phone Number" value="{{ (isset($addresse_detail->phone_no))?$addresse_detail->phone_no:'' }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label class="control-label col-md-5 col-sm-5 col-xs-12">Country <span class="required">*</span></label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <select name="country" class="form-control" id="country2" required onchange="provinces('<?= addslashes(url("ajax")); ?>', '<?= $addresse_detail->province; ?>');">
                                <option value="">-Select One-</option>
                                @foreach($countries_list as $value)
                                    <option value="{{ $value->id }}" {{ (isset($addresse_detail->country) && $addresse_detail->country == $value->id)? 'selected' :'' }}>{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!--/row-->
        </div>

        <br />

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