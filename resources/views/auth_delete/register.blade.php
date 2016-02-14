@extends('layouts.default')
@section('content')

@if(false)
    <div class="container">
        <?php printfile("views/auth/register.blade.php"); ?>
        <div class="row">
            <div class="col-md-8 col-sm-12 col-xs-12 col-md-offset-2 margin-bottom-20">
                @if(Session::has('message'))
                <div class="alert alert-info">
                    <strong>Alert!</strong> &nbsp; {!! Session::get('message') !!}
                </div>
                @endif
                <!-- BEGIN SAMPLE FORM PORTLET-->
                <div class="box-shadow clearfix">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-table"></i> Registration Form
                        </div>
                    </div>
                    <div class="portlet-body">
                        <h4>Please enter all the required fields to proceed!</h4>
                        {!! Form::open(array('url' => '/auth/register', 'id'=>'login-form','class'=>'form-horizontal','method'=>'post','role'=>'form')) !!}
                        @include('common.contactinfo')
                        {!! Form::close() !!}
                    </div>
                </div>
                <!-- END SAMPLE FORM PORTLET-->
            </div>
        </div>
    </div>
@endif
@stop