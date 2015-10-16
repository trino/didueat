@extends('layouts.default')
@section('content')

<div class="content-page">

    <div class="row">

        <div class="col-md-9 col-sm-8 col-xs-12 no-padding">
            {!! Form::open(array('url' => '/search/menus', 'id'=>'searchMenuForm2','class'=>'form-horizontal','method'=>'get','role'=>'form')) !!}
            <div class="input-group" valign="center">

                <input type="text" name="search_term" placeholder="Search Menus" class="form-control" required />
                <span class="input-group-btn">
                    <button class="btn btn-primary red" type="submit">Search</button>
                </span>
            </div>
            {!! Form::close() !!}
            <br />

            <div id="postswrapper" class="margin-bottom-20 clearfix">
                @include('menus')
            </div>

            <div class="clearfix"></div>
            <div id="loadmoreajaxloader" style="display:none;">
                <center><img src="{{ asset('assets/images/ajax-loader.gif') }}"></center>
            </div>
            <div class="clearfix"></div>
            <?php if ($menus_list->hasMorePages()) { ?>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12  margin-bottom-10" style="margin-left: 15px;">
                        <button align="center" class="loadmore btn btn-primary">Load More</button>
                        <img id="loadingbar" src="{{ asset('assets/images/loader.gif') }}" style="display: none;" />
                        {!! csrf_field() !!}
                    </div>
                </div>
            <?php } ?>
            <div class="clearfix"></div>
        </div>

        <div class="col-md-3 col-sm-4 col-xs-12">

            <div class="portlet box red">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i>Filter Search
                    </div>
                    <div class="tools">
                    </div>
                </div>
                <div class="portlet-body">
                    <h4>Sort By</h4>
                    <ul id="filterType">
                        <li>
                            Sort
                            <select name="sortType" id="sortType">
                                <option value="id">ID</option>
                                <option value="menu_item">Name</option>
                                <option value="price">Price</option>
                                <option value="sing_mul">S or M</option>
                                <option value="image">Image</option>
                            </select>
                            - By
                            <select name="sortBy" id="sortBy">
                                <option value="ASC">ASC</option>
                                <option value="DESC">DESC</option>
                            </select>
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

        <!-- END CONTENT -->
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

        $('#postswrapper').html('');
        $('#loadingbar').show();
        $('.loadmore').hide();
        $.post("{{ url('/search/menus/ajax') }}", {start:0, term:search, _token:token, sortType:sortType, sortBy:sortBy, priceFrom:priceFrom, priceTo:priceTo, singleMultiple:singleMultiple, hasAddon:hasAddon, hasImage:hasImage}, function(result){
            $('#loadingbar').hide();
            $('.loadmore').show();
            $('#postswrapper').html(result);
        });
    }
</script>
@stop