<?php
    printfile("views/dashboard/user/ajax/list.blade.php");
?>

@if(\Session::has('message'))
    {!! message_show("Message!", \Session::get('message')) !!}
@endif

<div class="card">

    <div class="card-header ">
        <div class="row">
            <div class="col-lg-9">
                <h3>
                    Users
                    <a class="btn btn-primary btn-sm" id="addNew" data-toggle="modal" data-id="0" data-target="#editModel">Add</a>
                </h3>
            </div>
            @include('common.table_controls')
        </div>
    </div>

    <div class="card-block p-a-0">
        <table class="table table-responsive table ">
            <thead class="">
                <tr>
                    <th>
                        <a class="sortOrder" data-meta="id" data-order="ASC" data-title="ID" title="Sort [ID] ASC"><i class="fa fa-caret-down"></i></a>
                        ID
                        <a class="sortOrder" data-meta="id" data-order="DESC" data-title="ID" title="Sort [ID] DESC"><i class="fa fa-caret-up"></i></a>
                    </th>
                    <th >
                        <a class="sortOrder" data-meta="name" data-order="ASC" data-title="Name" title="Sort [Name] ASC"><i class="fa fa-caret-down"></i></a>
                        Name
                        <a class="sortOrder" data-meta="name" data-order="DESC" data-title="Name" title="Sort [Name] DESC"><i class="fa fa-caret-up"></i></a>
                    </th>
                    <th >
                        <a class="sortOrder" data-meta="email" data-order="ASC" data-title="Email" title="Sort [Email] ASC"><i class="fa fa-caret-down"></i></a>
                        Email
                        <a class="sortOrder" data-meta="email" data-order="DESC" data-title="Email" title="Sort [Email] DESC"><i class="fa fa-caret-up"></i></a>
                    </th>
                    <!--th>
                        <a class="sortOrder" data-meta="profile_type" data-order="ASC" data-title="Type" title="Sort [Type] ASC"><i class="fa fa-caret-down"></i></a>
                        Type
                        <a class="sortOrder" data-meta="profile_type" data-order="DESC" data-title="Type" title="Sort [Type] DESC"><i class="fa fa-caret-up"></i></a>
                    </th-->
                    <th>
                        Cell Phone
                    </th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if($recCount > 0)
                @foreach($Query as $key => $value)
                <tr>
                    <td>{{ fontawesome($value->profile_type) . " " . $value->id }}</td>
                    <td>{{ $value->name }}</td>
                    <td>{{ $value->email }}</td>
                    <!--td> select_field('profiletypes', 'id', $value->profile_type, 'name') </td-->
                    <td>{{ $value->phone }}</td>
                    <td>
                        <!--a class="btn btn-info btn-sm editRow" data-toggle="modal" data-id="{{ $value->id }}" data-target="#editModel">
                            Edit
                        </a-->
                        @if($value->id != \Session::get('session_id'))

                            <a href="{{ url('users/action/user_possess/'.$value->id) }}" class="btn btn-warning btn-sm"
                               onclick="return confirm('Are you sure you want to possess {{ addslashes("'" . $value->name . "'") }} ?');">Possess</a>

                            <a href="{{ url('users/action/user_fire/'.$value->id) }}" class="btn btn-danger btn-sm"
                               onclick="return confirm('Are you sure you want to fire  {{ addslashes("'" . $value->name . "'") }} ?');">X</a>


                        @endif
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <th scope="row" colspan="7" class="text-center">No records found</th>
                </tr>
                @endif
            </tbody>
        </table>
    </div>


    <div class="card-footer clearfix">
        {!! $Pagination !!}
    </div>
</div>