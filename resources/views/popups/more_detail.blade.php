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
                    echo '<p><strong>Phone</strong> <A HREF="tel:' . $restaurant->phone . '">' . phonenumber($restaurant->phone, true) . '</A></p>';

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

                    <p>


                        @if($restaurant["is_delivery"])
                            @if(!$restaurant["is_pickup"])
                                <!--span class="list-inline-item"><strong>Delivery only</strong></span-->
                            @endif
                            <span class="list-inline-item"><strong>Delivery</strong> {{ asmoney($restaurant['delivery_fee'],$free=true) }}</span>
                            <span class="list-inline-item"><strong>Minimum</strong> {{ asmoney($restaurant['minimum'],$free=false) }}</span>
                        @elseif($restaurant["is_pickup"])
                            <!--span class="list-inline-item"><strong>Pickup Only</strong></span-->
                        @endif



                    </p>

                    @if(false)
                        <h3>Tags</h3>
                        <p>{!! (isset($restaurant->tags))?$restaurant->tags:'' !!}</p>
                        <h3>Reviews</h3>
                        <p>{!! rating_initialize((session('session_id'))?"rating":"static-rating", "restaurant", $restaurant->id) !!}</p>
                    @endif
                {!! (isset($restaurant->description)&&$restaurant->description!='')? '<strong>Description</strong><br>'.$restaurant->description .'<br><br>':'' !!}

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

                        echo '<strong>Hours</strong>';


                    echo "<table>";

                    foreach ($days as $day) {
                        echo '<tr><td>' . $day . '&nbsp;</td><td>&nbsp;</td>';
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


                        }

                        echo '</tr>';
                    }

                    echo "</table>";


                    if ($needsdeliveryhours) {
                        echo '<br><strong>Delivery Hours</strong>';
                    }



                    if ($needsdeliveryhours) {
                        echo "<table>";

                        foreach ($days as $day) {
                            echo '<tr><td>' . $day . '</td>';

                            $open_del = getfield($restaurant, $day . "_open_del");
                            $close_del = getfield($restaurant, $day . "_close_del");

                            if ($open == $close) {
                                echo '<td>Closed</td>';
                            } else {
                                echo '<td>' . converttime($open_del) . '';
                                echo ' to ';
                                echo '' . converttime($close_del) . '</td>';
                            }
                            echo"</tr>";
                        }

                        echo "</table>";
                    }




                    ?>


                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" TITLE="Close" TITLE="Close">Close</button>
            </div>
        </div>
    </div>
</div>