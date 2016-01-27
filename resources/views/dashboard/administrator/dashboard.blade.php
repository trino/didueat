@extends('layouts.default')
@section('content')

<div class="row">

    @include('layouts.includes.leftsidebar')

    <div class="col-lg-9">
        <?php printfile("views/dashboard/administrator/dashboard.blade.php"); ?>

        <div class="card">
            <div class="card-header">
                <h3>My Personal Profile</h3>
            </div>
            <div class="card-block">
                {!! Form::open(array('url' => '/dashboard', 'id'=>'profileForm','class'=>'form-horizontal','method'=>'post','role'=>'form')) !!}
                    <div id="registration-error" class="alert alert-danger" style="display: none;"></div>

                    @include("common.contactinfo", array("user_detail" => $user_detail, "mobile" => true))



                    <?= newrow(false, "Profile Photo","","",7); ?>

        <a href="javascript:void(0);" id="uploadbtn" class="btn btn-success red">Click to Change Image</a> &nbsp;
                            <input type="hidden" name="photo" id="hiddenLogo" value="{{ $user_detail->photo }}"/>
                            <img id="picture" class="logopic" align="right"
                            @if($user_detail->photo)
                                test="assets/images/users/{{ $user_detail->id . "/" . $user_detail->photo }}"
                                src="{{ asset('assets/images/users/' . $user_detail->id . "/" . $user_detail->photo) }}" >
                            @else
                                src="{{ asset('assets/images/didueatdefault.png') }}" >  
                                <script>
                                    document.getElementById('uploadbtn').innerHTML="Click to Set Your Own Logo";
                                </script>
                            @endif
                        </div>
                    </div>

<hr width="100%" align="center" />

                </div>
                <div class="card-footer clearfix" style="text-align:center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <input name="userPhotoTemp" type="hidden" id="userPhotoTemp" />
                    <input name="user_idDir" id="user_idDir" type="hidden" value="{{ (isset($user_detail->id))?$user_detail->id:'' }}" />
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
                    document.getElementById('userPhotoTemp').value=path;
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