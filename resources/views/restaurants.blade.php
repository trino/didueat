<?php
$IncludeMenu = true;

if ($IncludeMenu) {
    $orderID = 0;
    $items = false;
    $order = false;
    if (ReceiptVersion) {
        if (isset($_GET["orderid"])) {
            $orderID = $_GET["orderid"];
            $order = select_field("orders", "id", $orderID);
            $items = enum_all("orderitems", "order_id=" . $orderID);
        } else {
            $orderID = \App\Http\Models\Orders::newid();
        }
    }
    $itemPosnForJSStr = "";
    $catIDforJS_Str = "";
    $catNameStrJS = "";
}
$IncludeMenuBackup = $IncludeMenu;
$first = false;
$type = "hidden";
//$localIPTst = $_SERVER['REMOTE_ADDR'];
//$localIPTst = "24.36.50.14"; // needed for wamp -- remove from remote server
$latlngStr = "";
$locationStr = "";
$useCookie = false;
$useHamilton = true;
$is_pickup_checked = "";
$is_delivery_checked = "";
$is_menu_checked = iif(isset($_COOKIE["is_menu"]) && $_COOKIE["is_menu"], " CHECKED");
if (isset($_COOKIE['delivery_type'])) {
    switch ($_COOKIE['delivery_type']) {
        case "is_delivery":
            $is_delivery_checked = "checked";
            break;
        case "is_pickup":
            $is_pickup_checked = "checked";
            break;
        default:
            $is_delivery_checked = "checked";
            $is_pickup_checked = "checked";
    }
} else {
    $is_delivery_checked = "checked";
    $is_pickup_checked = "checked";
}


if ($useHamilton) {
    $City = "Hamilton";
    $Province = "Ontario";
    $Country = "Canada";
    $latHam = "43.2566983";
    $lonHam = "-79.8690719";
    $loc = "43.2566983,-79.8690719";
} else if (is_object($details)) {
    $loc = $details->loc;
}

$alts = array(
        "city" => "View restaurants for this city",
        "signup" => "Sign up as a restaurant owner"
);
?>
@if($IncludeMenu)
    @include('menus')
@endif

