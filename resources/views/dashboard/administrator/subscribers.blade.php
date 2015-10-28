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



    <div id="addNewUser" class="col-md-12 col-sm-12 col-xs-12" style="display: none; width:500px;">
        <div class="modal-dialog2">
            <div class="fancy-modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New</h4>
                </div>
                {!! Form::open(array('url' => '/restaurant/users', 'id'=>'addNewForm', 'class'=>'form-horizontal form-restaurants','method'=>'post','role'=>'form')) !!}
                    @include('common.edituser')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <!-- /.modal-content -->


    <div id="editNewUser" class="col-md-12 col-sm-12 col-xs-12" style="display: none; width:500px;">
        <div class="modal-dialog2">
            <div class="fancy-modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update</h4>
                </div>
                {!! Form::open(array('url' => '/restaurant/users/update', 'name'=>'editForm', 'id'=>'addNewForm', 'class'=>'form-horizontal form-restaurants','method'=>'post','role'=>'form')) !!}
                    <div id="editContents"></div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <!-- /.modal-content -->



    @include('common.tabletools')
    <script>
        $('body').on('click', '.editUser', function(){
            var id = $(this).attr('data-id');
            $.get("{{ url("restaurant/users/edit") }}/"+id, {}, function(result){
                $('#editContents').html(result);
            });
        });
    </script>

@stop