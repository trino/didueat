<?php
    printfile("views/dashboard/orders/ajax/list.blade.php");
    $secondsper = array("day" => 86400, "hr" => 3600, "min" => 60);//"week" => 604800,
    $secondsTitle = "sec";
    function statuscolor($Status, $Color = false){
        switch ($Status) {
            case "incomplete":
                return iif($Color, 'BLUE', "btn-secondary");
                break;
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
            "deleteorder" => "Delete this order",
            "available" => "Mark yourself as available for the next 8 hours",
            "unavailable" => "Mark yourself as unavailable"
    );

    if($type == "driver"){
        $eighthoursago = now(false, strtotime("-8 hour") );
        $driver = select_field("profiles", "id", read("id"));
    }

    if(debugmode()){
        var_dump($SQL);
    }
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
                    @elseif($type=='driver')
                        Delivery
                    @else
                        Restaurant
                    @endif
                    Orders

                    @if (Session::get('session_type_user') == "super" || $type=='restaurant')
                        <a class="btn btn-secondary btn-sm pull-right" title="{{ $alts["print"] }}" href="{{ url('orders/report') }}">Print Report</a>
                    @endif

                    @if($type == "admin" && false)
                        <a class="btn btn-primary btn-sm pull-right" title="{{ $alts["notifyall"] }}" ONCLICK="notifystore(event, 0);">Notify All</a>
                    @endif
                </h4>
            </div>
            @if($type=='driver')
                <div class="col-lg-3" TITLE="{{ $alts["available"] }}">
                    <LABEL id="available-label">
                        <input type="checkbox" class="toggle" @if($driver->available_at > $eighthoursago) checked @endif ONCLICK="available(event);">
                        Availability
                    </LABEL>
                    <SPAN id="available-spinner" style="display:none;"><I CLASS="fa fa-spin fa-spinner"></I> Updating</SPAN>
                </div>
            @endif
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
                        <TH>Type</TH>
                        @if($type!='user')
                            <th>Status</th>
                            @if (Session::get('session_type_user') == "super" || $type=='restaurant'  || $type=='driver')
                                <TH>Response Time</TH>
                            @endif
                        @endif
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($Query as $value)
                        <?php
                            $URL = url('orders/order_detail/' . $value->id . '/' . $type);
                            if(ReceiptVersion == ""){
                                $resto = DB::table('restaurants')->select('name', 'slug')->where('id', '=', $value->restaurant_id)->get();
                            } else {
                                $value->guid = $value->id;
                                if($value->status == "incomplete"){//get the slug of the first restaurant from the order
                                    $restaurant_id = select_field("orderitems", "order_id", $value->id, "restaurant_id");
                                    $URL = url("restaurants/" . getslug($restaurant_id)  . "/menu") . "?orderid=" . $value->id;
                                }
                            }
                        ?>
                        <tr id="order{{ $value->id }}">
                            <td align="center">
                                <a href="{{ $URL }}" title="{{ $alts["order_detail"] }}" class="btn {{ statuscolor($value->status) }} btn-sm" style="width:100%">
                                    {{ $value->guid }}
                                </a>
                            </td>
                            <td>
                                <?php
                                    if($type=='user'){
                                        if(isset($resto)){
                                            echo '<a HREF="' . url('restaurants/'. $resto[0]->slug .'/menu') . '" title="' . $alts["restaurants/menu"] . '">' . $resto[0]->name . '</a>';
                                        } else {
                                            echo 'Multi';
                                        }
                                    } else {
                                        echo $value->ordered_by;
                                    }
                                    echo '</td><td>';

                                    if($value->status == "incomplete"){
                                        echo "Incomplete";
                                    } else {
                                        $dateformat = get_date_format();//D M d, g:j A
                                        $date = strtotime($value->order_time);
                                        if (date("dmY", $date) == date("dmY")) {
                                            echo 'Today, ';
                                            $dateformat = str_replace("D M d,", "", $dateformat);
                                        }
                                        echo date($dateformat, $date);
                                    }
                                    echo '</TD><TD><span class="m-a-0 text-muted no_text_break">' . iif($value->order_type, "Delivery", "Pickup") . iif($value->order_till, ' later') . '</span>';
                                    echo '</td>';

                                    if($type!='user'){
                                        if($value->status == "pending" && $value->driver_id){
                                            $value->status = "Waiting for driver to accept";
                                            $waiting=true;
                                        }
                                        echo '<TD><FONT COLOR="' . statuscolor($value->status, true) . '">' . ucfirst($value->status) . '</FONT></td>';

                                        echo '<TD>';
                                        if (Session::get('session_type_user') == "super" || $type=='restaurant' || $type=='driver'){
                                            if ($value->time) {
                                                $class = ' CLASS="timedisplay"';
                                                if(isset($waiting)){
                                                    $delay = (now(true) - strtotime($value->assigned_at));
                                                } else if($value->status == "pending"){
                                                    $delay = (now(true) - strtotime($value->order_time));
                                                } else {
                                                    $delay = (strtotime($value->time) - strtotime($value->order_time));
                                                    $class = "";
                                                }
                                                echo '<FONT' . $class . ' SECONDS="' . $delay . '" COLOR="';
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
                                            }
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
                                       class="pull-right"
                                       onclick="deleteorder({{ $value->id }});">
                                        <i ID="fa{{ $value->id }}" class="fa fa-times"></i>
                                    </a>
                                @endif
                                @if($type == "admin" )
                                    <!--a class="btn btn-secondary-outline btn-sm pull-right" title="{{ $alts["notifyone"] }}"
                                       ONCLICK="notifystore(event, {{ $value->id}});">Notify</a-->
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
    var Orders = "{{ count_iterator($Query) }}";
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

    var OneDay = Number('{{ $secondsper["day"] }}');
    var OneHr = Number('{{ $secondsper["hr"] }}');
    var OneMin = Number('{{ $secondsper["min"] }}');

    setInterval(function(){
        $(".timedisplay").each(function(){
            var self = this; //use $( self )
            var Seconds = Number($( self).attr("seconds"))+1;
            $( self ).attr("seconds", Seconds);

            if (Seconds < 60) {
                $( self ).attr("color", 'GREEN');
            } else if (Seconds < 300) {
                $( self ).attr("color", 'ORANGE');
            } else {
                $( self ).attr("color", 'RED');
            }

            var Days = Math.floor(Seconds / OneDay);
            Seconds = Seconds % OneDay;
            var Hours = Math.floor(Seconds / OneHr);
            Seconds = Seconds % OneHr;
            var Minutes = Math.floor(Seconds / OneMin);
            Seconds = Seconds % OneMin;

            var text = Minutes + " min " + Seconds + " sec";
            if(Hours > 0){text = Hours + " hr " + text;}
            if(Days > 0){text = Days + " days " + text;}

            $( self ).text(text);
        });
    }, 1000);

    function available(event){
        var checked = $(event.target).is(":checked"), value = 0;
        if(checked){value = 1;}
        $("#available-label").hide();
        $("#available-spinner").show();
        $.post("{{ url('user/driverstatus') }}/" + value, {_token: token}, function(result){
            $("#available-label").show();
            $("#available-spinner").hide();
        });
    }
</SCRIPT>