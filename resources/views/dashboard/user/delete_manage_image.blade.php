@if(false)

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
<link href="{{ asset('assets/global/css/plugins.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/global/plugins/fancybox/source/jquery.fancybox.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/global/css/portfolio.css') }}" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->



<!-- delete this page???? -->


        <div class="row">
            @include('layouts.includes.leftsidebar')

            <div class="col-xs-12 col-sm-8 col-md-10 ">
                <?php printfile("views/dashboard/user/manage_image.blade.php"); ?>
                <a href="#addNewUser" class="btn pull-right fancybox-fast-view">Add New</a>

                <div class="clearfix"></div>

                <div class="box-shadow">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-globe"></i> MY UPLOADS
                        </div>
                        <div class="tools">
                        </div>
                    </div>
                    <div class="portlet-body">

                        <div class="row mix-grid" style="">
                            <?php $count = 0; ?>
                            @foreach($images_list as $value)
                                <?php $count++; ?>
                                <div class="col-md-3 col-sm-4 col-xs-12 mix category_1 mix_all" style=" display: block; opacity: 1;">
                                    <div class="mix-inner">
                                        <img class="img-responsive" src="{{ asset('assets/images/users/' . read("id") . "/" . $value->filename) }}" alt="">
                                        <div class="mix-details">
                                            <h4>Cascusamus et iusto odio</h4>
                                            <a class="mix-preview fancybox-button"
                                               href="{{ asset('assets/images/users/'.$value->filename) }}" title="Project Name" data-rel="fancybox-button"><i class="fa fa-search"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @if($count == 0)
                                <div align="center">No files have been uploaded</div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>



<div id="addNewUser" class="col-md-12 col-sm-12 col-xs-12 popup-dialog" style="display: none;">
    <div class="modal-dialog_nowidth">
        <div class="fancy-modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Image Upload</h4>
            </div>
            <br/>
            {!! Form::open(array('url' => '/user/images', 'id'=>'imageForm','method'=>'post','role'=>'form', 'enctype'=>'multipart/form-data')) !!}
            <div class="form-body">
                <div class="form-group">
                    <label>Restaurant Name </label>
                    <select name="restaurant_id" class="form-control input-lg" required>
                        <option value="">Select One</option>
                        @foreach($restaurants_list as $value)
                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Title </label>
                    <input type="text" name="title" class="form-control" placeholder="Title" required>
                </div>
                <div class="form-group">
                    <label>Image </label>
                    <input type="file" name="image" class="form-control" required>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn">Save Changes</button>
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
<script src="{{ asset('assets/global/scripts/portfolio.js') }}"></script>
<script>
    jQuery(document).ready(function() {
        Metronic.init();
        Portfolio.init();
        $("#imageForm").validate();
    });
</script>


@endif
@stop