<?php printfile($SQL . "<BR>views/dashboard/restaurant/ajax/noresults.blade.php"); ?>
<P>
Sorry, we've only launched in Hamilton.
<?php
    $is_subscribed = false;
    if(read("email")){
        $is_subscribed = select_field("newsletter", "email", read("email"));
    }
    if(!$is_subscribed){ ?>
            <DIV ID="subscribeform">
                Please subscribe to stay informed<BR>
                Email Address:
                <INPUT TYPE="TEXT" NAME="email" VALUE="{{ read("email") }}" ID="email">
                <INPUT TYPE="BUTTON" VALUE="Subscribe" CLASS="btn btn-primary" ONCLICK="subscribe();">
            </DIV>
<?php } ?>
<SCRIPT>
    function subscribe(){
        var token = "{{ csrf_token() }}";
        $.post("{{ url('/newsletter/subscribe') }}", {token: token, email: $("#email").val()}, function (result) {
            if(result.type == "success") {
                $("#subscribeform").hide();
            }
            alert(result.message);
        });
    }
</SCRIPT>
