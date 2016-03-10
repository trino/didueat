<?php
    printfile("views/dashboard/user/ajax/list.blade.php");
    $restaurants = enum_all("restaurants");
?>

@if(\Session::has('message'))
    {!! message_show("Message!", \Session::get('message')) !!}
@endif

<div class="card">

    <div class="card-header ">
        <div class="row">
            <div class="col-lg-9">
                <h4 class="card-title">
                    Users
                    <!--a class="btn btn-primary btn-sm" id="addNew" data-toggle="modal" data-id="0" data-target="#editModel">Add</a-->
                </h4>
            </div>
            @include('common.table_controls')
        </div>
    </div>

    <div class="card-block p-a-0">
        <table class="table table-responsive  m-b-0 ">
            @if($recCount > 0)

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
                        <a class="sortOrder" data-meta="name" data-order="ASC" data-title="Name" title="Sort [Name] ASC"><i class="fa fa-caret-down"></i></a>
                        Restaurant
                        <a class="sortOrder" data-meta="name" data-order="DESC" data-title="Name" title="Sort [Name] DESC"><i class="fa fa-caret-up"></i></a>
                    </th>
                    <!--th >
                        <a class="sortOrder" data-meta="email" data-order="ASC" data-title="Email" title="Sort [Email] ASC"><i class="fa fa-caret-down"></i></a>
                        Email
                        <a class="sortOrder" data-meta="email" data-order="DESC" data-title="Email" title="Sort [Email] DESC"><i class="fa fa-caret-up"></i></a>
                    </th-->
                    <!--th>
                        <a class="sortOrder" data-meta="profile_type" data-order="ASC" data-title="Type" title="Sort [Type] ASC"><i class="fa fa-caret-down"></i></a>
                        Type
                        <a class="sortOrder" data-meta="profile_type" data-order="DESC" data-title="Type" title="Sort [Type] DESC"><i class="fa fa-caret-up"></i></a>
                    </th-->
                    <th>
                        Phone Number
                    </th>
                    <th></th>
                </tr>
            </thead>
            @endif
            <tbody>
                @if($recCount > 0)
                    @foreach($Query as $key => $value)
                        <?php
                            $Addresses = select_field_where("profiles_addresses", array("user_id" => $value->id, 'CHAR_LENGTH(phone) > 0'), false);
                            foreach($Addresses as $Address){
                                $value->phone = phonenumber($Address->phone);
                                if($value->phone){
                                    break;
                                }
                            }
                            $restaurant="";
                            if($value->restaurant_id>0){
                                $restaurant = getIterator($restaurants, "id", $value->restaurant_id);
                                $restaurant = $restaurant->name;
                            }
                        ?>
                        <tr>
                            <td>{{ $value->id }}</td>
                            <td>{{ $value->name }}</td>
                            <!--td>{{ $value->email }}</td-->
                            <td>{{ $restaurant }}</td>
                            <!--td> select_field('profiletypes', 'id', $value->profile_type, 'name') </td-->
                            <td>{{ phonenumber($value->phone, true) }}</td>
                            <td>
                                <!--a class="btn btn-info btn-sm editRow" data-toggle="modal" data-id="{{ $value->id }}" data-target="#editModel">
                                    Edit
                                </a-->
                                @if($value->id != \Session::get('session_id'))
                                    <a href="{{ url('users/action/user_possess/'.$value->id) }}" class="btn btn-secondary-outline btn-sm"
                                       onclick="return confirm('Are you sure you want to possess {{ addslashes("'" . $value->name . "'") }} ?');">Possess</a>

                                    <a href="{{ url('users/action/user_fire/'.$value->id) }}" class="btn btn-secondary-outline btn-sm"
                                       onclick="return confirm('Are you sure you want to fire  {{ addslashes("'" . $value->name . "'") }} ?');">X</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td><span class="text-muted">No Records</span></td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    @if(Session::get('session_type_user') == "super"  && $recCount > 10)
        <div class="card-footer clearfix">
            {!! $Pagination !!}
        </div>
    @endif
</div>