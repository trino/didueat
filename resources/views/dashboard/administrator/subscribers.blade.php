@extends('layouts.default')
@section('content')


    <div class="content-page">
        <div class="row">
            @include('layouts.includes.leftsidebar')
            <div class="col-xs-12 col-md-10 col-sm-8">
                <?php printfile("views/dashboard/administrator/subscribers.blade.php"); ?>
                @if(\Session::has('message'))
                    <div class="alert {!! Session::get('message-type') !!}">
                        <strong>{!! Session::get('message-short') !!}</strong> &nbsp; {!! Session::get('message') !!}
                    </div>
                @endif

                <div class="deleteme">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="box-shadow">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-globe"></i>Subscribers List
                            </div>
                            <div class="tools">
                            </div>
                        </div>
                        <div class="portlet-body">
                            <table class="table table-striped table-bordered table-hover" id="sample_1">
                                <thead>
                                    <tr>
                                        <th width="10%">ID</th>
                                        <th width="50%">Email</th>
                                        <th width="20%">Subscribed Date</th>
                                        <th width="20%">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($list as $value)
                                    <tr>
                                        <td>{{ $value->id }}</td>
                                        <td>{{ $value->email }}</td>
                                        <td>{{ date('d M, Y', strtotime($value->created_at)) }}</td>
                                        <td>{{ ($value->status == 1)?"Active":"Inactive" }}</td>
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
    <!-- END CONTENT -->

    @include('common.tabletools')

@stop