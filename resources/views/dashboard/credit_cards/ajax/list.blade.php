<?php
    printfile("views/dashboard/credit_cards/ajax/list.blade.php");
    $encryptedfields = array("card_number", "expiry_month", "expiry_year", "ccv");
    $alts = array(
            "delete" => "Delete this credit card",
            "add" => "Add a credit card"
    );
    
?>

@if(\Session::has('message'))
    {!! message_show("Message!", \Session::get('message')) !!}
@endif

<div class="card">
    <div class="card-header ">
        <div class="row">
            <div class="col-lg-9">
                <h4 class="card-title"> 
                    My Credit Cards <!-- ({{ ucwords($type) }}) -->
                    <button type="button" class="btn btn-primary btn-sm" id="addNew" data-toggle="modal" data-target="#editModel" title="{{ $alts["add"] }}">
                        Add
                    </button>
                </h4>

                @if($type == "restaurant")
                <!--p class="card-subtitle text-muted">
                    Your credit card will be billed on the 1st of each month.
                </p-->
                @endif

            </div>

            @if (false)
                @include('common.table_controls')
            @endif
        </div>
    </div>

    <div class="card-block p-a-0">
        <table class="table table-responsive m-b-0">

            @if (Session::get('session_type_user') == "super"  && $recCount > 10)
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Card Type</th>
                        <th>Card Number</th>
                        <th>Expiry Date</th>
                        <th></th>
                    </tr>
                </thead>
            @endif

            <tbody>
                @if($recCount > 0)
                    @foreach($Query as $key => $value)
                        <?php
                            foreach ($encryptedfields as $field) {
                                if (is_encrypted($value->$field)) {
                                    $value->$field = \Crypt::decrypt($value->$field);
                                   
                                }
                            }
                        ?>
                        <tr class="rows" data-id="{{ $value->id }}" data-order="{{ $key }}">
                            <td>{{ $value->first_name.' '.$value->last_name }}</td>
                            <td>{{ $value->card_type }}</td>
                            <td>{{ obfuscate($value->card_number) }}</td>
                            <td>{{ $value->expiry_month }}/{{ right($value->expiry_year,2) }}</td>
                            <td>
                                <div class="pull-right">
                                    <!--a data-id="{{ $value->id }}" class="btn btn-info btn-sm editRow" data-toggle="modal" data-target="#editModel">
                                        Edit
                                    </a-->
                                    <a href="{{ url('credit-cards/delete/'.$value->id."/".$type) }}"
                                       class="btn btn-secondary-outline btn-sm" title="{{ $alts["delete"] }}"
                                       onclick="return confirm('Are you sure you want to delete this card:  {{ addslashes("'" . $value->card_number . "'") }} ?');"><i class="fa fa-times"></i></a>
                                </div>
                            </td>

                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td><span class="text-muted">No Credit Cards </span></td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    @if(Session::get('session_type_user') == "super"  && $recCount > 10)
        <div class="card-footer clearfix">{!! $Pagination !!}    </div>
    @endif
</div>