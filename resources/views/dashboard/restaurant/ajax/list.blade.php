@if(\Session::has('message'))
    {!! message_show("Message!", \Session::get('message')) !!}
@endif

<div class="card">
    <div class="card-header ">Restaurants</div>
    <a class="btn btn-primary btn-sm" href="{{ url('restaurant/add/new') }}">Add</a>
    
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
                    <th width="10%">
                        <a class="sortOrder" data-meta="id" data-order="ASC" data-title="ID" title="Sort [ID] ASC"><i class="fa fa-caret-down"></i></a>
                        ID
                        <a class="sortOrder" data-meta="id" data-order="DESC" data-title="ID" title="Sort [ID] DESC"><i class="fa fa-caret-up"></i></a>
                    </th>
                    <th width="20%">
                        Logo
                    </th>
                    <th width="30%">
                        <a class="sortOrder" data-meta="name" data-order="ASC" data-title="Name" title="Sort [Name] ASC"><i class="fa fa-caret-down"></i></a>
                        Name
                        <a class="sortOrder" data-meta="name" data-order="DESC" data-title="Name" title="Sort [Name] DESC"><i class="fa fa-caret-up"></i></a>
                    </th>
                    <th width="15%">
                        <a class="sortOrder" data-meta="rating" data-order="ASC" data-title="Rating" title="Sort [Rating] ASC"><i class="fa fa-caret-down"></i></a>
                        Rating
                        <a class="sortOrder" data-meta="rating" data-order="DESC" data-title="Rating" title="Sort [Rating] DESC"><i class="fa fa-caret-up"></i></a>
                    </th>
                    <th width="15%">
                        <a class="sortOrder" data-meta="status" data-order="ASC" data-title="Status" title="Sort [Status] ASC"><i class="fa fa-caret-down"></i></a>
                        Status
                        <a class="sortOrder" data-meta="status" data-order="DESC" data-title="Status" title="Sort [Status] DESC"><i class="fa fa-caret-up"></i></a>
                    </th>
                    <th width="10%">Action</th>
                </tr>
            </thead>
            <tbody>
                @if($recCount > 0)
                @foreach($Query as $key => $value)
                <?php $resLogo = (isset($value->logo) && $value->logo != "") ? 'restaurants/' . $value->id . '/thumb_' . $value->logo : 'default.png'; ?>
                <tr>
                    <td>{{ $value->id }}</td>
                    <td><img src="{{ asset('assets/images/'.$resLogo) }}" width="90"/></td>
                    <td>{{ $value->name }}</td>
                    <td>{!! rating_initialize("static-rating", "restaurant", $value['id'], true) !!}</td>
                    <td>
                        @if($value->open == true)Open @else Closed @endif
                        @if($value->open == true)
                            <a href="{{ url('restaurant/list/status/'.$value->id) }}" class="btn btn-warning btn-sm"
                               onclick="return confirm('Are you sure you want to close {{ addslashes("'" . $value->name . "'") }} ?');">Close</a>
                        @else
                            <a href="{{ url('restaurant/list/status/'.$value->id) }}" class="btn  btn-success btn-sm"
                               onclick="return confirm('Are you sure you want to open {{ addslashes("'" . $value->name . "'") }} ?');">Open</a>
                        @endif
                    </td>
                    <td>
                        <a href="{{ url('restaurant/orders/history/'.$value->id) }}" class="btn btn-primary btn-sm">Orders</a>
                        <a href="{{ url('restaurant/info/'.$value->id) }}" class="btn btn-info btn-sm">Edit</a>
                        <a href="{{ url('restaurant/list/delete/'.$value->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete {{ addslashes("'" . $value->name . "'") }} ?');">Delete</a>
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