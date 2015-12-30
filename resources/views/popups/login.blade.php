@if(false)
    <div id="login-pop-up" class="popup-dialog" style="display:none;">
        <?php printfile("views/popups/login.blade.php"); ?>
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

                        <p id="invalid"></p>

                        <div class="form-group">
                            <div class="input-icon">
                                <input type="email" name="email" class="form-control" id="email"
                                       placeholder="Email Address" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-icon">
                                <input type="password" name="password" class="form-control" id="password"
                                       placeholder="Password" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" Value="Login"><br>
                        </div>
                        <div class="form-group">
                            <a href="#forget-passsword" class="fancybox-fast-view">Forgot Password?</a><br>
                            <span>Don't have account? </span> <a href="#registration-form" class="fancybox-fast-view"
                                                                 type="button">Sign Up</a>
                        </div>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif



<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="loginModalLabel">Log in</h4>
            </div>
            <div class="modal-body">


                <DIV ID="message" align="center"></DIV>
                <form role="form" action="" id="login-ajax-form" method="post"
                      class="form-horizontal form-without-legend">
                    {!! csrf_field() !!}
                    <input type="hidden" name="action" value="login">
                    <input type="hidden" name="type" id="login_type" value=""/>

                    <p id="invalid"></p>

                    <div class="form-group">
                        <div class="input-icon">
                            <input type="email" name="email" class="form-control" id="email" placeholder="Email Address"
                                   required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon">
                            <input type="password" name="password" class="form-control" id="password"
                                   placeholder="Password" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <input class="btn btn-primary" type="submit" Value="Login"><br>
                    </div>
                    <div class="form-group">
                        <!--a href="#forget-passsword" class="fancybox-fast-view">Forgot Password?</a><br-->


                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                data-target="#forgotpasswordModal">
                            Forgot Password?
                        </button>


                        <!--span>Don't have account? </span> <a href="#registration-form" class="fancybox-fast-view" type="button">Sign Up</a-->


                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#signupModal">
                            Sign up
                        </button>


                    </div>
                    <div class="clearfix"></div>
                </form>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
