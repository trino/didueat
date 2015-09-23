@extends('layouts.default')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if(Session::has('message'))
            <div class="alert alert-info">
                <strong>Alert!</strong> &nbsp; {!! Session::get('message') !!}
            </div>
            @endif
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet box red">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-table"></i> Registration Form
                    </div>
                </div>
                <div class="portlet-body">
                    <h4>Please enter all the required fields to proceed!</h4>
                    {!! Form::open(array('url' => '/auth/register', 'id'=>'login-form','class'=>'form-horizontal','method'=>'post','role'=>'form')) !!}
                    <div class="form-group">
                        <label for="name" class="col-md-2 control-label">Name</label>
                        <div class="col-md-10">
                            <div class="input-icon">
                                <i class="fa fa-user"></i>
                                <input type="text" name="name" class="form-control" id="name" placeholder="Full Name" value="{{ old('name') }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-md-2 control-label">Email</label>
                        <div class="col-md-10">
                            <div class="input-icon">
                                <i class="fa fa-envelope"></i>
                                <input type="email" name="email" class="form-control" id="email" placeholder="Email Address" value="{{ old('email') }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-md-2 control-label">Password</label>
                        <div class="col-md-10">
                            <div class="input-icon">
                                <i class="fa fa-key"></i>
                                <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password" class="col-md-2 control-label">Re-type Password</label>
                        <div class="col-md-10">
                            <div class="input-icon">
                                <i class="fa fa-key"></i>
                                <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Re-type Password">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone" class="col-md-2 control-label">Phone</label>
                        <div class="col-md-10">
                            <div class="input-icon">
                                <i class="fa fa-phone"></i>
                                <input type="tel" name="phone" class="form-control" id="phone" placeholder="Phone number" value="{{ old('phone') }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone" class="col-md-2 control-label">&nbsp;</label>
                        <div class="col-md-10">
                            <label>
                                <input type="checkbox" name="subscribed" value="1" />
                                Sign up for our Newsletter
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-10">
                            <button type="submit" class="btn red">Sign up</button>
                            &nbsp;
                            <span>Already have account ? </span>
                            <a href="{{ url('auth/login') }}">Login here</a>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->
        </div>
    </div>
</div>

@stop