@if(!\Session::has('session_id'))

    <div class="modal" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="loginModalLabel">Log in</h4>
                </div>
                <form role="form" action="{{ url('auth/login') }}" id="login-ajax-form" method="post" class="m-b-0">
                    <div class="modal-body">

                        <?php
                            printfile("views/popups/login.blade.php");
                            $alts = array(
                                "forgot" => "Send a new password to your email address"
                            );
                        ?>

                        <DIV ID="message" align="center"></DIV>
                        {!! csrf_field() !!}
                        <input type="hidden" name="action" value="login">
                        <input type="hidden" name="type" id="login_type" value=""/>
                        <input type="hidden" name="gmt" id="gmt" class="gmt">

                        <DIV id="invalid" class="alert alert-danger m-b-1" style="display: none; margin-bottom: 1rem !important;"></DIV>
                        <DIV id="" class="cleafix" ></DIV>

                        <?= newrow(false, "Email", "", true); ?>
                        <input type="email" name="email" id="login-email" class="form-control" required/>
                        <?=newrow()?>

                        <?= newrow(false, "Password", "", true); ?>
                        <input type="password" name="password" id="login-password" class="form-control" required>

                        <!--p class="m-t-1 m-b-0">
                            <label class="radio-inline c-input c-checkbox">
                                <input type="checkbox" ID="login-remember">
                                <span class="c-indicator"></span>
                                Remember me?
                            </label>
                        </p-->

                        <p class="m-t-0 m-b-1"><a style="font-size: 90%;" href="javascript:void(0);" data-toggle="modal" data-target="#forgotpasswordModal" data-dismiss="modal" title="{{ $alts["forgot"] }}">
                                Forgot Password?
                        </a></p>

                        <?=newrow()?>

                        <input type="hidden" name="url" value="{{ Request::path() }}">
                            <button class="btn btn-primary btn-block" type="submit">Log in</button>
                        <div class="clearfix"></div>
                    </div>

                </form>
            </div>
        </div>
    </div>


    <SCRIPT>
        var visitortime = new Date();
        var visitortimezone = -visitortime.getTimezoneOffset() / 60;
        $(".gmt").val(visitortimezone);

        //save/delete data from the cookie
        $('#login-ajax-form').submit(function (e) {
            if ($("#login-remember").is(":checked")){
                createCookieValue("login-email", $("#login-email").val() );
                createCookieValue("login-password", $("#login-password").val() );
            } else {
                removeCookie("login-email");
                removeCookie("login-password");
            }
        });

        //attempt to get data from the cookie
        $(document).ready(function() {
            if(getCookie("login-email")){
                $("#login-email").val(getCookie("login-email"));
                $("#login-password").val(getCookie("login-password"));
                $("#login-remember").prop('checked', true);
            }
        });
    </SCRIPT>
@endif