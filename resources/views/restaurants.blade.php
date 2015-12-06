@extends('layouts.default')
@section('content')
  <?php
  if(isset($restaurantblade)){
  // pb: Add Google API key when going live
  ?>
  <script>
    var placeSearch, autocomplete;
    var componentForm = {
      locality: 'long_name',
      administrative_area_level_1: 'short_name',
      country: 'long_name',
      postal_code: 'short_name',
    }; // locality = city; administrative_area_level_1 = state/prov

    function initAutocomplete() {
      // Create the autocomplete object, restricting the search to geographical
      // location types.
      autocomplete = new google.maps.places.Autocomplete(
        /** @type {!HTMLInputElement} */(document.getElementById('addressInput')),
        {types: ['geocode']});

      // When the user selects an address from the dropdown, populate the address
      // fields in the form.
      autocomplete.addListener('place_changed', fillInAddress);
    }
  </script>
  <!--<script src="{{ asset('assets/global/scripts/maps-api.js') }}" async defer></script>-->
  <script src="https://maps.googleapis.com/maps/api/js?signed_in=true&libraries=places&callback=initAutocomplete" async defer></script>
  <?php } ?>

<?php
 $restaurantblade=true;
 $setaddresscookie=false; // don't set this cookie during development
 $testip = "24.36.50.14";// when using WAMP, need to enter ip manually
 $autoSrch=false; // do auto search only if city is found (ie, not with default input of city)
    
			 $startZoom=13;

    if(isset($_GET['userAddress'])){
				 $userAddress=$_GET['userAddress']; // GET takes precedence over cookie
     if(isset($_GET['radiusSelect'])){
      $radiusSelect=$_GET['radiusSelect'];
     }
     if(isset($_GET['geoloc'])){
      $geoLocSpl=explode(",",$_GET['geoloc']);
      $thisLat=$geoLocSpl[0];
      $thisLng=$geoLocSpl[1];
     }
     $autoSrch=true;
     if(isset($setaddresscookie)){
      if($setaddresscookie){
			    setcookie ("userAddress", $_GET['userAddress'], time()+315360000, "/", ".myseriestv.com");  // set to expire in ~10 years
			   }
     }
				}
				elseif(isset($_COOKIE['userAddress'])){
				 $userAddress=$_COOKIE['userAddress']; // this takes precedence over cookie
     $autoSrch=true;
				}
			 else{
     if(isset($testip)){
      $ip = $testip;
     }
     else{
      $ip = $_SERVER['REMOTE_ADDR'];   
     }
     
     if($details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"))){
      $thisCity=$details->city;
      $thisState=$details->region;
      $thisPostal=$details->postal;
      $thisCountry=$details->country;
      if($thisCountry=="CA"){
       $thisCountry="Canada";
      }
      
      $thisLoc=$details->loc;
      $geoLocSpl=explode(",",$thisLoc);
      $thisLat=$geoLocSpl[0];
      $thisLng=$geoLocSpl[1];
      $userAddress = $thisCity.", ".$thisState." ".$thisPostal;
      $autoSrch=true;
     }
     else{
 			  $userAddress = "Hamilton, ON";
     }
			 }
    
    if(!isset($radiusSelect)){
     $radiusSelect=10;
    }


 print("<script>var thisCity=\"".$thisCity."\",thisState=\"".$thisState."\",thisPostal=\"".$thisPostal."\",thisCountry=\"".$thisCountry."\";\nvar userAddress=\"".$userAddress."\";\nvar strtZoom=".$startZoom.";\nvar autoSrch=".$autoSrch.";\nvar thisLat=\"".$thisLat."\";\nvar thisLng=\"".$thisLng."\";</script>");

?>

<script src="https://maps.googleapis.com/maps/api/js?signed_in=true&libraries=places&callback=initAutocomplete" async defer></script>
<script>
    <?php
    if(!isset($radiusSelect) || $radiusSelect == "") {
        $radiusSelect = 2;
    }
    ?>
    var radiusSelectV =<?php echo $radiusSelect; ?>;
  var radObj = document.getElementById('radiusSelect');
  if (radObj){
  for (var i = 0; i < radObj.length; i++) {
    if (radObj.options[i].value == radiusSelectV) {
      radObj.selectedIndex = i;
      break;
    }
  }
}

  var placeSearch, autocomplete;
  var componentForm = {
    locality: 'long_name',
    administrative_area_level_1: 'short_name',
    country: 'long_name',
    postal_code: 'short_name',
  }; // locality = city; administrative_area_level_1 = state/prov

  function initAutocomplete() {
    // Create the autocomplete object, restricting the search to geographical
    // location types.
    autocomplete = new google.maps.places.Autocomplete(
      /** @type {!HTMLInputElement} */(document.getElementById('addressInput')),
      {types: ['geocode']});

    // When the user selects an address from the dropdown, populate the address
    // fields in the form.
    autocomplete.addListener('place_changed', fillInAddress);
  }

  function fillInAddress() {

    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({address: document.getElementById('addressInput').value}, function (results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        // retrieves from browser geopositioning function, if enabled and available
        var latlngSpl = results[0].geometry.location.toString().split(",")
        thisLat = latlngSpl[0].substring(1);
        thisLng = latlngSpl[1].substring(0, latlngSpl[1].length - 1);
      }

    });

    // Get the place details from the autocomplete object.
    var place = autocomplete.getPlace();

    // Get each component of the address from the place details
    for (var i = 0; i < place.address_components.length; i++) {
      var addressType = place.address_components[i].types[0];
      if (addressType == "locality") {
        thisCity = place.address_components[i][componentForm[addressType]];
        continue;
      }
      if (addressType == "administrative_area_level_1") {
        thisState = place.address_components[i][componentForm[addressType]];
        continue;
      }
      if (addressType == "country") {
        thisCountry = place.address_components[i][componentForm[addressType]];
        continue;
      }
      if (addressType == "postal_code") {
        thisPostal = place.address_components[i][componentForm[addressType]];
      }
    }

    searchLocationsNear(thisLat, thisLng, thisCity, thisState, thisPostal, thisCountry);

  }

  function radiusChng(v) {
    if (thisLat != "" && thisLng != "") {
      searchLocationsNear(thisLat, thisLng, thisCity, thisState, thisPostal, thisCountry)
    }
    ////
  }
