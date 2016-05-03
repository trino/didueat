@extends('layouts.default')
@section('content')

        <!--link href="{{ asset('assets/global/css/components.css') }}" id="style_components" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/global/css/plugins.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/global/scripts/jqueryui/jquery-ui.css') }}" rel="stylesheet"-->
<script src="{{ asset('assets/global/scripts/form-validation.js') }}"></script>

<?php
printfile("views/restaurants-signup.blade.php"); $Layout = "rows";
$alts = array(
        "contactus" => "Contact us",
        "home/terms" => "Terms of Use",
        "click" => "Sign up",
        "clip" => "Create a menu",
        "box" => "Receive orders",
        "arrow" => "Payment handling"
);
?>


<div class="jumbotron jumbotron-fluid   signup-bg-image bg-success p-b-0" style="
">

    <div class="container " style="padding: 0px !important;margin-top: 0px !important;">
        <div class="p-a-1">
            <div class="row m-l-0 m-r-0 text-xs-center" style="  ">
                <div class="col-md-12  ">
                    <h1 class="display-4 banner-text-shadow">
                        We'll bring the customers to you
                    </h1>
                </div>


                <div class="col-md-12">
                    <h4 class="p-t-0 p-b-0 banner-text-shadow">Put your menu online. An average revenue increase of
                        15-25%
                        a year!</h4>

                </div>

                <div class="col-md-12 m-t-1 text-xs-left" style="">

                    <strong class="und bd">How It Works</strong>: To satisfy the refined taste of its customers, DiduEat
                    works exclusively with high quality restaurants.
                    Partnering restaurants avoid the costs and logistics of employing their own drivers while
                    simultaneously gaining access to a much larger customer base and benefitting from higher revenues.
                    &nbsp;<a HREF="#" onclick="toggleMore(0,'Read');return false"><span
                                id="readmore0"
                                style="">Read More</span></a><br/><br/>


<span id="moreInfo0" class="p-t-0" style="display:none">


<div>
    <h4>How It works</h4>

    <h6>ORDER</h6>
    <p>Customers find nearby high quality restaurants on DiduEat.ca and order their favourite
        meal.</p>

    <h6>PREPARE</h6>
    <p>Once the order is submitted, the restaurant prepares the food.</p>

    <h6>DELIVERY</h6>
    <p>A driver picks up the order and delivers it as quickly as possible to the customer.</p>


</div>
<br>
<div>
    <h4>Main advantages of being a partner restaurant</h4>

    <p> To satisfy the refined taste of its customers, {{ DIDUEAT  }} works exclusively with high quality restaurants.
        Partnering restaurants avoid the costs and logistics of employing their own drivers while simultaneously gaining
        access to a much larger customer base and benefitting from higher revenues.

    </p>
    <br>
    <h4>Still not convinced?</h4>

    <p> {{ DIDUEAT  }} prides itself on its easy ordering system, helping customers spend less time searching for and
        ordering their meals. Improving on the emerging trend towards centralized meal ordering apps, {{ DIDUEAT  }}
        makes the process easier and faster than ever before. The main advantages include:</p>

    <p> 1. Larger customer base, use the power of the internet to bring your business to the 21st century! Exposing your
        cuisine to a whole new customer base</p>

    <p> 2. Easy integration, we set up your entire online store</p>

    <p> 3. Personalized delivery fleet, drivers are deployed to pick up the order on a timely manner</p>


</div>

<br>
<div>
    <h4>The fine print</h4>

    <p> Your restaurant will receive a phone call when an order is placed. You’ll need to log in via phone/tablet or
        computer to view and prepare the order. If for any reason you can not fulfil the order, simply click Decline
        and we will contact the customer.</p>
    <ul>
        <li>       {{ DIDUEAT  }} is 100% responsible for inputting, marketing and delivering your food. We don’t get
            paid
            unless you get an order
        </li>

        <li>       {{ DIDUEAT  }} retains a 10% Commission for every order we bring to your business</li>

        <li> The commission is flexible, for example: we can add 5% on top of your price and only take 5% commission
        </li>

        <li> A $5 delivery fee will be added on top of the total</li>

        <li>   {{ DIDUEAT  }} drivers gets to keep 100% of the tip</li>

        <li> Customer will check out with our secure online payment or can pay Cash on Delivery</li>

        <li> Bi-monthly payouts on 1st and 15th of every month via cheque or bank transfer</li>

        <li> Obligatory window sticker and marketing material will be sent to your establishment</li>

        <li> Fake orders will be reviewed on an individual basis</li>

        <li> Unsubscribe at any time, no cancellation fee</li>
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

            //handle hiding/loading of delivery-only options (duplicate code)
            $('body').on('change', '#is_delivery', function () {
                if ($(this).is(':checked')) {
                    $('#is_delivery_options').show();
                } else {
                    $('#is_delivery_options').hide();
                }
            });

//handle uploading of an image
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