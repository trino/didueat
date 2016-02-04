@if(!\Session::has('session_id'))





    <div class="modal fade  " id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="loginModalLabel">Log in</h4>
                </div>
                <form role="form" action="{{ url('auth/login') }}" id="login-ajax-form" method="post" class="m-b-0">
                    <div class="modal-body m-t-1">

                        <?php printfile("views/popups/login.blade.php"); ?>

                        <DIV ID="message" align="center"></DIV>
                        {!! csrf_field() !!}
                        <input type="hidden" name="action" value="login">
                        <input type="hidden" name="type" id="login_type" value=""/>
                        <input type="hidden" name="gmt" id="gmt" class="gmt">

                        <DIV id="invalid" class="alert alert-danger fade in" style="display: none;"></DIV>

                        <?= newrow(false, "Email", "", true); ?>
                        <input type="email" name="email" class="form-control" placeholder="" required/>
                        <?=newrow()?>

                        <?= newrow(false, "Password", "", true); ?>
                        <input type="password" name="password" class="form-control" placeholder="" required>

                        <p class="m-t-1 m-b-0"><a href="javascript:void(0);" class="" data-toggle="modal" data-target="#forgotpasswordModal"
                              data-dismiss="modal">
                                Forgot Password?
                            </a></p>
                        <?=newrow()?>

                        <input type="hidden" name="url" value="{{ Request::path() }}">

                            <button class="btn btn-primary btn-block" type="submit">Log in</button>


                        <div class="clearfix"></div>
                    </div>
                    <!--div class="modal-footer">




                        <div class="pull-left">
                            Don't have an account?
                            <a class="" href="javascript:void(0);" data-toggle="modal"
                               data-target="#signupModal" data-dismiss="modal">
                                Sign up
                            </a>
                        </div>


                        <div class="clearfix"></div>
                    </div-->
                </form>
            </div>
        </div>
    </div>
    <SCRIPT>
        var visitortime = new Date();
        var visitortimezone = -visitortime.getTimezoneOffset() / 60;
        $(".gmt").val(visitortimezone);
    </SCRIPT>
@endif