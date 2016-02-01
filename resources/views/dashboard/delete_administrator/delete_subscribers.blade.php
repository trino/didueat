@extends('layouts.default')
@section('content')

        <div class="row">
            @include('layouts.includes.leftsidebar')
            <div class="col-lg-9">
                <?php printfile("views/dashboard/administrator/subscribers.blade.php"); ?>
                    <div class="card">
                        <div class="card-header">
                            Subscribers
                        </div>

                        <div class="card-block p-a-0">
                            <table class="table table-responsive m-b-0">
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


@stop