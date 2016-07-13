<?php
    echo printfile("views/menus.blade.php");

    function printablereceipt($restaurant, $is_my_restro, $business_day, $checkout_modal, $__env, $order, $items){ ?>
        @include('common.receipt', array("restaurant" => $restaurant, "is_my_restro" => $is_my_restro, "is_open"=>$business_day, "checkout_modal" => $checkout_modal, "ordering" => true, "__env" => $__env, "order" => $order, "items" => $items))
        <?php
    }

function printmenu($__env, $restaurant, $catid, &$itemPosnForJSStr, &$catIDforJS_Str, &$catNameStrJS, $firstcat = true){
    $alts = array(
            "product-pop-up" => "Product info",
            "up_cat" => "Move Category up",
            "down_cat" => "Move Category down",
            "up_parent" => "Move this up",
            "down_parent" => "Move this down",
            "deleteMenu" => "Delete this item",
            "edititem" => "Edit this item",
            "editcat" => "Edit this category",
            "deletecat" => "Delete this category",
            "duplicate" => "Duplicate this item or category"
    );

    $cats = [];
    $catsOrder = [];
    $catCnt = 0;

    $category = \App\Http\Models\Category::where('res_id', $restaurant->id)->orderBy('display_order', 'ASC')->get();// all cats for resto in display_order
    foreach ($category as $cat) {
        $cats[$catCnt] = $cat->id;
        $catsOrder[$catCnt] = $cat->display_order;
        $catCnt++;
    }

    if (read('restaurant_id') == $restaurant->id || read("profiletype") != 2) {//is yours, doesnt need to be active
        $menus_list = App\Http\Models\Menus::where('restaurant_id', $restaurant->id)->where('parent', '0')->whereIn('cat_id', $cats)->orderBy('cat_id', 'ASC')->orderBy('display_order', 'ASC')->get();
    } else {
        //is not yours, needs to be active
        $menus_list = App\Http\Models\Menus::where('restaurant_id', $restaurant->id)->where('parent', '0')->whereIn('cat_id', $cats)->where('is_active', 1)->orderBy('display_order', 'ASC')->get();
    }

    $menuTSv = "?i=";
    $menuTS = read('menuTS');
    if ($menuTS) {
        $menuTSv = "?i=" . $menuTS;
        Session::forget('session_menuTS');
    }

    $menu_id = iif($restaurant->franchise > 0, $restaurant->franchise, $restaurant->id);
    $categories = enum_all("category", array("res_id" => $menu_id));
    $canedit = read('restaurant_id') == $restaurant->id || read("profiletype") == 1;

    $prevCat = "";
    $catNameStr = [];
    $parentCnt = [];
    $thisCatCnt = 0;
    $itemPosnForJS = [];
    $itemPosn = []; // to decide if js index needs a new array declared
    // $catCnt set in restaurants-menus.blade

    if (!isset($_GET['page'])) {
        echo '<div" id="loadmenus_' . $catid . '">';
    }
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

    $catMenuCnt = 0;
    $trueID = 0;
    $isBeingIncluded = ReceiptVersion && !$firstcat;

    $thisCatCnt = 0;
    $lastcategory = count($valueA) - 1;
    echo '<div id="accordion" role="tablist" aria-multiselectable="true">';
    foreach ($valueA as $index => $category) {
        $last = count($category) - 1;
        printmenuitems($category, true, $categories, $thisCatCnt, $prevCat, $catCnt, $restaurant, $menu_id, $catMenuCnt, $alts, $__env, $last, $firstcat, $trueID, $itemPosnForJS, $parentCnt, $lastcategory, $catNameStr, $isBeingIncluded);
        $firstcat = false;
        $thisCatCnt++;
        $catMenuCnt++;
        $trueID++;
    }
    echo '</div><div class="clearfix"></div></div></div></DIV><!-- end of last category -->';

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
    if (!isset($_GET['page'])) {
        echo '</div></div>';
    }
}

function consolelog($text){
    if (isset($GLOBALS["debug"])) {
        $GLOBALS["debug"] .= "  -  " . $text;
    } else {
        $GLOBALS["debug"] = $text;
    }
}

