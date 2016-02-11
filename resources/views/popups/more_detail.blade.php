<!-- add addresss modal -->
<div class=" modal  fade clearfix" id="viewMapModel" tabindex="-1" role="dialog" aria-labelledby="viewMapModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="viewMapModelLabel">Add Addresss</h4>
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

                <h3>Description: </h3>
                <p>{!! (isset($restaurant->description))?$restaurant->description:'' !!}</p>

                <h3>Hours: </h3>
                <TABLE WIDTH="100%">
                    <?php
                    $days = getweekdays();
                    foreach ($days as $day) {
                        echo '<TR><TD>' . $day . '</TD><TD align="right">' . converttime(getfield($restaurant, $day . "_open")) . '</TD><TD align="right">';
                        echo converttime(getfield($restaurant, $day . "_close")) . '</TD></TR>';
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
