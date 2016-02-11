<div class="modal fade" id="allergyModal" tabindex="-1" role="dialog" aria-labelledby="allergyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="simpleModalLabel">Loading...</h4>
            </div>

            <div class="modal-body">
                <?php printfile("views/common/popups/simplemodal.blade.php"); ?>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12" id="modal_contents">

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group" id="modal_loader"><img src="{{ asset('assets/images/loader.gif') }}"/></div>
                </div>
            </div>
        </div>
    </div>
</div>