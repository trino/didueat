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
                            @include('common.signupform')
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