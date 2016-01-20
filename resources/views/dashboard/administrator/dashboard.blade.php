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

                    @include("common.contactinfo", array("user_detail" => $user_detail))

                    <?= newrow(false, "Profile Photo"); ?>
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