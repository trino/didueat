<?php
    $isHTTP = strpos($_SERVER['SERVER_PROTOCOL'], "HTTP/") !== false;
    if($_SERVER["HTTP_HOST"] != "localhost"){$isHTTP = true;}
    if($isHTTP){$isHTTP = "http";} else {$isHTTP = "https";}
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $isHTTP . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]public/");
?>