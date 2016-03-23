<?php
    printfile("views/orders/stripe.blade.php");
    // sample values to be added to Stripe form
    $invoiceCents=2600;
    $orderDesc="2 Sandwiches ($26.00)";
?>
<script
    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
    data-key="pk_test_fcMnnEwpoC2fUrTPpOayYUOf"
    data-amount="{{ $invoiceCents }}"
    data-name="DidUEat Demo"
    data-description="{{ $orderDesc }}"
    data-image="/128x128.png"
    data-locale="auto">
</script>