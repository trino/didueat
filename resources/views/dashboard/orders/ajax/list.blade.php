<?php
    echo printfile("views/dashboard/orders/ajax/list.blade.php");
    $secondsper = array("day" => 86400, "hr" => 3600, "min" => 60);//"week" => 604800,
    $secondsTitle = "sec";
?>

@if(\Session::has('message'))
    {!! message_show("Message!", \Session::get('message')) !!}
@endif

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-lg-9">
                <h4>
                    @if($type=='user')
                        My
                    @else
                        Restaurant
                    @endif
                    Orders
                    @if(true)

                        <a class="btn btn-primary btn-sm" href="{{ url('orders/report') }}" class="">Print
                            Report</a>
                    @endif

                </h4>

            </div>
            @if(true)
                @include('common.table_controls')
            @endif
        </div>
    </div>

    <div class="card-block p-a-0">
        <table class="table table-responsive m-b-0">

            @if($recCount > 0)

                <thead>
                <tr>
                    <th>
                        <!--a class="sortOrder" data-meta="id" data-order="ASC" data-title="ID" title="Sort ID ASC"><i
                                    class="fa fa-caret-down"></i></a-->
                        Order #
                        <!--a class="sortOrder" data-meta="id" data-order="DESC" data-title="ID" title="Sort ID DESC"><i
                                    class="fa fa-caret-up"></i></a-->
                    </th>
                    <th>
                        <!--a class="sortOrder" data-meta="ordered_by" data-order="ASC" data-title="Ordered By"
                           title="Sort [Ordered By] ASC"><i class="fa fa-caret-down"></i></a-->
                        Customer
                        <!--a class="sortOrder" data-meta="ordered_by" data-order="DESC" data-title="Ordered By"
                           title="Sort [Ordered By] DESC"><i class="fa fa-caret-up"></i></a-->
                    </th>
                    <th>
                        <!--a class="sortOrder" data-meta="order_time" data-order="ASC" data-title="Date/Time"
                           title="Sort [Date/Time] ASC"><i class="fa fa-caret-down"></i></a-->
                        Ordered On
                        <!--a class="sortOrder" data-meta="order_time" data-order="DESC" data-title="Date/Time"
                           title="Sort [Date/Time] DESC"><i class="fa fa-caret-up"></i></a-->
                    </th>
                    <th>
                        <!--a class="sortOrder" data-meta="status" data-order="ASC" data-title="Status"
                           title="Sort [Status] ASC"><i class="fa fa-caret-down"></i></a-->
                        Status
                        <!--a class="sortOrder" data-meta="status" data-order="DESC" data-title="Status"
                           title="Sort [Status] DESC"><i class="fa fa-caret-up"></i></a-->
                    </th>

                    <TH>
                        Response Time
                    </TH>
                    <th>

                    </th>
                </tr>
                </thead>
                <tbody>


                @foreach($Query as $value)
                    <tr>
                        <td>
                            <a href="{{ url('orders/order_detail/' . $value->id . '/' . $type) }}" class="btn btn-primary  btn-sm">{{ $value->guid }}</a>
                        </td>
                        <td>{{ $value->ordered_by }}</td>
                        <td>{{ date(get_date_format(), strtotime($value->order_time)) }}</td>
                        <td><?= ucfirst($value->status) . '<HR>' . iif($value->order_type, "Delivery", "Pickup"); ?></td>

                        <TD>
                            <?php
                            if ($value->time) {
                                echo '<FONT COLOR="';
                                $delay = (strtotime($value->time) - strtotime($value->order_time));
                                if ($delay < 60) {
                                    echo 'GREEN">';
                                } else if ($delay < 300) {
                                    echo 'ORANGE">';
                                } else {
                                    echo 'RED">';
                                }
                                $delay = array($secondsTitle => $delay, "total" => "");
                                $total = array();
                                foreach ($secondsper as $timeperiod => $seconds) {
                                    $delay[$timeperiod] = floor($delay[$secondsTitle] / $seconds);
                                    $delay[$secondsTitle] = $delay[$secondsTitle] - ($seconds * $delay[$timeperiod]);
                                    if ($delay[$timeperiod]) {
                                        $total[] = $delay[$timeperiod] . " " . $timeperiod;// . iif($delay[$timeperiod] != 1, "s");
                                    }
                                }
                                if ($delay[$secondsTitle]) {
                                    $total[] = $delay[$secondsTitle] . " " . $secondsTitle;// . iif($delay[$secondsTitle] != 1, "s");
                                }
                                echo implode(" ", $total) . '</FONT>';
                            }
                            ?>
                        </TD>


                        <td>
                            @if(Session::get('session_profiletype') == 1)
                                <a href="{{ url('orders/list/delete/'.$type.'/'.$value->id) }}"
                                   class="btn btn-secondary-outline btn-sm pull-right"
                                   onclick="return confirm('Are you sure you want to delete order # {{ $value->id }}?');">
                                    X
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                @else



                    <tr>
                        <td><span class="text-muted">No Orders Yet</span></td>
                    </tr>
                @endif
                </tbody>
        </table>
    </div>

    @if($recCount > 10)
        <div class="card-footer clearfix">
            {!! $Pagination !!}
        </div>
    @endif

</div>