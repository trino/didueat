@extends('layouts.default')
@section('content')


    <div class="margin-bottom-40">

        <div class="content-page">
            <div class="row margin-bottom-10">
                <div class="col-md-8 col-sm-8 col-xs-8">

                    {!! Form::open(array('url' => '/search/restaurants', 'id'=>'searchRestaurantForm2','class'=>'form-horizontal','method'=>'get','role'=>'form')) !!}
                    <div class="input-group" valign="center">
                        <input type="text" name="search_term" placeholder="Search Restaurants" class="form-control" value="{{ $term }}" required />
                        <span class="input-group-btn">
                            <button class="btn btn-primary red" type="submit">Search</button>
                        </span>
                    </div>
                    {!! Form::close() !!}
                    <br />

                    <h1>[<span id="countRows">{{ $count }}</span>] Local Restaurants Founds</h1>

                    <div class="row margin-bottom-20 resturant-grid" id="postswrapper">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <table id="tableRestuarant" class="table table-bordered table-hover">
                                <tbody id="restuarant_bar">
                                @include('ajax.search_restaurants')
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <button type="button" class="btn btn-primary btn-lg loadMoreRestaurants">Load more</button>
                    <img id="loadingbar" src="{{ asset('assets/images/loader.gif') }}" style="display: none;" />
                    {!! csrf_field() !!}
                </div>

                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="portlet box red">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-globe"></i>Filter Search
                            </div>
                        </div>
                        <div class="portlet-body">
                            <h4>Sort By</h4>
                            <ul id="filterType">
                                <li>
                                    Sort
                                    <select name="sortType" id="sortType">
                                        <option value="id">ID</option>
                                        <option value="name">Name</option>
                                        <option value="address">Address</option>
                                        <option value="city">City</option>
                                        <option value="province">Province</option>
                                        <option value="country">Country</option>
                                        <option value="delivery_fee">Delivery Fee</option>
                                    </select>
                                    - By
                                    <select name="sortBy" id="sortBy">
                                        <option value="ASC">ASC</option>
                                        <option value="DESC">DESC</option>
                                    </select>
                                </li>
                            </ul>
                            <h4>City</h4>
                            <ul id="filterCity">
                                @foreach($cities as $city)
                                    <li><a class="cities" data-name="{{ $city->city }}">{{ $city->city }}</a></li>
                                @endforeach
                                    <input type="hidden" name="selected_city" id="selected_city" value="" />
                            </ul>
                            <h4>Provice</h4>
                            <ul id="filterProvince">
                                @foreach($provinces as $province)
                                    <li><a class="provinces" data-name="{{ $province->province }}">{{ $province->province }}</a></li>
                                @endforeach
                                    <input type="hidden" name="selected_province" id="selected_province" value="" />
                            </ul>
                            <h4>Country</h4>
                            <ul id="filterCountry">
                                @foreach($countries as $country)
                                    <li><a class="countries" data-name="{{ $country->id }}">{{ $country->name }}</a></li>
                                @endforeach
                                    <input type="hidden" name="selected_country" id="selected_country" value="" />
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


<script type="text/javascript">
    $('body').on('click', '#filterCity a.cities', function(){
        $('#selected_city').val($(this).attr('data-name'));
        var sortType = $('#filterType #sortType').val();
        var sortBy = $('#filterType #sortBy').val();
        var city = $('#filterCity #selected_city').val();
        var province = $('#filterProvince #selected_province').val();
        var country = $('#filterCountry #selected_country').val();

        return filterFunc(sortType, sortBy, city, province, country);
    });

    $('body').on('click', '#filterProvince a.provinces', function(){
        $('#selected_province').val($(this).attr('data-name'));
        var sortType = $('#filterType #sortType').val();
        var sortBy = $('#filterType #sortBy').val();
        var city = $('#filterCity #selected_city').val();
        var province = $('#filterProvince #selected_province').val();
        var country = $('#filterCountry #selected_country').val();


        return filterFunc(sortType, sortBy, city, province, country);
    });

    $('body').on('click', '#filterCountry a.countries', function(){
        $('#selected_country').val($(this).attr('data-name'));
        var sortType = $('#filterType #sortType').val();
        var sortBy = $('#filterType #sortBy').val();
        var city = $('#filterCity #selected_city').val();
        var province = $('#filterProvince #selected_province').val();
        var country = $('#filterCountry #selected_country').val();

        return filterFunc(sortType, sortBy, city, province, country);
    });

    $('body').on('change', '#filterType #sortType, #filterType #sortBy', function(){
        var sortType = $('#filterType #sortType').val();
        var sortBy = $('#filterType #sortBy').val();
        var city = $('#filterCity #selected_city').val();
        var province = $('#filterProvince #selected_province').val();
        var country = $('#filterCountry #selected_country').val();

        if(sortType == "undefined" || sortType == null || sortType == ""){
            return alert('Please select sort type first to proceed!');
        }

        return filterFunc(sortType, sortBy, city, province, country);
    });

    function filterFunc(sortType, sortBy, city, province, country){
        var search = "{{ $term }}";
        var token = $('input[name=_token]').val();
        $('#restuarant_bar').html('');
        $('#loadingbar').show();
        $.post("{{ url('/search/restaurants/ajax') }}", {start:0, term:search, _token:token, sortType:sortType, sortBy:sortBy, city:city, province:province, country:country}, function(result){
            $('#loadingbar').hide();
            $('#restuarant_bar').html(result);
            $('#countRows').text($('#restuarant_bar tr').length);
        });
    }

    $('body').on('click', '.loadMoreRestaurants', function(){
        var search = "{{ $term }}";
        var offset = $('#tableRestuarant tr:last').attr('id');
        var token = $('input[name=_token]').val();

        $('.loadingbar').show();
        $.post("{{ url('/search/restaurants/ajax') }}", {start:offset, term:search, _token:token, sortType:'', sortBy:'', city:'', province:'', country:''}, function(result){
            $('.loadingbar').hide();
            $('#restuarant_bar').append(result);

            if(!result){
                $('.loadMoreRestaurants').remove();
            }
        });
    });
</script>

@stop