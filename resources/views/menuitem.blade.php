<?php
    $alts = array(
            "check" => "This item has been added to your receipt",
            "delete" => "Remove this item from your receipt"
    );
?>
<li class="list-group-item" style="border-top: 1px solid #fafafa !important;">
        <i id="menuitem-check_{{ $value->id }}" class="fa fa-check menucheck" title="{{ $alts["check"] }}"></i>
        <i id="deleteitem-check_{{ $value->id }}" class="fa fa-times menudelete" title="{{ $alts["delete"] }}" onclick="deleteitems({{ $value->id }}, '{{ urlencode($value->menu_item) }}');"></i>
        <SPAN onclick="checkmenuitem(event, {{ $value->id }}, '{{ $value->price }}', '{{ '' }}');">
            @if(debugmode())
                (ID: {{ $value->id }})
            @endif



            {{ $value->menu_item }}


                <span class="pull-right">
            @if($value->price>0)
                ${{number_format(($value->price>0)?$value->price:$min_p,2)}}
            @else
                ${{number_format($min_p,2)}}+
            @endif
                            </SPAN>

                <br>
            <span class="card-text text-muted">{{ $value->description}}</span>
        </SPAN>
</li>













<!--- delete from here ---->




@if($has_iconImage)
    <img src="{{ $item_iconImg }}"
         class="img-circle"
         style="height:24px;width:24px;float:left;margin-right:.5rem;"
         alt="{{ $value->menu_item }}"/>
@endif


@if(false)
    <strike class="text-muted btn btn-sm btn-link"
            style="float: right">${{number_format($value->price,2)}}</strike>
@endif




<?php




if (false) {
    $everyday = '';
    $days = explode(',', $value->days_discount);
    $today = date('D');
    if ($value->has_discount == '1' && in_array($today, $days)) {
        if ($value->days_discount == 'Sun,Mon,Tue,Wed,Thu,Fri,Sat') {
            $everyday = 'everyday';
        } else {
            $everyday = str_replace($today, ',', $value->days_discount);
            $everyday = 'Today and ' . str_replace(',', '/', $everyday);
            $everyday = str_replace('//', '', $everyday);
            $everyday = str_replace(' and /', '', $everyday);
        }
        $discount = $value->discount_per;
        $d = $main_price * $discount / 100;
        $main_price = $main_price - $d;
        $dis = "" . $discount . "% off " . $everyday . "";
    }
}


/*
if (strlen($value->description) > 65) {
echo substr($value->description, 0, 65) . '...';
} else {
echo substr($value->description, 0, 65);
}
*/
?>
@if(false) <!-- no tags yet -->
@if(isset($restaurant->tags) && $restaurant->tags != "")
    <?php
    $tags = $restaurant->tags;
    $tags = explode(',', $tags);
    for ($i = 0; $i < 5; $i++) {
        if (isset($tags[$i])) {
            echo "<span class='tags'>" . $tags[$i] . "</span>";
        }
    }
    ?>
@endif

<!--div class="clearfix">
        rating_initialize((session('session_id'))?"static-rating":"static-rating", "menu", $value->id)
        <p class="card-text m-a-0">
            {{$dis}}
        </p>
    </div-->

<p class="card-text m-a-0 text-muted"> Category:
    <?php
    echo $value->cat_name;

    if ($value->uploaded_on) {
        echo 'Submitted: ' . $value->uploaded_on;
    }

    if ($value->uploaded_by) {
        $uploaded_by = \App\Http\Models\Profiles::where('id', $value->uploaded_by)->get()[0];
        echo "by: " . $uploaded_by->name . "";
    }
    ?>
</p>
@endif