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


<div class="modal fade clearfix" id="editCreditCardModal" tabindex="-1" role="dialog" aria-labelledby="editCreditCardModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="editCreditCardModalLabel">Credit Card</h4>
            </div>
            <div class="modal-body">

                {!! Form::open(array('url' => '/users/credit-cards/'.$type, 'name'=>'editForm', 'id'=>'addNewForm', 'class'=>'form-horizontal form-restaurants','method'=>'post','role'=>'form')) !!}
                <div id="editContents">
                    @include("common.edit_credit_card")
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

@if(false)
    <div id="addNewCreditCard" class="col-md-12 col-sm-12 col-xs-12 popup-dialog" style="display: none;">
        <div class="modal-dialog2">
            <div class="fancy-modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New</h4>
                </div>
                {!! Form::open(array('url' => '/users/credit-cards/'.$type, 'id'=>'addNewForm', 'class'=>'form-horizontal form-restaurants','method'=>'post','role'=>'form')) !!}
                <?php printfile("line 159"); ?>
                @include('common.edit_credit_card')
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div id="NewCreditCard" class="col-md-12 col-sm-12 col-xs-12 popup-dialog" style="display: none;">
        <div class="modal-dialog2">
            <div class="fancy-modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Card</h4>
                </div>
                {!! Form::open(array('url' => '/users/credit-cards/'.$type, 'name'=>'editForm', 'id'=>'addNewForm', 'class'=>'form-horizontal form-restaurants','method'=>'post','role'=>'form')) !!}
                <div id="editContents"></div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endif

@include('common.tabletools')

<script type="text/javascript">
    $('body').on('click', '.editRow', function () {
        var id = $(this).attr('data-id');
        $('#editCreditCardModal #editCreditCardModal').show();
        $('#editCreditCardModal #contents').html('');
        $.get("{{ url('users/credit-cards/edit') }}/" + id, {}, function (result) {
            try {
                if (jQuery.parseJSON(result).type == "error") {
                    var json = jQuery.parseJSON(result);
                    $('#editCreditCardModal #message').show();
                    $('#editCreditCardModal #message p').html(json.message);
                    $('#editCreditCardModal #editContents').html('');
                }
            } catch (e) {
                $('#editCreditCardModal #message').hide();
                $('#editCreditCardModal #editContents').html(result);
            }
            $('#editCreditCardModal #loading').hide();
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

        $.post("{{ url('credit-cards/Sequence') }}", {
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