<h1><span id="countRows">{{ $count }}</span> Menu Items Found</h1>
<div class="row">
  <?php
    printfile("views/ajax/search_menus.blade.php");
    $alts=array(
            "product-pop-up" => "Product information",
            "buttons" => "IDK",
            "remspan" => "Remove Item",
            "addspan" => "Add Item",
            "minus" => "Remove 1",
            "plus" => "Add 1",
            "add" => "Add items to cart",
            "reset" => "Clear these items",
            "popimage" => "This menu item's image"
    );
  ?>

  @foreach($query as $value)
    <?php
        //check for images and if they exist
        $item_image1 = asset('assets/images/icon-menu-default.jpg');
        if ($value->image != '' && file_exists(public_path('assets/images/restaurants/' . $value->restaurant_id . '/menus/' . $value->id . '/icon-' . $value->image))) {
            $item_image1 = asset('assets/images/restaurants/' . $value->restaurant_id . '/menus/' . $value->id . '/icon-' . $value->image);
        }
        $item_image = asset('assets/images/big-menu-default.jpg');
        if ($value->image != '' && file_exists(public_path('assets/images/restaurants/' . $value->restaurant_id . '/menus/' . $value->id . '/big-' . $value->image))) {
            $item_image = asset('assets/images/restaurants/' . $value->restaurant_id . '/menus/' . $value->id . '/big-' . $value->image);
        }
    ?>

    <!--new box layout-->

    <div id="{{ $start }}" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 parentDiv">
      <div class="new-layout-box">
        <div class="row">
          <div class="col-md-9">
            <div class="new-layout-box-content">
              <div class="restaurant-name">
                <a title="{{ $alts["product-pop-up"] }}"
                        href="{{ (Request::is('restaurants/*')) ? '#product-pop-up_' . $value->id : url('restaurants/' . select_field('restaurants', 'id', $value->restaurant_id, 'slug') . '/menu') }}"
                        class="{{ (Request::is('restaurants/*')) ? 'fancybox-fast-view' : '' }}">
                    <h2>{{ select_field('restaurants', 'id', $value->restaurant_id, 'name') }}</h2>
                </a>
              </div>
              <a title="{{ $alts["product-pop-up"] }}"
                    href="{{ (Request::is('restaurants/*')) ? '#product-pop-up_' . $value->id : url('restaurants/' . select_field('restaurants', 'id', $value->restaurant_id, 'slug') . '/menus') }}"
                    class="{{ (Request::is('restaurants/*')) ? 'fancybox-fast-view' : '' }}">
                <h3>{{ $value->menu_item }} <span class="menu-tag">${{ $value->price }}</span></h3>
              </a>
              <p class="box-des">{{ substr($value->description, 0, 300) }}</p>
              <div class="row">
                  {!! rating_initialize("static-rating", "menu", $value->id) !!}
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="menu-img">
              <a href="{{ (Request::is('restaurants/*')) ? '#product-pop-up_' . $value->id : url('restaurants/' . select_field('restaurants', 'id', $value->restaurant_id, 'slug') . '/menu') }}"
                class="{{ (Request::is('restaurants/*')) ? 'fancybox-fast-view' : '' }}" title="{{ $alts["product-pop-up"] }}">
                <div class="card-image">
                    Icon<img class="img-responsive" src="{{ $item_image1 }}" alt="{{ $item_image1 }}" style="width:32px;height:32px;padding-left:10px">
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div id="product-pop-up_{{ $value->id }}" class="popup-dialog-800" style="display: none;">
      <div class="product-page row product-pop-up p-popup">
        <div class="modal-body">
          <div class="col-sm-12 col-xs-12 title">
            <h2 style="color:white;">{{ $value->menu_item }}: $ {{ $value->price }}</h2>
          </div>
          <div class="col-sm-12 col-xs-12">
            <img class="popimage_{{ $value->id }}" style="width:600px;height:600px;" src="{{ $item_image }}" alt="{{ $alts["popimage"] }}"/>
          </div>
          <div class="clearfix"></div>

          <div class="product-titles">
            <h2>{{ $value->description }}</h2>
          </div>

          <div class="subitems_{{ $value->id }} optionals">
            <div class="clearfix space10"></div>
            <div style="display:none;">
              <input type="checkbox" style="display: none;" checked="checked" title="{{ $value->id.'_'.$value->menu_item.'-_'.$value->price.'_' }}"
                     value="" class="chk">
            </div>
            <div class="banner bannerz no-overflow">
              <table width="100%">
                <tbody>
                <?php
                    $submenus = \App\Http\Models\Menus::where('parent', $value->id)->get();
                ?>
                @foreach($submenus as $sub)
                  <tr>
                    <td width="100%" id="td_{{ $sub->id }}" class="valign-top">
                      <input type="hidden" value="{{ $sub->exact_upto_qty }}" id="extra_no_{{ $sub->id }}">
                      <input type="hidden" value="{{ $sub->req_opt }}" id="required_{{ $sub->id }}">
                      <input type="hidden" value="{{ $sub->sing_mul }}" id="multiple_{{ $sub->id }}">
                      <input type="hidden" value="{{ $sub->exact_upto }}" id="upto_{{ $sub->id }}">

                      <div class="infolist col-xs-12">
                        <div style="display: none;">
                          <input type="checkbox" value="{{ $sub->menu_item }}" title="___" id="{{ $sub->id }}" style="display: none;" checked="checked" class="chk">
                        </div>
                        <a href="javascript:void(0);"><strong>{{ $sub->menu_item }}</strong></a>
                        <span><em> </em></span>
                        <span class="limit-options right-float">
                        <?php
                            if ($sub->exact_upto == 0){
                                $upto = "up to ";
                            }else{
                                $upto = "exactly ";
                            }
                            if ($sub->req_opt == '0') {
                                if ($sub->exact_upto_qty > 0 && $sub->sing_mul == '0'){
                                    echo "(Select " . $upto . $sub->exact_upto_qty . " Items) ";
                                }
                                echo "(Optional)";
                            } elseif ($sub->req_opt == '1') {
                                if ($sub->exact_upto_qty > 0 && $sub->sing_mul == '0'){
                                    echo "Select " . $upto . $sub->exact_upto_qty . " Items ";
                                }
                                echo "(Mandatory)";
                            }
                        ?>
                        </span>

                        <div class="clearfix"></div>
                        <span class="error_{{ $sub->id }} strong-error"></span>

                        <div class="list clearfix">
                          <?php $mini_menus = \App\Http\Models\Menus::where('parent', $sub->id)->get(); ?>
                          @foreach($mini_menus as $mm)
                            <div class="col-xs-6 col-md-6" class="btn default btnxx pad-17">
                              <div class="pad-17">
                                <a title="{{ $alts["buttons"] }}" id="buttons_{{ $mm->id }}" class="buttons btn-plain" href="javascript:void(0);">
                                  <button class="btn btn-primary btn-curved"></button>
                                  <LABEL>
                                    <input type="{{ ($sub->sing_mul == '1') ? 'radio' : 'checkbox' }}" id="extra_{{ $mm->id }}"
                                           title="{{ $mm->id.'_<br/> '.$mm->menu_item.'_'.$mm->price.'_'.$sub->menu_item }}"
                                           class="extra-{{ $sub->id }}" name="extra_{{ $sub->id }}" value="post"/> &nbsp;&nbsp; {{ $mm->menu_item }}
                                    &nbsp;&nbsp; <?php if ($mm->price) echo "(+ $" . number_format(str_replace('$', '', $mm->price), 2) . ")"; ?>
                                  </LABEL>
                                  <b style="display:none;"></b>
                                </a>
                                <b style="display:none;"><a id="remspan_{{ $mm->id }}" title="{{ $alts["remspan"] }}" class="remspan plain" href="javascript:;"><b>&nbsp;&nbsp;-&nbsp;&nbsp;</b></a>
                                  <span id="sprice_0" class="span_{{ $mm->id }} allspan">&nbsp;&nbsp;1&nbsp;&nbsp;</span>
                                  <a id="addspan_{{ $mm->id }}" title="{{ $alts["addspan"] }}" class="addspan plain" href="javascript:;"><b>&nbsp;&nbsp;+&nbsp;&nbsp;</b></a>
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
              <div class="add-minus-btn left-float">
                <a class="btn btn-primary minus" title="{{ $alts["minus"] }}" href="javascript:void(0);" onclick="changeqty('{{ $value->id }}','minus')">-</a>

                <div class="number{{ $value->id }}">1</div>
                <a class="btn btn-primary add" title="{{ $alts["plus"] }}" href="javascript:void(0);" onclick="changeqty('{{ $value->id }}','plus')">+</a>
              </div>
              <a id="profilemenu{{ $value->id }}" class="btn btn-primary add_menu_profile add_end btn-spc right-float" title="{{ $alts["add"] }}" href="javascript:void(0);">Add</a>
              <button id="clear_{{ $value->id }}" title="{{ $alts["reset"] }}" data-dismiss="modal" class="btn btn-warning resetslider" type="button">
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
</div>