@if(false)
<div id="forget-passsword" class="popup-dialog" style="display: none;">
    <?php printfile("views/popups/forgotpassword.blade.php"); ?>

    <h1>Forgot Your Password?</h1>
    <div id="forgot-pass-success" class="note note-success" style="display: none;">
        <h1 class="block">success</h1>
        <p></p>
    </div>

    {!! Form::open(array('url' => '/auth/forgot-passoword', 'id'=>'forgot-pass-form','class'=>'form-horizontal form-without-legend','method'=>'post','role'=>'form')) !!}
    <div id="error" class="alert alert-danger" style="display: none;"></div>
    <div class="form-group col-md-12 col-sm-124 col-xs-12">
        <label class="col-lg-4 col-md-4 col-sm-4 col-xs-12 control-label" for="forgot-email">Email</label>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <div class="input-icon">
                <input type="email" name="email" class="form-control" id="email" placeholder="Email Address" required />
            </div>
        </div>
    </div>

    <div class="col-lg-8 col-sm-8 col-xs-12 col-md-offset-4 padding-left-0 padding-top-20">
        <button id="regButton" class="btn btn-primary" type="submit">Send</button>
        <img id="regLoader" src="{{ asset('assets/images/loader.gif') }}" style="display: none;"/>
        <span>&nbsp;&nbsp;Already have account credentials? <a href="#login-pop-up" class="fancybox-fast-view">Login here</a></span>
    </div>
    {!! Form::close() !!}
</div>

@endif


<div class="modal fade" id="forgotpasswordModal" tabindex="-1" role="dialog" aria-labelledby="forgotpasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="forgotpasswordModalLabel">Log in</h4>
            </div>
            <div class="modal-body">

                <?php printfile("views/popups/forgotpassword.blade.php"); ?>

                <h1>Forgot Your Password?</h1>
                <div id="forgot-pass-success" class="note note-success" style="display: none;">
                    <h1 class="block">success</h1>
                    <p></p>
                </div>

                {!! Form::open(array('url' => '/auth/forgot-passoword', 'id'=>'forgot-pass-form','class'=>'form-horizontal form-without-legend','method'=>'post','role'=>'form')) !!}
                <div id="error" class="alert alert-danger" style="display: none;"></div>
                <div class="form-group col-md-12 col-sm-124 col-xs-12">
                    <label class="col-lg-4 col-md-4 col-sm-4 col-xs-12 control-label" for="forgot-email">Email</label>
                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                        <div class="input-icon">
                            <input type="email" name="email" class="form-control" id="email" placeholder="Email Address" required />
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 col-sm-8 col-xs-12 col-md-offset-4 padding-left-0 padding-top-20">
                    <button id="regButton" class="btn btn-primary" type="submit">Send</button>
                    <img id="regLoader" src="{{ asset('assets/images/loader.gif') }}" style="display: none;"/>
                    <span>&nbsp;&nbsp;Already have account credentials? <a href="#login-pop-up" class="fancybox-fast-view">Login here</a></span>
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
