<?php
    printfile("views/menus.blade.php");
    $alts = array(
            "product-pop-up" => "Product info",
            "up_cat" => "Move Category up",
            "down_cat" => "Move Category down",
            "up_parent" => "Move this up",
            "down_parent" => "Move this down",
            "deleteMenu" => "Delete this item",
            "edititem" => "Edit this item",
            "editcat" => "Edit this category",
            "deletecat" => "Delete this category"
    );

    $menuTSv = "?i=";
    $menuTS = read('menuTS');
    if ($menuTS) {
        $menuTSv = "?i=" . $menuTS;
        Session::forget('session_menuTS');
    }

    $menu_id = iif($restaurant->franchise > 0, $restaurant->franchise, $restaurant->id);
    $categories = enum_all("category", array("res_id" => $menu_id));
    $canedit = false;

    $prevCat = "";
    $catNameStr = [];
    $parentCnt = [];
    $thisCatCnt = 0;
    $itemPosnForJS = [];
    $itemPosn = []; // to decide if js index needs a new array declared
    // $catCnt set in restaurants-menus.blade
?>

<script>
    var catPosn = [];
    var itemPosn = [];
    var restSlug = "{{ $restaurant->slug }}";
</script>
<style>
    .image {
        position: relative;
        max-width: 100% !important; /* for IE 6 */
    }

    .fronttext {
        position: absolute;
        top: 0px;
        left: 0;
    }
