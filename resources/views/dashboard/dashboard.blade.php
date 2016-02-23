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
                    <h4 class="card-title">My Profile</h4>
                </div>
                <div class="card-block">
                    {!! Form::open(array('url' => '/dashboard', 'id'=>'profileForm','class'=>'form-horizontal','method'=>'post','role'=>'form')) !!}
                    <div id="registration-error" class="alert alert-danger" style="display: none;"></div>

                    @include("common.contactinfo", array("user_detail" => $user_detail, "mobile" => true, "emaillocked" => true))


                    <?= newrow(false, "Profile Photo", "", "", 7); ?>

                    <a href="javascript:void(0);" id="uploadbtn" class="btn btn-success">Browse</a><div id="browseMsg" class="label smRd"></div>


                    <input style="max-width:100%;" type="hidden" name="photo" id="hiddenLogo" value="small-{{ $user_detail->photo }}"/>
                    <img style="max-width:100%;"  id="picture" class="logopic"
                         @if($user_detail->photo)
                         test="assets/images/users/{{ $user_detail->id . "/small-" . $user_detail->photo }}"
                         src="{{ asset('assets/images/users/' . $user_detail->id . "/small-" . $user_detail->photo) ."?" . date('U') }}"/>
                    @else
                        src="{{ asset('assets/images/thumb-didueatdefault.png') ."?" . date('U') }}" />
                    @endif
                    <span id="fullSize" class="smallT"></span>

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

           var pictureW=parseInt(document.getElementById('picture').clientWidth);
           if(pictureW > 450){
              var pictureH=parseInt(document.getElementById('picture').clientHeight);
              var new_pictureH=450/pictureW*pictureH;
              document.getElementById('picture').style.width=450+"px"
              document.getElementById('picture').style.height=new_pictureH+"px";
              document.getElementById('fullSize').innerHTML="Full size image is "+pictureW+" x "+pictureH+" pixels";
           }

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
                        //alert(response);return;
                        var resp = response.split('___');
                        var path = resp[0];
                        var img = resp[1];
                        var imgV = new Image();
                        imgV.src = path;
                        var imgW=0;
                        imgV.onload = function() {
                        var imgW=this.width;
                        var imgH=this.height;
	                       if(imgW > 500){
	                         document.getElementById('picture').style.width="100%";
                          document.getElementById('fullSize').innerHTML="Full size image is "+imgW+" x "+imgH+" pixels";
	                        }
	                        else{
                          document.getElementById('fullSize').innerHTML="";
	                         document.getElementById('picture').style.width=imgW+"px";
	                         document.getElementById('picture').style.height=imgH+"px";
	                        }
                        }
                        document.getElementById('userPhotoTemp').value = path;
                        button.html('Browse');
                        document.getElementById('browseMsg').innerHTML="&nbsp;<span class='instruct bd'>&#8594; </span>Remember to Click Save to Finish Uploading";
                        window.clearInterval(interval);
                        this.enable();
                        $('#picture').attr('src', path);
                        $('#hiddenLogo').val(img);
                    }
                });
            }

            validateform("profileForm", {phone: "phone required"});
        });
    </script>
@stop