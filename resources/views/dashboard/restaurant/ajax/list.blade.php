<?php
    printfile("views/dashboard/restaurant/ajax/list.blade.php");
    $alts = array(
            "enable" => "Enable this restaurant's ability to accept orders",
            "disable" => "Disable this restaurant's ability to accept orders",
            "enabled" => "This restaurant is accepting orders",
            "disabled" => "This restaurant is not accepting orders",
            "orders" => "View this restaurant's orders",
            "menu" => "View this restaurant's menu",
            "edit" => "Edit this restaurant",
            "incomplete" => "This restaurant is incomplete and can not be opened",
            "logo" => "This restaurant's logo",
            "delete" => "Delete this restaurant",
            "fixmenus" => "Fix old menu item's categories so they show up properly. Only needs to be done once, ever",
            "possess" => "Log in as the owner of this restaurant"
    );
    if(!isset($note)){$note = "";}
?>

@if(\Session::has('message'))
    {!! message_show("Message!", \Session::get('message')) !!}
@endif

<div class="card">
    <div class="card-header ">
        <div class="row">
            <div class="col-lg-9">
                <h4 class="card-title">
                    Restaurants {{ $note }}
                    @if(debugmode() && !$note)
                        <A HREF="?fixmenus" STYLE="float:right;" class="" title="{{ $alts["fixmenus"] }}">Fix menus</A>
                    @endif
                </h4>
            </div>
            @include('common.table_controls')
        </div>
    </div>
    
    <div class="card-block p-a-0">
        <table class="table table-responsive m-b-0">
            <?php
                TH(array( "" => array("sort" => false),"id" => "ID", 'logo' => array("sort" => false), "name", "rating", "status"));
            ?>
            <tbody>
                @if($recCount > 0)
                    @foreach($Query as $key => $value)
                        <?php $logo = defaultlogo($value, true); ?>
                        <tr id="restaurant{{ $value->id }}">

                            <td>
                                <div class="">
                                    <a href="{{ url('restaurants/' . $value->slug . '/menu/') }}" class="" title="{{ $alts["menu"] }}">Menu</a><br>
                                    @if(read("profiletype") == 1)
                                        <a href="{{ url('users/action/user_possess/') . '/' . select_field("profiles", "restaurant_id", $value->id, "id") }}" class="" title="{{ $alts["possess"] }}">Possess</a><br>
                                        <a href="{{ url('orders/list/restaurant/' . $value->id) }}" class="" title="{{ $alts["orders"] }}">Orders</a><br>
                                        <a href="{{ url('restaurant/info/'.$value->id) }}" class="" title="{{ $alts["edit"] }}">Edit</a><br>
                                        <!--a href="{{ url('restaurant/list/delete/'.$value->id) }}" class="btn btn-secondary-outline btn-sm" onclick="return confirm('Are you sure you want to delete {{ addslashes("'" . $value->name . "'") }} ?');">X</a-->
                                        <a class="" id="delete{{ $value->id }}" title="{{ $alts["delete"] }}" onclick="deleterestaurant('{{ $value->id }}', '{{ addslashes("'" . $value->name . "'") }}');">X</a>
                                    @endif
                                </div>
                            </td>
                            
                            
                            <td>{{ $value->id }}</td>
                            <td><img src="{{ $logo }}" width="90" alt="{{ $alts["logo"] }}"/></td>
                            <td>{{ $value->name }}</td>
                            <td NOWRAP>{!! rating_initialize("static-rating", "restaurant", $value->id, true, 'update-rating', false) !!}</td>
                            <td>
                            <div class="">
                                @if(!$value->is_complete)
                                    <a class="btn btn-secondary-outline btn-sm" style="cursor: default;" title="{{ $alts["incomplete"] }}">Incomplete</A><HR CLASS="slimhr">
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
                                @elseif($value->open == true)
                                    <a class="btn btn-secondary-outline btn-sm" style="" title="{{ $alts["enabled"] }}">Enabled</A>
                                    @if(read("type_user") == "super")
                                        <a href="{{ url('restaurant/list/status/'.$value->id) }}" class="btn btn-warning btn-sm" title="{{ $alts["disable"] }}"
                                            onclick="return confirm('Are you sure you want to disable {{ addslashes("'" . $value->name . "'") }} ?');">Disable</a>
                                    @endif
                                @else
                                    @if(read("type_user") == "super")
                                        <a href="{{ url('restaurant/list/status/'.$value->id) }}" class="btn  btn-success btn-sm" title="{{ $alts["enable"] }}"
                                            onclick="return confirm('Are you sure you want to enable {{ addslashes("'" . $value->name . "'") }} ?');">Enable</a>
                                    @endif
                                    <a class="btn btn-secondary-outline btn-sm" style="" title="{{ $alts["disabled"] }}">Disabled</A>
                                @endif
                                </div>                                
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

    @if((Session::get('session_type_user') == "super" || read("profiletype") == 3)  && $recCount > 10)
        <div class="card-footer clearfix">{!! $Pagination !!}    </div>
    @endif
</div>
<SCRIPT>
    var Restaurants = '{{ $recCount }}';
    function deleterestaurant(ID, Name){
        if(confirm('Are you sure you want to delete restaurant "' + Name + '"?')) {
            $("#delete" + ID).html('<i class="fa fa-spinner fa-spin"></i>');
            $.post("{{ url('restaurant/list/delete') }}/" + ID, {_token: "{{ csrf_token() }}"}, function (result) {
                Restaurants=Restaurants-1;
                if(Restaurants) {
                    $("#restaurant" + ID).fadeOut();
                } else {
                    $("#loadPageData").html(result);
                }
            });
        }
    }
</SCRIPT>