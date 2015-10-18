@extends('layouts.default')
@section('content')

<div class="container"> 
    <div class="row">
        <div class="col-md-8 col-sm-12 col-xs-12 col-md-offset-2">
            @if(Session::has('message'))
            <div class="alert alert-info">
                <strong>Alert!</strong> &nbsp; {!! Session::get('message') !!}
            </div>
            @endif
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-table"></i> Registration Form
                    </div>
                </div>
                <div class="portlet-body">
                    <h4>Please enter all the required fields to proceed!</h4>
                    {!! Form::open(array('url' => '/auth/register', 'id'=>'login-form','class'=>'form-horizontal','method'=>'post','role'=>'form')) !!}
                    @include('common.signupform')
                    {!! Form::close() !!}
                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->
        </div>
    </div>
</div>

@stop