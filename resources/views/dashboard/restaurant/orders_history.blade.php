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
            <div class="row">
                @include('layouts.includes.leftsidebar')

                <div class="col-xs-12 col-md-9 col-sm-8">
                    <div class="deleteme">
                        <h3 class="sidebar__title">Orders History</h3>
                        <hr class="shop__divider">

                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box red-intense">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-globe"></i>Orders List
                                </div>
                                <div class="tools">
                                </div>
                            </div>
                            <div class="portlet-body">
                                <table class="table table-striped table-bordered table-hover" id="sample_1">
                                    <thead>
                                        <tr>
                                            <th width="10%">Order #</th>
                                            <th width="30%">Ordered By</th>
                                            <th width="30%">Date/Time</th>
                                            <th width="10%">Status</th>
                                            <th width="20%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orders_list as $value)
                                        <tr>
                                            <td>{{ $value->id }}</td>
                                            <td>{{ $value->ordered_by }}</td>
                                            <td>{{ $value->order_time }}</td>
                                            <td>{{ $value->status }}</td>
                                            <td>
                                                <a href="#" class="btn btn-success">View</a>
                                                <a href="#" class="btn btn-danger" onclick="return confirm(' Are you sure you want to delete order');">Delete</a>
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


<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{ asset('assets/global/plugins/select2/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js') }}"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ asset('assets/admin/layout/scripts/demo.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/pages/scripts/table-advanced.js') }}"></script>
<script>
    jQuery(document).ready(function() {
        Demo.init(); // init demo features
        TableAdvanced.init();
    });
</script>
@stop