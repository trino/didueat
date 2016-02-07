@extends('layouts.default')
@section('content')



    <script src="{{ asset('assets/global/scripts/form-validation.js') }}"></script>


    <div class="container">
        <?php printfile("views/dashboard/dashbaord.blade.php"); ?>
    <div class="row">
        @include('layouts.includes.leftsidebar')

        <div class="col-lg-9">
            <?php printfile("views/dashboard/administrator/dashboard.blade.php"); ?>

            <div class="card">
                <div class="card-header">
                    <h4>My Profile</h4>
                </div>
                <div class="card-block">
                    {!! Form::open(array('url' => '/dashboard', 'id'=>'profileForm','class'=>'form-horizontal','method'=>'post','role'=>'form')) !!}
                    <div id="registration-error" class="alert alert-danger" style="display: none;"></div>

                    @include("common.contactinfo", array("user_detail" => $user_detail, "mobile" => true, "emaillocked" => true))


                    <?= newrow(false, "Profile Photo", "", "", 7); ?>

                    <a href="javascript:void(0);" id="uploadbtn" class="btn btn-success">Upload</a>


                    <input type="hidden" name="photo" id="hiddenLogo" value="{{ $user_detail->photo }}"/>
                    <img id="picture" class="logopic"
                         @if($user_detail->photo)
                         test="assets/images/users/{{ $user_detail->id . "/" . $user_detail->photo }}"
                         src="{{ asset('assets/images/users/' . $user_detail->id . "/" . $user_detail->photo) }}"/>
                    @else
                        src="{{ asset('assets/images/didueatdefault.png') }}" />
                        <script>
                            document.getElementById('uploadbtn').innerHTML = "Update";
                        </script>
                    @endif
                </div>
            </div>
        </div>

        <div class="card-footer clearfix" style="">
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
    </div>
    </div>













    <script type="text/javascript">
        $(document).ready(function () {

            setTimeout(function () {
                $(":password").val("");
            }, 500);

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
                        document.getElementById('userPhotoTemp').value = path;
                        button.html('Click Submit to Save Photo');
                        window.clearInterval(interval);
                        this.enable();
                        $('#picture').attr('src', path);
                        $('#hiddenLogo').val(img);
                    }
                });
            }

            add_all(true, true, true);
            $("#profileForm").validate({
                rules: {
                    phone: {
                        required: true,
                        checkPhone: true,
                        checkLen: true
                    }/*,
                    email: {
                        required: true,
                        email: true,
                        remote: {
                            url: "{{ url('auth/validate/email/ajax') }}",
                            type: "post"
                        }
                    }*/
                },
                messages: {
                    phone: {
                        required: "Please enter a phone number",
                        checkPhone: "Invalid character. Please just use numbers and hyphens",
                        checkLen: "Phone number must be 10 numbers long"
                    }
                },
                email: {
                    required: "Please enter an email address!",
                    remote: "This email address is already in use!"
                }
            });
        });
    </script>
@stop