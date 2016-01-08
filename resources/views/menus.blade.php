
@if(!isset($_GET['page']))
    <div id="loadmenus_{{ $catid }}">
        @endif

        <?php printfile("views/menus.blade.php"); ?>

        @foreach($menus_list as $value)
            <?php
            $item_image = asset('assets/images/restaurant-default.jpg');
            $item_image1 = asset('assets/images/restaurant-default.jpg');
            if ($value->image != '' && file_exists(public_path('assets/images/restaurants/' . $value->restaurant_id . '/menus/' . $value->id . '/thumb1_' . $value->image))) {
                $item_image1 = asset('assets/images/restaurants/' . $value->restaurant_id . '/menus/' . $value->id . '/thumb1_' . $value->image);
            }
            if ($value->image != '' && file_exists(public_path('assets/images/restaurants/' . $value->restaurant_id . '/menus/' . $value->id . '/thumb_' . $value->image))) {
                $item_image = asset('assets/images/restaurants/' . $value->restaurant_id . '/menus/' . $value->id . '/thumb_' . $value->image);
            }
            $submenus = \App\Http\Models\Menus::where('parent', $value->id)->get();
            ?>

            <div class="card card-block parents menus-parent" id="parent{{ $value->id }}">
                <div class="new-layout-box">
                    <div class="row">
                        <div class="col-md-9" style="padding-bottom: 26px">
                            <div class="new-layout-box-content">
                                <div class="restaurant-name">
                                <?php
                                    $main_price = $value->price;
                                    $dis = '';
                                    $everyday ='';
                                    $days = explode(',',$value->days_discount);
                                    $today = date('D');
                                    if($value->has_discount=='1'&& in_array($today,$days))
                                    {
                                        if($value->days_discount == 'Sun,Mon,Tue,Wed,Thu,Fri,Sat')
                                            $everyday= 'everyday';
                                        else
                                        {
                                            $everyday = str_replace($today,',',$value->days_discount);
                                            $everyday = 'Today and '.str_replace(',','/',$everyday);
                                            $everyday = str_replace('//','',$everyday);
                                            
                                        }        
                                
                                        $discount = $value->discount_per;
                                        $d = $main_price*$discount/100;
                                        $main_price=$main_price-$d;
                                        $dis = "(".$discount."% Discount ".$everyday.")";
                                    }
                                    
                                ?>

                                    <h4 class="card-title">{{ $value->menu_item }} <span
                                                    class="menu-tag menu-price">${{ $main_price." ".$dis }}</span></h4>
                                    <!--<a href="javascript:void(0)" id="{{ $value->id }}"
                                       data-res-id="{{ $value->restaurant_id }}" type="button"
                                       class="insert-stats" data-toggle="modal"
                                       data-target="{{ (Request::is('restaurants/*')) ? '#product-pop-up_' . $value->id : url('restaurants/' . select_field('restaurants', 'id', $value->restaurant_id, 'slug') . '/menus') }}">
                                        <h3 class="menu-item">{{ $value->menu_item }} <span
                                                    class="menu-tag menu-price">${{ $main_price." ".$dis }}</span></h3>
                                        <p><strong>Restaurant: </strong>{{ select_field('restaurants', 'id', $value->restaurant_id, 'name') }}</p>
                                        
                                    </a>-->




                                    <!--a href="{{ (Request::is('restaurants/*')) ? '#product-pop-up_' . $value->id : url('restaurants/' . select_field('restaurants', 'id', $value->restaurant_id, 'slug') . '/menus') }}"
                                       data-id="{{ $value->id }}" data-res-id="{{ $value->restaurant_id }}"
                                       class="insert-stats {{ (Request::is('restaurants/*')) ? 'fancybox-fast-view' : '' }}">
                                        <h2>{{ select_field('restaurants', 'id', $value->restaurant_id, 'name') }}</h2>
                                    </a-->
                                </div>
                                <!--a href="{{ (Request::is('restaurants/*')) ? '#product-pop-up_' . $value->id : url('restaurants/' . select_field('restaurants', 'id', $value->restaurant_id, 'slug') . '/menus') }}"
                                   class="{{ (Request::is('restaurants/*')) ? 'fancybox-fast-view' : '' }}">
                                    <h3>{{ $value->menu_item }} <span
                                                class="menu-tag menu-price">${{ $value->price }}</span></h3>
                                </a-->
                                <!--<h3>{{ $value->menu_item }} <span
                                            class="menu-tag menu-price">${{ $value->price }}</span></h3>
                                <p class="box-des"><strong>Description: </strong>{{ substr($value->description, 0, 230) }}</p>
                                <p><strong>Minimum total for Delivery: </strong>{{$restaurant->minimum }}</p>

                                
                                    
                                
                                <p><strong>Delivery Fee: </strong>{{ $restaurant->delivery_fee }}</p>-->

                                
                                @if(isset($restaurant->tags) && $restaurant->tags != "")
                                    
                                    <p>
                                        <?php
                                        $tags = $restaurant->tags;
                                        $tags = explode(',', $tags);
                                        for ($i = 0; $i < 5; $i++) {
                                            if (isset($tags[$i])) {
                                                echo "<span class='tags'>".$tags[$i]."</span>";
                                            }
                                        }
                                        ?>
                                        @endif
                                    </p>
                                    <p class="card-text">
                                    <!--<p class="res-desc">-->{{ $value->description }}</p>
                                    @if(Session::has('session_restaurant_id') && Session::get('session_restaurant_id') == $restaurant->id)
                                        <p>
                                            <a href="{{ url('restaurant/deleteMenu/' . $value->id . '/' . $restaurant->slug) }}"
                                               class="btn btn-sm btn-danger" onclick="return confirm('This will remove the menu item. Do you like to proceed?')">Remove</a>


                                            <button id="add_item{{ $value->id }}" type="button"
                                                    class="btn btn-sm btn-info additem" data-toggle="modal"
                                                    data-target="#addMenuModel">
                                                Edit
                                            </button>


                                            <a id="up_parent_{{ $value->id.'_'.$catid }}"
                                               class="btn custom-default-btn sorting_parent" href="javascript:void(0);"><i
                                                        class="fa fa-angle-left"></i></a>
                                            <a id="down_parent_{{ $value->id.'_'.$catid }}"
                                               class="btn custom-default-btn sorting_parent" href="javascript:void(0);"><i
                                                        class="fa fa-angle-right"></i></a>
                                        </p>
                                    @endif
                                    <div class="">
                                        {!! rating_initialize((session('session_id'))?"rating":"static-rating", "menu", $value->id) !!}
                                    </div>
                                    
                                    <?php if(isset($value) && !$value->is_active){
                                        ?>
                                    <div class="enable_disable">
                                    
                                        <span class="label label-default">Disabled</span>
                                        
                                    </div>
                                    <?php
                                    }?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="menu-img">

                                <p>
                                <a href="javascript:void(0)" id="{{ $value->id }}"
                                   data-res-id="{{ $value->restaurant_id }}" type="button"
                                   class="card-link insert-stats" data-toggle="modal"
                                   data-target="{{ (Request::is('restaurants/*')) ? '#product-pop-up_' . $value->id : url('restaurants/' . select_field('restaurants', 'id', $value->restaurant_id, 'slug') . '/menus') }}">
                                    View Menu Item
                                </a>
                                </p>
                                <a href="javascript:void(0)" id="{{ $value->id }}"
                                   data-res-id="{{ $value->restaurant_id }}" type="button"
                                   class="btn insert-stats" data-toggle="modal"
                                   data-target="{{ (Request::is('restaurants/*')) ? '#product-pop-up_' . $value->id : url('restaurants/' . select_field('restaurants', 'id', $value->restaurant_id, 'slug') . '/menus') }}" style="max-width: 100%">


                                    <div class="card-image">
                                        <img src="{{ $item_image1 }}" class="img-responsive"
                                             alt="{{ $value->menu_item }}"/>
                                    </div>


                                </a>


                                <!--a href="{{ (Request::is('restaurants/*')) ? '#product-pop-up_' . $value->id : url('restaurants/' . select_field('restaurants', 'id', $value->restaurant_id, 'slug') . '/menus') }}"
                                   data-id="{{ $value->id }}" data-res-id="{{ $value->restaurant_id }}"
                                   class="insert-stats {{ (Request::is('restaurants/*')) ? 'fancybox-fast-view' : '' }}">
                                    <div class="card-image">
                                        <img src="{{ $item_image1 }}" class="img-responsive"
                                             alt="{{ $value->menu_item }}"/>
                                    </div>
                                </a-->


                            </div>
                        </div>
                    </div>
                </div>
            </div>





            <div class="modal  fade clearfix " id="product-pop-up_<?if (isset($value->id)) {
                echo $value->id;
            }?>" tabindex="-1" role="dialog" aria-labelledby="viewDetailModelLabel"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close close<?php echo $value->id;?>" data-dismiss="modal" aria-label="Close" id="clear_<?php echo $value->id;?>" >
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="viewDetailModel"><?php echo $value->menu_item;?></h4>
                        </div>
                        <div class="modal-body product-popup" id="product-pop-up_{{ $value->id }}">


                            <div class="product-page product-pop-up">


                                <div class="modal-bodys">
                                    <div class="col-sm-12 col-xs-12 title">
                                        <h3><span class="label label-info">$ {{ $main_price." ".$dis }}</span></h3>
                                    </div>
                                    <div class="col-sm-12 col-xs-12" id="stats_block" style="display: none;">
                                        <strong>Menu Views:</strong>
                                        <span id="view_stats"></span>
                                    </div>
                                    <div class="col-sm-12 col-xs-12">
                                        <img class="popimage_{{ $value->id }}" width="150" src="{{ $item_image }}"/>
                                    </div>
                                    <div class="clearfix"></div>

                                    <div class="product-titles col-md-12">
                                        <p class="res-desc">{{ $value->description }}</p>
                                    </div>

                                    <div class="subitems_{{ $value->id }} optionals">
                                        <div class="clearfix space10"></div>
                                        <div style="display:none;">
                                            <input type="checkbox" style="display: none;" checked="checked"
                                                   title="{{ $value->id.'_'.$value->menu_item.'-_'.$main_price.'_' }}"
                                                   value=""
                                                   class="chk">
                                        </div>
                                        <div class="banner bannerz">
                                            <table width="100%">
                                                <tbody>
                                                @foreach ($submenus as $sub)
                                                    <tr class="zxcx">
                                                        <td width="100%" id="td_{{ $sub->id }}" class="valign-top">
                                                            <input type="hidden" value="{{ $sub->exact_upto_qty }}"
                                                                   id="extra_no_{{ $sub->id }}">
                                                            <input type="hidden" value="{{ $sub->req_opt }}"
                                                                   id="required_{{ $sub->id }}">
                                                            <input type="hidden" value="{{ $sub->sing_mul }}"
                                                                   id="multiple_{{ $sub->id }}">
                                                            <input type="hidden" value="{{ $sub->exact_upto }}"
                                                                   id="upto_{{ $sub->id }}">

                                                            <div style="" class="infolist col-xs-12">
                                                                <div style="display: none;">
                                                                    <input type="checkbox" value="{{ $sub->menu_item }}"
                                                                           title="___"
                                                                           id="{{ $sub->id }}" style="display: none;"
                                                                           checked="checked" class="chk">
                                                                </div>
                                                                <a href="javascript:void(0);"><strong>{{ ucfirst($sub->menu_item) }}</strong></a>
                                                                <span><em> </em></span>
                                            <strong><span class="limit-options">
                                                <?php
                                                if ($sub->exact_upto == 0) {
                                                    $upto = "up to ";
                                                } else {
                                                    $upto = "exactly ";
                                                }
                                                if ($sub->req_opt == '0') {
                                                    if ($sub->exact_upto_qty > 0 && $sub->sing_mul == '0') {
                                                        echo "(Select " . $upto . $sub->exact_upto_qty . " Items) ";
                                                    }
                                                    echo "(Optional)";
                                                } elseif ($sub->req_opt == '1') {
                                                    if ($sub->exact_upto_qty > 0 && $sub->sing_mul == '0') {
                                                        echo "Select " . $upto . $sub->exact_upto_qty . " Items ";
                                                    }
                                                    echo "(Mandatory)";
                                                }
                                                ?>
                                            </span></strong>

                                                                <div class="clearfix"></div>
                                                                <span class="error_{{ $sub->id }} errormsg"></span>

                                                                <div class="list clearfix">
                                                                    <?php $mini_menus = \App\Http\Models\Menus::where('parent', $sub->id)->get(); ?>
                                                                    @foreach($mini_menus as $mm)
                                                                        <!--<div class="col-xs-6 col-md-6 subin btn default btnxx">-->
                                                                        <div class="col-xs-6 col-md-6 subin padding-left-0">
                                                                            <div class="btnxx-inner">
                                                                                <a id="buttons_{{ $mm->id }}"
                                                                                   class="buttons"
                                                                                   href="javascript:void(0);">
                                                                                   <?php if($mm->price!=0)
                                                                                            $extra_price = '(+$'.$mm->price.')_';
                                                                                        else
                                                                                            $extra_price = '_';
                                                                                   ?>
                                                                                    <!--button class="btn btn-primary"></button-->
                                                                                    <input type="{{ ($sub->sing_mul == '1') ? 'radio' : 'checkbox' }}"
                                                                                           id="extra_{{ $mm->id }}"
                                                                                           title="{{ $mm->id.'_ '.$mm->menu_item.$extra_price.$mm->price.'_'.$sub->menu_item }}"
                                                                                           class="extra-{{ $sub->id }} spanextra_<?php echo $mm->id; ?>"
                                                                                           name="extra_{{ $sub->id }}"
                                                                                           value="post" <?php if($sub->sing_mul=='0')echo "style='display:none'";?>/>
                                                                                   
                                                                                    {{ $mm->menu_item }}
                                                                                    &nbsp;&nbsp; <?php if ($mm->price) echo "(+ $" . number_format(str_replace('$', '', $mm->price), 2) . ")"; ?>
                                                                                </a>
                                                                                <b <?php if($sub->sing_mul=='1'){echo "style='display:none'";}?>>
                                                                                    &nbsp; <a id="remspan_{{ $mm->id }}"
                                                                                       class="remspan btn btn-danger btn-xs"
                                                                                       href="javascript:;">-</a>
                                                                                    <span id="sprice_{{$mm->price}}"
                                                                                          class="span_{{ $mm->id }} allspan">&nbsp;&nbsp;0&nbsp;&nbsp;</span>
                                                                                    <a id="addspan_{{ $mm->id }}"
                                                                                       class="addspan btn btn-xs btn-info"
                                                                                       href="javascript:;">+</a>
                                                                                </b>
                                                                            </div>
                                                                            <div class="clearfix"></div>
                                                                        </div>
                                                                    @endforeach
                                                                    <input type="hidden" value=""
                                                                           class="chars_{{ $sub->id }}">
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="clearfix"></div>
                                        <div class="col-xs-12 add-btn">
                                            <div class="add-minus-btn">
                                                <a class="btn btn-danger btn-sm minus" href="javascript:void(0);"
                                                   onclick="changeqty('{{ $value->id }}', 'minus')">-</a>

                                                &nbsp; <span class="number{{ $value->id }}">1</span> &nbsp; 
                                                <a class="btn btn-info btn-sm add" href="javascript:void(0);"
                                                   onclick="changeqty('{{ $value->id }}', 'plus')">+</a>
                                            </div>
                                            <p>
                                            <a id="profilemenu{{ $value->id }}"
                                               class="btn btn-primary add_menu_profile add_end"
                                               href="javascript:void(0);" >Add</a>
                                            <button id="clear_{{ $value->id }}"  class="btn btn-warning resetslider" type="button">
                                                RESET
                                            </button>
                                            <div class="clearfix"></div>
                                            </p>
                                        </div>


                                        <div class="clearfix"></div>


                                    </div>


                                    <div class="clearfix"></div>


                                </div>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>











        @endforeach











        @if(!isset($_GET['page']))
    </div>
@endif














<div style="display: none;" class="nxtpage_{{ $catid }}">
    <li class="next_{{ $catid }}"><a href="{{ $menus_list->nextPageUrl() }}">Next &gt;&gt;</a></li>
</div>


{{--@if(!isset($_GET['page']))--}}
@if( $menus_list->hasMorePages() === true)
    <div class="row" id="LoadMoreBtnContainer{{ $catid }}">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <button align="center" class="loadmore red btn btn-primary" title="{{ $catid }}">Load More</button>
            </div>
        </div>
    </div>
@endif
{{--@endif--}}


<div class="clearfix"></div>

    