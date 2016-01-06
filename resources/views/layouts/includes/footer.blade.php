@if(false)
    <div class="clearfix"></div>
    <div class="footer">
        <?php printfile("views/dashboard/layouts/includes/footer.blade.php"); ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 col-md-offset-3">


                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div>
                                <h3 class="footer-h3"><i class="fa fa-search"></i> Pick A Restaurant</h3>
                                <em>Choose your preference</em>
                            </div>
                            <span>&nbsp;</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div>
                                <h3 class="footer-h3"><i class="fa fa-shopping-cart"></i> Order Online</h3>
                                <em>Get the best discount</em>
                            </div>
                            <span>&nbsp;</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div>
                                <h3 class="footer-h3"><i class="fa fa-spoon"></i> Enjoy Your Meal</h3>
                                <em>No setup fees, hidden costs, or contracts</em>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row">

                <!-- BEGIN COPYRIGHT -->
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 col-md-offset-3">
                    <p class="loadinfo"><?php
                        $end_loading_time = microtime(true);
                        printf("Page was generated in %f seconds", $end_loading_time - $start_loading_time);
                        echo "";
                        echo getOS();
                        echo " => ";
                        echo getUserBrowser();
                        ?></p>

                    <p class="copyrights">&copy;
                        <script language=javascript>var yr;
                            Today = new Date();
                            document.write(Today.getFullYear());</script>
                        didueat.ca / ALL Rights Reserved.
                    </p>


                </div>
                <!-- END COPYRIGHT -->
            </div>
        </div>
    </div>



@endif











<hr/>

<footer class=" p-y-1  container text-muted">
    <?php printfile("views/dashboard/layouts/includes/footer.blade.php"); ?>

    <div class="row">


        <div class="col-lg-4 ">
            <h3 class="footer-h3"><i class="fa fa-search"></i> Pick A Restaurant</h3>

            <p>Choose your preference</p>
        </div>
        <div class="col-lg-4 ">
            <h3 class="footer-h3"><i class="fa fa-shopping-cart"></i> Order Online</h3>

            <p>Get the best discount</p>
        </div>
        <div class="col-lg-4 ">
            <h3 class="footer-h3"><i class="fa fa-spoon"></i> Enjoy Your Meal</h3>

            <p>No setup fees, hidden costs, or contracts</p>
        </div>

        <div class="col-lg-12 ">
            <hr/>
        </div>
        <div class="col-lg-10 ">

            <ul class="list-inline">
                <li class="list-inline-item"><a href="#">About</a></li>
                <li class="list-inline-item"><a href="#">Email</a></li>
                <li class="list-inline-item"><a href="#">FAQ</a></li>
                <?php
                    if(!read("id")){
                        echo '<li class="list-inline-item"><a data-toggle="modal" data-target="#loginModal">Log In</a></li>';
                        echo '<li class="list-inline-item"><a data-toggle="modal" data-target="#signupModal">Sign Up</a></li>';
                    }
                ?>
                <li class="list-inline-item"><a href="{{ url("restaurants/signup") }}">Restaurant Owner</a></li>
                <li class="list-inline-item"><a href="#">Terms & Conditions</a></li>
            </ul>
        </div>
        <div class="col-lg-2" style="">
            <h5>

                <i class="fa fa-instagram pull-right"></i>
                <i class="fa fa-twitter pull-right"></i>
                <i class="fa fa-facebook pull-right"></i>

            </h5>

        </div>
        <div class="col-lg-12 " style="font-size: 90%;">

            <p>Designed and built with all the <i class="fa fa-heart"></i> in the world by <a
                        href="#"
                        target="_blank">trino</a>. Maintained by the <a
                        href="#">core team</a> with the help of <a
                        href="#">our contributors</a>.</p>

            <p>Currently v1.0 / &copy;
                <script language=javascript>var yr;
                    Today = new Date();
                    document.write(Today.getFullYear());</script>
                diduEAT / ALL Rights Reserved

                <?php
                $end_loading_time = microtime(true);
                printf(" Page generated in %f seconds. ", $end_loading_time - $start_loading_time);
                echo "";
                echo getOS();
                echo " => ";
                echo getUserBrowser();
                ?>


            </p>

        </div>
    </div>

</footer>


<div class="overlay_loader">
    <div class="clearfix"></div>
    <div id="loadmoreajaxloader">
        <img src="{{ asset('assets/images/ajax-loading.gif') }}"/>
    </div>
</div>


<div id="fancybox-rating-commentbox" style="display:none;">
    <div class="login-form popup-dialog" style="">
        <h1>Your Comment</h1>
        {!! Form::open(array('id'=>'rating-form','class'=>'form-horizontal form-without-legend','method'=>'post','role'=>'form')) !!}
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div id="message-error" class="alert alert-danger" style="display: none;"></div>
            <div id="message-success" class="alert alert-success" style="display: none;"></div>
            <div id="ratingContentArea">
                <div class="form-group">
                    <label>Comments: </label>
                    <textarea rows="6" id="ratingInput" class="form-control" maxlength="5000" required></textarea>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn red" id="ratingSaveBtn" value="Save"/>
                    <input type="hidden" id="rating_id" value=""/>
                    <input type="hidden" id="data-rating-id" value=""/>
                    <input type="hidden" id="data-target-id" value=""/>
                    <input type="hidden" id="data-type" value=""/>
                    <input type="hidden" id="ratingInputHidden" value=""/>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

