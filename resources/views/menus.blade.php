<?php printfile("views/menus.blade.php"); ?>

@if(!isset($_GET['page']))
    <div id="loadmenus_{{ (isset($catid))?$catid:0 }}">
        @endif

        <DIV class="list-group" id="">


            <div class="list-group-item parents" id="">
                <div class="">
                    <div class="row">

                        <div class="col-md-12">
                            <h4 class="card-title">Online Menu</h4>
                            </div>
                            </div>
                            </div>
                            </div>
            @foreach($menus_list as $value)


                <?php
                $has_image = true;

                $item_image = asset('assets/images/restaurant-default.jpg');
                $item_image1 = asset('assets/images/restaurant-default.jpg');

                if ($value->image != '' && file_exists(public_path('assets/images/restaurants/' . $value->restaurant_id . '/menus/' . $value->id . '/' . $value->image))) {
                    $item_image1 = asset('assets/images/restaurants/' . $value->restaurant_id . '/menus/' . $value->id . '/' . $value->image);
                    $has_image = true;
                }
                if ($value->image != '' && file_exists(public_path('assets/images/restaurants/' . $value->restaurant_id . '/menus/' . $value->id . '/' . $value->image))) {
                    $item_image = asset('assets/images/restaurants/' . $value->restaurant_id . '/menus/' . $value->id . '/' . $value->image);
                    $has_image = false;
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
                                    }
                                    $discount = $value->discount_per;
                                    $d = $main_price * $discount / 100;
                                    $main_price = $main_price - $d;
                                    $dis = "" . $discount . "% off " . $everyday . "";

                                }
                                ?>

                                <h4 class="card-title">
                                    <a href="#" id="{{ $value->id }}"
                                       data-res-id="{{ $value->restaurant_id }}" type=""
                                       class="card-link" data-toggle="modal"
                                       data-target="{{ (Request::is('restaurants/*')) ? '#product-pop-up_' . $value->id : url('restaurants/' . select_field('restaurants', 'id', $value->restaurant_id, 'slug') . '/menus') }}">

                                        @if(!$has_image)
                                            <img src="{{ $item_image1 }}"
                                                 class="img-circle" style="height: 25px;width:25px;"
                                                 alt="{{ $value->menu_item }}"/>
                                            @else
                                                    <!--i class="fa fa-arrow-right" style="font-size:20px;padding:0px;color:#fafafa;width:25px;height:25px;"></i-->
                                        @endif


                                        {{ $value->menu_item }}

                                    </a>
                                 <div class="pull-right">


                                        @if($dis)
                                            <strike class="text-muted"
                                                    style="font-size:60%;">${{number_format($value->price,2)}}</strike>
                                        @endif

                                        <a href="#" id="{{ $value->id }}"
                                        data-res-id="{{ $value->restaurant_id }}" type="button"
                                        data-toggle="modal"
                                        data-target="{{ (Request::is('restaurants/*')) ? '#product-pop-up_' . $value->id : url('restaurants/' . select_field('restaurants', 'id', $value->restaurant_id, 'slug') . '/menus') }}"
                                        class="btn btn-sm btn-primary">

                                            @if($main_price>0)
                                            ${{number_format(($main_price>0)?$main_price:$min_p,2)}}
                                            @else
Order
                                                @endif


                                        </a>

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

                                <!--p class="card-text m-a-0 text-muted" style=""> Category: {{ $value->cat_name }}
                                @if($value->uploaded_on)
                                        Submitted: {{$value->uploaded_on}}
                                @endif

                                @if($value->uploaded_by)
                                <?php
                                $uploaded_by = \App\Http\Models\Profiles::where('id', $value->uploaded_by)->get()[0];
                                echo "by: " . $uploaded_by->name . "";
                                ?>
                                @endif
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


                            <div class="col-md-12" style="">
                                @if(Session::has('session_restaurant_id') && Session::get('session_restaurant_id') == $restaurant->id)
                                    <div class="btn-group pull-right" role="group">

                                        <a id="up_parent_{{ $value->id.'_'.$catid }}"
                                           class="btn btn-sm btn-secondary-outline sorting_parent"
                                           href="javascript:void(0);">
                                           <i class="fa fa-arrow-up"></i></a>

                                        <a id="down_parent_{{ $value->id.'_'.$catid }}"
                                           class="btn btn-sm btn-secondary-outline sorting_parent"
                                           href="javascript:void(0);">
                                            <i class="fa fa-arrow-down"></i></a>

                                        <button id="add_item{{ $value->id }}" type="button"
                                                class="btn btn-sm btn-secondary-outline additem" data-toggle="modal"
                                                data-target="#addMenuModel">Edit
                                        </button>

                                        <a href="{{ url('restaurant/deleteMenu/' . $value->id . '/' . $restaurant->slug) }}"
                                           class="btn btn-sm btn-secondary-outline"
                                           onclick="return confirm('This will delete the menu item. Do you wish to proceed?')"><i class="fa fa-times"></i></a>
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