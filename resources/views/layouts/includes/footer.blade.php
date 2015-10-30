
<!-- BEGIN STEPS -->
<div class="steps-block steps-block-red" style="color:#FFF;background:#df4500;padding:25px 0; clear: both;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-1"></div>
            <div class=" col-md-10 col-sm-12 col-xs-12">

                <div class="col-md-4 col-sm-12 col-xs-11 steps-block-col">
                    <i class="fa fa-search"></i>
                    <div>
                        <h3>Pick A Restaurant</h3>
                        <em>Choose your preference</em>
                    </div>
                    <span>&nbsp;</span>
                </div>

                <div class="col-md-4 col-sm-12 col-xs-11 steps-block-col">
                    <i class="fa fa-shopping-cart"></i>
                    <div>
                        <h3>Order Online</h3>
                        <em>Get the best discount</em>
                    </div>
                    <span>&nbsp;</span>
                </div>

                <div class="col-md-4 col-sm-12 col-xs-11 steps-block-col">
                    <i class="fa fa-spoon"></i>
                    <div>
                        <h3>Enjoy Your Meal</h3>
                        <em>No setup fees, hidden costs, or contracts</em>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</div>
<!-- END STEPS -->

<!-- BEGIN PRE-FOOTER -->
<div class="pre-footer" style="color: #a0a0a0;">
    <div class="container-fluid">
        <div class="row">
            <!-- END BOTTOM ABOUT BLOCK -->
            <!-- BEGIN BOTTOM INFO BLOCK -->
            <div class="col-md-3 col-sm-6 pre-footer-col">
                <h2 class="margin-bottom-15">Information</h2>
                <ul class="list-unstyled">
                    <li><i class="fa fa-angle-right"></i> <a href="#">Delivery Information</a></li>
                    <li><i class="fa fa-angle-right"></i> <a href="#">Customer Service</a></li>
                    <li><i class="fa fa-angle-right"></i> <a href="/Foodie/pages/disclaimers">Disclaimers</a></li>
                </ul>
            </div>
            <!-- END INFO BLOCK -->

            <!-- BEGIN TWITTER BLOCK -->
            <div class="col-md-3 col-sm-6 pre-footer-col">
                <h2 class="margin-bottom-15">Latest Tweets</h2>
                <a class="twitter-timeline" href="https://twitter.com/twitterapi" data-tweet-limit="2" data-theme="dark" data-link-color="#57C8EB" data-widget-id="455411516829736961" data-chrome="noheader nofooter noscrollbar noborders transparent">Loading tweets by @keenthemes ...</a>
            </div>
            <!-- END TWITTER BLOCK -->

            <div class="col-md-4 col-sm-12 pre-footer-col">
                <h2 class="margin-bottom-15">Share your Experience</h2>
                <p>Leave comments or describe your experience using the DidUEat.ca website, how well your meal was and interaction with restarurants.</p>
                <form class="form">
                    <fieldset>
                        <div class="form-group margin-bottom-10">
                            <label class="col-lg-12 col-sm-12 control-label col-xs-12 no-padding margin-bottom-10" for="Message">Message <span class="require">*</span></label>
                            <div class="col-lg-12 col-sm-12 col-xs-12 no-padding">
                                <textarea style="height:150px" name="Message" class="form-control margin-bottom-10"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="pull-right">
                                <input class="btn red" type="submit" value="Submit"/>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>

            <div class="col-md-2 col-sm-6 pre-footer-col">
                <h2 class="margin-bottom-15">Cities</h2>
                <ul class="list-unstyled">
                    <li>Hamilton Delivery</li>
                </ul>
            </div>
        </div>
        <hr>
        <div class="row">
            <!-- BEGIN SOCIAL ICONS -->
            <div class="col-md-6 col-sm-6">
                <ul class="social-icons">
                    <li><a class="rss" data-original-title="rss" href="#"></a></li>
                </ul>
            </div>
            <!-- END SOCIAL ICONS -->
            <!-- BEGIN NEWLETTER -->
            <div class="col-md-6 col-sm-6">
                <div class="pre-footer-subscribe-box pull-right">
                    <h2>Newsletter</h2>
                    {!! Form::open(array('url' => '/newsleter/subscribe', 'id'=>'subscribe-email','class'=>'','method'=>'post','role'=>'form')) !!}
                        <input type="hidden" name="action" value="subscribe">

                        <div class="input-group">
                            <input type="text" name="email" placeholder="youremail@mail.com" class="form-control">
                            <span class="input-group-btn">
                                <button class="btn red" type="submit">Subscribe</button>
                            </span>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <!-- END NEWLETTER -->
        </div>
    </div>



    <script type="text/javascript">
        jQuery(document).ready(function () {
            Layout.init();
            Layout.initOWL();
            LayersliderInit.initLayerSlider();
            Layout.initImageZoom();
            Layout.initTouchspin();
            Layout.initTwitter();
        });

        $(document).ready(function(){
            $('body').on('submit', '#subscribe-email', function(e){
                var email = $('#subscribe-email input[name=email]').val();
                var token = $('#subscribe-email input[name=_token]').val();

                if($.trim(email) == "" || email == null){
                    alert('Please type your email! thanks');
                    $('#subscribe-email input[name=email]').focus();
                    return false;
                }

                $.post("{{ url('newsletter/subscribe') }}", {email:email, _token:token}, function(jason){
                    //var jason = $.parseJSON(result);
                    if (jason.type == "error") {
                        alert(jason.message);
                        $('#subscribe-email input[name=email]').focus();
                    } else {
                        $('#subscribe-email input[name=email]').val('');
                        alert(jason.message);
                    }
                });
                e.preventDefault();
            });
        });

        $(function () {
            var wd = $(window).width();
            var ht = $(window).height();

            var headr_ht = $('.container-fluid').height();
            var htt = Number(ht) - Number(headr_ht);
            $('.top-cart-block').css({'height': htt});

            if (wd <= '767') {
                $('.top-cart-info').show();
                $('.header-navigation-wrap').hide();
                $('.new_headernav').show();
                $('#cartsz').hide();
            } else {
                $('.header-navigation-wrap').show();
                $('.top-cart-info').hide();
                $('.new_headernav').hide();
                $('#cartsz').show();
            }

            $(window).resize(function () {
                var wd = $(window).width();
                if (wd <= '767') {
                    $('.top-cart-info').show();
                    $('.header-navigation-wrap').hide();
                    $('.new_headernav').show();
                    $('#cartsz').hide();
                } else {
                    $('.header-navigation-wrap').show();
                    $('.top-cart-info').hide();
                    $('.new_headernav').hide();
                    $('#cartsz').show();
                }
            });

            $('body').on('submit', '#searchMenuForm', function (e) {
                var term = $('#searchMenuForm input[name=search_term]').val();
                if (term.trim() != "") {
                    window.location.href = "{{ url('/search/menus') }}/" + term;
                }
                e.preventDefault();
            });

            $('body').on('submit', '#searchRestaurantForm', function (e) {
                var term = $('#searchRestaurantForm input[name=search_term]').val();
                if (term.trim() != "") {
                    window.location.href = "{{ url('/search/restaurants') }}/" + term;
                }
                e.preventDefault();
            });

            $('body').on('submit', '#searchMenuForm2', function (e) {
                var term = $('#searchMenuForm2 input[name=search_term]').val();
                if (term.trim() != "") {
                    window.location.href = "{{ url('/search/menus') }}/" + term;
                }
                e.preventDefault();
            });

            $('body').on('submit', '#searchRestaurantForm2', function (e) {
                var term = $('#searchRestaurantForm2 input[name=search_term]').val();
                if (term.trim() != "") {
                    window.location.href = "{{ url('/search/restaurants') }}/" + term;
                }
                e.preventDefault();
            });
        });

        function getvalue(ElementID) {
            return document.getElementById(ElementID).value;
        }

        function setvalue(ElementID, Value) {
            document.getElementById(ElementID).innerHTML = Value;
        }

        function escapechars(text) {
            return text.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
        }

        $('body').on('submit', '#forgot-pass-form', function (e) {
            var token = $("#forgot-pass-form input[name=_token]").val();
            var email = $("#forgot-pass-form input[name=email]").val();

            $("#forgot-pass-form #regButton").hide();
            $("#forgot-pass-form #regLoader").show();
            $.post("{{ url('auth/forgot-passoword/ajax') }}", {_token: token, email: email}, function (result) {
                $("#forgot-pass-form #regButton").show();
                $("#forgot-pass-form #regLoader").hide();

                var json = jQuery.parseJSON(result);
                if (json.type == "error") {
                    $('#forgot-pass-form #error').show();
                    $('#forgot-pass-form #error').html(json.message);
                } else {
                    $('#forgot-pass-form').hide();
                    $('#forgot-pass-success').show();
                    $('#forgot-pass-success p').html(json.message);
                }
            });
            e.preventDefault();
        });

        $('body').on('submit', '#login-ajax-form', function(e){
            var data = $('#login-ajax-form').serialize();
            $.ajax({
                url: "{{ url('auth/login/ajax') }}",
                data: data,
                type: "post",
                success: function (msg) {

                    if (isNaN(Number(msg))) {
                        if (checkUrl(msg)) {
                            window.location = msg;
                        } else {
                            $('#invalid').text(msg);
                            $('#invalid').show();
                        }
                    }
                    else {
                        if ($('#login_type').val() == 'reservation') {

                            $.ajax({
                                url: "{{url('/user/json_data')}}",
                                type: "post",
                                data: "id=" + msg + '&_token={{csrf_token()}}',
                                dataType: "json",
                                success: function (arr) {
                                    $('#fullname').val(arr.name);
                                    $('#ordered_email').val(arr.email);
                                    $('#ordered_contact').val(arr.phone);
                                    $('#ordered_province').val(arr.province);
                                    $('#ordered_street').val(arr.street);
                                    $('#ordered_city').val(arr.city);
                                    $('#ordered_code').val(arr.postal_code);
                                    $('.reservation_signin').hide();
                                    $('.fancybox-close').click();
                                    //only loads header
                                    $('#header-nav').load(document.URL +  ' #header-nav>div:first-child');

                                }
                            });
                        }
                        else
                            window.location = "{{ url('dashboard') }}";
                    }
                },
                failure: function (msg) {
                    setvalue("message", "ERROR: " + msg);
                }
            });
            e.preventDefault();
        });

        $('body').on('click', '#resendMeEmail', function (e) {
            var url = $(this).attr('href');
            $('#registration-success p').html('Please wait email is being send...');
            $.get(url, {}, function (result) {
                var json = jQuery.parseJSON(result);
                $('#registration-success p').html(json.message);
            });
            e.preventDefault();
        });

        $('body').on('submit', '#register-form', function (e) {
            var token = $("#register-form input[name=_token]").val();
            var Name = $("#register-form input[name=name]").val();
            var Email = $("#register-form input[name=email]").val();
            //var address = $("#register-form input[name=address]").val();
            //var post_code = $("#register-form input[name=post_code]").val();
            //var city = $("#register-form input[name=city]").val();
            var phone_no = $("#register-form input[name=phone_no]").val();
            //var province = $("#register-form input[name=province]").val();
            //var country = $("#register-form select[name=country]").val();
            var password = $("#register-form input[name=password]").val();
            var confirm_password = $("#register-form input[name=confirm_password]").val();
            var subscribed = 0;
            if($("#register-form input[name=subscribed]").is(':checked')){
                subscribed = $("#register-form input[name=subscribed]").val();
            }

            $("#register-form #regButton").hide();
            $("#register-form #regLoader").show();
            $.post("{{ url('auth/register/ajax') }}", {
                _token: token,
                name: Name,
                email: Email,
                //address: address,
                //post_code: post_code,
                //city: city,
                phone_no: phone_no,
                //province: province,
                //country: country,
                password: password,
                confirm_password: confirm_password,
                subscribed: subscribed
            }, function (result) {
                $("#register-form #regButton").show();
                $("#register-form #regLoader").hide();

                var json = jQuery.parseJSON(result);
                if (json.type == "error") {
                    $('#register-form #registration-error').show();
                    $('#register-form #registration-error').html(json.message);
                } else {
                    $('#register-form').hide();
                    $('#registration-success').show();
                    $('#registration-success p').html(json.message);
                }
            });
            e.preventDefault();
        });


        function ValidURL(textval) {
            var urlregex = new RegExp(
                    "^(http|https|ftp)\://([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&amp;%\$\-]+)*@)*((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(\:[0-9]+)*(/($|[a-zA-Z0-9\.\,\?\'\\\+&amp;%\$#\=~_\-]+))*$");
            return urlregex.test(textval);
        }

        function checkUrl(textval) {
            if (textval.replace('/dashboard', '') != textval)
                return true;
            else
                return false;
        }

        //loadmore
        $(function () {
            $('.loadmore').click(function () {
                $('div#loadmoreajaxloader').show();
                ur = $('.next a').attr('href');
                if (ur != '') {
                    url1 = ur.replace('/?', '?');
                    $.ajax({
                        url: url1,
                        success: function (html) {

                            if (html) {
                                $('.nxtpage').remove();
                                $("#postswrapper").append(html);
                                $('div#loadmoreajaxloader').hide();
                            } else
                                $('div#loadmoreajaxloader').html('<center>No more menus to show.</center>');
                        }
                    });
                }
                else {
                    $('div#loadmoreajaxloader').html('<center>No more menus to show.</center>');
                    $(this).parent().remove();
                }
            });

        });
    </script>

    <!-- BEGIN FOOTER -->
    <div class="footer">
        <div class="container-fluid">
            <div class="row">
                <!-- BEGIN COPYRIGHT -->
                <div class="col-md-4 col-sm-4 padding-top-10">
                    2015 &copy; didueat.ca / ALL Rights Reserved.
                </div>
                <div class="col-md-4 col-sm-4 padding-top-10" align="center">
                    <?php
                        $end_loading_time = microtime(true);
                        printf("Page was generated in %f seconds", $end_loading_time - $start_loading_time);
                    ?>
                </div>
                <!-- END COPYRIGHT -->
                <!-- BEGIN PAYMENTS -->
                <div class="col-md-4 col-sm-4">

                </div>
                <!-- END PAYMENTS -->
            </div>
        </div>
    </div>
    <!-- END FOOTER -->

</div>


<div class="overlay_loader">
    <div class="clearfix"></div>
    <div id="loadmoreajaxloader">
        <img src="{{ asset('assets/images/ajax-loading.gif') }}">
    </div>
</div>

<!-- END PRE-FOOTER -->
