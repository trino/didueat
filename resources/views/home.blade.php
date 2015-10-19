@extends('layouts.default')
@section('content')

    <div class="content-page">
<div class="container-fluid">
        <div class="row default_page_padd">

            <div class="col-md-9 col-sm-8 col-xs-12">
                {!! Form::open(array('url' => '/search/menus', 'id'=>'searchMenuForm2','class'=>'form-horizontal','method'=>'get','role'=>'form')) !!}
                <div class="input-group" valign="center">
                    <input type="text" name="search_term" placeholder="Search Menus" class="form-control" required />
                    <span class="input-group-btn">
                        <button class="btn btn-primary red" type="submit">Search</button>
                    </span>
                </div>
                {!! Form::close() !!}
                <br />


                <h1><span id="countRows">{{ $count }}</span> Menu Items Found</h1>

                <div id="menus_bar" class="margin-bottom-20 row clearfix">
                    @include('ajax.search_menus')
                </div>

                <div class="clearfix"></div>
                <div class="col-md-12 col-sm-12 col-xs-12"><button type="button" class="btn btn-primary red loadMoreMenus margin-bottom-15" data-offset="{{ $start }}">Load more</button>
                <img id="loadingbar" src="{{ asset('assets/images/loader.gif') }}" style="display: none;" />
                {!! csrf_field() !!}</div>
                <div class="clearfix"></div>
            </div>


            <div class="col-md-3 col-sm-4 col-xs-12">




                <div class="box-shadow filter_search">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-globe"></i>Filter Search
                        </div>
                    </div>
                    <div class="portlet-body">
                        <h4>Sort By</h4>
                        <ul id="filterType" class="margin-bottom-10 clearfix">
                            <li>
                                Sort
                                <div class="input-field col s12">
                                <select name="sortType" id="sortType" class="browser-default">
                                    <option value="id">ID</option>
                                    <option value="menu_item">Name</option>
                                    <option value="price">Price</option>
                                    <option value="sing_mul">S or M</option>
                                    <option value="image">Image</option>
                                </select>
                                - By
                                <select name="sortBy" id="sortBy" class="browser-default">
                                    <option value="ASC">ASC</option>
                                    <option value="DESC">DESC</option>
                                </select>
                                    </div>
                            </li>
                        </ul>
                        <h4>Price Range</h4>
                        <ul id="filterPriceRange">
                            <li>From <input type="text" name="priceFrom" id="priceFrom" size="3" value="" /> - To <input type="text" name="priceTo" id="priceTo" size="3" value="" /></li>
                        </ul>
                        <h4>Has Addon?</h4>
                        <ul id="filterAddon">
                            <li><a class="hasAddon" data-name="1">Yes</a></li>
                            <li><a class="hasAddon" data-name="0">No</a></li>
                            <input type="hidden" name="selected_hasAddon" id="selected_hasAddon" value="" />
                        </ul>
                        <h4>Has Image?</h4>
                        <ul id="filterImage">
                            <li><a class="hasImage" data-name="1">Yes</a></li>
                            <li><a class="hasImage" data-name="0">No</a></li>
                            <input type="hidden" name="selected_hasImage" id="selected_hasImage" value="" />
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>

    <script type="text/javascript">
        $('body').on('click', '#filterAddon a.hasAddon', function(){
            $('#selected_hasAddon').val($(this).attr('data-name'));
            var sortType = $('#filterType #sortType').val();
            var sortBy = $('#filterType #sortBy').val();
            var priceFrom = $('#filterPriceRange #priceFrom').val();
            var priceTo = $('#filterPriceRange #priceTo').val();
            var singleMultiple = $('#filterSingleMultiple #selected_singleMultiple').val();
            var hasAddon = $('#filterAddon #selected_hasAddon').val();
            var hasImage = $('#filterImage #selected_hasImage').val();

            return filterFunc(sortType, sortBy, priceFrom, priceTo, singleMultiple, hasAddon, hasImage);
        });

        $('body').on('click', '#filterImage a.hasImage', function(){
            $('#selected_hasImage').val($(this).attr('data-name'));
            var sortType = $('#filterType #sortType').val();
            var sortBy = $('#filterType #sortBy').val();
            var priceFrom = $('#filterPriceRange #priceFrom').val();
            var priceTo = $('#filterPriceRange #priceTo').val();
            var singleMultiple = $('#filterSingleMultiple #selected_singleMultiple').val();
            var hasAddon = $('#filterAddon #selected_hasAddon').val();
            var hasImage = $('#filterImage #selected_hasImage').val();

            return filterFunc(sortType, sortBy, priceFrom, priceTo, singleMultiple, hasAddon, hasImage);
        });

        $('body').on('change', '#filterPriceRange #priceFrom, #filterPriceRange #priceTo', function(){
            var sortType = $('#filterType #sortType').val();
            var sortBy = $('#filterType #sortBy').val();
            var priceFrom = $('#filterPriceRange #priceFrom').val();
            var priceTo = $('#filterPriceRange #priceTo').val();
            var singleMultiple = $('#filterSingleMultiple #selected_singleMultiple').val();
            var hasAddon = $('#filterAddon #selected_hasAddon').val();
            var hasImage = $('#filterImage #selected_hasImage').val();

            return filterFunc(sortType, sortBy, priceFrom, priceTo, singleMultiple, hasAddon, hasImage);
        });

        $('body').on('change', '#filterType #sortType, #filterType #sortBy', function(){
            var sortType = $('#filterType #sortType').val();
            var sortBy = $('#filterType #sortBy').val();
            var priceFrom = $('#filterPriceRange #priceFrom').val();
            var priceTo = $('#filterPriceRange #priceTo').val();
            var singleMultiple = $('#filterSingleMultiple #selected_singleMultiple').val();
            var hasAddon = $('#filterAddon #selected_hasAddon').val();
            var hasImage = $('#filterImage #selected_hasImage').val();

            if(sortType == "undefined" || sortType == null || sortType == ""){
                return alert('Please select sort type first to proceed!');
            }

            return filterFunc(sortType, sortBy, priceFrom, priceTo, singleMultiple, hasAddon, hasImage);
        });

        function filterFunc(sortType, sortBy, priceFrom, priceTo, singleMultiple, hasAddon, hasImage){
            var search = "{{ $term }}";
            var token = $('input[name=_token]').val();

            $('#menus_bar').html('');
            $('#loadingbar').show();
            $('.loadMoreMenus').hide();
            $.post("{{ url('/search/menus/ajax') }}", {start:0, term:search, _token:token, sortType:sortType, sortBy:sortBy, priceFrom:priceFrom, priceTo:priceTo, singleMultiple:singleMultiple, hasAddon:hasAddon, hasImage:hasImage}, function(result){
                $('.loadMoreMenus').show();
                $('#loadingbar').hide();
                $('#menus_bar').html(result);
                $('#countRows').text($('div#menus_bar div.parentDiv').length);
            });
        }

        $('body').on('click', '.loadMoreMenus', function(){
            var search = "{{ $term }}";
            var offset = $('#menus_bar .parentDiv:last').attr('id');
            var token = $('input[name=_token]').val();
            var sortType = $('#filterType #sortType').val();
            var sortBy = $('#filterType #sortBy').val();
            var priceFrom = $('#filterPriceRange #priceFrom').val();
            var priceTo = $('#filterPriceRange #priceTo').val();
            var singleMultiple = $('#filterSingleMultiple #selected_singleMultiple').val();
            var hasAddon = $('#filterAddon #selected_hasAddon').val();
            var hasImage = $('#filterImage #selected_hasImage').val();

            $('.loadingbar').show();
            $.post("{{ url('/search/menus/ajax') }}", {start:offset, term:search, _token:token, sortType:sortType, sortBy:sortBy, priceFrom:priceFrom, priceTo:priceTo, singleMultiple:singleMultiple, hasAddon:hasAddon, hasImage:hasImage}, function(result){
                $('.loadingbar').hide();
                $('#menus_bar').append(result);
                if(!result){
                    $('.loadMoreMenus').remove();
                }
            });
        });
    </script>
@stop