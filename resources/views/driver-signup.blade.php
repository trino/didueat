@extends('layouts.default')
@section('content')

<script src="{{ asset('assets/global/scripts/form-validation.js') }}"></script>

<?php
    printfile("views/driver-signup.blade.php"); $Layout = "rows";
    $alts = array(
            "contactus" => "Contact us",
            "home/terms" => "Terms of Use",
            "click" => "Sign up",
            "clip" => "Create a menu",
            "box" => "Receive orders",
            "arrow" => "Payment handling"
    );
?>

<div class="container" style="padding-top:0 !important;">
    <div class="row ">

        <div class="col-sm-12">
            <h1 align="center">SIGN UP AS A DRIVER</h1>
        </div>

        {!! Form::open(array('url' => '/driver/signup', 'onsubmit'=>'return validateFn(this)', 'id'=>'signupForm', 'class'=>'form-restaurants','method'=>'post','role'=>'form', 'enctype'=>'multipart/form-data')) !!}
            @include('common.driver', array("hours" => false, "cols" => 2, "minimum" => true))
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