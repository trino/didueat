<div class="modal" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="alertModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php printfile("views/popups/alert.blade.php)<BR>"); ?>
                <SPAN ID="alertModalMsg"></SPAN>
            </div>
            <div class="modal-footer">
                <SPAN ID="alertModalFooterMSG" class="pull-left"></SPAN>
                <button type="button" class="btn  btn-danger" onclick="$('#alertModal').modal('hide');"/>OK</button>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
<SCRIPT>
    function alert(message, calledfrom) {
        if(debugmode){
            if(isundefined(calledfrom)){
                calledfrom = arguments.callee.caller.name;
            }
            $("#alertModalFooterMSG").text("CALLED FROM: " + calledfrom);
        }
        $('#alertModalMsg').text(message);
        $('#alertModal').modal('show');
    }
</SCRIPT>