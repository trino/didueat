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
<link href="{{ asset('assets/admin/pages/css/portfolio.css') }}" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->

<div class="margin-bottom-40">
    <!-- BEGIN CONTENT -->
    <div class="col-md-12 col-xs-12">
        <div class="row content-page">
            <div class="col-xs-12">
                <div class="">

                </div>
            </div>

            <div class="col-md-12 no-padding">
                @include('layouts.includes.leftsidebar')

                <div class="col-xs-10 col-sm-9">
                    <div class="portlet box red">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i> Image Upload
                            </div>
                        </div>
                        <div class="portlet-body form">
                            {!! Form::open(array('url' => '/user/images', 'id'=>'imageForm','method'=>'post','role'=>'form', 'enctype'=>'multipart/form-data')) !!}
                                <div class="form-body">
                                    
                                    @if(Session::has('message'))
                                        <div class="alert alert-info">
                                            <strong>Alert!</strong> &nbsp; {!! Session::get('message') !!}
                                        </div>
                                    @endif
                                    
                                    <div class="form-group">
                                        <label>Restaurant Name <span class="required">*</span></label>
                                        <select name="RestaurantID" class="form-control input-lg" required>
                                            <option value="">Select One</option>
                                            @foreach($restaurants_list as $value)
                                                <option value="{{ $value->ID }}">{{ $value->Name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Title <span class="required">*</span></label>
                                        <input type="text" name="Title" class="form-control" placeholder="Title" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Image <span class="required">*</span></label>
                                        <input type="file" name="image" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn green">Save Changes</button>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <hr class="shop__divider">


                    <div class="margin-top-10">
                        <ul class="list-group">
                            <li class="list-group-item bg-red" data-filter="all">
                                <h3 class="sidebar__title">Images List</h3>
                            </li>
                        </ul>
                        <div class="row mix-grid" style="">
                            @foreach($images_list as $value)
                            <div class="col-md-3 col-sm-4 mix category_1 mix_all" style=" display: block; opacity: 1;">
                                <div class="mix-inner">
                                    <img class="img-responsive" src="{{ url('assets/images/users/'.$value->Filename) }}" alt="">
                                    <div class="mix-details">
                                        <h4>Cascusamus et iusto odio</h4>
                                        <!--<a class="mix-link"><i class="fa fa-link"></i></a>-->
                                        <a class="mix-preview fancybox-button" href="{{ url('assets/images/users/'.$value->Filename) }}" title="Project Name" data-rel="fancybox-button">
                                            <i class="fa fa-search"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <hr class="shop__divider">
                </div>

            </div>
        </div>
    </div>                
    <!-- END CONTENT -->
</div>

<script type="text/javascript" src="{{ asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}"></script>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{ asset('assets/global/plugins/jquery-mixitup/jquery.mixitup.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/fancybox/source/jquery.fancybox.pack.js') }}"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ asset('assets/global/scripts/metronic.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/layout/scripts/demo.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/pages/scripts/form-validation.js') }}"></script>
<script src="{{ asset('assets/admin/pages/scripts/portfolio.js') }}"></script>
<script>
jQuery(document).ready(function() {
    Metronic.init();
    Demo.init();
    Portfolio.init();
    $("#imageForm").validate();
});
</script>
@stop