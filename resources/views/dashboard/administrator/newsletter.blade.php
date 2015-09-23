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

<div class="margin-bottom-40">
    <!-- BEGIN CONTENT -->
    <div class="col-md-12 col-xs-12">
        <div class="row content-page">

            <div class="col-md-12 no-padding">
                @include('layouts.includes.leftsidebar')

                <div class="col-xs-12 col-md-9 col-sm-8">
                    <div class="deleteme">
                        <h3 class="sidebar__title">Newsletter</h3>
                        <hr class="shop__divider">

                        <!-- BEGIN VALIDATION STATES-->
                        <div class="portlet box red-intense">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-gift"></i>Send Newsletter
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <!-- BEGIN FORM-->
                                <form action="#" id="form_sample_1" class="form-horizontal">
                                    <div class="form-body">
                                        <div class="alert alert-danger display-hide">
                                            <button class="close" data-close="alert"></button>
                                            You have some form errors. Please check below.
                                        </div>
                                        <div class="alert alert-success display-hide">
                                            <button class="close" data-close="alert"></button>
                                            Your form validation is successful!
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 right-align">
                                                There are 1 subscriber(s).
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 right-align">Subject <span class="required">
                                                    * </span>
                                            </label>
                                            <div class="col-md-8">
                                                <input type="text" name="name" data-required="1" class="form-control"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 right-align">Message <span class="required">
                                                    * </span>
                                            </label>
                                            <div class="col-md-8">
                                                <textarea name="message" rows="6" class="form-control" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button type="submit" class="btn green">Send</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!-- END FORM-->
                            </div>
                        </div>
                        <!-- END VALIDATION STATES-->

                        <hr class="shop__divider">
                    </div>        
                </div>

            </div>
        </div>
    </div>                
    <!-- END CONTENT -->
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
<script>
jQuery(document).ready(function() {
    Metronic.init(); // init metronic core components
    Demo.init(); // init demo features
    FormValidation.init();
});
</script>
@stop