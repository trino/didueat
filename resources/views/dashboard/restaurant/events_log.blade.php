@extends('layouts.default')
@section('content')

            <div class="row">

                @include('layouts.includes.leftsidebar')

                <div class="col-lg-9">
                    <?php printfile("views/dashboard/restaurant/events_log.blade.php"); ?>
                    <div class="deleteme">

                        <div class="box-shadow">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-globe"></i>Logs List
                                </div>
                                <div class="tools">
                                </div>
                            </div>
                            <div class="portlet-body">
                                <table class="table table-striped table-bordered table-responsive" id="sample_1">
                                    <thead>
                                    <tr>
                                        <th width="10%">ID</th>
                                        <th width="20%">User</th>
                                        <th width="20%">Date</th>
                                        <th width="50%">Event</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($logs_list as $value)
                                        <tr>
                                            <td>{{ $value->id }}</td>
                                            <td>{{ select_field("profiles", 'id', $value->user_id, "name") }}</td>
                                            <td>{{ $value->created_at }}</td>
                                            <td>{!! "<b>".$value->type."</b> => ".$value->text !!}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

            </div>


    @include('common.tabletools')
@stop