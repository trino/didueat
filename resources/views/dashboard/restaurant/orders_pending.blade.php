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
                                                @if(strtolower($value->status) == 'pending')
                                                    <a href="#cancel-popup" class="btn yellow fancybox-fast-view cancel-popup" data-id="{{ $value->id }}">Cancel</a>
                                                    <a href="#approve-popup" class="btn blue fancybox-fast-view approve-popup" data-id="{{ $value->id }}">Approve</a>
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

    <div id="approve-popup" style="display:none;width:500px;">
        <div class="login-pop-up">
            <div class="login-form" style="">
                <h1>Approve Order</h1>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <DIV ID="message" align="center"></DIV>
                    {!! Form::open(array('url' => '/restaurant/orders/pending/approve', 'id'=>'approve-form','class'=>'form-horizontal form-without-legend','method'=>'post','role'=>'form')) !!}
                        <div class="form-group">
                            <label>Note: </label>
                            <textarea name="note" rows="6" class="form-control" required></textarea>
                            <input type="hidden" name="id" value="" />
                        </div>
                        <div class="form-group">
                            <input class="btn red" type="submit" Value=" Approve " onclick="return confirm(' Are you sure you want to approve this order ? ');">
                        </div>
                        <div class="clearfix"></div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <div id="cancel-popup" style="display:none;width:500px;">
        <div class="login-pop-up">
            <div class="login-form" style="">
                <h1>Cancel Order</h1>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div ID="message" align="center"></div>
                    {!! Form::open(array('url' => '/restaurant/orders/pending/cancel', 'id'=>'cancel-form','class'=>'form-horizontal form-without-legend','method'=>'post','role'=>'form')) !!}
                    <div class="form-group">
                        <label>Note: </label>
                        <textarea name="note" rows="6" class="form-control" required></textarea>
                        <input type="hidden" name="id" value="" />
                    </div>
                    <div class="form-group">
                        <input class="btn red" type="submit" Value=" Cancel " onclick="return confirm(' Are you sure you want to cancel this order ? ');">
                    </div>
                    <div class="clearfix"></div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <script>
        jQuery(document).ready(function () {
            $('.approve-popup').on('click', function(){
                var id = $(this).attr('data-id');
                $('#approve-form textarea[name=note]').val('');
                $('#approve-form input[name=id]').val(id);
            });

            $('.cancel-popup').on('click', function(){
                var id = $(this).attr('data-id');
                $('#cancel-form textarea[name=note]').val('');
                $('#cancel-form input[name=id]').val(id);
            });
        });
    </script>

@stop