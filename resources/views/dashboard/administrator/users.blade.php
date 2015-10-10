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


<a class="btn btn-danger pull-right fancybox-fast-view" href="#addNewUser">Add New</a>



<div class="content-page">
    <div class="row">



        @include('layouts.includes.leftsidebar')



                <div class="col-xs-12 col-md-10 col-sm-8">





                @if(\Session::has('message'))
                        <div class="alert {!! Session::get('message-type') !!}">
                            <strong>{!! Session::get('message-short') !!}</strong> &nbsp; {!! Session::get('message') !!}
                        </div>
                    @endif

                    <div class="deleteme">

                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box red-intense">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-globe"></i>Users List
                                </div>
                                <div class="tools">
                                </div>
                            </div>
                            <div class="portlet-body">
                                <table class="table table-striped table-bordered table-hover" id="sample_1">
                                    <thead>
                                        <tr>
                                            <th width="5%">ID</th>
                                            <th width="25%">Name</th>
                                            <th width="25%">Email</th>
                                            <th width="15%">Phone</th>
                                            <th width="10%">Type</th>
                                            <th width="20%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users_list as $value)
                                        <tr>
                                            <td>{{ $value->ID }}</td>
                                            <td>{{ $value->name }}</td>
                                            <td>{{ $value->email }}</td>
                                            <td>{{ $value->phone }}</td>
                                            <td>{{ select_field('profiletypes', 'ID', $value->profileType, 'name') }}</td>
                                            <td>
                                                <a href="{{ url('restaurant/users?action=user_fire&ID='.$value->id) }}" class="btn btn-danger" onclick="return confirm('Are you sure you want to fire <?= addslashes($value->name); ?>?');">Fire</a>
                                                <a href="{{ url('restaurant/users?action=user_possess&ID='.$value->id) }}" class="btn btn-info" onclick="return confirm('Are you sure you want to possess <?= addslashes($value->name); ?>?');">Possess</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- END EXAMPLE TABLE PORTLET-->

                    </div>
                </div>


    </div>
    </div>
    <!-- END CONTENT -->

















<div id="addNewUser" class="col-md-12" style="display: none;" >
    <div class="modal-dialog">
        <div class="fancy-modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New</h4>
            </div>
            {!! Form::open(array('url' => '/restaurant/users', 'id'=>'addNewForm', 'class'=>'form-horizontal form-restaurants','method'=>'post','role'=>'form')) !!}
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label col-md-3">Name</label>
                            <div class="col-md-9">
                                <input type="text" name="name" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label col-md-3">Email</label>
                            <div class="col-md-9">
                                <input type="text" name="email" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label col-md-3">Phone</label>
                            <div class="col-md-9">
                                <input type="text" name="phone" class="form-control" required>
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
                                <select name="profile_type" class="form-control">
                                    <option value="2">User</option>
                                    <option value="4">Employee</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label col-md-3">Password</label>
                            <div class="col-md-9">
                                <input type="password" name="password" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label col-md-3">Confirm Password</label>
                            <div class="col-md-9">
                                <input type="password" name="confirm_password" class="form-control" required>
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
        </div>
        </div>
        <!-- /.modal-content -->


<script type="text/javascript" src="{{ asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}"></script>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{ asset('assets/global/plugins/select2/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js') }}"></script>
<!--script type="text/javascript" src="{{ asset('assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js') }}"></script-->
<script type="text/javascript" src="{{ asset('assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js') }}"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ asset('assets/admin/layout/scripts/demo.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/pages/scripts/table-advanced.js') }}"></script>
<script src="{{ asset('assets/global/scripts/metronic.js') }}" type="text/javascript"></script>
<script>
    jQuery(document).ready(function() {
        Metronic.init(); // init metronic core components
        Demo.init(); // init demo features
        TableAdvanced.init();
        $("#addNewForm").validate();
    });
</script>
@stop