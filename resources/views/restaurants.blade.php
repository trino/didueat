@extends('layouts.default')
@section('content')

<div class="margin-bottom-40">
    <div class="content-page">
        <div class="container-fluid">
            <div class="row margin-bottom-10">

                <div class="col-md-4 col-sm-4 col-xs-12  top-cart-block">
                    <div class="box-shadow">
                        <div class="portlet-body">
                            {!! Form::open(array('url' => '/search/restaurants', 'id'=>'searchRestaurantForm2','class'=>'form-horizontal','method'=>'get','role'=>'form')) !!}
                            <div class="input-group" valign="center">
                                <input type="text" name="search_term" placeholder="Search Restaurants" class="form-control" value="{{ $term }}" required />
                                <span class="input-group-btn">
                                    <button class="btn btn-primary red" type="submit">Search</button>
                                </span>
                            </div>
                            {!! Form::close() !!}
                            <br />

                            <h4>Sort By</h4>
                            <ul id="filterType">
                                <li>
                                    Sort
                                    <select name="sortType" id="sortType" class="browser-default">
                                        <option value="id">ID</option>
                                        <option value="name">Name</option>
                                        <option value="address">Address</option>
                                        <option value="city">City</option>
                                        <option value="province">Province</option>
                                        <option value="country">Country</option>
                                        <option value="delivery_fee">Delivery Fee</option>
                                    </select>
                                    By
                                    <select name="sortBy" id="sortBy" class="browser-default">
                                        <option value="ASC">ASC</option>
                                        <option value="DESC">DESC</option>
                                    </select>
                                </li>
                            </ul>
                            <h4><a class="filterTitle"><i class="fa fa-plus-square"></i> City</a></h4>
                            <ul id="filterCity" style="display: none;">
                                @foreach($cities as $city)
                                <li><a class="cities" data-name="{{ $city->city }}"><i class="fa fa-square-o"></i> &nbsp; {{ $city->city }}</a></li>
                                @endforeach
                                <input type="hidden" name="selected_city" id="selected_city" value="" />
                            </ul>
                            
                            <h4><a class="filterTitle"><i class="fa fa-plus-square"></i> Provice</a></h4>
                            <ul id="filterProvince" style="display: none;">
                                @foreach($provinces as $province)
                                <li><a class="provinces" data-name="{{ $province->province }}"><i class="fa fa-square-o"></i> &nbsp; {{ $province->province }}</a></li>
                                @endforeach
                                <input type="hidden" name="selected_province" id="selected_province" value="" />
                            </ul>
                            
                            <h4><a class="filterTitle"><i class="fa fa-plus-square"></i> Country</a></h4>
                            <ul id="filterCountry" style="display: none;">
                                @foreach($countries as $country)
                                <li><a class="countries" data-name="{{ $country->id }}"><i class="fa fa-square-o"></i> &nbsp; {{ $country->name }}</a></li>
                                @endforeach
                                <input type="hidden" name="selected_country" id="selected_country" value="" />
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-8 col-sm-8 col-xs-8 col-md-offset-4">
                    <h1><span id="countRows">{{ $count }}</span> Restaurants Found</h1>

                    <div class="row margin-bottom-20 resturant-grid" id="postswrapper">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div id="restuarant_bar">
                                @include('ajax.search_restaurants')
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <button type="button" class="btn btn-primary red loadMoreRestaurants">Load more</button>
                    <img id="loadingbar" src="{{ asset('assets/images/loader.gif') }}" style="display: none;" />
                    {!! csrf_field() !!}
                </div>
            </div>
        </div>

    </div>
</div>


