<div class="modal" id="forgotpasswordModal" tabindex="-1" role="dialog" aria-labelledby="forgotpasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="forgotpasswordModalLabel">Forgot Password</h4>
            </div>
            <div class="modal-body">
                <?php printfile("views/popups/forgot-password.blade.php"); ?>
                <div id="forgot-pass-success" class="note note-success" style="display: none;">
                    <div class="alert alert-success">Please check your email for the recovery password</div>
                </div>
                {!! Form::open(array('url' => '/auth/forgot-password', 'id'=>'forgot-pass-form','class'=>'form-horizontal form-without-legend','method'=>'post','role'=>'form')) !!}
                <div id="error" class="alert alert-danger" style="display: none;"></div>
                <div class="form-group row ">
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-9">
                        A new password will be emailed to you
                    </div>
                </div>
                <?php echo newrow(false, "Email", '', true); ?>
                <input type="email" name="email" class="form-control" id="email" placeholder="" required/>
            </div>
        </div>
        <div class="form-group row ">
            <div class="col-md-3">
            </div>
            <div class="col-md-9">
                <button id="lostPWregButton" class="btn btn-primary btn-block form-control" type="submit"
                        >Submit
                </button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>