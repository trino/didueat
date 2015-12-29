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
            <div class="modal-body" id="signupModalBody">

                <?php printfile("views/popups/signup.blade.php"); ?>

                <div id="registration-success" class="note note-success" style="display: none;">
                    <h1 class="block">success</h1>

                    <p></p>
                </div>

                {!! Form::open(array('url' => '/auth/register', 'id'=>'register-form','class'=>'form-horizontal','method'=>'post','role'=>'form')) !!}
                @include('common.signupform')
                @include('common.editaddress', array("required" => false, "apartment" => true))

                <img id="regLoader" src="{{ asset('assets/images/loader.gif') }}" style="display: none;"/>

            </div>
            <div class="modal-footer">
                <div class="pull-left">
                    Already have an account?    <a href="javascript:void(0);" data-toggle="modal"  data-dismiss="modal" data-target="#loginModal">
                        Log in
                    </a>
                </div>

                <button id="regButton" class="btn btn-primary" type="submit" onclick="$('.editaddress').hide();">Sign Up</button>
                {!! Form::close() !!}

            </div>
        </div>
    </div>
</div>