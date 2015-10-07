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
                            <h3 class="sidebar__title">Notifications Addresses</h3>
                            <hr class="shop__divider">

                            <a class="btn btn-danger pull-right fancybox-fast-view" href="#addNewUser">Add New</a>
                            <div class="clearfix"></div>
                            <hr class="shop__divider">

                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet box red-intense">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-globe"></i>Addresses List
                                    </div>
                                    <div class="tools"></div>
                                </div>
                                <div class="portlet-body">
                                    <table class="table table-striped table-bordered table-hover" id="sample_1">
                                        <thead>
                                            <tr>
                                                <th width="10%">ID</th>
                                                <th width="50%">Phone Number/Email Address</th>
                                                <th width="20%">Type</th>
                                                <th width="20%">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($addresses_list as $value)
                                            <tr>
                                                <td>{{ $value->ID }}</td>
                                                <td>{{ $value->Address }}</td>
                                                <td>{{ $value->Type }}</td>
                                                <td>
                                                    <a href="{{ url('restaurant/addresses/delete/'.$value->ID) }}" class="btn btn-danger" onclick="return confirm(' Are you sure you want to delete this ? ');">Delete</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->

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


<script type="text/javascript" src="{{ asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}"></script>
<!-- BEGIN PAGE LEVEL PLUGINS -->
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
<script src="{{ asset('assets/admin/pages/scripts/form-validation.js') }}"></script>
<script>
jQuery(document).ready(function() {
    Metronic.init(); // init metronic core components
    Demo.init(); // init demo features
    TableAdvanced.init();
    $("#addNewForm").validate();
});
</script>
@stop