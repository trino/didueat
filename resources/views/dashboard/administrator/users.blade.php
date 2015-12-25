@extends('layouts.default')
@section('content')

        <div class="row">
            @include('layouts.includes.leftsidebar')
            <div class="col-lg-9">
                <?php printfile("views/dashboard/administrator/users.blade.php"); ?>
                @if(\Session::has('message'))
                    <div class="alert {!! Session::get('message-type') !!}">
                        <strong>{!! Session::get('message-short') !!}</strong> &nbsp; {!! Session::get('message') !!}
                    </div>
                @endif

                <div class="deleteme">
                    <!--a class="btn red pull-right fancybox-fast-view" href="#addNewUser">Add New</a-->

                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#addNewUser" >
                        Add
                    </button>

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
                                            <!--a href="#editNewUser" class="btn nomargin btn-info editUser fancybox-fast-view" data-id="{{ $value->id }}">Edit</a-->


                                            <button type="button" class="btn btn-danger editUser" data-toggle="modal" data-id="{{ $value->id }}" data-target="#editNewUser" >
                                                Edit
                                            </button>



                                            @if($value->id != \Session::get('session_id'))
                                                <a href="{{ url('restaurant/users/action/user_fire/'.$value->id) }}" class="btn red" onclick="return confirm('Are you sure you want to fire  {{ addslashes("'" . $value->name . "'") }} ?');">Fire</a>
                                                <a href="{{ url('restaurant/users/action/user_possess/'.$value->id) }}" class="btn red blue" onclick="return confirm('Are you sure you want to possess {{ addslashes("'" . $value->name . "'") }} ?');">Possess</a>
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






    <!--div id="editNewUser" class="col-md-12 col-sm-12 col-xs-12 popup-dialog" style="display: none;">
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
    </div-->




        <div class="modal  fade clearfix" id="editNewUser" tabindex="-1" role="dialog" aria-labelledby="editNewUserLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="editNewUserLabel">Edit</h4>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(array('url' => '/restaurant/users/update', 'name'=>'editForm', 'id'=>'addNewForm', 'class'=>'form-horizontal form-restaurants','method'=>'post','role'=>'form')) !!}
                        <div id="editContents"></div>
                        {!! Form::close() !!}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>



    <!--div id="addNewUser" class="col-md-12 col-sm-12 col-xs-12 popup-dialog" style="display: none;">
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
    </div-->







        <div class="modal  fade clearfix" id="addNewUser" tabindex="-1" role="dialog" aria-labelledby="addNewUserLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="addNewUserLabel">Add</h4>
                    </div>
                    <div class="modal-body">


                        {!! Form::open(array('url' => '/restaurant/users', 'id'=>'addNewForm', 'class'=>'form-horizontal form-restaurants','method'=>'post','role'=>'form')) !!}
                        @include('common.edituser')
                        {!! Form::close() !!}


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

















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