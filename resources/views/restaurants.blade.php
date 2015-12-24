@extends('layouts.default')
@section('content')




    @if(false)

        <div class="content-page">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3 col-sm-4 col-xs-12 filterform">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="box-shadow filter_search">
                                    <div class="portlet-title">
                                        <h2>Filter Search</h2>
                                    </div>
                                    <div class="portlet-body">
                                        {!! Form::open(array('url' => '/search/restaurants/ajax', 'id'=>'search-form', 'class'=>'search-form','method'=>'post','role'=>'form')) !!}
                                        <div class="sort search-form clearfix">
                                            <div class="form-group">
                                                <input type="text" name="name" id="name" value="" class="form-control"
                                                       placeholder="Restaurant Name"
                                                       onkeyup="createCookieValue('cname', this.value)"/>
                                            </div>
                                            <div id="radius_panel" style="display: none;">
                                                <label>Radius</label>
                                                <select name="radius" id="radius" class="form-control"
                                                        onchange="createCookieValue('radius', this.value)">
                                                    <option value="">---</option>
                                                    <?php
                                                    foreach (array(1, 2, 3, 4, 5, 10, 20) as $km) {
                                                        echo '<option value="' . $km . '">' . $km . ' km</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label><input type="radio" name="delivery_type" id="delivery_type"
                                                              value="is_delivery" checked
                                                              onclick="createCookieValue('delivery_type', this.value)"/>
                                                    Delivery</label>
                                                <label><input type="radio" name="delivery_type" id="delivery_type"
                                                              value="is_pickup"
                                                              onclick="createCookieValue('delivery_type', this.value)"/>
                                                    Pickup</label>
                                            </div>
                                            <div class="form-group">
                                                <select name="minimum" id="minimum" class="form-control"
                                                        onchange="createCookieValue('minimum', this.value)">
                                                    <option value="">Delivery Minimum</option>
                                                    <?php
                                                    for ($i = 5; $i < 50; $i += 5) {
                                                        echo '<option value="' . $i . '">$' . $i . ' - $' . $i + 5 . '</option>';
                                                    }
                                                    echo '<option value="' . $i . '">$' . $i . '</option>';
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <select name="cuisine" id="cuisine" class="form-control"
                                                        onchange="createCookieValue('cuisine', this.value)">
                                                    <option value="">Cuisine Types</option>
                                                    @foreach($cuisine as $value)
                                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <select name="rating" id="rating" class="form-control"
                                                        onchange="createCookieValue('rating', this.value)">
                                                    <option value="">Restaurant Rating</option>
                                                    <option value="5">5 Stars</option>
                                                    <option value="4">4 Stars or Better</option>
                                                    <option value="3">3 Stars or Better</option>
                                                    <option value="2">2 Stars or Better</option>
                                                    <option value="1">1 Stars or Better</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <select name="tags" id="tags" class="form-control"
                                                        onchange="createCookieValue('tags', this.value)">
                                                    <option value="">Tags</option>
                                                    @foreach($tags as $value)
                                                        <option value="{{ $value->name }}">{{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <select name="SortOrder" id="SortOrder" class="form-control"
                                                        onchange="createCookieValue('SortOrder', this.value)">
                                                    <option value="">Sort By</option>
                                                    <option value="rating">Quality score</option>
                                                    <option value="delivery_fee">Delivery fee</option>
                                                    <option value="minimum">Minimum order</option>
                                                    <option value="id">Newest first</option>
                                                    <option value="name">Restaurant name</option>
                                                </select>
                                            </div>
                                            <input type="hidden" name="latitude" id="latitude" value=""/>
                                            <input type="hidden" name="longitude" id="longitude" value=""/>
                                        </div>
                                        <br/>

                                        <div class="form-group">
                                            <input type="submit" name="search" class="btn custom-default-btn"
                                                   value="Refine Search"/>
                                            <input type="button" name="clearSearch" id="clearSearch"
                                                   class="btn custom-default-btn" value="Clear Search"/>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9 col-sm-8 col-xs-12">
                        <div class="container-fluid">
                            <div class="msgtop dropshadow"><span id="countRows" style="font: inherit;">No</span>
                                Restaurant(s) Found
                            </div>
                            <p id="start_up_message">Please enter address above to find restaurants near your area.</p>
                            @include('ajax.search_restaurants')
                        </div>
                    </div>
                </div>
            </div>
        </div>



    @endif











    <div class="row ">
        <div class="col-lg-4">
            <div class="card">

                <div class="card-header">
                    Filter Search
                </div>
                <div class="card-block">

                    <?php printfile("views/restaurants.blade.php"); ?>

                    {!! Form::open(array('url' => '/search/restaurants/ajax', 'id'=>'search-form', 'class'=>'search-form','method'=>'post','role'=>'form')) !!}
                    <div class="sort search-form clearfix">
                        <div class="form-group">
                            <input type="text" name="name" id="name" value="" class="form-control"
                                   placeholder="Restaurant Name" onkeyup="createCookieValue('cname', this.value)"/>
                        </div>
                        <div id="radius_panel" class="form-group" style="display: none;">
                            <select name="radius" id="radius" class="form-control"
                                    onchange="createCookieValue('radius', this.value)">
                                <option value="">Distance</option>
                                <?php
                                foreach (array(1, 2, 3, 4, 5, 10, 20) as $km) {
                                    echo '<option value="' . $km . '">' . $km . ' km radius</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><input type="radio" name="delivery_type" id="delivery_type" value="is_delivery"
                                          checked onclick="createCookieValue('delivery_type', this.value)"/>
                                Delivery</label>
                            <label><input type="radio" name="delivery_type" id="delivery_type" value="is_pickup"
                                          onclick="createCookieValue('delivery_type', this.value)"/> Pickup</label>
                        </div>
                        <div class="form-group">
                            <select name="minimum" id="minimum" class="form-control"
                                    onchange="createCookieValue('minimum', this.value)">
                                <option value="">Delivery Minimum</option>
                                <?php
                                for ($i = 5; $i < 50; $i += 5) {
                                    echo '<option value="' . $i . '">$' . $i . ' - $' . $i + 5 . '</option>';
                                }
                                echo '<option value="' . $i . '">$' . $i . '</option>';
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="cuisine" id="cuisine" class="form-control"
                                    onchange="createCookieValue('cuisine', this.value)">
                                <option value="">Cuisine Types</option>
                                @foreach($cuisine as $value)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <select name="rating" id="rating" class="form-control"
                                    onchange="createCookieValue('rating', this.value)">
                                <option value="">Restaurant Rating</option>
                                <option value="5">5 Stars</option>
                                <option value="4">4 Stars or Better</option>
                                <option value="3">3 Stars or Better</option>
                                <option value="2">2 Stars or Better</option>
                                <option value="1">1 Stars or Better</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="tags" id="tags" class="form-control"
                                    onchange="createCookieValue('tags', this.value)">
                                <option value="">Tags</option>
                                @foreach($tags as $value)
                                    <option value="{{ $value->name }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="SortOrder" id="SortOrder" class="form-control"
                                    onchange="createCookieValue('SortOrder', this.value)">
                                <option value="">Sort By</option>
                                <option value="rating">Quality score</option>
                                <option value="delivery_fee">Delivery fee</option>
                                <option value="minimum">Minimum order</option>
                                <option value="id">Newest first</option>
                                <option value="name">Restaurant name</option>
                            </select>
                        </div>
                        <input type="hidden" name="latitude" id="latitude" value=""/>
                        <input type="hidden" name="longitude" id="longitude" value=""/>
                    </div>


                </div>

                <div class="card-footer  text-xs-right">
                    <input type="button" name="clearSearch" id="clearSearch" class="btn btn-link"
                           value="Clear Search"/>
                    <input type="submit" name="search" class="btn btn-primary" value="Refine Search"/>


                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        <div class="col-lg-8 ">


            <div class="alert alert-danger alert-dismissible fade in" role="alert" id="start_up_message">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <p>Please enter address above to find restaurants near your area.</p>
            </div>

            <div class="alert alert-success alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <span id="countRows" style="font: inherit;">No</span> Restaurant(s) Found

            </div>


            @include('ajax.search_restaurants')


        </div>
    </div>











    <script type="text/javascript">
        onloadpage();
        function onloadpage() {
            if (getCookie('cname')) {
                $('#search-form #name').val(getCookie('cname'));
            }
            if (getCookie('latitude')) {
                $('#search-form #latitude').val(getCookie('latitude'));
            }
            if (getCookie('longitude')) {
                $('#search-form #longitude').val(getCookie('longitude'));
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
            if (getCookie('cname') || getCookie('latitude') || getCookie('longitude') || getCookie('minimum') || getCookie('cuisine') || getCookie('rating') || getCookie('SortOrder')) {
                $('#search-form #clearSearch').show();
            } else {
                $('#search-form #clearSearch').hide();
            }
            if (getCookie('radius').trim() != "") {
                $('#search-form #radius_panel').show();
                $('#search-form #radius').val(getCookie('radius'));
            } else {
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
            removeCookie('latitude');
            removeCookie('longitude');
            removeCookie('minimum');
            removeCookie('cuisine');
            removeCookie('rating');
            removeCookie('SortOrder');
            $('#formatted_address').val('');
            $('#search-form #clearSearch').hide();
        });

        $('body').on('keyup', '#formatted_address', function () {
            $('#radius_panel').hide();
            if ($(this).val()) {
                $('#radius_panel').show();
            }
        });

        $('body').on('submit', '#search-form', function (e) {
            var formatted_address = $('#formatted_address').val();
            var latitude = $('#latitude').val();
            var longitude = $('#longitude').val();
            if (latitude.trim() == "" || longitude.trim() == "") {
                alert('Please enter address to proceed. thanks');
                e.preventDefault();
                return false;
            }
            var token = $('#search-form input[name=_token]').val();
            var data = $(this).serialize();

            $('#search-form #clearSearch').show();
            $('#restuarant_bar').html('');
            $('.parentLoadingbar').show();
            $('#start_up_message').remove();
            $.post("{{ url('/search/restaurants/ajax') }}", {_token: token, data}, function (result) {
                $('.parentLoadingbar').hide();
                $('#restuarant_bar').html(result);
                if (result.trim() != "") {
                    $('#countRows').text($('#countTotalResult').val());
                } else {
                    $('#countRows').text(0);
                }
            });
            e.preventDefault();
        });

        $('body').on('click', '.loadMoreRestaurants', function () {
            var start = $(this).attr('data-id');
            var token = $('#search-form input[name=_token]').val();
            var data = $('#search-form').serialize();
            $('.loadingbar').show();
            $('#loadingbutton').hide();
            $.post("{{ url('/search/restaurants/ajax') }}", {start: start, _token: token, data}, function (result) {
                $('#restuarant_bar').append(result);
                $('#loadMoreBtnContainer').remove();
            });
        });

        //Google Api Codes.
        var placeSearch, formatted_address;
        function initAutocomplete() {
            formatted_address = new google.maps.places.Autocomplete(
                    (document.getElementById('formatted_address')),
                    {types: ['geocode']});
            formatted_address.addListener('place_changed', fillInAddress);
        }

        function fillInAddress() {
            var place = formatted_address.getPlace();
            var lat = place.geometry.location.lat();
            var lng = place.geometry.location.lng();
            $('#latitude').val(lat);
            $('#longitude').val(lng);

            createCookieValue('latitude', lat);
            createCookieValue('longitude', lng);
        }

        function geolocate() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    var geolocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    var circle = new google.maps.Circle({
                        center: geolocation,
                        radius: position.coords.accuracy
                    });
                    formatted_address.setBounds(circle.getBounds());
                });
            }
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?signed_in=true&libraries=places&callback=initAutocomplete"
            async defer></script>
@stop