@extends('layouts.default')
@section('content')


    <div class="row">

        @include('layouts.includes.leftsidebar')

        <div class="col-lg-9">
            <?php printfile("views/dashboard/administrator/dashboard.blade.php"); ?>
            @if(\Session::has('message'))
                <div class="alert {!! Session::get('message-type') !!}">
                    <strong>{!! Session::get('message-short') !!}</strong>
                    &nbsp; {!! Session::get('message') !!}
                </div>
            @endif

            <div class="card">
                <div class="card-header bg-primary">


                   My Info



                </div>
                <div class="card-block">


                    {!! Form::open(array('url' => '/dashboard', 'id'=>'profileForm','class'=>'form-horizontal','method'=>'post','role'=>'form')) !!}
                    <div id="registration-error" class="alert alert-danger" style="display: none;"></div>

                    <label>Email</label>
                    <input type="email" name="email" class="form-control readonly" id="email"
                           placeholder="Email Address"
                           value="{{ $user_detail->email }}" readonly>
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Full Name"
                           value="{{ $user_detail->name }}"
                           >
                    <label>Phone Number </label>
                    <input type="text" name="phone_no" class="form-control" id="phone_no" placeholder="Phone Number"
                           value="{{ (isset($address_detail->phone_no))?$address_detail->phone_no:'' }}">
                    <label>Mobile Number </label>
                    <input type="text" name="mobile" class="form-control" id="mobile" placeholder="Mobile Number"
                           value="{{ (isset($address_detail->mobile))?$address_detail->mobile:'' }}">

                    <label>
                        Create Password
                    </label>

                    @if(Session::has('session_id'))
                        <label>Old Password</label>
                        <input type="password" name="old_password" class="form-control" id="old_password"
                               placeholder="Old Password">
                    @endif

                    <label>Re-type Password</label>
                    <input type="password" name="confirm_password" class="form-control" id="confirm_password"
                           placeholder="Re-type Password">
                        <input type="checkbox" name="subscribed" id="subscribed" value="1"
                               @if($user_detail->subscribed) checked @endif />
                        Sign up for our Newsletter


                    <h3>Change Photo</h3>
                    @if($user_detail->photo)
                        <img id="picture" class=""
                             src="{{ asset('assets/images/users/'.$user_detail->photo). '?'.mt_rand() }}" title=""
                             style="">
                    @else
                        <img id="picture" class="" src="{{ asset('assets/images/default.png') }}"
                             title="" style="">
                    @endif

                    <a href="javascript:void(0);" id="uploadbtn" class="btn btn-success">Change Image</a>


                    <input type="hidden" name="photo" id="hiddenLogo" value="{{ $user_detail->photo }}"/>


                    <button type="submit" class="btn red"><i class="fa fa-check"></i> Save Changes</button>
                    <input type="hidden" name="restaurant_id"
                           value="{{ (isset($user_detail->restaurant_id))?$user_detail->restaurant_id:'' }}"/>
                    <input type="hidden" name="status"
                           value="{{ (isset($user_detail->status))?$user_detail->status:'' }}"/>
                    <input type="hidden" name="adid" value="{{ (isset($address_detail->id))?$address_detail->id:'' }}"/>
                {!! Form::close() !!}


            </div>
        </div>
    </div>


    <script type="text/javascript">
        $(document).ready(function () {
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