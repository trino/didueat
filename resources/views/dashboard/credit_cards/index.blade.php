@extends('layouts.default')
@section('content')

<meta name="_token" content="{{ csrf_token() }}"/>
<script type="text/javascript">
    window.showEntries = 10;
    window.page = 1;
    window.pageUrlLoad = "{{ url('credit-cards/list/ajax/'.$type) }}";
</script>

<script src="{{ url("assets/global/scripts/provinces.js") }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/scripts/custom-datatable/blockUI.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/scripts/custom-datatable/toastr.min.js') }}"></script>
<script src="{{ asset('assets/global/scripts/custom-datatable/custom-plugin-datatable.js') }}" type="text/javascript"></script>

<div class="row">
    @include('layouts.includes.leftsidebar')

    <div class="col-lg-9">
        <?php printfile("views/dashboard/credit_cards/index.blade.php"); ?>
        <div id="ajax_message_jgrowl"></div>
        
        <!-- Panels Start -->
        <div id="loadPageData">
            <div id="ajaxloader"></div>
        </div>

    </div>
</div>


<div class="modal fade clearfix" id="editModel" tabindex="-1" role="dialog" aria-labelledby="editModelLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="editModelLabel">Credit Card</h4>
            </div>
            {!! Form::open(array('url' => 'credit-cards/list/'.$type, 'name'=>'editForm', 'id'=>'editForm', 'class'=>'form-horizontal form-restaurants','method'=>'post','role'=>'form')) !!}
            <div id="ajaxloader"></div>
            <div class="modal-body" id="contents">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>



<script type="text/javascript">
    function switchdivs(event){
        if (event == "restaurant") {
            $(".restaurant_id").show();
            $(".user_id").hide();
        } else {
            $(".user_id").show();
            $(".restaurant_id").hide();
        }
    }
    
    $('body').on('click', '.editRow, #addNew', function () {
        var id = $(this).attr('data-id');
        if(id == null || id == undefined || id == ""){
            id = 0;
            $('#editLabel').text('Add Address');
        }
        $('#editModel #ajaxloader').show();
        $('#editModel #contents').html('');
        $.get("{{ url('credit-cards/edit') }}/" + id, {}, function (result) {
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

        $.post("{{ url('credit-cards/sequence') }}", {
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