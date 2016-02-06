<?php printfile("views/menus.blade.php"); ?>


@if(!isset($_GET['page']))
    <div id="loadmenus_{{ (isset($catid))?$catid:0 }}">
        @endif


        <DIV class="list-group" id="">


            @foreach($menus_list as $value)
                <?php
                $has_image = true;
                $item_image = asset('assets/images/restaurant-default.jpg');
                $item_image1 = asset('assets/images/restaurant-default.jpg');


                if ($value->image != '' && file_exists(public_path('assets/images/restaurants/' . $value->restaurant_id . '/menus/' . $value->id . '/thumb1_' . $value->image))) {
                    $item_image1 = asset('assets/images/restaurants/' . $value->restaurant_id . '/menus/' . $value->id . '/thumb1_' . $value->image);
                    $has_image = true;
                }
                if ($value->image != '' && file_exists(public_path('assets/images/restaurants/' . $value->restaurant_id . '/menus/' . $value->id . '/thumb_' . $value->image))) {
                    $item_image = asset('assets/images/restaurants/' . $value->restaurant_id . '/menus/' . $value->id . '/thumb_' . $value->image);
                    $has_image = false;
                }


                $submenus = \App\Http\Models\Menus::where('parent', $value->id)->orderBy('display_order', 'ASC')->get();
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
                                    if ($value->days_discount == 'Sun,Mon,Tue,Wed,Thu,Fri,Sat')
                                        $everyday = 'everyday';
                                    else {
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


                                <h3 class="card-title">
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
                                            <strike class="text-muted">${{number_format($value->price,2)}}</strike>
                                        @endif

                                        <a

                                                href="#" id="{{ $value->id }}"
                                                data-res-id="{{ $value->restaurant_id }}" type="button"
                                                data-toggle="modal"
                                                data-target="{{ (Request::is('restaurants/*')) ? '#product-pop-up_' . $value->id : url('restaurants/' . select_field('restaurants', 'id', $value->restaurant_id, 'slug') . '/menus') }}"
                                                class="btn btn-primary">${{number_format($main_price,2)}}</a>


                                    </div>


                                </h3>

                                <div class="clearfix">
                                    {!! rating_initialize((session('session_id'))?"static-rating":"static-rating", "menu", $value->id) !!}

                                    <p class="card-text m-a-0">
                                        {{$dis}}
                                    </p>


                                </div>


                                <p class="card-text m-a-0">
                                    {{ $value->description }}
                                </p>




                                <!--p class="card-text m-a-0 text-muted" style="">
                                            Category: {{ $value->cat_name }}
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
                                            &nbsp;<i class="fa fa-angle-left"></i>&nbsp;</a>

                                        <a id="down_parent_{{ $value->id.'_'.$catid }}"
                                           class="btn btn-sm btn-secondary-outline sorting_parent"
                                           href="javascript:void(0);">
                                            &nbsp;<i class="fa fa-angle-right"></i>&nbsp;</a>

                                        <button id="add_item{{ $value->id }}" type="button"
                                                class="btn btn-sm btn-secondary-outline additem" data-toggle="modal"
                                                data-target="#addMenuModel">Edit Item
                                        </button>

                                        <a href="{{ url('restaurant/deleteMenu/' . $value->id . '/' . $restaurant->slug) }}"
                                           class="btn btn-sm btn-secondary-outline"
                                           onclick="return confirm('This will delete the menu item. Do you wish to proceed?')">X</a>
                                    </div>

                                @endif


                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>


                <div class="modal fade clearfix " id="product-pop-up_{{ (isset($value->id))?$value->id:'' }}"
                     tabindex="-1"
                     role="dialog" aria-labelledby="viewDetailModelLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close close<?php echo $value->id; ?>" data-dismiss="modal"
                                        aria-label="Close" id="clear_<?php echo $value->id; ?>">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="viewDetailModel"><?php echo $value->menu_item; ?></h4>
                            </div>
                            <div class="modal-body product-popup">
                                <div class="product-page product-pop-up">
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12 title">
                                            <h3>
                                                @if($dis)
                                                    <strike class="text-muted">${{number_format($value->price,2)}}</strike>
                                                    ${{number_format($main_price,2)}}
                                                    <span class='label label-warning'>{{$dis}}</span>
                                                @else
                                                    ${{number_format($value->price,2)}}
                                                @endif
                                            </h3>
                                        </div>
                                        @if (Session::get('session_type_user') == "super" )
                                                <!--div class="col-sm-12 col-xs-12">
                                               <p class="">Views: {{ ViewsCountsType($value->id, "menu") }}</p>
                                           </div-->
                                        @endif
                                        <div class="col-sm-12 col-xs-12">
                                            <img class="popimage_{{ $value->id }}" width="150" src="{{ $item_image }}"/>
                                        </div>

                                        <div class="col-sm-12 col-xs-12">
                                            <p class="">{{ $value->description }}</p>
                                        </div>
                                        <div class="subitems_{{ $value->id }} optionals">
                                            <div class="clearfix space10"></div>
                                            <div style="display:none;">
                                                <input type="checkbox" style="display: none;" checked="checked"
                                                       title="{{ $value->id.'_<b>'.$value->menu_item.'</b>_'.$main_price.'_' }}"
                                                       value="" class="chk">
                                            </div>
                                            <div class="banner bannerz">
                                                <table>
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
                                                                        <input type="checkbox"
                                                                               value="{{ '<br/>'.$sub->menu_item }}"
                                                                               title="___" id="{{ $sub->id }}"
                                                                               style="display: none;" checked="checked"
                                                                               class="chk">
                                                                    </div>
                                                                    <strong>
                                                                        {{ ucfirst($sub->menu_item) }}     </strong>

                                                           <span class="limit-options">
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
                                                               </span>


                                                                    <div class="clearfix"></div>
                                                                    <span class="error_{{ $sub->id }} errormsg"></span>

                                                                    <div class="list clearfix">
                                                                        <?php $mini_menus = \App\Http\Models\Menus::where('parent', $sub->id)->orderBy('display_order', 'ASC')->get(); ?>
                                                                        @foreach($mini_menus as $mm)






                                                                            <div class="col-xs-12 col-md-6">


                                                                                <div id="buttons_{{ $mm->id }}"
                                                                                     class="buttons <?php if($sub->sing_mul != '1'){?>col-md-8 <?php }?>nopadd"
                                                                                     href="javascript:void(0);">
                                                                                    <?php
                                                                                    if ($mm->price != 0)
                                                                                        $extra_price = '(+$' . $mm->price . ')_';
                                                                                    else
                                                                                        $extra_price = '_';
                                                                                    ?>
                                                                                    <input type="{{ ($sub->sing_mul == '1') ? 'radio' : 'checkbox' }}"
                                                                                           id="extra_{{ $mm->id }}"
                                                                                           title="{{ $mm->id.'_ '.$mm->menu_item.$extra_price.$mm->price.'_'.$sub->menu_item }}"
                                                                                           class="extra-{{ $sub->id }} spanextra_<?php echo $mm->id; ?>"
                                                                                           name="extra_{{ $sub->id }}"
                                                                                           value="post" <?php if ($sub->sing_mul == '0') echo "style='display:none'"; ?> />
                                                                                    {{ $mm->menu_item }}


                                                                                    <?php if ($mm->price) echo "(+ $" . number_format(str_replace('$', '', $mm->price), 2) . ")"; ?>
                                                                                </div>


                                                                                <div <?php if ($sub->sing_mul == '1') {
                                                                                    echo "style='display:none'";
                                                                                } ?> class="">


                                                                                    <a id="remspan_{{ $mm->id }}"
                                                                                       class="remspan btn btn-secondary-outline btn-xs"
                                                                                       href="javascript:;">-</a>

                                                                                           <span
                                                                                                   id="sprice_{{$mm->price}}"
                                                                                                   class="span_{{ $mm->id }} allspan">0</span>


                                                                                    <a id="addspan_{{ $mm->id }}"
                                                                                       class="addspan btn btn-xs btn-primary"
                                                                                       href="javascript:;">+</a>


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
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="modal-footer">
                                <!--button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                   <button id="clear_{{ $value->id }}" class="btn btn-warning resetslider" type="button">
                                       Reset
                                   </button-->
                                Qty&nbsp;
                                <a class="btn btn-secondary-outline" href="javascript:void(0);"
                                   onclick="changeqty('{{ $value->id }}', 'minus')">-</a>
                                &nbsp;
                                <span class="number{{ $value->id }}">1</span> &nbsp;
                                <a class="btn  btn-secondary-outline  " href="javascript:void(0);"
                                   onclick="changeqty('{{ $value->id }}', 'plus')">+</a>

                                <a id="profilemenu{{ $value->id }}"
                                   class="btn  btn-primary add_menu_profile add_end"
                                   href="javascript:void(0);">Add</a>
                            </div>
                        </div>
                    </div>
                </div>


            @endforeach


            @if(!isset($_GET['page']))
        </div>
    </div>
@endif

<div style="display: none;" class="nxtpage_{{ $catid }}">
    <li class="next_{{ $catid }}"><a href="{{ $menus_list->nextPageUrl() }}">Next &gt;&gt;</a></li>
</div>

@if( $menus_list->hasMorePages() === true)
    <div class="row" id="LoadMoreBtnContainer{{ $catid }}">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <button align="center" class="loadmore btn btn-primary btn-block" title="{{ $catid }}">Load
                More
            </button>
        </div>
    </div>
@endif

<div class="clearfix"></div>