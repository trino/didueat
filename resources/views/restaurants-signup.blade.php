@extends('layouts.default')
@section('content')

    <link href="{{ asset('assets/global/css/components.css') }}" id="style_components" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/global/css/plugins.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/global/scripts/jqueryui/jquery-ui.css') }}" rel="stylesheet">


    <?php printfile("views/restaurants-signup.blade.php"); $Layout = "rows"; ?>

    <div class="container ">
        <div class="row ">


            <div class="col-sm-12">
                We'll bring the customers to you
                <h3>Put your menu online. Average revenue increase between 15 and 25% a year!</h3>
            </div>

            <div class="col-sm-12">
                <b>How</b> It Works

                Did U Eat is dedicated to connecting local restaurants to hungry customers. Instead of having an
                exhausting
                menu for customers to look through, we do things a bit differently. Our restaurants feature a meal of
                the
                day for each day of the week. The customer simply selects the food category they feel like having,
                choose
                the meal that appeals to them, place their order through the site, pick up/wait for delivery, and enjoy.
                That's it! <a HREF="#" onclick="toggleMore();return false" style="text-decoration:none;color:#00f">...
                    <span id="readmore" style="text-decoration:underline">Read More</span></a><span id="moreInfo"
                                                                                                    style="display:none"><div
                            style="margin:0px;font-size:5px;line-height:5px"><br/><br/></div>We pride ourselves on our easy ordering system so customers spend less time ordering and enjoy more time
            eating. What are you waiting for? Sign up now and let the Did U Eat team bring the customers to you.
            By putting your restaurant online with Did U Eat, you'll be getting more business from hungry customers
            in your local area
            Diners on our sites browse your menu and place an order from their computer or web app. Once that's
            done, our system sends you the order to be made and delivered just like you do now.
            You'll only pay on orders we send you!<br/>
        <div class="col-sm-3">
            <img src="{{ asset('assets/images/click.png') }}">

            <h3>Sign Up</h3>

            <p>Sign up or contact us today to book an appointment with one of our team members.</p>
        </div>

        <div class="col-sm-3">
            <img src="{{ asset('assets/images/clip.png') }}">

            <h3>Create Menu</h3>

            <p>Do it yourself menu creation, update anytime.</p>
        </div>

        <div class="col-sm-3">
            <img src="{{ asset('assets/images/box.png') }}">

            <h3>Receive Orders</h3>

            <p>Start receiving orders in as little as 10 minutes.</p>
        </div>

        <div class="col-sm-3">
            <div class="pricing-head pricing-head-active">
                <h3>Expert <span>Officia</span></h3>
                <h4>
                    <i>$</i>13<i>.99</i>
                    <span>Per Month</span>
                </h4>
            </div>
            <ul class="pricing-content list-unstyled">
                <li><i class="fa fa-tags"></i> 10% Sales Commission</li>
                <li><i class="fa fa-shopping-cart"></i> Consecte adiping elit</li>
            </ul>
            <div class="pricing-footer">
                <p>Lorem ipsum dolor sit </p>

            </div>
        </div>
            </div>


        </div>

        <div class="col-sm-12">
            <h1 align="center" style="">Free Restaurant Signup</h1>
        </div>


        {!! Form::open(array('url' => '/restaurants/signup', 'onsubmit'=>'return validateFn(this)', 'id'=>'signupForm', 'class'=>'form-restaurants','method'=>'post','role'=>'form', 'enctype'=>'multipart/form-data')) !!}
        @include('common.restaurant', array("hours" => false, "cols" => 2, "minimum" => true))
        {!! Form::close() !!}


    </div>

    <script type="text/javascript">

    