function printmenuitems($category, $even, $categories, $thisCatCnt, $prevCat, $catCnt, $restaurant, $menu_id, $catMenuCnt,
                        $alts, $__env, $last, $firstcat, $catindex, &$itemPosnForJS, &$parentCnt, $lastcategory, &$catNameStr, $isBeingIncluded){
    $halfway = ceil(count($category) * 0.5);
    foreach ($category as $index => $value) {
        $isfirst = $index == 0;
        $islast = $index == $last;
        $catMenuCnt = printmenuitem($categories, $value, $index, $thisCatCnt, $isfirst, $islast, $catCnt, $restaurant,
                $menu_id, $catMenuCnt, $alts, $__env, $firstcat, $catindex, $itemPosnForJS, $parentCnt, $lastcategory, $catNameStr, $halfway, $isBeingIncluded);
    }
}

function iseven($number){
    return $number % 2 == 0;
}

echo '<!---- START PRINT MENU ITEMS ------>';

function printmenuitem($categories, $value, $index, $thisCatCnt, $isfirst, $islast, $catCnt, $restaurant, $menu_id,
                       $catMenuCnt, $alts, $__env, $firstcat, $catindex, &$itemPosnForJS, &$parentCnt, $lastcategory, &$catNameStr, $halfway, $isBeingIncluded){
$noUpCatSort = false;
$canedit = read("profiletype") == 1 || read("restaurant_id") == $restaurant->id;
if ($isBeingIncluded) {
    $canedit = false;
    $thisCatCnt = $value->id;
    $catindex = $value->id;
}
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

if($isfirst){
$thisUpMenuVisib = "hidden";
if ($catMenuCnt) {
    echo '</div></div><!-- end of previous category -->';
}
$prevCat = $value->cat_id;
$value->cat_name = getIterator($categories, "id", $prevCat)->title;

$catNameStr[$prevCat] = $value->cat_name;
$thisUpCatSort = iif($noUpCatSort, "hidden", "visible");
$thisDownCatSort = iif($lastcategory == $thisCatCnt, "hidden", "visible");

if ($menu_id == $restaurant->id) {
    $canedit = $canedit || (read("profiletype") == 3 && $value->uploaded_by == read("id"));
}
if (!$canedit) {
    $thisUpCatSort = 'hidden';
    $thisDownCatSort = 'hidden';
    $thisDownMenuVisib = 'hidden';
    $thisUpMenuVisib = 'hidden';
}
?>

<DIV class=" {{ iif(!$firstcat, "collapsed") }} " id="c{{ $thisCatCnt }}"><!-- start of this category -->
    <div class="parents ">
        <!-- start of category heading -->

        <li class="list-group-item" style="background: #f3f3f3;border-bottom:0px !important;cursor: pointer;">
            <div class="restcat_{{ $value->restaurant_id }}" data-toggle="collapse" data-target="#cat_{{ $catindex }}">
              ~  <a style="color:#373a3c;"  name="<?php echo $value->cat_name; ?>"><?=$value->cat_name; ?></a>
            </div>
            <div class="" id="save{{ $thisCatCnt }}" style="display:none;color:#f00"><input
                        name="saveOrderChng" type="button" value="Save All Category Order Changes"
                        onclick="saveCatOrderChngs({{ $thisCatCnt }})"/><span
                        id="saveCatOrderMsg{{ $thisCatCnt }}"></span></div>
            <div class=" pull-right" id="saveMenus{{ $value->cat_id }}"
                 style="display:none;color:#f00"><input name="saveOrderChng" type="button"
                                                        value="Save Category Sorting"
                                                        onclick="saveMenuOrder({{ $value->cat_id }},false,false)"/><span
                        id="saveMenuOrderMsg{{ $value->cat_id }}"></span></div>
        </li>


    </div>
    <DIV ID="cat_{{ $catindex }}" CLASS="{{ iif(!$firstcat, "collapse", "collapse in") }}">
        <DIV CLASS="">
            <?php
            $thisCatCnt++;
            $catMenuCnt++;
            }

            if ($index == $halfway) {
                echo '</DIV><DIV CLASS="">';
            }

            ?>

                <div id="parent{{ $value->cat_id }}_{{ $value->display_order }}">

                    <a style="hover:bac" href="#" id="{{ $value->id }}" name="{{ $value->id }}"
                       title="{{ $alts["product-pop-up"] }}"
                       class="card-link" data-toggle="modal"
                    >

                        <div ID="divfour_{{ $value->cat_id }}">
                            @include("menuitem")
                        </div>
                    </a>

                </div>


            <?php
            return $catMenuCnt++;
            }
            ?>



        <!---- END PRINT MENU ITEMS ------>


            <!---- START PRINT SCRIPTS ------>

            <?php
            function printscripts($checkout_modal, $orderID, $restaurant, $itemPosnForJSStr, $catIDforJS_Str, $catNameStrJS){
            $slug = "";
            if (isset($restaurant->slug)) {
                $slug = $restaurant->slug;
            }
            ?>
            <script src="{{ asset('assets/global/scripts/menu_manager.js') }}"></script>
            <script src="{{ asset('assets/global/scripts/receipt' . ReceiptVersion . '.js') }}"></script>
            <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
            <script src="{{ asset('assets/global/scripts/stripe.js') }}"></script>

            <script>
                var catPosn = [];
                var itemPosn = [];
                var restSlug = "{{ $slug }}";
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

                .panel-heading {
                    cursor: pointer;
                }
            </style>
            <SCRIPT>
                        <?php echo $itemPosnForJSStr;?>

                var itemPosnOrig = itemPosn;
                var menuSortChngs = [];
                var catOrigPosns = [<?= $catIDforJS_Str;?>]; // as original cat posns as indexes, with the values being the db cat_id
                var currentCatOrderIDs = catOrigPosns;//Not sure if we'll need this - surrounding cat divs stay same on pg (indexes in array), but value chng to the cat_id
                catNameA = ['<?= $catNameStrJS;?>'];
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
                function checkmenuitem(event, ID, main_price, dis) {
                    if (!$("#product-pop-up_" + ID).length) {
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
                            $("#popupholder").append(result);
                            if (receiptversion) {
                                showproductpopup(ID);
                            } else {
                                $(temptarget).trigger("click");
                            }
                        });
                    } else if (receiptversion) {
                        showproductpopup(ID);
                    }
                }

                function confirmclearForm(ID) {
                    confirm2('Are you sure you want to erase your data?', function (tthis, data) {
                        clearForm(data.ID);
                    }, {ID: ID});
                }
                function clearForm(ID) {
                    log("Clearing: " + ID);
                    var Parent = "#product-pop-up_" + ID;
                    $(Parent).find('input:visible').not(':button, :submit, :reset, :hidden, :checkbox, :radio :hidden').val('');
                    $(Parent).find(':checkbox, :radio').filter(':visible').prop('checked', false);
                    $("#select" + ID).val(1);
                    changeqty(ID, 1);
                    $(".modalprice" + ID).text("$" + Number($("#originalprice" + ID).val()).toFixed(2) );
                }

                function showproductpopup(ID) {
                    if ($("#profilemenu" + ID).hasClass("has_items")) {
                        $("#product-pop-up_" + ID).modal({
                            backdrop: 'static',   // This disable for click outside event
                            keyboard: true        // This for keyboard event
                        });
                        clearForm(ID);
                    } else {
                        $("#profilemenu" + ID).trigger("click");
                    }
                }

                function collapseall(value) {
                    var temp;
                    $(".panel-heading").each(function () {
                        temp = $(this).next().attr('aria-expanded');
                        if (temp == null || temp === undefined) {
                            temp = "false";
                        }
                        if (temp == value) {
                            $(this).trigger("click");
                        }
                    });
                }

                @if(isset($GLOBALS["debug"]))
                    console.log("{{ $GLOBALS["debug"] }}");
                @endif

                function confirmcopy(URL, itemtype, name) {
                    if (itemtype == "category") {
                        itemtype = itemtype + " and all of it's items";
                    }
                    confirm2("Do you want to duplicate the '" + name + "' " + itemtype + "?", function (tthis, data) {
                        window.location.href = URL;
                    }, {url: URL});
                }

                var checkout_modal = "{{ $checkout_modal }}";
                var order_id = "{{ $orderID }}";
                console.log("Order ID " + order_id);

                function addresschange(where) {
                    log("Menus.blade");
                    //code for adding addresses to the drop down is in views/common/receipt.blade.php
                    var forcedelivery = true;

                    var found = false;
                    var element = false;
                    var address = "your address";

                    if (where == "editaddress") {
                        addresschanged($("#reservation_address option:selected").get(0));
                    }

                    if ($("#delivery1").is(":checked") || forcedelivery) {
                        if ($("#reservation_address").length) {
                            var value = $("#reservation_address").val();
                            address = "Address ID: " + value;
                            var element = $("#reservation_address option").filter(":selected");
                            if (element) {
                                var address_latitude = element.attr("latitude");
                                var address_longitude = element.attr("longitude");
                                found = !isundefined(element.attr("latitude"));
                                address = element.text();
                            }
                        } else {
                            address = $("#formatted_address").val();
                            var address_latitude = Number($("#order_latitude").val());
                            var address_longitude = Number($("#order_longitude").val());
                            found = address && address_latitude && address_longitude;
                        }
                    } else {
                        var address_latitude = $("#order_latitude").val();
                        var address_longitude = $("#order_longitude").val();
                        found = address_latitude && address_longitude && !$("#ordered_email-error").is(":visible");
                    }

                    if (found) {

                        var message = "";
                        var storedistances = "The address: " + address_latitude + " - " + address_longitude + "<BR>";
                        $( ".receipt_item" ).each(function() {
                            var distance = calcdistance($(this).attr("latitude"), $(this).attr("longitude"), address_latitude, address_longitude);
                            storedistances = storedistances + unescapetext($(this).attr("name")) + " is at " + $(this).attr("latitude") + ", " + $(this).attr("longitude") + " and is " + distance + " km";
                            if (distance > $(this).attr("maxdistance") ) {
                                message = message + unescapetext($(this).attr("name")) + " will only deliver within " + $(this).attr("maxdistance") + " km<BR>" + address + " is " + distance.toFixed(2) + " km away.<BR>";
                            }
                        });
                        if(message){
                            @if(debugmode())
                               if (where == "addresscheck") {
                                    message = message.replaceAll("<BR>", "\n", message);
                                    return confirm(message + "Would you like to bypass this restriction? (DEBUG MODE)");
                               }
                            @endif
                            alert(message);
                            return false;
                        } else if (debugmode){
                            alert(storedistances);
                        }

                        if (element) {
                            element.trigger("click");
                        }
                        return true;
                    } else if (where == "addresscheck") {
                        alert("No Address Specified");
                        return false;
                    }

                    return true;
                }

                function check_val(v) {
                }


                        <?php if (!islive()) {
                            echo "Stripe.setPublishableKey('pk_rlgl8pX7nDG2JA8O3jwrtqKpaDIVf'); //test";
                        } else {
                            echo "Stripe.setPublishableKey('pk_vnR0dLVmyF34VAqSegbpBvhfhaLNi'); //live";
                        }?>

                        function orderdata(){
                            var token = $('#profiles input[name=_token]').val();
                            var datas = $('#profiles input, select, textarea').serialize();
                            var order_data = $('.receipt_main input').serialize();
                            //checkingout = true;
                            return datas + '&' + order_data + '&_token=' + token + '&order_id=' + order_id;
                        }

                var stripeResponseHandler = function (status, response) {
                            //var $form = $('#payment-form');
                            var $form = $('#profiles');
                            if (response.error) {
                                // Show the errors on the form
                                log("Stripe error: " + response.error.message);
                                $form.find('.payment-errors').text(response.error.message);
                                $form.find('button').prop('disabled', false);
                                overlay_loader_hide();
                                $('#chkOut').removeAttr('disabled');
                            } else {
                                // token contains id, last4, and card type
                                var token = response.id;
                                // Insert the token into the form so it gets submitted to the server
                                $('.stripeToken').val(token);

                                //alert(order_data);
                                $.ajax({
                                    type: 'post',
                                    url: '<?php echo url(); ?>/user/ajax_register',
                                    data: orderdata(),
                                    success: function (msg) {

                                        msg = msg.trim();
                                        $('#chkOut').removeAttr('disabled');
                                        var hide = true;
                                        if (msg == '1') {
                                            $('#ordered_email').focus();
                                            $('.email_error').show();
                                            $('.email_error').html('Email Already Registered.');
                                        } else if (msg == '6') {
                                            window.location = "{{url('orders/list/user?flash=1')}}";
                                            hide = false;
                                            $('.top-cart-content ').html("<span class='thankyou'>Thank you! Your order has been received</span>");
                                        } else if (msg == '786') {
                                            hide = false;
                                            window.location = "{{url('orders/list/user?flash=2')}}";
                                            $('.top-cart-content ').html("<span class='thankyou'>Thank you! Your order has been received and your account has been created</span>");
                                        } else {
                                            $('.payment-errors').html(msg);
                                            console.log("stripeResponseHandler");
                                            //alert( msg, "stripeResponseHandler" );
                                        }
                                        if (hide) {
                                            overlay_loader_hide();
                                        }
                                    }
                                })

                            }
                        };
                $(document).ready(function () {
                    var delivery_type = getCookie("delivery_type");
                    if (!delivery_type) {
                        delivery_type == "is_delivery";
                    }
                    if (delivery_type == "is_pickup") {
                        $("#pickup1").trigger("click");
                    } else {
                        $("#delivery1").trigger("click");
                    }

                    function validatePassword() {
                        var password = document.getElementById("password"), confirm_password = document.getElementById("confirm_password");
                        if (password.value != confirm_password.value) {
                            confirm_password.setCustomValidity("Passwords Don't Match");
                        } else {
                            confirm_password.setCustomValidity('');
                            $('#confirm_password').removeAttr('required');
                        }
                    }

                    $('.back').live('click', function () {
                        log(".back event");
                        $('.receipt_main').show();
                        $('.profiles').hide();
                    });

                    //submission of order
                    $('#profiles').submit(function (e) {
                        log("'#profiles submit event in restaurants-menus");
                        if ($("#cardnumber-error").length || $("#cvc-error").length) {
                            if ($("#cardnumber-error").length) {
                                if ($("#cvc-error").length) {
                                    $("#cardnumber-error").text("These fields are required.");
                                }
                                var tempstr = $("#cardnumber-error")[0];
                            } else {
                                var tempstr = $("#cvc-error")[0];
                            }
                            $("#cardnumber-error").remove();
                            $("#cvc-error").remove();
                            $("#cardcvc").html(tempstr);
                        }

                        var errors = $("label.error[for!='cardnumber'][for!='cvc']").filter(":visible").length;
                        if (errors) {
                            console.log("form validation detected " + errors + " errors");
                            return false;
                        }

                        e.preventDefault();
                        $('#chkOut').attr('disabled', 'disabled');
                        overlay_loader_show();
                        if ($('.CC').is(':visible')) {
                            Stripe.card.createToken($('#profiles'), stripeResponseHandler);
                        } else {
                            //why are there 2 huge identical blocks of code?
                            $.ajax({
                                type: 'post',
                                url: '<?php echo url(); ?>/user/ajax_register',
                                data: orderdata(),
                                success: function (msg) {
                                    msg = msg.trim();
                                    $('#chkOut').removeAttr('disabled');
                                    var hide = true;
                                    if (msg == '1') {
                                        $('#ordered_email').focus();
                                        $('.email_error').show();
                                        $('.email_error').html('Email Already Registered.');
                                    } else if (msg == '6') {
                                        hide = false;
                                        checkingout = true;
                                        window.location = "{{url('orders/list/user?flash=1')}}";
                                        $('.top-cart-content ').html("<span class='thankyou'>Thank you! Your order has been received</span>");
                                    } else if (msg == '786') {
                                        hide = false;
                                        checkingout = true;
                                        window.location = "{{url('orders/list/user?flash=2')}}";
                                        $('.top-cart-content ').html("<span class='thankyou'>Thank you! Your order has been received and your account has been created</span>");
                                    } else {
                                        log("$('#profiles').submit in restaurants-menus.blade.php: " + msg);
                                        msg = jQuery(msg).text().trim();
                                        if (msg) {
                                            alert(jQuery(msg).text(), "$('#profiles').submit(function (e) {");
                                        }
                                    }
                                    if (hide) {
                                        overlay_loader_hide();
                                    }
                                }
                            })
                        }

                    });

                    function iif(value, iftrue, iffalse) {
                        if (value) {
                            return iftrue;
                        }
                        if (isundefined(iffalse)) {
                            return "";
                        }
                        return iffalse;
                    }

                    function ordererror(err, catid, td_index, td_temp, text) {
                        err++;
                        td_index = $('#td_' + catid).index();
                        if (td_temp >= td_index) {
                            td_temp = td_index;
                        } else {
                            td_temp = td_temp;
                        }
                        $('.error_' + catid).html(text);
                        return err;
                    }

                    $('.modal').on('shown.bs.modal', function () {
                        $('input:text:visible:first', this).focus();
                    });
                    $('.clearall , .close').click(function () {
                        var menu = $(this).attr('id');
                        if (menu) {
                            menu = menu.replace('clear_', '');
//alert(menu);
                            $('.subitems_' + menu).find('input:checkbox, input:radio').each(function () {
                                if (!$(this).hasClass('chk'))
                                    $(this).removeAttr("checked");
                                $('.allspan').html('0');
                            });
                            $('.inp').val("");
                        }
                        $('.fancybox-close').click();
                    });
                    $('.resetslider').live('click', function () {
                        log(".resetslider event");
                        var menu = $(this).attr('id');
                        menu = menu.replace('clear_', '');
                        $('.number' + menu).html('1');
                        $('#select' + menu).val('1');
//alert(menu);
                        $('.subitems_' + menu).find('input:checkbox, input:radio').each(function () {
                            if (!$(this).hasClass('chk'))
                                $(this).removeAttr("checked");
                            $('.allspan').html('0');
                        });
                        $('.inp').val("");
                        $(this).parent().parent().find('.nxt_button').show();
                        $(this).parent().parent().find('.nxt_button').attr('title', '1');
                        $(this).parent().parent().find('.prv_button').hide();
                        var banner = $(this).parent().parent().parent().find('.bannerz');
                        banner.animate({scrollLeft: 0}, 1000);
                    });
//add items to receipt
                    var counter_item = 0;
                    $('.add_menu_profile').live('click', function () {
                        log(".add_menu_profile event");
                        var menu_id = $(this).attr('id').replace('profilemenu', '');
                        var ids = "";
                        var app_title = "";
                        var price = "";
                        var extratitle = "";
                        var dbtitle = "";
                        var err = 0;
                        var catarray = [];
                        var td_index = 0;
                        var td_temp = 9999;
                        var n_counter = 0;
                        var csr = $("#csr" + menu_id).val();

                        $('.subitems_' + menu_id).find('input:checkbox, input:radio').each(function (index) {
                            if ($(this).hasClass('checked') || ($(this).is(':checked') && $(this).attr('title') != "")) {
                                var tit = $(this).attr('title');
                                var title = tit.split("_");
                                if (index != 0) {
                                    extratitle = extratitle + "," + title[1];
                                }
                                var su = "";
                                if ($(this).val() != "") {
                                    var cnn = 0;
                                    var catid = $(this).attr('id');
                                    catarray.push(catid);
                                    var is_required = $('#required_' + catid).val();
                                    var extra_no = $('#extra_no_' + catid).val();
                                    if (extra_no == 0) {
                                        extra_no = 1;
                                    }
                                    var multiples = $('#multiple_' + catid).val();
                                    var upto = Number($('#upto_' + catid).val());
                                    var ary_qty = "";
                                    var ary_price = "";
                                    $('.extra-' + catid).each(function () {
                                        if ($(this).is(":checked")) {
                                            var mid = $(this).attr('id').replace('extra_', '');
                                            var qty = Number($(this).parents().find('.span_' + mid).text().trim());

                                            if (qty != "") {
                                                cnn += Number(qty);
                                            } else {
                                                cnn++;
                                            }
                                        }
                                    });

                                    //cnn = how many are selected
                                    //is_required: 1 if required, 0 if not
                                    //extra_no: quantity limit
                                    //upto: 0 if up to extra_no, 1 if exactly extra_no, 2 if unlimited
                                    //multiples: 1 if can only select a single item, 0 if multiple items are allowed
                                    //log("is_required " + is_required + " upto " + upto + " multiples " + multiples + " cnn " + cnn + " extra_no " + extra_no);
                                    /*
                                    if (debugmode) {
                                        log("Checking " + catid + " (" + $("#title_" + catid).text().trim + ")");
                                        log("cnn (how many are selected): " + cnn);
                                        log("is_required (0=no, 1=yes):   " + is_required + " (" + (cnn > 0) + ")");
                                        log("multiples (1=no, 0=yes):     " + multiples + " (" + iif(multiples == 0, true, cnn == 1) + ")");
                                        log("extra_no (quantity limit):   " + extra_no + " (" + (cnn <= extra_no) + ")");
                                        log("upto:                        " + upto);
                                        switch (upto) {
                                            case 0:
                                                log(cnn + " can be between 0 and " + extra_no + " (" + (cnn <= extra_no) + ")");
                                                break;
                                            case 1:
                                                log(cnn + " must be exactly " + extra_no + " (" + (cnn == extra_no) + ")");
                                                break;
                                            case 2:
                                                log(cnn + " can unlimited (" + true + ")");
                                                break;
                                        }
                                    }
                                    */

                                    $('.error_' + catid).html("");
                                    if (is_required == '1') {//if items are required
                                        if (cnn == 0) {//no items are selected
                                            err = ordererror(err, catid, td_index, td_temp, "Options are required");
                                        } else if (upto == 1 && cnn != extra_no) {//exact number required but not given
                                            err = ordererror(err, catid, td_index, td_temp, "Select up to " + extra_no + " Options");
                                        } else if (multiples == 0 && cnn > extra_no && upto < 2) {//multiple items are allowed, selected is above the limit, limit is not unlimited
                                            err = ordererror(err, catid, td_index, td_temp, "Select up to " + extra_no + " Options");
                                        }
                                    } else if (upto < 2) {//if items are not required, and limit is not unlimited
                                        if (upto == 1 && cnn != extra_no && cnn > 0) {//exact number required but not given
                                            err = ordererror(err, catid, td_index, td_temp, "Select up to " + extra_no + " Options");
                                        } else if (multiples == 0 && cnn > 0 && cnn > extra_no) {//multiple items are allowed, selected is above the limit
                                            err = ordererror(err, catid, td_index, td_temp, "Select " + extra_no + " Options (" + multiples + ", " + cnn + ", " + extra_no + ")");
                                        }
                                    }

                                    if (cnn > 0) {
                                        su = $(this).val();
                                        extratitle = extratitle + " " + su + ":";
                                        app_title = app_title + " " + su + ":";
                                    }
                                }
                                var x = index;
                                if (title[0] != "") {
                                    ids = ids + "_" + title[0];
                                }
                                app_title = app_title + "," + title[1];
                                price = Number(price) + Number(title[2]);
                            }
                        });
                        if (err > 0) {
                            scrollto($(".errormsg").filter(":visible").first());
                            return false;
                        } else {
                            var banner = $(this).parent().parent().parent().find('.bannerz');
                            $(this).parent().parent().find('.nxt_button').attr('title', '1');
                            $(this).parent().parent().find('.prv_button').hide();
                            banner.animate({scrollLeft: 0}, 10);
                            $(this).parent().parent().find('.nxt_button').show();
                            catarray.forEach(function (catid) {
                                $('#error_' + catid).html("");
                            });
                        }

                        ids = ids.replace("__", "_");
                        app_title = app_title.split(",,").join("");
                        app_title = app_title.substring(1, app_title.length);
                        var last = app_title.substring(app_title.length, app_title.length - 1);
                        if (last == ",") {
                            app_title = app_title.substring(0, app_title.length - 1);
                        }
                        var last = app_title.substring(app_title.length, app_title.length - 1);
                        if (last == "-") {
                            app_title = app_title.substring(0, app_title.length - 1);
                        }
                        app_title = app_title.split(",(").join("(");
                        app_title = app_title.split("-").join(" -");
                        app_title = app_title.split("-,").join("-");
                        app_title = app_title.split(",").join(", ");
                        app_title = app_title.split(":").join(": ");
                        app_title = app_title.split("x,").join("x");
                        extratitle = extratitle.split(":,").join(":");
                        extratitle = extratitle.substring(1, extratitle.length);
                        var last1 = extratitle.substring(extratitle.length, extratitle.length - 1);
                        if (last1 == ",") {
                            extratitle = extratitle.substring(0, extratitle.length - 1);
                        }
                        var last1 = extratitle.substring(extratitle.length, extratitle.length - 1);
                        if (last1 == "-") {
                            extratitle = extratitle.substring(0, extratitle.length - 1);
                        }
                        dbtitle = extratitle.split(",").join("%");
                        dbtitle = dbtitle.split("%%").join("");

                        var pre_cnt = $('#list' + ids).find('.count').text();
                        pre_cnt = parseInt(Number(pre_cnt.replace('x', '')));
                        var n = parseInt($('.number' + menu_id).text());
                        if (pre_cnt != "") {
                            pre_cnt = Number(pre_cnt) + Number(n);
                        } else {
                            pre_cnt = Number(n);
                        }

                        additemtoreceipt(menu_id, ids, pre_cnt, price, csr, app_title, extratitle, dbtitle);

                        showloader();
                        $('.allspan').html('0');
                        $('.close' + menu_id).click();

                        show_header();
                        total_items = "(" + (parseInt(Number(total_items)) + parseInt(Number(n))) + ")";

                        updatecart("add_menu_profile click");

                        clearForm(menu_id);
                    });

                    function inArray(needle, haystack) {
                        var length = haystack.length;
                        for (var i = 0; i < length; i++) {
                            if (haystack[i] == needle) {
                                return true;
                            }
                        }
                        return false;
                    }

                    $(document).on('click', '.loadmore', function () {
                        var catid = $(this).attr('title');
                        overlay_loader_show();
                        ur = $('.next_' + catid + ' a').attr('href');
                        if (ur != '') {
                            url1 = ur.replace('/?', '?');
                            $.ajax({
                                url: url1,
                                success: function (html) {
                                    $('#LoadMoreBtnContainer' + catid).remove();
                                    if (html) {
                                        $('.nxtpage_' + catid).remove();
                                        $("#loadmenus_" + catid).append(html);
                                        overlay_loader_hide();
                                    } else {
                                        $('div#loadmoreajaxloader_' + catid).html('<center>No more menus to show.</center>');
                                    }
                                }
                            });
                        } else {
                            $('div#loadmoreajaxloader_' + catid).html('<center>No more menus to show.</center>');
                            $(this).parent().remove();
                        }
                    });

                    <?php if(isset($_GET["menuitem"]) && $_GET["menuitem"]): ?>
                        setTimeout(function () {
                        $("#add_item<?php echo e($_GET["menuitem"]); ?>").trigger("click");
                    }, 500);
                    <?php endif; ?>
                    //updatecart();
                });
                //updatecart("restaurants-menus.blade.php");

                function changeitem(id) {
                    var CURRENT = $('#qty' + id).val(), DESIRED = $('#itemsel' + id).val(), QTY = 0, DIR = "";
                    if (CURRENT > DESIRED) {
                        DIR = "dec" + id;
                        QTY = CURRENT - DESIRED;
                    } else if (CURRENT < DESIRED) {
                        DIR = "inc" + id;
                        QTY = DESIRED - CURRENT;
                    }
                    if (QTY) {
                        for (i = 0; i < QTY; i++) {
                            $("#" + DIR).trigger("click");
                        }
                    }
                }

                function makeselect(start, end, selected) {
                    var tempstr, tempstr2;
                    for (i = start; i <= end; i++) {
                        tempstr = tempstr + '<OPTION VALUE="' + i + '"';
                        if (selected == i) {
                            tempstr = tempstr + ' SELECTED';
                        }
                        tempstr = tempstr + '>' + i + '</OPTION>';
                    }
                    return tempstr;
                }
            </script>
            <script type="text/javascript">
                //Google Api Codes.
                $('body').on('change', '#formatted_address', function () {
                    if ($(this).val()) {
                        //window.location = "{{ url('restaurants') }}/" + $(this).val();
                    }
                });

                function onheaderload() {
                    setTimeout(function () {
                        updatecart("onlogin rest");
                    }, 1500);
                }
            </script>
            <?php } ?>
        <!---- END PRINT SCRIPTS ------>


            <!---- delete from here ------>


            @if(false)
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
            @endif







            @if(false)
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

            <script>
                function showItem(c, m) {
                    return c + "  --  " + m + "  --  " + itemPosn[c][m];
                }
            </script>

            @if(false)
                @if(debugmode())
                    <div style="color:#FF0000" class="debugdata btn-group pull-left">
                        parent{{ $value->cat_id . '_' . $value->display_order . " ID: " . $value->id . ', ' . $value->cat_id . ', ' . $value->display_order . ', "down", ' . $catMenuCnt . ", " . $index }}
                    </div>
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

                <A TITLE="{{ $alts["duplicate"] }}" class="btn btn-sm btn-link pull-right"
                   onclick="confirmcopy('{{ url("restaurant/copyitem/item/" . $value->id) }}', 'item', '{{ $value->menu_item }}');">
                    <i class="fa fa-files-o"></i>
                </A>

@endif