<!-- END PRE-FOOTER -->

<script type="text/javascript">
    jQuery(document).ready(function () {
        Layout.init();
        Layout.initOWL();
        LayersliderInit.initLayerSlider();
        Layout.initImageZoom();
        Layout.initTouchspin();
        Layout.initTwitter();
    });

    $(document).ready(function () {
        $('body').on('click', '.update-rating', function () {
            $('#rating-form #ratingContentArea').show();
            var rating = $(this).val();
            var isAlreadyRated = $(this).attr('data-count-exist');
            var rating_id = $(this).attr('data-rating-id');
            var target_id = $(this).attr('data-target-id');
            var type = $(this).attr('data-type');

            if (isAlreadyRated > 0) {
                return alert('You already rated!');
            }

            $('#rating_id').val(rating);
            $('#rating-form #data-rating-id').val(rating_id);
            $('#rating-form #data-target-id').val(target_id);
            $('#rating-form #data-type').val(type);

            $('#rating-form #message-success').hide();
            $('#rating-form #message-error').hide();

            $.fancybox({
                'content': $('#fancybox-rating-commentbox').html(),
                'hideOnContentClick': true
            });
        });

        $('body').on('keyup', '#ratingInput', function () {
            var value = $(this).val();
            $('#rating-form #ratingInputHidden').val(value);
        });

        $('body').on('submit', '#rating-form', function (e) {
            var ratingbox = $('#rating-form #ratingInputHidden').val();
            var rating = $('#rating-form #rating_id').val();
            var rating_id = $('#rating-form #data-rating-id').val();
            var target_id = $('#rating-form #data-target-id').val();
            var type = $('#rating-form #data-type').val();

            $.post("{{ url('rating/save') }}", {
                rating: rating,
                rating_id: rating_id,
                target_id: target_id,
                comments: ratingbox,
                type: type,
                _token: "{{ csrf_token() }}"
            }, function (json) {
                if (json.type == "error") {
                    $('#rating-form #message-success').hide();
                    $('#rating-form #message-error').show();
                    $('#rating-form #message-error').text(json.response);
                } else {
                    $('#rating-form #message-error').hide();
                    $('#rating-form #message-success').show();
                    $('#rating-form #message-success').text(json.response);
                    $('#rating-form #ratingInput').val('');
                    $('#rating-form #ratingContentArea').hide();
                    //$.fancybox.close();
                    $('.' + target_id + rating_id + type).attr('data-count-exist', 1);
                }
            });
            e.preventDefault();
        });

        $('body').on('submit', '#subscribe-email', function (e) {
            var email = $('#subscribe-email input[name=email]').val();
            var token = $('#subscribe-email input[name=_token]').val();

            if ($.trim(email) == "" || email == null) {
                alert('Please type your email! thanks');
                $('#subscribe-email input[name=email]').focus();
                return false;
            }

            $.post("{{ url('newsletter/subscribe') }}", {email: email, _token: token}, function (jason) {
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

        $('body').on('submit', '#login-ajax-form', function (e) {
            var data = $('#login-ajax-form').serialize();
            var token = $('#login-ajax-form input[name=_token]').val();
            $('#invalid').hide();
            $.ajax({
                url: "{{ url('auth/login/ajax') }}",
                data: data, _token: token,
                type: "post",
                success: function (msg) {
                    if (isNaN(Number(msg))) {
                        if (checkUrl(msg)) {
                            window.location = msg;
                        } else {
                            $('#invalid').text(msg);
                            $('#invalid').fadeIn(500);
                        }
                    } else {
                        if ($('#login_type').val() == 'reservation') {
                            $.ajax({
                                url: "{{url('/user/json_data')}}",
                                type: "post",
                                data: "id=" + msg + '&_token={{csrf_token()}}',
                                dataType: "json",
                                success: function (arr) {
                                    $('#fullname').val(arr.name);
                                    $('#ordered_user_id').val(arr.user_id);
                                    $('#ordered_email').val(arr.email);
                                    $('#ordered_contact').val(arr.phone);
                                    $('#ordered_province').val(arr.province);
                                    $('#ordered_code').val(arr.postal_code);
                                    $('#ordered_street').val(arr.street);
                                    $('#ordered_city').val(arr.city);
                                    //$('.reservation_signin').hide();
                                    $('.fancybox-close').click();
                                    //only loads header
                                    $('#header-nav').load(document.URL + ' #header-nav>ul');
                                }
                            });
                        } else {
                            window.location = "{{ url('dashboard') }}";
                        }
                    }
                },
                failure: function (msg) {
                    $('#invalid').text("ERROR: " + msg);
                    $('#invalid').fadeIn(1000);
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
            <?php
                $fields = array("name", "email", "password", "confirm_password", "formatted_address", "address", "postal_code", "phone", "country", "province", "city", "apartment", "buzz");
                foreach( $fields as $field){
                    echo 'var ' . $field . ' = $("#register-form input[name=' . $field . ']").val();' . "\r\n";
                }
            ?>
            var subscribed = 0;
            if ($("#register-form input[name=subscribed]").is(':checked')) {
                subscribed = $("#register-form input[name=subscribed]").val();
            }

            $("#register-form #regButton").hide();
            $("#register-form #regLoader").show();
            $.post("{{ url('auth/register/ajax') }}", {
                _token: token,
                <?php
                    foreach( $fields as $field){
                        echo $field . ': ' . $field . ',' . "\r\n";
                    }
                ?>
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