<div class="modal fade" id="forgotpasswordModal" tabindex="-1" role="dialog" aria-labelledby="forgotpasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="forgotpasswordModalLabel">Forgot Password</h4>
            </div>
            <div class="modal-body">
                <?php printfile("views/popups/forgotpassword.blade.php"); ?>
                <div id="forgot-pass-success" class="note note-success" style="display: none;">
                    <h1 class="block">Success</h1>

                    <p></p>
                </div>
                {!! Form::open(array('url' => '/auth/forgot-passoword', 'id'=>'forgot-pass-form','class'=>'form-horizontal form-without-legend','method'=>'post','role'=>'form')) !!}
                <div id="error" class="alert alert-danger" style="display: none;"></div>
                <div class="form-group row">
                    <div class="col-sm-12"><p>A new password will be emailed to you</p></div>

                    <div class="col-sm-3">Email</div>
                    <div class="col-sm-9">
                        <input type="email" name="email" class="form-control" id="email" placeholder="Email Address"
                               required/>
                    </div>
                </div>
                <img id="regLoader" src="{{ asset('assets/images/loader.gif') }}" style="display: none;"/>
            </div>
            <div class="modal-footer">
                <button id="regButton" class="btn btn-primary" type="submit">Submit</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>