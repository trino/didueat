@extends('layouts.default')
@section('content')

<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            @include('layouts.includes.leftsidebar')

            <div class="col-xs-12 col-md-10 col-sm-8">

                @if(\Session::has('message'))
                <div class="alert {!! Session::get('message-type') !!}">
                    <strong>{!! Session::get('message-short') !!}</strong>
                    &nbsp; {!! Session::get('message') !!}
                </div>
                @endif

                <div class="deleteme">
                    <div class="btn_wrapper margin-bottom-20 clearfix">
                        <a type="button" href="{{ url('restaurant/report') }}" class="btn red pull-right">Print Report</a>
                    </div>

                    <div class="box-shadow">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-globe"></i> MY ORDERS ({{ strtoupper($type) }})
                            </div>
                            <div class="tools">
                                
                            </div>
                        </div>
                        <div class="portlet-body">

                            <table class="table table-striped table-bordered table-hover" id="sample_111">
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
                                            <a href="{{ url('restaurant/orders/list/delete/'.$value->id) }}" class="btn red" onclick="return confirm('Are you sure you want to delete order # <?= $value->id; ?>?');">Delete</a>
                                            @endif
                                            @if(Session::get('session_profiletype') >= 1)
                                            <a href="{{ url('restaurant/orders/order_detail/'.$value->id) }}" class="btn green">View</a>
                                            @if($value->restaurant_id > 0)
                                                @if(strtolower($value->status) == 'approved' || strtolower($value->status) == 'pending')
                                                    <a href="#cancel-popup-dialog" class="btn yellow fancybox-fast-view cancel-popup" data-id="{{ $value->id }}">Cancel</a>
                                                @endif
                                                @if(strtolower($value->status) == 'cancelled' || strtolower($value->status) == 'pending')
                                                    @if(\Session::get('session_type_user') != 'user')
                                                    <a href="#approve-popup-dialog" class="btn blue fancybox-fast-view approve-popup" data-id="{{ $value->id }}">Approve</a>
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
                    <!-- END EXAMPLE TABLE PORTLET-->

                </div>
            </div>

        </div>
    </div>
</div>

@include('common.tabletools')

@include('popups.approve_cancel')

@stop