<?php
    function offsettime($time, $hours = 0) {
        if ($hours) {
            $time = explode(":", $time);
            $time[0] = $time[0] + $hours;
            if ($time[0] < 0) {
                $time[0] += 24;
            }
            if ($time[0] > 23) {
                $time[0] -= 24;
            }
            $time = implode(":", $time);
        }
        return $time;
    }

    if(isset($data)){
        if (debugmode()) {
            echo "Debugging here: ";
            var_dump($data);
        }
        foreach($data as $key => $value){
            $$key = $value;
            $_POST[$key] = $value;
        }
    }

    $server_gmt = date('Z') / 3600;
    $user_gmt = \Session::get('session_gmt', $server_gmt);
    $difference = $server_gmt - $user_gmt;
    $server_time = date('H:i:s');
    $user_time = $server_time;
    if(!isset($sql)){$sql = "MISSING SQL";}
    printfile("<BR>" . $sql . "<BR>views/ajax/search_restaurants.blade.php");
    if (is_object($count)) {
        echo "Count should not be an object!!!";
        return;
    }

    echo '<div id="restuarant_bar">';

    $totalCnt = 0;
    $openCnt = 0;
    $closedCnt = 0;
    $openStr = "";
    $closedStr = "";

    if(isset($query) && $count > 0 && is_iterable($query)){
        $restaurants = array();
        foreach($query as $value){
            if(!isset($restaurants[$value["id"]])){
                $restaurants[$value["id"]] = true;
                $is_open = \App\Http\Models\Restaurants::getbusinessday($value);
                $thisrestaurant = '<div class="list-group">' . view("dashboard.restaurant.restaurantpanel", array("Restaurant" => $value, "order" => true, "is_menu" => isset($is_menu))) . '</div>';
                if ($is_open) {
                    $openStr .= $thisrestaurant;
                    $openCnt++;
                } else {
                    $closedStr .= $thisrestaurant;
                    $closedCnt++;
                }
                $totalCnt++;
            }
        }
    }

    if ($openStr) {echo '<div class="open-stores">' . $openStr . '</div>';}
    if ($closedStr) {echo '<div class="closed-stores">' . $closedStr . '</div>';}

    $alts = array(
            "loadmore" => "Load more restaurants",
            "loading" => "Loading..."
    );

    echo '</div>';
    $totalCnt=$count;
?>

@if(isset($data) && $data["start"] < 20)
<script>
    var totalCnt = <?= $totalCnt . ";
         var openCnt = " . $openCnt . ";
         var closedCnt = " . $closedCnt . ";";
    ?>
    var openCntMsg = "";
    var closedCntMsg = "";
    var spBR = "";
    if (openCnt != totalCnt) {
        if (openCnt < totalCnt && closedCnt < totalCnt) {
            spBR = " ";
            openCntMsg = openCnt + " Open";
            closedCntMsg = " and " + closedCnt + " Closed";
        } else if (closedCnt == totalCnt) {
            //closedCntMsg="Sorry, but all restaurants are currently closed. In the meantime, you can view the restaurants, and place your order when they are open";
        }
        //document.getElementById('openClosed').innerHTML = spBR + "" + openCntMsg + closedCntMsg + "";
        var original = $("#countRows").text();
        if(isNaN(original)){original = 0;}
        totalCnt = totalCnt + Number(original);
        $("#countRows").text(totalCnt);
        if (totalCnt) {
            $("#countRowsS").text("s");
        }
    }
</script>
@endif

<div id="loadMoreBtnContainer">
    @if($hasMorePage > 0)
        <div class="row">
            <div class="col-md-12 text-xs-center">
                <button style="width: 120px;
  height: 120px;
  line-height:120px; /* adjust line height to align vertically*/
  padding:0;
  border-radius: 50%;" id="loadingbutton" data-id="{{ $start }}" align="center"
                        class="loadMoreRestaurants btn btn-secondary btn-lg m-b-1"
                        title="{{ $alts["loadmore"] }}">Load More
                </button>
                <img class="loadingbar" src="{{ asset('assets/images/loader.gif') }}" style="display: none;" alt="{{ $alts["loading"] }}"/>
            </div>
        </div>
    @endif
    <input type="hidden" id="countTotalResult" value="{{ $count }}"/>
</div>
<img id='parentLoadingbar' src="{{ asset('assets/images/loader.gif') }}" style="display: none;" alt="{{ $alts["loading"] }}"/>