@extends('layouts.default')
@section('content')


    <div class="content-page">
        <div class="row">

            @include('layouts.includes.leftsidebar')

            <div class="col-xs-12 col-md-10 col-sm-8">
                <div class="deleteme">

                    <div class="portlet box red">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-globe"></i>Logs List
                            </div>
                            <div class="tools">
                            </div>
                        </div>
                        <div class="portlet-body">
                            <table class="table table-striped table-bordered table-hover" id="sample_1">
                                <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="15%">User</th>
                                    <th width="20%">Date</th>
                                    <th width="60%">Event</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($logs_list as $value)
                                    <tr>
                                        <td>{{ $value->id }}</td>
                                        <td>{{ select_field("profiles", 'id', $value->user_id, "name") }}</td>
                                        <td>{{ $value->date }}</td>
                                        <td>{{ $value->text }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>


@include('common.tabletools')

@stop