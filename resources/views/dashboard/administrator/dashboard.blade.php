@extends('layouts.default')
@section('content')

<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/select2/select2.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/bootstrap-datepicker/css/datepicker.css') }}"/>
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN THEME STYLES -->
<link href="{{ asset('assets/global/css/components.css') }}" id="style_components" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/css/plugins.css') }}" />
<!-- END THEME STYLES -->

        <div class="row content-page">

            <div class="col-md-12 col-sm-12 col-xs-12 no-padding">
                <div class="row">
                @include('layouts.includes.leftsidebar')

                <div class="col-xs-12 col-md-10 col-sm-8 no-padding">

                    @if(\Session::has('message'))
                        <div class="alert {!! Session::get('message-type') !!}">
                            <strong>{!! Session::get('message-short') !!}</strong> &nbsp; {!! Session::get('message') !!}
                        </div>
                    @endif

                    <div class="portlet box red">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i>Profile Manage
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <!-- BEGIN FORM-->
                            {!! Form::open(array('url' => '/dashboard', 'id'=>'profileForm','class'=>'form-horizontal','method'=>'post','role'=>'form')) !!}
                                <div class="form-body">
                                    <div class="alert alert-danger display-hide">
                                        <button class="close" data-close="alert"></button>
                                        You have some form errors. Please check below.
                                    </div>
                                    <div class="alert alert-success display-hide">
                                        <button class="close" data-close="alert"></button>
                                        Your form validation is successful!
                                    </div>

                                    <h3 class="form-section">Person Info</h3>
                                    <div class="form-group">
                                        <label class="control-label col-md-5 col-sm-5 col-xs-12">Full Name <span class="required">*</span></label>
                                        <div class="col-md-5 col-sm-5 col-xs-12">
                                            <input type="text" name="name" class="form-control" placeholder="Full Name" value="{{ Session::get('session_name') }}" required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-5 col-sm-5 col-xs-12">Email Address <span class="required">*</span></label>
                                        <div class="col-md-5 col-sm-5 col-xs-12">
                                            <input type="email" name="email" class="form-control" placeholder="Email Address" value="{{ Session::get('session_email') }}" required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-5 col-sm-5 col-xs-12">Phone <span class="required">*</span></label>
                                        <div class="col-md-5 col-sm-5 col-xs-12">
                                            <input type="tel" name="phone" class="form-control" placeholder="Phone" value="{{ Session::get('session_phone') }}" required />
                                        </div>
                                    </div>

                                    <h3 class="form-section">Change Password</h3>
                                    <div class="form-group">
                                        <label class="control-label col-md-5 col-sm-5 col-xs-12">Old Password</label>
                                        <div class="col-md-5 col-sm-5 col-xs-12">
                                            <input type="password" name="old_password" class="form-control" placeholder="Old Password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-5 col-sm-5 col-xs-12">New Password</label>
                                        <div class="col-md-5 col-sm-5 col-xs-12">
                                            <input type="password" name="new_password" class="form-control" placeholder="New Password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-5 col-sm-5 col-xs-12">Confirm password</label>
                                        <div class="col-md-5 col-sm-5 col-xs-12">
                                            <input type="password" name="confirm_password" class="form-control" placeholder="Confirm password">
                                        </div>
                                    </div>

                                    <h3 class="form-section">Newsletter Setting</h3>
                                    <div class="checkbox form-group margin-bottom-20">
                                        <label class="col-md-5 col-sm-5 col-xs-12 control-label" for="newsletter"></label>
                                        <div class="col-md-5 col-sm-5 col-xs-12">
                                            <div class="checker">
                                                <span>
                                                    <label class="control-label" id="newsletter_label" for="newsletter">
                                                        <input type="checkbox" name="subscribed" id="newsletter" class="form-control" @if(Session::has('session_subscribed') && Session::get('session_subscribed') == true) checked @endif> Sign up for our Newsletter
                                                    </label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="row">
                                                <div class="col-md-offset-3 col-md-9 col-sm-9 col-xs-12">
                                                    <button type="submit" class="btn red">Update</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                        </div>
                                    </div>
                                </div>
                            {!! Form::close() !!}
                            <!-- END FORM-->
                        </div>
                    </div>



                    <hr class="shop__divider">
                    <div class="row margin-bottom-30">
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <img class="img-responsive" alt="" src="{{ asset('assets/images/works/img4.jpg') }}">
                        </div>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <h2>Our Money For Your Meal!</h2>
                            <p>
                                Receive a $5 credit just for uploading a photo of your meal to our site! Remember, the meal has to be from one of our prestigious restaurants listed
                            </p>
                            <a href="{{ url('user/images') }}" class="btn red">Upload Image</a>
                        </div>
                    </div>
                </div>
            </div>



            </div>
        </div>



<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{ asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/select2/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap-markdown/js/bootstrap-markdown.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap-markdown/lib/markdown.js') }}"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ asset('assets/global/scripts/metronic.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/layout/scripts/demo.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/pages/scripts/form-validation.js') }}"></script>
<script src="{{ asset('assets/admin/pages/scripts/form-samples.js') }}"></script>
<script>
jQuery(document).ready(function() {
    Metronic.init();
    Demo.init();
    //FormValidation.init();
    FormSamples.init();

    $("#profileForm").validate();
});
</script>

@stop