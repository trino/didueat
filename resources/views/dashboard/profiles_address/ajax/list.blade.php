{{ printfile("views/dashboard/profiles_address/ajax/list.blade.php") }}

@if(\Session::has('message'))
    {!! message_show("Message!", \Session::get('message')) !!}
@endif

<div class="card">
    <div class="card-header ">
        <div class="row">
            <div class="col-lg-6"><h6>
                    My Addresses
                    <a class="btn btn-primary btn-sm" id="addNew" data-toggle="modal" data-target="#editModel">Add</a>
                </h6></div>
            @include('common.table_controls')
        </div>
    </div>




    <div class="card-block p-a-0">
        <table class="table table-responsive">
            <thead>
            <tr>
                <!--th width="5%">
                    ID
                </th-->
                <!--th width="15%">
                    <a class="sortOrder" data-meta="user_id" data-order="ASC" data-title="Name" title="Sort [Name] ASC"><i
                                class="fa fa-caret-down"></i></a>
                    Name
                    <a class="sortOrder" data-meta="user_id" data-order="DESC" data-title="Name"
                       title="Sort [Name] DESC"><i class="fa fa-caret-up"></i></a>
                </th-->
                <th  class="">
                    <a class="sortOrder" data-meta="location" data-order="ASC" data-title="Location"
                       title="Sort [Location] ASC"><i class="fa fa-caret-down"></i></a>
                    Location
                    <a class="sortOrder" data-meta="location" data-order="DESC" data-title="Location"
                       title="Sort [Location] DESC"><i class="fa fa-caret-up"></i></a>
                </th>
                <th   class="">
                    <a class="sortOrder" data-meta="phone" data-order="ASC" data-title="Phone"
                       title="Sort [Phone] ASC"><i class="fa fa-caret-down"></i></a>
                    Phone
                    <a class="sortOrder" data-meta="phone" data-order="DESC" data-title="Phone"
                       title="Sort [Phone] DESC"><i class="fa fa-caret-up"></i></a>
                </th>
                <th class="">
                    <a class="sortOrder" data-meta="address" data-order="ASC" data-title="Address"
                       title="Sort [Address] ASC"><i class="fa fa-caret-down"></i></a>
                    Address
                    <a class="sortOrder" data-meta="address" data-order="DESC" data-title="Address"
                       title="Sort [Address] DESC"><i class="fa fa-caret-up"></i></a>
                </th>
                <th   class="">Action</th>
                <th   class="">Order</th>
            </tr>
            </thead>
            <tbody>
            @if($recCount > 0)
                @foreach($Query as $key => $value)
                    <tr class="rows" data-id="{{ $value->id }}" data-order="{{ $key }}">
                        <!--td>{{ $key+1 }}</td-->
                        <!--td>{{ select_field('profiles', 'id', $value->user_id, 'name') }}</td-->
                        <td>{{ $value->location }}</td>
                        <td>{{ $value->phone }}</td>
                        <td>{{ $value->address.', '. $value->city .', '. select_field('states', 'id', $value->province, 'name') .', '.$value->postal_code.', '.select_field('countries', 'id', $value->country, 'name') }}</td>
                        <td>
                            <a data-id="{{ $value->id }}" class="btn btn-info editRow btn-sm" data-toggle="modal" data-target="#editModel">Edit</a>
                            <a href="{{ url('user/addresses/delete/'.$value->id) }}" class="btn btn-danger btn-sm"
                               onclick="return confirm('Are you sure you want to delete {{ addslashes($value->location) }}?');">Delete</a>
                        </td>
                        <td>
                            <div class="btn-group-vertical">
                                <a class="btn btn-secondary-outline up btn-sm"><i class="fa fa-arrow-up"></i></a>
                                <a class="btn btn-secondary-outline down btn-sm"><i class="fa fa-arrow-down"></i></a>
                            </div>
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
        {!! $Pagination !!}    </div>
</div>