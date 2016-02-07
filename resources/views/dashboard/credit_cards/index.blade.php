@extends('layouts.default')
@section('content')

<meta name="_token" content="{{ csrf_token() }}"/>
<script type="text/javascript">
    window.showEntries = 10;
    window.page = 1;
    window.pageUrlLoad = "{{ url('credit-cards/list/ajax/'. $type) . "?" . http_build_query($_GET) }}";
</script>

<script src="{{ url("assets/global/scripts/provinces.js") }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/scripts/custom-datatable/blockUI.js') }}" type="text/javascript"></script>
<!--script src="{{ asset('assets/global/scripts/custom-datatable/toastr.min.js') }}"></script-->
<script src="{{ asset('assets/global/scripts/custom-datatable/custom-plugin-datatable.js') }}" type="text/javascript"></script>


<div class="container">
    <?php printfile("views/dashboard/credit_cards/index.blade.php"); ?>

<div class="row">
    @include('layouts.includes.leftsidebar')

    <div class="col-lg-9">
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
            {!! Form::open(array('url' => 'credit-cards/list/'. $type, 'name'=>'editForm', 'id'=>'editForm', 'class'=>'form-horizontal form-restaurants','method'=>'post','role'=>'form')) !!}
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
        $.get("{{ url('credit-cards/edit') }}/" + id + '/{{  $type }}', {}, function (result) {
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

    function validateCardNumber(number) {
        number = number.replace(/\D/g,'');
        if (luhnCheck(number)){
            var prefix = number.substring(0, 2);
            var length = 0;
            if (prefix >= 51 && prefix <= 55) {
                length = 16; //mastercard
                var type = "mastercard";
            } else if (prefix == 34 || prefix == 37) {
                length = 15; //amex
                var type = "americanExpress";
            } else if (number.substring(0, 1) == 4) {
                length = number.length;
                if (length != 13 && length != 16){length=length+1;}
                var type = "visa";
            } else if (prefix == 65) {
                length = 16; //discover
                var type = "discover";
            } else {
                prefix = number.substring(0, 6);
                if (prefix >= 622126 || prefix <= 622925) {
                    length = 16; //discover
                    var type = "discover";
                } else {
                    prefix = number.substring(0, 3);
                    if (prefix >= 644 || prefix <= 649 || number.substring(0, 4) == 6011) {
                        length = 16; //discover
                        var type = "discover";
                    }
                }
            }
            if(length == number.length){return type;}
        }
        return false;
    }

    function luhnCheck(val) {
        var sum = 0;
        for (var i = 0; i < val.length; i++) {
            var intVal = parseInt(val.substr(i, 1));
            if (i % 2 == 0) {
                intVal *= 2;
                if (intVal > 9) {
                    intVal = 1 + (intVal % 10);
                }
            }
            sum += intVal;
        }
        return (sum % 10) == 0;
    }

    jQuery.validator.addMethod("creditcard", function (value, element) {
        return validateCardNumber(value);
    });

    $("#editForm").validate({
        rules: {
            card_number: {
                required: true,
                creditcard: true
            }
        },
        messages: {
            card_number: {
                creditcard: "The card number is not valid",
            },
        }
    });
</script>
@stop