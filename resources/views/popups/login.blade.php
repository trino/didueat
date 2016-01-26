@if(!\Session::has('session_id'))
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="loginModalLabel">Log in</h4>
                </div>
                <form role="form" action="{{ url('auth/login') }}" id="login-ajax-form" method="post" class="">
                    <div class="modal-body">
                        <?php printfile("views/popups/login.blade.php"); ?>
                        <DIV ID="message" align="center"></DIV>
                        {!! csrf_field() !!}
                        <input type="hidden" name="action" value="login">
                        <input type="hidden" name="type" id="login_type" value=""/>
                        <input type="hidden" name="gmt" id="gmt" value="">

                        <DIV id="invalid" class="alert alert-danger fade in" style="display: none;"></DIV>


<?php echo newrow(false, "Email Address", "", true); ?>
                                <input type="email" name="email" class="form-control" placeholder="Email Address" required/>
                            </div>
                        </div>
                        
                        
<?php echo newrow(false, "Password", "", true); ?>
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                            </div>
                        </div>

                        <input type="hidden" name="url" value="{{ Request::path() }}">
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:void(0);" class="btn btn-secondary" data-toggle="modal" data-target="#forgotpasswordModal"  data-dismiss="modal">
                            Forgot Password?
                        </a>

                        <a class="btn btn-success" href="javascript:void(0);" data-toggle="modal" data-target="#signupModal"  data-dismiss="modal">
                            Sign up
                        </a>
                        <button class="btn btn-primary" type="submit">Log in</button>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <SCRIPT>
        var visitortime = new Date();
        var visitortimezone = -visitortime.getTimezoneOffset()/60;
        document.getElementById("gmt").value = visitortimezone;
    </SCRIPT>
@endif