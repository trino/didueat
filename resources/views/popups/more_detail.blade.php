<!-- add addresss modal -->
<div class=" modal clearfix" id="viewMapModel" tabindex="-1" role="dialog" aria-labelledby="viewMapModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="viewMapModelLabel">{{$restaurant->name}}</h4>
            </div>
            <div class="modal-body">
                <?php printfile("view/popups/more_detail.blade.php"); ?>
                <div style="height:300px;max-width:100%;list-style:none; transition: none;overflow:hidden;">
                    @include("common.gmaps", array("address" => $restaurant->formatted_address))
                </div>
                    <br>
                    <p> <strong>Address </strong>
                        {!! (isset($restaurant->address))?$restaurant->address.',':'' !!}
                        {!! (isset($restaurant->city))?$restaurant->city.', ':'' !!}
                        {!! (isset($restaurant->province))? 'ON':'' !!}
                        {!! (isset($restaurant->postal_code))?$restaurant->postal_code.' ':'' !!}
                    </p>

                <?php
                    $Today = \App\Http\Models\Restaurants::getbusinessday($restaurant);
                //    echo "<p><strong>Hours</strong> " . converttime(getfield($restaurant, $Today . "_open")) . " - " . converttime(getfield($restaurant, $Today . "_close")) . "</p>";
                    echo '<p><strong>Phone</strong> ' . $restaurant->phone . '</p>';

                        /*
                    if($restaurant->is_delivery){
                        $open = getfield($restaurant, $Today . "_open");
                        $close = getfield($restaurant, $Today . "_close");

                        echo "<p><strong>Delivery</strong> ";
                        if ($open != $close) {
                            echo converttime(getfield($restaurant, $Today . "_open_del")) . " - " . converttime(getfield($restaurant, $Today . "_close_del")) . "</p>";
                        } else {
                            echo "Closed";
                        }

                        echo '<input type="hidden" id="minimum_delivery" value="' . $restaurant->minimum . '"/>';
                    }
                        */
                ?>

                @if (Session::get('session_type_user') == "super" )
                    <p>
                        <strong class="">Views</strong> {!! (isset($total_restaurant_views))?$total_restaurant_views:0 !!}
                    </p>
                @endif

                    @if(false)
                        <h3>Tags</h3>
                        <p>{!! (isset($restaurant->tags))?$restaurant->tags:'' !!}</p>
                        <h3>Reviews</h3>
                        <p>{!! rating_initialize((session('session_id'))?"rating":"static-rating", "restaurant", $restaurant->id) !!}</p>
                    @endif
                <p>{!! (isset($restaurant->description)&&$restaurant->description!='')? '<h4>Description</h4>'.$restaurant->description:'' !!}</p>

                <?php
                    $needsdeliveryhours=false;

                    $days = getweekdays();
                    $needsdeliveryhours = false;
                    if ($restaurant->is_delivery) {
                        foreach ($days as $day) {
                            $open = getfield($restaurant, $day . "_open");
                            $close = getfield($restaurant, $day . "_close");
                            if ($open != $close) {
                                if ($open <> getfield($restaurant, $day . "_open_del") || $close <> getfield($restaurant, $day . "_close_del")) {
                                    $needsdeliveryhours = true;
                                    break;
                                }
                            }
                        }
                    }

                    if ($needsdeliveryhours) {
                        echo '<strong>Pickup Hours</strong>';
                    } else {
                        echo '<strong>Pickup/Delivery Hours</strong>';
                    }


echo "<table>";






                    foreach ($days as $day) {
                        echo '<tr><td>' . $day . '&nbsp;</td>';
                        $open = getfield($restaurant, $day . "_open");
                        $close = getfield($restaurant, $day . "_close");
                        $open_del = getfield($restaurant, $day . "_open_del");
                        $close_del = getfield($restaurant, $day . "_close_del");

                        if ($open == $close) {
                            echo '<td>Closed</td>';
                        } else {
                            echo '<td>' . converttime($open) . '';
                            echo ' to ';
                            echo ' ' . converttime($close) . '</td>';

                            if ($needsdeliveryhours) {
                                echo '<td>' . converttime($open_del) . '';
                                echo ' to ';
                                echo '' . converttime($close_del) . '</td>';
                            } else {
                                echo '';
                            }

                        }

                        echo '</tr>';
                    }

                    echo "</table>";
                ?>


                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>