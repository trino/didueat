<?php printfile("views/menus.blade.php"); //edit loadmenus in homecontroller if you want disabled items to show ?>

@if(!isset($_GET['page']))
    <div id="loadmenus_{{ (isset($catid))?$catid:0 }}">
@endif

        <DIV class="list-group m-b-1" id="">


            <div class="list-group-item parents" style="background-color: #f5f5f5;" id="">
                <div class="">
                    <div class="row">

                        <div class="col-md-12">
                            <h4 class="card-title">Online Menu</h4>
                        </div>
                    </div>
                </div>

            </div>
<?php


    $menuTSv="?i=";
    $menuTS=read('menuTS');
    if($menuTS){
         $menuTSv="?i=".$menuTS;
         Session::forget('session_menuTS');
    }

?>

            @foreach($menus_list as $value)
                <?php //load images, duplicate code
                    
                    $has_iconImage = false;

                    if ($value->image != '' && file_exists(public_path('assets/images/restaurants/' . $value->restaurant_id . '/menus/' . $value->id . '/icon-' . $value->image))) {
                        $item_iconImg = asset('assets/images/restaurants/' . $value->restaurant_id . '/menus/' . $value->id . '/icon-' . $value->image).$menuTSv;
                        $has_iconImage = true;
                    }

                    $has_bigImage = false;
                    if ($value->image != '' && file_exists(public_path('assets/images/restaurants/' . $value->restaurant_id . '/menus/' . $value->id . '/big-' . $value->image))) {
                        $item_bigImage = asset('assets/images/restaurants/' . $value->restaurant_id . '/menus/' . $value->id . '/big-' . $value->image).$menuTSv;
                        $has_bigImage = true;
                    }

                    $submenus = \App\Http\Models\Menus::where('parent', $value->id)->orderBy('display_order', 'ASC')->get();
                    $min_p = get_price($value->id);
                ?>

                <div class="list-group-item parents" id="parent{{ $value->id }}">
                    <div class="">
                        <div class="row">

                            <div class="col-md-12">
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
                                            $everyday = str_replace(' and /','',$everyday);
                                        }
                                        $discount = $value->discount_per;
                                        $d = $main_price * $discount / 100;
                                        $main_price = $main_price - $d;
                                        $dis = "" . $discount . "% off " . $everyday . "";

                                    }
                                ?>
                                    <div class="" style="width: 70%;float:left;">

                                <h4 class="card-title">
                                    <a href="#" id="{{ $value->id }}"
                                       data-res-id="{{ $value->restaurant_id }}" type=""
                                       class="card-link" data-toggle="modal"
                                       data-target="{{ (Request::is('restaurants/*')) ? '#product-pop-up_' . $value->id : url('restaurants/' . select_field('restaurants', 'id', $value->restaurant_id, 'slug') . '/menu') }}">

                                        @if($has_iconImage)
                                            <img src="{{ $item_iconImg }}"
                                                 class="img-rounded" style="height:32px;width:32px;"
                                                 alt="{{ $value->menu_item }}"/>
                                        @else
                                                    <!--i class="fa fa-arrow-right" style="font-size:20px;padding:0px;color:#fafafa;width:25px;height:25px;"></i-->
                                        @endif

                                        {{ $value->menu_item }}

                                    </a>

