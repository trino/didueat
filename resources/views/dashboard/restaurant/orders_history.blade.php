


@extends('layouts.default')
@section('content')

    delete me 324234324324


    <div class="content-page">
    <div class="container-fluid">
    <div class="row">
                @include('layouts.includes.leftsidebar')

                <div class="col-xs-12 col-md-9 col-sm-8">
                    <div class="deleteme">
                        <h3 class="sidebar__title">Orders History</h3>
                        <hr class="shop__divider">

                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="box-shadow">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-globe"></i>Orders List
                                </div>
                                <div class="tools">
                                </div>
                            </div>
                            <div class="portlet-body">
                                <table class="table table-striped table-bordered table-hover" id="sample_1">
                                    <thead>
                                        <tr>
                                            <th width="10%">Order #</th>
                                            <th width="30%">Ordered By</th>
                                            <th width="30%">Date/Time</th>
                                            <th width="10%">Status</th>
                                            <th width="20%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orders_list as $value)
                                        <tr>
                                            <td>{{ $value->id }}</td>
                                            <td>{{ $value->ordered_by }}</td>
                                            <td>{{ $value->order_time }}</td>
                                            <td>{{ $value->status }}</td>
                                            <td>
                                                <a href="#" class="btn btn-success">View</a>
                                                <a href="#" class="btn btn-danger" onclick="return confirm(' Are you sure you want to delete order');">Delete</a>
                                                <?php if(strtolower($value->status)=='pending'){?>
                                                    <a href="{{ url('restaurant/orders/pending/cancel/'.$value->id) }}" class="btn yellow" onclick="return confirm(' Are you sure you want to cancel this order');">Cancel</a>
                                                    <a href="{{ url('restaurant/orders/pending/approve/'.$value->id) }}" class="btn blue" onclick="return confirm(' Are you sure you want to approve this order ? ');">Approve</a>
                                                <?php }?>
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



@stop