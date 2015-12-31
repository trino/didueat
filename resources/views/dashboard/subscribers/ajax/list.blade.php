@if(\Session::has('message'))
{!! message_show("Message!", \Session::get('message')) !!}
@endif

<div class="card">
    <div class="card-header ">Subscribers</div>

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
                    <th width="60%">
                        <a class="sortOrder" data-meta="email" data-order="ASC" data-title="Email" title="Sort [Email] ASC"><i class="fa fa-caret-down"></i></a>
                        Email
                        <a class="sortOrder" data-meta="email" data-order="DESC" data-title="Email" title="Sort [Email] DESC"><i class="fa fa-caret-up"></i></a>
                    </th>
                    <th width="15%">
                        <a class="sortOrder" data-meta="created_at" data-order="ASC" data-title="Date" title="Sort [Date] ASC"><i class="fa fa-caret-down"></i></a>
                        Date
                        <a class="sortOrder" data-meta="created_at" data-order="DESC" data-title="Date" title="Sort [Date] DESC"><i class="fa fa-caret-up"></i></a>
                    </th>
                    <th width="12%">
                        <a class="sortOrder" data-meta="status" data-order="ASC" data-title="Status" title="Sort [Status] ASC"><i class="fa fa-caret-down"></i></a>
                        Status
                        <a class="sortOrder" data-meta="status" data-order="DESC" data-title="Status" title="Sort [Status] DESC"><i class="fa fa-caret-up"></i></a>
                    </th>
                </tr>
            </thead>
            <tbody>
                @if($recCount > 0)
                @foreach($Query as $key => $value)
                <tr>
                    <td>{{ $value->id }}</td>
                    <td>{{ $value->email }}</td>
                    <td>{{ date('d M, Y', strtotime($value->created_at)) }}</td>
                    <td>{{ ($value->status == 1)?"Active":"Inactive" }}</td>
                </tr>
                @endforeach
                @else
                <tr>
                    <th scope="row" colspan="4" class="text-center">No record founds!</th>
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