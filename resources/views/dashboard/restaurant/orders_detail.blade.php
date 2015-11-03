@extends('layouts.default')
@section('content')


    <div class="margin-bottom-40">
        <!-- BEGIN CONTENT -->
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="content-page">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="">

                    </div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12 no-padding">
                    <div class="row">
                        @include('layouts.includes.leftsidebar')

                        <div class="col-xs-12 col-md-10 col-sm-8">
                            @if(\Session::has('message'))
                                <div class="alert {!! Session::get('message-type') !!}">
                                    <strong>{!! Session::get('message-short') !!}</strong>
                                    &nbsp; {!! Session::get('message') !!}
                                </div>
                            @endif

                            <div class="deleteme orders_details">
                                <div class="btn_wrapper margin-bottom-20 clearfix">
                                    <input type="button" style="margin: 0;" value="Print Report" onclick="printDiv('toPrintDetail')" class="btn red pull-right" />
                                    @if(strtolower($order->status) == 'pending')
                                        <a href="#cancel-popup" class="btn yellow pull-right fancybox-fast-view cancel-popup" data-id="{{ $order->id }}" style="margin: 0px 10px;">Cancel</a>
                                        <a href="#approve-popup" class="btn blue pull-right fancybox-fast-view approve-popup" data-id="{{ $order->id }}">Approve</a>
                                    @endif
                                </div>

                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div id="toPrintDetail" class="box-shadow">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-globe"></i>Orders List
                                        </div>
                                        <div class="tools">
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="infolist noprint margin-top-10"><strong>RESTAURANT NAME: </strong><?= $restaurant->name;?></div>
                                        <div class="infolist noprint"><strong>ORDERED BY: </strong><?= $order->ordered_by;?></div>
                                        <div class="infolist noprint"><strong>EMAIL: </strong><?= $order->email;?></div>
                                        <div class="infolist noprint"><strong>CONTACT: </strong><?= $order->contact;?></div>
                                        <div class="infolist noprint"><strong>ORDER TYPE: </strong><?= ($order->order_type == '1') ? 'Delivery' : 'Pickup'?></div>
                                        <div class="infolist noprint"><strong>ORDERED ON: </strong><?php $date = new DateTime($order->order_time);echo $date->format('l jS \of F Y h:i:s A'); ?></div>
                                        <div class="infolist noprint"><strong>ORDER READY: </strong><?= $order->order_till;?></div>
                                        <?php
                                            if ($order->remarks != '') {
                                                echo '<div class="infolist noprint" style="border-bottom: 1px solid #dfdfdf;padding-bottom:15px;margin-bottom:20px;"><strong>ADDITIONAL NOTES:</strong>' . $order->remarks . '</div>';
                                            }
                                        ?>
                                        @include('common.receipt')
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <!-- END EXAMPLE TABLE PORTLET-->
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- END CONTENT -->
    </div>

    @include('popups.approve_cancel')

    <script>
        $(function () {
            $(".datepicker").datepicker({"dateFormat": 'yy-mm-dd'});
        });

        $(function () {
            $('.clearitems').click(function () {
                $('.orders').html('');
                $('.tax input').val('0');
                var tax = 0;
                var df = $('.df').val();
                $('#subtotal1').val('0');
                $('.subtotal').first().text('0.00');

                var subtotal = 0;
                if ($('#pickup1').hasClass("deliverychecked")) {
                    grandtotal = 0;
                }
                else
                    grandtotal = Number(df) + Number(subtotal) + Number(tax);

                $('.grandtotal').text(grandtotal.toFixed(2));
                $('.grandtotal').val(grandtotal.toFixed(2));

                $('#cart-total').text('$' + grandtotal.toFixed(2));
            })

        });
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>

@stop