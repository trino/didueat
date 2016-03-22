<?php
    printfile("views/emails/footer.blade.php<BR>");
    $alts = array(
        "login" => "Log in as an existing user"
    );
?>
<A HREF="https://didueat.ca/#login" title="{{ $alts["login"] }}">Click here to login</A>