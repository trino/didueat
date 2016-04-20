<?php
printfile("views/menus.blade.php");
$alts = array(
        "product-pop-up" => "Product info",
        "up_cat" => "Move Category up",
        "down_cat" => "Move Category down",
        "up_parent" => "Move this up",
        "down_parent" => "Move this down",
        "deleteMenu" => "Delete this item",
        "edititem" => "Edit this item"
);

$menuTSv = "?i=";
$menuTS = read('menuTS');
if ($menuTS) {
    $menuTSv = "?i=" . $menuTS;
    Session::forget('session_menuTS');
}

$prevCat = "";
$catNameStr = [];
$parentCnt = [];
$thisCatCnt = 0;
$itemPosnForJS = [];
// $catCnt set in restaurants-menus.blade
?>

<script>
    var catPosn = [];
    var itemPosn = [];
    var restSlug = "{{ $restaurant->slug }}";
</script>

@if(!isset($_GET['page']))
    <div id="loadmenus_{{ (isset($catid))?$catid:0 }}">
        @endif

        <?php
        $menus_listA = [];
        $menus_sortA = [];
        $cats_listA = [];
        $cats_listA2 = [];
        $thisCnt = 0;

        foreach ($menus_list as $value) {
            $catsListCnt = 0;
            foreach ($cats as $row) {
                if ($row == $value->cat_id) {
                    $menus_listA[$thisCnt] = $value;
                    $cats_listA[$row] = $catsOrder[$catsListCnt];
                    $menus_sortA[$row][$thisCnt] = $value->display_order;
                    $thisCnt++;
                    break;
                }
                $catsListCnt++;
            }
        }

        asort($cats_listA);

        foreach ($cats_listA as $key => $row) {
            asort($menus_sortA[$key]);
            foreach ($menus_sortA[$key] as $key2 => $row2) {
                $cats_listA2[$key2] = $row;
            }
        }


        $valueA = [];
        $catIDNum = [];
        $cnt2 = 0;
        while (list($key, $thisOrder) = each($cats_listA2)) {
            $valueA[$cnt2] = $menus_listA[$key]; // this contains full menus list for resto
            $catIDNum[$cnt2] = $menus_listA[$key]->cat_id;
            $cnt2++;
        }

        ?>

        @while(list($index,$value) = each($valueA))

            <?php
            $noUpCatSort = false;
            $thisUpMenuVisib = "show";
            $thisDownMenuVisib = "show";
            $parentCnt[$thisCatCnt] = $value->id; // for js sorting with ajax, not implemented yet
            $itemPosnForJS[$value->cat_id][$value->id] = $value->display_order;
            $catPosn[] = $thisCatCnt;
            if ($prevCat == "") {
                $noUpCatSort = true;
            }

            if ($index < ($thisCnt - 1)) { // means it's not the last item
                $nextIndx = ($index + 1);
                if ($value->cat_id != $catIDNum[$nextIndx]) {
                    $thisDownMenuVisib = "none";
                }
            } else {
                $thisDownMenuVisib = "none"; // last item in array
            }

            //echo "\$prevCat: ".$prevCat."  --  \$index: ".$index."  --  \$nextIndx: ".$nextIndx."  -- totalItems-1: ".($thisCnt-1)."  --  cat_id: ".$value->cat_id."  --   next CatID: ".$catIDNum[$nextIndx]."  --  ".$value->menu_item."  --  ".$value->display_order;

            if($value->cat_id != $prevCat){ // means it's a new category
            $thisUpMenuVisib = "none";
            $catMenuCnt = 0; // reset count for this category
            if ($prevCat) {
                echo '</div><!-- end of previous category -->';
            }
            $prevCat = $value->cat_id; // also used as current cat_id until next loop

            $catNameStr[$prevCat] = $value->cat_name;
            ($noUpCatSort) ? $thisUpCatSort = "none" : $thisUpCatSort = "show";
            ($thisCatCnt >= ($catCnt - 1)) ? $thisDownCatSort = "none" : $thisDownCatSort = "show";


            if (!read('id')) {

                $thisUpCatSort = 'none';
                $thisDownCatSort = 'none';
                $thisDownMenuVisib = 'none';
                $thisUpMenuVisib = 'none';
            }
            ?>

            <DIV class="list-group m-b-1" id="c{{ $thisCatCnt }}"><!-- start of this category -->
                <div class="list-group-item parents" style="background: #f5f5f5;"><!-- start of category heading -->
                    <div class="">
                        <div class="row">
                            <div class="col-xs-10">
                                <a href="#" name="<?php echo $value->cat_name; ?>"></a>
                                <h4 class="card-title"><?= $value->cat_name;?></h4>
                            </div>


                            <div class="col-xs-2">
                                <div class="pull-right" aria-label="Basic example">
                                    <a title="{{ $alts["up_cat"] }}" class="btn btn-sm btn-link"
                                       id="up{{ $thisCatCnt }}" style="display:{{ $thisUpCatSort }} !important"
                                       href="#" onclick="chngCatPosn({{ $thisCatCnt }},'up');return false">
                                        <!-- <a title="{{ $alts["up_cat"] }}" class="btn btn-sm btn-secondary" disabled="" href="<?= url("restaurant/orderCat2/" . $value->cat_id . "/up");?>"> -->
                                        <i class="fa fa-arrow-up"></i>
                                    </a>

                                    <a title="{{ $alts["down_cat"] }}" class="btn btn-sm btn-link"
                                       id="down{{ $thisCatCnt }}" style="display:{{ $thisDownCatSort }} !important"
                                       href="#" onclick="chngCatPosn({{ $thisCatCnt }},'down');return false">
                                        <!-- <a title="{{ $alts["down_cat"] }}" class="btn btn-sm btn-secondary" href="<?= url("restaurant/orderCat2/" . $value->cat_id . "/down");?>"> -->
                                        <i class="fa fa-arrow-down"></i>
                                    </a>
                                </div>

                            </div>

                            <div class="col-md-6" id="save{{ $thisCatCnt }}" style="display:none;color:#f00"><input
                                        name="saveOrderChng" type="button" value="Save All Category Order Changes"
                                        onclick="saveCatOrderChngs({{ $thisCatCnt }})"/><span
                                        id="saveCatOrderMsg{{ $thisCatCnt }}"></span></div>

                            <div class="col-md-6 pull-right" id="saveMenus{{ $value->cat_id }}"
                                 style="display:none;color:#f00"><input name="saveOrderChng" type="button"
                                                                        value="Save Category Sorting"
                                                                        onclick="saveMenuOrder({{ $value->cat_id }},false,false)"/><span
                                        id="saveMenuOrderMsg{{ $value->cat_id }}"></span></div>

                        </div>

                    </div>
                </div>
                <!-- end of category heading -->

                <?php
                $thisCatCnt++;
                }



                //load images, duplicate code

                $has_iconImage = false;

                if ($value->image != '' && file_exists(public_path('assets/images/restaurants/' . $value->restaurant_id . '/menus/' . $value->id . '/icon-' . $value->image))) {
                    $item_iconImg = asset('assets/images/restaurants/' . $value->restaurant_id . '/menus/' . $value->id . '/icon-' . $value->image) . $menuTSv;
                    $has_iconImage = true;
                }

                $has_bigImage = false;
                if ($value->image != '' && file_exists(public_path('assets/images/restaurants/' . $value->restaurant_id . '/menus/' . $value->id . '/big-' . $value->image))) {
                    $item_bigImage = asset('assets/images/restaurants/' . $value->restaurant_id . '/menus/' . $value->id . '/big-' . $value->image) . $menuTSv;
                    $has_bigImage = true;
                }

                $submenus = \App\Http\Models\Menus::where('parent', $value->id)->orderBy('display_order', 'ASC')->get();
                $min_p = get_price($value->id);

                $canedit = read("profiletype") == 1 || (read("profiletype") == 3 && $value->uploaded_by == read("id"));
                ?>

                <div class="list-group-item parents" id="parent{{ $value->cat_id }}_{{ $value->display_order }}">
                    <!-- start of menu item -->
                    <div>
                        <div class="row">
                            <div class="col-md-12"><!-- start div 4 -->

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

                                <h5 class="card-title" style="">

                                    <div class="" style="width: 100%;float:left;vertical-align: middle;">

                <a
