{{ printfile("views/dashboard/user/ajax/list.blade.php") }}

@if(\Session::has('message'))
    {!! message_show("Message!", \Session::get('message')) !!}
@endif

<div class="card">



    <div class="card-header ">
        <div class="row">
            <div class="col-lg-6"><h6>

                    Users     <a class="btn btn-primary btn-sm editUser" data-toggle="modal" data-id="0" data-target="#editNewUser">Add</a>
                </h6></div>

            @include('common.table_controls')

        </div>
    </div>



    <!--table width="100%" border="0" cellpadding="0" cellspacing="0" style=" border: #BCBCBC solid 1px; padding:5px; margin: 0 auto;background-color: darkgray;">
        <tr>
            <td align="left"><label>Show<select size="1" name="showDataEntries" id="showDataEntries"  class="form-con"><option value="10" {!! ($per_page == 10)?"selected":''; !!}>10</option><option value="25" {!! ($per_page == 25)?"selected":''; !!}>25</option><option value="50" {!! ($per_page == 50)?"selected":''; !!}>50</option><option value="100" {!! ($per_page == 100)?"selected":''; !!}>100</option><option value="300" {!! ($per_page == 300)?"selected":''; !!}>300</option><option value="500" {!! ($per_page == 500)?"selected":''; !!}>500</option><option value="1000" {!! ($per_page == 1000)?"selected":''; !!}>1000</option></select> entries</label></td>
            <td align="right">
                <div>
                    <label>
                        <b class="search-input">  Search: </b><input type="text" class="form-control" id='searchResult' value='{!! $searchResults !!}' placeholder='Enter Keyword...' autofocus='true' style="width:220px !important;" />
                    </label>
                </div>
            </td>
        </tr>
    </table-->


    
    <div class="card-block p-a-0">
        <table class="table table-responsive">
            <thead>
                <tr>
                    <th width="10%">
                        <a class="sortOrder" data-meta="id" data-order="ASC" data-title="ID" title="Sort [ID] ASC"><i class="fa fa-caret-down"></i></a>
                        ID
                        <a class="sortOrder" data-meta="id" data-order="DESC" data-title="ID" title="Sort [ID] DESC"><i class="fa fa-caret-up"></i></a>
                    </th>
                    <th width="20%">
                        <a class="sortOrder" data-meta="name" data-order="ASC" data-title="Name" title="Sort [Name] ASC"><i class="fa fa-caret-down"></i></a>
                        Name
                        <a class="sortOrder" data-meta="name" data-order="DESC" data-title="Name" title="Sort [Name] DESC"><i class="fa fa-caret-up"></i></a>
                    </th>
                    <th width="30%">
                        <a class="sortOrder" data-meta="email" data-order="ASC" data-title="Email" title="Sort [Email] ASC"><i class="fa fa-caret-down"></i></a>
                        Email
                        <a class="sortOrder" data-meta="email" data-order="DESC" data-title="Email" title="Sort [Email] DESC"><i class="fa fa-caret-up"></i></a>
                    </th>
                    <th width="15%">
                        <a class="sortOrder" data-meta="profile_type" data-order="ASC" data-title="Type" title="Sort [Type] ASC"><i class="fa fa-caret-down"></i></a>
                        Type
                        <a class="sortOrder" data-meta="profile_type" data-order="DESC" data-title="Type" title="Sort [Type] DESC"><i class="fa fa-caret-up"></i></a>
                    </th>
                    <th width="15%">
                        Phone
                    </th>
                    <th width="10%">Action</th>
                </tr>
            </thead>
            <tbody>
                @if($recCount > 0)
                @foreach($Query as $key => $value)
                <tr>
                    <td>{{ $value->id }}</td>
                    <td>{{ $value->name }}</td>
                    <td>{{ $value->email }}</td>
                    <td>{{ select_field('profiletypes', 'id', $value->profile_type, 'name') }}</td>
                    <td>{{ $value->phone }}</td>
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
                @else
                <tr>
                    <th scope="row" colspan="7" class="text-center">No record founds!</th>
                </tr>
                @endif
            </tbody>
        </table>


    </div>


    <div class="card-footer clearfix">
        {!! $Pagination; !!}    </div>
</div>