</script>
    <script>
/***  This script will be put into an external file when ready  ***/    

// NOTE, the variable name "marker" is used as a legacy from when the page used Google Maps markers
    var infoWindow;
    var resultsDisplay="box"; // alternate: select
    var kmMi="km";
    
//    var isMobileDevice = navigator.userAgent.match(/iPad|iPhone|iPod/i) != null || screen.width <= 480;
    
    var innerWHObj;
       

   window.onload=function(){
	   if(autoSrch){
	    searchLocationsNear(thisLat,thisLng,thisCity,thisState,thisPostal,thisCountry); // other params may be used in future
	   }
   }

   function clearLocations() {  
     // reset the other arrays for this new search:
     markerDataA=[];
		 markerSelected=[];
		 pgParams=[];
     
     document.getElementById('list').innerHTML="";
     document.getElementById('topLinks').innerHTML="";

   }


function loadPg(pgNum,prevNext,thisnumMarkers){
 // this is for pagination
 
 var newpgNum="";
  
 // determine the new active page
 if(pgNum  || parseInt(pgNum) == 0){
  newpgNum=pgNum;
 }
 else if(prevNext == "prev"){
  newpgNum = (activepg - 1);
 }
 else{
  newpgNum = (activepg + 1);
 }
 
 
 // clear existing items list div (Note: keep items in cart identified with markerSelected array)
 
 // clear existing highlited page numbers, and highlite new active pg
 
 // change backgrounds, then save value to str to put back into list box once the new markers are added
 document.getElementById('pg'+activepg).style.background="#fff";
 document.getElementById('pgTop'+activepg).style.background="#fff";

 if((newpgNum && newpgNum < numpgs) || parseInt(newpgNum) == 0){
  document.getElementById('pg'+newpgNum).style.background="#d3d3d3";
  document.getElementById('pgTop'+newpgNum).style.background="#d3d3d3";
 }
 else{
  if(prevNext == "prev"){
   document.getElementById('pg'+(activepg-1)).style.background="#d3d3d3";
   document.getElementById('pgTop'+(activepg-1)).style.background="#d3d3d3";
  }
	 else{
	  // next
	   document.getElementById('pg'+(activepg+1)).style.background="#d3d3d3";
	   document.getElementById('pgTop'+(activepg+1)).style.background="#d3d3d3";
	 }
 }

if(numpgs > 2){ // prev and next are shown only if there are more than 2 pages
 if(newpgNum === 0){
  document.getElementById('prevpag').style.visibility="hidden";
  document.getElementById('nextpag').style.visibility="visible";
  
  document.getElementById('prevpagTop').style.visibility="hidden";
  document.getElementById('nextpagTop').style.visibility="visible";
 }
 else if(newpgNum == (numpgs-1)){
  document.getElementById('nextpag').style.visibility="hidden";
  document.getElementById('prevpag').style.visibility="visible";
  
  document.getElementById('nextpagTop').style.visibility="hidden";
  document.getElementById('prevpagTop').style.visibility="visible";
 }
 else{
 // set prev and next to visible
  document.getElementById('nextpag').style.visibility="visible";
  document.getElementById('prevpag').style.visibility="visible";
  
  document.getElementById('nextpagTop').style.visibility="visible";
  document.getElementById('prevpagTop').style.visibility="visible";
 }
}

 if(numpgs > 1){
  document.getElementById('numReturned').innerHTML="<span id='numMarkers'>"+thisnumMarkers+"</span> <span id='MatchesID'>Matches, Page "+(parseInt(newpgNum)+1)+" of &nbsp;"+numpgs+"</span>"+matchAppend;
 }

 // recreate the top links 
	 newpgsStr = document.getElementById('pagination').innerHTML;  // copy it so we don't have to recreate it
	 newpgsStrTop = document.getElementById('topPagination').innerHTML;  

 var existingPgIndxStrt="";
 var existingIndexMax="";
 if(activepg === 0){
 // for clearing exisiting markers and polygons
	 var existingPgIndxStrt=0;
	 var existingIndexMax=perpg;
 }
 else{
// alert("numpgs: "+numpgs)
	 var existingPgIndxStrt=activepg*perpg;
  if(activepg == (numpgs-1)){
  // meaning it's the last page
   var existingIndexMax=existingPgIndxStrt+lastPgRemainder;
  }
  else{
 	 var existingIndexMax=existingPgIndxStrt+perpg;   
  }
 }

 
 document.getElementById('list').innerHTML="";
 document.getElementById('topLinks').innerHTML="";
 
  
 // now populate sidebox with new page items

 var thisPgIndxStrt="";
 var indexMax="";
 if(newpgNum === 0){
  thisPgIndxStrt=0;
  indexMax=perpg;
 }
 else{
  thisPgIndxStrt=newpgNum*perpg;
  indexMax=thisPgIndxStrt+perpg;
 }
 
 for(var i=thisPgIndxStrt;i<indexMax;i++){
 // pgParams: latlng, arrayIndex, boxCnt
  if(pgParams[i]){ 
		 createSideBox(false,pgParams[i].arrayIndex,pgParams[i].boxCnt);
  }
 }
 
  var pgspara = document.createElement("P");
  pgspara.setAttribute('id','pagination');
  pgspara.setAttribute('style','margin-left:auto;margin-right:auto;text-align:center');
  pgspara.innerHTML=newpgsStr; 
		document.getElementById("list").appendChild(pgspara);
  
  var pgsparaTop = document.createElement("P");
  pgsparaTop.setAttribute('id','topPagination');
  pgsparaTop.innerHTML=newpgsStrTop;
		document.getElementById("topLinks").appendChild(pgsparaTop);

 
  activepg=newpgNum;
 
// document.title="activepg: "+activepg;

////
}

var activepg=0;
var pgsStr="";
var pgsStrTop="";
var lastPgRemainder;

