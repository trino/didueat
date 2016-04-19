@extends('layouts.default')
@section('content')

    <div class="container ">
        <?php
            printfile("views/dashboard/orders/orders_detail.blade.php");
            $profiletype = Session::get('session_profiletype');
            $CanApprove = $profiletype == 1 || ($order->status == "pending" && Session::get('session_restaurant_id') == $restaurant->id);//is admin, or (is pending and is owner of the restaurant)
            //$order->status == "pending", "cancelled", or "approved"
            echo '<INPUT TYPE="HIDDEN" ID="orderid" VALUE="' . $order->id . '">';
            $paid_for = 0;
            if ($order->paid) {
                $paid_for = 1;
            }
            if($order->status == "pending" && $order->order_till){
                $duedate = strtotime($order->order_till);
                if ($duedate < time()){
                    $order->status = "waiting";
                }
            }
            $alts=array(
                    "approve" => "Accept this order",
                    "decline" => "Decline this order",
                    "cantdecline" => "Unable to decline this order"
            );
            $showCSR = true;
        ?>
        <div class="row">

            @include('layouts.includes.leftsidebar')

            <div class="col-lg-9">

                <div class="card" id="toPrinpetail">
                    <div class="card-header">
                        <h4 class="card-title">Order #{{$order->guid}}
                            <input type="button" value="Print" onclick="prinpiv('toPrinpetail')"
                                   class="hidden-sm-down btn btn-sm btn-secondary-outline pull-right"/>
                        </h4>
                    </div>

                    <div class="card-block row">

                        <div class="col-md-6">
                            @include('common.receipt')
                        </div>

                        <div class="col-md-6">
                            <div class="card " style="margin-bottom: 0 !important;">
                                <div class="card-block">


                                    @if(!$CanApprove)
                                        <table style="width:100%;">
                                            <tbody>
                                            <tr class="infolist noprint">
                                                <td class=""><strong>Restaurant</strong></td>
                                                <td width="15"></td>
                                                <td>{{$restaurant->name}}</td>
                                            </tr>
                                            <tr class="infolist noprint">
                                                <td class=""><strong>Phone</strong></td>
                                                <td width="15"></td>
                                                <td>{{$restaurant->phone}}</td>
                                            </tr>
                                            <tr class="infolist noprint">
                                                <td class=""><strong>Address</strong></td>
                                                <td width="15"></td>
                                                <td>{{$restaurant->address}}, {{$restaurant->city}} {{$restaurant->province}} {{$restaurant->postal_code}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
<hr >
                                    @endif

                                    @include('common.orderinfo', array("order" => $order, "restaurant" => $restaurant, "user_detail" => $user_detail, "paid_for"=> $paid_for))
                                        @if(!$CanApprove)
                                            @if($order->order_type == 0 && false)
                                                @include("common.gmaps", array("address" => $restaurant->formatted_address))
                                            @endif
                                        @endif

                                        @if($order->order_type > 0 && $CanApprove && false)
                                            @include("common.gmaps", array("address" => $restaurant->formatted_address))
                                        @endif

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <!--  include("home.stripe", array("orderID" => $order->id, "invoiceCents" => $order->g_total * 100, "salesTax" => $order->tax * 100, "orderDesc" => $order->guid)) -->
                    @if($CanApprove)

                        <div class="card-footer text-xs-right">

                            @if($order->status != "cancelled")
                                @if($order->status == "waiting")
                                    <a class="btn btn-secondary" title="{{ $alts["cantdecline"] }}">Can't Decline</a>
                                @else
                                    <a href="#cancel-popup-dialog"
                                       class="btn btn-danger orderCancelModal " data-toggle="modal"
                                       data-target="#orderCancelModal" title="{{ $alts["decline"] }}"
                                       id="cancel-popup" data-id="{{ $order->id }}">Decline</a>
                                @endif
                            @endif
                            @if($order->status == "pending" || $order->status == "waiting")
                                <a href="#approve-popup-dialog"
                                   class="btn btn-primary orderApproveModal " data-toggle="modal"
                                   data-target="#orderApproveModal"
                                   id="approve-popup" title="{{ $alts["approve"] }}"
                                   data-id="{{ $order->id }}">Accept</a>
                            @endif
                        </div>
                    @endif

                </div>
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