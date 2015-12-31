@extends('layouts.default')
@section('content')


    <div class="row">
        @include('layouts.includes.leftsidebar')

        <div class="col-lg-9">
            <?php printfile("views/dashboard/restaurant/report.blade.php"); ?>
            <div class="restaurentsList deleteme">
                <div class="toprint">

                    <div class="noprint">
                        <h3 class="sidebar__title">Print Order Report</h3>
                        <hr class="shop__divider">
                        <div>
                            <strong>FILTER BY DATE</strong>

                            <form class="col-xs-12" id="report-form" method="get" action="">
                                <input type="text" class="datepicker form-control--contact" name="from"
                                       placeholder="FROM (Date)" value="{{ old('from') }}">
                                <input type="text" class="datepicker form-control--contact" name="to"
                                       placeholder="TO (Date)" value="{{ old('to') }}">
                                <input type="submit" id="check_filter" class="btn btn-primary" value="Go"
                                       onclick="return checkFilter();">

                                <div class="clearfix"></div>
                            </form>
                            <div class="clearfix"></div>
                        </div>
                    </div>

                    <div id="toprint">
                        @if(isset($orders) && count($orders) > 0)
                            @foreach($orders as $order)
                                <div class="restaurentDetail">
                                    <h3>Orders List</h3>
                                    <?php
                                    $restaurant = \App\Http\Models\Restaurants::where('id', $order->restaurant_id)->first(); ?>
                                    <div class="infolist noprint margin-top-10"><strong>RESTAURANT
                                            NAME: </strong><?= $restaurant->name;?></div>
                                    <div class="infolist noprint"><strong>ORDERED BY: </strong><?= $order->ordered_by;?>
                                    </div>
                                    <div class="infolist noprint"><strong>EMAIL: </strong>{{ $order->email }}</div>
                                    <div class="infolist noprint"><strong>CONTACT: </strong>{{ $order->contact }}</div>
                                    <div class="infolist noprint"><strong>ORDER
                                            TYPE: </strong>{{ ($order->order_type == '1') ? 'Delivery' : 'Pickup' }}
                                    </div>
                                    <div class="infolist noprint"><strong>ORDERED
                                            ON: </strong><?php $date = new DateTime($order->order_time);echo $date->format('l jS \of F Y h:i:s A'); ?>
                                    </div>
                                    <div class="infolist noprint"><strong>ORDER READY: </strong>{{ $order->order_till }}
                                    </div>
                                    <?php
                                    if ($order->remarks != '') {
                                        echo '<div class="infolist noprint" style="border-bottom: 1px solid #dfdfdf;padding-bottom:15px;margin-bottom:20px;"><strong>ADDITIONAL NOTES:</strong>' . $order->remarks . '</div>';
                                    }
                                    ?>
                                    @include('common.receipt')
                                    <div class="clearfix"></div>

                                </div>
                            @endforeach
                        @else
                            Sorry! No Results Found.
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
            <a href="javascript:void(0);" class="btn red noprint" onclick="return printDiv('toprint')">Print Receipt</a>
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