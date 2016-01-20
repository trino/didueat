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
                    


<?php

$new = false;

echo newrow($new, "Email", "", false); ?>
    <input type="text" name="email" class="form-control" disabled placeholder="Email Address" value="{{ $user_detail->email }}" >
                        </div>
                    </div>


<?php

echo newrow($new, "Name", "", true); ?>
    <input type="text" name="name" class="form-control" placeholder="Full Name" value="{{ $user_detail->name }}" required>
                        </div>
                    </div>
                    
                    
<?php

echo newrow($new, "Phone Number", "", false); ?>
    <input type="text" name="phone" class="form-control" placeholder="Phone Number" value="{{ (isset($address_detail->phone))?$address_detail->phone:'' }}" >
                        </div>
                    </div>


<?php

echo newrow($new, "Cell Phone", "", true); ?>
    <input type="text" name="mobile" class="form-control" placeholder="Cell Phone" value="{{ (isset($address_detail->mobile))?$address_detail->mobile:'' }}" required>
                        </div>
                    </div>




<?php

echo newrow($new, " ", "", false); ?>
                            <input type="checkbox" name="subscribed" id="subscribed" value="1" @if($user_detail->subscribed) checked @endif />
                            Sign up for our Newsletter
                        </div>
                    </div>
                    


                    @if(Session::has('session_id'))
<?php

echo newrow($new, "Old Password", "", false); ?>
    <input type="password" name="old_password" class="form-control" id="old_password" placeholder="" autocomplete="off">
                        </div>
                    </div>
                    @endif
                    


<?php

echo newrow($new, "New Password", "", false); ?>
    <input type="password" name="password" class="form-control" id="password" placeholder="" autocomplete="off">
                        </div>
                    </div>



<?php

echo newrow($new, "Re-type Password", "", false); ?>
    <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="" autocomplete="off">
                        </div>
                    </div>
                    


<?php

echo newrow($new, "Profile Photo", "", false); ?>
                            <input type="hidden" name="photo" id="hiddenLogo" value="{{ $user_detail->photo }}"/>
                            <img id="picture" class="logopic"
                            @if($user_detail->photo)
                                src="{{ asset('assets/images/users/' . $user_detail->id . "/" . $user_detail->photo). '?'.mt_rand() }}" >
                            @else
                                src="{{ asset('assets/images/default.png') }}" >
                            @endif
                            <a href="javascript:void(0);" id="uploadbtn" class="btn btn-success">Change Image</a>
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