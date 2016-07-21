@extends('layouts.default')
@section('content')
    <script src="{{ asset('assets/global/scripts/provinces.js') }}"></script>
    <script src="{{ asset('assets/global/scripts/form-validation.js') }}"></script>
    @include("popups.rating")
    @include('menus')
    <?php
        $orderID = 0;
        $items=false;
        $order=false;

        if(isset($_GET["orderid"])){
            $orderID = $_GET["orderid"];
            $order = select_field("orders", "id", $orderID);
            $items = enum_all("orderitems", "order_id=" . $orderID);
        } else {
            $orderID = \App\Http\Models\Orders::newid();
        }

        $checkout_modal = false;
        $menu_id = iif($restaurant->franchise > 0, $restaurant->franchise, $restaurant->id);

        if (read("restaurant_id") && read("restaurant_id") != $restaurant->id) {
            popup(false, "You can not place orders as a restaurant owner", "Oops");
        }
        if($menu_id != $restaurant->id){
            popup(false, "Only the parent store can be edited", "Oops");
        }

        $is_my_restro = false;
        if (Session::has('session_restaurant_id') && Session::get('session_restaurant_id') == $restaurant->id) {
            $is_my_restro = true;
        }

        $business_day = \App\Http\Models\Restaurants::getbusinessday($restaurant);

        $alts = array(
            "add_item" => "Add Item"
        );

        $allowedtoupload = $is_my_restro && $menu_id == $restaurant->id;
        if (read("profiletype") == 1 || read("profiletype") == 3) {$allowedtoupload = true;}

        if(!$restaurant->latitude || !$restaurant->longitude){
            $restaurant->longitude = 0;
            $restaurant->latitude = 90;
        }
    ?>


    <div class="container" >
        <?php printfile("views/restaurants-menus.blade.php"); ?>
        <div class="row">

            <div class="col-lg-8 col-md-7 col-sm-12 ">

                @include("dashboard.restaurant.restaurantpanel", array("Restaurant" => $restaurant, "details" => true, "showtoday" => true))

                @if($allowedtoupload)
                        <a href="#" id="add_item0" type="button"
                           class="btn btn-success btn-lg additem  btn-block m-b-1"
                           data-toggle="modal"
                           title="{{ $alts["add_item"] }}"
                           data-target="#addMenuModel">
                            Upload Menu Item
                        </a>
                @endif

                <div class="overlay overlay_reservation">
                        <div class="loadmoreajaxloader"></div>
                    </div>
                    <div id="saveOrderChngBtn" style="display:none">
                        <input name="saveOrderChng" type="button" value="Save All Category Order Changes" onclick="saveCatOrderChngs()" /><span id="saveCatOrderMsg"></span>
                    </div>

                    <div class="clearfix"></div>
                    <div class="menu_div">
                        @if(isset($restaurant))
                            <input type="hidden" id="res_id" value="{{ $restaurant->id }}"/>
                        @endif

                        <?php
                            $itemPosnForJSStr="";
                            $catIDforJS_Str="";
                            $catNameStrJS="";
                            if(!isset($catid)){$catid=0;}
                            printmenu($__env, $restaurant, $catid, $itemPosnForJSStr, $catIDforJS_Str, $catNameStrJS, true, $allowedtoupload);
                        ?>

                        @if($allowedtoupload)
                                <a href="#" id="add_item0" type="button"
                                   class="btn btn-success btn-lg additem  btn-block m-b-1"
                                   data-toggle="modal"
                                   title="{{ $alts["add_item"] }}"
                                   data-target="#addMenuModel">
                                    Upload Menu Item
                                </a>
                        @endif
                    </div>


                <div class="col-lg-4 col-md-5 col-sm-12" id="printableArea">
                <?php
                    if(!isset($order)){$order = false;}
                    //printablereceipt($restaurant, $is_my_restro, $business_day, $checkout_modal, $__env, $order, $items);
                ?>
                </div>

                <div class="modal clearfix" id="addMenuModel" tabindex="-1" role="dialog" aria-labelledby="addMenuModelLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="addMenuModelLabel">Add Menu Item</h4>
                            </div>
                            <div class="modal-body" id="menumanager2"></div>
                            <div class="modal-footer">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal clearfix" id="editCatModel" tabindex="-1" role="dialog" aria-labelledby="editCatModelLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="editCatModelLabel">Edit Category</h4>
                            </div>
                            <div class="modal-body" id="categoryeditor"></div>
                            <div class="modal-footer">
                                <a id="saveeditor" class="btn btn-primary savebtn" debug="uses savebtn in additional.js" onclick="savecat();">Save</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
          </div>
      </div>
    </div>
</div>
</div>

<DIV ID="popupholder"></DIV>
<SCRIPT>isinreceipt = false;</SCRIPT>
@include('popups.more_detail')
<?php printscripts($checkout_modal, $orderID, $restaurant, $itemPosnForJSStr, $catIDforJS_Str, $catNameStrJS); ?>
@stop