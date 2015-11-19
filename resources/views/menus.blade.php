@if(!isset($_GET['page']))
<div id="loadmenus_{{ $catid }}">
@endif

@foreach($menus_list as $value)
    <?php
        $item_image = asset('assets/images/default_menu.jpg');
        $item_image1 = asset('assets/images/default_menu.jpg');
        if ($value->image != '' && file_exists(public_path('assets/images/restaurants/' . $value->restaurant_id . '/menus/' . $value->id . '/thumb1_' . $value->image))){
            $item_image1 = asset('assets/images/restaurants/' . $value->restaurant_id . '/menus/' . $value->id . '/thumb1_' . $value->image);
        }
        if($value->image != '' && file_exists(public_path('assets/images/restaurants/' . $value->restaurant_id . '/menus/' . $value->id . '/thumb_' . $value->image))){
            $item_image = asset('assets/images/restaurants/' . $value->restaurant_id . '/menus/' . $value->id . '/thumb_' . $value->image);
        }
        $submenus = \App\Http\Models\Menus::where('parent', $value->id)->get();
    ?>
    <div class="col-md-6 col-sm-6 col-xs-12 parents menus-parent" id="parent{{ $value->id }}">
        <div class="product-item">
            <a href="{{ (Request::is('restaurants/*')) ? '#product-pop-up_' . $value->id : url('restaurants/' . select_field('restaurants', 'id', $value->restaurant_id, 'slug') . '/menus') }}" data-id="{{ $value->id }}" data-res-id="{{ $value->restaurant_id }}" class="insert-stats {{ (Request::is('restaurants/*')) ? 'fancybox-fast-view' : '' }}">
                <div class="col-md-8 col-sm-7 col-xs-6 no-padding">
                    <h2 class="padding-top-5 menu-title">{{ $value->menu_item }}</h2>
                    <p class="menu-description">{{ $value->description }}</p>
                    @if(Session::has('is_logged_in'))
                        <div class="pull-left">
                            <a href="{{ url('restaurant/deleteMenu/' . $value->id . '/' . $restaurant->slug) }}" class="btn-sm red">Remove</a>
                            <a href="#menumanager2" id="add_item{{ $value->id }}" class="btn-small blue fancybox-fast-view additem">Edit</a>
                            <a id="up_parent_{{ $value->id.'_'.$catid }}" class="sorting_parent" href="javascript:void(0);"><i class="fa fa-angle-left"></i></a>
                            <a id="down_parent_{{ $value->id.'_'.$catid }}" class="sorting_parent" href="javascript:void(0);"><i class="fa fa-angle-right"></i></a>
                        </div>
                    @endif
                </div>
                <div class="col-md-2 col-sm-3 col-xs-3 menu-price">${{ $value->price }}</div>
                <div class="col-md-2 col-sm-2 col-xs-3 menu-image">
                    <img style="height:60px;" src="{{ $item_image1 }}" class="img-responsive" alt="{{ $value->menu_item }}" />
                </div>
            </a>
        </div>
    </div>


    <div id="product-pop-up_{{ $value->id }}" class="product-popup" style="display: none;">
        <div class="product-page product-pop-up">
            <div class="modal-body">
                <div class="col-sm-12 col-xs-12 title">
                    <h2>{{ $value->menu_item }}: $ {{ $value->price }}</h2>
                </div>
                <div class="col-sm-12 col-xs-12" id="stats_block" style="display: none;">
                    <strong>Menu Views:</strong>
                    <span id="view_stats"></span>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <img class="popimage_{{ $value->id }}" width="150" src="{{ $item_image }}" />
                </div>
                <div class="clearfix"></div>

                <div class="product-titles">
                    <h2>{{ $value->description }}</h2>
                </div>

                <div class="subitems_{{ $value->id }} optionals">
                    <div class="clearfix space10"></div>
                    <div style="display:none;">
                        <input type="checkbox" style="display: none;" checked="checked" title="{{ $value->id.'_'.$value->menu_item.'-_'.$value->price.'_' }}" value="" class="chk">
                    </div>
                    <div class="banner bannerz">
                        <table width="100%">
                            <tbody>    
                                @foreach ($submenus as $sub)
                                <tr class="zxcx">
                                    <td width="100%" id="td_{{ $sub->id }}" class="valign-top">
                                        <input type="hidden" value="{{ $sub->exact_upto_qty }}" id="extra_no_{{ $sub->id }}">
                                        <input type="hidden" value="{{ $sub->req_opt }}" id="required_{{ $sub->id }}">
                                        <input type="hidden" value="{{ $sub->sing_mul }}" id="multiple_{{ $sub->id }}">
                                        <input type="hidden" value="{{ $sub->exact_upto }}" id="upto_{{ $sub->id }}">

                                        <div style="" class="infolist col-xs-12">
                                            <div style="display: none;">
                                                <input type="checkbox" value="{{ $sub->menu_item }}" title="___" id="{{ $sub->id }}" style="display: none;" checked="checked" class="chk">
                                            </div>
                                            <a href="javascript:void(0);"><strong>{{ $sub->menu_item }}</strong></a>
                                            <span><em> </em></span>
                                            <span class="limit-options">
                                                <?php
                                                if ($sub->exact_upto == 0)
                                                    $upto = "up to ";
                                                else
                                                    $upto = "exactly ";
                                                if ($sub->req_opt == '0') {
                                                    if ($sub->exact_upto_qty > 0 && $sub->sing_mul == '0')
                                                        echo "(Select " . $upto . $sub->exact_upto_qty . " Items) ";
                                                    echo "(Optional)";
                                                } elseif ($sub->req_opt == '1') {
                                                    if ($sub->exact_upto_qty > 0 && $sub->sing_mul == '0')
                                                        echo "Select " . $upto . $sub->exact_upto_qty . " Items ";
                                                    echo "(Mandatory)";
                                                }
                                                ?>
                                            </span>
                                            <div class="clearfix"></div>
                                            <span class="error_{{ $sub->id }} errormsg"></span>
                                            <div class="list clearfix">
                                                <?php $mini_menus = \App\Http\Models\Menus::where('parent', $sub->id)->get(); ?>
                                                @foreach($mini_menus as $mm)
                                                <div class="col-xs-6 col-md-6 subin btn default btnxx">
                                                    <div class="btnxx-inner">
                                                        <a id="buttons_{{ $mm->id }}" class="buttons" href="javascript:void(0);">
                                                            <button class="btn btn-primary"></button>
                                                            <input type="{{ ($sub->sing_mul == '1') ? 'radio' : 'checkbox' }}"
                                                                   id="extra_{{ $mm->id }}" title="{{ $mm->id.'_<br/> '.$mm->menu_item.'_'.$mm->price.'_'.$sub->menu_item }}"
                                                                   class="extra-{{ $sub->id }}" name="extra_{{ $sub->id }}" value="post" />
                                                            &nbsp;&nbsp; {{ $mm->menu_item }}
                                                            &nbsp;&nbsp; <?php if ($mm->price) echo "(+ $" . number_format(str_replace('$', '', $mm->price), 2) . ")"; ?>
                                                        </a>
                                                        <b style="display:none;">
                                                            <a id="remspan_{{ $mm->id }}" class="remspan" href="javascript:;"><b>&nbsp;&nbsp;-&nbsp;&nbsp;</b></a>
                                                            <span id="sprice_0" class="span_{{ $mm->id }} allspan">&nbsp;&nbsp;1&nbsp;&nbsp;</span>
                                                            <a id="addspan_{{ $mm->id }}" class="addspan" href="javascript:;"><b>&nbsp;&nbsp;+&nbsp;&nbsp;</b></a>
                                                        </b>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                                @endforeach
                                                <input type="hidden" value="" class="chars_{{ $sub->id }}">
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
                            <a class="btn btn-primary minus" href="javascript:void(0);" onclick="changeqty('{{ $value->id }}', 'minus')">-</a>
                            <div class="number{{ $value->id }}">1</div>
                            <a class="btn btn-primary add" href="javascript:void(0);" onclick="changeqty('{{ $value->id }}', 'plus')">+</a>
                        </div>
                        <a id="profilemenu{{ $value->id }}" class="btn btn-primary add_menu_profile add_end" href="javascript:void(0);">Add</a>
                        <button id="clear_{{ $value->id }}" data-dismiss="modal" class="btn btn-warning resetslider" type="button">
                            RESET
                        </button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
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

@if(!isset($_GET['page']))
    @if($menus_list->hasMorePages())
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <button align="center" class="loadmore red btn btn-primary" title="{{ $catid }}">Load More</button>
                </div>
            </div>
        </div>
    @endif
    <div class="clearfix"></div>
@endif