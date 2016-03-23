<?php
    printfile("common/profile.php");
    $alts = array(
        "back" => "Go back",
        "checkout" => "Finish your order and send it to the restaurant"
    );
?>
<meta name="_token" class="csrftoken" content="{{ csrf_token() }}"/>
<script src="{{ url("assets/global/scripts/provinces.js") }}" type="text/javascript"></script>

<div class="form-group">
    <div class="col-xs-12">
        <h2 class="profile_delevery_type"></h2>
    </div>
</div>
<form id="profiles">
    <div class="form-group">
        <div class="col-xs-12 margin-bottom-10">
            <input type="text" name="ordered_by" id="fullname" placeholder="Name" class="form-control padding-margin-top-0" required="">
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-12 col-sm-6 margin-bottom-10">
            <input type="email" name="email" id="ordered_email" placeholder="Email" class="form-control" required="">
        </div>
        <div class="col-xs-12 col-sm-6">
            <input type="text" name="contact" id="ordered_contact" placeholder="Phone Number" class="form-control" required="">
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="form-group">
        <div class="col-xs-12">
            <input type="password" name="password" id="password" class="form-control" placeholder="Password" onkeyup="check_val(this.value);"/>
        </div>
        <div class="clearfix"></div>
    </div>
    <!--div class="form-group confirm_password" style="display: none;">
        <div class="col-xs-12">
            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password"/>
        </div>
        <div class="clearfix"></div>
    </div-->

    <div class="form-group">
        <div class="col-xs-12">
            <select class="form-control " name="order_till" id="ordered_on_time">
                <option value="ASAP">ASAP</option>
                <?php
                    for ($i = 30; $i < 570; $i = $i + 30) {
                        echo "<option value='" . date('M t, ', strtotime("+" . ($i - 30) . " minutes")) . date('h:i', strtotime("+" . ($i - 30) . " minutes")) . ' - ' . date('h:i', strtotime("+" . $i . " minutes")) . "'>" . date('M t, ', strtotime("+" . ($i - 30) . " minutes")) . date('h:i', strtotime("+" . ($i - 30) . " minutes")) . ' - ' . date('h:i', strtotime("+" . $i . " minutes")) . "</option>";
                    }
                ?>
            </select>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="profile_delivery_detail" style="display: none;">
        <div class="form-group margin-bottom-10">
            <div class="col-xs-12 col-sm-6  margin-bottom-10">
                <input type="text" placeholder="Address 2" class="form-control " name="address2"/>
            </div>
            <div class="col-xs-12 col-sm-6  margin-bottom-10">
                <input type="text" placeholder="City" class="form-control " name="city" id="city"/>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12 col-sm-6">
                <select class="form-control" name="province">
                    <OPTION>GET LIST OF PROVINCES</OPTION>
                </select>
            </div>
            <div class="col-xs-12 col-sm-6">
                <input type="text" placeholder="Postal Code" class="form-control " name="postal_code" id="postal_code"/>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-12">
            <textarea placeholder="Additional Notes" class="form-control " name="remarks"></textarea>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="form-group">
        <div class="col-xs-12">
            <a href="javascript:void(0)" class="btn btn-default back" title="<?= $alts["back"]; ?>">Back</a>
            <button type="submit" class="btn btn-primary" title="<?= $alts["checkout"]; ?>">Checkout</button>
        </div>
        <div class="clearfix"></div>
    </div>
</form>

<script>
    $(function () {
        function check_val(v) {
            if (v != '') {
                //$('.confirm_password').show();
                //$('#confirm_password').attr('required', 'required');
            }
        }

        function validatePassword() {
            if (password.value != confirm_password.value) {
                confirm_password.setCustomValidity("Passwords Don't Match");
            } else {
                confirm_password.setCustomValidity('');
                $('#confirm_password').removeAttr('required');
            }
        }

        /*
            var password = document.getElementById("password");, confirm_password = document.getElementById("confirm_password");
            password.onchange = validatePassword;
            confirm_password.onkeyup = validatePassword;
        */

        $('.back').live('click', function () {
            $('.receipt_main').show();
            $('.profiles').hide();
        });

        $('#profiles').submit(function (e) {
            e.preventDefault();
            var datas = $('#profiles input, select, textarea').serialize();
            var order_data = $('.receipt_main input').serialize();
            $.ajax({
                type: 'post',
                url: "{{ url('user/ajax_register') }}",
                data: datas + '&' + order_data,
                success: function (msg) {
                    if (msg == '0') {
                        $('.top-cart-content ').html('<span class="thankyou">Thank You.</span>');
                    } else if (msg == '1') {
                        alert('Email Already Registred.');
                    }
                }
            })
        });

    });
</script>