<div class="container">
    <hr>

    <footer class="text-muted p-b-1 p-l-1 p-r-1">
        <?php
            printfile("views/dashboard/layouts/includes/footer.blade.php");
            $alts = array(
                    "home/about" => "About " . DIDUEAT,
                    "home/faq" => "Frequently asked questions",
                    "contactus" => "Contact us",
                    "restaurants/signup" => "Sign up as a restaurant owner",
                    "allergy" => "Information on allergies",
                    "socmed" => "View us on social media",
                    "home/terms" => "Terms of use",
                    "trinoweb" => "More about the webmasters"
            );
        ?>
        <div class="row text-xs-center">
            <div class="col-lg-12 ">


                <ul class="list-inline">
                    @include('popups.simplemodal')
                    <li class="list-inline-item"><a href="{{ url("home/about") }}" title="{{ $alts["home/about"] }}">About</a></li>
                    <li class="list-inline-item"><a href="{{ url("home/faq") }}" title="{{ $alts["home/faq"] }}">FAQ</a></li>


                    <li class="list-inline-item"><a href="mailto:info@didueat.ca?subject=Contact%20Me%20Regarding%20Didu%20Eat&body=
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
Thank you" title="{{ $alts["contactus"] }}">Email Support</a></li>


                <?php
                    $IsOnSignup = \Request::route()->getName() == "restaurants.signup.index";

                    if (!read("id")) {
                        echo '<li class="list-inline-item"><a href="#" data-toggle="modal" data-target="#loginModal">Log In</a></li>';
                        echo '<li class="list-inline-item"><a href="#" data-toggle="modal" data-target="#signupModal">Sign Up</a></li>';
                    }

                    if (!$IsOnSignup &&  (!Session::get('session_type_user') == "restaurant" || debugmode())) {?>
                        <li class="list-inline-item">
                            <a href="{{ url("restaurants/signup") }}" title="{{ $alts["restaurants/signup"] }}">Restaurant Sign Up</a>
                        </li>
                    <?php } ?>


                    <li class="list-inline-item">
                        <a href="#" data-toggle="modal" data-target="#allergyModal" data-id="popups.allergy" title="{{ $alts["allergy"] }}" class="simplemodal">Allergy</a>
                    </li>

                    @if(!islive())
                        <li class="list-inline-item">
                            <a href="{{ url("home/debugmode") . "?url=" . protocol() . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" }}">{{ iif(debugmode(), "Deactivate", "Activate") }} Debug Mode</a>
                        </li>
                    @endif

                    <li class="list-inline-item">
                        <h3>
                            <A href="https://www.facebook.com/didueatcanada/" target="_blank" title="{{ $alts["socmed"] }}"><i class="fa fa-facebook"></i></A>&nbsp;
                            <A href="https://mobile.twitter.com/didueatcanada" target="_blank" title="{{ $alts["socmed"] }}"><i class="fa fa-twitter"></i></A>&nbsp;
                            <A href="https://www.instagram.com/didueat/" target="_blank" title="{{ $alts["socmed"] }}"><i class="fa fa-instagram"></i></A>
                        </h3>
                    </li>


                </ul>
            </div>

            <div class="col-lg-12 " style="font-size: 90%;">
                <p>
                    Designed and built with all the <i class="fa fa-heart" style="color:#d9534f!important"></i> in theworld by
                    <a href="http://trinoweb.com/" target="_blank" title="{{ $alts["trinoweb"] }}">
                        <B CLASS="nowrap">
                            <SPAN style="color:green;">TRIN<i class="fa fa-globe"></i></SPAN><SPAN style="color:black;">WEB</SPAN>
                        </B>
                    </a>
                    <!-- and maintained by the <a href="{{ url("home/team") }}">core team</a> -->

                    &copy; {{ DIDUEAT  }} <?= date("Y"); ?>

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

                    <a href="{{ url("home/terms") }}" title="{{ $alts["home/terms"] }}">Terms of Use</a>

                </p>

            </div>
        </div>
    </footer>