style="line-height:30px;"
                        href="#" id="{{ $value->id }}" name="{{ $value->id }}"
                   data-res-id="{{ $value->restaurant_id }}"
                   title="{{ $alts["product-pop-up"] }}"
                   class="card-link" data-toggle="modal"
                   data-target="{{ (Request::is('restaurants/*')) ? '#product-pop-up_' . $value->id : url('restaurants/' . select_field('restaurants', 'id', $value->restaurant_id, 'slug') . '/menu') }}">

                                            @if($has_iconImage)
                                                <img src="{{ $item_iconImg }}"
                                                     class="img-circle" style="height:30px;width:30px;float:left;margin-right:.5rem;"
                                                     alt="{{ $value->menu_item }}"/>
                                                @else
                                                        <!--i class="fa fa-arrow-right" style="font-size:20px;padding:0px;color:#fafafa;width:25px;height:25px;"></i-->
                                                @endif

                                                {{ $value->menu_item }}
<span style="white-space: nowrap">
                                                &ndash;
                                                @if($main_price>0)
                                                    ${{number_format(($main_price>0)?$main_price:$min_p,2)}}
                                                @else
                                                    ${{number_format($min_p,2)}}+
                                                @endif
                                                @if($dis)
                                                    <strike class="text-muted btn btn-sm btn-link"
                                                            style="float: right">${{number_format($value->price,2)}}</strike>
                                                @endif
                                                @if($dis)
                                                    <strike class="text-muted btn btn-sm btn-link"
                                                            style="float: right">${{number_format($value->price,2)}}</strike>
                                                @endif
