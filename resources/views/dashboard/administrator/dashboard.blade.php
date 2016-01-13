@extends('layouts.default')
@section('content')

<div class="row">

    @include('layouts.includes.leftsidebar')

    <div class="col-lg-9">
        <?php printfile("views/dashboard/administrator/dashboard.blade.php"); ?>

        <div class="card">
            <div class="card-header">
                <h3>My Info</h3>
            </div>
            <div class="card-block">
                    {!! Form::open(array('url' => '/dashboard', 'id'=>'profileForm','class'=>'form-horizontal','method'=>'post','role'=>'form')) !!}

                    <div id="registration-error" class="alert alert-danger" style="display: none;"></div>
                    <div class="form-group row">
                        <label class="col-sm-3">Email</label>
                        <div class="col-sm-9">
                            <input type="email" name="email" class="form-control readonly" id="email" placeholder="Email Address" value="{{ $user_detail->email }}" disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3">Name</label>
                        <div class="col-sm-9">
                            <input type="text" name="name" class="form-control" id="name" placeholder="Full Name" value="{{ $user_detail->name }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3">Phone Number </label>
                        <div class="col-sm-9">
                            <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone Number" value="{{ (isset($address_detail->phone))?$address_detail->phone:'' }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3">Mobile Number </label>
                        <div class="col-sm-9">
                            <input type="text" name="mobile" class="form-control" id="mobile" placeholder="Mobile Number" value="{{ (isset($address_detail->mobile))?$address_detail->mobile:'' }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-9">
                            <input type="checkbox" name="subscribed" id="subscribed" value="1" @if($user_detail->subscribed) checked @endif />
                            Sign up for our Newsletter
                        </div>
                    </div>

                    @if(Session::has('session_id'))
                        <div class="form-group row">
                            <label class="col-sm-3">Password</label>
                            <div class="col-sm-9">
                                <input type="password" name="old_password" class="form-control" id="old_password" placeholder="Old Password" autocomplete="off">
                            </div>
                        </div>
                    @endif

                    <div class="form-group row">
                        <label class="col-sm-3">New Password</label>
                        <div class="col-sm-9">
                            <input type="password" name="password" class="form-control" id="password" placeholder="New Password" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3">Re-type Password</label>
                        <div class="col-sm-9">
                            <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Re-type Password" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3">Profile Photo</label>
                        <div class="col-sm-9">
                            <a href="javascript:void(0);" id="uploadbtn" class="btn btn-success">Change Image</a>
                            <input type="hidden" name="photo" id="hiddenLogo" value="{{ $user_detail->photo }}"/>
                            @if($user_detail->photo)
                                <img id="picture" style="max-width:100%;"
                                     src="{{ asset('assets/images/users/'.$user_detail->photo). '?'.mt_rand() }}" >
                            @else
                                <img id="picture" class="" src="{{ asset('assets/images/default.png') }}"
                                     title="" style="max-width:100%;" />
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <button type="submit" class="btn btn-primary pull-right">Submit</button>
                    <input type="hidden" name="restaurant_id" value="{{ (isset($user_detail->restaurant_id))?$user_detail->restaurant_id:'' }}"/>
                    <input type="hidden" name="status" value="{{ (isset($user_detail->status))?$user_detail->status:'' }}"/>
                    <input type="hidden" name="adid" value="{{ (isset($address_detail->id))?$address_detail->id:'' }}"/>    
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
    $(document).ready(function () {

        setTimeout(function () {$(":password").val("");}, 500 );

        ajaxuploadbtn('uploadbtn');

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
    });
</script>
@stop