function appendPgsStr(totalNumMarkers){
 pgsStr="";
 pgsStrTop="";
 var bgcolorHilight="";
 numpgs=Math.floor(totalNumMarkers/perpg);
	var remainderNum = totalNumMarkers % perpg;
	if(remainderNum > 0){
	// means a final page is needed for at least one item
	  numpgs=numpgs+1;
   lastPgRemainder=remainderNum;
  }

 for(var i=0;i<numpgs;i++){
  if(i == 0 && numpgs > 2){
   prevPgNum=(activepg-1);
   pgsStr+="<a HREF='#' onclick='loadPg(false,\"prev\","+totalNumMarkers+");return false' id='prevpag' style='visibility:hidden;padding-left:10px;padding-right:15px'>Prev</a>&nbsp; ";
   
   pgsStrTop+="<a HREF='#' onclick='loadPg(false,\"prev\","+totalNumMarkers+");return false' id='prevpagTop' style='visibility:hidden;padding-left:10px;padding-right:15px'>Prev</a>&nbsp; ";
  }
  
  if(activepg == i){
   bgcolorHilight=";background:#d3d3d3";
  }
  else{
   bgcolorHilight="";
  }
  
  pgsStr+=" <a HREF='#' onclick='loadPg("+i+",false,"+totalNumMarkers+");return false' id='pg"+i+"' style='padding:10px;font-weight:bold;font-size:14px;line-height:14px;height:15px"+bgcolorHilight+"'>"+(i+1)+"</a>&nbsp; ";
  
  pgsStrTop+=" <a HREF='#' onclick='loadPg("+i+",false,"+totalNumMarkers+");return false' id='pgTop"+i+"' style='padding:10px;font-weight:bold;font-size:14px;line-height:14px;height:15px"+bgcolorHilight+"'>"+(i+1)+"</a>&nbsp; ";

  if(i == (numpgs-1) && numpgs > 2){
  
   nxtPgNum=(activepg+1);
   pgsStr+="<a HREF='#' onclick='loadPg(false,\"next\","+totalNumMarkers+");return false' id='nextpag' style='padding-left:10px'>Next</a>";
   pgsStrTop+="<a HREF='#' onclick='loadPg(false,\"next\","+totalNumMarkers+");return false' id='nextpagTop' style='padding-left:10px'>Next</a>";
  }

 }

  var pgspara = document.createElement("P");
  pgspara.setAttribute('id','pagination');
  pgspara.setAttribute('style','margin-left:auto;margin-right:auto;text-align:center');
  pgspara.innerHTML=pgsStr; 
		document.getElementById("list").appendChild(pgspara);
 
  var pgsparaTop = document.createElement("P");
  pgsparaTop.setAttribute('id','topPagination');
  pgsparaTop.innerHTML=pgsStrTop; 
		document.getElementById("topLinks").appendChild(pgsparaTop);

     if(useRefined){
       var addPgs=addPgsRefn;
       var es="es";
       var pgMsg="";
       if(numMarkers < 2){
        es="";
       }
       else{
        if(numpgs > 1){
         pgMsg=", Page 1 of &nbsp;"+numpgs;
         document.getElementById('numReturned').style.marginBottom="20px"
        }
       }
       document.getElementById('MatchesID').innerHTML="Match"+es+pgMsg;
     }
     
  document.getElementById('numMarkers').innerHTML=totalNumMarkers;
 
////
}


showMoreA=[];
markerDataA=[];
markerSelected=[];
polygons=[];
pgParams=[]; // for pagination
var perpg=3;
var numpgs;
var numMarkers;
var matchAppend;
var markerDataALen=0;

var currAddr="{{ $userAddress }}";
function searchRefined(){

/*
<!--  for(var i=0;i<;i++){
  createSideBox(true,indx,bxId)
 } -->
*/

////
}

