@extends('layouts.default')
@section('content')

<?php
    $encryptedfields = array("first_name", "last_name", "card_number", "expiry_date", "expiry_month", "expiry_year", "ccv");
    function obfuscate($CardNumber, $maskingCharacter = "*"){
        if(strlen($CardNumber) < 15){return "[INVALID CARD NUMBER]";}
        return substr($CardNumber, 0, 4) . str_repeat($maskingCharacter, strlen($CardNumber) - 8) . substr($CardNumber, -4);
    }
?>

<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            @include('layouts.includes.leftsidebar')
            <div class="col-xs-12 col-md-10 col-sm-8">
                <?php printfile("views/dashboard/administrator/creditcards.blade.php"); ?>
                @if(\Session::has('message'))
                    <div class="alert {!! Session::get('message-type') !!}">
                        <strong>{!! Session::get('message-short') !!}</strong> &nbsp; {!! Session::get('message') !!}
                    </div>
                @endif

                <div class="deleteme">
                    <a class="btn red pull-right fancybox-fast-view" href="#addNewCreditCard">Add New</a>

                    <div class="clearfix"></div>
                    <hr class="shop__divider">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="box-shadow">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-globe"></i>Credit Cards List
                            </div>
                            <div class="tools">
                            </div>
                        </div>
                        <div class="portlet-body">
                            <table class="table table-striped table-bordered table-hover" id="sample_1">
                                <thead>
                                <tr>
                                    <th width="5%">User Type</th>
                                    <th width="10%">Name</th>
                                    <th width="10%">Card Type</th>
                                    <th width="15%">Card Number</th>
                                    <th width="5%">Date</th>
                                    <th width="5%">Month</th>
                                    <th width="5%">Year</th>
                                    <th width="10%">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($credit_cards_list as $value)
                                    <?php
                                        foreach($encryptedfields as $field){
                                            if(is_encrypted($value->$field)){
                                                $value->$field = \Crypt::decrypt($value->$field);
                                            }
                                        }
                                    ?>
                                    <tr>
                                        <td>{{ $value->user_type }}</td>
                                        <td>{{ $value->first_name.' '.$value->last_name }}</td>
                                        <td>{{ $value->card_type }}</td>
                                        <td>{{ obfuscate($value->card_number) }}</td>
                                        <td>{{ $value->expiry_date }}</td>
                                        <td>{{ $value->expiry_month }}</td>
                                        <td>{{ $value->expiry_year }}</td>
                                        <td>
                                            <a href="#NewCreditCard" class="btn red blue editUser fancybox-fast-view" data-id="{{ $value->id }}">Edit</a>
                                            @if($value->id != \Session::get('session_id'))
                                                <a href="{{ url('users/credit-cards/action/'.$value->id."/".$type) }}" class="btn red" onclick="return confirm('Are you sure you want to delete this card:  {{ addslashes("'" . $value->card_number . "'") }} ?');">Delete</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END EXAMPLE TABLE PORTLET-->

                </div>
            </div>
        </div>
    </div>
</div>
    <!-- END CONTENT -->



    <div id="addNewCreditCard" class="col-md-12 col-sm-12 col-xs-12 popup-dialog" style="display: none;">
        <div class="modal-dialog2">
            <div class="fancy-modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New</h4>
                </div>
                {!! Form::open(array('url' => '/users/credit-cards/'.$type, 'id'=>'addNewForm', 'class'=>'form-horizontal form-restaurants','method'=>'post','role'=>'form')) !!}
                    @include('common.edit_credit_card')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <!-- /.modal-content -->


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
    <!-- /.modal-content -->
    
    @include('common.tabletools')
    
    <script>
        $('body').on('click', '.editUser', function(){
            var id = $(this).attr('data-id');
            $.get("{{ url("users/credit-cards/edit") }}/"+id, {}, function(result){
                $('#editContents').html(result);
            });
        });
    </script>
@stop