</span>
                                        </a>
                                    </div>

                                    <div class="clearfix"></div>
                                </h5>


                                <div class="clearfix">
                                    {!! rating_initialize((session('session_id'))?"static-rating":"static-rating", "menu", $value->id) !!}
                                    <p class="card-text m-a-0">
                                        {{$dis}}
                                    </p>
                                </div>


                                <p class="card-text m-a-0  text-muted">
                                    <?php
                                    if (strlen($value->description) > 65) {
                                        echo substr($value->description, 0, 65) . '...';
                                    } else {
                                        echo substr($value->description, 0, 65);
                                    }
                                    ?>

                                </p>

                                <? if(false){?>

                                <p class="card-text m-a-0 text-muted"> Category: {{ $value->cat_name }}
                                    @if($value->uploaded_on)
                                        Submitted: {{$value->uploaded_on}}
                                    @endif

                                    <?php
                                    if ($value->uploaded_by) {
                                        $uploaded_by = \App\Http\Models\Profiles::where('id', $value->uploaded_by)->get()[0];
                                        echo "by: " . $uploaded_by->name . "";
                                    }
                                    ?>
                                </p>


                                <?}?>
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
                                @endif


                            </div>
                            <!-- End div 4 -->


                            <div class="col-md-12"><!-- start div 5 0000-00-00 00:00:00 -->


                                @if(read('restaurant_id') == $restaurant->id || $canedit)

                                    <div class="btn-group pull-left" role="group" style="vertical-align: middle">
                                        <span class="fa fa-spinner fa-spin" id="spinner{{ $value->id }}"
                                              style="color:blue; display: none;"></span>
                                        @if($value->uploaded_by)
                                            Uploaded by: <A
                                                    HREF="{{ url("user/uploads/" . $value->uploaded_by) }}">{{ select_field("profiles", "id", $value->uploaded_by, "name" ) }}</A>
                                            @if($value->uploaded_on != "0000-00-00 00:00:00")
                                                on {{ date("M j 'y", strtotime($value->uploaded_on)) }}
                                            @endif
                                        @endif

                                    </div>
                                @endif



                                @if($canedit || $value->uploaded_by ==read("id"))

                                    <a href="#"
                                       class="btn btn-sm btn-link pull-right"
                                       title="{{ $alts["deleteMenu"] }}"
                                       onclick="deleteMenuItem(<?php echo $value->cat_id . ', ' . $value->id . ', ' . $value->display_order;?>);return false"><i
                                                class="fa fa-times"></i></a>

                                    <a id="add_item{{ $value->id }}" type="button" title="{{ $alts["edititem"] }}"
                                       class="btn btn-sm btn-link additem pull-right"
                                       data-toggle="modal"
                                       data-target="#addMenuModel"><strong>Edit</strong>
                                    </a>



                                    <a id="up_parent_{{ $value->id.'_'.$value->cat_id }}"
                                       title="{{ $alts["up_parent"] }}"
                                       class="btn btn-sm btn-link pull-right sorting_parent"
                                       href="javascript:void(0);"
                                       onclick="menuItemSort({{ $value->id }}, {{ $value->cat_id }}, {{ $value->display_order }}, 'up', {{ $catMenuCnt }});return false"
                                       style="display:{{ $thisUpMenuVisib }} !important">
                                        <i class="fa fa-arrow-up"></i></a>

                                    <a id="down_parent_{{ $value->id.'_'.$value->cat_id }}"
                                       title="{{ $alts["down_parent"] }}"
                                       class="btn btn-sm btn-link pull-right sorting_parent"
                                       href="javascript:void(0);"
                                       onclick="menuItemSort({{ $value->id }}, {{ $value->cat_id }}, {{ $value->display_order }}, 'down', {{ $catMenuCnt }});return false"
                                       style="display:{{ $thisDownMenuVisib }} !important">
                                        <i class="fa fa-arrow-down"></i></a>

                                @endif


                            </div>
                            <!-- end div 5 -->
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>
                <?php
                $catMenuCnt++;
                ?>
                @include('popups.order_menu_item')
                @endwhile

            </div> <!-- end of last category -->


            <?php

            $catIDforJS = array_keys($catNameStr);
            $catIDforJS_Str = implode(",", $catIDforJS);
            $catNameStrJS = implode("','", $catNameStr);

            $objComma = "";
            $itemPosnForJSStr = "";
            foreach ($itemPosnForJS as $key => $row) { // $key is cat id
                $objStrJS = "";
                foreach ($itemPosnForJS[$key] as $key2 => $row2) {
                    $objComma = ", ";
                    if ($objStrJS == "") {
                        $objComma = "";
                    }
                    $objStrJS .= $objComma . $key2 . ":" . $row2;
                }
                $itemPosnForJSStr .= "\n itemPosn[" . $key . "]={" . $objStrJS . "};"; // [catID]={menuID:displayOrder}
            }


            ?>


            @if(!isset($_GET['page']))
    </div>
    </div>