@extends('layouts.default')
@section('content')

    <div class=" main-bg-image " style="">
        <div class="" style="margin-top: 0 !important;">
            <div class=" text-xs-center" style="">


            @include('common.search_bar')



            <!--div class="col-md-offset-2 text-xs-center col-md-8" style="">
                    <h1 class="banner-text-shadow m-y-1"><span style="font-size: 125%;font-weight: 500;">Hamilton Restaurants<br>& Delivery</span>
                    </h1>
                    <div class="clearfix"></div>
                </div-->


                <!--div class="col-md-offset-2 text-xs-center col-md-8" style="">

                    <a class="btn btn-lg btn-link btn-responsive "
                       href="{{ url("restaurants/signup") }}" title="{{ $alts["signup"] }}" style="color: white;"><h5
                                class="banner-text-shadow">Restaurant Sign Up</h5></a>

                    <div class="clearfix"></div>

                </div>

                <div class="clearfix"></div-->
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="container hidden-md-down"></div>

    </div>
    </div>
    </div>

    @include("popups.rating")
    <div class="container hidden-md-down">
    </div>
    <div class="" style="">

        <?php printfile("views/restaurants.blade.php"); ?>

        <div class="row m-t-2">

            <div class="" id="results_show" style="display: none;">
                <div class="col-lg-9 m-b-2">
                    <?php popup(true, "message:nostores", false, false, ''); $IncludeMenu = false; ?>
                    @include('ajax.search_restaurants')
                </div>
                <div class="col-lg-3" ID="filter-results" style="height: 100%;">
                    <div class="" style="">
                        <div class="card-footer text-xs-right" style="display: none">
                            <input type="button" name="search" class="btn btn-primary" value="Filter"
                                   id="search-form-submit"
                                   onclick="submitform(event, 0, 'search onclick');"/>
                        </div>
                    </div>

                    <div class="col-lg-12 followTo" style="width:350px;">
                        <?php
                            if ($IncludeMenuBackup && ReceiptVersion) {
                                printablereceipt(false, false, true, true, $__env, $order, $items);
                                printscripts(true, $orderID, false, $itemPosnForJSStr, $catIDforJS_Str, $catNameStrJS);
                            }
                            if(debugmode() || read("profiletype") == 1){
                                echo '<A ONCLICK="expandcollapseall(true);">Expand All</A><BR><A ONCLICK="expandcollapseall(false);">Collapse All</A>';
                            }
                        ?>
                    </div>

                </div>
            </div>

            @if(!Session::has('is_logged_in') && false)
                <div class="col-lg-12 text-xs-center p-t-0">
                    <hr>
                    <div class="text-xs-center m-b-0 p-a-1 text-muted" style="width: 100%">
                        <h2>ADVERTISE FOR FREE. GO ONLINE ANYTIME.</h2>
                        <!--a class="btn btn-lg btn-success-outline btn-responsive" data-toggle="modal" data-target="#signupModal">SIGN UP NOW!</a-->
                        <a class="btn btn-lg btn-success-outline btn-responsive"
                           href="{{ url("restaurants/signup") }}" title="{{ $alts["signup"] }}">Restaurant Sign
                            Up</a>
                    </div>
                </div>
                <div class="clearfix"></div>

            @endif

        </div>
        <div id="element"></div>
    </div>


    <script type="text/javascript">
        var elementname = '#formatted_address2';
        var IgnoreOne = false;
        var startingat = 0;
        onloadpage();

        function setdeliverytype() {
            deliverytype = ""
            var text, replacewith = "delivery_type="
            if (document.getElementById('deliverycb').checked && document.getElementById('pickupcb').checked) {
                deliverytype = "both";
                replacewith = replacewith + "both";
            } else {
                if (document.getElementById('pickupcb').checked) {
                    deliverytype = "is_pickup";
                    replacewith = replacewith + "is_pickup";
                } else {
                    deliverytype = "is_delivery"; // the default
                    replacewith = replacewith + "is_delivery";
                    if (!document.getElementById('deliverycb').checked) {
                        alert("At least Delivery or Pickup must be checked (or both). We are checking Delivery as the default, but you may adjust as you see fit");
                        document.getElementById('deliverycb').checked = "true";
                    }
                }
            }
            document.getElementById('delivery_type').value = deliverytype;
            createCookieValue('delivery_type', deliverytype);
            replacewith = replacewith + deliverytype;
            deliverytype = "delivery_type=" + deliverytype;

            $('.restaurant-url').each(function () {
                text = $(this).attr('href');
                text = text.replace(replacewith, deliverytype);
                $(this).attr('href', text);
            });
        }

        function keypress(event) {
            if (event.keyCode == 13) {
                submitform(event, 0, "keypress");
                return false;
            }
        }

        function onloadpage() {
            if (getCookie('cname')) {
                $('#search-form #name').val(getCookie('cname'));
            }

            if (getCookie('latitude')) {
                $('#latitude').val(getCookie('latitude'));
            }
            if (getCookie('longitude')) {
                $('#longitude').val(getCookie('longitude'));
            }
            if (getCookie('city')) {
                $('#city').val(getCookie('city'));
            }
            if (getCookie('country')) {
                $('#country').val(getCookie('country'));
            }
            if (getCookie('province')) {
                $('#province').val(getCookie('province'));
            }
            if (getCookie('postal_code')) {
                $('#postal_code').val(getCookie('postal_code'));
            }

            if (getCookie('delivery_type')) {
                $("#search-form input[name=delivery_type][value=" + getCookie('delivery_type') + "]").prop('checked', true);
            }
            if (getCookie('minimum')) {
                $('#search-form #minimum').val(getCookie('minimum'));
            }
            if (getCookie('cuisine')) {
                $('#search-form #cuisine').val(getCookie('cuisine'));
            }
            if (getCookie('rating')) {
                $('#search-form #rating').val(getCookie('rating'));
            }
            if (getCookie('SortOrder')) {
                $('#search-form #SortOrder').val(getCookie('SortOrder'));
            }
            if (getCookie("is_menu")) {
                $('#search-form #is_menu').attr("checked", true);
            }

            if (getCookie('address')) {
                $('#formatted_address2').val(getCookie('address'));
                $("#header-search-button").show();
                $('#search-form-submit').trigger('click');
            }
        }

        $('body').on('click', '#clearSearch', function () {
            removeCookie('cname');
            removeCookie('radius');
            removeCookie('city');
            removeCookie('province');
            removeCookie('country');
            removeCookie('postal_code');
            removeCookie('latitude');
            removeCookie('longitude');
            removeCookie('minimum');
            removeCookie('is_menu');
            removeCookie('cuisine');
            removeCookie('rating');
            removeCookie('SortOrder');
            removeCookie('formatted_address2');
            removeCookie('formatted_address');
            removeCookie('address');
            $(elementname).val('');
            hideresults();
        });

        function hideresults() {
            $(".main-bg-image").css("padding", oldpadding);
            $('#restuarant_bar').html("");
            $('#results_show').hide();
            $('#start_up_message').show();
            $("#formatted_address2").val("");
            $("html, body").animate({scrollTop: 0}, "slow");
        }

        var lastdata = "";
        var oldpadding = "";

        function submitform(e, start, eventname) {
            if (IgnoreOne) {
                IgnoreOne = false;
                return false;
            }

            var formatted_address = $(elementname).val();
            var latitude = $('#latitude').val().trim();
            var longitude = $('#longitude').val().trim();
            var address_alias = $('#formatted_address2').val();

            var city = $('#city').val();
            var province = $('#province').val();
            var country = $('#country').val();
            var postal_code = $('#postal_code').val();
            var is_menu = $('#is_menu').is(":checked");

            <?php
              (!is_null(Session::get('earthRad')))? $earthRad=Session::get('earthRad') : $earthRad=6371;
              echo "var earthRad = ".$earthRad.";";
            ?>

            createCookieValue("formatted_address", formatted_address);
            createCookieValue('longitude', longitude);
            createCookieValue('latitude', latitude);
            createCookieValue('address', address_alias);
            createCookieValue('city', city);
            createCookieValue('province', province);
            createCookieValue('country', country);
            createCookieValue('postal_code', postal_code);
            createCookieValue('is_menu', is_menu);

            createCookieValue('userC', earthRad); // other delimited items can be added in stage 2

            var token = $('#search-form input[name=_token]').val();

            if ($(e.target).text() && $(e.target).hasClass("search-city")) {
                IgnoreOne = true;
                var element = $(e.target);
                address_alias = element.text();
                $("#formatted_address2").val(address_alias);
                createCookieValue('address', address_alias);
                var data = $('#search-form').serialize() + "&formatted_address=" + address_alias + "&city=" + element.attr("city") + "&province=" + element.attr("province") + "&country=" + element.attr("country");
            } else {
                if (!address_alias) {
                    return false;
                }
                var data = $('#search-form').serialize() + "&" + $('#addressbar').serialize(); // "&latitude=" + latitude + "&longitude=" + longitude + "&earthRad=" + earthRad + "&formatted_address=" + address_alias + "&city";
            }

            var tempdata = data + "&start=" + start;
            if (tempdata == lastdata) {
                return tempdata;
            }

            if (start == 0) {
                //   $('#search-form #clearSearch').show();
                oldpadding = $(".main-bg-image").css("padding");
                $(".main-bg-image").css("padding", ".5rem");

                $('#restuarant_bar').html('');
                $('#parentLoadingbar').show();
                $('#start_up_message').hide();
                // $('#icons_show').hide();
                $('#results_show').show();
                $.post("{{ url('/search/restaurants/ajax') }}", {
                    token: token,
                    data: data,
                    start: start
                }, function (result) {
                    $('#parentLoadingbar').hide();
                    $('#restuarant_bar').html(result);
                    loadall();
                });
            } else {
                $('.loadingbar').show();
                $('#loadingbutton').hide();
                $.post("{{ url('/search/restaurants/ajax') }}", {
                    start: start,
                    _token: token,
                    data: data
                }, function (result) {
                    $('#restuarant_bar').append(result);
                    $('#loadMoreBtnContainer').remove();
                    loadall();
                });
            }

            return tempdata;
        }

        $('body').on('click', '.loadMoreRestaurants', function (e) {
            var start = $(this).attr('data-id');
            lastdata = submitform(e, start, "body onclick");
        });
        
        var loading = false;
        var expandatend = false;
        function loadmenu(RestaurantID) {
            if (!$("#menu-rest-" + RestaurantID).length) {
                $("#card-header-" + RestaurantID).append('<DIV ID="loading-rest-' + RestaurantID + '">Loading...<i class="fa fa-spin fa-spinner"></DIV>');
                $.post("{{ url('ajax') }}", {
                    token: token,
                    type: "loadmenu",
                    RestaurantID: RestaurantID
                }, function (result) {
                    result = '<DIV ID="menu-rest-' + RestaurantID + '" class="menu-rest">' + result + '</DIV>';
                    $("#loading-rest-" + RestaurantID).remove();
                    $("#card-header-" + RestaurantID).append(result);
                    if(loading){
                        PullRest();
                    }
                });
            } else if($('#menu-rest-' + RestaurantID).hasClass("collapse")) {
                $('#menu-rest-' + RestaurantID).removeClass("collapse");
            } else {
                $('#menu-rest-' + RestaurantID).addClass("collapse");
            }
        }

        function loadall(){
            if(loading){return false;}
            $('.menu-rest').removeClass("collapse");
            restaurants = new Array();
            $(".card-rest").each(function(index) {
                var RestID = $(this).attr("data-id");
                if (!$("#menu-rest-" + RestID).length) {
                    restaurants.push(RestID);//must be queued or the server will error out
                }
            });
            PullRest();
        }

        var restaurants;
        function expandcollapseall(expand){
            if(expand){
                expandatend = true;
                loadall();
            } else {
                $(".collapse").removeClass("collapse").removeClass("in").addClass("collapsing collapsed");
                $('.menu-rest').addClass("collapse");
            }
        }

        function PullRest(){
            loading = restaurants.length > 0;
            if(loading){
                loadmenu(restaurants[0]);
                restaurants.splice(0, 1);
            } else if(expandatend) {
                $("div[aria-expanded=false]").trigger("click");
                $("div[data-toggle=collapse]:not([aria-expanded])").trigger("click");
                expandatend = false;
            }
        }
    </script>
@stop
