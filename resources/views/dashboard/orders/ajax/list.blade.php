{{ printfile("views/dashboard/orders/ajax/list.blade.php") }}

@if(\Session::has('message'))
    {!! message_show("Message!", \Session::get('message')) !!}
@endif

<div class="card">
    <div class="card-header">


        <div class="row">
            <div class="col-lg-6"><h6>My Orders ({{ ucwords($type) }}) <a class="btn btn-primary btn-sm "
                                                                          href="{{ url('restaurant/report') }}"
                                                                          class="">Print Report</a>
                </h6>
            </div>


            @include('common.table_controls')


        </div>


    </div>


    <div class="card-block p-a-0">
        <table class="table table-responsive">
            <thead>
            <tr>
                <th>
                    <a class="sortOrder" data-meta="id" data-order="ASC" data-title="ID" title="Sort ID ASC"><i
                                class="fa fa-caret-down"></i></a>
                    Order Id
                    <a class="sortOrder" data-meta="id" data-order="DESC" data-title="ID" title="Sort ID DESC"><i
                                class="fa fa-caret-up"></i></a>
                </th>
                <th>
                    <a class="sortOrder" data-meta="ordered_by" data-order="ASC" data-title="Ordered By"
                       title="Sort [Ordered By] ASC"><i class="fa fa-caret-down"></i></a>
                    By
                    <a class="sortOrder" data-meta="ordered_by" data-order="DESC" data-title="Ordered By"
                       title="Sort [Ordered By] DESC"><i class="fa fa-caret-up"></i></a>
                </th>
                <th>
                    <a class="sortOrder" data-meta="order_time" data-order="ASC" data-title="Date/Time"
                       title="Sort [Date/Time] ASC"><i class="fa fa-caret-down"></i></a>
                    On
                    <a class="sortOrder" data-meta="order_time" data-order="DESC" data-title="Date/Time"
                       title="Sort [Date/Time] DESC"><i class="fa fa-caret-up"></i></a>
                </th>
                <th>
                    <a class="sortOrder" data-meta="status" data-order="ASC" data-title="Status"
                       title="Sort [Status] ASC"><i class="fa fa-caret-down"></i></a>
                    Status
                    <a class="sortOrder" data-meta="status" data-order="DESC" data-title="Status"
                       title="Sort [Status] DESC"><i class="fa fa-caret-up"></i></a>
                </th>
                <th width="36%">
                    Actions
                </th>
            </tr>
            </thead>
            <tbody>
            @if($recCount > 0)
                @foreach($Query as $value)
                    <tr>
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->ordered_by }}</td>
                        <td>{{ date('d M, Y H:i A', strtotime($value->order_time)) }}</td>
                        <td>{{ $value->status }}</td>
                        <td>
                            @if(Session::get('session_profiletype') >= 1)
                                <a href="{{ url('orders/order_detail/'.$value->id) }}" class="btn btn-primary  btn-sm">View</a>
                            @endif

                            @if(Session::get('session_profiletype') == 1)
                                <a href="{{ url('orders/list/delete/'.$type.'/'.$value->id) }}"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Are you sure you want to delete order # {{ $value->id }}?');">
                                    Delete
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <th scope="row" colspan="5" class="text-center">No record founds!</th>
                </tr>
            @endif
            </tbody>
        </table>


    </div>


    <div class="card-footer clearfix">
        {!! $Pagination; !!}    </div>


</div>