@endif

<div class="clearfix"></div>

<SCRIPT>
    <?php echo $itemPosnForJSStr;?>
    var itemPosnOrig = itemPosn;
    var menuSortChngs = [];
    var catOrigPosns = [<?php echo $catIDforJS_Str;?>]; // as original cat posns as indexes, with the values being the db cat_id
    var currentCatOrderIDs = catOrigPosns;//Not sure if we'll need this - surrounding cat divs stay same on pg (indexes in array), but value chng to the cat_id
    catNameA = ['<?php echo $catNameStrJS;?>'];
    catPosns = []; // index is for surrounding cat divs, but the posn changes as user adjust order

    catNameLnks = "";
    for (var i = 0; i < catNameA.length; i++) {
        var spaces = "&nbsp; &nbsp; &nbsp;";
        if (i == 0) {
            spaces = "";
        }
        catPosns[i] = i;
        catNameLnks += spaces + "<a HREF='#" + catNameA[i] + "'>" + catNameA[i] + "</a>";

        menuSortChngs[catOrigPosns[i]] = false;
    }

    //enable/disable a menu item via ajax
    function enableitem(id) {
        var checked = $("#check" + id).is(":checked");
        $("#enable" + id).hide();
        $("#spinner" + id).show();

        $.post("{{ url('restaurant/enable') }}", {
            value: checked,
            id: id,
            _token: "{{ csrf_token() }}"
        }, function (result) {
            if (!result) {
                alert("Unable to enable/disable this item");
                $("#check" + id).prop('checked', false);
            }
            $("#enable" + id).show();
            $("#spinner" + id).hide();
        });
    }
</SCRIPT>