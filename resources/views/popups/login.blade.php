


<div id="login-pop-up" style="display:none;width:500px;">
    <div class="login-pop-up">
            <div class="login-form" style="">





                <h1>Login</h1>

                <div class="col-md-12 col-sm-12 col-xs-12">


                <DIV ID="message" align="center"></DIV>
                <form role="form" action="" id="login-ajax-form" method="post"
                      class="form-horizontal form-without-legend">
                    {!! csrf_field() !!}
                    <input type="hidden" name="action" value="login">
                    <input type="hidden" name="type" id="login_type" value=""/>

                    <p style="display: none;text-align:center; color: red;" id="invalid"></p>

                    <div class="form-group">


                            <div class="input-icon">
                                <i class="fa fa-envelope"></i>
                                <input type="email" name="email" class="form-control" id="email"
                                       placeholder="Email Address" required/>
                            </div>
                    </div>
                    <div class="form-group">

                            <div class="input-icon">
                                <i class="fa fa-lock"></i>
                                <input type="password" name="password" class="form-control" id="password"
                                       placeholder="Password" required>
                            </div>
                    </div>

                    <div class="form-group">
                            <input class="btn btn-primary" type="button" Value="Login"
                                   onclick="trylogin(); return false;"><br>

                    </div>
                    <div class="form-group">
                            <a href="#forget-passsword" class="fancybox-fast-view">Forgot Password?</a><br>
                            <span>Don't have account? </span> <a href="#registration-form" class="fancybox-fast-view" type="button">Sign Up</a>
                    </div>



                    <div class="clearfix"></div>
                </form>






            </div>

        </div>

    </div>
</div>


