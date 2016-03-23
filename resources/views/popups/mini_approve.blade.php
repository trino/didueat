@extends('layouts.default')
@section('content')
<?php printfile("views/popups/mini_approve.blade.php"); ?>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="orderApproveModalLabel">{{ ucfirst($action) }} Order {{ $guid }}</h4>
            </div>
            {!! Form::open(array('url' => '/orders/list/' . $action . '/email/' . $email . '/' . $guid, 'id'=>'approve-form','class'=>'form-horizontal form-without-legend','method'=>'post','role'=>'form')) !!}
            <div class="modal-body">
                <DIV ID="message" align="center"></DIV>
                <label>Note to Customer</label>
                <textarea name="note" rows="4" id="text" class="form-control" maxlength="5000"></textarea>
                <input type="hidden" name="id" value="" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" TITLE="Close" TITLE="Close">Close</button>
                <button class="btn btn-primary" onclick="return confirm2('{{ $action }}');">{{ ucfirst($action) }}</button>
                <div class="clearfix"></div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <SCRIPT>
        //make sure the note is filled in before submitting
        function confirm2(Action){
            var element = document.getElementById("text").value.length;
            if(element==0){
                return true;
            }
            return confirm('Are you sure you want to ' + Action + ' order ID: {{ $guid }}?');
        }
    </SCRIPT>
@stop