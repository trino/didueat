@extends('layouts.default')
@section('content')

    <?php
    $encryptedfields = array("first_name", "last_name", "card_number", "expiry_date", "expiry_month", "expiry_year", "ccv");
    function obfuscate($CardNumber, $maskingCharacter = "*")
    {
        if (strlen($CardNumber) < 15) {
            return "[INVALID CARD NUMBER]";
        }
        return substr($CardNumber, 0, 4) . str_repeat($maskingCharacter, strlen($CardNumber) - 8) . substr($CardNumber, -4);
    }
    ?>


    <div class="row">
        @include('layouts.includes.leftsidebar')
        <div class="col-lg-9">
            <?php printfile("views/dashboard/administrator/creditcards.blade.php"); ?>
            @if(\Session::has('message'))
                <div class="alert {!! Session::get('message-type') !!}">
                    <strong>{!! Session::get('message-short') !!}</strong> &nbsp; {!! Session::get('message') !!}
                </div>
            @endif

            <div class="deleteme">

                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#addCreditCardModal">
                    Add Credit Card
                </button>


                <div class="clearfix"></div>
                <hr class="shop__divider">
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
                                <th width="13%">Card Number</th>
                                <th width="5%">Date</th>
                                <th width="4%">Month</th>
                                <th width="4%">Year</th>
                                <th width="14%">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($credit_cards_list as $key => $value)
                                <?php
                                foreach ($encryptedfields as $field) {
                                    if (is_encrypted($value->$field)) {
                                        //   $value->$field = \Crypt::decrypt($value->$field);
                                    }
                                }
                                ?>
                                <tr class="rows" data-id="{{ $value->id }}" data-order="{{ $key }}">
                                    <td>{{ $value->user_type }}</td>
                                    <td>{{ $value->first_name.' '.$value->last_name }}</td>
                                    <td>{{ $value->card_type }}</td>
                                    <td>{{ obfuscate($value->card_number) }}</td>
                                    <td>{{ $value->expiry_date }}</td>
                                    <td>{{ $value->expiry_month }}</td>
                                    <td>{{ $value->expiry_year }}</td>
                                    <td>

                                        <button type="button" data-id="{{ $value->id }}" class="btn btn-danger"
                                                data-toggle="modal" data-target="#editCreditCardModal">
                                            Edit Credit Card
                                        </button>


                                        @if($value->id != \Session::get('session_id'))
                                            <a href="{{ url('users/credit-cards/action/'.$value->id."/".$type) }}"
                                               class="btn red"
                                               onclick="return confirm('Are you sure you want to delete this card:  {{ addslashes("'" . $value->card_number . "'") }} ?');">Delete</a>
                                        @endif
                                        <a class="btn nomargin btn-info up"><i class="fa fa-arrow-up"></i></a>
                                        <a class="btn nomargin btn-info down"><i class="fa fa-arrow-down"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>






    <div class="modal fade clearfix" id="addCreditCardModal" tabindex="-1" role="dialog"
         aria-labelledby="addCreditCardModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="addCreditCardModalLabel">Update Credit Card</h4>
                </div>
                <div class="modal-body">

                    {!! Form::open(array('url' => '/users/credit-cards/'.$type, 'id'=>'addNewForm', 'class'=>'form-horizontal form-restaurants','method'=>'post','role'=>'form')) !!}
                    @include('common.edit_credit_card')
                    {!! Form::close() !!}


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>




    <div class="modal fade clearfix" id="editCreditCardModal" tabindex="-1" role="dialog"
         aria-labelledby="editCreditCardModalLabel"
         aria-hidden="true">
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





    @if(false)
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

                $.post("{{ url('users/credit-cards/sequance') }}", {
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