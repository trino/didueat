                        <div class="modal fade clearfix" id="editModel" tabindex="-1" role="dialog" aria-labelledby="editModelLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title" id="editLabel">My Home Address
                                        @if(debugmode()) (index) @endif
                                    </h4>
                                </div>
                                <div id="ajaxloader"></div>
                                {!! Form::open(array('url' => 'user/addresses', 'id'=>'edit-form', 'method'=>'post','role'=>'form')) !!}
                                    <div class="modal-body" id="contents">
                    
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
    <script>
                    var oldID = 0;
    $('body').on('click', '.editRow, #addNew', function () {
        var id = $(this).attr('data-id');
        var URL = $("#edit-form").attr('action') + "end";
        $('#edit-form').attr('action',  URL.replace("/" + oldID + "end", "/" + id));
        if(id == null || id == undefined || id == ""){
            id = 0;
            $('#editLabel').text('Add/Edit Address');
        }
        oldID=id;
        $('#editModel #ajaxloader').show();
        $('#editModel #contents').html('');
        $.get("{{ url('user/addresses/edit') }}/" + id, {}, function (result) {
            $('#editModel #ajaxloader').hide();
            try {
                if (jQuery.parseJSON(result).type == "error") {
                var json = jQuery.parseJSON(result);
                        $('#editModel #message').show();
                        $('#editModel #message p').html(json.message);
                        $('#editModel #contents').html('');
                }
            } catch (e) {
                $('#editModel #message').hide();
                $('#editModel #contents').html(result);
            }
        });
    });
                    </script>