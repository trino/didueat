@extends('layouts.default')
@section('content') 

<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/select2/select2.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css') }}"/>
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN THEME STYLES -->
<link href="{{ asset('assets/global/css/plugins.css') }}" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->

<div class="margin-bottom-40">
    <!-- BEGIN CONTENT -->
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="row content-page">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="">

                </div>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12 no-padding">
            <div class="row">
                @include('layouts.includes.leftsidebar')

                <div class="col-xs-12 col-md-10 col-sm-8">
                    @if(Session::has('message'))
                    <div class="alert alert-info">
                        <strong>Alert!</strong> &nbsp; {!! Session::get('message') !!}
                    </div>
                    @endif

                    <div class="deleteme">
                        <h3 class="sidebar__title">Addresses Manager</h3>
                        <hr class="shop__divider">

                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box red-intense">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-globe"></i>Addresses List
                                </div>
                                <div class="tools">
                                </div>
                            </div>
                            <div class="portlet-body">
                                <table class="table table-striped table-bordered table-hover" id="sample_1">
                                    <thead>
                                        <tr>
                                            <th width="5%">ID</th>
                                            <th width="15%">Mobile #</th>
                                            <th width="20%">Apartment/Unit/Room</th>
                                            <th width="20%">Buzz code/doorbell number</th>
                                            <th width="25%">Address</th>
                                            <th width="15%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($addresses_list as $value)
                                        <tr>
                                            <td>{{ $value->ID }}</td>
                                            <td>{{ $value->Number }}</td>
                                            <td>{{ $value->Apt }}</td>
                                            <td>{{ $value->Buzz }}</td>
                                            <td>{{ $value->Street.', '.$value->City.', '.$value->Province.', '.$value->PostCode.', '.select_field('countries', 'ID', $value->Country, 'Name') }}</td>
                                            <td>
                                                <a href="{{ url('user/addresses/'.$value->ID) }}" class="btn btn-danger">Edit</a>
                                                <a href="{{ url('user/addresses/delete/'.$value->ID) }}" class="btn btn-danger" onclick="return confirm(' Are you sure you want to delete this ? ');">Delete</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- END EXAMPLE TABLE PORTLET-->

                        <hr class="shop__divider">

                        <div class="portlet box red">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-gift"></i> Add Address
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <!-- BEGIN FORM-->
                                {!! Form::open(array('url' => 'user/addresses', 'id'=>'addressesForm', 'class'=>'form-horizontal','method'=>'post','role'=>'form')) !!}
                                    <div class="form-body">                                        
                                        <h3 class="form-section">Person Info</h3>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-5 col-sm-5 col-xs-12">Street Address <span class="required">*</span></label>
                                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                                        <input type="text" name="Street" class="form-control" placeholder="Street address" value="{{ (isset($addresse_detail->Street))?$addresse_detail->Street:'' }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-5 col-sm-5 col-xs-12">Postal Code</label>
                                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                                        <input type="text" name="PostCode" class="form-control" placeholder="Postal Code" value="{{ (isset($addresse_detail->PostCode))?$addresse_detail->PostCode:'' }}">
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
                                                        <input type="text" name="Apt" class="form-control" placeholder="Name of the address" value="{{ (isset($addresse_detail->Apt))?$addresse_detail->Apt:'' }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-5 col-sm-5 col-xs-12">Buzz code/door bell number</label>
                                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                                        <input type="text" name="Buzz" class="form-control" placeholder="Buzz code or door bell number" value="{{ (isset($addresse_detail->Buzz))?$addresse_detail->Buzz:'' }}">
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
                                                        <input type="text" name="Number" class="form-control" placeholder="Mobile Number" value="{{ (isset($addresse_detail->Number))?$addresse_detail->Number:'' }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-5 col-sm-5 col-xs-12">Phone Number</label>
                                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                                        <input type="text" name="PhoneNo" class="form-control" placeholder="Phone Number" value="{{ (isset($addresse_detail->PhoneNo))?$addresse_detail->PhoneNo:'' }}">
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
                                                        <input type="text" name="City" class="form-control" placeholder="City" value="{{ (isset($addresse_detail->City))?$addresse_detail->City:'' }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-5 col-sm-5 col-xs-12">Province <span class="required">*</span></label>
                                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                                        <input type="text" name="Province" class="form-control" placeholder="Province" value="{{ (isset($addresse_detail->Province))?$addresse_detail->Province:'' }}" required>
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
                                                        <select name="Country" class="form-control" required>
                                                            <option value="">-Select One-</option>
                                                            @foreach($countries_list as $value)
                                                                <option value="{{ $value->id }}" {{ (isset($addresse_detail->Country) && $addresse_detail->Country == $value->id)? 'selected' :'' }}>{{ $value->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-5 col-sm-5 col-xs-12">Notes</label>
                                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                                        <input type="text" name="Notes" class="form-control" placeholder="Notes" value="{{ (isset($addresse_detail->Notes))?$addresse_detail->Notes:'' }}">
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
                                                        <input type="hidden" name="ID" value="{{ (isset($addresse_detail->ID))?$addresse_detail->ID:'' }}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                            </div>
                                        </div>
                                    </div>
                                {!! Form::close() !!}
                                <!-- END FORM-->
                            </div>
                        </div>

                        <hr class="shop__divider">
                    </div>        
                </div>
            </div>
            </div>
        </div>
    </div>                
    <!-- END CONTENT -->
</div>

<div id="addNewUser" class="col-md-12" style="display: none;" >
    <div class="modal-dialog">
        <div class="fancy-modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New</h4>
            </div>
            {!! Form::open(array('url' => '/restaurant/addresses', 'id'=>'addNewForm', 'class'=>'form-horizontal form-restaurants','method'=>'post','role'=>'form')) !!}
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label col-md-3">Phone / Email</label>
                            <div class="col-md-9">
                                <input type="text" name="Address" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label col-md-3">Type</label>
                            <div class="col-md-9">
                                <select name="Type" class="form-control">
                                    <option value="Email">Email</option>
                                    <option value="Phone">Phone</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn blue">Save changes</button>
            </div>
            {!! Form::close() !!}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{ asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/select2/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js') }}"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ asset('assets/global/scripts/metronic.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/layout/scripts/demo.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/pages/scripts/table-advanced.js') }}"></script>
<script src="{{ asset('assets/admin/pages/scripts/form-samples.js') }}"></script>
<script src="{{ asset('assets/admin/pages/scripts/form-validation.js') }}"></script>
<script>
jQuery(document).ready(function() {
    Metronic.init();
    Demo.init();
    $("#addressesForm").validate();
    TableAdvanced.init();
    FormSamples.init();
});
</script>
@stop