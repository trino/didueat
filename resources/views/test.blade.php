<?php
    $now = time();
    $now = mktime (1, 0, 0, 2 , 22, 2016);
    $business_day = \App\Http\Models\Restaurants::getbusinessday(1, $now);
    echo "Testing: " . date('F d, Y - H:i (g:i A)', $now) . " = " . $business_day;

    echo "<BR>" . $_SERVER['HTTP_HOST'];
?>