</div>

                                    <div class="" style="width: 30%;float: right">



                                        <a href="#" id="{{ $value->id }}"
                                            data-res-id="{{ $value->restaurant_id }}" type="button"
                                            data-toggle="modal"
                                           style="float: right;"
                                            data-target="{{ (Request::is('restaurants/*')) ? '#product-pop-up_' . $value->id : url('restaurants/' . select_field('restaurants', 'id', $value->restaurant_id, 'slug') . '/menu') }}"
                                            class="btn btn-sm btn-primary">

                                            @if($main_price>0)
                                                ${{number_format(($main_price>0)?$main_price:$min_p,2)}}
                                            @else
                                                ${{number_format($min_p,2)}}+
                                            @endif
                                        </a>

                                        @if($dis)
                                            <strike class="text-muted btn btn-sm btn-link" style="float: right">${{number_format($value->price,2)}}</strike>
                                        @endif

                                    </div>
                                </h4>

                                <div class="clearfix">
                                    {!! rating_initialize((session('session_id'))?"static-rating":"static-rating", "menu", $value->id) !!}
                                    <p class="card-text m-a-0">
                                        {{$dis}}
                                    </p>
                                </div>


                                <p class="card-text m-a-0">
                                    <?php
                                        if (strlen($value->description) > 65) {
                                            echo substr($value->description, 0, 65) . '...';
                                        } else {
                                            echo substr($value->description, 0, 65);
                                        }
                                    ?>

                                </p>

                                <!--p class="card-text m-a-0 text-muted"> Category: {{ $value->cat_name }}
                                @if($value->uploaded_on)
                                    Submitted: {{$value->uploaded_on}}
                                @endif

                                <?php
                                    if($value->uploaded_by){
                                        $uploaded_by = \App\Http\Models\Profiles::where('id', $value->uploaded_by)->get()[0];
                                        echo "by: " . $uploaded_by->name . "";
                                    }
                                ?>
                                        </p-->


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


                            <div class="col-md-12">
                                @if(Session::has('session_restaurant_id') && Session::get('session_restaurant_id') == $restaurant->id)
                                    <div class="btn-group pull-left" role="group" style="vertical-align: middle">
                                        <span class="fa fa-spinner fa-spin" id="spinner{{ $value->id }}" style="color:blue; display: none;"></span>
                                        <label class="c-input c-checkbox p-r-1" id="enable{{ $value->id }}">
                                            <input {{ iif($value->is_active, "CHECKED") }} id="check{{ $value->id }}" onclick="enableitem({{ $value->id }});" type="checkbox" class="is_active">Enable Item
                                            <span class="c-indicator"></span>
                                        </label>
                                    </div>
                                    <div class="btn-group pull-right" role="group">

                                        <a id="up_parent_{{ $value->id.'_'.$catid }}"
                                           class="btn btn-sm btn-primary-outline sorting_parent"
                                           href="javascript:void(0);">
                                           <i class="fa fa-arrow-up"></i></a>

                                        <a id="down_parent_{{ $value->id.'_'.$catid }}"
                                           class="btn btn-sm btn-primary-outline sorting_parent"
                                           href="javascript:void(0);">
                                            <i class="fa fa-arrow-down"></i></a>

                                        <button id="add_item{{ $value->id }}" type="button"
                                                class="btn btn-sm btn-primary-outline additem" data-toggle="modal"
                                                data-target="#addMenuModel"><strong>Edit</strong>
                                        </button>

                                        <a href="{{ url('restaurant/deleteMenu/' . $value->id . '/' . $restaurant->slug) }}"
                                           class="btn btn-sm btn-primary-outline"
                                           onclick="return confirm('This will delete the menu item. Do you wish to proceed?\n\nOptionally, you can disable the display of the menu item by deselecting the Enable checkbox on the menu edit pop-up.\nThis will save the menu item for future use.')"><i class="fa fa-times"></i></a>
                                    </div>

                                @endif


                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>

                @include('popups.order_menu_item')
            @endforeach


            @if(!isset($_GET['page']))
        </div>
    </div>
@endif

<div class="clearfix"></div>
<SCRIPT>
    //enable/disable a menu item via ajax
    function enableitem(id){
        var checked = $("#check" + id).is(":checked");
        $("#enable" + id).hide();
        $("#spinner" + id).show();

        $.post("{{ url('restaurant/enable') }}", {
            value: checked,
            id: id,
            _token: "{{ csrf_token() }}"
        }, function (result) {
            if(!result){
                alert("Unable to enable/disable this item");
                $("#check" + id).prop('checked', false);
            }
            $("#enable" + id).show();
            $("#spinner" + id).hide();
        });
    }
</SCRIPT>