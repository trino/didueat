<?php
$first = false;
$type = "hidden";
?>
@extends('layouts.default')

@section('content')

    <div class="jumbotron jumbotron-fluid  bg-danger" style=" background-image: url( '{{ asset('assets/images/restro-background.jpg') }}' )  !important;
            background-size: cover;
            background-repeat: no-repeat;
            background-position:center center;

            ">
        <div class="container" style="padding-top: 0px !important;">
            <h1 class="display-4">Order Delivery & Take-Out Online</h1>
            <p class="lead">Enter your location to find restaurants near you.</p>



            <div class="m-b-1">
                @include('common.search_bar')
            </div>


        </div>
    </div>


    <div class="container-fluid">


    <div class="container" style="padding-top: 0px !important;">

        <?php printfile("views/restaurants.blade.php"); ?>

        <div class="row ">


            <div class="col-lg-8 ">



                <div class="alert alert-success alert-dismissible fade in" role="alert" id="results_show"
                     style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <span id="countRows" style="">No</span> restaurant<span id="countRowsS" style="">s</span>
                    found in your area
                </div>
                @include('ajax.search_restaurants')
            </div>


            <div class="col-lg-4 ">
                <div class="card ">
                    <div class="card-header">
                        <p class="card-title m-b-0">Filter Search</p>
                    </div>

                    <div class="card-block">

                        {!! Form::open(array('url' => '/search/restaurants/ajax', 'id'=>'search-form', 'class'=>'search-form m-b-0','method'=>'post','role'=>'form', 'onkeypress' => 'return keypress(event);')) !!}
                        <div class="sort search-form clearfix">

                            <div class="form-group">

                                <label class="c-input c-radio">
                                    <input type="radio" name="delivery_type" id="delivery_type" value="is_delivery"
                                           checked
                                           onclick="createCookieValue('delivery_type', this.value)"/>
                                    <span class="c-indicator"></span>
                                    Delivery
                                </label>

                                <label class="c-input c-radio">
                                    <input type="radio" name="delivery_type" id="delivery_type" value="is_pickup"
                                           onclick="createCookieValue('delivery_type', this.value)"/>
                                    <span class="c-indicator"></span>
                                    Pickup
                                </label>

                                <!--label class="c-input c-checkbox">
                                    <input type="checkbox" name="is_complete" id="is_complete" value="true" checked
                                           onclick="createCookieValue('is_complete', this.value)"/>
                                    <span class="c-indicator"></span>
                                    Order Online
                                </label-->

                            </div>

                            <div class="form-group">
                                <input type="text" name="name" id="name" value="" class="form-control"
                                       placeholder="Restaurant Name" onkeyup="createCookieValue('cname', this.value)"/>
                            </div>

                            <div class="form-group">
                                <select name="cuisine" id="cuisine" class="form-control"
                                        onchange="createCookieValue('cuisine', this.value)">
                                    <option value="">Cuisine</option>
                                    @foreach($cuisine as $value)
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div id="radius_panel" class="form-group row" style="display:none;">
                                <div class=" col-md-6">
                                    <label id="radius_panel_label">Distance (<?= MAX_DELIVERY_DISTANCE; ?> km)</label>
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
            if (getCookie('address')) {
                $('#formatted_address2').val(getCookie('address'));
                $("#header-search-button").show();
            }
            if (getCookie('latitude2')) {
                $('#latitude2').val(getCookie('latitude2'));
            }
            if (getCookie('longitude2')) {
                $('#longitude2').val(getCookie('longitude2'));
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
             */
            if (getCookie('radius').trim() != "") {
                $('#search-form #radius_panel').show();
                $('#search-form #radius').val(getCookie('radius'));
            }
        }

        function setCookie(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            var expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + "; " + expires;
        }

        function getCookie(cname) {
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') c = c.substring(1);
                if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
            }
            return "";
        }

        function removeCookie(cname) {
            $.removeCookie(cname);
            $('#search-form #name').val('');
            $('#search-form #' + cname).val('');
            //createCookie(cname, "", -1);
        }

        function createCookieValue(cname, cvalue) {
            setCookie(cname, cvalue, 1);
        }

        $('body').on('click', '#clearSearch', function () {
            removeCookie('cname');
            removeCookie('radius');
            removeCookie('latitude2');
            removeCookie('longitude2');
            removeCookie('minimum');
            removeCookie('cuisine');
            removeCookie('rating');
            removeCookie('SortOrder');
            $(elementname).val('');
            //  $('#search-form #clearSearch').hide();
        });

        $('body').on('keyup', elementname, function () {
            $('#radius_panel').hide();
            if ($(this).val()) {
                $('#radius_panel').show();
            }
        });

        function submitform(e, start) {
            var formatted_address = $(elementname).val();
            var latitude2 = $('#latitude2').val().trim();
            var longitude2 = $('#longitude2').val().trim();
            var address_alias = $('#formatted_address2').val();
            createCookieValue('longitude2', longitude2);
            createCookieValue('latitude2', latitude2);
            createCookieValue('address', address_alias);
            var token = $('#search-form input[name=_token]').val();
            var data = $('#search-form').serialize() + "&latitude=" + latitude2 + "&longitude=" + longitude2 + "&formatted_address=" + address_alias;

            if (start == 0) {
                //   $('#search-form #clearSearch').show();
                $('#restuarant_bar').html('');
                $('.parentLoadingbar').show();
                $('#start_up_message').remove();
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