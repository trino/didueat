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

                <div class="deleteme">

                    <div class="">
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
                                    <th width="20%">Name</th>
                                    <th width="20%">Email</th>
                                    <th width="10%">Type</th>
                                    <th width="15%">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($restaurants_list as $value)
                                    <tr>
                                        <td>{{ $value->id }}</td>
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->email }}</td>
                                        <td>[@if($value->open == true) OPENED @else CLOSED @endif]</td>
                                        <td>

                                            <a href="{{ url('restaurant/orders/history/'.$value->id) }}"
                                               class="btn blue">Orders</a>

                                            <a href="{{ url('restaurant/info/'.$value->id) }}"
                                               class="btn btn-info">Edit</a>

                                            @if($value->open == true)
                                                <a href="{{ url('restaurant/restaurants/status/'.$value->id) }}"
                                                   class="btn btn-warning"
                                                   onclick="return confirm('Are you sure you want to close this Restaurant ?');">Close</a>
                                            @else
                                                <a href="{{ url('restaurant/restaurants/status/'.$value->id) }}"
                                                   class="btn green"
                                                   onclick="return confirm('Are you sure you want to open this Restaurant ?');">Open</a>
                                            @endif
                                            <a href="{{ url('restaurant/restaurants/delete/'.$value->id) }}"
                                               class="btn btn-primary"
                                               onclick="return confirm('Are you sure you want to delete Restaurant One?');">Delete</a>

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