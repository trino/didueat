<?php
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

    /*
    if ((!isset($_COOKIE['userC']) && !read('is_logged_in')) || !$useCookie) {
        $Province = "";
        if (function_exists('geoip_record_by_name')) {
            $info = geoip_record_by_name($localIPTst);
            $City = $info['city'];
            $Country = $info['country_name'];
            if ($info['country_name'] == "United States" || $info['country_name'] == "Canada") {
                $Province = $info['region'];
            }
        } else {
            $ip = $localIPTst;
            $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}"));
            $City = $details->city;
            if ($details->country == "US"){$Country = "United States";}
            if ($details->country == "CA"){$Country = "Canada";}
            if(isset($Country)){
                $Province = $details->region;
            } else {
                $Country = $details->country;
            }
            $latlng = explode(",", $details->loc);
            $latlngStr = "&latitude=" . $latlng[0] . "&longitude=" . $latlng[1];
        }
    } else {
        // get city [, province/state], and country from cookie or session, once implemented
    }
    */

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


@extends('layouts.default')
@section('content')

    <div class=" bg-success main-bg-image">
        <div class="container" style="margin-top: 0 !important;">
            <div class="row text-md-center " style="padding:0 1rem !important;">
                <div class="col-md-offset-2 text-xs-center col-md-8 m-b-1" style="">
                    <h1 class="banner-text-shadow"><span style="font-size: 127%">Meals Delivered From </span><span
                                style="font-size: 126%"> Hamilton Restaurants</span></h1>
                    <div class="clearfix"></div>
                </div>

                <div class="col-md-offset-3 col-md-6 text-md-center">
                    @include('common.search_bar')
                </div>
                <div class="clearfix"></div>

                        <!--h5 class="m-t-1 display-5 banner-text-shadow" loc="{{ $loc }}"-->
                        <!--h5 class="m-t-1 display-5 banner-text-shadow">
                            or show me <a style="cursor:pointer;text-decoration: underline; color:white"
                                          class="search-city" onclick="submitform(event, 0);return false;"
                                          city="{{ $City }}" province="{{ $Province }}" title="{{ $alts["city"] }}"
                                          country="{{ $Country }}">{{ $City . ", " . $Province }}</a>
                        </h5-->

                        <div class="clearfix"></div>
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
    <div class="container" style="margin-top: 0 !important;">

        <?php printfile("views/restaurants.blade.php"); ?>

        <div class="row">

            <div class="" id="results_show" style="display: none;">
                <div class="col-lg-8 m-b-2">
                    <?php popup(true, "message:nostores", false, false, ''); ?>
                    @include('ajax.search_restaurants')
                </div>
                <div class="col-lg-4" ID="filter-results">
                    <div class="card ">
                        <div class="card-header">
                            <h4 class="card-title">Search Restaurant</h4>
                        </div>

                        <div class="card-block">

                            {!! Form::open(array('url' => '/search/restaurants/ajax', 'id'=>'search-form', 'class'=>'search-form m-b-0','method'=>'post','role'=>'form', 'onkeypress' => 'return keypress(event);')) !!}
                            <div class="sort search-form clearfix">

                                <!--div class="p-l-0 p-r-1 pull-left">
                                    <div class="form-group">
                                        <input name="delivery_type" type="hidden" id="delivery_type"/>
                                        <label class="c-input c-checkbox ">
                                            <input type="checkbox" name="deliverycb" id="deliverycb"
                                                   value="is_delivery"
                                                   {{ $is_delivery_checked }}
                                                   onclick="setdeliverytype();"/>
                                            <span class="c-indicator"></span>
                                            Delivery
                                        </label>
                                    </div>
                                </div>

                                <div class="p-l-0 pull-left">
                                    <div class="form-group">
                                        <label class="c-input c-checkbox ">
                                            <input type="checkbox" name="pickupcb" id="pickupcb"
                                                   value="is_pickup"
                                                   {{ $is_pickup_checked }}
                                                   onclick="setdeliverytype();"/>
                                            <span class="c-indicator"></span>
                                            Pickup
                                        </label>
                                    </div>
                                </div-->

                                <div class="form-group">
                                    <input type="text" name="name" id="name" value="" class="form-control"
                                           placeholder="Restaurant Name"
                                           onkeyup="createCookieValue('cname', this.value)"/>
                                </div>

                                <div class="form-group" style="margin-bottom:0 !important;">
                                    <select name="cuisine" id="cuisine" class="form-control"
                                            onchange="createCookieValue('cuisine', this.value)">
                                        <option value="">All Cuisine</option>
                                        @foreach($cuisine as $value)
                                            <option>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div id="radius_panel" class="form-group row" style="display:none;">
                                    <div class=" col-md-6">
                                        <label id="radius_panel_label">Distance (<?= MAX_DELIVERY_DISTANCE; ?>
                                            km)</label>
                                    </div>
                                    <div class=" col-md-6">
                                        <input type="range" name="radius" id="radius" min="1"
                                               max="<?= MAX_DELIVERY_DISTANCE; ?>" value="5"
                                               class="form-control"
                                               onchange="$('#radius_panel_label').html('Distance (' + $(this).val() + ' km)');">

                                        <!--input type="range" name="radius" id="radius" min="1"
                                       max="<?= MAX_DELIVERY_DISTANCE; ?>" value="<?= MAX_DELIVERY_DISTANCE; ?>"
                                       class="form-control"
                                       onchange="$('#radius_panel_label').html('Distance (' + $(this).val() + ' km)');"-->

                                    </div>
                                    <div class="clearfix"></div>
                                </div>


                            </div>
                        </div>
                        <div class="card-footer text-xs-right">
                            <div class="">     <input type="button" name="clearSearch" id="clearSearch" class="btn btn-secondary-outline"
                                   value="Reset"/>
                            <input type="button" name="search" class="btn btn-primary" value="Search"
                                   id="search-form-submit"
                                   onclick="submitform(event, 0, 'search onclick');"/>

                                </div>
                        </div>
                        {!! Form::close() !!}
                    </div>


                    <div class="col-lg-4 hidden-md-down">
                        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                    </div>

                </div>
            </div>

            <!--div id="icons_show">
                <div class="col-lg-12 p-b-1 text-xs-center" style="padding-top:1rem !important;">
                    <h2 class="text-muted ">WHY ORDER FROM {{ strtoupper(DIDUEAT)  }}?</h2>
                    <hr>
                </div>
                <div class="col-lg-4 text-xs-center">
                    <div class="card card-block text-xs-center m-b-0">
                        <div class="exp_cir bg-success"><i class="fa fa-map-marker fa-2x "
                                                           style="line-height: inherit;"></i></div>
                        <br><br>
                        <h4>Local</h4>
                        <footer>
                            Steel Town's best restaurants
                        </footer>
                    </div>
                </div>
                <div class="col-lg-4 text-xs-center">
                    <div class="card card-block text-xs-center m-b-0">
                        <div class="exp_cir bg-warning"><i class="fa fa-cutlery fa-2x "
                                                           style="line-height: inherit;"></i></div>
                        <br><br>
                        <h4>Efficient</h4>
                        <footer>
                            The fastest way to order food
                        </footer>
                    </div>
                </div>
                <div class="col-lg-4 text-xs-center">
                    <div class="card card-block text-xs-center m-b-0">
                        <div class="exp_cir bg-info"><i class="fa fa-usd fa-2x " style="line-height: inherit;"></i>
                        </div>
                        <br><br>
                        <h4>Discounts</h4>
                        <footer>
                            There's a deal everyday
                        </footer>
                    </div>
                </div>
                <div class="clearfix"></div>

            </div-->

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
        @if(isset($_GET["start"]))
            //startingat = "{{ $_GET["start"] }}";
        @endif
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

            /*
             if (getCookie('cname') || getCookie('latitude2') || getCookie('longitude2') || getCookie('minimum') || getCookie('cuisine') || getCookie('rating') || getCookie('SortOrder')) {
             $('#search-form #clearSearch').show();
             } else {
             $('#search-form #clearSearch').hide();
             }

             if (getCookie('radius').trim() != "") {
             $('#search-form #radius_panel').show();
             $('#search-form #radius').val(getCookie('radius'));
             }
             */

            if (getCookie('address')) {
                $('#formatted_address2').val(getCookie('address'));
                $("#header-search-button").show();
                $('#search-form-submit').trigger('click');
            }

            @if(isset($_GET["start"]))
                //submitform($(".footer"), 0);
            @endif
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
            $('#restuarant_bar').html("");
            $('#results_show').hide();
            $('#start_up_message').show();
            //  $('#icons_show').show();
            $("#formatted_address2").val("");
            $("html, body").animate({scrollTop: 0}, "slow");
        }

        /*
         $('body').on('keyup', elementname, function () {
         $('#radius_panel').hide();
         if ($(this).val()) {
         $('#radius_panel').show();
         }
         });
         */

        var lastdata = "";

        function submitform(e, start, eventname) {
            if (IgnoreOne) {
                IgnoreOne = false;
                return false;
            }

            /*if(startingat){
                ChangeUrl("Search", "{{ url("?start=") }}" + startingat);
            } else {
                ChangeUrl("Search", "{{ url("?start=") }}" + start);
            }*/
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
            if(tempdata == lastdata){
                return tempdata;
            }

            if (start == 0) {
                //   $('#search-form #clearSearch').show();
                $('#restuarant_bar').html('');
                $('#parentLoadingbar').show();
                $('#start_up_message').hide();
               // $('#icons_show').hide();
                $('#results_show').show();
                $.post("{{ url('/search/restaurants/ajax') }}", {token: token, data: data, start: start}, function (result) {
                    var quantity = 0;
                    $('#parentLoadingbar').hide();
                    $('#restuarant_bar').html(result);
                    $('#countRowsS').text('s');
                    if (result.trim() != "") {
                        quantity = $('#countTotalResult').val();
                        $('#countRows').text(quantity);
                        if (quantity == "1" || quantity == 1) {
                            $('#countRowsS').text('');
                        }
                    } else {
                        $('#countRows').text(0);
                    }
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
                });
            }

            return tempdata;
        }
        
        
        
        
        ////////////////////////////////////////////////////////////////
       $(document).ready(function () {
    $(window).on('beforeunload', function () {
        document.cookie = "keepscroll=" + $(window).scrollTop();
    });
    var cs = document.cookie ? document.cookie.split(';') : [];
    var i = 0, cslen = cs.length;
    for (; i < cs.length; i++) {
        var c = cs[i].split('=');
        if (c[0].trim() == "keepscroll") {
            setTimeout(function(){
                if($(document).height()<c[1])
                {
                   $('.loadMoreRestaurants').click()
                     setTimeout(function(){$(window).scrollTop(parseInt(c[1]));},800);
                    
                    
                  
                  // alert($(document).height());
                  
                }
            },800);
            
            
            break;
        }
    }
});
        
        
        $(document).ready(function() {
        	var win = $(window);
        
        	// Each time the user scrolls
        	win.scroll(function() {
        	   //if($(document).height()>4000)
        	  //alert($(window).scrollTop());
        	   //alert($("div#element").scrollTop());
        		// End of the document reached?
        		if ($(document).height() - win.height() == win.scrollTop()) {
        			$('.loadMoreRestaurants').click();
        		}
        	});
        });
        /////////////////////////////////////////////////////////

        $('body').on('click', '.loadMoreRestaurants', function (e) {
            var start = $(this).attr('data-id');
            lastdata = submitform(e, start, "body onclick");
        });

        var p = document.getElementById("radius");
        p.addEventListener("input", function () {
            $("#radius").trigger("change");
        }, false);
    </script>
@stop
