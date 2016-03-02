@extends('layouts.default')
@section('content')

        <!--link href="{{ asset('assets/global/css/components.css') }}" id="style_components" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/global/css/plugins.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/global/scripts/jqueryui/jquery-ui.css') }}" rel="stylesheet"-->
<script src="{{ asset('assets/global/scripts/form-validation.js') }}"></script>

<?php printfile("views/restaurants-signup.blade.php"); $Layout = "rows"; ?>


<div class="jumbotron jumbotron-fluid  bg-warning signup-bg-image">

    <div class="container " style="padding: 0px !important;margin-top: 0px !important;">
    <div class="p-a-1">
        <div class="row m-l-0 m-r-0 text-md-center" style="  ">
            <div class="col-md-12  ">
                <h1 class="display-4 banner-text-shadow">
                    We'll bring the customers to you
                </h1>
            </div>

            <div class="clearfix"></div>

            <div class="col-md-12 clearfix">
                <p class="lead p-t-1 p-b-0 banner-text-shadow">Put your menu online. Average revenue increase between 15
                    and 25% a year!</p>

            </div>


            <div class="col-md-12 clearfix">


                <span class="  ">
                How It Works
                {{ DIDUEAT  }} is dedicated to connecting local restaurants to hungry customers. Instead of having an
                exhausting menu for customers to look through, we do things a bit differently. Our restaurants feature a
                meal of
                the day for each day of the week. The customer simply selects the food category they feel like having,
                choose the meal that appeals to them, place their order through the site, pick up/wait for delivery, and
                enjoy.
                That's it!

                <a HREF="#" onclick="toggleMore();return false" style="text-decoration:none;color:#00f">
                    <span id="readmore" style="text-decoration:underline; color: white;font-weight: bold;">Read More</span>
                </a>
</span><br>
                <span id="moreInfo" class="p-t-1" style="display:none">
                    <div class="smBR"></div>We pride ourselves on our easy ordering system so customers spend less time ordering and enjoy more time
            eating. What are you waiting for? Sign up now and let the {{ DIDUEAT  }} team bring the customers to you.
            By putting your restaurant online with {{ DIDUEAT  }}, you'll be getting more business from hungry customers
            in your local area
            Diners on our sites browse your menu and place an order from their computer or web app. Once that's
            done, our system sends you the order to be made and delivered just like you do now.
            You'll only pay on orders we send you!

<br/><br/>

        <div class="col-sm-3   ">
            <img class="p-b-1"  src="{{ asset('assets/images/click.png') }}">

            <h4>Sign Up</h4>

            <p>Sign up or contact us to book an appointment</p>
        </div>

        <div class="col-sm-3   ">
            <img class="p-b-1" src="{{ asset('assets/images/clip.png') }}">

            <h4>Create Menu</h4>

            <p>Do it yourself menu creation, update anytime</p>
        </div>

        <div class="col-sm-3   ">
            <img class="p-b-1"  src="{{ asset('assets/images/box.png') }}">

            <h4>Receive Orders</h4>

            <p>Start receiving orders in as little as 10 minutes</p>
        </div>

        <div class="col-sm-3">
            <div class="pricing-head pricing-head-active">
                <h4>Pricing <span>Plan</span></h4>

            </div>
            <ul class="pricing-content list-unstyled">
                <li><i class="fa fa-tags"></i> 10% Commission</li>
                <li><i class="fa fa-tags"></i> Paid out Monthly</li>
                <li><i class="fa fa-tags"></i> No Contract</li>
                <li><i class="fa fa-tags"></i> Unsubscribe Anytime</li>
            </ul>

        </div>
            </span>


        </div>
        </div>
    </div>
    </div>
</div>
</div>


<div class="container" style="padding-top:0 !important;">
    <div class="row ">


        <div class="col-sm-12">
            <h1 align="center">SIGN UP NOW</h1>
        </div>


        {!! Form::open(array('url' => '/restaurants/signup', 'onsubmit'=>'return validateFn(this)', 'id'=>'signupForm', 'class'=>'form-restaurants','method'=>'post','role'=>'form', 'enctype'=>'multipart/form-data')) !!}

        @include('common.restaurant', array("hours" => false, "cols" => 2, "minimum" => true))
        {!! Form::close() !!}


    </div>

    <script type="text/javascript">
        $(document).ready(function () {


            validateform("signupForm", {
                phone: "phone required",
                mobile: "phone",
                email: "email required",
                password: "required minlength 3"
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