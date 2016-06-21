<?php
    $main_price = $value->price;
    $dis = '';
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
?>

<span>
    <div style="width: 100%;float:left;vertical-align: middle;" onclick="checkmenuitem(event, {{ $value->id }}, '{{ $main_price }}', '{{ $dis }}');">
        @if($has_iconImage)
            <img src="{{ $item_iconImg }}"
                 class="img-circle"
                 style="height:24px;width:24px;float:left;margin-right:.5rem;"
                 alt="{{ $value->menu_item }}"/>
        @endif

        <i id="menuitem-check_{{ $value->id }}" class="fa fa-check" style="display:none;color:green;"></i>

        @if(debugmode())
            (ID: {{ $value->id }})
        @endif

        {{ $value->menu_item }}


        <span style="white-space: nowrap" class="pull-right">
            @if($main_price>0)
                ${{number_format(($main_price>0)?$main_price:$min_p,2)}}
            @else
                ${{number_format($min_p,2)}}+
            @endif

            @if($dis)
                <strike class="text-muted btn btn-sm btn-link" style="float: right">${{number_format($value->price,2)}}</strike>
            @endif
        </span>
    </div>
</span>

<p class="card-text m-a-0  text-muted">
    <?php
        echo $value->description;
        /*
        if (strlen($value->description) > 65) {
            echo substr($value->description, 0, 65) . '...';
        } else {
            echo substr($value->description, 0, 65);
        }
        */
    ?>
</p>

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

            if($value->uploaded_on){
                echo 'Submitted: ' . $value->uploaded_on;
            }

            if ($value->uploaded_by) {
                $uploaded_by = \App\Http\Models\Profiles::where('id', $value->uploaded_by)->get()[0];
                echo "by: " . $uploaded_by->name . "";
            }
        ?>
    </p>
@endif
