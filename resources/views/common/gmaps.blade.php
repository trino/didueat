<?php printfile("view/common/gmaps.blade.php<BR>"); ?>
@if(isset($address) && !empty($address))

    <div id="gmap_display" style="height:100%; width:100%;max-width:100%;">
        <iframe style="height:100%;width:100%;border:0;" frameborder="0" src="https://www.google.com/maps/embed/v1/place?q={{ $address }}&key=AIzaSyAN0om9mFmy1QN6Wf54tXAowK4eT0ZUPrU"></iframe>
    </div>
@else
    No address is on file
@endif