<script type="text/javascript">
    $('body').on('click', '.filterTitle', function() {
        if ($(this).children('i.fa-plus-square').length > 0) {
            $(this).children('i').removeClass('fa-plus-square').addClass('fa-minus-square');
            $(this).parent().next().show();
        } else {
            $(this).children('i').removeClass('fa-minus-square').addClass('fa-plus-square');
            $(this).parent().next().hide();
        }
    });


    $('body').on('click', '#filterCity a.cities', function() {
        $('#selected_city').val($(this).attr('data-name'));
        var sortType = $('#filterType #sortType').val();
        var sortBy = $('#filterType #sortBy').val();
        var city = $('#filterCity #selected_city').val();
        var province = $('#filterProvince #selected_province').val();
        var country = $('#filterCountry #selected_country').val();

        $('#filterCity li a').children('i').removeClass('fa-square').removeClass('fa-square-o').addClass('fa-square-o');
        $(this).children('i').addClass('fa-square');

        return filterFunc(sortType, sortBy, city, province, country);
    });

    $('body').on('click', '#filterProvince a.provinces', function() {
        $('#selected_province').val($(this).attr('data-name'));
        var sortType = $('#filterType #sortType').val();
        var sortBy = $('#filterType #sortBy').val();
        var city = $('#filterCity #selected_city').val();
        var province = $('#filterProvince #selected_province').val();
        var country = $('#filterCountry #selected_country').val();

        $('#filterProvince li a').children('i').removeClass('fa-square').removeClass('fa-square-o').addClass('fa-square-o');
        $(this).children('i').addClass('fa-square');
        return filterFunc(sortType, sortBy, city, province, country);
    });

    $('body').on('click', '#filterCountry a.countries', function() {
        $('#selected_country').val($(this).attr('data-name'));
        var sortType = $('#filterType #sortType').val();
        var sortBy = $('#filterType #sortBy').val();
        var city = $('#filterCity #selected_city').val();
        var province = $('#filterProvince #selected_province').val();
        var country = $('#filterCountry #selected_country').val();

        $('#filterCountry li a').children('i').removeClass('fa-square').removeClass('fa-square-o').addClass('fa-square-o');
        $(this).children('i').addClass('fa-square');
        return filterFunc(sortType, sortBy, city, province, country);
    });

    $('body').on('change', '#filterType #sortType, #filterType #sortBy', function() {
        var sortType = $('#filterType #sortType').val();
        var sortBy = $('#filterType #sortBy').val();
        var city = $('#filterCity #selected_city').val();
        var province = $('#filterProvince #selected_province').val();
        var country = $('#filterCountry #selected_country').val();

        if (sortType == "undefined" || sortType == null || sortType == "") {
            return alert('Please select sort type first to proceed!');
        }

        return filterFunc(sortType, sortBy, city, province, country);
    });

    function filterFunc(sortType, sortBy, city, province, country) {
        var search = "{{ $term }}";
        var token = $('input[name=_token]').val();
        $('#restuarant_bar').html('');
        $('#loadingbar').show();
        $.post("{{ url('/search/restaurants/ajax') }}", {start: 0, term: search, _token: token, sortType: sortType, sortBy: sortBy, city: city, province: province, country: country}, function(result) {
            $('#loadingbar').hide();
            $('#restuarant_bar').html(result);
            $('#countRows').text($('#restuarant_bar span').length);
        });
    }

    $('body').on('click', '.loadMoreRestaurants', function() {
        var search = "{{ $term }}";
        var offset = $('#restuarant_bar .startRow:last').attr('id');
        var token = $('input[name=_token]').val();
        var sortType = $('#filterType #sortType').val();
        var sortBy = $('#filterType #sortBy').val();
        var city = $('#filterCity #selected_city').val();
        var province = $('#filterProvince #selected_province').val();
        var country = $('#filterCountry #selected_country').val();

        $('.loadingbar').show();
        $.post("{{ url('/search/restaurants/ajax') }}", {start: offset, term: search, _token: token, sortType: sortType, sortBy: sortBy, city: city, province: province, country: country}, function(result) {
            $('.loadingbar').hide();
            $('#restuarant_bar').append(result);

            if (!result) {
                $('.loadMoreRestaurants').remove();
            }
        });
    });
</script>

@stop