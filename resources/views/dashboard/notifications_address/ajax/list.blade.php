{{ printfile("views/dashboard/notifications_address/ajax/list.blade.php") }}

@if(\Session::has('message'))
{!! message_show("Message!", \Session::get('message')) !!}
@endif

<div class="card">

    <div class="card-header ">
        <div class="row">
            <div class="col-lg-6">
                <h6>
                    My Notifications Addresses
                    <a class="btn btn-primary btn-sm" id="addNew" data-toggle="modal" data-target="#editModel">Add</a>
                </h6>
            </div>

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
                    <th>
                        #
                    </th>
                    <th>
                        <a class="sortOrder" data-meta="address" data-order="ASC" data-title="Phone/Email"
                           title="Sort [Phone/Email] ASC"><i class="fa fa-caret-down"></i></a>
                        Phone/Email
                        <a class="sortOrder" data-meta="address" data-order="DESC" data-title="Phone/Email"
                           title="Sort [Phone/Email] DESC"><i class="fa fa-caret-up"></i></a>
                    </th>
                    <th>
                        <a class="sortOrder" data-meta="note" data-order="ASC" data-title="Note" title="Sort [Note] ASC"><i
                                class="fa fa-caret-down"></i></a>
                        Note
                        <a class="sortOrder" data-meta="note" data-order="DESC" data-title="Note"
                           title="Sort [Note] DESC"><i class="fa fa-caret-up"></i></a>
                    </th>
                    <th>
                        <a class="sortOrder" data-meta="type" data-order="ASC" data-title="Type" title="Sort [Type] ASC"><i
                                class="fa fa-caret-down"></i></a>
                        Type
                        <a class="sortOrder" data-meta="type" data-order="DESC" data-title="Type"
                           title="Sort [Type] DESC"><i class="fa fa-caret-up"></i></a>
                    </th>
                    <th>
                        <a class="sortOrder" data-meta="enabled" data-order="ASC" data-title="Enabled"
                           title="Sort [Enabled] ASC"><i class="fa fa-caret-down"></i></a>
                        Enabled
                        <a class="sortOrder" data-meta="enabled" data-order="DESC" data-title="Enabled"
                           title="Sort [Enabled] DESC"><i class="fa fa-caret-up"></i></a>
                    </th>
                    <th>Action</th>
                    <th>Order</th>
                </tr>
            </thead>
            <tbody>
                @if($recCount > 0)
                @foreach($Query as $key => $value)
                <tr class="rows" data-id="{{ $value->id }}" data-order="{{ $key }}">
                    <td>{{ $key+1 }}</td>
                    <td>{{ $value->address }}</td>
                    <td id="note_{{ $value->id }}" value="{{ $value->note }}" onclick="editnote({{ $value->id }});">{{ $value->note }}</td>
                    <td>{{ $value->type }}</td>
                    <td><INPUT TYPE="CHECKBOX" ID="add_enable_{{ $value->id }}" CLASS="fullcheck" <?php if ($value->enabled) {
    echo "CHECKED";
} ?> ONCLICK="add_enable({{ $value->id }});"></td>
                    <td>
                        <a class="btn btn-info btn-sm editRow" data-toggle="modal" data-target="#editModel" data-id="{{ $value->id }}">Edit</a>
                        <a href="{{ url('notification/addresses/delete/'.$value->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete {{ addslashes($value->address) }} ?');">Delete</a>
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
        {!! $Pagination; !!}    
    </div>
</div>