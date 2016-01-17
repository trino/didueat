{{ printfile("views/dashboard/event_logs/ajax/list.blade.php") }}

@if(\Session::has('message'))
    {!! message_show("Message!", \Session::get('message')) !!}
@endif

<div class="card">

    <div class="card-header ">
        <div class="row">
            <div class="col-lg-9">
                <h3>Event Logs</h3>
            </div>
            @include('common.table_controls')
        </div>
    </div>

    <div class="card-block p-a-0">
        <table class="table table-responsive">
            <thead>
            <tr>
                <th>
                    <a class="sortOrder" data-meta="id" data-order="ASC" data-title="ID" title="Sort [ID] ASC"><i class="fa fa-caret-down"></i></a>
                    ID
                    <a class="sortOrder" data-meta="id" data-order="DESC" data-title="ID" title="Sort [ID] DESC"><i class="fa fa-caret-up"></i></a>
                </th>
                <th>
                    <a class="sortOrder" data-meta="user_id" data-order="ASC" data-title="User" title="Sort [User] ASC"><i class="fa fa-caret-down"></i></a>
                    User
                    <a class="sortOrder" data-meta="user_id" data-order="DESC" data-title="User" title="Sort [User] DESC"><i class="fa fa-caret-up"></i></a>
                </th>
                <th>
                    <a class="sortOrder" data-meta="created_at" data-order="ASC" data-title="Date" title="Sort [Date] ASC"><i class="fa fa-caret-down"></i></a>
                    Date
                    <a class="sortOrder" data-meta="created_at" data-order="DESC" data-title="Date" title="Sort [Date] DESC"><i class="fa fa-caret-up"></i></a>
                </th>
                <th>
                    Event
                </th>
            </tr>
            </thead>
            <tbody>
            @if($recCount > 0)
                @foreach($Query as $key => $value)
                    <tr>
                        <td>{{ $value->id }}</td>
                        <td>{{ select_field("profiles", 'id', $value->user_id, "name") }}</td>
                        <td>{{ $value->created_at }}</td>
                        <td>{!! "<b>".$value->type."</b> => ".$value->text !!}</td>
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