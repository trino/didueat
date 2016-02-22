@extends('layouts.default')
@section('content')

    <div class="container ">
        <?php
            printfile("views/dashboard/orders/orders_detail.blade.php");
            $profiletype = Session::get('session_profiletype');
            $CanApprove = $profiletype == 1 || Session::get('session_restaurant_id') == $restaurant->id;//is admin, or (is pending and is owner of the restaurant)
            //$order->status == "pending", "cancelled", or "approved"
            echo '<INPUT TYPE="HIDDEN" ID="orderid" VALUE="' . $order->id . '">';
        ?>
        <div class="row">

            @include('layouts.includes.leftsidebar')

            <div class="col-lg-9">

                <div class="card" id="toPrinpetail">
                    <div class="card-header">
                        <h4 class="card-title">Order #{{$order->guid}}
                            <input type="button" style="" value="Print Receipt" onclick="prinpiv('toPrinpetail')" class="btn btn-sm btn-secondary-outline pull-right"/>
                        </h4>
                    </div>

                    <div class="card-block">
                        <div class="row">
                            <div class="col-md-6">
                                @include('common.receipt')
                                <div class="clearfix"></div>
                            </div>

                            <div class="col-md-6">
                                @include('common.orderinfo', array("order" => $order, "restaurant" => $restaurant, "user_detail" => $user_detail))
                                <div class="clearfix"></div>
                            </div>

                            <div  class="col-md-6" style="height:200px;max-width:100%;list-style:none; transition: none;overflow:hidden;">
                                @include("common.gmaps", array("address" => $restaurant->formatted_address))
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>

                        @if($CanApprove)
                            <div class="card-footer text-xs-right">
                                @if($order->status != "cancelled")
                                    <a href="#cancel-popup-dialog"
                                       class="btn btn-danger orderCancelModal " data-toggle="modal"
                                       data-target="#orderCancelModal"
                                       id="cancel-popup" data-id="{{ $order->id }}">Decline</a>
                                @endif
                                @if($order->status == "pending")
                                    <a href="#approve-popup-dialog"
                                       class="btn btn-primary orderApproveModal " data-toggle="modal"
                                       data-target="#orderApproveModal"
                                       id="approve-popup"
                                       data-id="{{ $order->id }}">Accept</a>
                                @endif

                                <div class="clearfix"></div>
                            </div>
                        @endif

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