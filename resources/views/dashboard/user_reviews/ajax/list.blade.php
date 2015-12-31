@if(\Session::has('message'))
    {!! message_show("Message!", \Session::get('message')) !!}
@endif

<div class="card">
    <div class="card-header ">Reviews</div>
    
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
                    <th width="15%">
                        <a class="sortOrder" data-meta="user_id" data-order="ASC" data-title="User" title="Sort [User] ASC"><i class="fa fa-caret-down"></i></a>
                        User
                        <a class="sortOrder" data-meta="user_id" data-order="DESC" data-title="User" title="Sort [User] DESC"><i class="fa fa-caret-up"></i></a>
                    </th>
                    <th width="15%">
                        <a class="sortOrder" data-meta="target_id" data-order="ASC" data-title="Target" title="Sort [Target] ASC"><i class="fa fa-caret-down"></i></a>
                        Target
                        <a class="sortOrder" data-meta="target_id" data-order="DESC" data-title="Target" title="Sort [Target] DESC"><i class="fa fa-caret-up"></i></a>
                    </th>
                    <th width="10%">
                        <a class="sortOrder" data-meta="type" data-order="ASC" data-title="Type" title="Sort [Type] ASC"><i class="fa fa-caret-down"></i></a>
                        Type
                        <a class="sortOrder" data-meta="type" data-order="DESC" data-title="Type" title="Sort [Type] DESC"><i class="fa fa-caret-up"></i></a>
                    </th>
                    <th width="10%">
                        <a class="sortOrder" data-meta="rating" data-order="ASC" data-title="Rating" title="Sort [Rating] ASC"><i class="fa fa-caret-down"></i></a>
                        Rating
                        <a class="sortOrder" data-meta="rating" data-order="DESC" data-title="Rating" title="Sort [Rating] DESC"><i class="fa fa-caret-up"></i></a>
                    </th>
                    <th width="20%">
                        <a class="sortOrder" data-meta="comments" data-order="ASC" data-title="Comments" title="Sort [Comments] ASC"><i class="fa fa-caret-down"></i></a>
                        Comment
                        <a class="sortOrder" data-meta="comments" data-order="DESC" data-title="Comments" title="Sort [Comments] DESC"><i class="fa fa-caret-up"></i></a>
                    </th>
                    <th width="10%">
                        <a class="sortOrder" data-meta="created_at" data-order="ASC" data-title="Date" title="Sort [Date] ASC"><i class="fa fa-caret-down"></i></a>
                        Date
                        <a class="sortOrder" data-meta="created_at" data-order="DESC" data-title="Date" title="Sort [Date] DESC"><i class="fa fa-caret-up"></i></a>
                    </th>
                    <th width="10%">Action</th>
                </tr>
            </thead>
            <tbody>
                @if($recCount > 0)
                @foreach($Query as $key => $rating)
                <tr>
                    <td>{{ $rating->id  }}</td>
                    <td>{{ select_field("profiles", "id", $rating->user_id, "name")  }}</td>
                    <td>{{ ($rating->type == "menu")?select_field("menus", "id", $rating->target_id, "menu_item"):select_field("restaurants", "id", $rating->target_id, "name")  }}</td>
                    <td>{{ $rating->type  }}</td>
                    <td>{{ $rating->rating  }}</td>
                    <td>{{ substr($rating->comments, 0, 100) }}</td>
                    <td>{{ $rating->created_at  }}</td>
                    <td>
                        <a class="btn btn-info btn-sm editUser" data-toggle="modal" data-target="#editReviewModal"  data-id="{{ $rating->id }}">Edit</a>
                        <a href="{{ url('user/reviews/action/'.$rating->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete review  {{ addslashes("'" . $rating->rating . "'") }} ?');">Delete</a>
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