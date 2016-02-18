<?php
$first = false;
$type = "hidden";
?>
@extends('layouts.default')
@section('content')

    <div class="jumbotron jumbotron-fluid  bg-primary main-bg-image p-a-0 m-a-0" style="">
        <div class="container " style="margin-top: 0 !important;">
            <div class="row text-md-center p-t-3" style="  ">
                <div class="col-md-offset-3 p-a-0 text-xs-center col-md-6   m-b-1">
                    <h1 class="display-4 banner-text-shadow" style="">Order Food from Local Restaurants</h1>
                </div>

                <div class="col-md-12 ">
                    <div class="col-md-offset-3 p-a-0 text-md-center col-md-6  text-md-center">
                        @include('common.search_bar')
                    </div>
                </div>

                <div class="col-md-12 m-t-1 text-md-center">
                    <p class="lead text-xs-center   p-b-0 banner-text-shadow">Or show me <a href="#" class="search-city" style="color:white;text-decoration: underline;" onclick="submitform(event, 0);">Hamilton</a></p>
                </div>


            </div>
        </div>
    </div>

    @include("popups.rating")

    <div class="container" style="">

        <?php printfile("views/restaurants.blade.php"); ?>

        <div class="row">

            <div class="" id="results_show" style="display: none;">
                <div class="col-lg-8">
                    <?php popup(true, "message:nostores"); ?>

                    @include('ajax.search_restaurants')

                </div>
                <div class="col-lg-4">


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

                                <!--div class="form-group">
                                    <select name="cuisine" id="cuisine" class="form-control"
                                            onchange="createCookieValue('cuisine', this.value)">
                                        <option value="">Cuisine</option>
                                        @foreach($cuisine as $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div-->


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


                <div class="col-lg-12 p-b-1 text-md-center">
                    <h2>Why Order From Didu EAT?</h2>
                    <hr>
                </div>


                <!--div class="col-lg-12 text-md-center">

                <h2 class=" text-md-center">Why order from DIDU EAT?</h2>
                    </div-->
                <div class="col-lg-4 text-md-center">

                    <div class="img-circle bg-success center-block m-b-1" style="width:87px;height:87px;">

                        <br>

                        <h1><i class="fa fa-cutlery center-block"></i></h1>


                    </div>
                    <h4>Local</h4>

                    <p class="text-muted">All local menus at your fingertips</p>
                </div>
                <div class="col-lg-4 text-md-center">

                    <div class="img-circle bg-success center-block m-b-1" style="width:87px;height:87px;">

                        <br>

                        <h1><i class="fa fa-cutlery center-block"></i></h1>


                    </div>
                    <h4>Efficient</h4>

                    <p class="text-muted">The quickest way to order food</p>
                </div>

                <div class="col-lg-4 text-md-center">

                    <div class="img-circle bg-success center-block m-b-1" style="width:87px;height:87px;">

                        <br>

                        <h1><i class="fa fa-cutlery center-block"></i></h1>


                    </div>
                    <h4>Discounts</h4>

                    <p class="text-muted">There's a deal everyday</p>
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

        function hideresults(){
            $('#restuarant_bar').html("");
            $('#results_show').hide();
            $('#start_up_message').show();
            $('#icons_show').show();
            $("#formatted_address2").val("");
            $("html, body").animate({ scrollTop: 0 }, "slow");
        }

        /*
         $('body').on('keyup', elementname, function () {
         $('#radius_panel').hide();
         if ($(this).val()) {
         $('#radius_panel').show();
         }
         });
         */

        function submitform(e, start) {
            var formatted_address = $(elementname).val();
            var latitude = $('#latitude').val().trim();
            var longitude = $('#longitude').val().trim();
            var address_alias = $('#formatted_address2').val();
            if (!address_alias) {
                return false;
            }

            createCookieValue("formatted_address", formatted_address);
            createCookieValue('longitude', longitude);
            createCookieValue('latitude', latitude);
            createCookieValue('address', address_alias);

            var token = $('#search-form input[name=_token]').val();

            if($(e.target).html() && $(e.target).hasClass("search-city")){
               var data = "city=" + $(e.target).html();
            } else {
                var data = $('#search-form').serialize() + "&latitude=" + latitude + "&longitude=" + longitude + "&formatted_address=" + address_alias;
            }
            if (start == 0) {
                //   $('#search-form #clearSearch').show();
                $('#restuarant_bar').html('');
                $('.parentLoadingbar').show();
                $('#start_up_message').hide();
                $('#icons_show').hide();
                $('#results_show').show();
                $.post("{{ url('/search/restaurants/ajax') }}", {token: token, data}, function (result) {
                    $('.parentLoadingbar').hide();
                    $('#restuarant_bar').html(result);
                    $('#countRowsS').text('s');
                    if (result.trim() != "") {
                        var quantity = $('#countTotalResult').val();
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
                $.post("{{ url('/search/restaurants/ajax') }}", {start: start, _token: token, data}, function (result) {
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