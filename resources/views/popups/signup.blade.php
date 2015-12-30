@if(false)
<div id="registration-form" class="col-md-12 popup-dialog" style="display: none;">
    <?php printfile("views/popups/signup.blade.php"); ?>
    
    <div id="registration-success" class="note note-success" style="display: none;">
        <h1 class="block">success</h1>
        <p></p>
    </div>
    
    {!! Form::open(array('url' => '/auth/register', 'id'=>'register-form','class'=>'form-horizontal','method'=>'post','role'=>'form')) !!}
    @include('common.signupform')
    <div class="row">
        <div class="col-lg-8 col-sm-8 col-xs-12 col-md-offset-1 padding-left-0 padding-top-20">
            <button id="regButton" class="btn btn-primary" type="submit">Sign Up</button>
            <br />
            <img id="regLoader" src="{{ asset('assets/images/loader.gif') }}" style="display: none;"/>
            <span>&nbsp;&nbsp;Already have an account? <a href="#login-pop-up" class="fancybox-fast-view">Login here</a></span>
        </div>
    </div>
    {!! Form::close() !!}
</div>

@endif


<div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="signupModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="signupModalLabel">Log in</h4>
            </div>
            <div class="modal-body">

                <?php printfile("views/popups/signup.blade.php"); ?>

                <div id="registration-success" class="note note-success" style="display: none;">
                    <h1 class="block">success</h1>
                    <p></p>
                </div>

                {!! Form::open(array('url' => '/auth/register', 'id'=>'register-form','class'=>'form-horizontal','method'=>'post','role'=>'form')) !!}
                @include('common.signupform')
                <div class="row">
                    <div class="col-lg-8 col-sm-8 col-xs-12 col-md-offset-1 padding-left-0 padding-top-20">
                        <button id="regButton" class="btn btn-primary" type="submit">Sign Up</button>
                        <br />
                        <img id="regLoader" src="{{ asset('assets/images/loader.gif') }}" style="display: none;"/>
                        <span>&nbsp;&nbsp;Already have an account? <a href="#login-pop-up" class="fancybox-fast-view">Login here</a></span>
                    </div>
                </div>
                {!! Form::close() !!}


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
