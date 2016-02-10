<div class="container-fluid text-muted p-y-2 m-t-2" style="background:white;
    border-top: 1px solid #e5e5e5;
    border-bottom: 1px solid #e5e5e5;
">

    <!--div class="container  p-y-2">
        <div class="row ">
            <div class="col-lg-12 title-v2 p-b-1">
                <h2 class="text-xs-center side-lines"> HOW IT WORKS </h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 ">
                <h3 class="text-xs-center "><i class="fa fa-search bg-secondary"></i> Enter Your Location</h3>

                <p class="text-xs-center">We'll list all the deals in your area</p>
            </div>
            <div class="col-lg-4 ">
                <h3 class="footer-h3 text-xs-center"><i class="fa fa-shopping-cart "></i> Pick A Deal</h3>

                <p class="text-xs-center">What do you feel like eating?</p>
            </div>
            <div class="col-lg-4 ">
                <h3 class="footer-h3 text-xs-center "><i class="fa fa-cutlery  "></i> Order Online</h3>

                <p class="text-xs-center">Receive your meal in under 45 mins</p>
            </div>
        </div>
    </div-->

    <footer class=" p-t-2  container text-muted">
        <?php printfile("views/dashboard/layouts/includes/footer.blade.php"); ?>
        <div class="row">
            <div class="col-lg-10 ">
                <ul class="list-inline">
                    <li class="list-inline-item"><a href="{{ url("home/about") }}">About</a></li>
                    <li class="list-inline-item"><a href="mailto:info@didueat.ca?subject=Contact%20Me%20Regarding%20diduEAT&body=
Message:
%0A%0A
%0A%0A
%0A%0A
%0A%0A
%0A%0A
Name:
%3A%0A%0A
Contact Number:
%3A%0A%0A
Thank you">Email Us</a></li>








                    <li class="list-inline-item"><a href="{{ url("home/faq") }}">FAQ</a></li>
                    <?php
                    if (!read("id")) {
                        echo '<li class="list-inline-item"><a href="#" data-toggle="modal" data-target="#loginModal">Log In</a></li>';
                        echo '<li class="list-inline-item"><a href="#" data-toggle="modal" data-target="#signupModal">Sign Up</a></li>';
                    }

                    if (Session::get('session_type_user') == "restaurant") {
                        $ownerSignup = "Owner Admin";
                    } else {
                        $ownerSignup = "Signup";
                    }
                    ?>
                    <li class="list-inline-item"><a
                                href="{{ url("restaurants/signup") }}">Restaurant {{ $ownerSignup }}</a></li>

                    <li class="list-inline-item"> <a href="{{ url("home/terms") }}">Terms & Conditions</a></li>






                </ul>
            </div>
            <div class="col-lg-2" style="">
                <h4>
                    <A href="https://www.instagram.com/didueat/" target="_blank"><i
                                class="fa fa-instagram pull-right"></i></A>
                    <A href="https://mobile.twitter.com/didueatcanada" target="_blank"><i
                                class="fa fa-twitter pull-right"></i></A>
                    <A href="https://www.facebook.com/didueatcanada/" target="_blank"><i
                                class="fa fa-facebook pull-right"></i></A>
                </h4>
            </div>
            <div class="col-lg-12 " style="font-size: 90%;">
                <p>
                    Designed and built with all the <i class="fa fa-heart" style="color:#d9534f!important"></i> in the
                    world by
                    <a href="http://trinoweb.com/" target="_blank">
                        <B>
                            <SPAN style="color:green;">TRIN<i class="fa fa-globe"></i></SPAN><SPAN style="color:black;">WEB</SPAN>
                        </B>
                    </a>
                    <!-- and maintained by the <a href="{{ url("home/team") }}">core team</a> -->
                </p>

                <p>
                    Currently v1.0 / &copy;
                    <script language=javascript>
                        var yr;
                        Today = new Date();
                        document.write(Today.getFullYear());
                    </script>
                    diduEAT / ALL Rights Reserved
                    @if(Session::get('session_type_user') == "super")
                        <?php
                        $end_loading_time = microtime(true);
                        printf("/ Page generated in %f seconds. ", $end_loading_time - $start_loading_time);
                        echo "";
                        echo getOS();
                        echo " => ";
                        echo getUserBrowser();
                        ?>
                    @endif

</p>

            </div>
        </div>
    </footer>
</div>

