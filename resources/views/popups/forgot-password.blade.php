<div class="modal fade" id="forgotpasswordModal" tabindex="-1" role="dialog" aria-labelledby="forgotpasswordModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="forgotpasswordModalLabel">Forgot Password</h4>
            </div>
            <div class="modal-body">
                <?php printfile("views/popups/forgot-password.blade.php"); ?>
                <div id="forgot-pass-success" class="note note-success" style="display: none;">
                    <h1 class="block">New Password Emailed</h1>
                    <p></p>
                </div>
                {!! Form::open(array('url' => '/auth/forgot-password', 'id'=>'forgot-pass-form','class'=>'form-horizontal form-without-legend','method'=>'post','role'=>'form')) !!}
                <div id="error" class="alert alert-danger" style="display: none;"></div>
                <div class="form-group row">
                    <div class="col-sm-12"><p style="">Click Submit, and a new
                            password will be emailed to you:</p></div>
                </div>

                <?php echo newrow(false, "Email", '', true); ?>
                <input type="email" name="email" class="form-control" id="email" placeholder="" required/>
            </div>


            <img src="{{ asset('assets/images/loader.gif') }}" id="regLoader"
                 style="display: none;margin-left:auto;margin-right:auto;"/>


        </div>
    </div>
    <div class="modal-footer">

        <button id="lostPWregButton" class="btn btn-primary pull-right" type="submit" style="">Submit</button>
        {!! Form::close() !!}
    </div>
</div>
</div>
</div>