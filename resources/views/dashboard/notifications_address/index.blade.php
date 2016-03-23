@extends('layouts.default')
@section('content')

<SCRIPT>
    window.showEntries = 10;
    window.page = 1;
    window.pageUrlLoad = "{{ url('notification/addresses/ajax/list') . "?" . http_build_query($_GET) }}";
</SCRIPT>
<meta name="_token" class="csrftoken" content="{{ csrf_token() }}"/>
<script src="{{ asset('assets/global/scripts/custom-datatable/blockUI.js') }}" type="text/javascript"></script>
<!--script src="{{ asset('assets/global/scripts/custom-datatable/toastr.min.js') }}"></script-->
<script src="{{ asset('assets/global/scripts/custom-datatable/custom-plugin-datatable.js') }}" type="text/javascript"></script>

<div class="container">
    <?php printfile("views/dashboard/notifications_address/index.blade.php"); ?>

    <div class="row">
        @include('layouts.includes.leftsidebar')
        <div class="col-lg-9">
            <div id="ajax_message_jgrowl"></div>
            <!-- Panels Start -->
            <div id="loadPageData">
                
            </div>
        </div>
    </div>
</div>

<div class="modal clearfix" id="editModel" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
       {!! Form::open(array('url' => '/notification/addresses', 'name'=>'editForm', 'onsubmit'=>'return validateNotif(this)', 'onchange'=>'return validateNotif(this)', 'id'=>'editForm', 'class'=>'form-horizontal form-restaurants','method'=>'post','role'=>'form')) !!}
       <input name="type" type="hidden" />
       <div class="modal-content">
           <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
               <h4 class="modal-title" id="editModalLabel">Edit Addresss</h4>
           </div>
           <!--<div id="ajaxloader"></div>-->
           <div class="modal-body" id="contents">

           </div>

           <div class="modal-body">
                <DIV class="col-sm-12" ID="toast" style="color: red;"></DIV>
               <div class="clearfix"></div>

           </div>

           <div class="modal-footer">
               <button type="button" class="btn btn-secondary saveNewBtn" data-dismiss="modal" TITLE="Close">Close</button>
               <button type="submit" class="btn btn-primary saveNewBtn">Save</button>
           </div>
       </div>
       {!! Form::close() !!}
   </div>
</div>



<script type="text/javascript">
    //send some text to the user
    function toast(message){
        $("#toast").html(message);
    }

    function validateall(){
        $("#editForm").trigger("change");
    }

    //edit the note
    function editnote(ID) {
        return;
        var element = document.getElementById('note_' + ID);
        if (element.innerHTML.indexOf("<") == -1) {
            element.innerHTML = '<INPUT ID="text_note_' + ID + '" ONBLUR="editnote_event(' + ID + ');" ONKEYDOWN="editnote_keypress(' + ID + ');" TYPE="TEXTBOX" VALUE="' + element.getAttribute("value") + '">';
            element = document.getElementById("text_note_" + ID);
            element.focus();
            element.setSelectionRange(0, element.value.length);
        }
    }

    //detect when enter is pressed
    function editnote_keypress(ID) {
        if (event.keyCode == 13) {
            editnote_event(ID);
        }
    }

    //send the new note to the server
    function editnote_event(ID) {
        var element = document.getElementById('text_note_' + ID);
        var value = element.value;
        $.ajax({
            url: '{{addslashes(url('ajax'))}}',
            type: "post",
            dataType: "HTML",
            data: "type=change_note&id=" + ID + "&value=" + encodeURIComponent(value),
            success: function (msg) {
                if (msg) {
                    alert(msg);
                } else {
                    element = document.getElementById('note_' + ID);
                    element.innerHTML = value;
                    element.setAttribute("value", value);
                }
            }
        });
    }

    //enable/disable the notification method
    var ignore1 = false;
    function add_enable(ID) {
        if (ignore1) {
            ignore1 = false;
            return;
        }
        var Value = 0;
        var element = document.getElementById('add_enable_' + ID);
        if (element.checked) {
            Value = 1;
        }
        $.ajax({
            url: '{{addslashes(url('ajax'))}}',
            type: "post",
            dataType: "HTML",
            data: "type=add_enable&token={{ csrf_token() }}&id=" + ID + "&value=" + Value,
            success: function (msg) {
                if (msg.trim()) {
                    ignore1 = true;
                    $(element).trigger("click");
                    alert(msg);
                }
            }
        });
    }

    //bring up the "add new notification method" form
    $('body').on('click', '.editRow, #addNew', function() {
        var id = $(this).attr('data-id');
        if(id == null || id == undefined || id == ""){
            id = 0;
            $('#editLabel').text('Add Address');
        }
        toast("");
        $('.overlay_loader').show();
        $('#editModel #contents').html('');
        $.get("{{ url('notification/addresses/edit') }}/" + id, {}, function (result) {
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
                $('#editModel #contents').html(result);
            }
        });
    });

    function isValidEmailAddress(emailAddress) {
        var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
        return pattern.test(emailAddress);
    };

    //handle keypresses on the address, check if it's valud
    $('body').on('keyup', '.address', function () {
        var ep_emailval = $(this).val();
        if (!isValidEmailAddress(ep_emailval)) {
            $('.reach_type').show();
            $('.is_contact_type').val(1);
        } else {
            $('.reach_type').hide();
            $('.is_contact_type').val(0);
        }
        if (ep_emailval) {
            $('.saveNewBtn').attr('disabled', false);
        } else {
            $('.saveNewBtn').attr('disabled', true);
        }
    });

    //handle the up/down arrows to change the priority (which doesn't actually do anything)
    $('body').on('click', '.up, .down', function () {
        var row = $(this).parents("tr:first");
        var token = $('#addNewForm input[name=_token]').val();
        var order = $(this).parents("tr:first").attr('data-order');

        if ($(this).is(".up")) {
            row.insertBefore(row.prev());
        } else {
            row.insertAfter(row.next());
        }

        $(".rows").each(function (index) {
            $(this).attr("data-order", index);
        });

        var data_id = $(".rows").map(function () {
            return $(this).attr("data-id");
        }).get();
        var data_order = $(".rows").map(function () {
            return $(this).attr("data-order");
        }).get();

        $.post("{{ url('notification/addresses/sequence') }}", {
            id: data_id.join('|'),
            order: data_order.join('|'),
            _token: token
        }, function (result) {
            if (result) {
                alert(result);
            }
        });
    });
</script>
@stop