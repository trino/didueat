<!-- add addresss modal -->
<div class=" modal  fade clearfix" id="viewMapModel" tabindex="-1" role="dialog" aria-labelledby="viewMapModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="viewMapModelLabel">More Detail</h4>
            </div>
            <div class="modal-body">
                <?php printfile("view/popups/more_detail.blade.php"); ?>
                <div style="height:500px;max-width:100%;list-style:none; transition: none;overflow:hidden;">
                    <div id="gmap_display" style="height:100%; width:100%;max-width:100%;">
                        @if(!empty($restaurant->formatted_address))
                            <iframe style="height:100%;width:100%;border:0;" frameborder="0"
                                    src="https://www.google.com/maps/embed/v1/place?q={{ $restaurant->formatted_address }}&key=AIzaSyAN0om9mFmy1QN6Wf54tXAowK4eT0ZUPrU"></iframe>
                        @endif
                    </div>
                </div>
                <br>

                <h4>Description: </h4>
                <p>{!! (isset($restaurant->description))?$restaurant->description:'' !!}</p>

                <h4>Hours: </h4>
                <TABLE WIDTH="100%">
                    <?php
                        $days = getweekdays();
                        $needsdeliveryhours = false;
                        if ($restaurant->is_delivery){
                            foreach ($days as $day) {
                                $open = getfield($restaurant, $day . "_open");
                                $close = getfield($restaurant, $day . "_close");
                                if ($open != $close){
                                    if($open <> getfield($restaurant, $day . "_open_del") || $close <> getfield($restaurant, $day . "_close_del")){
                                        $needsdeliveryhours=true;
                                        break;
                                    }
                                }
                            }
                        }
                        if($needsdeliveryhours){
                            echo '<TR><TD></TD><TD COLSPAN="3" ALIGN="center"><strong>Pickup Hours</strong></TD><TD COLSPAN="2" ALIGN="center"><strong>Delivery Hours</strong></TD></TR>';
                        }
                        foreach ($days as $day) {
                            echo '<TR><TD>' . $day . '</TD>';
                            $open = getfield($restaurant, $day . "_open");
                            $close = getfield($restaurant, $day . "_close");
                            if($open == $close){
                                echo '<TD COLSPAN="5" ALIGN="center"><B>Closed</B></TD>';
                            } else {
                                echo '<TD align="right">' . converttime($open) . '</TD>';
                                echo '<TD align="right">' . converttime($close) . '</TD>';
                                if($needsdeliveryhours){
                                    echo '<TD align="right">' . converttime(getfield($restaurant, $day . "_open_del")) . '</TD>';
                                    echo '<TD align="center">to</TD>';
                                    echo '<TD align="right">' . converttime(getfield($restaurant, $day . "_close_del")) . '</TD>';
                                }
                            }
                            echo '</TR>';
                        }
                    ?>
                </TABLE>

                @if(false)
                    <h3>Tags: </h3>
                    <p>{!! (isset($restaurant->tags))?$restaurant->tags:'' !!}</p>

                    <h3>Reviews: </h3>
                    <p>{!! rating_initialize((session('session_id'))?"rating":"static-rating", "restaurant", $restaurant->id) !!}</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