function searchLocations(){

 searchLocationsNear(thisLat,thisLng,thisCity,thisState,thisPostal,thisCountry); // other params may be used in future
////
}

   function searchLocationsNear(lat,lng,thisCity,thisState,thisPostal,thisCountry) {

    var addPgs=false;
    var es="es";
    var pgMsg="";
    clearLocations();

    if(radObj){
      var radius = document.getElementById('radiusSelect').value;
    } else {
      var radius = 0;
    }

     var searchUrl = 'dbRetrievalToXml.php?lat=' + lat+ '&lng=' + lng + '&radius=' + radius+"&city="+thisCity+"&state="+thisState+"&postal="+thisPostal+"&country="+thisCountry;
  
       downloadUrl(searchUrl, function(data) {
       var xml = parseXml(data);
       var markerNodes = xml.documentElement.getElementsByTagName("marker"); // the AJAX file used the xml element "marker"
       
      numMarkers = markerNodes.length;
      
      // calculate number of pages to be used internally below, but use appendStr fn for the global numpgs variable
      var thisNumpgs=Math.floor(numMarkers/perpg);
     	var thisRemainderNum = numMarkers % perpg;
						if(thisRemainderNum > 0){
						// means a final page is needed for at least one item
						  thisNumpgs=thisNumpgs+1;
					  }
      
      if(numMarkers > 0){

       if(numMarkers < 2){
        es="";
       }
       else{
        if(thisNumpgs > 1){
         pgMsg=", Page 1 of &nbsp;"+thisNumpgs;
         document.getElementById('numReturned').style.marginBottom="20px"
        }
       }
       var thisSrchCity=thisCity+", "+thisState;
       matchAppend=" <span style='font-size:16px;color:#000'>("+thisSrchCity+", "+radius+kmMi+")</span>";
       document.getElementById('numReturned').innerHTML="<span id='numMarkers'>"+numMarkers+"</span> <span id='MatchesID'>Match"+es+pgMsg+"</span>"+matchAppend;
       document.getElementById('numReturned').style.visibility="visible";
       document.getElementById('addressInput').value=thisSrchCity+", "+thisCountry;
//		     document.getElementById('leftcol').style.display="block";
       
                   
       for (var i = 0; i < numMarkers; i++) {
// id,name,slug,genre,email,website,phone,address,postal_code,lat,lng,distance,description,logo,delivery_fee,minimum,rating,latlng
         var id = parseInt(markerNodes[i].getAttribute("id"));
         var name = markerNodes[i].getAttribute("name");
         var slug = markerNodes[i].getAttribute("slug");
         var genre = markerNodes[i].getAttribute("genre");
         var email = markerNodes[i].getAttribute("email");
         var website = markerNodes[i].getAttribute("website");
         var phone = markerNodes[i].getAttribute("phone");
/*
<!-- 
         var addressPop=markerNodes[i].getAttribute("address").split(",");
									addressPop.pop(); // remove last item on split array, because we don't need country displaying here
         if(thisCountry == "Canada" || thisCountry == "USA"){
          addressPop.pop(); // remove state/province and zip/postal code
         }
									var address = addressPop.join();
 -->
*/
         var address = markerNodes[i].getAttribute("address");
         var postal_code = markerNodes[i].getAttribute("postal_code");
         var latlng = "("+markerNodes[i].getAttribute("lat")+","+markerNodes[i].getAttribute("lng")+")";
         var distance = parseFloat(markerNodes[i].getAttribute("distance")).toFixed(2)+" "+kmMi;
         var description = markerNodes[i].getAttribute("description");
         var logo = markerNodes[i].getAttribute("logo");
         var delivery_fee = parseFloat(markerNodes[i].getAttribute("delivery_fee")).toFixed(2);
         var minimum = parseFloat(markerNodes[i].getAttribute("minimum")).toFixed(2);
         var rating = parseFloat(markerNodes[i].getAttribute("rating"));
         
         var thisData = {id:id, name:name, slug:slug, genre:genre, email:email, website:website, phone:phone, address:address, postal_code:postal_code, distance:distance, description:description, logo:logo, delivery_fee:delivery_fee, minimum:minimum, rating:rating, latlng:latlng};
         
         markerDataA[i]=thisData;
         markerSelected[i]=false;
        
         showMoreA[i]=false;
         
         if(i < perpg){
         // to paginate results
	         createSideBox(false,i,boxCnt);
         }
         
         if(numMarkers > perpg){
         // show pagination navigation only if # markers > # per pg (otherwise, only 1 page needed)
          addPgs=true;
         }

        // save values for when user clicks next page
        // latlng, array index, boxCnt
        pgParams[i]={latlng:latlng,arrayIndex:i,boxCnt:boxCnt};
         
       }
       
       
							if (typeof markerDataA !== 'undefined' && markerDataA.length > 0) {
							 markerDataALen=markerDataA.length;
							 markerDataAOK=true;
        getRefineData(markerDataAOK); // this fn displays only DB returned data for the lists used for Refining the Search 
							}
              
       if(addPgs){
        appendPgsStr(numMarkers);
       }
              
       }
       else{
        document.getElementById('numReturned').innerHTML="";
        document.getElementById('numReturned').style.visibility="hidden";
        alert("No Matches in Your Specified Location.\n\nPlease Try Increasing the Search Distance, or Specifying A Different Address.\n\n")
       }
      });
    }
    

    function deleteFromMyList(indx,bxId){
     markerSelected[indx]=false;
     document.getElementById('loc'+bxId).style.border="none";
     document.getElementById('loc'+bxId).style.margin="1px";
     document.getElementById('btn'+bxId).style.color="#000000";
     document.getElementById('btn'+bxId).value='Reserve This Spot';
     
     document.getElementById('btn'+bxId).setAttribute('onclick','sendData('+indx+','+bxId+')');
          
     
     
// unhighlight left column list box of this item
// leave boxCnt unchngd, to make easier to keep track of user item reservation instead of incrementing/decrementing
// the number for boxCnt is saved with the markers in the markerSelected array (probably not needed for didueat)


    ////
    }

function getinnerWidth() {
 var w = window.innerWidth
|| document.documentElement.clientWidth
|| document.body.clientWidth;

var h = window.innerHeight
|| document.documentElement.clientHeight
|| document.body.clientHeight;

return {w:w,h:h};

}

    function sendDataFwd(){
     thisLen=markerSelected.length;
     for(var i=0;i<thisLen;i++){
      if(markerSelected[i] !== false){
       
		     var fld = document.createElement("INPUT");
					  fld.setAttribute("type","hidden");
							fld.setAttribute("name","reservations[]");
							fld.setAttribute("value",markerDataA[i].ownerID+","+markerDataA[i].id);
		     var brTag = document.createElement("BR");
		     document.getElementById('reservations').appendChild(brTag);
		     document.getElementById('reservations').appendChild(fld);
      }
     }
     document.reservations.submit.click();
    ////
    }
    
    function sendData(indx,bxId){

     markerSelected[indx]=bxId;
     document.getElementById('loc'+bxId).style.border="solid #f00000 1px";
     document.getElementById('loc'+bxId).style.margin="0px";
     document.getElementById('btn'+bxId).style.color="#f00000";
     document.getElementById('btn'+bxId).value='Delete From Cart';
     document.getElementById('btn'+bxId).setAttribute('onclick','deleteFromMyList('+indx+','+bxId+')');

    ////
    }

