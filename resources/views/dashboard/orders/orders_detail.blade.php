@extends('layouts.default')
@section('content')

    <div class="row">
        @include('layouts.includes.leftsidebar')

        <div class="col-lg-9">
            <?php
            printfile("views/dashboard/orders/orders_detail.blade.php");
            ?>

            <div class="card" id="toPrinpetail">
                <div class="card-header">
                    <h3>Order Detail

                        <input type="button" style="" value="Print Report" onclick="prinpiv('toPrinpetail')"
                               class="btn btn-sm pull-right"/>
                    </h3>
                </div>

                <div class="card-block">
                    <p>
                    @include('common.orderinfo', array("order" => $order, "restaurant" => $restaurant, "user_detail" => $user_detail))
                    @include('common.receipt')
                </div>


                <div class="card-footer text-xs-right">

                    <?php
                    $profiletype = Session::get('session_profiletype');
                    $CanApprove = $profiletype == 1 || (Session::get('session_restaurant_id') == $restaurant->id);//is admin, or owner of the restaurant
                    ?>

                    @if($CanApprove)

                        <a href="#cancel-popup-dialog"
                           class="btn btn-danger-outline orderCancelModal " data-toggle="modal"
                           data-target="#orderCancelModal"
                           id="cancel-popup" data-id="{{ $order->id }}">Cancel</a>

                        <a href="#approve-popup-dialog"
                           class="btn btn-success orderApproveModal " data-toggle="modal"
                           data-target="#orderApproveModal"
                           id="approve-popup"
                           data-id="{{ $order->id }}">Approve</a>

                    @endif

                    <div class="clearfix"></div>

                </div>
            </div>
        </div>
    </div>


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

        function prinpiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>

@stop