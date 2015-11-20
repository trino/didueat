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
      $thiscity=$details->city;
      $thisregion=$details->region;
      $thispostal=$details->postal;
      
      $thisLoc=$details->loc;
      $geoLocSpl=explode(",",$thisLoc);
      $thisLat=$geoLocSpl[0];
      $thisLng=$geoLocSpl[1];
      
      $userAddress =  $thiscity.", ".$thisregion." ".$thispostal;
      $autoSrch=true;
     }
     else{
 			  $userAddress = "Hamilton, ON";
     }
			 }
    
    if(!isset($radiusSelect)){
     $radiusSelect=10;
    }

?>

@extends('layouts.default')
@section('content')

<?php

 print("<script>var thisCity,thisState,thisPostal,thisCountry;\nvar userAddress=\"".$userAddress."\";\nvar strtZoom=".$startZoom.";\nvar autoSrch=".$autoSrch.";\nvar thisLat=\"".$thisLat."\";\nvar thisLng=\"".$thisLng."\";</script>");

?>


    <script>
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


function loadPg(pgNum,prevNext){
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
  document.getElementById('numReturned').innerHTML=numMarkers+" Matches, Page "+(parseInt(newpgNum)+1)+" of &nbsp;"+numpgs;
 }

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
		 createSideBox(pgParams[i].arrayIndex,pgParams[i].boxCnt);
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
   pgsStr+="<a HREF='#' onclick='loadPg(false,\"prev\");return false' id='prevpag' style='visibility:hidden;padding-left:10px;padding-right:15px'>Prev</a>&nbsp; ";
   
   pgsStrTop+="<a HREF='#' onclick='loadPg(false,\"prev\");return false' id='prevpagTop' style='visibility:hidden;padding-left:10px;padding-right:15px'>Prev</a>&nbsp; ";
  }
  
  if(activepg == i){
   bgcolorHilight=";background:#d3d3d3";
  }
  else{
   bgcolorHilight="";
  }
  
  pgsStr+=" <a HREF='#' onclick='loadPg("+i+",false);return false' id='pg"+i+"' style='padding:10px;font-weight:bold;font-size:14px;line-height:14px;height:15px"+bgcolorHilight+"'>"+(i+1)+"</a>&nbsp; ";
  
  pgsStrTop+=" <a HREF='#' onclick='loadPg("+i+",false);return false' id='pgTop"+i+"' style='padding:10px;font-weight:bold;font-size:14px;line-height:14px;height:15px"+bgcolorHilight+"'>"+(i+1)+"</a>&nbsp; ";

  if(i == (numpgs-1) && numpgs > 2){
  
   nxtPgNum=(activepg+1);
   pgsStr+="<a HREF='#' onclick='loadPg(false,\"next\");return false' id='nextpag' style='padding-left:10px'>Next</a>";
   pgsStrTop+="<a HREF='#' onclick='loadPg(false,\"next\");return false' id='nextpagTop' style='padding-left:10px'>Next</a>";
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

 
 
////
}


markerDataA=[];
markerSelected=[];
polygons=[];
pgParams=[]; // for pagination
var perpg=3;
var numpgs;
var numMarkers;

