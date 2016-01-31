@extends('layouts.default')
@section('content')

<?php $encryptedfields = array("first_name", "last_name", "card_number", "expiry_date", "expiry_month", "expiry_year", "ccv"); ?>

    <div class="row">
        @include('layouts.includes.leftsidebar')
        <div class="col-lg-9">
            <?php printfile("views/dashboard/administrator/delete_creditcards.blade.php"); ?>
            <div class="card">
                <div class="card-header">
                    Credit Card ({{ ($type) }})
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                            data-target="#editCreditCardModal">
                        Add
                    </button>
                </div>
                <div class="card-block p-a-0">
                    <table class="table table-responsive m-b-0">
                        <thead>
                        <tr>
                            <th width="5%">Type</th>
                            <th width="10%">Name</th>
                            <th width="10%">Card Type</th>
                            <th width="13%">Card Number</th>
                            <th width="10%">Expiry Date</th>
                            <th width="14%">Actions</th>
                            <th width="14%">Order</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $encryptedfields = array("first_name", "last_name", "card_number", "expiry_date", "expiry_month", "expiry_year", "ccv");
                        ?>
                        @foreach($credit_cards_list as $key => $value)
                            <?php
                                foreach ($encryptedfields as $field) {
                                    if (is_encrypted($value->$field)) {

                                     $value->$field = \Crypt::decrypt($value->$field);

                                    }
                                }
                            ?>
                            <tr class="rows" data-id="{{ $value->id }}" data-order="{{ $key }}">
                                <td>{{ $value->user_type }}</td>
                                <td>{{ $value->first_name.' '.$value->last_name }}</td>
                                <td>{{ $value->card_type }}</td>
                                <td>{{ obfuscate($value->card_number) }}</td>
                                <td>{{ $value->expiry_month }}/{{ $value->expiry_date }}/{{ $value->expiry_year }}</td>
                                <td>

                                    <a data-id="{{ $value->id }}" class="btn btn-info btn-sm editRow" data-toggle="modal" data-target="#editCreditCardModal">
                                        Edit
                                    </a>

                                    @if($value->id != \Session::get('session_id'))
                                        <a href="{{ url('users/credit-cards/action/'.$value->id."/".$type) }}"
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Are you sure you want to delete this card:  {{ addslashes("'" . $value->card_number . "'") }} ?');">Delete</a>
                                    @endif
                                </td>
                                <td>

                                    <div class="btn-group-vertical">
                                        <a class="btn btn-secondary-outline up btn-sm"><i class="fa fa-arrow-up"></i></a>
                                        <a class="btn btn-secondary-outline down btn-sm"><i class="fa fa-arrow-down"></i></a>
                                    </div>


                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
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
                    <h4 class="modal-title" id="editCreditCardModalLabel">Update Credit Card</h4>
                </div>
                <div class="modal-body">

                    {!! Form::open(array('url' => '/users/credit-cards/'.$type, 'name'=>'editForm', 'id'=>'addNewForm', 'class'=>'form-horizontal form-restaurants','method'=>'post','role'=>'form')) !!}
                    <div id="editContents">
                        <?php printfile("line 136"); ?>
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


    <script>
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
    </script>


    <script type="text/javascript">
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

            $.post("{{ url('users/credit-cards/Sequence') }}", {
                id: data_id.join('|'),
                order: data_order.join('|'),
                _token: token
            }, function (result) {
                if (result) {
                    alert(result);
                }
            });
        });

        $('body').on('click', '.editUser', function () {
            var id = $(this).attr('data-id');
            $.get("{{ url("users/credit-cards/edit") }}/" + id, {}, function (result) {
                $('#editContents').html(result);
            });
        });
    </script>
@stop