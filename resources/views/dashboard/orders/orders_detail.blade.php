@extends('layouts.default')
@section('content')

<div class="row">
    @include('layouts.includes.leftsidebar')

    <div class="col-lg-9">
        <?php printfile("views/dashboard/restaurant/orders_detail.blade.php"); ?>
        @if(\Session::has('message'))
        <div class="alert {!! Session::get('message-type') !!}">
            <strong>{!! Session::get('message-short') !!}</strong>
            &nbsp; {!! Session::get('message') !!}
        </div>
        @endif

        <div class="deleteme orders_details">
            <div class="btn_wrapper margin-bottom-20 clearfix">
                <input type="button" style="margin: 0;" value="Print Report" onclick="printDiv('toPrintDetail')" class="btn red pull-right" />
                @if(Session::get('session_profiletype') == 1)
                @if(strtolower($order->status) == 'pending')
                <a href="#cancel-popup-dialog" class="btn yellow pull-right fancybox-fast-view cancel-popup" id="cancel-popup" data-id="{{ $order->id }}">Cancel</a>
                <a href="#approve-popup-dialog" class="btn red blue pull-right fancybox-fast-view approve-popup" id="approve-popup" data-id="{{ $order->id }}">Approve</a>
                @endif
                @endif
            </div>

            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div id="toPrintDetail" class="box-shadow">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i> Order Detail
                    </div>
                    <div class="tools">
                    </div>
                </div>
                <?php $date = new DateTime($order->order_time); ?>
                <div class="portlet-body">
                    <div class="infolist noprint"><strong>ORDERED BY: </strong>{{ $user_detail->name }}</div>
                    <div class="infolist noprint"><strong>EMAIL: </strong>{{ $user_detail->email }}</div>
                    <div class="infolist noprint"><strong>CONTACT: </strong>{{ $order->contact }}</div>
                    <div class="infolist noprint"><strong>ORDER TYPE: </strong>{{ ($order->order_type == '1') ? 'Delivery' : 'Pickup' }}</div>
                    <div class="infolist noprint"><strong>ORDERED ON: </strong>{{ $date->format('l jS \of F Y h:i:s A') }}</div>
                    <div class="infolist noprint"><strong>ORDER READY: </strong>{{ $order->order_till }}</div>
                    <div class="portlet-title">
                        <div class="caption">
                            Restaurant {{ (isset($restaurant->name))?'['.$restaurant->name.']':'' }}
                        </div>
                    </div>
                    @if($order->remarks != '')
                    <div class="infolist noprint" style="border-bottom: 1px solid #dfdfdf;padding-bottom:15px;margin-bottom:20px;"><strong>ADDITIONAL NOTES:</strong> {{ $order->remarks }}</div>
                    @endif
                    
                    @include('common.receipt')
                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>

</div>

@include('common.tabletools')

@include('popups.approve_cancel')

<script>
    $(function() {
        $(".datepicker").datepicker({"dateFormat": 'yy-mm-dd'});

        $('.clearitems').click(function() {
            $('.orders').html('');
            $('.tax input').val('0');
            var tax = 0;
            var df = $('.df').val();
            $('#subtotal1').val('0');
            $('.subtotal').first().text('0.00');

            var subtotal = 0;
            if ($('#pickup1').hasClass("deliverychecked")) {
                grandtotal = 0;
            } else {
                grandtotal = Number(df) + Number(subtotal) + Number(tax);
            }

            $('.grandtotal').text(grandtotal.toFixed(2));
            $('.grandtotal').val(grandtotal.toFixed(2));

            $('#cart-total').text('$' + grandtotal.toFixed(2));
        });
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