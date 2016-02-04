@extends('layouts.default')
@section('content')


    <div class="row">
        @include('layouts.includes.leftsidebar')

        <div class="col-lg-9">
            <?php printfile("views/dashboard/restaurant/report.blade.php"); ?>
            <div class="restaurentsList deleteme">
                <div class="toprint">

                    <div class="noprint">
                        <h3 class="">My Orders</h3>

                            <strong>Filter by Date</strong>

                            <form id="report-form" method="get">
                                <div class="col-md-2">
                                <input type="text" class="datepicker form-control" name="from"
                                       placeholder="From" value="{{ old('from') }}">
                                </div>                                <div class="col-md-2">

                                <input type="text" class="datepicker form-control" name="to"
                                       placeholder="To" value="{{ old('to') }}">
                                </div>                                <div class="col-md-2">

                                <input type="submit" id="check_filter" class="btn btn-primary" value="Go"
                                       onclick="return checkFilter();">
</div>
                                <div class="clearfix"></div>
                            </form>


                        <input type="checkbox" checked data-toggle="toggle">








                    </div>

                    <div id="toprint">
                        @if(isset($orders) && count($orders) > 0)
                            @foreach($orders as $order)
                                <div class="restaurentDetail">
                                    <h3>Orders List</h3>
                                    <?php
                                    $restaurant = \App\Http\Models\Restaurants::where('id', $order->restaurant_id)->first(); ?>
                                    @include('common.orderinfo', array("order" => $order, "restaurant" => $restaurant, "layout" => true))
                                    @include('common.receipt')
                                    <div class="clearfix"></div>

                                </div>
                            @endforeach
                        @else
                            No orders found
                        @endif
                        <div class="clearfix"></div>

                        <div class="clearfix  hidden-xs"></div>
                        <script>
                            function checkFilter() {
                                var date1 = $('.date1').val();
                                var date2 = $('.date2').val();
                                if (date1 == '' || date2 == '') {
                                    alert('Date can\'t be blank');
                                    return false;
                                } else {
                                    date1 = date1.replace('-', '').replace('-', '');
                                    date2 = date2.replace('-', '').replace('-', '');

                                    date1 = parseFloat(date1);
                                    date2 = parseFloat(date2);

                                    if (date1 > date2) {
                                        alert('Starting date cannot be greater than end date');
                                        return false;
                                    }
                                    return true;
                                }
                            }
                        </script>
                        <style>
                            .date1, .date2 {
                                padding-left: 5px;
                            }
                        </style>
                    </div>
                </div>
            </div>
            <a href="javascript:void(0);" class="btn noprint" onclick="return printDiv('toprint')">Print Receipt</a>
            <hr class="shop__divider">
        </div>

    </div>


    <script>
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }

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
    </script>
@stop