function chkCBs(cb){
  if(cb){
   if(cbchkd > 2){
    alert("You may check a maximum of only 3 cuisine types. Please adjust your selection accordingly.");
    return false;
   }
   else{
    cbchkd++;
    return true;
   }
  }
  else{
   cbchkd--;
   return false;
  }
////
}
     


        function validateFn(f) {
            var cuisinesStr = "";
            var comma = "";
            for (var i = 0; i < cuisineCnt; i++) {
                if (f.elements["cuisine" + i].checked) {
                    if (cuisinesStr != "") {
                        comma = ",";
                    }
                    cuisinesStr += comma + f.elements["cuisine" + i].value
                }
            }
            f.cuisines.value = cuisinesStr;
        }



        $(document).ready(function () {
//            Demo.init();

            jQuery.validator.addMethod("matchPattern", function (value, element) {
                var patt = "/((^[0-9]+[a-z]+)|(^[a-z]+[0-9]+))+[0-9a-z]+$/i";
                if (value.replace(' ', '').length == 6) {
                    return true;
                }
                return false;
            });


            var phoneRep = /[\-\ \,\(\)\.]/g;

            jQuery.validator.addMethod("checkPhone", function (value, element) {
                var numStr = "0123456789";
                var cleanedPhone = value.replace(phoneRep, '');
                var numOK = true;
                for (var i = 0; i < cleanedPhone.length; i++) {
                    if (numStr.indexOf(cleanedPhone.charAt(i)) == -1) {
                        numOK = false;
                        break;
                    }
                }

                if (numOK) {
                    return true;
                }
                else {
                    return false;
                }
            });

            jQuery.validator.addMethod("checkLen", function (value, element) {
                var cleanedPhone = value.replace(phoneRep, '');
                if (cleanedPhone.length != 10) {
                    return false;
                }
                return true;
            });


            $("#signupForm").validate({
                rules: {
                    phone: {
                        required: true,
                        checkPhone: true,
                        checkLen: true
                    },
                    mobile: {
                        checkPhone: true,
                        checkLen: true
                    },
                    email: {
                        required: true,
                        email: true,
                        remote: {
                            url: "{{ url('auth/validate/email/ajax') }}",
                            type: "post"
                        }
                    },
                    password: {
                        required: true,
                        minlength: 5
                    },
                    confirm_password: {
                        equalTo: "#password"
                    }
                },
                messages: {
                    phone: {
                        required: "Please enter a phone number",
                        checkPhone: "Invalid character. Please just use numbers and hyphens",
                        checkLen: "Phone number must be 10 numbers long"
                    },
                    email: {
                        required: "Please enter an email address!",
                        remote: "This email address is already in use!"
                    },
                    mobile: {
                        checkPhone: "Invalid character. Please just use numbers and hyphens",
                        checkLen: "Phone number must be 10 numbers long"
                    }
                }
            });

            /* duplicates tag field
             $('#demo4').tagEditor({
             initialTags: [
            {{ old('tags') }}],
             placeholder: 'Enter tags ...',
             maxTags: 9,
             onChange: function (field, editor, tags) {
             $('#responseTags').val((tags.length ? tags.join(', ') : ''));
             },
             beforeTagDelete: function (field, editor, tags, val) {
             var q = confirm('Remove tag "' + val + '"?');
             return q;
             }
             });
             */

            @if(old('city'))
                $(document).ready(function () {
                        cities("{{ url('ajax') }}", "{{ old('city') }}");
                    });
            @endif

            $('body').on('change', '#is_delivery', function () {
                        if ($(this).is(':checked')) {
                            $('#is_delivery_options').show();
                        } else {
                            $('#is_delivery_options').hide();
                        }
                    });

            function ajaxuploadbtn(button_id) {
                var button = $('#' + button_id), interval;
                act = base_url + 'uploadimg/restaurant';
                new AjaxUpload(button, {
                    action: act,
                    name: 'myfile',
                    data: {'_token': '{{csrf_token()}}'},
                    onSubmit: function (file, ext) {
                        button.text('Uploading...');
                        this.disable();
                        interval = window.setInterval(function () {
                            var text = button.text();
                            if (text.length < 13) {
                                button.text(text + '.');
                            } else {
                                button.text('Uploading...');
                            }
                        }, 200);
                    },
                    onComplete: function (file, response) {
                        var resp = response.split('___');
                        var path = resp[0];
                        var img = resp[1];
                        button.html('Change Image');
                        window.clearInterval(interval);
                        this.enable();
                        $('#picture').attr('src', path);
                        $('#hiddenLogo').val(img);
                    }
                });
            }

            ajaxuploadbtn('uploadbtn');
        });
    </script>
@stop