
@extends('layouts.default')
@section('content')

    <div class="content-page">
        <div class="container-fluid">
            <div class="row">

                @include('layouts.includes.leftsidebar')

                <div class="col-xs-12 col-md-10 col-sm-8">

                    @if(\Session::has('message'))
                        <div class="alert {!! Session::get('message-type') !!}">
                            <strong>{!! Session::get('message-short') !!}</strong>
                            &nbsp; {!! Session::get('message') !!}
                        </div>
                    @endif

                    <div class="box-shadow">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i> Profile Manager
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <!-- BEGIN FORM-->
                            {!! Form::open(array('url' => '/dashboard', 'id'=>'profileForm','class'=>'form-horizontal','method'=>'post','role'=>'form')) !!}
                            <div class="form-body">
                                <div id="registration-error" class="alert alert-danger" style="display: none;"></div>

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group clearfix">
                                        <label for="name" class="col-md-12 col-sm-12 col-xs-12 control-label">Name <span class="require">*</span></label>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="input-icon">
                                                <input type="text" name="name" class="form-control" id="name" placeholder="Full Name" value="{{ $user_detail->name }}" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group clearfix">
                                        <label for="email" class="col-md-12 col-sm-12 col-xs-12 control-label">Email <span class="require">*</span></label>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="input-icon">
                                                <input type="email" name="email" class="form-control" id="email" placeholder="Email Address" value="{{ $user_detail->email }}" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="caption">
                                    <i class="fa fa-gift"></i> Addressing Information
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group clearfix">
                                        <label for="address" class="col-md-12 col-sm-12 col-xs-12 control-label">Street Address</label>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="input-icon">
                                                <input type="text" name="address" class="form-control" id="address" placeholder="Street Address" value="{{ (isset($address_detail->address))?$address_detail->address:'' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group clearfix">
                                        <label for="post_code" class="col-md-12 col-sm-12 col-xs-12 control-label">Postal Code</label>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="input-icon">
                                                <input type="text" name="post_code" class="form-control" id="post_code" placeholder="Postal Code" value="{{ (isset($address_detail->post_code))?$address_detail->post_code:'' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group clearfix">
                                        <label for="city" class="col-md-12 col-sm-12 col-xs-12 control-label">City</label>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="input-icon">
                                                <input type="text" name="city" class="form-control" id="city" placeholder="City" value="{{ (isset($address_detail->city))?$address_detail->city:'' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group clearfix">
                                        <label for="phone_no" class="col-md-12 col-sm-12 col-xs-12 control-label">Phone Number </label>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="input-icon">
                                                <input type="text" name="phone_no" class="form-control" id="phone_no" placeholder="Phone Number" value="{{ (isset($address_detail->phone_no))?$address_detail->phone_no:'' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group clearfix">
                                        <label for="province" class="col-md-12 col-sm-12 col-xs-12 control-label">Province</label>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="input-icon">
                                                <input type="text" name="province" class="form-control" id="province" placeholder="Province" value="{{ (isset($address_detail->province))?$address_detail->province:'' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group clearfix">
                                        <label for="country" class="col-md-12 col-sm-12 col-xs-12 control-label">Country</label>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="input-icon">
                                                <select name="country" id="country" class="form-control">
                                                    <option value="">-Select One-</option>
                                                    @foreach(select_field_where('countries', '', false, "name", $Dir = "ASC", "") as $value)
                                                        <option value="{{ $value->id }}" @if(isset($address_detail->country) && $address_detail->country == $value->id) selected @endif>{{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-gift"></i> Create Password
                                    </div>
                                </div>

                                @if(Session::has('session_id'))
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group clearfix">
                                            <label for="password" class="col-md-12 col-sm-12 col-xs-12 control-label">Old Password<span class="require">*</span></label>

                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="input-icon">
                                                    <input type="password" name="old_password" class="form-control" id="old_password" placeholder="Old Password">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group clearfix">
                                        <label for="password" class="col-md-12 col-sm-12 col-xs-12 control-label">Choose Password<span class="require">*</span></label>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="input-icon">
                                                <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group clearfix">
                                        <label for="confirm_password" class="col-md-12 col-sm-12 col-xs-12 control-label">Re-type Password<span class="require">*</span></label>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="input-icon">
                                                <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Re-type Password">
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group clearfix">
                                        <label for="subscribed" class="col-md-12 col-sm-12 col-xs-12 control-label">&nbsp;</label>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label>
                                                <input type="checkbox" name="subscribed" id="subscribed" value="1" <?php if (read('subscribed')) { echo ' checked'; } ?> />
                                                Sign up for our Newsletter
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-gift"></i> Change Photo
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <br />
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        @if($user_detail->photo)
                                            <img id="picture" class="margin-bottom-10" src="{{ asset('assets/images/users/'.$user_detail->photo). '?'.mt_rand() }}" title="" style="width: 100%;">
                                        @else
                                            <img id="picture" class="margin-bottom-10" src="{{ asset('assets/images/default.png') }}" title="" style="width: 100%;">
                                        @endif
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <a href="javascript:void(0);" id="uploadbtn" class="btn btn-success red">Change Image</a>
                                    </div>
                                    <input type="hidden" name="photo" id="hiddenLogo"/>
                                </div>
                            </div>

                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="row margin-top-20">
                                            <div class="col-xs-offset-0 col-md-9 col-sm-9 col-xs-12">
                                                <button type="submit" class="btn red"><i class="fa fa-check"></i> Save Changes</button>
                                                <input type="hidden" name="restaurant_id" value="{{ (isset($user_detail->restaurant_id))?$user_detail->restaurant_id:'' }}" />
                                                <input type="hidden" name="status" value="{{ (isset($user_detail->status))?$user_detail->status:'' }}" />
                                                <input type="hidden" name="adid" value="{{ (isset($address_detail->id))?$address_detail->id:'' }}" />
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
    </div>


    <script type="text/javascript">
        $(document).ready(function(){
            ajaxuploadbtn('uploadbtn');

        });
        function ajaxuploadbtn(button_id) {
            var button = $('#' + button_id), interval;
            act = base_url + 'restaurant/uploadimg/user';
            new AjaxUpload(button, {
                action: act,
                name: 'myfile',
                data: {'_token': $('#profileForm input[name=_token]').val()},
                onSubmit: function (file, ext) {
                    button.text('Uploading...');
                    this.disable();
                    interval = window.setInterval(function () {
                        var text = button.text();
                        if (text.length < 13) {
                            button.text(text + '.');
                        } else {
                            button.text('Uploading...');
                        }
                    }, 200);
                },
                onComplete: function (file, response) {
                    //alert(response);return;
                    var resp = response.split('___');
                    var path = resp[0];
                    var img = resp[1];
                    button.html('Change Image');

                    window.clearInterval(interval);
                    this.enable();
                    $('#picture').attr('src', path);
                    $('#hiddenLogo').val(img);
                }
            });
        }
    </script>
@stop