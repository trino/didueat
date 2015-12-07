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
                Profile Manager
              </div>
            </div>
            <div class="portlet-body form">
              <!-- BEGIN FORM-->
              {!! Form::open(array('url' => '/dashboard', 'id'=>'profileForm','class'=>'form-horizontal','method'=>'post','role'=>'form')) !!}
              <div class="form-body">
                <div id="registration-error" class="alert alert-danger" style="display: none;"></div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group clearfix">
                    <label for="email" class="col-md-12 col-sm-12 col-xs-12 control-label">Email <span class="required">*</span></label>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <div class="input-icon">
                        <input type="email" name="email" class="form-control readonly" id="email" placeholder="Email Address"
                               value="{{ $user_detail->email }}" readonly>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group clearfix">
                    <label for="name" class="col-md-12 col-sm-12 col-xs-12 control-label">Name <span class="required">*</span></label>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <div class="input-icon">
                        <input type="text" name="name" class="form-control" id="name" placeholder="Full Name" value="{{ $user_detail->name }}"
                               required="">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="caption">
                  Contact Information
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group clearfix">
                    <label for="phone_no" class="col-md-12 col-sm-12 col-xs-12 control-label">Phone Number </label>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <div class="input-icon">
                        <input type="text" name="phone_no" class="form-control" id="phone_no" placeholder="Phone Number"
                               value="{{ (isset($address_detail->phone_no))?$address_detail->phone_no:'' }}">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="portlet-title">
                  <div class="caption">
                    Create Password
                  </div>
                </div>

                @if(Session::has('session_id'))
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group clearfix">
                      <label for="password" class="col-md-12 col-sm-12 col-xs-12 control-label" align="left">Old Password <span
                          class="required">*</span></label>

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
                    <label for="password" class="col-md-12 col-sm-12 col-xs-12 control-label">Choose Password <span class="required">*</span></label>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <div class="input-icon">
                        <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group clearfix">
                    <label for="confirm_password" class="col-md-12 col-sm-12 col-xs-12 control-label">Re-type Password <span class="required">*</span></label>

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
                        <input type="checkbox" name="subscribed" id="subscribed" value="1" @if($user_detail->subscribed) checked @endif />
                        Sign up for our Newsletter
                      </label>
                    </div>
                  </div>
                </div>

                <div class="portlet-title">
                  <div class="caption">
                    Change Photo
                  </div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                  <br/>

                  <div class="col-md-3 col-sm-3 col-xs-12">
                    @if($user_detail->photo)
                      <img id="picture" class="margin-bottom-10" src="{{ asset('assets/images/users/'.$user_detail->photo). '?'.mt_rand() }}" title=""
                           style="width: 100%;">
                    @else
                      <img id="picture" class="margin-bottom-10" src="{{ asset('assets/images/default.png') }}" title="" style="width: 100%;">
                    @endif
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <a href="javascript:void(0);" id="uploadbtn" class="btn btn-success red">Change Image</a>
                  </div>
                  <input type="hidden" name="photo" id="hiddenLogo" value="{{ $user_detail->photo }}" />
                </div>
              </div>

              <div class="form-actions">
                <div class="row">
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="row margin-top-20">
                      <div class="col-xs-offset-0 col-md-9 col-sm-9 col-xs-12">
                        <button type="submit" class="btn red"><i class="fa fa-check"></i> Save Changes</button>
                        <input type="hidden" name="restaurant_id" value="{{ (isset($user_detail->restaurant_id))?$user_detail->restaurant_id:'' }}"/>
                        <input type="hidden" name="status" value="{{ (isset($user_detail->status))?$user_detail->status:'' }}"/>
                        <input type="hidden" name="adid" value="{{ (isset($address_detail->id))?$address_detail->id:'' }}"/>
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