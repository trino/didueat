<?php
    //stop making duplicate files!!!
    printfile("views/dashboard/creditcards/ajax/edit.blade.php");
    echo "<BR>" . view('common.edit_credit_card', array("restaurants_list" => $restaurants_list, "credit_cards_list" => $credit_cards_list));
?>