var boxCnt=0; // keep incrementing, even if user deletes some of the items from the lefthand list

    function showInfo(refinedB,indx,b){
    
    // showInfo creates results for each index
     var divSt="";
     var divEnd="";
     var btnColor="#000";
     var btnFW="normal";
     if(markerSelected[indx]){
      divSt="<div style='border:solid #ff0000 2px;padding:4px'>";
      divEnd="</div>";
      btnColor="#f00";
      btnFW="bold";
     }

// id,name,slug,genre,email,website,phone,address,postal_code,lat,lng,distance,description,logo,delivery_fee,minimum,rating,latlng

     if(markerDataA[indx].rating){
      var ratingImgNum=(Math.round(markerDataA[indx].rating * 2) / 2).toFixed(1);
     }
     else{
      var ratingImgNum=0; // shows 'Unrated' image
     }
     
     
     thisEmail="";
     if(markerDataA[indx].email){
      thisEmail="<a href='mailto:"+markerDataA[indx].email+"' title='"+markerDataA[indx].email+"'>Email Restaurant</a>";
     }
     
     thisWebsite="";
     if(markerDataA[indx].website){
      thisElip="";
      thisTitle=""; // only put the title attribute in if the displayed text is less than the whole url
      websiteStr=markerDataA[indx].website.substring(0,50); // clip url displayed at 50
      if(websiteStr.length < markerDataA[indx].website.length){
       thisElip="&hellip;";
       thisTitle=markerDataA[indx].website;
      }
      if(websiteStr.indexOf("www.") < 0){
       websiteStr="www."+websiteStr;
      }
      thisWebsite="<br/><a href='http://"+markerDataA[indx].website+"' title='"+thisTitle+"'>"+websiteStr+thisElip+"</a>";
     }
     
     var thisInfo = divSt+"<img src='assets/images/logos/"+markerDataA[indx].logo+"' border='0' align='right' title='" + markerDataA[indx].name + "' class='restoLogo' onclick='alert(\"Restaurant Index: "+markerDataA[indx].id+"\")' /><b>" + markerDataA[indx].name + "&nbsp; ("+markerDataA[indx].genre+") <img src='assets/images/rating"+ratingImgNum+".gif' title='Rating: "+markerDataA[indx].rating+"' border='0' class='ratingImg' />&nbsp; <div style='display:inline-block;color:#FF0000'>(Delivery: $"+markerDataA[indx].delivery_fee+", &nbsp;Minimum: $"+markerDataA[indx].minimum+")</div></b>&nbsp; <span><i>"+markerDataA[indx].slug+"</i></span><br/>" + markerDataA[indx].address+"&nbsp; &nbsp;(Distance: "+markerDataA[indx].distance+")<br/>"+markerDataA[indx].phone+" &nbsp;"+thisEmail+thisWebsite+"&nbsp; &nbsp; <a HREF='#' onclick='showmore("+indx+");return false' style='color:#00f;'><u>More</u><span class='dArr'>&#9660;</span></a><div id='more"+indx+"' style='display:none;padding:0px;margin:0px;position:relative;left:30px'></div>"+divEnd;

     if(b){
      boxCnt++;
     }
     return thisInfo;
    ////
    }

function showmore(i){
 if(showMoreA[i]){
  document.getElementById('more'+i).innerHTML="";
  document.getElementById('more'+i).style.display="none";
  showMoreA[i]=false;
 }
 else{
  document.getElementById('more'+i).innerHTML=markerDataA[i].description+"<br/>Minimum Purchase: $"+markerDataA[i].minimum;
  document.getElementById('more'+i).style.display="block";
  showMoreA[i]=true;
 }
////
}

var keepOpn=false;

function createSideBox(refinedB,indx,bxId){
  
  var para = document.createElement("P");
  para.innerHTML=showInfo(refinedB,indx,true); // showInfo creates results for each index
  para.setAttribute("class","results");
  para.setAttribute("id","loc"+bxId);
  
  var hrTag = document.createElement("HR");
  hrTag.setAttribute("width","100%");
  para.appendChild(hrTag);
  
		document.getElementById("list").appendChild(para);
 
////
}


    
    function getMo(v){
     switch (v){
     case 0:
      return "Jan";
     break;
     case 1:
      return "Feb";
     break;
     case 2:
      return "Mar";
     break;
     case 3:
      return "Apr";
     break;
     case 4:
      return "May";
     break;
     case 5:
      return "Jun";
     break;
     case 6:
      return "Jul";
     break;
     case 7:
      return "Aug";
     break;
     case 8:
      return "Sep";
     break;
     case 9:
      return "Oct";
     break;
     case 10:
      return "Nov";
     break;
     case 11:
      return "Dec";
     }
    ////
    }
    
    function getDa(v){
     switch (v){
     case 0:
      return "Sun";
     break;
     case 1:
      return "Mon";
     break;
     case 2:
      return "Tue";
     break;
     case 3:
      return "Wed";
     break;
     case 4:
      return "Thu";
     break;
     case 5:
      return "Fri";
     break;
     case 6:
      return "Sat";
     break;
     }
    ////
    }


        
    function reserveList(indx){
     var para = document.createElement("P");
// markerDataA:  id, startdate, enddate, times, price, address, distance, ownerID, ownerName, rating, security
     var thisAddress = markerDataA[indx].address.split(/,(.+)?/);
     var dateDisplay = "";
     startSpl=markerDataA[indx].startdate.split("-");
     thestart=new Date(startSpl[0],startSpl[1]-1,startSpl[2]);
     dateDisplay=getDa(parseInt(thestart.getDay()))+", "+getMo(parseInt(thestart.getMonth()))+" "+parseInt(startSpl[2])+", "+startSpl[0];
     if(markerDataA[indx].startdate != markerDataA[indx].enddate){
      endSpl=markerDataA[indx].enddate.split("-");
      theend=new Date(endSpl[0],endSpl[1]-1,endSpl[2]);
      dateDisplay=dateDisplay+" <u>to</u> "+getDa(parseInt(theend.getDay()))+", "+getMo(theend.getMonth())+" "+parseInt(endSpl[2])+", "+endSpl[0];
     }
     
     timesSpl=markerDataA[indx].times.split("~~");
     
     var nxtDay="";
     if(parseInt(timesSpl[0]) > parseInt(timesSpl[1])){
      // means next day
      nxtDay=" (the next day)";
     }
     
     if(markerDataA[indx].rating){
      var ratingImgNum=(Math.round(markerDataA[indx].rating * 2) / 2).toFixed(1);
     }
     else{
      var ratingImgNum=0;
     }
         
					para.innerHTML="<b><u>Owner</u>: "+markerDataA[indx].ownerName+"&nbsp; <img src='assets/images/rating"+ratingImgNum+".gif' border='0' title='Rating "+markerDataA[indx].rating+"' class='ratingImg' /><br/>$"+markerDataA[indx].price+" ea</b> &nbsp;Security: "+markerDataA[indx].security+"<br/>"+thisAddress[0]+"<br/>"+thisAddress[1]+"<br/><span style='color:#008000'><b><u>Distance</u>: "+markerDataA[indx].distance.toFixed(2)+" mi (from location) </b></span><br/><u>Available Dates</u>:<br/>"+dateDisplay+"<br/><u>Times</u>:<br/>"+timesSpl[0]+" <u>to</u> "+timesSpl[1]+nxtDay+"<br/>";
     
					para.setAttribute("class","results");
					para.setAttribute("id","loc"+bxId);
     
     var btn = document.createElement("BUTTON");
     var t = document.createTextNode("Delete This");
     btn.style.marginTop="7px";
     btn.style.width="120px";
     btn.style.marginLeft="auto";
     btn.style.marginRight="auto";
     btn.style.textAlign="center";
     btn.appendChild(t);   
     btn.onclick = function() {
      deleteFromMyList(indx,bxId);
     }
     para.appendChild(btn);
     
     var hrTag = document.createElement("HR");
     para.appendChild(hrTag);
     
					document.getElementById("reserve").appendChild(para);

    ////
    }


    function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;

      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request.responseText, request.status);
        }
      };

      request.open('GET', url, true);
      request.send(null);
    }

    function parseXml(str) {
      if (window.ActiveXObject) {
        var doc = new ActiveXObject('Microsoft.XMLDOM');
        doc.loadXML(str);
        return doc;
      } else if (window.DOMParser) {
        return (new DOMParser).parseFromString(str, 'text/xml');
      }
    }

    function doNothing() {}


