


<div id="login-pop-up" style="display:none;">
    <div class="login-pop-up">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="login-form">







                <h1>Login</h1>

                <DIV ID="message" align="center"></DIV>
                <form role="form" action="" id="login-ajax-form" method="post"
                      class="form-horizontal form-without-legend">
                    {!! csrf_field() !!}
                    <input type="hidden" name="action" value="login">
                    <input type="hidden" name="type" id="login_type" value=""/>

                    <p style="display: none;text-align:center; color: red;" id="invalid"></p>

                    <div class="form-group">
                        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label" for="email">
                            Email <span class="require">*</span>
                        </label>

                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                            <div class="input-icon">
                                <i class="fa fa-envelope"></i>
                                <input type="email" name="email" class="form-control" id="email"
                                       placeholder="Email Address" required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label" for="password">Password <span
                                    class="require">*</span></label>

                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                            <div class="input-icon">
                                <i class="fa fa-lock"></i>
                                <input type="password" name="password" class="form-control" id="password"
                                       placeholder="Password" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 col-md-offset-3 padding-left-10">
                            <span>Forgot your account password? </span>
                            <a href="#forget-passsword" class="fancybox-fast-view">Forgot Password?</a>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 col-md-offset-3 padding-left-10 padding-top-10">
                            <input class="btn btn-primary" type="button" Value="Login"
                                   onclick="trylogin(); return false;">
                            <span>Don't have account? </span> <a href="#registration-form" class="fancybox-fast-view"
                                                                 type="button">Sign Up</a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </form>






            </div>

        </div>

    </div>
</div>


