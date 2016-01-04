@extends('layouts.default')
@section('content')

    <div class="row">
        @include('layouts.includes.leftsidebar')

        <?php printfile("views/dashboard/restaurant/orders_pending.blade.php"); ?>

        <div class="col-lg-9">
            <div class="card">
                <div class="card-header">
                    My Orders ({{ ($type) }}) <a class="btn btn-primary btn-sm" href="{{ url('restaurant/report') }}"
                                                 class="">Print Report</a>
                </div>
                <div class="card-block p-a-0">


                    <table class="table table-responsive">
                        <thead>
                        <tr>
                            <th width="15%">Order ID</th>
                            <th width="20%">Ordered By</th>
                            <th width="15%">Date/Time</th>
                            <th width="20%">Status</th>
                            <th width="30%">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders_list as $value)
                            <tr>
                                <td>{{ $value->id }}</td>
                                <td>{{ $value->ordered_by }}</td>
                                <td>{{ date('d M, Y H:i A', strtotime($value->order_time)) }}</td>
                                <td>{{ $value->status }}</td>
                                <td>
                                    @if(Session::get('session_profiletype') >= 1)
                                        <a href="{{ url('restaurant/orders/order_detail/'.$value->id) }}"
                                           class="btn btn-primary  btn-sm">View</a>

                                        @if($value->restaurant_id > 0)
                                            @if(strtolower($value->status) == 'approved' || strtolower($value->status) == 'pending')
                                                <a data-id="{{ $value->id }}"
                                                   class="btn btn-warning btn-sm orderCancelModal"
                                                   data-toggle="modal" data-target="#orderCancelModal">
                                                    Cancel
                                                </a>
                                            @endif
                                            @if(strtolower($value->status) == 'cancelled' || strtolower($value->status) == 'pending')
                                                @if(\Session::get('session_type_user') != 'user')

                                                    <a data-id="{{ $value->id }}"
                                                       class="btn btn-success btn-sm orderApproveModal"
                                                       data-toggle="modal"
                                                       data-target="#orderApproveModal">
                                                        Approve
                                                    </a>

                                                @endif
                                            @endif
                                        @endif
                                    @endif

                                    @if(Session::get('session_profiletype') == 1)

                                        <a href="{{ url('restaurant/orders/list/delete/'.$value->id) }}"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete order # <?= $value->id; ?>?');">
                                            Delete
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('common.tabletools')
    @include('popups.approve_cancel')

@stop