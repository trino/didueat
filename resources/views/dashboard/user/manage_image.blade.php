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
<link href="{{ asset('assets/global/css/plugins.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/global/plugins/fancybox/source/jquery.fancybox.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/global/css/portfolio.css') }}" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->


<div class="content-page">
    <div class="row">
        @include('layouts.includes.leftsidebar')

        <div class="col-xs-12 col-sm-8 col-md-10 ">





            <!--div class="row margin-bottom-20">
                            <div class="col-md-5 col-sm-5 col-xs-12">
                                <img class="img-responsive" alt="" src="{{ asset('assets/images/works/img4.jpg') }}">
                            </div>
                            <div class="col-md-7 col-sm-7 col-xs-12">
                                <h2>Our Money For Your Meal!</h2>
                                <p>
                                    Receive a $5 credit just for uploading a photo of your meal to our site! Remember, the meal has to be from one of our prestigious restaurants listed
                                </p>
                            </div>
                        </div-->



            <a class="btn red pull-right fancybox-fast-view" href="#addNewUser">Add New</a>
            <div class="clearfix"></div>
            <hr class="shop__divider">

            @if(\Session::has('message'))
                <div class="alert {!! Session::get('message-type') !!}">
                    <strong>{!! Session::get('message-short') !!}</strong> &nbsp; {!! Session::get('message') !!}
                </div>
            @endif


            <div class="portlet box red">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i>MY UPLOADS
                    </div>
                    <div class="tools">
                    </div>
                </div>
                <div class="portlet-body">



                    <div class="row mix-grid" style="">
                        @foreach($images_list as $value)
                            <div class="col-md-3 col-sm-4 col-xs-12 mix category_1 mix_all" style=" display: block; opacity: 1;">
                                <div class="mix-inner">
                                    <img class="img-responsive" src="{{ url('assets/images/users/'.$value->filename) }}" alt="">
                                    <div class="mix-details">
                                        <h4>Cascusamus et iusto odio</h4>
                                        <!--<a class="mix-link"><i class="fa fa-link"></i></a>-->
                                        <a class="mix-preview fancybox-button" href="{{ url('assets/images/users/'.$value->filename) }}" title="Project Name" data-rel="fancybox-button">
                                            <i class="fa fa-search"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>


        </div>

    </div>
</div>



<div id="addNewUser" class="col-md-12" style="display: none;" >
    <div class="modal-dialog">
        <div class="fancy-modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Image Upload</h4>
            </div>
            <br />
            {!! Form::open(array('url' => '/user/images', 'id'=>'imageForm','method'=>'post','role'=>'form', 'enctype'=>'multipart/form-data')) !!}
            <div class="form-body">
                <div class="form-group">
                    <label>Restaurant Name <span class="required">*</span></label>
                    <select name="restaurant_id" class="form-control input-lg" required>
                        <option value="">Select One</option>
                        @foreach($restaurants_list as $value)
                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Title <span class="required">*</span></label>
                    <input type="text" name="title" class="form-control" placeholder="Title" required>
                </div>
                <div class="form-group">
                    <label>Image <span class="required">*</span></label>
                    <input type="file" name="image" class="form-control" required>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn red">Save Changes</button>
            </div>
            {!! Form::close() !!}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<script type="text/javascript" src="{{ asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}"></script>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{ asset('assets/global/plugins/jquery-mixitup/jquery.mixitup.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/fancybox/source/jquery.fancybox.pack.js') }}"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ asset('assets/global/scripts/metronic.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/scripts/demo.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/scripts/form-validation.js') }}"></script>
<script src="{{ asset('assets/global/pages/scripts/portfolio.js') }}"></script>
<script>
    jQuery(document).ready(function() {
        Metronic.init();
        Demo.init();
        Portfolio.init();
        $("#imageForm").validate();
    });
</script>
@stop