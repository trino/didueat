<div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="signupModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="signupModalLabel">Sign up</h4>
            </div>
            <div id="registration-error" style="display: none;"></div>
            <div id="registration-success" class="note note-success" style="display: none;">
                <?php printfile("views/popups/signup.blade.php (success popup)"); ?>
                <h1 class="block">success</h1>
                <P></P>
            </div>
            {!! Form::open(array('url' => '/auth/register', 'id'=>'register-form','class'=>'form-horizontal','method'=>'post','role'=>'form')) !!}
            <div class="modal-body" id="signupModalBody">
                <?php printfile("views/popups/signup.blade.php"); ?>
                <div class="editaddress">
                    @include('common.signupform', array("new" => true))
                </div>
            </div>
            <img id="regLoader" src="{{ asset('assets/images/loader.gif') }}" style="display: none;"/>
            <div class="modal-footer">
                <div id="actionBtn">
                    <div class="pull-left">
                        Already have an account?
                        <a href="javascript:void(0);" data-toggle="modal"  data-dismiss="modal" data-target="#loginModal">
                            Log in
                        </a>
                    </div>
                    <button id="regButton" class="btn btn-primary" type="submit">Sign Up</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>