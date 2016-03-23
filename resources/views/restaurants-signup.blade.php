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


<div class="jumbotron jumbotron-fluid  bg-success signup-bg-image">

    <div class="container " style="padding: 0px !important;margin-top: 0px !important;">
    <div class="p-a-1">
        <div class="row m-l-0 m-r-0 text-xs-center" style="  ">
            <div class="col-md-12  ">
                <h1 class="display-4 banner-text-shadow">
                    We'll bring the customers to you
                </h1>
            </div>

            <div class="clearfix"></div>

            <div class="col-md-12 clearfix">
                <h4 class="p-t-0 p-b-0 banner-text-shadow">Put your menu online. Average revenue increase of 15-25% a year!</h4>

            </div>


            <div class="col-md-12 clearfix" style="margin:0px;color:#000;background:#f4f7f8;padding:12px !important;text-align:left">

                <span class="und bd" style="color:#e9232d;font-size:19px !important">How It Works</span>&nbsp; {{ DIDUEAT  }} connects restaurants to customers looking for a handy way to satisfy their cravings. Instead of an exhaustive menu to browse, we do things a bit differently -- our restaurants each feature a Meal of the Day. Using a cellphone or computer, it is a quick and easy process for customers to order -- simply select a food category, and then choose an appetizing meal. Customers can then either pick up the meal, or have it delivered. If a restaurant accepts customer payment through {{ DIDUEAT  }}'s secure checkout*, then the customer can pay for the meal on the same page. It's that simple -- simple for the customer, and simple for the restaurant!                &nbsp;<a HREF="#" onclick="toggleMore(0,'Read');return false" style="text-decoration:none;color:#00f"><span id="readmore0" style="cursor:default;text-decoration:underline; color: #00f;font-weight: bold;">Read More</span></a><br/>
<div class="smT">* If a restaurant does not enable payment through {{ DIDUEAT  }}'s secure checkout, then the customer is provided with the restaurant's phone number in order to pay the 'old fashioned' way.</div>

                
                <span id="moreInfo0" class="p-t-0" style="display:none">
                    <div class="smBR"><br/><br/></div>{{ DIDUEAT  }} prides itself on its easy ordering system -- helping customers spend less time searching for and ordering their meals! Improving on the emerging trend towards centralized meal ordering apps, {{ DIDUEAT  }} makes the process easier and faster than ever before. Don't miss out on the next big thing in restaurant ordering! Book an appointment with one of our sales reps, and we'll be happy to describe {{ DIDUEAT  }} in further detail.<div class="smBR"><br/><br/></div>
                    
                <span class="und bd" style="color:#e9232d;font-size:17px !important">A Limited Time Offer!</span>&nbsp; <a HREF="#" onclick="toggleMore(1,'Learn');return false" style="text-decoration:none;color:#00f"><span id="readmore1" style="cursor:default;text-decoration:underline; color: #00f;font-weight: bold;">Learn More</span></a><br/>
                 <span id="moreInfo1" class="p-t-0" style="display:none">
                    <div class="smBR"></div>
                    There will never be a better time to sign up with {{ DIDUEAT  }}! For a limited time, {{ DIDUEAT  }} is offering its premium sign-up package for free, helping you every step of the way so you can start getting more business as quickly as possible. {{ DIDUEAT  }} will complete your registration, offer first-hand instruction to familiarize you with the system, and will even work with you on your image portfolio (including your logo and photos of your menu items).</span>

