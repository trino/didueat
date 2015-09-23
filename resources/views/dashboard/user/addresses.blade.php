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
    <div class="col-md-12 col-xs-12">
        <div class="row content-page">
            <div class="col-xs-12">
                <div class="">

                </div>
            </div>

            <div class="col-md-12 no-padding">
                @include('layouts.includes.leftsidebar')

                <div class="col-xs-12 col-md-9 col-sm-8">
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
                                            <th width="40%">Address</th>
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
                                        
                                        @if(Session::has('message'))
                                            <div class="alert alert-info">
                                                <strong>Alert!</strong> &nbsp; {!! Session::get('message') !!}
                                            </div>
                                        @endif
                                        
                                        <h3 class="form-section">Person Info</h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Street Address <span class="required">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="Street" class="form-control" placeholder="Street address" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Postal Code</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="PostCode" class="form-control" placeholder="Postal Code">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/row-->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Apartment/Unit/ Room <span class="required">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="Apt" class="form-control" placeholder="Name of the address" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Buzz code/door bell number</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="Buzz" class="form-control" placeholder="Buzz code or door bell number">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/row-->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Mobile Number</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="Number" class="form-control" placeholder="Mobile Number">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Phone Number</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="PhoneNo" class="form-control" placeholder="Phone Number">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/row-->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">City <span class="required">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="City" class="form-control" placeholder="City" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Province <span class="required">*</span></label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="Province" class="form-control" placeholder="Province" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/row-->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Country <span class="required">*</span></label>
                                                    <div class="col-md-9">
                                                        <select name="Country" class="form-control" required>
                                                            <option value="">-Select One-</option>
                                                            @foreach($countries_list as $value)
                                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Notes</label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="Notes" class="form-control" placeholder="Notes">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/row-->
                                    </div>
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-offset-3 col-md-9">
                                                        <button type="submit" class="btn green">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
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
    <!-- END CONTENT -->
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