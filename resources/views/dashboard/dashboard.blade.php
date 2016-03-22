@extends('layouts.default')
@section('content')

    <script src="{{ asset('assets/global/scripts/form-validation.js') }}"></script>
 
    <div class="container">
        <?php
            printfile("views/dashboard/dashboard.blade.php");
            $alts = array(
                    "upload" => "Upload a picture",
                    "yourpic" => "Your profile picture"
            );
        ?>
        <div class="row">
            @include('layouts.includes.leftsidebar')

            <div class="col-lg-9">
                <?php printfile("views/dashboard/administrator/dashboard.blade.php"); ?>

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">My Settings</h4>
                    </div>
                    <div class="card-block">
                        {!! Form::open(array('url' => '/dashboard', 'id'=>'profileForm','class'=>'form-horizontal','method'=>'post','role'=>'form')) !!}
                        <div id="registration-error" class="alert alert-danger" style="display: none;"></div>

                        @include("common.contactinfo", array("user_detail" => $user_detail, "mobile" => true, "disabled" => array()))

                        <?= newrow(false, "Profile Photo", "", "", 7); ?>

                        <a href="javascript:void(0);" id="uploadbtn" title="{{ $alts["upload"] }}" class="btn btn-success">Browse</a><div id="browseMsg" class="label smRd"></div>

                        <input type="hidden" name="photo" id="hiddenLogo"/>
                        <img style="max-width:100%;"  id="picture" class="logopic" alt="{{ $alts["yourpic"] }}"
                             @if($user_detail->photo)
                             test="assets/images/users/{{ $user_detail->id . "/small-" . $user_detail->photo }}"
                             src="{{ asset('assets/images/users/' . $user_detail->id . "/small-" . $user_detail->photo) ."?" . date('U') }}"/>
                        @else
                            src="{{ asset('assets/images/small-didueatdefault.png') ."?" . date('U') }}" />
                        @endif
                        <!-- <span id="fullSize" class="smallT"></span> -->

                    </div>
                </div>
            </div>

            <div class="card-footer clearfix">
                <button type="submit" class="btn btn-primary pull-right">Save</button>
                <input name="userPhotoTemp" type="hidden" id="userPhotoTemp"/>
                <input name="user_idDir" id="user_idDir" type="hidden" value="{{ (isset($user_detail->id))?$user_detail->id:'' }}"/>
                <input type="hidden" name="restaurant_id" value="{{ (isset($user_detail->restaurant_id))?$user_detail->restaurant_id:'' }}"/>
                <input type="hidden" name="status" value="{{ (isset($user_detail->status))?$user_detail->status:'' }}"/>
                <input type="hidden" name="adid" value="{{ (isset($address_detail->id))?$address_detail->id:'' }}"/>
            </div>



            {!! Form::close() !!}
        </div>

    </div>

    <script type="text/javascript">
        $(document).ready(function () {
           currentuser = {{ read("id") }};
           validateform("profileForm", {email: "currentuser email", mobile: "phone required"});

            //handle image uploading
            ajaxuploadbtn('uploadbtn');
            function ajaxuploadbtn(button_id) {
                var button = $('#' + button_id), interval;
                act = base_url + 'restaurant/uploadimg/user';
                new AjaxUpload(button, {
                    action: act,
                    name: 'myfile',
                    data: {'_token': $('#profileForm input[name=_token]').val(), 'setSize': 'No'},
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
                    var resp = response.split('___');
                    var path = resp[0];
                    var img = resp[1];

                    document.getElementById('userPhotoTemp').value=path;
//                        button.html('Browse');
                    window.clearInterval(interval);
                    document.getElementById(button_id).style.display="none";
                        $('#picture').attr('src', "{{ asset('assets/images/spacer.gif') }}");
                        document.getElementById('browseMsg').innerHTML="<img src='{{ asset('assets/images/uploaded-checkbox.png') }}' border='0' />&nbsp;<span class='instruct bd'>Click Save to Finish Uploading</span>";
//                        this.enable();
                        $('#hiddenLogo').val(img);
                    }
                });
            }
        });
    </script>
@stop