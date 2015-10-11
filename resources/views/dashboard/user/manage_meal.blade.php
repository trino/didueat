DELETE THIS PAGE 1234123123








@extends('layouts.default')
@section('content')

<div class="margin-bottom-40">
    <!-- BEGIN CONTENT -->
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="content-page">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="">

                </div>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12 no-padding">
            <div class="row">
                @include('layouts.includes.leftsidebar')

                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="portlet box red">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i> Meal Upload Form
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form enctype="multipart/form-data" method="post" accept-charset="utf-8" role="form">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label>Restaurant Name</label>
                                        <input type="text" class="form-control input-lg" placeholder="Restaurant Name">
                                    </div>
                                    <div class="form-group">
                                        <label>Meal Name</label>
                                        <input type="text" class="form-control" placeholder="Meal Name">
                                    </div>
                                    <div class="form-group">
                                        <label>Image</label>
                                        <input type="file" class="form-control">
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn green">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-5 col-sm-8 col-xs-12">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box red">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-globe"></i>Meal Upload History
                                </div>
                                <div class="tools">
                                </div>
                            </div>
                            <div class="portlet-body">
                                <table class="table table-striped table-bordered table-hover" id="sample_1">
                                    <thead>
                                        <tr>
                                            <th width="20%">Image</th>
                                            <th width="50%">Restaurant Name</th>
                                            <th width="30%">Meal Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Win 95+</td>
                                            <td>Internet Explorer 4.0</td>
                                            <td>4</td>
                                        </tr>
                                        <tr>
                                            <td>Win 95+</td>
                                            <td>Internet Explorer 4.0</td>
                                            <td>4</td>
                                        </tr>
                                        <tr>
                                            <td>Win 95+</td>
                                            <td>Internet Explorer 4.0</td>
                                            <td>4</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- END EXAMPLE TABLE PORTLET-->
                </div>

            </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
</div>





<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/select2/select2.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css') }}"/>
<link href="{{ asset('assets/global/css/plugins.css') }}" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="{{ asset('assets/global/plugins/select2/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js') }}"></script>
<script src="{{ asset('assets/admin/layout/scripts/demo.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/pages/scripts/table-advanced.js') }}"></script>

<script>
    jQuery(document).ready(function() {
        Demo.init(); // init demo features
        TableAdvanced.init();
    });
</script>

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#image-preview img').attr('src', e.target.result);
                $('#image-preview img').show();
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $(function() {

        $("#image-meal").change(function() {
            readURL(this);
        });
    })
</script>






@stop