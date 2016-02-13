delete me
@extends('layouts.default')
@section('content')

            <div class="row">

                @include('layouts.includes.leftsidebar')

                <div class="col-lg-9">
                    <?php printfile("views/dashboard/restaurant/events_log.blade.php"); ?>

                        <div class="card">
                            <div class="card-header">

<h4  class="card-title">
                                Logs</h4>


                            </div>
                            <div class="card-block p-a-0">
                                <table class="table table-responsive">
                                    <thead>
                                    <tr>
                                        <th width="10%">ID</th>
                                        <th width="20%">User</th>
                                        <th width="20%">Datetime</th>
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



@stop