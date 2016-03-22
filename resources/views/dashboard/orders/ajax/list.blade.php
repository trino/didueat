<?php
    printfile("views/dashboard/orders/ajax/list.blade.php");
    $secondsper = array("day" => 86400, "hr" => 3600, "min" => 60);//"week" => 604800,
    $secondsTitle = "sec";
    function statuscolor($Status, $Color = false){
        switch ($Status) {
            case "approved":
                return iif($Color, 'GREEN', "btn-success");
                break;
            case "cancelled":
                return iif($Color, 'RED', "btn-danger");
                break;
            case "pending":
                return iif($Color, 'ORANGE', "btn-warning");
                break;
        }
    }
    $alts = array(
            "print" => "Print preview",
            "notifyall" => "Notify stores for every pending order",
            "notifyone" => "Notify the store for this order",
            "order_detail" => "View the order",
            "restaurants/menu" => "View the restaurant",
            "deleteorder" => "Delete this order"
    );
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

                    @if (Session::get('session_type_user') == "super" || $type=='restaurant')
                        <a class="btn btn-secondary btn-sm" title="{{ $alts["print"] }}" href="{{ url('orders/report') }}">Print Report</a>
                    @endif

                    @if($type == "admin" && false)
                        <a class="btn btn-primary btn-sm" title="{{ $alts["notifyall"] }}" ONCLICK="notifystore(event, 0);">Notify All</a>
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
                        <th>
                            @if($type=='user')
                                Restaurant
                            @else
                                Customer
                            @endif
                        </th>
                        <th>Ordered On</th>
                        <th>Status</th>
                        @if (Session::get('session_type_user') == "super" || $type=='restaurant')

                        <TH>Response Time</TH>
                        @endif
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($Query as $value)
                    <?php
                      $resto = DB::table('restaurants')->select('name', 'slug')->where('id', '=', $value->restaurant_id)->get();
                    ?>
                        <tr id="order{{ $value->id }}">
                            <td>
                                <a href="{{ url('orders/order_detail/' . $value->id . '/' . $type) }}" title="{{ $alts["order_detail"] }}" class="btn {{ statuscolor($value->status) }} btn-sm">{{ $value->guid }}</a>
                            </td>
                            <td>
                                @if($type=='user')
                                    <a HREF="{{ url('restaurants/'. $resto[0]->slug .'/menu') }}" title="{{ $alts["restaurants/menu"] }}">{{ $resto[0]->name }}</a>
                                @else
                                    {{$value->ordered_by }}
                                @endif
                            </td>

                            <td>
                                <?php
                                $dateformat = get_date_format();//D M d, g:j A
                                $date = strtotime($value->order_time);
                                if (date("dmY", $date) == date("dmY")) {
                                    echo '<FONT COLOR="">Today, </FONT>';
                                    $dateformat = str_replace("D M d,", "", $dateformat);
                                }
                                echo date($dateformat, $date);
                                echo '<HR class="m-a-0">(For ' . iif($value->order_type, "Delivery", "Pickup") . iif($value->order_till, ' later') . ')';
                                echo '</td>';

                                echo '<TD><FONT COLOR="' . statuscolor($value->status, true) . '">' . ucfirst($value->status) . '</FONT></td>';

                                echo '<TD>';
                                    if (Session::get('session_type_user') == "super" || $type=='restaurant'){
                                        if ($value->time && $value->status != "pending") {
                                            echo '<FONT COLOR="';
                                            $delay = (strtotime($value->time) - strtotime($value->order_time));
                                            if ($delay < 60) {
                                                echo 'GREEN">';
                                            } else if ($delay < 300) {
                                                echo 'ORANGE">';
                                            } else {
                                                echo 'RED">';
                                            }
                                            //check how much time has passed
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
                                    }
                                ?>
                            </TD>


                            <td>
                                @if(Session::get('session_profiletype') == 1)
                                    <!--a href="{{ url('orders/list/delete/'.$type.'/'.$value->id) }}"
                                       class="btn btn-secondary-outline btn-sm pull-right"
                                       onclick="return confirm('Are you sure you want to delete order #{{ $value->id }}?');">
                                        <i class="fa fa-times"></i>
                                    </a-->
                                    <a title="{{ $alts["deleteorder"] }}"
                                       class="btn btn-secondary-outline btn-sm pull-right"
                                       onclick="deleteorder({{ $value->id }});">
                                        <i ID="fa{{ $value->id }}" class="fa fa-times"></i>
                                    </a>
                                @endif
                                @if($type == "admin" )
                                    <a class="btn btn-secondary-outline btn-sm pull-right" title="{{ $alts["notifyone"] }}"
                                       ONCLICK="notifystore(event, {{ $value->id}});">Notify</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
            @else
                <tr>
                    <td><span class="text-muted">No orders yet</span></td>
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
    var Orders = "{{ iterator_count($Query) }}";
    function deleteorder(ID){
        if(confirm('Are you sure you want to delete order #' + ID + '?')) {
            $("#fa" + ID).attr("class", "fa fa-spinner fa-spin");
            $.post("{{ url('orders/list/delete/' . $type) }}/" + ID, {_token: "{{ csrf_token() }}"}, function (result) {
                Orders=Orders-1;
                if(Orders) {
                    $("#order" + ID).fadeOut();
                } else {
                    $("#loadPageData").html(result);
                }
            });
        }
    }

    //notify the store of a pending order
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