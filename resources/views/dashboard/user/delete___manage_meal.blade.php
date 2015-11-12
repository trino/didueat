

@extends('layouts.default')
@section('content')




    DELETE THIS PAGE 1234123123








    <div class="margin-bottom-40">





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
                    <div class="box-shadow">
                        <div class="portlet-title">
                            <div class="caption">
                                 Meal Upload Form
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
                                    <button type="submit" class="btn red">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-5 col-sm-8 col-xs-12">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="box-shadow">
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




@include('common.tabletools')





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