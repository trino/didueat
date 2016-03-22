@extends('layouts.default')
@section('content')
    @if(false)
        <div class="container">
            <?php printfile("views/auth/login.blade.php"); ?>
            <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12 col-md-offset-3">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class="box-shadow clearfix">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-table"></i> Login Form
                            </div>
                        </div>
                        <div class="portlet-body">
                            <h4>Enter username & password to login</h4>
                            {!! Form::open(array('url' => '/auth/login', 'id'=>'login-form','class'=>'form-horizontal','method'=>'post','role'=>'form')) !!}
                            <div class="form-group clearfix">
                                <label for="inputEmail12" class="col-md-2 col-sm-2 col-xs-4 control-label">Email</label>
                                <div class="col-md-10 col-sm-10 col-xs-8">
                                    <div class="input-icon">
                                        <i class="fa fa-envelope"></i>
                                        <input type="email" name="email" class="form-control" id="email" placeholder="Email Address" value="{{ old('email') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label for="password" class="col-md-2 col-sm-2 col-xs-4 control-label">Password</label>
                                <div class="col-md-10 col-sm-10 col-xs-8">
                                    <div class="input-icon">
                                        <i class="fa fa-lock"></i>
                                        <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <div class="col-md-offset-2 col-md-10 col-sm-10 col-xs-12">
                                    <span>Forgot your account password? </span>
                                    <a href="{{ url('auth/forgot-password') }}">Click here</a>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <div class="col-md-offset-2 col-md-10 col-sm-10 col-xs-12">
                                    <button type="submit" class="btn">Sign in</button>
                                    &nbsp;
                                    <span>Don't have account? </span>
                                    <a href="{{ url('auth/register') }}">Create here</a>
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