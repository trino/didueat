<?php
    $first = false;
    $type = "hidden";
    //$localIPTst = $_SERVER['REMOTE_ADDR'];
    //$localIPTst = "24.36.50.14"; // needed for wamp -- remove from remote server
    $latlngStr = "";
    $locationStr = "";
    $useCookie = false;
    $useHamilton = true;

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

    if($useHamilton){
        $City = "Hamilton";
        $Province = "Ontario";
        $Country = "Canada";
        $latHam="43.2566983";
        $lonHam="-79.8690719";
        $loc="43.2566983,-79.8690719";
    } else if(is_object($details)) {
        $loc=$details->loc;
    }

?>


@extends('layouts.default')
@section('content')

    <div class="jumbotron jumbotron-fluid  bg-warning  main-bg-image">
        <div class="container " style="margin-top: 0 !important;">
            <div class="row text-md-center" style="padding:1.25rem !important;">

                <div class="col-md-offset-2 text-xs-center col-md-8 ">
                    <h1 class="banner-text-shadow display-4">Pickup & Delivery From Hamilton Restaurants</h1>

                    <div class="clearfix"></div>




                </div>

                <div class="col-md-offset-3  col-md-6 text-md-center">
                    @include('common.search_bar')
                </div>
                <div class="clearfix"></div>



                <div class="col-md-offset-3 text-xs-center col-md-6 ">
                    <div class="text-xs-center" onclick="submitform(event, 0);" >

                        <!--h5 class="m-t-1 display-5 banner-text-shadow" loc="{{ $loc }}"-->
                        <h5 class="m-t-1 display-5 banner-text-shadow">
                            or show me <a style="cursor:pointer;text-decoration: underline; color:white" class="search-city" onclick="submitform(event, 0);return false;" city="{{ $City }}" province="{{ $Province }}" country="{{ $Country }}">{{ $City . ", " . $Province }}</a>
                        </h5>
                        <div class="clearfix"></div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    @include("popups.rating")

    <div class="container" style="">

        <?php printfile("views/restaurants.blade.php"); ?>

        <div class="row">

            <div class="" id="results_show" style="display: none;">
                <div class="col-lg-8 m-b-2">
                    <?php popup(true, "message:nostores"); ?>

                    @include('ajax.search_restaurants')

                </div>
                <div class="col-lg-4" ID="filter-results">


                    <div class="card ">
                        <div class="card-header">
                            <h4 class="card-title">Filter Search</h4>
                        </div>

                        <div class="card-block">

                            {!! Form::open(array('url' => '/search/restaurants/ajax', 'id'=>'search-form', 'class'=>'search-form m-b-0','method'=>'post','role'=>'form', 'onkeypress' => 'return keypress(event);')) !!}
                            <div class="sort search-form clearfix">

                                <div class="p-l-0 p-r-1 pull-left">
                                    <div class="form-group">

                                        <label class="c-input c-radio ">
                                            <input type="radio" name="delivery_type" id="delivery_type"
                                                   value="is_delivery"
                                                   checked
                                                   onclick="createCookieValue('delivery_type', this.value)"/>
                                            <span class="c-indicator"></span>
                                            Delivery
                                        </label></div>
                                </div>
                                <div class="p-l-0 pull-left">

                                    <div class="form-group">

                                        <label class="c-input c-radio ">
                                            <input type="radio" name="delivery_type" id="delivery_type"
                                                   value="is_pickup"
                                                   onclick="createCookieValue('delivery_type', this.value)"/>
                                            <span class="c-indicator"></span>
                                            Pickup
                                        </label></div>
                                </div>
                                <!--label class="c-input c-checkbox">
                                    <input type="checkbox" name="is_complete" id="is_complete" value="true" checked
                                           onclick="createCookieValue('is_complete', this.value)"/>
                                    <span class="c-indicator"></span>
                                    Order Online
                                </label-->


                                <div class="form-group">
                                    <input type="text" name="name" id="name" value="" class="form-control"
                                           placeholder="Restaurant Name"
                                           onkeyup="createCookieValue('cname', this.value)"/>
                                </div>

                                <div class="form-group">
                                    <select name="cuisine" id="cuisine" class="form-control"
                                            onchange="createCookieValue('cuisine', this.value)">
                                        <option value="">Cuisine Type</option>
                                        @foreach($cuisine as $value)
                                            <option>{{ $value->name }}</option>
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
                            <input type="button" name="clearSearch" id="clearSearch" class="btn btn-secondary"
                                   value="Clear"/>
                            <input type="button" name="search" class="btn btn-primary" value="Filter"
                                   id="search-form-submit"
                                   onclick="submitform(event, 0);"/>
                        </div>
                        {!! Form::close() !!}
                    </div>


                </div>
            </div>

            <div class=" " id="icons_show">


                <div class="col-lg-12 p-b-1 text-xs-center">
                    <h2>Why Order From Didu Eat?</h2>
                    <hr>
                </div>


                <div class="col-lg-4 text-xs-center">
                    <div class="card card-block text-xs-center m-b-0">
                        <blockquote class="card-blockquote">

                            <div class="img-circle center-block m-b-1">
                                <h1><i class="fa fa-map-marker bg-success img-circle "
                                       style="padding-top:25px;width:90px;height:90px;"></i></h1>
                            </div>
                            <h4>Local</h4>
                            <footer>
                                Steel Town's best restaurants
                            </footer>
                        </blockquote>
                    </div>
                </div>


                <div class="col-lg-4 text-xs-center">
                    <div class="card card-block text-xs-center m-b-0">
                        <blockquote class="card-blockquote">

                            <div class="img-circle center-block m-b-1">
                                <h1><i class="fa fa-cutlery bg-success img-circle "
                                       style="padding-top:25px;width:90px;height:90px;"></i></h1>
                            </div>
                            <h4>Efficient</h4>
                            <footer>
                                The fastest way to order food
                            </footer>
                        </blockquote>
                    </div>
                </div>


                <div class="col-lg-4 text-xs-center">
                    <div class="card card-block text-xs-center m-b-0">
                        <blockquote class="card-blockquote">

                            <div class="img-circle center-block m-b-1">
                                <h1><i class="fa fa-usd bg-success img-circle "
                                       style="padding-top:25px;width:90px;height:90px;"></i></h1>
                            </div>
                            <h4>Discounts</h4>
                            <footer>
                                There's a deal everyday
                            </footer>
                        </blockquote>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        var elementname = '#formatted_address2';
        onloadpage();
        function keypress(event) {
            if (event.keyCode == 13) {
                submitform(event, 0);
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
        }

        $('body').on('click', '#clearSearch', function () {
            removeCookie('cname');
            removeCookie('radius');
            removeCookie('latitude');
            removeCookie('longitude');
            removeCookie('minimum');
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
            $('#icons_show').show();
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

        var IgnoreOne=false;
        function submitform(e, start) {
            if(IgnoreOne){IgnoreOne= false; return false;}
            var formatted_address = $(elementname).val();
            var latitude = $('#latitude').val().trim();
            var longitude = $('#longitude').val().trim();
            var address_alias = $('#formatted_address2').val();

            <?php
              (!is_null(Session::get('earthRad')))? $earthRad=Session::get('earthRad') : $earthRad=6371;
              echo "var earthRad = ".$earthRad.";";
            ?>

            createCookieValue("formatted_address", formatted_address);
            createCookieValue('longitude', longitude);
            createCookieValue('latitude', latitude);
            createCookieValue('address', address_alias);
            createCookieValue('userC', earthRad); // other delimited items can be added in stage 2

            var token = $('#search-form input[name=_token]').val();

            if ($(e.target).text() && $(e.target).hasClass("search-city")) {



                /*
                 <!--

                 // We will need to put this back when we expand beyond Canada
                 var dataStr = $(e.target).html();
                 var loc = $(e.target).attr("loc");
                 var dataStr2 = dataStr.split(", ");
                 var secondVar = "";

                 (dataStr2[1] != "US" && dataStr2[1] != "CA" && dataStr2[1] != "United States" && dataStr2[1] != "Canada") ? secondVar = "country" : secondVar = "province";

                 $("#formatted_address2").val(dataStr);
                 data = "city=" + dataStr2[0] + "&" + secondVar + "=" + dataStr2[1] + "&earthRad=" + earthRad;
                 -->
                 */



                IgnoreOne = true;
                $("#formatted_address2").val($(e.target).text());
                data = "delivery_type=is_delivery&name=&cuisine=&radius=5&latitude={{ (isset($latHam))? $latHam:"" }}&longitude={{ (isset($lonHam))? $lonHam : "" }}&earthRad=" + earthRad + "&formatted_address=67 Caroline St S, Hamilton, ON, Canada";
            } else {
                if (!address_alias) {
                    return false;
                }

                var data = $('#search-form').serialize() + "&latitude=" + latitude + "&longitude=" + longitude + "&earthRad=" + earthRad + "&formatted_address=" + address_alias;
            }

            if (start == 0) {
                //   $('#search-form #clearSearch').show();
                $('#restuarant_bar').html('');
                $('#parentLoadingbar').show();
                $('#start_up_message').hide();
                $('#icons_show').hide();
                $('#results_show').show();
                $.post("{{ url('/search/restaurants/ajax') }}", {token: token, data: data}, function (result) {
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
        }

        $('body').on('click', '.loadMoreRestaurants', function (e) {
            var start = $(this).attr('data-id');
            submitform(e, start);
        });

        var p = document.getElementById("radius");
        p.addEventListener("input", function () {
            $("#radius").trigger("change");
        }, false);
    </script>
@stop