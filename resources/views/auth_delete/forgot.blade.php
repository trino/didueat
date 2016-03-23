@extends('layouts.default')
@section('content')
    @if(false)
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12 col-md-offset-3">
                    @if(Session::has('message'))
                        <div class="alert alert-danger">
                            <strong>Error!</strong> &nbsp; {!! Session::get('message') !!}
                        </div>
                    @endif
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <?php printfile("views/auth/forgot.blade.php"); ?>
                    <div class="box-shadow clearfix">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-table"></i> Forgot Password
                            </div>
                        </div>
                        <div class="portlet-body">
                            <h4>Enter your email address</h4>
                            {!! Form::open(array('url' => '/auth/forgot-password', 'id'=>'login-form','class'=>'form-horizontal','method'=>'post','role'=>'form')) !!}
                            <div class="form-group clearfix">
                                <label for="email" class="col-md-2 col-sm-4 col-xs-4 control-label">Email</label>
                                <div class="col-md-10 col-sm-8 col-xs-8">
                                    <div class="input-icon">
                                        <i class="fa fa-envelope"></i>
                                        <input type="email" name="email" class="form-control" id="email" placeholder="Email Address" value="{{ old('email') }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <div class="col-md-offset-2 col-md-10 col-sm-10 col-xs-12">
                                    <button type="submit" class="btn">Send New Password Request</button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <!-- END SAMPLE FORM PORTLET-->
                </div>
            </div>
        </div>
    @endif
@stop