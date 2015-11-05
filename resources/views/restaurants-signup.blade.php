
@extends('layouts.default')
@section('content')

    <link href="{{ asset('assets/global/css/components.css') }}" id="style_components" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/global/css/plugins.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/global/scripts/jqueryui/jquery-ui.css') }}" rel="stylesheet">

    <div class="margin-bottom-40">
        <div class="slide">
            <div class="text">
                We'll bring the customers to you
                <h3>Put your menu online. Average revenue increase ranging 15-25% a year!</h3>
            </div>
        </div>

        <div class="heading">
            <div class="text"><b>How</b> It Works</div>
        </div>

        <div class="intro">
            <div class="text">
                Did U Eat is dedicated to connecting local restaurants to hungry customers. Instead of having an
                exhausting
                menu for customers to look through, we do things a bit differently. Our restaurants feature a meal of
                the
                day for each day of the week. The customer simply selects the food category they feel like having,
                choose
                the meal that appeals to them, place their order through the site, pick up/wait for delivery, and enjoy.
                That's it!
                We pride ourselves on our easy ordering system so customers spend less time ordering and enjoy more time
                eating. What are you waiting for? Sign up now and let the Did U Eat team bring the customers to you.
                By putting your restaurant online with Did U Eat, you'll be getting more business from hungry customers
                in
                your local area
                Diners on our sites browse your menu and place an order from their computer or web app. Once that's
                done,
                our system sends you the order to be made and delivered just like you do now.
                You'll only pay on orders we send you
                <button class="btn-3">Sign Up Now</button>
            </div>
        </div>

        <div class="heading">
            <div class="text"><b>Receive Orders</b> In 10 Mins</div>
        </div>

        <div class="grid">
            <div class="col-1-3">
                <div class="module">
                    <img src="{{ asset('assets/images/click.png') }}">
                    <h3>Sign Up</h3>
                    <p>Sign up or contact us today to book an appointment with one of our team members.</p>
                </div>
            </div>
            <div class="col-1-3">
                <div class="module">
                    <img src="{{ asset('assets/images/clip.png') }}">
                    <h3>Create Menu</h3>
                    <p>Do it yourself menu creation, update anytime.</p>
                </div>
            </div>
            <div class="col-1-3">
                <div class="module">
                    <img src="{{ asset('assets/images/box.png') }}">
                    <h3>Receive Orders</h3>
                    <p>Start receiving orders in as little as 10 minutes.</p>
                </div>
            </div>
        </div>


        <div class="services">
            <div class="eyes">
                <div class="texted"><b>Our</b> Services</div>
            </div>

            <div class="row margin-bottom-10" style="margin-top: 20px; padding: 30px;">
                <!-- Pricing -->
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <div class="pricing pricing-active hover-effect">
                        <div class="pricing-head pricing-head-active">
                            <h3>Expert <span>Officia deserunt mollitia</span></h3>
                            <h4>
                                <i>$</i>13<i>.99</i>
                                <span>Per Month</span>
                            </h4>
                        </div>
                        <ul class="pricing-content list-unstyled">
                            <li><i class="fa fa-tags"></i> At vero eos</li>
                            <li><i class="fa fa-asterisk"></i> No Support</li>
                            <li><i class="fa fa-heart"></i> Fusce condimentum</li>
                            <li><i class="fa fa-star"></i> Ut non libero</li>
                            <li><i class="fa fa-shopping-cart"></i> Consecte adiping elit</li>
                        </ul>
                        <div class="pricing-footer">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero magna psum olor.</p>
                            <a href="#" class="btn btn-primary red">Sign Up <i class="m-icon-swapright m-icon-white"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-md-9 col-sm-8 col-xs-12">
                    @if(\Session::has('message'))
                        <div class="alert {!! Session::get('message-type') !!}">
                            <strong>{!! Session::get('message-short') !!}</strong>
                            &nbsp; {!! Session::get('message') !!}
                        </div>
                        @endif

                        {!! Form::open(array('url' => '/restaurants/signup', 'id'=>'signupForm', 'class'=>'form-restaurants','method'=>'post','role'=>'form', 'enctype'=>'multipart/form-data')) !!}
                            <!--//End Pricing -->
                            <?php $Layout = "rows"; ?>
                            @include('common.restaurant')
                        {!! Form::close() !!}
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script type="text/javascript" src="{{ asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/global/plugins/select2/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/global/scripts/metronic.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/global/scripts/demo.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/global/scripts/jquery.timepicker.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            Demo.init();
            $('.time').timepicker();
            $('.time').click(function () {
                $('.ui-timepicker-hour-cell .ui-state-default').each(function () {
                    var t = parseFloat($(this).text());
                    if (t > 12) {
                        if (t < 22)
                            $(this).text('0' + (t - 12));
                        else
                            $(this).text(t - 12);
                    }
                });
            });
            $('.time').change(function () {
                //$('.time_real').val($(this).val());
                var t = $(this).val();
                var arr = t.split(':');
                var h = arr[0];
                var t = parseFloat(h);
                if (t > 11) {
                    var format = 'PM';
                    if (t < 22) {
                        if (t != 12)
                            var ho = '0' + (t - 12);
                        else
                            var ho = 12;
                    }
                    else {
                        var ho = t - 12;
                    }
                }
                else {
                    var ho = arr[0];
                    var format = 'AM';
                    if (arr[0] == '00')
                        var ho = '12';
                }
                var tm = ho + ':' + arr[1] + ' ' + format;
                $(this).val(tm);
            });

            jQuery.validator.addMethod("matchPattern", function (value, element) {
                var patt = "/((^[0-9]+[a-z]+)|(^[a-z]+[0-9]+))+[0-9a-z]+$/i";
                if (value.replace(' ', '').length == 6) {
                    return true;
                }
                else {
                    return false;
                }
            });
            $("#signupForm").validate({
                rules: {
                    Phone: {
                        required: true,
                        minlength: 10,
                        maxlength: 10,
                        number: true

                    },

                    email: {
                        required: true,
                        email: true
                    },
                    PostalCode: {
                        matchPattern: true
                    }
                },
                messages: {
                    Phone: {
                        required: "Please enter a phone number",
                        minlength: "Your phone number must consist of at least 10 Number",
                        maxlength: "Your phone number must consist of at most 10 Number",
                    },

                    email: "Please enter a valid email address",
                    PostalCode: {
                        matchPattern: "Invalid Postal Code"
                    },
                }
            });
        });
    </script>
@stop