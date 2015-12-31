@extends('layouts.default')
@section('content')

<<<<<<< HEAD
=======
<?php
    $encryptedfields = array("first_name", "last_name", "card_number", "expiry_date", "expiry_month", "expiry_year", "ccv");
    function obfuscate($CardNumber, $maskingCharacter = "*") {
        if (!isvalid_creditcard($CardNumber)) {
            return "[INVALID CARD NUMBER]";
        }
        return substr($CardNumber, 0, 4) . str_repeat($maskingCharacter, strlen($CardNumber) - 8) . substr($CardNumber, -4);
    }


    function isvalid_creditcard($CardNumber, $Invalid = ""){
        $CardNumber=preg_replace('/\D/', '', $CardNumber);
        // http://stackoverflow.com/questions/174730/what-is-the-best-way-to-validate-a-credit-card-in-php
        // https://en.wikipedia.org/wiki/Bank_card_number#Issuer_identification_number_.28IIN.29
        if($CardNumber){
            $length=0;
            $mod10 = true;
            $Prefix = left($CardNumber,2);
            if($Prefix >= 51 && $Prefix <= 55){
                $length = 16;//mastercard
                $type = "mastercard";
            } else if ($Prefix == 34 || $Prefix == 37) {
                $length = 15;//amex
                $type = "americanExpress";
            } else if (left($CardNumber, 1) == 4) {
                $length = array(13,16);//visa
                $type = "visa";
            } else if ($Prefix == 65){
                $length = 16;//discover
                $type = "discover";
            } else {
                $Prefix = left($CardNumber,6);
                if($Prefix >= 622126 || $Prefix <= 622925){
                    $length = 16;//discover
                    $type = "discover";
                } else {
                    $Prefix = left($CardNumber,3);
                    if($Prefix >= 644 || $Prefix <= 649){
                        $length = 16;//discover
                        $type = "discover";
                    } else if (left($CardNumber, 4) == 6011){
                        $length = 16;//discover
                        $type = "discover";
                    }
                }
            }
            if($length){
                if(!is_array($length)){$length = array($length);}
                $Prefix = false;
                foreach( $length as $digits ){
                    if( strlen($CardNumber) == $digits){
                        $Prefix = true;
                    }
                }
                if($Prefix){
                    if($mod10){
                        if (luhn_check($CardNumber)){
                            return $type;
                        }
                    }
                    return $type;
                }
            }
        }
        return $Invalid;
    }

    function luhn_check($number) {
        // Strip any non-digits (useful for credit card numbers with spaces and hyphens)
        $number=preg_replace('/\D/', '', $number);

        // Set the string length and parity
        $number_length=strlen($number);
        $parity=$number_length % 2;

        // Loop through each digit and do the maths
        $total=0;
        for ($i=0; $i<$number_length; $i++) {
            $digit=$number[$i];
            // Multiply alternate digits by two
            if ($i % 2 == $parity) {
                $digit*=2;
                // If the sum is two digits, add them together (in effect)
                if ($digit > 9) {
                    $digit-=9;
                }
            }
            // Total up the digits
            $total+=$digit;
        }

        // If the total mod 10 equals 0, the number is valid
        return ($total % 10 == 0) ? TRUE : FALSE;
    }

    /*
    $testnumbers = array("378282246310005", "371449635398431", "378734493671000", "6011111111111117", "6011000990139424", "5555555555554444", "5105105105105100", "4111111111111111", "4012888888881881", "4222222222222", "test");
    foreach($testnumbers as $CreditCard){
        echo $CreditCard . " is " . isvalid_creditcard($CreditCard, "[INVALID]" ) . "<BR>";
    }
    */
?>


>>>>>>> 7bdffe0ba57e82410fd35a449684d83e0f32b05e
    <div class="row">
        @include('layouts.includes.leftsidebar')
        <div class="col-lg-9">
            <?php printfile("views/dashboard/administrator/creditcards.blade.php"); ?>
            @if(\Session::has('message'))
                <div class="alert {!! Session::get('message-type') !!}">
                    <strong>{!! Session::get('message-short') !!}</strong> &nbsp; {!! Session::get('message') !!}
                </div>
            @endif


            <div class="card">
                <div class="card-header">
                    Credit Card ({{ ($type) }})
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                            data-target="#editCreditCardModal">
                        Add
                    </button>
                </div>
                <div class="card-block p-a-0">
                    <table class="table table-responsive" id="">
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
                                    <a class="btn btn-secondary-outline btn-sm up"><i class="fa fa-arrow-up"></i></a>
                                    <a class="btn btn-secondary-outline btn-sm down"><i class="fa fa-arrow-down"></i></a>
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