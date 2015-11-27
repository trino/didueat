@extends('layouts.default')
@section('content')

  <div class="content-page">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3 col-sm-4 col-xs-12">
          <div class="container-fluid">
            <div class="row">
              <div class="box-shadow filter_search">
                <div class="portlet-title">
                  <h2>Filter Search</h2>
                </div>
                <div class="portlet-body">
                  {!! Form::open(array('url' => '/search/menus', 'id'=>'searchMenuForm2','class'=>'form-horizontal','method'=>'get','role'=>'form')) !!}
                  <div class="input-group" valign="center">
                    <input type="text" name="search_term" placeholder="Search Menus" class="form-control" required/>
                            <span class="input-group-btn">
                                <button class="btn custom-default-btn" type="submit">Search</button>
                            </span>
                  </div>
                  {!! Form::close() !!}

                  <br/>
                  <div class="sort search-form clearfix">
                    <h4>Sort By</h4>
                    <ul id="filterType">
                      <li>
                        {{--Sort--}}
                        <div class="input-field col s12">
                          <select name="sortType" id="sortType" class="browser-default">
                            <option value="id">ID</option>
                            <option value="menu_item">Name</option>
                            <option value="price">Price</option>
                            <option value="sing_mul">S or M</option>
                            <option value="image">Image</option>
                          </select>

                          <select name="sortBy" id="sortBy" class="browser-default">
                            <option value="ASC">ASC</option>
                            <option value="DESC">DESC</option>
                          </select>
                        </div>
                      </li>
                    </ul>
                  </div>
                  <div class="price_range search-form clearfix">
                    <h4>Price Range</h4>
                    <ul id="filterPriceRange">
                      <li><input type="text" placeholder="From" name="priceFrom" id="priceFrom" size="3" value=""/> - <input type="text" name="priceTo" placeholder="To" id="priceTo"size="3" value=""/></li>
                    </ul>
                  </div>

                  <div class="has_addon search-form clearfix">
                    <h4>Has Addon?</h4>
                    <ul id="filterAddon">
                      <li><a class="hasAddon" data-name="1"><i class="fa fa-square-o"></i> &nbsp; Yes</a></li>
                      <li><a class="hasAddon" data-name="0"><i class="fa fa-square-o"></i> &nbsp; No</a></li>
                      <input type="hidden" name="selected_hasAddon" id="selected_hasAddon" value=""/>
                    </ul>
                  </div>
                  <div class="has_img search-form clearfix">
                    <h4>Has Image?</h4>
                    <ul id="filterImage">
                      <li><a class="hasImage" data-name="1"><i class="fa fa-square-o"></i> &nbsp; Yes</a></li>
                      <li><a class="hasImage" data-name="0"><i class="fa fa-square-o"></i> &nbsp; No</a></li>
                      <input type="hidden" name="selected_hasImage" id="selected_hasImage" value=""/>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-9 col-sm-8 col-xs-12">
          <div class="container-fluid">
            <div class="row">
              <div id="menus_bar" class="menu-list">
                @include('ajax.search_menus')
              </div>
              <div class="clearfix"></div>
              <div class="col-md-12 col-sm-12 col-xs-12">
                @if ($count > 10)
                  <button type="button" class="btn btn-primary red loadMoreMenus margin-bottom-15" data-offset="{{ $start }}">Load more</button>
                  <img id="loadingbar" src="{{ asset('assets/images/loader.gif') }}" style="display: none;"/>
                @endif
                {!! csrf_field() !!}
              </div>
              <div class="clearfix"></div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <script type="text/javascript">
    $('body').on('click', '#filterAddon a.hasAddon', function () {
      $('#selected_hasAddon').val($(this).attr('data-name'));
      var sortType = $('#filterType #sortType').val();
      var sortBy = $('#filterType #sortBy').val();
      var priceFrom = $('#filterPriceRange #priceFrom').val();
      var priceTo = $('#filterPriceRange #priceTo').val();
      var singleMultiple = $('#filterSingleMultiple #selected_singleMultiple').val();
      var hasAddon = $('#filterAddon #selected_hasAddon').val();
      var hasImage = $('#filterImage #selected_hasImage').val();

      $('#filterAddon li a').children('i').removeClass('fa-square').removeClass('fa-square-o').addClass('fa-square-o');
      $(this).children('i').addClass('fa-square');
      return filterFunc(sortType, sortBy, priceFrom, priceTo, singleMultiple, hasAddon, hasImage);
    });

    $('body').on('click', '#filterImage a.hasImage', function () {
      $('#selected_hasImage').val($(this).attr('data-name'));
      var sortType = $('#filterType #sortType').val();
      var sortBy = $('#filterType #sortBy').val();
      var priceFrom = $('#filterPriceRange #priceFrom').val();
      var priceTo = $('#filterPriceRange #priceTo').val();
      var singleMultiple = $('#filterSingleMultiple #selected_singleMultiple').val();
      var hasAddon = $('#filterAddon #selected_hasAddon').val();
      var hasImage = $('#filterImage #selected_hasImage').val();

      $('#filterImage li a').children('i').removeClass('fa-square').removeClass('fa-square-o').addClass('fa-square-o');
      $(this).children('i').addClass('fa-square');
      return filterFunc(sortType, sortBy, priceFrom, priceTo, singleMultiple, hasAddon, hasImage);
    });

    $('body').on('change', '#filterPriceRange #priceFrom, #filterPriceRange #priceTo', function () {
      var sortType = $('#filterType #sortType').val();
      var sortBy = $('#filterType #sortBy').val();
      var priceFrom = $('#filterPriceRange #priceFrom').val();
      var priceTo = $('#filterPriceRange #priceTo').val();
      var singleMultiple = $('#filterSingleMultiple #selected_singleMultiple').val();
      var hasAddon = $('#filterAddon #selected_hasAddon').val();
      var hasImage = $('#filterImage #selected_hasImage').val();

      return filterFunc(sortType, sortBy, priceFrom, priceTo, singleMultiple, hasAddon, hasImage);
    });

    $('body').on('change', '#filterType #sortType, #filterType #sortBy', function () {
      var sortType = $('#filterType #sortType').val();
      var sortBy = $('#filterType #sortBy').val();
      var priceFrom = $('#filterPriceRange #priceFrom').val();
      var priceTo = $('#filterPriceRange #priceTo').val();
      var singleMultiple = $('#filterSingleMultiple #selected_singleMultiple').val();
      var hasAddon = $('#filterAddon #selected_hasAddon').val();
      var hasImage = $('#filterImage #selected_hasImage').val();

      if (sortType == "undefined" || sortType == null || sortType == "") {
        return alert('Please select sort type first to proceed!');
      }

      return filterFunc(sortType, sortBy, priceFrom, priceTo, singleMultiple, hasAddon, hasImage);
    });

    function filterFunc(sortType, sortBy, priceFrom, priceTo, singleMultiple, hasAddon, hasImage) {
      var search = "{{ $term }}";
      var token = $('input[name=_token]').val();

      $('#menus_bar').html('');
      $('#loadingbar').show();
      $('.loadMoreMenus').hide();
      $.post("{{ url('/search/menus/ajax') }}", {
        start: 0,
        term: search,
        _token: token,
        sortType: sortType,
        sortBy: sortBy,
        priceFrom: priceFrom,
        priceTo: priceTo,
        singleMultiple: singleMultiple,
        hasAddon: hasAddon,
        hasImage: hasImage
      }, function (result) {
        $('.loadMoreMenus').show();
        $('#loadingbar').hide();
        $('#menus_bar').html(result);
        $('#countRows').text($('div#menus_bar div.parentDiv').length);
      });
    }

    $('body').on('click', '.loadMoreMenus', function () {
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
      $.post("{{ url('/search/menus/ajax') }}", {
        start: offset,
        term: search,
        _token: token,
        sortType: sortType,
        sortBy: sortBy,
        priceFrom: priceFrom,
        priceTo: priceTo,
        singleMultiple: singleMultiple,
        hasAddon: hasAddon,
        hasImage: hasImage
      }, function (result) {
        $('.loadingbar').hide();
        $('#menus_bar').append(result);
        if (!result) {
          $('.loadMoreMenus').remove();
        }
      });
    });
  </script>

@stop