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
            <form role="form" action="" id="login-ajax-form" method="post"
                  class="">
                <div class="modal-body">


                    <DIV ID="message" align="center"></DIV>

                    {!! csrf_field() !!}
                    <input type="hidden" name="action" value="login">
                    <input type="hidden" name="type" id="login_type" value=""/>

                    <p id="invalid"></p>

                    <div class="form-group row">
                        <label class="col-sm-3">Email</label>

                        <div class="col-sm-9">

                            <input type="email" name="email" class="form-control" id="email" placeholder="Email Address"
                                   required/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3">Password</label>

                        <div class="col-sm-9">

                            <input type="password" name="password" class="form-control" id="password"
                                   placeholder="Password" required>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">


                    <a href="javascript:void(0);" class="btn btn-secondary" data-toggle="modal"
                       data-target="#forgotpasswordModal"  data-dismiss="modal">
                        Forgot Password?
                    </a>

                    <a class="btn btn-warning" href="javascript:void(0);" data-toggle="modal"
                       data-target="#signupModal"  data-dismiss="modal">
                        Sign up
                    </a>
                    <button class="btn btn-primary" type="submit">Log in</button>

                    <div class="clearfix"></div>

                </div>

            </form>

        </div>
    </div>
</div>
