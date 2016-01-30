<?php
echo printfile("views/dashboard/orders/ajax/list.blade.php");
$secondsper = array("day" => 86400, "hour" => 3600, "minute" => 60);//"week" => 604800,
?>

@if(\Session::has('message'))
    {!! message_show("Message!", \Session::get('message')) !!}
@endif



<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-lg-9">
                <h3>
                    Restaurant Orders <!-- ({{ ucwords($type) }})         -->           <!--a class="btn btn-primary btn-sm " href="{{ url('orders/report') }}" class="">Print Report</a-->

                </h3>

            </div>
            @include('common.table_controls')
        </div>
    </div>

    <div class="card-block p-a-0">
        <table class="table table-responsive">
            <thead>
            <tr>
                <th>
                    <!--a class="sortOrder" data-meta="id" data-order="ASC" data-title="ID" title="Sort ID ASC"><i
                                class="fa fa-caret-down"></i></a-->
                    Order Id
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
                    Date
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
                </TH>  <th>

                </th>
            </tr>
            </thead>
            <tbody>
            @if($recCount > 0)
                @foreach($Query as $value)
                    <tr>
                        <td>{{ $value->id }}
                            @if(Session::get('session_profiletype') >= 1)
                                <a href="{{ url('orders/order_detail/' . $value->id . '/' . $type) }}"
                                   class="btn btn-primary  btn-sm">View</a>
                            @endif
                        </td>
                        <td>{{ $value->ordered_by }}</td>
                        <td>{{ date(get_date_format(), strtotime($value->order_time)) }}</td>
                        <td>{{ $value->status }}</td>


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
                                $delay = array('second' => $delay, "total" => "");
                                $total = array();
                                foreach ($secondsper as $timeperiod => $seconds) {
                                    $delay[$timeperiod] = floor($delay["second"] / $seconds);
                                    $delay["second"] = $delay["second"] - ($seconds * $delay[$timeperiod]);
                                    if ($delay[$timeperiod]) {
                                        $total[] = $delay[$timeperiod] . " " . $timeperiod . iif($delay[$timeperiod] != 1, "s");
                                    }
                                }
                                if ($delay["second"]) {
                                    $total[] = $delay["second"] . " second" . iif($delay["second"] != 1, "s");
                                }
                                echo implode(", ", $total) . '</FONT>';
                            }
                            ?>
                        </TD>



                        <td>
                            @if(Session::get('session_profiletype') == 1)
                                <a href="{{ url('orders/list/delete/'.$type.'/'.$value->id) }}"
                                   class="btn btn-danger-outline btn-sm pull-right"
                                   onclick="return confirm('Are you sure you want to delete order # {{ $value->id }}?');">
                                    X
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="text-center  alert notification">No orders found</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
    <div class="card-footer clearfix">
        {!! $Pagination !!}
    </div>
</div>