</script>

    <div class="margin-bottom-40">
        <div class="content-page">
        <div class="container-fluid">
            <div class="row margin-bottom-10" style="padding:0px;margin-top:0px">



                <div class="col-md-3 col-sm-3 col-xs-12  top-cart-block">
                    <div class="box-shadow" style="padding-left:10px">
<br/><br/>
       <ul class="nav navbar-nav">
          <li id="top-address-search-select">
            <select id="radiusSelect" onchange="radiusChng(this.value)" style="position:relative;top:-3px;padding:0px;">
              <option value="1">1 km</option>
              <option value="2">2 km</option>
              <option value="5">5 km</option>
              <option value="10">10 km</option>
              <option value="20">20 km</option>
            </select>
          </li> &nbsp; <span style="font-size:17px;font-weight:bold">Specify Search Distance</span>
          </ul>
          
          <br/>
          <hr width="100%" style="margin-top:30px;margin-bottom:-10px" align="center" />
        
        <div style="margin-right:10px;margin-bottom:10px;margin-top:0px;text-align:center;padding:0px;padding-bottom:10px;border-bottom:solid #000 1px"><label for="searchBtn" style="padding:0px;margin:0px"><h3 style="display:block;margin-bottom:5px">Refine Search With<br/>Options Below</h3></label>
        <input class="btn btn-default nearby-res-btn srchBtnRnd" style="margin:0px;border-radius:8px" id="searchBtn" type="button" title="Click to Refine Your Search Results" onclick="refineSelection()" value="Find Nearby Restaurants"></div>
        

        <div class="container-fluid" style="margin:0px;padding:0px">
            <div class="row margin-bottom-10" style="padding:0px;margin-top:0px">
                <div class="col-md-12 col-sm-12 col-xs-12" align="left" style="margin-right:0px;padding-right:0px;">
        
											<label for="minimum" style="font-weight:bold;font-size:15px">Delivery Minimum Purchase*</label><br/>
			        <div class="btn-group">
									  <button type="button" class="btn btn-danger" data-toggle="dropdown" style="background:#ff1a1a;font-weight:bold">Select Minimum</button>
									  <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" style="background:#ff1a1a;border-left:solid #770000 2px">
									    <span class="caret"></span>
									  </button>
									  <ul class="dropdown-menu" role="menu" id="minimum"></ul>&nbsp; <span id="minimumDisp" style="position:relative;top:5px;color:#f00;font-size:14px"></span>
									</div>
         <br/>*<span style="font-size:14px">Does not apply to Pickups</span>
        </div>
</div>


            <div class="row margin-bottom-10" style="padding:0px;margin-top:0px">
                <div class="col-md-12 col-sm-12 col-xs-12" align="left" style="margin-right:0px;padding-right:0px;"><br/>

										<label for="ratingRef" style="font-weight:bold;font-size:15px">Restaurant Rating</label><br/>
		        <div class="btn-group">
								  <button type="button" class="btn btn-danger" data-toggle="dropdown" style="background:#ff1a1a;font-weight:bold">Select Rating</button>
								  <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" style="background:#ff1a1a;border-left:solid #770000 2px">
								    <span class="caret"></span>
								  </button>
								  <ul class="dropdown-menu" role="menu" id="ratingRef">
          <li><a HREF="#" onclick="document.getElementById('stars').innerHTML='All';return false;">Show All Ratings</a></li>
          <li><a HREF="#" onclick="document.getElementById('stars').innerHTML='5/5';return false;">5 Stars</a></li>
          <li><a HREF="#" onclick="document.getElementById('stars').innerHTML='4/5';return false;">4 Stars or Better</a></li>
          <li><a HREF="#" onclick="document.getElementById('stars').innerHTML='3/5';return false;">3 Stars or Better</a></li>
          <li><a HREF="#" onclick="document.getElementById('stars').innerHTML='2/5';return false;">2 Stars or Better</a></li>
          </ul>&nbsp; <span id="stars" style="position:relative;top:5px;color:#f00;font-size:14px">All</span>
								</div>
       
       </div>


<div class="col-md-12 col-sm-12 col-xs-12" align="left"><br/><br/>
										<label for="genreDD" style="font-weight:bold;font-size:15px">Restaurant Cuisine Types</label><br/>
		        <div class="btn-group">
								  <button type="button" id="cuisinesBtn" class="btn btn-danger" data-toggle="dropdown" style="background:#ff1a1a;font-weight:bold" onclick="cuisineOpn=false;showCuisines()">Select Cuisines</button>
								  <button type="button" id="cuisinesCaret" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" style="background:#ff1a1a;border-left:solid #770000 2px" onclick="cuisineOpn=false;showCuisines()">
								    <span class="caret"></span>
								  </button>
								<ul class="dropdown-menu" role="menu" id="genreDD" onmouseover="mouseoverCuisines=true" onmouseout="mouseoverCuisines=false">
        <li>
								<div id="genre" class="genreList" align="left" onmouseover="mouseoverCuisines=true" onmouseout="mouseoverCuisines=false"></div></li>
        </ul>&nbsp; <span id="cuisinesSelected" style="position:relative;top:5px;color:#f00;font-size:14px"></span>
