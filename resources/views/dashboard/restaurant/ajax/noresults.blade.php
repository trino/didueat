<?php
    printfile($SQL . "<BR>views/dashboard/restaurant/ajax/noresults.blade.php<BR>");
    $is_subscribed = false;
    if(read("email")){
        $is_subscribed = select_field("newsletter", "email", read("email"));
    }
    if(!$is_subscribed){
        ?>
            <DIV ID="subscribeform" class="input-group col-md-8 row">
                <p>We don't have any restaurants in your area at the moment.</p>
                <p>Subscribe with your email to receive a special gift when we launch in your town.</p>
            </DIV>
            <DIV ID="subscribeform" class="input-group col-md-8 row">
                <INPUT placeholder="Email" class="form-control" TYPE="TEXT" NAME="email" VALUE="{{ read("email") }}" ID="email">
                <span class="input-group-btn">
                    <button TYPE="BUTTON" VALUE="Subscribe" CLASS="btn btn-primary" ONCLICK="subscribe();">Subscribe</button>
                </span>
            </DIV>
<?php } ?>

<SCRIPT>
    //subscribe to the newsletter
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
