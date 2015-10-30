@extends('layouts.default')
@section('content')


    <div class="content-page">
        <div class="container-fluid">
            <div class="row">
                @include('layouts.includes.leftsidebar')

                <div class="col-xs-12 col-md-10 col-sm-8">
                    @if(\Session::has('message'))
                        <div class="alert {!! Session::get('message-type') !!}">
                            <strong>{!! Session::get('message-short') !!}</strong>
                            &nbsp; {!! Session::get('message') !!}
                        </div>
                    @endif

                    <div class="btn_wrapper margin-bottom-20 clearfix">
                        <a class="btn btn-danger red pull-right fancybox-fast-view" href="#addNewUser">Add New</a>
                    </div>

                    <div class="deleteme">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="box-shadow">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-globe"></i>MY NOTIFICATIONS
                                </div>
                                <div class="tools"></div>
                            </div>
                            <div class="portlet-body">
                                <table class="table table-striped table-bordered table-hover" id="sample_1">
                                    <thead>
                                    <tr>
                                        <th width="10%">ID</th>
                                        <th width="50%">Phone Number/Email Address</th>
                                        <th width="20%">Type</th>
                                        <th width="20%">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($addresses_list as $value)
                                        <tr>
                                            <td>{{ $value->id }}</td>
                                            <td>{{ $value->address }}</td>
                                            <td>{{ $value->type }}</td>
                                            <td>
                                                <a href="{{ url('restaurant/addresses/delete/'.$value->id) }}" class="btn btn-danger red" onclick="return confirm(' Are you sure you want to delete this ? ');">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
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


    <div id="addNewUser" class="col-md-12" style="display: none;">
        <div class="modal-dialog">
            <div class="fancy-modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New</h4>
                </div>
                {!! Form::open(array('url' => '/restaurant/addresses', 'id'=>'addNewForm', 'class'=>'form-horizontal form-restaurants','method'=>'post','role'=>'form')) !!}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label col-md-3">Phone / Email</label>
                                <div class="col-md-9">
                                    <input type="text" name="address" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn blue">Save changes</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    @include('common.tabletools')
@stop