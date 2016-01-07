@extends('layouts.default')
@section('content')

    <link href="{{ asset('assets/global/css/components.css') }}" id="style_components" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/global/css/plugins.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/global/scripts/jqueryui/jquery-ui.css') }}" rel="stylesheet">


    <?php printfile("views/restaurants-signup.blade.php"); $Layout = "rows"; ?>

    <div class="row">

        <div class="col-sm-12">
            We'll bring the customers to you
            <h3>Put your menu online. Average revenue increase ranging 15-25% a year!</h3>
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
            That's it!
            We pride ourselves on our easy ordering system so customers spend less time ordering and enjoy more time
            eating. What are you waiting for? Sign up now and let the Did U Eat team bring the customers to you.
            By putting your restaurant online with Did U Eat, you'll be getting more business from hungry customers
            in your local area
            Diners on our sites browse your menu and place an order from their computer or web app. Once that's
            done, our system sends you the order to be made and delivered just like you do now.
            You'll only pay on orders we send you
        </div>

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

        <div class="col-sm-12">
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

            </div>
        </div>

        {!! Form::open(array('url' => '/restaurants/signup', 'id'=>'signupForm', 'class'=>'form-restaurants','method'=>'post','role'=>'form', 'enctype'=>'multipart/form-data')) !!}
        @include('common.restaurant')
        {!! Form::close() !!}
    </div>

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
                        if (t < 22) {
                            $(this).text('0' + (t - 12));
                        }else {
                            $(this).text(t - 12);
                        }
                    }
                });
            });

            $('.time').change(function () {
                var t = $(this).val();
                var arr = t.split(':');
                var h = arr[0];
                var t = parseFloat(h);
                if (t > 11) {
                    var format = 'PM';
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
                    var ho = arr[0];
                    var format = 'AM';
                    if (arr[0] == '00') {
                        var ho = '12';
                    }
                }
                var tm = ho + ':' + arr[1] + ' ' + format;
                $(this).val(tm);
            });

            jQuery.validator.addMethod("matchPattern", function (value, element) {
                var patt = "/((^[0-9]+[a-z]+)|(^[a-z]+[0-9]+))+[0-9a-z]+$/i";
                if (value.replace(' ', '').length == 6) {
                    return true;
                }
                return false;
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
                        email: true,
                        remote: {
                            url: "{{ url('auth/validate/email/ajax') }}",
                            type: "post"
                        }
                    },
                    password1: {
                        required: true,
                        minlength: 5
                    },
                    confirm_password1: {
                        required: true,
                        minlength: 5,
                        equalTo: "#password1"
                    }
                },
                messages: {
                    Phone: {
                        required: "Please enter a phone number",
                        minlength: "Your phone number must consist of at least 10 numbers",
                        maxlength: "Your phone number must consist of at most 10 numbers",
                    },
                    email: {
                        required: "Please Enter an email address!",
                        email: "This is not a valid email address!",
                        remote: "This email address is already in use!"
                    },
                    confirm_password1: {
                        equalTo: "The password fields are mis-matched!"
                    }
                }
            });

            $('#demo4').tagEditor({
                initialTags: [{{ old('tags') }}],
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