@extends('layouts.default')
@section('content')
    <?php
        printfile("views/dashboard/restaurant/report.blade.php");
        $alts = array(
            "print" => "Print preview"
        );
        if(!isset($_GET['from'])){$_GET['from'] = now("Y-m-d", time() - 3600*24*7);}
        if(!isset($_GET['to'])){$_GET['to'] = now("Y-m-d");}
    ?>

    <link href="{{ asset('assets/global/css/timepicker.css') }}" rel="stylesheet"/>
    <div class="container">
        <div class="row">
            @include('layouts.includes.leftsidebar')

            <div class="col-lg-9">
                <div class="restaurentsList deleteme">
                    <div class="toprint">
                        <h3 class="p-b-1">My Orders
                            <a href="javascript:void(0);" class="btn btn-secondary noprint pull-right" title="{{ $alts["print"] }}" onclick="return printDiv('toprint')">Print</a>
                        </h3>
                        <hr class="p-t-1"/>
                        <div class="noprint row">
                            <div class="col-md-12">Filter by Date</div>
                            <div class="col-md-12">
                                <form id="report-form" method="get">

                                    <div class="input-group">
                                        <div class="input-group-btn">
                                            <input type="text" class="datepicker form-control" name="from" placeholder="From"
                                                value="<?php if(isset($_GET['from']))echo $_GET['from'];else{?>{{ old('from') }}<?php }?>">
                                        </div>

                                        <div class="input-group-btn">
                                            <input type="text" class="datepicker form-control" name="to" placeholder="To"
                                                value="<?php if(isset($_GET['to']))echo $_GET['to'];else{?>{{ old('to') }}<?php }?>">
                                        </div>

                                        <div class="input-group-btn">
                                            <input type="submit" id="check_filter" class="btn btn-primary" value="Go" onclick="return checkFilter();">
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>
                                </form>
                            </div>

                            <div class="clearfix"></div>
                        </div>


                        <div id="toprint">
                            @if(isset($orders) && count($orders) > 0)
                                @foreach($orders as $order)
                                    <div class="restaurentDetail card">

                                        <?php $restaurant = get_entry("restaurants", "id", $order->restaurant_id); ?>
                                        <div class="col-md-6">
                                            @include('common.orderinfo', array("order" => $order, "restaurant" => $restaurant, "layout" => true))
                                        </div>
                                        <div class="col-md-6">
                                            @include('common.receipt', array("type" => "report"))
                                        </div>
                                        <div class="clearfix"></div>

                                    </div>
                                @endforeach
                            @else
                                <br>No orders placed by you between {{ $_GET['from'] }} and {{ $_GET['to'] }} were found
                            @endif

                            <div class="clearfix"></div>

                            <div class="clearfix hidden-xs"></div>

                            <script>
                                //makes sure the end date isn't before the start date, for searching between 2 dates
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

                        <hr class="p-t-1"/>
                        <a href="javascript:void(0);" title="{{ $alts["print"] }}" class="btn btn-secondary noprint pull-right" onclick="return printDiv('toprint')">Print</a>
                    </div>
                </div>

            </div>

        </div>
    </div>


    <script>
        //send to the print preview screen
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