</div>

								<div id="resultsOutput"></div>
</div>
</div>
</div>

<script>

// set up Refinement lists to show only items that have matches
var mouseoverCuisines=false;
var cuisineOpn=false;
var markerDataAOK = false;
var uncheckallBool=true;


var genreboxHead="<div class='row panel-header' onmouseover='mouseoverCuisines=true' onmouseout='mouseoverCuisines=false'><div class='col-xs-5' style='margin:0px'><h3 style='margin:0px'>&nbsp;Cuisines</h3></div><div class='col-xs-5' align='right'><a HREF='#' onclick='clearAllChkdGenre();return false' id='uncheckall' style='position:relative;top:-5px;font-size:14px;text-decoration:underline;color:red'><span style='font-size:20px'>U</span>ncheck All</a></div><div class='col-xs-2' align='right' style='padding:0px'><img src=\"{{ asset('assets/images/logos/close-x.gif') }}\" border='0' style='cursor:pointer;position:relative;top:-6px;left:-4px' onclick='cuisineOpn=true;showCuisines()' title='Close Cuisines Popup' /></div></div><hr style='border:none;border-top:solid #000 2px;margin:2px' />";

function showCuisines(){
 if(!cuisineOpn){
 $('#genreDD').collapse("show");
    document.getElementById('genre').innerHTML=genreboxHead+genreCBStr;
//    alert(genresIndxA.join())
    for(var i=0;i<genresFoundLen;i++){
     var thisgenreIndx=genresIndxA.indexOf(i);
     if(thisgenreIndx != -1){
      document.getElementById('genre'+i).checked=true;
     }
     else{
//     alert('Unchecking genre'+i)
      document.getElementById('genre'+i).checked=false;
     }
    }
 cuisineOpn=true;
 }
 else{
  cuisineOpn=false;
  $('#genreDD').collapse("hide");
 }
 
////
}

function clearAllChkdGenre(){
	
	 for(var i=0;i<genresFoundLen;i++){
				 if(uncheckallBool){
				  document.getElementById('genre'+i).checked=false;
					 genresA=[];
					 genresIndxA=[];
      document.getElementById('uncheckall').innerHTML="<span style='font-size:20px'>C</span>heck All";
				 }
				else{
			  document.getElementById('genre'+i).checked=true;
     genresIndxA.push(i);
     genresA.push(genresFound[i]);
     document.getElementById('uncheckall').innerHTML="<span style='font-size:20px'>U</span>ncheck All";
				}
	 }
  
  uncheckallBool = (uncheckallBool) ? false:true;

////
}


function genreToggle(i,chkd,v){
 var thisgenreIndx=genresIndxA.indexOf(i);
 if(chkd){
  if(thisgenreIndx == -1){
   genresA.push(v);
   genresIndxA.push(i);
  }
 }
 else{
  if(thisgenreIndx != -1){
  // remove from array
//  alert("remove "+i+" from array at index: "+thisgenreIndx)
   genresA.splice(thisgenreIndx,1);
   genresIndxA.splice(thisgenreIndx,1);
  }
 }
 if(genresIndxA.length > 0){
  document.getElementById('cuisinesSelected').innerHTML="("+genresIndxA.length+" Selected)";
  document.getElementById('cuisinesBtn').title="Selected Cuisines: "+genresA.join(" | ");
  document.getElementById('cuisinesCaret').title="Selected Cuisines: "+genresA.join(" | ");
 }
 else{
  document.getElementById('cuisinesSelected').innerHTML="None Selected";
  document.getElementById('cuisinesBtn').title="No Selected Cuisines";
  document.getElementById('cuisinesCaret').title="No Selected Cuisines";
 }
////
}


var minsV=""; // to store minimum order for delivery
var genresA=[]; // to store checked cuisines
var genresIndxA=[]; // to match indexes of cuisine box when user checks a cuisine
var genresFound=[];
var genresFoundLen=0;
var minsFound=[];
var minimumOptStr="";
var genreCBStr="";

function getRefineData(markerDataAOKBool){
// this fn displays only DB returned data for the lists used for Refining the Search 
		if(markerDataAOKBool){
				for(var i=0;i<markerDataALen;i++){
				 if(minsFound.indexOf(markerDataA[i].minimum) == -1){
				  minsFound.push(markerDataA[i].minimum);
				 }
				// alert(genresFound.indexOf(markerDataA[i].genre)+"  --  "+markerDataA[i].genre)
				 if(genresFound.indexOf(markerDataA[i].genre) == -1){
				 // add to found list to prevent duplicates in list
				  genresFound.push(markerDataA[i].genre);
				 }

				}
    
    genresFoundLen=genresFound.length;

				minsFound.sort(function(a, b){return a-b});
				genresFound.sort();

				for(var i=0;i<minsFound.length;i++){
 				 minimumOptStr+="<li><a href='#' onclick='minsV="+minsFound[i]+";document.getElementById(\"minimumDisp\").innerHTML=\"$"+minsFound[i]+"\";return false'>$"+minsFound[i]+"</a></li>";
				}

				for(var i=0;i<genresFoundLen;i++){
     // check all by default
				  genreCBStr+="<div class='CBs'><input id='genre"+i+"' type='checkbox' checked value='"+genresFound[i]+"' onclick='genreToggle("+i+",this.checked,this.value)' /> <label for='genre"+i+"'>"+genresFound[i]+"</label></div>";
				 // add index to genresIndxA because all genre checkboxes are checked initially
      genresIndxA.push(i);
				}
    
    
    document.getElementById('cuisinesSelected').innerHTML="("+genresFound.length+" Available Within "+radiusSelectV+kmMi+")";
    document.getElementById('cuisinesBtn').title="Available Cuisines: "+genresFound.join(" | ");
    document.getElementById('cuisinesCaret').title="Selected Cuisines: "+genresA.join(" | ");

				document.getElementById('minimum').innerHTML="<li><a href='#' onclick='minsV='';document.getElementById(\"minimumDisp\").innerHTML='(Not Applicable)';return false'>Not Applicable</a></li>"+minimumOptStr;
    document.getElementById('minimumDisp').innerHTML="None"


		}

}

