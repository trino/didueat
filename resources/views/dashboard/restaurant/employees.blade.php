@extends('layouts.default')
@section('content')




    DELETE ME ASDSAD32432432











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

                <div class="col-xs-12 col-md-9 col-sm-8">
                    <div class="deleteme">
                        <h3 class="sidebar__title">Employees Manager</h3>
                        <hr class="shop__divider">

                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box red">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-globe"></i>Employees List
                                </div>
                                <div class="tools">
                                </div>
                            </div>
                            <div class="portlet-body">
                                <table class="table table-striped table-bordered table-hover" id="sample_1">
                                    <thead>
                                        <tr>
                                            <th width="5%">ID</th>
                                            <th width="25%">Name</th>
                                            <th width="30%">Email</th>
                                            <th width="20%">Phone</th>
                                            <th width="20%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Internet Explorer 4.0</td>
                                            <td>Win 95+</td>
                                            <td>4</td>
                                            <td><a href="#" class="btn btn-danger" onclick="return confirm('Are you sure you want to fire Waqar Javed?');">Fire</a><a href="?action=possess&amp;ID=7" class="btn btn-info" onclick="return confirm('Are you sure you want to possess Waqar Javed?');">Possess</a></td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>Internet Explorer 4.0</td>
                                            <td>Win 95+</td>
                                            <td>4</td>
                                            <td><a href="#" class="btn btn-danger" onclick="return confirm('Are you sure you want to fire Waqar Javed?');">Fire</a><a href="?action=possess&amp;ID=7" class="btn btn-info" onclick="return confirm('Are you sure you want to possess Waqar Javed?');">Possess</a></td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>Internet Explorer 4.0</td>
                                            <td>Win 95+</td>
                                            <td>4</td>
                                            <td><a href="#" class="btn btn-danger red" onclick="return confirm('Are you sure you want to fire Waqar Javed?');">Fire</a><a href="?action=possess&amp;ID=7" class="btn btn-info" onclick="return confirm('Are you sure you want to possess Waqar Javed?');">Possess</a></td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>Internet Explorer 4.0</td>
                                            <td>Win 95+</td>
                                            <td>4</td>
                                            <td><a href="#" class="btn btn-danger red" onclick="return confirm('Are you sure you want to fire Waqar Javed?');">Fire</a><a href="?action=possess&amp;ID=7" class="btn btn-info" onclick="return confirm('Are you sure you want to possess Waqar Javed?');">Possess</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- END EXAMPLE TABLE PORTLET-->

                        <hr class="shop__divider">
                    </div>
                </div>

            </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
</div>



    @include('common.tabletools')






@stop