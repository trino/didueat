<?php
$first = false; $type = "hidden";
?>
@extends('layouts.default')




<div class="bg-danger p-t-3 p-b-3 m-t-3 secondary_red">
    <div class="container">
        <div class="row ">
            <div class="col-lg-8">
                <h1 class="display-3">diduEAT</h1>
                <p class="lead">
                    The easiest way to order food from local restaurants.
                    <br>
                    Meal of the Day Business Model.
                </p>
            </div>
            <div class="col-lg-4">
                <div class="primary_red  p-a-2 ">
                    <p class="lead">Where are you located?</p>
                    <input class="form-control" type="text" id="formatted_address4" placeholder="Address, City or Postal Code">
                    <body onload="formatted_address4 = initAutocompleteWithID('formatted_address4');">
                </div>
            </div>
        </div>
    </div>
</div>




@section('content')

<?php printfile("views/restaurants.blade.php"); ?>



    <div class="row ">




        <div class="col-lg-4">
            <div class="card">

                <div class="card-header">
                    Filter Search
                </div>
                <div class="card-block">

                    <?php printfile("views/restaurants.blade.php"); ?>

                    {!! Form::open(array('url' => '/search/restaurants/ajax', 'id'=>'search-form', 'class'=>'search-form','method'=>'post','role'=>'form', 'onkeypress' => 'return keypress(event);')) !!}
                    <div class="sort search-form clearfix">
                        <div class="form-group">
                            <input type="text" name="name" id="name" value="" class="form-control" placeholder="Restaurant Name" onkeyup="createCookieValue('cname', this.value)"/>
                        </div>
                        <div id="radius_panel" class="form-group row">

                            <div class=" col-md-6">
                            <LABEL id="radius_panel_label">Distance (20 km)</LABEL>
                            </div>
                            <div class=" col-md-6">

                            <input type="range" name="radius" id="radius" min="1" max="20" value="20" class="form-control" onchange="$('#radius_panel_label').html('Distance (' + $(this).val() + ' km)');">
</div>
                            <!--select name="radius" id="radius" class="form-control" onchange="createCookieValue('radius', this.value)">
                                <option value="">Distance</option>
                                <?php
                                    foreach (array(1, 2, 3, 4, 5, 10, 20) as $km) {
                                        echo '<option value="' . $km . '">' . $km . ' km radius</option>';
                                    }
                                ?>
                            </select-->
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                            <label><input type="radio" name="delivery_type" id="delivery_type" value="is_delivery" checked onclick="createCookieValue('delivery_type', this.value)"/>
                                Delivery</label>
                            <label><input type="radio" name="delivery_type" id="delivery_type" value="is_pickup" onclick="createCookieValue('delivery_type', this.value)"/> Pickup</label>
                        </div>
                        <div class="form-group">
                            <select name="minimum" id="minimum" class="form-control" onchange="createCookieValue('minimum', this.value)">
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
                            <select name="cuisine" id="cuisine" class="form-control" onchange="createCookieValue('cuisine', this.value)">
                                <option value="">Cuisine Types</option>
                                @foreach($cuisine as $value)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <select name="rating" id="rating" class="form-control" onchange="createCookieValue('rating', this.value)">
                                <option value="">Restaurant Rating</option>
                                <option value="5">5 Stars</option>
                                <option value="4">4 Stars or Better</option>
                                <option value="3">3 Stars or Better</option>
                                <option value="2">2 Stars or Better</option>
                                <option value="1">1 Stars or Better</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="tags" id="tags" class="form-control" onchange="createCookieValue('tags', this.value)">
                                <option value="">Tags</option>
                                @foreach($tags as $value)
                                    <option value="{{ $value->name }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="SortOrder" id="SortOrder" class="form-control" onchange="createCookieValue('SortOrder', this.value)">
                                <option value="">Sort By</option>
                                <option value="rating">Quality score</option>
                                <option value="delivery_fee">Delivery fee</option>
                                <option value="minimum">Minimum order</option>
                                <option value="id">Newest first</option>
                                <option value="name">Restaurant name</option>
                            </select>
                        </div>
                    </div>


                </div>

                <div class="card-footer  text-xs-right">
                    <input type="button" name="clearSearch" id="clearSearch" class="btn btn-link" value="Clear Search"/>
                    <input type="button" name="search" class="btn btn-primary" value="Refine Search" id="search-form-submit" onclick="submitform(event, 0);"/>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        <div class="col-lg-8 ">
            <div class="alert alert-danger alert-dismissible fade in" role="alert" id="start_up_message">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <p>Please enter an address above to find restaurants near you</p>
            </div>

            <div class="alert alert-success alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <span id="countRows" style="font: inherit;">No</span> restaurant<Span id="countRowsS" style="font: inherit;">s</span> found in your area
            </div>
            @include('ajax.search_restaurants')
        </div>
    </div>











    <script type="text/javascript">
        var elementname = '#formatted_address2';
        onloadpage();

        function keypress(event){
            if ( event.keyCode == 13 ) {
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
            if (getCookie('cname') || getCookie('latitude') || getCookie('longitude') || getCookie('minimum') || getCookie('cuisine') || getCookie('rating') || getCookie('SortOrder')) {
                $('#search-form #clearSearch').show();
            } else {
                $('#search-form #clearSearch').hide();
            }
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
            removeCookie('latitude');
            removeCookie('longitude');
            removeCookie('minimum');
            removeCookie('cuisine');
            removeCookie('rating');
            removeCookie('SortOrder');
            $(elementname).val('');
            $('#search-form #clearSearch').hide();
        });

        $('body').on('keyup', elementname, function () {
            $('#radius_panel').hide();
            if ($(this).val()) {
                $('#radius_panel').show();
            }
        });

        function submitform(e, start){
            var formatted_address = $(elementname).val();
            var latitude = $('#latitude').val().trim();
            var longitude = $('#longitude').val().trim();
            var address_alias = $('#formatted_address2').val();

            createCookieValue('longitude', longitude);
            createCookieValue('latitude', latitude);
            createCookieValue('address', address_alias);

            var token = $('#search-form input[name=_token]').val();
            var data = $('#search-form').serialize() + "&latitude=" + latitude + "&longitude=" + longitude + "&formatted_address=" + address_alias;

            if(start == 0){
                $('#search-form #clearSearch').show();
                $('#restuarant_bar').html('');
                $('.parentLoadingbar').show();
                $('#start_up_message').remove();
                $.post("{{ url('/search/restaurants/ajax') }}", {token: token, data}, function (result) {
                    $('.parentLoadingbar').hide();
                    $('#restuarant_bar').html(result);
                    $('#countRowsS').text('s');
                    if (result.trim() != "") {
                        var quantity = $('#countTotalResult').val();
                        $('#countRows').text(quantity);
                        if(quantity == "1" || quantity == 1){
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

        $('body').on('submit', '#search-form', function (e) {
           //doesn't work, tries to submit the form after the pos request
        });

        $('body').on('click', '.loadMoreRestaurants', function (e) {
            var start = $(this).attr('data-id');
            submitform(e, start);
        });

        var p = document.getElementById("radius");
        p.addEventListener("input", function() {
            $("#radius").trigger("change");
        }, false);
      </script>
@stop