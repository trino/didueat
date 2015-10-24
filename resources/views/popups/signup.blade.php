<div id="registration-form" class="col-md-12" style="width:500px;display: none;">
    <div id="registration-success" class="note note-success" style="display: none;">
        <h1 class="block">success</h1>

        <p></p>
    </div>
    {!! Form::open(array('url' => '/auth/register', 'id'=>'register-form','class'=>'form-horizontal','method'=>'post','role'=>'form')) !!}
    <h1>Sign up</h1>

    <div id="registration-error" class="alert alert-danger" style="display: none;"></div>

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


