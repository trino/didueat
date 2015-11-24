<div class="footer footer-gb">
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

    <div class="row">
      <!-- BEGIN COPYRIGHT -->
      <div class="col-md-4 col-sm-4 padding-top-10">
        &copy;
        <script language=javascript>var yr;
          Today = new Date();
          document.write(Today.getFullYear());</script>
        didueat.ca / ALL Rights Reserved.
      </div>
      <div class="col-md-4 col-sm-4 padding-top-10" align="center">
        <?php
        $end_loading_time = microtime(true);
        printf("Page was generated in %f seconds", $end_loading_time - $start_loading_time);
        echo "<br />";
        echo getOS();
        echo " => ";
        echo getUserBrowser();
        ?>
      </div>
      <!-- END COPYRIGHT -->
      <!-- BEGIN PAYMENTS -->
      <div class="col-md-4 col-sm-4">
        <div class="pre-footer-subscribe-box pull-right">
          {!! Form::open(array('url' => '/newsleter/subscribe', 'id'=>'subscribe-email','class'=>'','method'=>'post','role'=>'form')) !!}
          <input type="hidden" name="action" value="subscribe">

          <div class="input-group">
            <input type="text" name="email" placeholder="youremail@mail.com" class="form-control">
                        <span class="input-group-btn">
                            <button class="btn red" type="submit">Email Subscription</button>
                        </span>
          </div>
          {!! Form::close() !!}
        </div>
      </div>
      <!-- END PAYMENTS -->
    </div>
  </div>
</div>

<div class="overlay_loader">
  <div class="clearfix"></div>
  <div id="loadmoreajaxloader">
    <img src="{{ asset('assets/images/ajax-loading.gif') }}">
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
    $('body').on('click', '.update-rating', function (e) {
      var rating = $(this).val();
      var rating_id = $(this).attr('data-rating-id');
      var target_id = $(this).attr('data-target-id');
      var type = $(this).attr('data-type');

      $.post("{{ url('rating/save') }}", {
        rating: rating,
        rating_id: rating_id,
        target_id: target_id,
        type: type,
        _token: "{{ csrf_token() }}"
      }, function (json) {
        if (json.type == "error") {
          alert(json.response);
          //e.preventDefault();
        } else {
          alert(json.response);
        }
      });
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
                  $('#ordered_user_id').val(arr.user_id);
                  $('#ordered_email').val(arr.email);
                  $('#ordered_contact').val(arr.phone);
                  $('#ordered_province').val(arr.province);
                  $('#ordered_code').val(arr.post_code);
                  $('#ordered_street').val(arr.street);
                  $('#ordered_city').val(arr.city);
                  $('.reservation_signin').hide();
                  $('.fancybox-close').click();
                  //only loads header
                  $('#header-nav').load(document.URL + ' #header-nav>div:first-child');

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
      var phone_no = $("#register-form input[name=phone_no]").val();
      var password = $("#register-form input[name=password]").val();
      var confirm_password = $("#register-form input[name=confirm_password]").val();
      var subscribed = 0;
      if ($("#register-form input[name=subscribed]").is(':checked')) {
        subscribed = $("#register-form input[name=subscribed]").val();
      }

      $("#register-form #regButton").hide();
      $("#register-form #regLoader").show();
      $.post("{{ url('auth/register/ajax') }}", {
        _token: token,
        name: Name,
        email: Email,
        phone_no: phone_no,
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
