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
                <h4 class="card-title">
                    @if($type=='user')
                        My
                    @else
                        Restaurant
                    @endif
                    Orders

                    <a class="btn btn-secondary btn-sm" href="{{ url('orders/report') }}" class="">Print Report</a>
                    @if($type == "admin" && false)
                        <a class="btn btn-primary btn-sm" ONCLICK="notifystore(event, 0);">Notify All</a>
                    @endif
                </h4>

            </div>
            @if(false)
                @include('common.table_controls')
            @endif
        </div>
    </div>

    <div class="card-block p-a-0">
        <table class="table table-responsive m-b-0">

            @if($recCount > 0)

                <thead>
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Ordered On</th>
                    <th>Status</th>
                    <TH>Response Time</TH>
                    <th></th>
                </tr>
                </thead>
                <tbody>


                @foreach($Query as $value)
                    <tr>
                        <td>
                            <a href="{{ url('orders/order_detail/' . $value->id . '/' . $type) }}" class="btn btn-primary  btn-sm">{{ $value->guid }}</a>
                        </td>
                        <td>{{ $value->ordered_by }}</td>
                        <td>
                            <?php
                               $dateformat = get_date_format();
                               $date = strtotime($value->order_time);
                               if (date("dmY", $date) == date("dmY")){
                                   echo '<FONT COLOR="GREEN">Today, </FONT>';
                                   $dateformat = str_replace("M d, Y", "", $dateformat);
                               }
                               echo date($dateformat, $date);
                               echo '<HR class="m-a-0">(For ' . iif($value->order_type, "Delivery", "Pickup").')';
                            echo '</td><TD>';

                                echo '<FONT COLOR="';
                                switch ($value->status){
                                    case "approved": echo 'GREEN'; break;
                                    case "cancelled": echo 'RED'; break;
                                    case "pending": echo 'ORANGE'; break;
                                }
                                echo '">' . ucfirst($value->status);

                                echo '</FONT>';

                            echo '</td><TD>';

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
                                } else {
                                    echo "Pending...";
                                }
                            ?>
                        </TD>


                        <td>
                            @if(Session::get('session_profiletype') == 1)
                                <a href="{{ url('orders/list/delete/'.$type.'/'.$value->id) }}"
                                   class="btn btn-secondary-outline btn-sm pull-right"
                                   onclick="return confirm('Are you sure you want to delete order #{{ $value->id }}?');">
                                    <i class="fa fa-times"></i>
                                </a>
                            @endif
                            @if($type == "admin" )
                                <a class="btn btn-primary btn-sm"
                                   ONCLICK="notifystore(event, {{ $value->id}} );">Notify</a>

                            @endif
                        </td>
                    </tr>
                @endforeach
                @else



                    <tr>
                        <td><span class="text-muted">No Orders</span></td>
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

<SCRIPT>
    function notifystore(event, OrderID) {
        var element = event.target;
        element.setAttribute("disabled", "true");
        var OriginalText = element.innerHTML;
        element.innerHTML = 'Standby';
        $.ajax({
            url: "{{  url('orders/alertstore') }}",
            type: "get",
            dataType: "HTML",
            data: "orderid=" + OrderID,
            success: function (msg) {
                element.innerHTML = 'Notified';
                element.removeAttribute("disabled");
            },
            error: function (msg) {
                toast("An error occurred.", true);
                element.innerHTML = OriginalText;
                element.removeAttribute("disabled");
            }
        })
    }
</SCRIPT>