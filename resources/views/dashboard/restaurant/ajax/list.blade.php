{{ printfile("views/dashboard/restaurant/ajax/list.blade.php") }}

@if(\Session::has('message'))
    {!! message_show("Message!", \Session::get('message')) !!}
@endif

<div class="card">
    <div class="card-header ">
        <div class="row">
            <div class="col-lg-9">
                <h4 class="card-title">
                    Restaurants

                    <?php
                        $incomplete = isset($_GET["incomplete"]);
                        echo '<a class="btn btn-primary btn-sm" ';
                        //href="{{ url('restaurant/list') }}">Add
                        if($incomplete){
                            echo 'HREF="' . url('/restaurant/list') . '">All';
                        } else {
                            echo 'HREF="' . url('/restaurant/list?incomplete') . '">Incomplete';
                        }
                        echo '</a>';
                    ?>
                </h4>
            </div>
            @include('common.table_controls')
        </div>
    </div>

    <div class="card-block p-a-0">
        <table class="table table-responsive m-b-0">
            <?php
                if($incomplete){
                    TH(array("id" => "ID", "name", "reasons" => array("sort" => false), "" => array("sort" => false)));
                } else {
                    TH(array("id" => "ID", 'logo' => array("sort" => false), "name", "rating", "status", "" => array("sort" => false)));
                }
            ?>
            <tbody>
                @if($recCount > 0)
                @foreach($Query as $key => $value)
                <?php $resLogo = (isset($value->logo) && $value->logo != "") ? 'restaurants/' . $value->id . '/thumb_' . $value->logo : 'default.png'; ?>
                <tr>
                    <td>{{ $value->id }}</td>
                    @if(!$incomplete)
                        <td><img src="{{ asset('assets/images/'.$resLogo) }}" width="90"/></td>
                    @endif
                    <td>{{ $value->name }}</td>

                    @if($incomplete)
                        <TD>
                            <?php
                                $reasons = array();
                                if(!$value->has_creditcard){
                                    //$reasons["fa-credit-card"] = "Missing Credit Card information";
                                }
                                if(!$value->is_delivery){
                                    $reasons["fa-car"] = "Delivery is disabled";
                                }
                                if(!$value->is_pickup){
                                    $reasons["fa-bicycle"] = "Pickup is disabled";
                                }
                                if (!$value->latitude || !$value->longitude) {
                                    $reasons["fa-envelope"] = "Missing address";
                                }
                                if ($value->max_delivery_distance < 2 && $value->is_delivery) {
                                    $reasons["fa-hand-lizard-o"] = "Maximum delivery distance might be too small";
                                }
                                if (!$value->minimum || $value->minimum == "0.00") {
                                    $reasons["fa-usd"] = "Minimum delivery charge might be missing";
                                }
                                //check hours of operation
                                $weekdays = getweekdays();
                                $someHoursNotOK = false; // to encourage restaurant to finish setting up hours
                                $DayOfWeek = current_day_of_week();
                                $now = date('H:i:s');
                                foreach ($weekdays as $weekday) {
                                    foreach (array("_close", "_close_del") as $field) { // only the close needs to be checked, as 12:00 is often an opening time
                                        $field = $weekday . $field;
                                        if ($value->$field != "12:00:00" && $value->$field != "00:00:00") {
                                            $weekdays = false;
                                        } else {
                                            $someHoursNotOK = true;
                                        }
                                    }
                                }
                                if ($weekdays || $someHoursNotOK) {
                                    $reasons["fa-clock-o"] = "Hours of operations";
                                }

                                foreach($reasons as $icon => $title){
                                    if(is_numeric($icon)){
                                        echo $title;
                                    } else {
                                        echo '<i class="fa ' . $icon . '" title="' . $title . '"></i>&nbsp;';
                                    }
                                }
                            ?>
                        </TD>
                    @else
                        <td NOWRAP>{!! rating_initialize("static-rating", "restaurant", $value['id'], true, 'update-rating', false) !!}</td>
                        <td>
                            @if($value->open == true)
                                <a class="btn btn-secondary-outline btn-sm" style="cursor: default;">Enabled</A>
                                    <a href="{{ url('restaurant/list/status/'.$value->id) }}" class="btn btn-warning btn-sm"
                                   onclick="return confirm('Are you sure you want to disable {{ addslashes("'" . $value->name . "'") }} ?');">Disable</a>
                            @else
                                <a href="{{ url('restaurant/list/status/'.$value->id) }}" class="btn  btn-success btn-sm"
                                   onclick="return confirm('Are you sure you want to enable {{ addslashes("'" . $value->name . "'") }} ?');">Enable</a>
                                <a class="btn btn-secondary-outline btn-sm" style="cursor: default;">Disabled</A>
                            @endif
                        </td>
                    @endif

                    <td>
                        @if(!$incomplete)
                            <a href="{{ url('orders/list/restaurant/' . $value['id']) }}" class="btn btn-info btn-sm">Orders</a>
                            <a href="{{ url('restaurants/' . $value->slug . '/menu/') }}" class="btn btn-info btn-sm">Menu</a>
                        @endif
                        <a href="{{ url('restaurant/info/'.$value->id) }}" class="btn btn-info btn-sm">Edit</a>
                        <a href="{{ url('restaurant/list/delete/'.$value->id) }}" class="btn btn-secondary-outline btn-sm" onclick="return confirm('Are you sure you want to delete {{ addslashes("'" . $value->name . "'") }} ?');">X</a>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td><span class="text-muted">No Restaurants Found</span></td>
                </tr>
                @endif
            </tbody>
        </table>

    </div>

    @if(Session::get('session_type_user') == "super"  && $recCount > 10)


    <div class="card-footer clearfix">
        {!! $Pagination !!}    </div>
        @endif
</div>