<br/>       
        <div class="col-sm-3" style="text-align:left">
            <img class="p-b-1 worksImg"  src="{{ asset('assets/images/click.png') }}" alt="{{ $alts["click"] }}">

            <h4>Free Sign Up</h4>

            <p class="bigBlt">Sign up online, or <a href="mailto:info@didueat.ca" title="{{ $alts["contactus"] }}">contact us</a> to book an appointment</p>
        </div>

        <div class="col-sm-3" style="text-align:left">
            <img class="p-b-1 worksImg" src="{{ asset('assets/images/clip.png') }}" alt="{{ $alts["clip"] }}">

            <h4>Create Menu</h4>

            <p class="bigBlt">Do it yourself menu creation; update anytime</p>
        </div>

        <div class="col-sm-3" style="text-align:left">
            <img class="p-b-1 worksImg" style="padding-bottom:10px !important"  src="{{ asset('assets/images/box.png') }}" title="{{ $alts["box"] }}">

            <h4>Receive Orders</h4>

            <p class="bigBlt" style="margin-bottom:3px !important">Get started in as little as 10 minutes!<br/><span class="bd und">Payment Options</span></p><p style="margin-top:0px;line-height:120% !important">1. {{ DIDUEAT  }} secure payment<br/>2. Collect from customer</p>
        </div>

        <div class="col-sm-3" style="text-align:left">
            <div class="pricing-head pricing-head-active">
                <h4>Pricing <span>Plan</span></h4>

            </div>
            <ul class="pricing-content list-unstyled">
                <li><i class="fa fa-tags"></i> 10% Processing Fee*</li>
                <li><i class="fa fa-tags"></i> Monthly Payouts*</li>
                <li><i class="fa fa-tags"></i> No Contract</li>
                <li><i class="fa fa-tags"></i> Unsubscribe at Anytime</li>
            </ul>
            <div class="smT up7">* There is no processing fee or monthly payout if you do not choose to accept customer payment through the {{ DIDUEAT  }} secure payment system.</div><div class="smBR"><br/><br/></div>
        </div> 
        

        <div class="col-sm-12">
           <span class="bd">A huge increase in your customer base is within reach!</span> Using {{ DIDUEAT  }}'s simple set-up, you customize your presentation, and create your own menus and pricing. When customers place orders from you, {{ DIDUEAT  }} processes the transactions on its secure payment system*. Seconds later you receive notification, with precise details of the order.<br/>
<div class="smT">* If you do not accept payment through {{ DIDUEAT  }}, the customer will be presented your phone number when ready to check out, and you can take the order and payment the 'old fashioned' way.<div class="smBR"><br/><br/></div></div>

<span class="bd">Sign up now, risk free, and let the {{ DIDUEAT  }} team bring customers to YOU!</span><div class="smBR"><br/><br/></div>

<span class="bd"><img src="{{ asset('assets/images/arrow.gif') }}" style="padding-right:2px;position:relative;top:-2px" alt="{{ $alts["arrow"] }}"/>Your best choice is to accept customer payment through {{ DIDUEAT  }}, instead of collecting from the customer yourself.</span>&nbsp;<a HREF="#" onclick="toggleMore(2,'Learn');return false" style="text-decoration:none;color:#00f"><span id="readmore2" style="cursor:default;text-decoration:underline; color: #00f;font-weight: bold;">Learn More</span></a><br/><div class="smBR"><br/><br/></div>


                <span id="moreInfo2" class="p-t-0" style="display:none">
                <ul style="font-family: Times, Georgia, serif;color:#000080">
                  <li>Saves you time, because the customers make their entire order choices without talking to you.</li>
                  <li>Accuracy and accountability, because the exact details of the order are specified during the online process, which the customer approves before paying.</li>
                  <li>No problems from your employees making mistakes in taking the orders, because the {{ DIDUEAT  }} ordering system assembles orders exactly as you have specified, which means any errors are the responsibility of the customer.</li>
                  <li>100% secure payment system with {{ DIDUEAT  }}.</li>
                  <li>No hastles collecting payments from customers. {{ DIDUEAT  }} will have collected full payment for you before sending you the order notification and details.</li>
                  <li>Satisfies customer preferences to complete their orders in one step, instead of having to call you to read out their order details, and then make a separate payment with you.</li>
                  <li>All order details are stored electronically for your easy, private access.</li>
                  <li>{{ DIDUEAT  }}'s customer support line and chat service filter out nuisance calls from customers so that you deal only with legitimate issues.</li>
                  <li>You will be 'future ready' by preparing yourself for the emerging trend in the restaurant ordering process.</li>
                </ul>
                
                </span>
        
<span class="smT">For full details, please refer to {{ DIDUEAT  }}'s <a HREF="{{ asset('home/terms') }}" title="{{ $alts["home/terms"] }}" class="lnk smT">Terms of Use</a> page.</span>

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