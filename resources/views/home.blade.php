<?php
$homeblade=true;
$testip = "24.36.50.14";// when using WAMP, need to enter ip manually
    
			 $startZoom=13;

    if(isset($_GET['userAddress'])){
				 $userAddress=$_GET['userAddress']; // this takes precedence over cookie
			  setcookie ("userAddress", $_GET['userAddress'], time()+315360000, "/", ".myseriestv.com");  // set to expire in ~10 years
				}
				elseif(isset($_COOKIE['userAddress'])){
				 $userAddress=$_COOKIE['userAddress']; // this takes precedence over cookie
				}
			 else{
     if(isset($testip)){
      $ip = $testip;
     }
     else{
      $ip = $_SERVER['REMOTE_ADDR'];   
     }
     
     if($details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"))){
      $thiscity=$details->city;
      $thisregion=$details->region;
      $thispostal=$details->postal;
      $thisLoc=$details->loc;
      $userAddress =  $thiscity.", ".$thisregion." ".$thispostal;
     }
     else{
 			  $userAddress = "Hamilton, ON";
     }
			 }


?>
@extends('layouts.default')
@section('content')

<div class="container-fluid">
				<div class="row" style="position:relative;top:150px;">
       <h1 align="center">Order Your Food From a Nearby Restaurant</h1>
									<div class="col-xs-12 col-sm-10 col-md-8 col-sm-offset-1 col-md-offset-2">
         				<form role="form">
													<div class="row home-map-form" id="homepgsrch" style="margin-left:auto;margin-right:auto;min-width:350px;max-width:700px">
				             <div class="col-xs-12 col-sm-7 col-md-7">
                     <div class="form-group" align="center">
																	         <label for="radiusSelect"><b>Enter Address, City or Postal Code:</b></label>
     																	    <input type="text" id="addressInput" placeholder="Enter Your Address, City or Postal Code" value="{{ $userAddress }}" style="width:300px;height:28px;margin-right:3px" /><input id="geoloc" type="hidden"  value="{{ $thisLoc }}" />
																	    </div>
																	</div>
                 <div class="col-xs-12 col-sm-5 col-md-5">
                     <div class="form-group" align="center">
                         <label for="radiusSelect"><b>Distance:</b></label>
		                       <select id="radiusSelect" style="margin-right:3px">
																							      <option value="1">1 km</option>
																							      <option value="2">2 km</option>
																							      <option value="5">5 km</option>
																							      <option value="10">10 km</option>
																							      <option value="20">20 km</option>
																						   </select>
                       <input type="button" id='searchBtn' class="btn-primary" style="margin-top:5px;border-radius:5px;" onclick="sendSearch()" value="Find Restaurants" />
                 </div>
             </div>
             </div>
             </form>
									</div>
				</div>
</div>



    <script type="text/javascript">
    
    function sendSearch(){
     if(document.getElementById('addressInput').value == ""){
      alert("Please enter your Address, City or Postal Code before clicking Find Restaurants");
      document.getElementById('addressInput').focus();
      return false;
     }
     else{
      window.location="{{ url('restaurants') }}?userAddress="+document.getElementById('addressInput').value+"&radiusSelect="+document.getElementById('radiusSelect').value+"&geoloc="+document.getElementById('geoloc').value;
     }
    ////
    }

    jQuery(window).on("resize", function(event) {
        var chartDiv = jQuery("#homepgsrch");
//alert(chartDiv.css('width'))

        // Temporarily hide, then set size of chart to container (which will naturally resize itself), then show it again 
        chartDiv.css({ display:"none" });
        chartDiv.css({ width:chartDiv.parent().innerWidth(), display:"block" });

    });


    $('body').on('click', '#filterAddon a.hasAddon', function() {
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

    $('body').on('click', '#filterImage a.hasImage', function() {
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

    $('body').on('change', '#filterPriceRange #priceFrom, #filterPriceRange #priceTo', function() {
        var sortType = $('#filterType #sortType').val();
        var sortBy = $('#filterType #sortBy').val();
        var priceFrom = $('#filterPriceRange #priceFrom').val();
        var priceTo = $('#filterPriceRange #priceTo').val();
        var singleMultiple = $('#filterSingleMultiple #selected_singleMultiple').val();
        var hasAddon = $('#filterAddon #selected_hasAddon').val();
        var hasImage = $('#filterImage #selected_hasImage').val();

        return filterFunc(sortType, sortBy, priceFrom, priceTo, singleMultiple, hasAddon, hasImage);
    });

    $('body').on('change', '#filterType #sortType, #filterType #sortBy', function() {
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
        }, function(result) {
            $('.loadMoreMenus').show();
            $('#loadingbar').hide();
            $('#menus_bar').html(result);
            $('#countRows').text($('div#menus_bar div.parentDiv').length);
        });
    }

    $('body').on('click', '.loadMoreMenus', function() {
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
        }, function(result) {
            $('.loadingbar').hide();
            $('#menus_bar').append(result);
            if (!result) {
                $('.loadMoreMenus').remove();
            }
        });
    });
</script>

@stop