<div class="overlay_loader">
    <div class="clearfix"></div>
    <div id="loadmoreajaxloader">
        <img src="{{ asset('assets/images/ajax-loading.gif') }}"/>
    </div>
</div>


@include('popups.rating')

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
        $('body').on('click', '.reviews_detail', function () {
            var rating_id = $(this).attr('data-rating-id');
            var type = $(this).attr('data-type');
            var dataname = $(this).attr('data-item-name');
            var detail = $(this).attr('data-reviews-detail');
            var target_id = $(this).attr('data-target-id');

            $("#ratingModal #ratingModalLabel").text(dataname);
            $("#ratingModal #reviews").text(detail);
            $("#ratingModal #modal_contents").show();
            
            $.post("{{ url('reviews/users/get') }}", {rating_id: rating_id, type: type, target_id: target_id}, function (result) {
                if(result){
                    $("#ratingModal #modal_contents").html(result);
                } else {
                    $("#ratingModal #modal_contents").hide();
                }
            });
        });

        $('body').on('click', '.rating-it-btn', function () {
            var isAlreadyRated = $(this).attr('data-count-exist');
            var rating_id = $(this).attr('data-rating-id');
            var target_id = $(this).attr('data-target-id');
            var type = $(this).attr('data-type');
            
            $('#ratingModal').modal('show');
            $("#ratingModal #message-error").hide();
            $("#ratingModal #message-success").hide();
            $("#ratingModal .rating input").attr("checked", false);
            $("#ratingModal #ratingInput").val('');

            if (isAlreadyRated > 0) {
                $('#ratingModal #rating-form').hide();
            } else {
                $('#ratingModal #rating-form').show();
            }

            $('#rating-form #data-rating-id').val(rating_id);
            $('#rating-form #data-target-id').val(target_id);
            $('#rating-form #data-type').val(type);
        });

        $('body').on('keyup', '#ratingInput', function () {
            var value = $(this).val();
            $('#rating-form #ratingInputHidden').val(value);
        });

        $('body').on('click', '.update-rating', function () {
            var value = $(this).val();
            $('#rating-form #rating_id').val(value);
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

                    setTimeout(function () {
                        $('#ratingModal').modal('hide');
                        $('#parent' + target_id + ' .static-rating .rating-it-btn').attr('data-count-exist', 1);
                        $.each($('#parent' + target_id + ' .static-rating input[value="' + rating + '"]'), function (index, value) {
                            $(this).addClass("checked-stars");
                            $(this).attr("checked", true);
                        });
                        $('#restaurant_rating .static-rating .rating-it-btn').attr('data-count-exist', 1);
                        $.each($('#restaurant_rating .static-rating input[value="' + rating + '"]'), function (index, value) {
                            $(this).addClass("checked-stars");
                            $(this).attr("checked", true);
                        });

                        var reviews = $("#reviewcount" + target_id).html();
                        reviews = Number(reviews.replace(/\D/g,''));
                        $("#reviewcount" + target_id).html("Reviews (" + (reviews+1) + ")");
                    }, 500);
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
            $("#forgot-pass-form #lostPWregButton").hide();
            $("#forgot-pass-form #regLoader").show();
            $.post("{{ url('auth/forgot-password/ajax') }}", {_token: token, email: email}, function (result) {
                $("#forgot-pass-form #lostPWregButton").show();
                $("#forgot-pass-form #regLoader").hide();
                
                var json = jQuery.parseJSON(result);
                if (json.type == "error") {
                    alert(json.message);
//                    $('#forgot-pass-form #error').show();
//                    $('#forgot-pass-form #error').html(json.message);
                } else {
                    $('#forgot-pass-form').hide();
                    $('#forgot-pass-success').show();
                    $('#closeBtn').show();
                    $('#lostPWregButton').hide();
                    $('#forgot-pass-success p').html(json.message);
                }
                    
            });
            e.preventDefault();
        });

        $('body').on('submit', '#login-ajax-form', function (e) {

            e.preventDefault();
            var data = $('#login-ajax-form').serialize();
            var reserv = $(this).attr('data-route');
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
                            alert(msg);
//                            $('#invalid').text(msg);
//                            $('#invalid').fadeIn(500);
                        }
                    } else {
                        if ($('#login_type').val() == 'reservation' || reserv == 'reservation') {
                            $.ajax({
                                url: "{{url('/user/json_data')}}",
                                type: "post",
                                data: "id=" + msg + '&_token={{csrf_token()}}',
                                dataType: "json",
                                success: function (arr) {
                                    $('.reserve_login').hide();
                                    $('.reservation_address').show();
                                    $('#fullname').val(arr.name);
                                    $('#ordered_user_id').val(arr.user_id);
                                    $('#ordered_email').val(arr.email);
                                    $('#ordered_contact').val(arr.phone);
                                    $('#ordered_province').val(arr.province);
                                    $('#ordered_code').val(arr.postal_code);
                                    $('#ordered_street').val(arr.street);
                                    $('#ordered_city').val(arr.city);
                                    $('.phone').val(arr.phone);
                                    //$('.reservation_signin').hide();
                                    $('.close').click();
                                    $('.addressdropdown').load(document.URL + ' .addressdropdown>', function(){
                                        if($('.profile_delivery_detail').is(':visible'))
                                            $('.reservation_address_dropdown').attr('required','required');
                                    });
                                    //only loads header
                                    $('.header-nav').load(document.URL + ' .header-nav>ul');
                                    $('.password_reservation').hide();
                                    $('.password_reservation').removeAttr('required');
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
                $fields = array("name", "email", "password", "formatted_address", "address", "postal_code", "phone", "country", "province", "city", "apartment", "gmt");//, "confirm_password"
                foreach( $fields as $field){
                echo 'var ' . $field . ' = $("#register-form input[name=' . $field . ']").val();' . "\r\n";
                }
            ?>
            var subscribed = 0;
            if ($("#register-form input[name=subscribed]").is(':checked')) {
                subscribed = $("#register-form input[name=subscribed]").val();
            }

            $("#register-form #actionBtn").hide();
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
                $("#register-form #actionBtn").show();
                $("#register-form #regLoader").hide();

                var json = jQuery.parseJSON(result);
                if (json.type == "error") {
                    $('#register-form .editaddress').show();
                    alert(json.message);
                    //$('#register-form #registration-error').show();
                    //$('#register-form #registration-error').html(json.message);
                } else {
                    $('#register-form').hide();
                    $('#registration-success').show();
                    $('#registration-success p').html(json.message);
                    setTimeout(redirectToDashboard(true), 1000);
                }
            });
            e.preventDefault();
        });

        function redirectToDashboard(is_first_login) {
            if(is_first_login){
                return window.location.replace("{{ url('/dashboard/1') }}");
            } else {
                return window.location.replace("{{ url('/dashboard') }}");
            }
        }

        function ValidURL(textval) {
            var urlregex = new RegExp(
                    "^(http|https|ftp)\://([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&amp;%\$\-]+)*@)*((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(\:[0-9]+)*(/($|[a-zA-Z0-9\.\,\?\'\\\+&amp;%\$#\=~_\-]+))*$");
            return urlregex.test(textval);
        }

        function checkUrl(textval) {
            if (textval.replace('/dashboard', '') != textval) {
                return true;
            } else {
                return false;
            }
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
                        } else {
                            $('div#loadmoreajaxloader').html('<center>No more menus to show.</center>');
                        }
                    }
                });
            } else {
                $('div#loadmoreajaxloader').html('<center>No more menus to show.</center>');
                $(this).parent().remove();
            }
        });

        var TimeFormat = 24;//valid options are 12 and 24
        if ($('.time').length) {
            $('.time').timepicker();
            $('.time').click(function () {
                $('.ui-timepicker-hour-cell .ui-state-default').each(function () {
                    var t = parseFloat($(this).text());
                    if (t > 12) {
                        if (t < 22) {
                            $(this).text('0' + (t - 12));
                        } else {
                            $(this).text(t - 12);
                        }
                    }
                });
            });

            $('.time').change(function () {
                var t = $(this).val();
                var arr = t.split(':');
                var h = arr[0];
                var t = parseFloat(h);//hour
                var format = ":00";// + arr[2];
                var ho = arr[0];

                if (TimeFormat == 12) {
                    if (t > 11) {
                        format = ' PM';
                        if (t < 22) {
                            if (t != 12) {
                                var ho = '0' + (t - 12);
                            } else {
                                var ho = 12;
                            }
                        } else {
                            var ho = t - 12;
                        }
                    } else {
                        format = ' AM';
                        if (arr[0] == '00') {
                            var ho = '12';
                        }
                    }
                }

                var tm = ho + ':' + arr[1] + format;
                $(this).val(tm);
            });
        }
    });
</script>