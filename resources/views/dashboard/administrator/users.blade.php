@extends('layouts.default')
@section('content')

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
                    <a class="btn red pull-right fancybox-fast-view" href="#addNewUser">Add New</a>

                    <div class="clearfix"></div>
                    <hr class="shop__divider">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="box-shadow">
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
                                        <td>{{ $value->id }}</td>
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->email }}</td>
                                        <td>{{ $value->phone }}</td>
                                        <td>{{ select_field('profiletypes', 'id', $value->profile_type, 'name') }}</td>
                                        <td>
                                            <a href="#editNewUser" class="btn red editUser fancybox-fast-view" data-id="{{ $value->id }}">Edit</a>
                                            @if($value->id != \Session::get('session_id'))
                                                <a href="{{ url('restaurant/users/action/user_fire/'.$value->id) }}" class="btn red" onclick="return confirm('Are you sure you want to fire  {{ addslashes("'" . $value->name . "'") }} ?');">Fire</a>
                                                <a href="{{ url('restaurant/users/action/user_possess/'.$value->id) }}" class="btn blue" onclick="return confirm('Are you sure you want to possess {{ addslashes("'" . $value->name . "'") }} ?');">Possess</a>
                                            @endif
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


    <div id="editNewUser" class="col-md-12 col-sm-12 col-xs-12 popup-dialog" style="display: none;">
        <div class="modal-dialog2">
            <div class="fancy-modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update</h4>
                </div>
                {!! Form::open(array('url' => '/restaurant/users/update', 'name'=>'editForm', 'id'=>'addNewForm', 'class'=>'form-horizontal form-restaurants','method'=>'post','role'=>'form')) !!}
                    <div id="editContents"></div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <!-- /.modal-content -->
    
    <div id="addNewUser" class="col-md-12 col-sm-12 col-xs-12 popup-dialog" style="display: none;">
        <div class="modal-dialog2">
            <div class="fancy-modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New</h4>
                </div>
                {!! Form::open(array('url' => '/restaurant/users', 'id'=>'addNewForm', 'class'=>'form-horizontal form-restaurants','method'=>'post','role'=>'form')) !!}
                    @include('common.edituser')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <!-- /.modal-content -->
    
    @include('common.tabletools')
    
    <script>
        $('body').on('click', '.editUser', function(){
            var id = $(this).attr('data-id');
            $.get("{{ url("restaurant/users/edit") }}/"+id, {}, function(result){
                $('#editContents').html(result);
            });
        });
    </script>
@stop