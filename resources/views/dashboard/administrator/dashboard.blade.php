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

                <div class="portlet box red">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-gift"></i>Profile Manage
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                        {!! Form::open(array('url' => '/dashboard', 'id'=>'profileForm','class'=>'form-horizontal','method'=>'post','role'=>'form')) !!}
                        <div class="form-body">
                            <div class="alert alert-danger display-hide">
                                <button class="close" data-close="alert"></button>
                                You have some form errors. Please check below.
                            </div>
                            <div class="alert alert-success display-hide">
                                <button class="close" data-close="alert"></button>
                                Your form validation is successful!
                            </div>

                            <h3 class="form-section">Person Info</h3>

                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-5 col-xs-12">Full Name <span
                                            class="required">*</span></label>

                                <div class="col-md-5 col-sm-5 col-xs-12">
                                    <input type="text" name="name" class="form-control" placeholder="Full Name"
                                           value="{{ Session::get('session_name') }}" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-5 col-xs-12">Email Address <span
                                            class="required">*</span></label>

                                <div class="col-md-5 col-sm-5 col-xs-12">
                                    <input type="email" name="email" class="form-control" placeholder="Email Address"
                                           value="{{ Session::get('session_email') }}" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-5 col-xs-12">Phone <span
                                            class="required">*</span></label>

                                <div class="col-md-5 col-sm-5 col-xs-12">
                                    <input type="number" name="phone" class="form-control" placeholder="Phone"
                                           value="{{ Session::get('session_phone') }}" required/>
                                </div>
                            </div>

                            <h3 class="form-section">Change Password</h3>

                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-5 col-xs-12">Old Password</label>

                                <div class="col-md-5 col-sm-5 col-xs-12">
                                    <input type="password" name="old_password" class="form-control"
                                           placeholder="Old Password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-5 col-xs-12">New Password</label>

                                <div class="col-md-5 col-sm-5 col-xs-12">
                                    <input type="password" name="new_password" class="form-control"
                                           placeholder="New Password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-5 col-sm-5 col-xs-12">Confirm password</label>

                                <div class="col-md-5 col-sm-5 col-xs-12">
                                    <input type="password" name="confirm_password" class="form-control"
                                           placeholder="Confirm password">
                                </div>
                            </div>

                            <h3 class="form-section">Newsletter Setting</h3>

                            <div class="checkbox form-group margin-bottom-20">
                                <label class="col-md-5 col-sm-5 col-xs-12 control-label" for="newsletter"></label>

                                <div class="col-md-5 col-sm-5 col-xs-12">
                                    <div class="checker">
                                                <span>
                                                    <label class="control-label" id="newsletter_label" for="newsletter">
                                                        <input type="checkbox" name="subscribed" id="newsletter"
                                                               class="form-control"
                                                               @if(Session::has('session_subscribed') && Session::get('session_subscribed') == true) checked @endif>
                                                        Sign up for our Newsletter
                                                    </label>
                                                </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9 col-sm-9 col-xs-12">
                                            <button type="submit" class="btn red"><i class="fa fa-check"></i> Save
                                                Changes
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}

                    </div>
                </div>


            </div>

        </div>
    </div>


@stop