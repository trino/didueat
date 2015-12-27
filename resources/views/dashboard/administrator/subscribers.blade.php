@extends('layouts.default')
@section('content')

        <div class="row">
            @include('layouts.includes.leftsidebar')
            <div class="col-lg-9">
                <?php printfile("views/dashboard/administrator/subscribers.blade.php"); ?>
                @if(\Session::has('message'))
                    <div class="alert {!! Session::get('message-type') !!}">
                        <strong>{!! Session::get('message-short') !!}</strong> &nbsp; {!! Session::get('message') !!}
                    </div>
                @endif


                    <div class="card">
                        <div class="card-header">


                            Subscribers


                        </div>
                        <div class="card-block p-a-0">
                            <table class="table table-responsive" id="sample_1">
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
                    <!-- END EXAMPLE TABLE PORTLET-->

                </div>
            </div>
        </div>

    <!-- END CONTENT -->

    @include('common.tabletools')

@stop