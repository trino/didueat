@extends('layouts.default')
@section('content')

<div class="content-page">
    <?php printfile("views/restaurants.blade.php"); ?>
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
                      <input type="text" name="name" id="name" value="" class="form-control" placeholder="Restaurant Name" />
                      </div>
                      <div id="radius_panel" style="display: none;">
                        <label>Radius</label>
                        <select name="radius" id="radius" class="form-control ">
                            <option value="">---</option>
                            <?php
                                foreach(array(1,2,3,4,5,10,20) as $km){
                                    echo '<option value="' . $km . '">' . $km . ' km</option>';
                                }
                            ?>
                        </select>
                      </div>
                      <div class="form-group">
                      <label><input type="radio" name="delivery_type" id="delivery_type" value="is_delivery" checked /> Delivery</label>
                      <label><input type="radio" name="delivery_type" id="delivery_type" value="is_pickup" /> Pickup</label>
                      </div>
                      <div class="form-group">
                      <select name="minimum" id="minimum" class="form-control">
                          <option value="">Delivery Minimum</option>
                          <?php
                                for($i = 5; $i < 50; $i+=5){
                                    echo '<option value="' . $i . '">$' . $i . ' - $' . $i+5 . '</option>';
                                }
                                echo '<option value="' . $i . '">$' . $i . '</option>';
                          ?>
                      </select>
                      </div>
                      <div class="form-group">
                      <select name="cuisine" id="cuisine" class="form-control ">
                          <option value="">Cuisine Types</option>
                          @foreach($cuisine as $value)
                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                          @endforeach
                      </select>
                      </div>
                      
                      <div class="form-group">
                      <select name="rating" id="rating" class="form-control ">
                          <option value="">Restaurant Rating</option>
                          <option value="5">5 Stars</option>
                          <option value="4">4 Stars or Better</option>
                          <option value="3">3 Stars or Better</option>
                          <option value="2">2 Stars or Better</option>
                          <option value="1">1 Stars or Better</option>
                      </select>
                      </div>
                      <div class="form-group">
                      <select name="tags" id="tags" class="form-control ">
                          <option value="">Tags</option>
                          @foreach($tags as $value)
                            <option value="{{ $value->name }}">{{ $value->name }}</option>
                          @endforeach
                      </select>
                      </div>
                      <div class="form-group">
                      <select name="SortOrder" id="SortOrder" class="form-control">
                            <option value="">Sort By</option>
                            <option value="rating">Quality score</option>
                            <option value="delivery_fee">Delivery fee</option>
                            <option value="minimum">Minimum order</option>
                            <option value="id">Newest first</option>
                            <option value="name">Restaurant name</option>
                      </select>
                      </div>
                      <input type="hidden" name="latitude" id="latitude" value="" />
                      <input type="hidden" name="longitude" id="longitude" value="" />
                  </div>
                  <br />
                  <div class="form-group">
                      <input type="submit" name="search" class="btn custom-default-btn" value="Refine Search" />
                  </div>
                  {!! Form::close() !!}
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-9 col-sm-8 col-xs-12">
          <div class="container-fluid">
              <div class="msgtop dropshadow"><span id="countRows" style="font: inherit;">No</span> Restaurant(s) Found</div>
              <p id="start_up_message">Please enter address above to find restaurants near your area.</p>
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
        var formatted_address = $('#formatted_address').val();
        if(formatted_address.trim() == "" || formatted_address == null){
            alert('Please enter address to proceed. thanks');
            return false;
            e.preventDefault();
        }
        var token = $('#search-form input[name=_token]').val();
        var data = $(this).serialize();
        
        $('#restuarant_bar').html('');
        $('.parentLoadingbar').show();
        $('#start_up_message').remove();
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