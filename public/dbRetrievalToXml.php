<?php

/*  This is the Successor document to dbresults_toxml2.php for the didueat implementation  */

require("db_didueatConn.php");

// Get parameters from URL
$center_lat = $_GET["latitude"];
$center_lng = $_GET["longitude"];
$radius = $_GET["radius"];
//$city = $_GET['city'];


// Start XML file, create parent node
$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);


// test:  http://myseriestv.com/didueat/dbresults_toxml2.php?radius=0.5&lat=43.256043&lng=-79.875969
// test:  localhost/didueat/public/dbRetrievalToXml.php?radius=5&lat=43.256043&lng=-79.875969

/*
id,name,slug,genre,email,phone,formatted_address,address,city,province,country,postal_code,lat,lng,description,logo,delivery_fee,minimum,open,status
*/

// Search the rows in the markers table
// Note: each %s represents one of the trailing arguments in the sprintf function in order (ie, $center_lat or $center_lng etc)
$query = sprintf("SELECT id,name,slug,genre,email,website,phone,formatted_address,postal_code, lat, lng, ( 3959 * acos( cos( radians('%s') ) * cos( radians( latitude ) ) * cos( radians( lng ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( longitude ) ) ) ) AS distance, description,logo,delivery_fee,minimum,rating from restaurants WHERE open=1 AND status=1 HAVING distance < '%s' ORDER BY distance LIMIT 0 , 20",
  $mysqli->real_escape_string($center_lat),
  $mysqli->real_escape_string($center_lng),
  $mysqli->real_escape_string($center_lat),
  $mysqli->real_escape_string($radius));


$result=mysqli_query($mysqli, $query);
if (!$result) {
  die("Invalid query: " . mysql_error());
}

header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each
while ($row = @mysqli_fetch_assoc($result)){
  $node = $dom->createElement("marker");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("id", $row['id']);
  $newnode->setAttribute("name", $row['name']);
  $newnode->setAttribute("slug", $row['slug']);
  $newnode->setAttribute("genre", $row['genre']);
  $newnode->setAttribute("email", $row['email']);
  $newnode->setAttribute("website", $row['website']);
  $newnode->setAttribute("phone", $row['phone']);
  $newnode->setAttribute("address", $row['formatted_address']);
  $newnode->setAttribute("postal_code", $row['postal_code']);
  $newnode->setAttribute("latitude", $row['latitude']);
  $newnode->setAttribute("longitude", $row['longitude']);
  $newnode->setAttribute("distance", $row['distance']);
  $newnode->setAttribute("description", $row['description']);
  $newnode->setAttribute("logo", $row['logo']);
  $newnode->setAttribute("delivery_fee", $row['delivery_fee']);
  $newnode->setAttribute("minimum", $row['minimum']);
  $newnode->setAttribute("rating", $row['rating']);
}

echo $dom->saveXML();
?>
