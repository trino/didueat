@extends('layouts.default')
@section('content')



    <div class="content-page">
        <div class="row">
            @include('layouts.includes.leftsidebar')

            <div class="col-xs-12 col-md-10 col-sm-8">


                @if(\Session::has('message'))
                    <div class="alert {!! Session::get('message-type') !!}">
                        <strong>{!! Session::get('message-short') !!}</strong> &nbsp; {!! Session::get('message') !!}
                    </div>
                @endif

                <div class="deleteme">



                    <div class="btn_wrapper margin-bottom-20 clearfix">

                        <a type="button" href="{{ url('restaurant/report') }}" class="btn red pull-right">Print Report</a>

                    </div>



                    <div class="box-shadow">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-globe"></i>MY ORDERS ({{ strtoupper($type) }})
                            </div>
                            <div class="tools">

                            </div>
                        </div>
                        <div class="portlet-body">


                            <table class="table table-striped table-bordered table-hover" id="sample_1">
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

                                <?php
                                /*if (isset($orders_list) && $orders_list) {
                                    foreach($orders_list as $Order){
                                        $status= $Manager->order_status($Order);
                                        //$Profile = $Manager->get_profile($Order->UserID);
                                        echo '<tr><td>' . ucfirst($Order->ordered_by) . '</td><td>' . $Order->order_time . '</td>';
                                        echo '<td><a href="'. $this->request->webroot.'restaurants/order_detail/'. $Order->id . '" class="btn btn-success">View</a>';
                                        echo '<a href="'. $this->request->webroot.'restaurants/delete_order/'. $Order->id . '/'.$type.'" class="btn btn-danger" ';
                                        echo 'onclick="return confirm(\' Are you sure you want to delete order\');">Delete</a>';
                                        if($type!='pending') {
                                            echo '</td><td>' . $status . '</TD></TR>';
                                        }else {
                                            echo '<a href="' . $this->request->webroot . 'restaurants/approve_order/' . $Order->id . '" class="btn btn-info">Approve</a> <a href="' . $this->request->webroot . 'restaurants/cancel_order/' . $Order->id . '" class="btn btn-warning">Cancel</a></td><td>' . $status . '</TD></TR>';
                                        }
                                    }
                                } else {
                                    echo '<TR><TD colspan="4"><DIV align="center">No orders found</DIV></TD></TR>';
                                }*/
                                ?>

                                @foreach($orders_list as $value)
                                    <tr>
                                        <td>{{ $value->id }}</td>
                                        <td>{{ $value->ordered_by }}</td>
                                        <td>{{ date('d M, Y H:i A', strtotime($value->order_time)) }}</td>
                                        <td>{{ $value->status }}</td>
                                        <td>
                                            <a href="{{ url('restaurant/orders/order_detail/'.$value->id) }}"
                                               class="btn green">View</a>
                                            <a href="{{ url('restaurant/orders/pending/delete/'.$value->id) }}"
                                               class="btn red"
                                               onclick="return confirm(' Are you sure you want to delete this order ? ');">Delete</a>
                                            <?php if(strtolower($value->status) == 'pending'){?>
                                            <a href="{{ url('restaurant/orders/pending/cancel/'.$value->id) }}"
                                               class="btn yellow"
                                               onclick="return confirm(' Are you sure you want to cancel this order');">Cancel</a>
                                            <a href="{{ url('restaurant/orders/pending/approve/'.$value->id) }}"
                                               class="btn blue"
                                               onclick="return confirm(' Are you sure you want to approve this order ? ');">Approve</a>
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



    @include('common.tabletools')


@stop