function addressChngd(){
if(confirm("Not implemented yet. Do you want to go back to home page to perform search?")){
 window.location="{{ url('') }}";
}

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

     var radius = document.getElementById('radiusSelect').value;
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
       document.getElementById('numReturned').innerHTML=numMarkers+" Match"+es+pgMsg;
       document.getElementById('numReturned').style.visibility="visible";
//		     document.getElementById('leftcol').style.display="block";
       
            
       var bounds = new google.maps.LatLngBounds();
       
       for (var i = 0; i < numMarkers; i++) {
// id,name,slug,email,website,phone,address,postal_code,lat,lng,distance,description,logo,delivery_fee,minimum,rating
         var id = markerNodes[i].getAttribute("id");
         var name = markerNodes[i].getAttribute("name");
         var slug = markerNodes[i].getAttribute("slug");
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
         var latlng = new google.maps.LatLng(
              parseFloat(markerNodes[i].getAttribute("lat")),
              parseFloat(markerNodes[i].getAttribute("lng")));
         var distance = parseFloat(markerNodes[i].getAttribute("distance")).toFixed(2)+" "+kmMi;
         var description = markerNodes[i].getAttribute("description");
         var logo = markerNodes[i].getAttribute("logo");
         var delivery_fee = parseFloat(markerNodes[i].getAttribute("delivery_fee")).toFixed(2);
         var minimum = markerNodes[i].getAttribute("minimum");
         var rating = markerNodes[i].getAttribute("rating");
         
         var thisData = {id:id, name,slug:slug, email:email, website:website, phone:phone, address:address, postal_code:postal_code, distance:distance, description:description, logo:logo, delivery_fee:delivery_fee, minimum:minimum, rating:rating};
         
         markerDataA[i]=thisData;
         markerSelected[i]=false;
        
         
         if(i < perpg){
         // to paginate results
	         createSideBox(i,boxCnt);
         }
         
         if(numMarkers > perpg){
         // show pagination navigation only if # markers > # per pg (otherwise, only 1 page needed)
          addPgs=true;
         }

        // save values for when user clicks next page
        // latlng, array index, boxCnt
        pgParams[i]={latlng:latlng,arrayIndex:i,boxCnt:boxCnt};
         
       }
              
       if(addPgs){
        appendPgsStr(numMarkers);
       }
       
       }
       else{
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
// the number for boxCnt is saved with the markers in the markerSelected array


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

    function showInfo(indx,b){
     var divSt="";
     var divEnd="";
     var msg="";
     var btnFnCall="sendData";
     var btnTxt="Read This Menu";
     var secondParam=boxCnt;
     var btnColor="#000";
     var btnFW="normal";
     if(markerSelected[indx]){
      divSt="<div style='border:solid #ff0000 2px;padding:4px'>";
      divEnd="</div>";
      msg="<span style='color:#f00;font-size:11px'>&nbsp;(Already in Your List)</span>";
      btnFnCall="deleteFromMyList";
      btnTxt="Delete From Your List";
      secondParam=markerSelected[indx];
      btnColor="#f00";
      btnFW="bold";
     }

// id,name,slug,email,website,phone,address,postal_code,lat,lng,distance,description,logo,delivery_fee,minimum,rating

     if(markerDataA[indx].rating){
      var ratingImgNum=(Math.round(markerDataA[indx].rating * 2) / 2).toFixed(1);
     }
     else{
      var ratingImgNum=0;
     }
     
     var infoWinBtn="<br/><input name='btn"+indx+"' id='btn"+indx+"' type='button' value='"+btnTxt+"' style='color:"+btnColor+";font-weight:"+btnFW+"' onclick='"+btnFnCall+"("+indx+","+secondParam+")' />"+msg;
     
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
      thisWebsite="<br/><a href='http://"+markerDataA[indx].website+"' title='"+thisTitle+"'>"+websiteStr+thisElip+"</a>";
     }
     
     var thisInfo = divSt+"<b>" + markerDataA[indx].name + "&nbsp; <img src='assets/images/rating"+ratingImgNum+".gif' title='Rating: "+markerDataA[indx].rating+"' border='0' class='ratingImg' />&nbsp; <div style='display:inline-block;color:#FF0000'>(Delivery: $"+markerDataA[indx].delivery_fee+")</div></b> <span id='xtra"+indx+"' style='display:none'>Duncan</span> <br/>" + markerDataA[indx].address+"<br/>"+markerDataA[indx].phone+" &nbsp;"+thisEmail+thisWebsite+infoWinBtn+divEnd;

     if(b){
      boxCnt++;
     }
     return thisInfo;
    ////
    }



var keepOpn=false;

function createSideBox(indx,bxId){
  
  var para = document.createElement("P");
  para.innerHTML=showInfo(indx,true); 
  para.setAttribute("class","results");
  para.setAttribute("id","loc"+bxId);
  
  var hrTag = document.createElement("HR");
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


               <div class="col-md-4 col-sm-4 col-xs-4 top-cart-block">
    
<div id="leftcol" style="width:99%;height:100%;overflow:scroll;padding-left:5px;padding-right:8px;z-index:100">

     <div id="nextBtn" align="center" style="margin:10px;width:90%;margin-left:auto;margin-right:auto;font-size:16px;line-height:18px">
<!--      
     <b>When finished selecting spots,<br/>Go to Checkout</b><br/>
     <form name="reservations" id="reservations" method="post" action="checkout.php">
     <input name="checkout" style="margin-top:6px" type="button" value='Go To Checkout' onclick="sendDataFwd()" /><input name="submit" type="submit" value='1' style="position:absolute;left:-1000px;width:2px;height:2px" />
     </form> 
-->
<div id="numReturned" style="color:red;visibility:hidden;font-weight:bold;padding-top:3px;z-index:100;margin-left:auto;margin-right:auto;">  </div>
				<div id="topLinks" style="z-index:50"></div>

				     <hr width="100%" align="center" /></div>
				     
				     <div id="list"></div>
				    
				</div>

</div>
                
                
               <div class="col-md-8 col-sm-8 col-xs-8 col-md-offset-4" id="didueatmap" style="margin-top:1px;height: 600px;padding-left:2px;">
                

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