// end of refinement list populating



// start refinement script

var originalLoadStr=""; // to save data to reload original results without going to DB
var originalpgParams=[];
var addPgsRefn=false;
var originalPagination;
var originalTopPagination;
var useRefined=false;

function refineSelection(){
var currResultNums=[]; // to store new array with refinement 1 (minimum)
var currResultNums2=[]; // to store new array with refinement 1 (genre)
var resultsDumpStr=""; // for demo output
 if(minsV != "" || genresA.length > 0){
  if(minsV!=""){
   // find matches for less than the one minimum value
   for(var i=0;i<markerDataA.length;i++){
	   if(parseFloat(markerDataA[i].minimum) <= parseFloat(minsV)){
	    currResultNums.push(i);
	   }
   }
  }

  if(genresA.length > 0){
		   if(currResultNums.length > 0){
				   for(var i=0;i<currResultNums.length;i++){
				    if(genresA.indexOf(markerDataA[currResultNums[i]].genre) != -1){
				     currResultNums2.push(currResultNums[i]);
				    }
				   }
			  }
			  else{
				   for(var i=0;i<markerDataALen;i++){
				    if(genresA.indexOf(markerDataA[i].genre) != -1){
         if(currResultNums2.indexOf(markerDataA[i].genre) == -1){
 				     currResultNums2.push(i);        
         }
				    }
				   }
			  }
  }
  

   if(currResultNums2.length > 0 || currResultNums.length > 0){
 
	   // save original pgParams array, originalTopPagination and originalPagination in case user wants to return to full results
	   originalpgParams=pgParams;
	   pgParams=[];
	   originalPagination=document.getElementById('pagination').innerHTML;
	   originalTopPagination=document.getElementById('topPagination').innerHTML;
    document.getElementById('pagination').innerHTML="";
    document.getElementById('topPagination').innerHTML="";
    useRefined=true;
    activepg=0;
   }
   
   if(currResultNums2.length > 0){
    document.getElementById('topPagination').innerHTML="";
    originalLoadStr=document.getElementById("list").innerHTML
    document.getElementById("list").innerHTML="";
    document.getElementById("topLinks").innerHTML="";
		  for(var i=0;i<currResultNums2.length;i++){
     resultsDumpStr+=markerDataA[currResultNums2[i]].name+"<br/>";
     if(i < perpg){
      createSideBox(true,currResultNums2[i],i);    
     }
     if(i > perpg){
     // show pagination navigation only if # markers > # per pg (otherwise, only 1 page needed)
      addPgsRefn=true;
     }
     else{
      addPgsRefn=false;
     }
     
     
      // save values for when user clicks next page in Refined search
      // latlng, array index, boxCnt
      pgParams[i]={latlng:markerDataA[currResultNums2[i]].latlng,arrayIndex:currResultNums2[i],boxCnt:markerSelected[currResultNums2[i]]};
     
		  }
     appendPgsStr(i);
  }
  else if(currResultNums.length > 0){
    document.getElementById('topPagination').innerHTML="";
    document.getElementById("list").innerHTML="";
    document.getElementById("topLinks").innerHTML="";
    originalLoadStr=document.getElementById("list").innerHTML
  // use an if statement here instead of just else in case we add other categories for refinement
		  for(var i=0;i<currResultNums.length;i++){
     resultsDumpStr+=markerDataA[currResultNums[i]].name+"<br/>";
     if(i < perpg){
      createSideBox(true,currResultNums[i],i);
     }

     if(i > perpg){
     // show pagination navigation only if # markers > # per pg (otherwise, only 1 page needed)
      addPgsRefn=true;
     }
     else{
      addPgsRefn=false;
     }
          
      // save values for when user clicks next page in Refined search
      // latlng, array index, boxCnt
      pgParams[i]={latlng:markerDataA[currResultNums[i]].latlng,arrayIndex:currResultNums[i],boxCnt:markerSelected[currResultNums2[i]]};
      
		  }
     appendPgsStr(i);
  }
  
  var resultsDumpHead="";
  if(minsV != ""){
   resultsDumpHead="&nbsp; <u>Minimum</u>: Less than $"+minsV+".";
  }
  if(genresA.length > 0){
   resultsDumpHead+="&nbsp; <u>Genres</u>: "+genresA.join(", ")+" &nbsp;";
  }
  document.getElementById('resultsOutput').innerHTML="<b>Test Display of Results of Your Refined Search: </b><br/><span style='color:#FF0000'>("+resultsDumpHead+")</span><br/>"+resultsDumpStr;
  
 }
 else{
  // script this so that if user makes a refinement, and then goes back to no refinement, that the original list loads
  
 }
////
}


window.onclick=function(){
 if(cuisineOpn && !mouseoverCuisines){
  showCuisines();
  mouseoverCuisines=false;
 }
}

</script>
        
                        </div>
                    </div>
                </div>
                
                
               <div class="col-md-9 col-sm-9 col-xs-8 col-md-offset-3" id="didueatmap" style="margin-top:1px;height: 600px;padding-left:2px;">
               
                    <div id="leftcol" style="width:99%;height:100%;overflow:scroll;padding-left:5px;padding-right:8px;z-index:100">
                    
                        <div id="nextBtn" align="center" style="margin:10px;width:90%;margin-left:auto;margin-right:auto;font-size:16px;line-height:18px">
                        <div id="numReturned" style="font-size:24px;color:red;visibility:hidden;font-weight:bold;padding-top:9px;z-index:100;margin-left:auto;margin-right:auto;"></div>
                   <div id="topLinks" style="display:inline-block;z-index:50"></div>
                        
                        <hr width="100%" align="center" /></div>
                        <div id="list" style="margin-bottom:25px"></div>
                    </div>
               </div>


<script type="text/javascript">


    <?php
    if(!isset($radiusSelect) || $radiusSelect == "") {
        $radiusSelect = 2;
    }
    ?>
    var radiusSelectV=<?php echo $radiusSelect; ?>;
  var radObj = document.getElementById('radiusSelect');
  for (var i = 0; i < radObj.length; i++) {
    if (radObj.options[i].value == radiusSelectV) {
      radObj.selectedIndex = i;
      break;
    }
  }


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