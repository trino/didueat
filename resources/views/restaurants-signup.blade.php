@extends('layouts.default')
@section('content')

    <!--link href="{{ asset('assets/global/css/components.css') }}" id="style_components" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/global/css/plugins.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/global/scripts/jqueryui/jquery-ui.css') }}" rel="stylesheet"-->
    <script src="{{ asset('assets/global/scripts/form-validation.js') }}"></script>

<?php printfile("views/restaurants-signup.blade.php"); $Layout = "rows"; ?>


<div class="jumbotron jumbotron-fluid  bg-primary main-bg-image" style="">
    <div class="container " style="padding-top: 0px !important;">
        <div class="row m-l-0 m-r-0 text-md-center" style="  ">
            <div class="col-md-12  ">

                <h1 class="display-4 p-t-1 banner-text-shadow" style="">
                    We'll bring the customers to you
                </h1>
            </div>


            <div class="clearfix"></div>

            <div class="col-md-12   clearfix">
                <p class="lead p-t-1 p-b-0 banner-text-shadow">Put your menu online. Average revenue increase between 15
                    and 25% a year!</p>

            </div>




                <span class="col-sm-12    ">
                How It Works
                Did U Eat is dedicated to connecting local restaurants to hungry customers. Instead of having an
                exhausting menu for customers to look through, we do things a bit differently. Our restaurants feature a
                meal of
                the day for each day of the week. The customer simply selects the food category they feel like having,
                choose the meal that appeals to them, place their order through the site, pick up/wait for delivery, and
                enjoy.
                That's it!
                <a HREF="#" onclick="toggleMore();return false" style="text-decoration:none;color:#00f">...

                    <span id="readmore" style="text-decoration:underline; color: white;">Read More</span>

                </a>

                <span id="moreInfo" style="display:none">
                    <div style="margin:0px;font-size:5px;line-height:5px"><br/><br/></div>We pride ourselves on our easy ordering system so customers spend less time ordering and enjoy more time
            eating. What are you waiting for? Sign up now and let the Did U Eat team bring the customers to you.
            By putting your restaurant online with Did U Eat, you'll be getting more business from hungry customers
            in your local area
            Diners on our sites browse your menu and place an order from their computer or web app. Once that's
            done, our system sends you the order to be made and delivered just like you do now.
            You'll only pay on orders we send you!



        <div class="col-sm-3   ">
            <img src="{{ asset('assets/images/click.png') }}">

            <h3>Sign Up</h3>

            <p>Sign up or contact us today to book an appointment with one of our team members.</p>
        </div>

        <div class="col-sm-3   ">
            <img src="{{ asset('assets/images/clip.png') }}">

            <h3>Create Menu</h3>

            <p>Do it yourself menu creation, update anytime.</p>
        </div>

        <div class="col-sm-3   ">
            <img src="{{ asset('assets/images/box.png') }}">

            <h3>Receive Orders</h3>

            <p>Start receiving orders in as little as 10 minutes.</p>
        </div>

        <div class="col-sm-3   ">
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
            </span>


        </div>
    </div>
</div>


<div class="container" style="padding-top:0 !important;">
    <div class="row ">


        <div class="col-sm-12">
            <h1 align="center" style="">Receive orders in 10 minutes</h1>
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