<?php
    $alts["check"] = "This item has been added to your receipt";
    $alts["delete"] = "Remove this item from your receipt";
?>
<li class="list-group-item" style="border-top: 1px solid #f7f7f7 !important;">
    <i id="menuitem-check_{{ $value->id }}" class="fa fa-check menucheck" title="{{ $alts["check"] }}"></i>
    <i id="deleteitem-check_{{ $value->id }}" class="fa fa-times menudelete" title="{{ $alts["delete"] }}" onclick="deleteitems({{ $value->id }}, '{{ urlencode($value->menu_item) }}');"></i>
    <div style="width: 100%;height:100%;">
        <SPAN  onclick="checkmenuitem(event, {{ $value->id }}, '{{ $value->price }}', '{{ '' }}');">
            @if(debugmode())
                (ID: {{ $value->id }})
            @endif

            ~~  <SPAN ID="itemtitle{{ $value->id }}">{{ $value->menu_item }}</SPAN>

            <span class="pull-right">
                @if($value->price>0)
                    ${{number_format(($value->price>0)?$value->price:$min_p,2)}}
                @else
                    ${{number_format($min_p,2)}}+
                @endif
            </SPAN>
            <br>
            <span class="card-text text-muted">~~{{ $value->id}}~~{{ $value->description}}</span>
        </SPAN>

        @if($allowedtoupload)
            <div>Edit Tools:
            <div class="pull-right">
                <A TITLE="{{ $alts["duplicate"] }}" class="btn btn-sm btn-link"
                   onclick="confirmcopy('{{ url("restaurant/copyitem/category/" . $value->cat_id) }}', 'category', '{{ $value->cat_name }}');">
                    <i class="fa fa-files-o"></i>
                </A>

                <a title="{{ $alts["up_cat"] }}" class="btn btn-sm btn-link"
                   id="up{{ $thisCatCnt }}" style="visibility:{{ $thisUpCatSort }} !important"
                   href="#" onclick="chngCatPosn({{ $thisCatCnt }},'up');return false">
                    <!-- <a title="{{ $alts["up_cat"] }}" class="btn btn-sm btn-secondary" disabled="" href=" <?= url("restaurant/orderCat2/" . $value->cat_id . "/up");?>"> -->
                    <i class="fa fa-arrow-up"></i>
                </a>

                <a title="{{ $alts["down_cat"] }}" class="btn btn-sm btn-link"
                   id="down{{ $thisCatCnt }}"
                   style="visibility:{{ $thisDownCatSort }} !important"
                   href="#" onclick="chngCatPosn({{ $thisCatCnt }},'down');return false">
                    <!-- <a title="{{ $alts["down_cat"] }}" class="btn btn-sm btn-secondary" href="<?= url("restaurant/orderCat2/" . $value->cat_id . "/down");?>"> -->
                    <i class="fa fa-arrow-down"></i>
                </a>

                <A title="{{ $alts["deletecat"] }}" class="btn btn-sm btn-link pull-right"
                   onclick="deletecategory({{ $value->cat_id . ", '" . addslashes($value->cat_name) . "'"}});">
                    <i class="fa fa-times"></i>
                </A>

                <A title="{{ $alts["editcat"] }}" class="btn btn-sm btn-link pull-right"
                   data-toggle="modal"
                   data-target="#editCatModel" data-target-id="{{ $value->cat_id }}"
                   onclick="editcategory({{ $value->cat_id . ", '" . addslashes($value->cat_name) . "'"}});">
                    <i class="fa fa-pencil"></i>
                </A>
            </div>
            </div>
        @endif
    </div>


</li>


@if($has_iconImage)
    <img src="{{ $item_iconImg }}" class="img-circle" style="height:24px;width:24px;float:left;margin-right:.5rem;" alt="{{ $value->menu_item }}"/>
@endif

@if(false)
    <strike class="text-muted btn btn-sm btn-link" style="float: right">${{number_format($value->price,2)}}</strike>
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