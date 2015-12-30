@extends('layouts.default')
@section('content')

    <div class="row">
        @include('layouts.includes.leftsidebar')

        <div class="col-lg-9">
            <?php printfile("views/dashboard/restaurant/orders_pending.blade.php"); ?>

            @if(\Session::has('message'))
                <div class="alert {!! Session::get('message-type') !!}">
                    <strong>{!! Session::get('message-short') !!}</strong>
                    &nbsp; {!! Session::get('message') !!}
                </div>
            @endif


            <div class="deleteme">
                <div class="btn_wrapper margin-bottom-20 clearfix">
                </div>

                <a type="button" href="{{ url('restaurant/report') }}" class="btn red">Print Report</a>

                <h3> MY ORDERS ({{ strtoupper($type) }})</h3>

                <table class="table table-striped" id="sample_111">
                    <thead>
                    <tr>
                        <th width="5%">Order #</th>
                        <th width="20%">Ordered By</th>
                        <th width="20%">Date/Time</th>
                        <th width="10%">Status</th>
                        <th width="20%">Actions</th>
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

                                @if(Session::get('session_profiletype') == 1)
                                    <a href="{{ url('restaurant/orders/list/delete/'.$value->id) }}"
                                       class="btn btn-danger"
                                       onclick="return confirm('Are you sure you want to delete order # <?= $value->id; ?>?');">Delete</a>
                                @endif
                                @if(Session::get('session_profiletype') >= 1)
                                    <a href="{{ url('restaurant/orders/order_detail/'.$value->id) }}"
                                       class="btn btn-primary">View</a>
                                    @if($value->restaurant_id > 0)
                                    @if(strtolower($value->status) == 'approved' || strtolower($value->status) == 'pending')


                                            <!--a href="#cancel-popup-dialog"
                                               class="btn red yellow fancybox-fast-view cancel-popup"
                                               data-id="{{ $value->id }}">Cancel</a-->


                                    <a data-id="{{ $value->id }}" type="button" class="btn btn-danger orderCancelModal"
                                       data-toggle="modal" data-target="#orderCancelModal">
                                        Cancel
                                    </a>

                                    @endif
                                    @if(strtolower($value->status) == 'cancelled' || strtolower($value->status) == 'pending')
                                    @if(\Session::get('session_type_user') != 'user')


                                            <!--a href="#approve-popup-dialog"
                                                   class="btn red blue fancybox-fast-view approve-popup"
                                                   data-id="{{ $value->id }}">Approve</a-->


                                    <a data-id="{{ $value->id }}" type="button"
                                       class="btn btn-success orderApproveModal" data-toggle="modal"
                                       data-target="#orderApproveModal">
                                        Approve
                                    </a>



                                @endif
                                @endif
                                @endif

                                {{--@else--}}
                                {{--<a href="#disapprove-popup" class="btn red fancybox-fast-view disapprove-popup" data-id="{{ $value->id }}">Disapprove</a>--}}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    @include('common.tabletools')
    @include('popups.approve_cancel')

@stop