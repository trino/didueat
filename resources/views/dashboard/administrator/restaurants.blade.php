@extends('layouts.default')
@section('content')

    <div class="content-page">
        <div class="row">
            @include('layouts.includes.leftsidebar')

            <div class="col-xs-12 col-md-10 col-sm-8">
                @if(\Session::has('message'))
                    <div class="alert {!! Session::get('message-type') !!}">
                        <strong>{!! Session::get('message-short') !!}</strong> &nbsp; {!! Session::get('message') !!}
                    </div>
                @endif

                <div class="container-fluid">
                    <a class="btn red pull-right fancybox-fast-view" href="{{ url('restaurant/add/new') }}">Add New</a>
                    <div class="clearfix"></div><br />

                    <div class="box-shadow">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-globe"></i>Restaurants List
                            </div>
                            <div class="tools">
                            </div>
                        </div>
                        <div class="portlet-body">
                            <table class="table table-striped table-bordered table-hover" id="sample_1">
                                <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="10%">Logo</th>
                                    <th width="30%">Name</th>
                                    <th width="10%">Type</th>
                                    <th width="15%">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($restaurants_list as $value)
                                    <?php $resLogo = (isset($value->logo) && $value->logo != "")?'restaurants/'.$value->logo:'default.png'; ?>
                                    <tr>
                                        <td>{{ $value->id }}</td>
                                        <td><img src="{{ asset('assets/images/'.$resLogo) }}" width="90" /></td>
                                        <td>{{ $value->name }}</td>
                                        <td>[@if($value->open == true) OPENED @else CLOSED @endif]</td>
                                        <td>
                                            <a href="{{ url('restaurant/orders/history/'.$value->id) }}" class="btn blue">Orders</a>
                                            <a href="{{ url('restaurant/info/'.$value->id) }}" class="btn btn-info">Edit</a>
                                            @if($value->open == true)
                                                <a href="{{ url('restaurant/list/status/'.$value->id) }}" class="btn btn-warning" onclick="return confirm('Are you sure you want to close <?= addslashes("'" . $value->name . "'"); ?>?');">Close</a>
                                            @else
                                                <a href="{{ url('restaurant/list/status/'.$value->id) }}" class="btn green" onclick="return confirm('Are you sure you want to open <?= addslashes("'" . $value->name . "'"); ?>?');">Open</a>
                                            @endif
                                            <a href="{{ url('restaurant/list/delete/'.$value->id) }}" class="btn btn-primary" onclick="return confirm('Are you sure you want to delete <?= addslashes("'" . $value->name . "'"); ?>?');">Delete</a>
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

    @include('common.tabletools')
@stop