</style>
@if(!isset($_GET['page']))
    <div class="card" id="loadmenus_{{ (isset($catid))?$catid:0 }}">
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
        while (list($key, $thisOrder) = each($cats_listA2)) {
            $item = $menus_listA[$key];
            $valueA[$item->cat_id][] = $item; // this contains full menus list for resto
        }

        $catMenuCnt=0;
        foreach($valueA as $category){
            $last = count($category) - 1;
            printmenuitems($category, true, $categories, $thisCatCnt, $prevCat, $catCnt, $restaurant, $menu_id, $catMenuCnt, $alts, $__env, $last);
            printmenuitems($category, false, $categories, $thisCatCnt, $prevCat, $catCnt, $restaurant, $menu_id, $catMenuCnt, $alts, $__env, $last);
            $catMenuCnt++;
        }

        function printmenuitems($category, $even, $categories, $thisCatCnt, $prevCat, $catCnt, $restaurant, $menu_id, $catMenuCnt, $alts, $__env, $last){
            foreach($category as $index => $value){
                if(iseven($index) == $even){
                    $isfirst = $even && $index == 0;
                    $islast = $index == $last;
                    $catMenuCnt = printmenuitem($categories, $value, $index, $thisCatCnt, $isfirst, $islast, $catCnt, $restaurant, $menu_id, $catMenuCnt, $alts, $__env);
                }
            }
        }

        function iseven($number){
            return $number % 2 == 0;
        }

        function printmenuitem($categories, $value, $index, &$thisCatCnt, $isfirst, $islast, $catCnt, $restaurant, $menu_id, $catMenuCnt, $alts, $__env){
            $noUpCatSort = false;
            $canedit=read("profiletype") == 1 || read("restaurant_id") == $restaurant->id;
            $thisUpMenuVisib = "visible";
            $thisDownMenuVisib = iif($islast, "hidden", "visible");
            $has_iconImage = false;
            $min_p = get_price($value->id);
            $parentCnt[$thisCatCnt] = $value->id; // for js sorting with ajax, not implemented yet
            $itemPosnForJS[$value->cat_id][$value->id] = $value->display_order;
            $catPosn[] = $thisCatCnt;
            if (!$catMenuCnt && $isfirst) {
                $noUpCatSort = true;
            }

            if($isfirst){ // means it's a new category
                $thisUpMenuVisib = "hidden";
                $catMenuCnt = 0; // reset count for this category
                if ($catMenuCnt) {
                    echo '</div><!-- end of previous category -->';
                }
                $prevCat = $value->cat_id; // also used as current cat_id until next loop
                $value->cat_name = getIterator($categories, "id", $prevCat)->title;

                $catNameStr[$prevCat] = $value->cat_name;
                ($noUpCatSort) ? $thisUpCatSort = "hidden" : $thisUpCatSort = "visible";
                ($thisCatCnt >= ($catCnt - 1)) ? $thisDownCatSort = "hidden" : $thisDownCatSort = "visible";

                if (!read('id')) {
                    $thisUpCatSort = 'hidden';
                    $thisDownCatSort = 'hidden';
                    $thisDownMenuVisib = 'hidden';
                    $thisUpMenuVisib = 'hidden';
                }
                if ($menu_id == $restaurant->id) {
                    $canedit = $canedit || (read("profiletype") == 3 && $value->uploaded_by == read("id"));
                }
                ?>

                <DIV class="card-body p-b-1" id="c{{ $thisCatCnt }}"><!-- start of this category -->
                    <div class="parents"><!-- start of category heading -->

                        <div class="row">
                            <div class="col-xs-8 ">
                                <a href="#" name="<?php echo $value->cat_name; ?>"></a>
                                <h4 class="card-title" style="padding:.9375rem !important;"><?= $value->cat_name;?></h4>
                            </div>


                            <div class="col-xs-4">
                                <div class="pull-right" aria-label="Basic example">
                                    @if($canedit)
                                        <a title="{{ $alts["up_cat"] }}" class="btn btn-sm btn-link"
                                           id="up{{ $thisCatCnt }}" style="visibility:{{ $thisUpCatSort }} !important"
                                           href="#" onclick="chngCatPosn({{ $thisCatCnt }},'up');return false">
                                            <!-- <a title="{{ $alts["up_cat"] }}" class="btn btn-sm btn-secondary" disabled="" href="<?= url("restaurant/orderCat2/" . $value->cat_id . "/up");?>"> -->
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
                                    @endif
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
                <?php
                $thisCatCnt++;




                $catMenuCnt++;
            }

                    ?>
                    <a href="#" id="{{ $value->id }}" name="{{ $value->id }}"
                            data-res-id="{{ $value->restaurant_id }}"
                            title="{{ $alts["product-pop-up"] }}"
                            class="card-link" data-toggle="modal"
                            data-target="{{ (Request::is('restaurants/*')) ? '#product-pop-up_' . $value->id : url('restaurants/' . select_field('restaurants', 'id', $value->restaurant_id, 'slug') . '/menu') }}">

                        <div id="parent{{ $value->cat_id }}_{{ $value->display_order }}">
                            <!-- start of menu item -->
                            <div>
                                <div class="col-md-6 ">
                                    <div><!-- start div 4 -->
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

                                            {{ $value->menu_item }}
                                            <span style="white-space: nowrap">&ndash;
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
                                            if (strlen($value->description) > 65) {
                                                echo substr($value->description, 0, 65) . '...';
                                            } else {
                                                echo substr($value->description, 0, 65);
                                            }
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
                                    {!! rating_initialize((session('session_id'))?"static-rating":"static-rating", "menu", $value->id) !!}
                                                <p class="card-text m-a-0">
                                                    {{$dis}}
                                                </p>
                                            </div-->

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


                                        @endif


                                    </div>
                                    <!-- End div 4 -->


                                    <div class=""><!-- start div 5 0000-00-00 00:00:00 -->


                                        @if(read('restaurant_id') == $restaurant->id || $canedit)

                                            <div class="btn-group pull-left" role="group" style="vertical-align: middle">
                                                <span class="fa fa-spinner fa-spin" id="spinner{{ $value->id }}" style="color:blue; display: none;"></span>
                                                @if($value->uploaded_by)
                                                    Uploaded by: <A HREF="{{ url("user/uploads/" . $value->uploaded_by) }}">{{ select_field("profiles", "id", $value->uploaded_by, "name" ) }}</A>
                                                    @if($value->uploaded_on != "0000-00-00 00:00:00")
                                                        on {{ date("M j 'y", strtotime($value->uploaded_on)) }}
                                                    @endif
                                                @endif
                                            </div>
                                        @endif

                                        <script>
                                            function showItem(c, m) {
                                                return c + "  --  " + m + "  --  " + itemPosn[c][m];
                                            }
                                        </script>

                                        @if($canedit || $value->uploaded_by ==read("id"))
                                            @if(debugmode())
                                                <span style="color:#FF0000" class="debugdata">
                                                    parent{{ $value->cat_id . '_' . $value->display_order . $value->id . ', ' . $value->cat_id . ', ' . $value->display_order . ', "down", ' . $catMenuCnt . ", " . $index }}
                                                </span>
                                            @endif

                                            <DIV CLASS="clearfix"></DIV>

                                            <a href="#" class="btn btn-sm btn-link pull-right"
                                               title="{{ $alts["deleteMenu"] }}"
                                               onclick="deleteMenuItem(<?php echo $value->cat_id . ', ' . $value->id . ', ' . $value->display_order;?>);return false"><i
                                                        class="fa fa-times"></i></a>

                                            <a id="add_item{{ $value->id }}" type="button" title="{{ $alts["edititem"] }}"
                                               class="btn btn-sm btn-link additem pull-right"
                                               data-toggle="modal"
                                               data-target="#addMenuModel">
                                                <i class="fa fa-pencil"></i>
                                            </a>

                                            <a id="up_parent_{{ $value->id.'_'.$value->cat_id }}"
                                               title="{{ $alts["up_parent"] }}"
                                               class="btn btn-sm btn-link pull-right sorting_parent"
                                               href="javascript:void(0);"
                                               onclick="menuItemSort({{ $value->id }}, {{ $value->cat_id }}, {{ $value->display_order }}, 'up', {{ $catMenuCnt }});return false"
                                               onmouseover="this.title=showItem({{ $value->cat_id }},{{ $value->id }});"
                                               style="visibility:{{ $thisUpMenuVisib }} !important">
                                                <i class="fa fa-arrow-up"></i>
                                            </a>

                                            <a id="down_parent_{{ $value->id.'_'.$value->cat_id }}"
                                               title="{{ $alts["down_parent"] }}"
                                               class="btn btn-sm btn-link pull-right sorting_parent"
                                               href="javascript:void(0);"
                                               onclick="menuItemSort({{ $value->id }}, {{ $value->cat_id }}, {{ $value->display_order }}, 'down', {{ $catMenuCnt }});return false"
                                               style="visibility:{{ $thisDownMenuVisib }} !important">
                                                <i class="fa fa-arrow-down"></i>
                                            </a>

                                        @endif


                                    </div>
                                    <!-- end div 5 -->
                                </div>
                            </div>


                        </div>

                    </a>
                    <?php
                    //include('popups.order_menu_item')
            return $catMenuCnt++;
        }

        echo '<div class="clearfix"></div></div> <!-- end of last category -->';

            $catIDforJS = array_keys($catNameStr);
            $catIDforJS_Str = implode(",", $catIDforJS);
            $catNameStrJS = implode("','", $catNameStr);

            $objComma = "";
            $itemPosnForJSStr = "";
            $objStrJS = "";
            foreach ($itemPosnForJS as $key => $row) { // $key is cat id
                foreach ($itemPosnForJS[$key] as $key2 => $row2) {
                    if (!isset($itemPosn[$key])) {
                        $itemPosnForJSStr .= "itemPosn[" . $key . "]=[];\n";
                        $itemPosn[$key] = true;
                    }
                    $objComma = "\n";
                    $itemPosnForJSStr .= $objComma . "itemPosn[" . $key . "][" . $key2 . "]=" . $row2 . ";\n";
                }
            }


            ?>


            @if(!isset($_GET['page']))
    </div>
    </div>
@endif

<DIV ID="popupholder"></DIV>
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

    function editcategory(ID, Name) {
        $("#editCatModelLabel").text(Name);
        $("#categoryeditor").load("{{ url("restaurant/cateditor") }}/" + ID);
    }

    function deletecategory(ID, Name) {
        confirm2("Are you sure you want to delete '" + Name + "' and every item in that category?", function (tthis, data) {
            $.post("{{ url('ajax') }}", {
                type: "deletecategory",
                id: data.id,
                _token: "{{ csrf_token() }}"
            }, function (result) {
                window.location.reload();
            });
        }, {id: ID});
    }

    var temptarget;
    function checkmenuitem(event, ID, main_price, dis){
        if( !$("#product-pop-up_" + ID).length ){
            overlay_loader_show();
            temptarget = event.target;
            $.post("{{ url('ajax') }}", {
                type: "getmenuitem",
                id: ID,
                main_price: main_price,
                dis: dis,
                _token: "{{ csrf_token() }}"
            }, function (result) {
                overlay_loader_hide();
                $( "#popupholder" ).append( result );
                $(temptarget).trigger("click");
            });
        }
    }
</SCRIPT>