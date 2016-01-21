@extends('layouts.default')
@section('content')


    <!---- what page is this? -->


@if(false)

                <div class="row">
                    @include('layouts.includes.leftsidebar')

                    <div class="col-lg-9">
                        <?php printfile("views/dashboard/restaurant/orders_detail.blade.php"); ?>
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
                                    @include('common.orderinfo', array("order" => $order, "restaurant" => $restaurant, "user_detail" => $user_detail)))
                                    @include('common.receipt')
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->
                        </div>
                    </div>

                </div>



                @endif






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