</div>


<script type="text/javascript">
    var lastrating, needsrating = false;
    $(document).ready(function () {
        //loads the simple modal
        $('body').on('click', '.simplemodal', function () {
            var id = $(this).attr('data-id');
            $("#allergyModal #modal_loader").show();
            $.post("{{ url('home/simplemodal') }}/" + id, {}, function (result) {
                $("#allergyModal #modal_loader").hide();
                if (result) {
                    $("#allergyModal #modal_contents").html(result);
                    $("#allergyModal #simpleModalLabel").html($("#allergyModal #modaltitle").val());
                } else {
                    $("#allergyModal #modal_contents").hide();
                }
            });
        });

        //loads the review detail modal
        $('body').on('click', '.reviews_detail', function () {
            var rating_id = $(this).attr('data-rating-id');
            var type = $(this).attr('data-type');
            var dataname = $(this).attr('data-item-name');
            var detail = $(this).attr('data-reviews-detail');
            var target_id = $(this).attr('data-target-id');

            $("#ratingModal #ratingModalLabel").text(dataname);
            /* $("#ratingModal #reviews").text(detail); */
            $("#ratingModal #modal_contents").show();

            $.post("{{ url('reviews/users/get') }}", {
                rating_id: rating_id,
                type: type,
                target_id: target_id
            }, function (result) {
                if (result) {
                    $("#ratingModal #modal_contents").html(result);
                } else {
                    $("#ratingModal #modal_contents").hide();
                }
            });
        });

        //handles rating modal
        $('body').on('click', '.rating-it-btn', function () {
            lastrating = this;
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

        //handles clicking of a rating star, and keyboard events
        $('body').on('keyup', '#ratingInput', function () {
            var value = $(this).val();
            $('#rating-form #ratingInputHidden').val(value);
        });
        $('body').on('click', '.update-rating', function () {
            var value = $(this).val();
            $('#rating-form #rating_id').val(value);
        });

        //handles submission of the subscribe form
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

        //handles window resizing
        var wd = $(window).width();
        var ht = $(window).height();
        var headr_ht = $('.container-fluid').height();
        var htt = Number(ht) - Number(headr_ht);
        $('.top-cart-block').css({'height': htt});
        handleresizing(wd);
        function handleresizing(wd) {
            //console.log(wd);
            if (wd < '753') {
                //$('.top-cart-info').show();
                $('.header-navigation-wrap').hide();
                $('.new_headernav').show();

                $('#cartsz').closest('#printableArea').attr("class", "col-md-8 col-xs-12");
            } else {
                $('.header-navigation-wrap').show();
                //$('.top-cart-info').hide();
                $('.new_headernav').hide();

                $('#cartsz').closest('#printableArea').attr("class", "col-lg-4 col-md-5 col-sm-12");
            }
        }
        $(window).resize(function () {
            handleresizing($(window).width());
        });

        //handles submission of the search menu form (should be moved to where it's used)
        $('body').on('submit', '#searchMenuForm', function (e) {
            var term = $('#searchMenuForm input[name=search_term]').val();
            if (term.trim() != "") {
                window.location.href = "{{ url('/search/menu') }}/" + term;
            }
            e.preventDefault();
        });

        //handles submission of the search restaurant form (should be moved to where it's used)
        $('body').on('submit', '#searchRestaurantForm', function (e) {
            var term = $('#searchRestaurantForm input[name=search_term]').val();
            if (term.trim() != "") {
                window.location.href = "{{ url('/search/restaurants') }}/" + term;
            }
            e.preventDefault();
        });

        //handles submission of the search menu duplicate form (should be moved to where it's used, and duplicates merged)
        $('body').on('submit', '#searchMenuForm2', function (e) {
            var term = $('#searchMenuForm2 input[name=search_term]').val();
            if (term.trim() != "") {
                window.location.href = "{{ url('/search/menu') }}/" + term;
            }
            e.preventDefault();
        });

        //handles submission of the search restaurant duplicate form (should be moved to where it's used, and duplicates merged)
        $('body').on('submit', '#searchRestaurantForm2', function (e) {
            var term = $('#searchRestaurantForm2 input[name=search_term]').val();
            if (term.trim() != "") {
                window.location.href = "{{ url('/search/restaurants') }}/" + term;
            }
            e.preventDefault();
        });

        //boilerplate API
        function getvalue(ElementID) {
            return document.getElementById(ElementID).value;
        }
        function setvalue(ElementID, Value) {
            document.getElementById(ElementID).innerHTML = Value;
        }
        function escapechars(text) {
            return text.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
        }

        //handles submission of the forgot password form (should be moved to where it's used)
        $('body').on('submit', '#forgot-pass-form', function (e) {
            var token = $("#forgot-pass-form input[name=_token]").val();
            var email = $("#forgot-pass-form input[name=email]").val();
            $("#forgot-pass-form #lostPWregButton").hide();
            $('.overlay_loader').show();
            $.post("{{ url('auth/forgot-password/ajax') }}", {_token: token, email: email}, function (result) {
                $("#forgot-pass-form #lostPWregButton").show();
                $('.overlay_loader').hide();

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

        //handles submission of the login form (should be moved to where it's used)
        $('body').on('submit', '#login-ajax-form', function (e) {
            e.preventDefault();
            var data = $('#login-ajax-form').serialize();
            var reserv = $(this).attr('data-route');
            var token = $('#login-ajax-form input[name=_token]').val();
            $('#invalid').hide();
            $('.overlay_loader').show();
            $.ajax({
                //data retrieved from userscontroller@json_data
                url: "{{ url('auth/login/ajax') }}",
                data: data, _token: $('meta[name=_token]').attr('content'),
                type: "post",
                success: function (msg) {

                    if (isNaN(Number(msg))) {
                        $('.overlay_loader').hide();
                        if (checkUrl(msg)) {
                            window.location = msg;
                        } else {
                            msg = JSON.parse(msg);
                            $('#invalid').text(msg.message);
                            $('#invalid').fadeIn(500);
                        }
                    } else {
                        //if ($('#login_type').val() == 'reservation' || reserv == 'reservation') {
                        $.ajax({
                            url: "{{url('/user/json_data')}}",
                            type: "post",
                            data: "id=" + msg + '&_token={{csrf_token()}}',
                            dataType: "json",
                            success: function (arr) {
                                $('.overlay_loader').hide();
                                reserv = "{{ Route::getCurrentRoute()->getActionName() }}";
                                var directtorest = arr.restaurant_id && reserv != 'App\Http\Controllers\HomeController@menusRestaurants';
                                if (debugmode && directtorest) {
                                    directtorest = confirm("Would you like to be directed to the restaurant page? (DEBUG MODE)");
                                }
                                if (directtorest) {
                                    window.location = "{{ url('orders/list/restaurant') }}";
                                } else {//handles logging in without a refresh
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
                                    $('.csrftoken').attr("content", arr.token);
                                    $(".show-on-login").show();
                                    $(".hide-on-login").hide();

                                    //enable ratings
                                    $(".static-rating").attr('class', 'rating');
                                    $(".rating input[type=radio]").attr("class", "update-rating");

                                    $('.hidden_elements').hide();
                                    $('#fullname, #ordered_email, #ordered_contact').attr('readonly', 'readonly')
                                    //$('.reservation_signin').hide();
                                    $('.close').click();
                                    $('.addressdropdown').load(document.URL + ' .addressdropdown>', function () {
                                        if ($('.profile_delivery_detail').is(':visible')) {
                                            $('.reservation_address_dropdown').attr('required', 'required');
                                        }
                                    });
                                    //only loads header
                                    $('.header-nav').load(document.URL + ' .header-nav>');
                                    $('.password_reservation').hide();
                                    $('.password_reservation').removeAttr('required');

                                    if(needsrating){
                                        $('#ratingModal').modal('show');
                                    }
                                    $('#ordered_email').rules('remove');
                                    validateform("profiles", {reservation_address: "required"});//phone, mobile, password, email
                                }
                            }
                        });
                        //} else {
                        //   window.location = "{{ url('dashboard') }}";
                        //}
                    }

                },
                failure: function (msg) {
                    $('.overlay_loader').hide();
                    $('#invalid').text("ERROR: " + msg);
                    $('#invalid').fadeIn(1000);
                }
            });

        });

        //handles submission of the resend email form (should be moved to where it's used)
        $('body').on('click', '#resendMeEmail', function (e) {
            var url = $(this).attr('href');
            $('#registration-success p').html('Please wait email is being send...');
            $.get(url, {}, function (result) {
                var json = jQuery.parseJSON(result);
                $('#registration-success p').html(json.message);
            });
            e.preventDefault();
        });

        //handles submission of the register form (should be moved to where it's used)
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
            $('.overlay_loader').show();
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
                $('.overlay_loader').hide();

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
            if (is_first_login) {
                return window.location.replace("{{ url('/dashboard/1') }}");
            } else {
                return window.location.replace("{{ url('/dashboard') }}");
            }
        }

        //checks if it's a valud URL
        function ValidURL(textval) {
            var urlregex = new RegExp(
                    "^(http|https)\://([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&amp;%\$\-]+)*@)*((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.(com|ca|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(\:[0-9]+)*(/($|[a-zA-Z0-9\.\,\?\'\\\+&amp;%\$#\=~_\-]+))*$");
            return urlregex.test(textval);
        }

        //returns true if the URL is the dashboard
        function checkUrl(textval) {
            return textval.replace('/dashboard', '') != textval;
        }

        //handles the "Load more" button on the restaurant search page, and should really be moved to where it's actually used
        $('.loadmore').click(function () {
            $('.overlay_loader').show();
            ur = $('.next a').attr('href');
            if (ur != '') {
                url1 = ur.replace('/?', '?');
                $.ajax({
                    url: url1,
                    success: function (html) {
                        if (html) {
                            $('.nxtpage').remove();
                            $("#postswrapper").append(html);
                            $('.overlay_loader').hide();
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

        //handles the time picker
        var TimeFormat = 12;//valid options are 12 and 24
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

                var tm = Number(ho) + ':' + arr[1] + format;
                $(this).val(tm);
            });
        }
    });

    //when a review is submitted, this will update the review stars.
    function updatereview(target_id) {
        var reviews = $("#reviewcount" + target_id).html();
        if (isundefined(reviews)){
            var reviews = 1;
        } else {
            reviews = Number(reviews.replace(/\D/g, '')) + 1;
        }
        $("#reviewcount" + target_id).html("Reviews (" + reviews + ")");

        var element = document.getElementById("ratingtarget" + target_id);
        var rating_type = getAttribute(element, "rating-type");
        var rating_loadtype = getAttribute(element, "rating-loadtype");
        var rating_twolines = getAttribute(element, "rating-twolines");
        var rating_class = getAttribute(element, "rating-class");
        var rating_button = getAttribute(element, "rating-button");
        var rating_starts = getAttribute(element, "rating-starts");
        var rating_color = getAttribute(element, "rating-color");

        $.ajax({
            url: "{{ url('/ajax') }}",
            type: "post",
            dataType: "HTML",
            data: "type=updatereview&targetid=" + target_id + "&rating_type=" + rating_type + "&rating_loadtype=" + rating_loadtype + "&rating_twolines=" + rating_twolines + "&rating_class=" + rating_class + "&rating_button=" + rating_button + "&rating_starts=" + rating_starts + "&rating_color=" + rating_color,
            success: function (msg) {
                $("#ratingtarget" + target_id).html(msg);
            }
        })
    }
    function getAttribute(element, atttribute){
        if (element.hasAttribute(atttribute)){
            return element.getAttribute(atttribute);
        }
    }
</script>



