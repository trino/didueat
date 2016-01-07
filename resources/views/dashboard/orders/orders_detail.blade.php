@extends('layouts.default')
@section('content')

    <div class="row">
        @include('layouts.includes.leftsidebar')

        <div class="col-lg-9">
            <?php
                printfile("views/dashboard/orders/orders_detail.blade.php");
                $profiletype = Session::get('session_profiletype');
                $date = new DateTime($order->order_time);
            ?>


            <div class="card" id="toPrintDetail">
                <div class="card-header ">
                    <p>Order Detail
                        <input type="button" style="" value="Print Report" onclick="printDiv('toPrintDetail')" class="btn btn-sm pull-right"/>
                    </p>
                </div>

                <div class="card-block">
                    @if($profiletype == 1 || $profiletype == 2)
                        @if(strtolower($order->status) == 'pending')
                            <a href="#cancel-popup-dialog"
                               class="btn btn-warning btn-sm orderCancelModal" data-toggle="modal" data-target="#orderCancelModal"
                               oldclass="btn yellow pull-right fancybox-fast-view cancel-popup"
                               id="cancel-popup" data-id="{{ $order->id }}">Cancel</a>
                            <a href="#approve-popup-dialog"
                               class="btn btn-success btn-sm orderApproveModal" data-toggle="modal" data-target="#orderApproveModal"
                               oldclass="btn red blue pull-right fancybox-fast-view approve-popup" id="approve-popup"
                               data-id="{{ $order->id }}">Approve</a>
                        @else
                            {{ "Status: " . strtolower($order->status)}}
                        @endif
                    @else
                        {{"Profile Type: " . Session::get('session_profiletype')}}
                    @endif

                    <div>

                        <TABLE WIDTH="50%">
                        @if(is_object($user_detail))
                            <TR><TD>Ordered by</TD>     <TD>{{ $user_detail->name }}</TD></TR>
                            <TR><TD>Email</TD>          <TD>{{ $user_detail->email }}</TD></TR>
                        @else
                            <TR><TD COLSPAN="2">User is not on record!</TD></TR>
                        @endif
                        <TR><TD>Contact</TD>            <TD>{{ $order->contact }}</TD></TR>
                        <TR><TD>Order Type</TD>         <TD>{{ ($order->order_type == '1') ? 'Delivery':'Pickup' }}</TD></TR>
                        <TR><TD>Ordered On</TD>         <TD>{{ $date->format('l jS \of F Y h:i:s A') }}</TD></TR>
                        <TR><TD>Order ready</TD>        <TD>{{ $order->order_till }}</TD></TR>
                        <TR><TD>Restaurant</TD>         <TD>{{ (isset($restaurant->name))?'['.$restaurant->name.']':'' }}</TD></TR>
                        @if($order->remarks != '')
                            <TR><TD>Notes</TD>          <TD>{{ $order->remarks }}
                        @endif
                        </TABLE>
                        
                        @include('common.receipt')

                    </div>
                </div>

                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    @include('common.tabletools')
    @include('popups.approve_cancel')

    <script>
        $(function () {
            $(".datepicker").datepicker({"dateFormat": 'yy-mm-dd'});

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