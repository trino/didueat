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
            <div class="col-lg-6">
                <h6>

                    Credit Card ({{ ucwords($type) }})
                    <button type="button" class="btn btn-primary btn-sm" id="addNew" data-toggle="modal"
                            data-target="#editModel">
                        Add
                    </button>

                </h6>
            </div>

            @include('common.table_controls')

        </div>
    </div>

    <!--table width="100%" border="0" cellpadding="0" cellspacing="0"
           style=" border: #BCBCBC solid 1px; padding:5px; margin: 0 auto;background-color: darkgray;">
        <tr>
            <td align="left"><label>Show<select size="1" name="showDataEntries" id="showDataEntries" class="form-con">
                        <option value="10" {!! ($per_page == 10)?"selected":''; !!}>10</option>
                        <option value="25" {!! ($per_page == 25)?"selected":''; !!}>25</option>
                        <option value="50" {!! ($per_page == 50)?"selected":''; !!}>50</option>
                        <option value="100" {!! ($per_page == 100)?"selected":''; !!}>100</option>
                        <option value="300" {!! ($per_page == 300)?"selected":''; !!}>300</option>
                        <option value="500" {!! ($per_page == 500)?"selected":''; !!}>500</option>
                        <option value="1000" {!! ($per_page == 1000)?"selected":''; !!}>1000</option>
                    </select> entries</label></td>
            <td align="right">
                <div>
                    <label>
                        <b class="search-input"> Search: </b><input type="text" class="form-control" id='searchResult'
                                                                    value='{!! $searchResults !!}'
                                                                    placeholder='Enter Keyword...' autofocus='true'
                                                                    style="width:220px !important;"/>
                    </label>
                </div>
            </td>
        </tr>
    </table-->


    <div class="card-block p-a-0">
        <table class="table table-responsive">
            <thead>
            <tr>
                <th>
                    <a class="sortOrder" data-meta="first_name" data-order="ASC" data-title="Name"
                       title="Sort [Name] ASC"><i class="fa fa-caret-down"></i></a>
                    Name
                    <a class="sortOrder" data-meta="first_name" data-order="DESC" data-title="Name"
                       title="Sort [Name] DESC"><i class="fa fa-caret-up"></i></a>
                </th>
                <th>
                    <a class="sortOrder" data-meta="card_type" data-order="ASC" data-title="Card Type"
                       title="Sort [Card Type] ASC"><i class="fa fa-caret-down"></i></a>
                    Card Type
                    <a class="sortOrder" data-meta="card_type" data-order="DESC" data-title="Card Type"
                       title="Sort [Card Type] DESC"><i class="fa fa-caret-up"></i></a>
                </th>
                <th>
                    <a class="sortOrder" data-meta="card_number" data-order="ASC" data-title="Card Number"
                       title="Sort [Card Number] ASC"><i class="fa fa-caret-down"></i></a>
                    Card Number
                    <a class="sortOrder" data-meta="card_number" data-order="DESC" data-title="Card Number"
                       title="Sort [Card Number] DESC"><i class="fa fa-caret-up"></i></a>
                </th>
                <th>
                    <a class="sortOrder" data-meta="expiry_date" data-order="ASC" data-title="Expiry Date"
                       title="Sort [Expiry Date] ASC"><i class="fa fa-caret-down"></i></a>
                    Expiry Date
                    <a class="sortOrder" data-meta="expiry_date" data-order="DESC" data-title="Expiry Date"
                       title="Sort [Expiry Date] DESC"><i class="fa fa-caret-up"></i></a>
                </th>
                <th>Actions</th>
                <th>Order</th>
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
                        <td>{{ $value->first_name.' '.$value->last_name }}</td>
                        <td>{{ $value->card_type }}</td>
                        <td>{{ obfuscate($value->card_number) }}</td>
                        <td>{{ $value->expiry_month }}/{{ $value->expiry_date }}/{{ $value->expiry_year }}</td>
                        <td>
                            <a data-id="{{ $value->id }}" class="btn btn-info btn-sm editRow" data-toggle="modal"
                               data-target="#editModel">
                                Edit
                            </a>
                            @if($value->id != \Session::get('session_id'))
                                <a href="{{ url('credit-cards/delete/'.$value->id."/".$type) }}"
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
            @else
                <tr>
                    <th scope="row" colspan="7" class="text-center">No records found</th>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
    <div class="card-footer clearfix">
        {!! $Pagination; !!}    </div>
</div>