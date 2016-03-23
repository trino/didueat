<div class="modal clearfix" id="editModel" tabindex="-1" role="dialog" aria-labelledby="editModelLabel" aria-hidden="true" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="editLabel">Add/Edit Address

                </h4>
            </div>
            <?php
                printfile("views/popups/addaddress.blade.php");                
                $class = '';
                if(isset($loaded_from)){
                    $class= $loaded_from;
                }
            ?>
            <!--<div id="ajaxloader"></div>-->
            {!! Form::open(array('url' => 'user/addresses', 'id'=>'edit-form', 'method'=>'post', 'role'=>'form','class'=>$class, 'autocomplete' => 'false', 'onsubmit' => 'if (isaddress_incomplete()) { return false;}')) !!}
                <div class="modal-body" id="contents"></div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" onclick="if (isaddress_incomplete()) {return false;}">Save</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<script>
    var oldID = 0;
    $('body').on('click', '.editRow, .addNew', function () {
        var id = $(this).attr('data-id');
        var addOrEdit = $(this).attr('data-addOrEdit');

        var URL = "{{ url("user/addresses/save") }}/" + id;

        var route ='';
        if($(this).attr('data-route')) {
            route = "?route=" + $(this).attr('data-route');
        }
        $('#edit-form').attr('action',  URL);
        if(id == null || id == undefined || id == ""){
            id = 0;
            $('#editLabel').text('Add/Edit Address');
        }
        oldID=id;
        $('.overlay_loader').show();
        $('#editModel #contents').html('');
        $.get("{{ url('user/addresses/edit') }}/" + id+route, {}, function (result) {
           $('.overlay_loader').hide();
            try {
                if (jQuery.parseJSON(result).type == "error") {
                    var json = jQuery.parseJSON(result);
                    $('#editModel #message').show();
                    $('#editModel #message p').html(json.message);
                    $('#editModel #contents').html('');
                }
            } catch (e) {
                $('#editModel #message').hide();
                $('#editModel #contents.modal-body').html(result);
            }
            //document.getElementById('addOrEdit').value=addOrEdit;
            //initAutocompleteWithID("formatted_address");
            //initAutocomplete();
        });
    });

    //validateform("edit-form", {formatted_address: "required", city: "required", province: "required", postal_code: "required", country: "required"})
    //make sure the form is complete before allowing it to submit
    $('#edit-form').submit(function (e) {
        if(isaddress_incomplete()) {
            return false;
        }
    });
</script>
<script src="{{ url("assets/global/scripts/provinces.js") }}" type="text/javascript"></script>