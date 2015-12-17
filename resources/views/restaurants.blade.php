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
                  {!! Form::open(array('url' => '/search/restaurants/ajax', 'id'=>'search-form', 'class'=>'search-form','method'=>'post','role'=>'form')) !!}
                  <div class="sort search-form clearfix">
                      <label>Restaurant Name</label>
                      <input type="text" name="name" id="name" value="" class="form-control" />
                      <div id="radius_panel" style="display: none;">
                        <label>Radius</label>
                        <select name="radius" id="radius" class="form-control ">
                            <option value="">---</option>
                            <option value="1">1 km</option>
                            <option value="2">2 km</option>
                            <option value="3">3 km</option>
                            <option value="4">4 km</option>
                            <option value="5">5 km</option>
                            <option value="10">10 km</option>
                            <option value="20">20 km</option>
                        </select>
                      </div>
                      <label><input type="radio" name="delivery_type" id="delivery_type" value="is_delivery" checked /> Delivery</label>
                      <label><input type="radio" name="delivery_type" id="delivery_type" value="is_pickup" /> Pickup</label>
                      <br />
                      <label>Delivery Minimum</label>
                      <select name="minimum" id="minimum" class="form-control">
                          <option value="">---</option>
                          <option value="5">$5 - $10</option>
                          <option value="10">$10 - $15</option>
                          <option value="15">$15 - $20</option>
                          <option value="20">$20 - $25</option>
                          <option value="25">$25 - $30</option>
                          <option value="30">$30 - $35</option>
                          <option value="35">$35 - $40</option>
                          <option value="40">$40 - $45</option>
                          <option value="45">$45 - $50</option>
                          <option value="50">$50</option>
                      </select>
                      <label>Cuisine Types</label>
                      <select name="cuisine" id="cuisine" class="form-control ">
                          <option value="">---</option>
                          @foreach($cuisine as $value)
                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                          @endforeach
                      </select>
                      <label>Restaurant Rating</label>
                      <select name="rating" id="rating" class="form-control ">
                          <option value="">---</option>
                          <option value="5">5 Stars</option>
                          <option value="4">4 Stars or Better</option>
                          <option value="3">3 Stars or Better</option>
                          <option value="2">2 Stars or Better</option>
                          <option value="1">1 Stars or Better</option>
                      </select>
                      <label>Tags</label>
                      <select name="tags" id="tags" class="form-control ">
                          <option value="">---</option>
                          @foreach($tags as $value)
                            <option value="{{ $value->name }}">{{ $value->name }}</option>
                          @endforeach
                      </select>
                      <label>Sort By</label>
                      <select name="SortOrder" id="SortOrder" class="form-control">
                            <option value="">---</option>
                            <option value="rating">Quality score</option>
                            <option value="delivery_fee">Delivery fee</option>
                            <option value="minimum">Minimum order</option>
                            <option value="id">Newest first</option>
                            <option value="name">Restaurant name</option>
                      </select>
                      <input type="hidden" name="latitude" id="latitude" value="" />
                      <input type="hidden" name="longitude" id="longitude" value="" />
                  </div>
                  <br />
                  <input type="submit" name="search" class="btn custom-default-btn" value="Refine Search" />
                  {!! Form::close() !!}
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-9 col-sm-8 col-xs-12">
          <div class="container-fluid">
              <h1><span id="countRows">{{ $count }}</span> Restaurant(s) Items Found</h1>
              @include('ajax.search_restaurants')
          </div>
        </div>
      </div>
    </div>
</div>


<script type="text/javascript">
    $('body').on('keyup', '#formatted_address', function(){
        $('#radius_panel').hide();
        if($(this).val()){
            $('#radius_panel').show();
        }
    });
    $('body').on('submit', '#search-form', function(e){
        var token = $('#search-form input[name=_token]').val();
        var data = $(this).serialize();
        
        $('#restuarant_bar').html('');
        $('.parentLoadingbar').show();
        $.post("{{ url('/search/restaurants/ajax') }}", {_token:token, data}, function(result){
            $('.parentLoadingbar').hide();
            $('#restuarant_bar').html(result);
            if(result.trim() != ""){
                $('#countRows').text($('#countTotalResult').val());
            } else {
                $('#countRows').text(0);
            }
        });
        e.preventDefault();
    });
    $('body').on('click', '.loadMoreRestaurants', function() {
        var start = $(this).attr('data-id');
        var token = $('#search-form input[name=_token]').val();
        var data = $('#search-form').serialize();
        $('.loadingbar').show();
        $('#loadingbutton').hide();
        $.post("{{ url('/search/restaurants/ajax') }}", {start: start, _token: token, data}, function(result) {
            $('#restuarant_bar').append(result);
            $('#loadMoreBtnContainer').remove();
        });
    });
    
    //Google Api Codes.
    var placeSearch, formatted_address;
    function initAutocomplete(){
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
    }

    function geolocate() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
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
<script src="https://maps.googleapis.com/maps/api/js?signed_in=true&libraries=places&callback=initAutocomplete" async defer></script>
@stop