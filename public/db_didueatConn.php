<?php

 $dbname="didueat";
 $mysqli = new mysqli('localhost', 'root', '', $dbname);

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}

function check_input($value){
 // Stripslashes
  if (get_magic_quotes_gpc()) {
   $value = stripslashes($value);
  }
 // Quote if not a number
  if (!is_numeric($value)) {
   $value = "'" . mysql_real_escape_string($value) . "'";
  }
 return $value;
 }

?>