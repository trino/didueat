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

            <div class="card">
                <div class="card-header">
                    Users

                    <a class="btn btn-primary btn-sm editUser" data-toggle="modal" data-id="0" data-target="#editNewUser">
                        Add
                    </a>


                    <!--a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editNewUser">
                        Add
                    </a-->

                </div>
                <div class="card-block p-a-0">

                <table class="table table-responsive">
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

                                <a class="btn btn-info btn-sm editUser" data-toggle="modal" data-id="{{ $value->id }}" data-target="#editNewUser">
                                    Edit
                                </a>
                                @if($value->id != \Session::get('session_id'))

                                    <a href="{{ url('restaurant/users/action/user_fire/'.$value->id) }}"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Are you sure you want to fire  {{ addslashes("'" . $value->name . "'") }} ?');">Fire</a>

                                    <a href="{{ url('restaurant/users/action/user_possess/'.$value->id) }}"
                                       class="btn btn-info btn-sm"
                                       onclick="return confirm('Are you sure you want to possess {{ addslashes("'" . $value->name . "'") }} ?');">Possess</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
            </div>

        </div>
    </div>




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
                    <div id="editContents">
                        <!-- include("common.edituser") -->
                    </div>
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
        $('body').on('click', '.editUser', function () {
            var id = $(this).attr('data-id');
            $.get("{{ url("restaurant/users/edit") }}/" + id, {}, function (result) {
                $('#editContents').html(result);
                initAutocomplete();
            });
        });
    </script>
@stop

<script src="{{ url("assets/global/scripts/provinces.js") }}" type="text/javascript"></script>
<?php
    /*if(!includeJS("https://maps.googleapis.com/maps/api/js?signed_in=true&libraries=places&callback=initAutocomplete&source=users", "async defer")){
        echo '<script>initAutocomplete();</script>';
    }*/
?>