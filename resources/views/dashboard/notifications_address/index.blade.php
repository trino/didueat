@extends('layouts.default')
@section('content')

<meta name="_token" content="{{ csrf_token() }}"/>
<script type="text/javascript">
    window.showEntries = 10;
    window.page = 1;
    window.pageUrlLoad = "{{ url('restaurant/addresses/ajax/list') }}";
</script>
<script src="{{ asset('assets/global/scripts/custom-datatable/blockUI.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/scripts/custom-datatable/toastr.min.js') }}"></script>
<script src="{{ asset('assets/global/scripts/custom-datatable/custom-plugin-datatable.js') }}" type="text/javascript"></script>

<div class="row">
    @include('layouts.includes.leftsidebar')

    <div class="col-lg-9">
        <?php printfile("views/dashboard/user/addresses.blade.php"); ?>

        @if(\Session::has('message'))
        <div class="alert {!! Session::get('message-type') !!}">
            <strong>{!! Session::get('message-short') !!}</strong>
            &nbsp; {!! Session::get('message-detail') !!}
        </div>
        @endif
        
        <div id="ajax_message_jgrowl"></div>
        
        <!-- Panels Start -->
        <div id="loadPageData">
            <div id="ajaxloader"></div>
        </div>
        
    </div>
</div>


<div class="modal  fade clearfix" id="addAddressModal" tabindex="-1" role="dialog" aria-labelledby="editAddressModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
       <div class="modal-content">
           <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
               <h4 class="modal-title" id="editAddressModalLabel">Add Addresss</h4>
           </div>
           <div class="modal-body">

               {!! Form::open(array('url' => '/restaurant/addresses', 'id'=>'addNewForm', 'class'=>'form-horizontal form-restaurants','method'=>'post','role'=>'form')) !!}
               <div class="modal-body">
                   <div class="row">
                       <div class="col-md-12">
                           <div class="form-group">
                               <label class="control-label col-md-3">Phone / Email</label>

                               <div class="col-md-9">
                                   <input type="text" name="address" class="form-control address" required>
                               </div>
                           </div>
                           <div class="form-group">
                               <label class="control-label col-md-3">&nbsp;</label>

                               <div class="col-md-9 reach_type" style="display: none;">
                                   <label><input type="checkbox" name="is_call" value="1" checked> Call</label>
                                   &nbsp;
                                   <label><input type="checkbox" name="is_sms" value="1" checked> SMS</label>
                               </div>
                           </div>
                       </div>
                   </div>
                   <div class="clearfix"></div>
               </div>
               <div class="modal-footer">
                   <input type="hidden" name="is_contact_type" class="is_contact_type" value=""/>
                   <button type="submit" class="btn custom-default-btn saveNewBtn" disabled>Save changes</button>
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


<div class="modal  fade clearfix" id="editAddressModal" tabindex="-1" role="dialog" aria-labelledby="editAddressModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
       <div class="modal-content">
           <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
               <h4 class="modal-title" id="editAddressModalLabel">Edit Addresss</h4>
           </div>
           <div class="modal-body">

               {!! Form::open(array('url' => '/restaurant/addresses', 'name'=>'editForm', 'id'=>'editForm', 'class'=>'form-horizontal form-restaurants','method'=>'post','role'=>'form')) !!}
               <div id="editContents"></div>
               {!! Form::close() !!}

           </div>
           <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
               <button type="button" class="btn btn-primary">Save changes</button>
           </div>
       </div>
   </div>
</div>

@include('common.tabletools')

<script type="text/javascript">
    function editnote(ID) {
        var element = document.getElementById('note_' + ID);
        if (element.innerHTML.indexOf("<") == -1) {
            element.innerHTML = '<INPUT ID="text_note_' + ID + '" ONBLUR="editnote_event(' + ID + ');" ONKEYDOWN="editnote_keypress(' + ID + ');" TYPE="TEXTBOX" VALUE="' + element.getAttribute("value") + '">';
            element = document.getElementById("text_note_" + ID);
            element.focus();
            element.setSelectionRange(0, element.value.length);
        }
    }
    function editnote_keypress(ID) {
        if (event.keyCode == 13) {
            editnote_event(ID);
        }
    }
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
            data: "type=add_enable&id=" + ID + "&value=" + Value,
            success: function (msg) {
                if (msg) {
                    ignore1 = true;
                    $(element).trigger("click");
                    alert(msg);
                }
            }
        });
    }

    $('body').on('click', '.editAddress', function () {
        var id = $(this).attr('data-id');
        $.get("{{ url("restaurant/addresses/edit") }}/" + id, {}, function (result) {
            $('#editForm #editContents').html(result);
        });
    });

    $('body').on('keyup', '.address', function () {
        var ep_emailval = $(this).val();
        var intRegex = /[0-9 -()+]+$/;
        if (intRegex.test(ep_emailval)) {
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

        $.post("{{ url('restaurant/addresses/sequence') }}", {
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