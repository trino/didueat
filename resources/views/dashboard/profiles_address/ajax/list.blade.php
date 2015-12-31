@if(\Session::has('message'))
    {!! message_show("Message!", \Session::get('message')) !!}
@endif

<div class="card">
    <div class="card-header ">
        My Addresses
        <a class="btn btn-primary btn-sm" id="addNew" data-toggle="modal" data-target="#editModel">Add</a>
    </div>
    
    <table width="100%" border="0" cellpadding="0" cellspacing="0" style=" border: #BCBCBC solid 1px; padding:5px; margin: 0 auto;background-color: darkgray;">
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
    </table>
    
    <input type='hidden' name='hiddenShowDataEntries' id='hiddenShowDataEntries' value='{!! ($per_page)?$per_page:5; !!}' />
    <input type='hidden' name='hiddenSearchResult' id='hiddenSearchResult' value='{!! ($searchResults)?$searchResults:""; !!}' />
    <input type='hidden' name='hiddenShowMeta' id='hiddenShowMeta' value='{!! ($meta)?$meta:"id"; !!}' />
    <input type='hidden' name='hiddenShowOrder' id='hiddenShowOrder' value='{!! ($order)?$order:"ASC"; !!}' />
    <input type='hidden' name='hiddenPage' id='hiddenPage' value='{!! ($page)?$page:1; !!}' />
    
    <div id="ajaxBlock"></div>
    
    <div class="card-block p-a-0">
        <table class="table table-responsive">
            <thead>
                <tr>
                    <th width="5%">
                        ID
                    </th>
                    <th width="15%">
                        <a class="sortOrder" data-meta="user_id" data-order="ASC" data-title="Name" title="Sort [Name] ASC"><i class="fa fa-caret-down"></i></a>
                        Name
                        <a class="sortOrder" data-meta="user_id" data-order="DESC" data-title="Name" title="Sort [Name] DESC"><i class="fa fa-caret-up"></i></a>
                    </th>
                    <th width="15%">
                        <a class="sortOrder" data-meta="location" data-order="ASC" data-title="Location" title="Sort [Location] ASC"><i class="fa fa-caret-down"></i></a>
                        Location
                        <a class="sortOrder" data-meta="location" data-order="DESC" data-title="Location" title="Sort [Location] DESC"><i class="fa fa-caret-up"></i></a>
                    </th>
                    <th width="10%">
                        <a class="sortOrder" data-meta="phone_no" data-order="ASC" data-title="Phone" title="Sort [Phone] ASC"><i class="fa fa-caret-down"></i></a>
                        Phone
                        <a class="sortOrder" data-meta="phone_no" data-order="DESC" data-title="Phone" title="Sort [Phone] DESC"><i class="fa fa-caret-up"></i></a>
                    </th>
                    <th width="20%">
                        <a class="sortOrder" data-meta="address" data-order="ASC" data-title="Address" title="Sort [Address] ASC"><i class="fa fa-caret-down"></i></a>
                        Address
                        <a class="sortOrder" data-meta="address" data-order="DESC" data-title="Address" title="Sort [Address] DESC"><i class="fa fa-caret-up"></i></a>
                    </th>
                    <th width="20%">Action</th>
                    <th width="10%">Order</th>
                </tr>
            </thead>
            <tbody>
                @if($recCount > 0)
                @foreach($Query as $key => $value)
                <tr class="rows" data-id="{{ $value->id }}" data-order="{{ $key }}">
                    <td>{{ $key+1 }}</td>
                    <td>{{ select_field('profiles', 'id', $value->user_id, 'name') }}</td>
                    <td>{{ $value->location }}</td>
                    <td>{{ $value->phone_no }}</td>
                    <td>{{ $value->address.', '. $value->city .', '. select_field('states', 'id', $value->province, 'name') .', '.$value->post_code.', '.select_field('countries', 'id', $value->country, 'name') }}</td>
                    <td>
                        <a data-id="{{ $value->id }}" class="btn btn-info editRow btn-sm" data-toggle="modal" data-target="#editModel">Edit</a>
                        <a href="{{ url('user/addresses/delete/'.$value->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete {{ addslashes($value->location) }}?');">Delete</a>
                    </td>
                    <td>
                        <a class="btn  btn-info up btn-sm"><i class="fa fa-arrow-up"></i></a>
                        <a class="btn  btn-info down btn-sm"><i class="fa fa-arrow-down"></i></a>
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
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="pagination-table">
            <tr>
                <td>{!! $Pagination; !!}</td>
            </tr>
        </table>
    </div>
</div>