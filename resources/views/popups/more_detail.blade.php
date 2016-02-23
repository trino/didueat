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
                <div style="height:200px;max-width:100%;list-style:none; transition: none;overflow:hidden;">
                    @include("common.gmaps", array("address" => $restaurant->formatted_address))
                </div>

                <?php
                    $Today = \App\Http\Models\Restaurants::getbusinessday($restaurant);
                    echo "<p><strong>Hours</strong> " . converttime(getfield($restaurant, $Today . "_open")) . " - " . converttime(getfield($restaurant, $Today . "_close")) . "</p>";
                    echo '<p><strong>Phone</strong> ' . $restaurant->phone . '</p>';

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
                ?>

                @if (Session::get('session_type_user') == "super" )
                    <p>
                        <strong class="">Views</strong> {!! (isset($total_restaurant_views))?$total_restaurant_views:0 !!}
                    </p>
                @endif

                <p>{!! (isset($restaurant->description)&&$restaurant->description!='')? '<h4>Description</h4>'.$restaurant->description:'' !!}</p>

                <h4>Hours: </h4>

                <?php
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

                    $needsdeliveryhours=false;
                    if ($needsdeliveryhours) {
                        echo '<div class="col-md-5 col-md-offset-2" align="center"><strong>Pickup Hours</strong></div>';
                        echo '<div class="col-md-5" align="left"><strong>Delivery Hours</strong></div>';
                    } else {
                        echo '<div class="col-md-10 col-md-offset-2" align="center"><strong>Pickup/Delivery Hours</strong></div>';
                    }
                    foreach ($days as $day) {
                        echo '<div class="col-md-2">' . $day . '</DIV>';
                        $open = getfield($restaurant, $day . "_open");
                        $close = getfield($restaurant, $day . "_close");
                        $open_del = getfield($restaurant, $day . "_open_del");
                        $close_del = getfield($restaurant, $day . "_close_del");
                        if ($open == $close) {
                            echo '<div class="col-md-10" ALIGN="center"><strong>Closed</strong></DIV>';
                        } else {
                            echo '<div class="col-md-2 nowrap" align="left">' . converttime($open) . '</div>';
                            echo '<div class="col-md-1" align="center">to</div>';
                            echo '<div class="col-md-2 nowrap" align="left">' . converttime($close) . '</div>';
                            if ($needsdeliveryhours) {
                                echo '<div class="col-md-2 nowrap" align="left">' . converttime($open_del) . '</div>';
                                echo '<div class="col-md-1" align="center">to</div>';
                                echo '<div class="col-md-2 nowrap" align="left">' . converttime($close_del) . '</div>';
                            } else {
                                echo '<div class="col-md-5">&nbsp;</div>';
                            }
                        }
                        echo '</TR>';
                    }
                ?>

                @if(false)
                    <h3>Tags</h3>
                    <p>{!! (isset($restaurant->tags))?$restaurant->tags:'' !!}</p>
                    <h3>Reviews</h3>
                    <p>{!! rating_initialize((session('session_id'))?"rating":"static-rating", "restaurant", $restaurant->id) !!}</p>
                @endif

                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>