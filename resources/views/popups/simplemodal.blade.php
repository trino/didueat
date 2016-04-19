<div class="modal" id="allergyModal" tabindex="-1" role="dialog" aria-labelledby="allergyModalLabel" aria-hidden="true" style="z-index: 9999;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="Close">
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
                    <div class="form-group" id="modal_loader"><img src="{{ asset('assets/images/loader.gif') }}" alt="Loading..."/></div>
                </div>
            </div>
        </div>
    </div>
</div>