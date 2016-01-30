<?php
printfile("views/dashboard/credit_cards/ajax/list.blade.php");
$encryptedfields = array("card_number", "expiry_date", "expiry_month", "expiry_year", "ccv");
?>

@if(\Session::has('message'))
    {!! message_show("Message!", \Session::get('message')) !!}
@endif

<div class="card">
    <div class="card-header ">
        <div class="row">
            <div class="col-lg-9">
                <h4 class="card-title">
                    Credit Card ({{ ucwords($type) }})
                    <button type="button" class="btn btn-primary btn-sm" id="addNew" data-toggle="modal"
                            data-target="#editModel">
                        Add
                    </button>
                </h4>

                <p class="card-subtitle text-muted">Your credit card will be billed on the 1st of each month. You must
                    have at least 1 active for your store to be open.</p>

            </div>

            @if (Session::get('session_type_user') == "super")


            <div class="col-lg-3">
                <?php printfile("views/common/table_controls.blade.php"); ?>
                <input type="text" class="form-control" id='searchResult' value='<?php echo $searchResults; ?>'
                       placeholder='Search...' autofocus='true' style=""/>
            </div>


            @include('common.table_controls')

                @endif
        </div>
    </div>

    <div class="card-block p-a-0">
        <table class="table table-responsive">
            <thead>
            <tr>
                <!--th>
                    <a class="sortOrder" data-meta="Id" data-order="ASC" data-title="Id"
                       title="Sort [Id] ASC"><i class="fa fa-caret-down"></i></a>
                    #
                    <a class="sortOrder" data-meta="Id" data-order="DESC" data-title="Id"
                       title="Sort [Id] DESC"><i class="fa fa-caret-up"></i></a>
                </th-->


                <th>
                    <!--a class="sortOrder" data-meta="first_name" data-order="ASC" data-title="Name"
                       title="Sort [Name] ASC"><i class="fa fa-caret-down"></i></a-->
                    Name
                    <!--a class="sortOrder" data-meta="first_name" data-order="DESC" data-title="Name"
                       title="Sort [Name] DESC"><i class="fa fa-caret-up"></i></a-->
                </th>
                <th>
                    <!--a class="sortOrder" data-meta="card_type" data-order="ASC" data-title="Card Type"
                       title="Sort [Card Type] ASC"><i class="fa fa-caret-down"></i></a-->
                    Card Type
                    <!--a class="sortOrder" data-meta="card_type" data-order="DESC" data-title="Card Type"
                       title="Sort [Card Type] DESC"><i class="fa fa-caret-up"></i></a-->
                </th>
                <th>
                    <!--a class="sortOrder" data-meta="card_number" data-order="ASC" data-title="Card Number"
                       title="Sort [Card Number] ASC"><i class="fa fa-caret-down"></i></a-->
                    Card Number
                    <!--a class="sortOrder" data-meta="card_number" data-order="DESC" data-title="Card Number"
                       title="Sort [Card Number] DESC"><i class="fa fa-caret-up"></i></a-->
                </th>
                <th>
                    <!--a class="sortOrder" data-meta="expiry_date" data-order="ASC" data-title="Expiry Date"
                       title="Sort [Expiry Date] ASC"><i class="fa fa-caret-down"></i></a-->
                    Expiry Date
                    <!--a class="sortOrder" data-meta="expiry_date" data-order="DESC" data-title="Expiry Date"
                       title="Sort [Expiry Date] DESC"><i class="fa fa-caret-up"></i></a-->
                </th>
                <th></th>
                <th></th>
            </tr>
            </thead>
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

                        <!--td>{{ $value->id }}
                            &nbsp;
                            <div class="btn-group-vertical">
                                <a class="btn btn-secondary-outline up btn-sm"><i class="fa fa-arrow-up"></i></a>
                                <a class="btn btn-secondary-outline down btn-sm"><i class="fa fa-arrow-down"></i></a>
                            </div>
                        </td-->


                        <td>{{ $value->first_name.' '.$value->last_name }}</td>
                        <td>{{ $value->card_type }}</td>
                        <td>{{ obfuscate($value->card_number) }}</td>
                        <td>{{ $value->expiry_month }}/{{ $value->expiry_date }}/{{ $value->expiry_year }}</td>
                        <td>
                            <div class="pull-right">
                                <!--a data-id="{{ $value->id }}" class="btn btn-info btn-sm editRow" data-toggle="modal"
                                   data-target="#editModel">
                                    Edit
                                </a-->
                                <a href="{{ url('credit-cards/delete/'.$value->id."/".$type) }}"
                                   class="btn btn-danger-outline btn-sm "
                                   onclick="return confirm('Are you sure you want to delete this card:  {{ addslashes("'" . $value->card_number . "'") }} ?');">X</a>
                            </div>
                        </td>

                    </tr>
                @endforeach
            @else
                <tr>
                    <th scope="row" colspan="7" class="text-center">No records found</th>
                </tr>
            @endif
            </tbody>
        </table>
    </div>



    @if (Session::get('session_type_user') == "super")
    <div class="card-footer clearfix">
        {!! $Pagination; !!}    </div>
    @endif



</div>