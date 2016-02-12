{{ printfile("views/dashboard/profiles_address/ajax/list.blade.php") }}

@if(\Session::has('message'))
    {!! message_show("Message!", \Session::get('message')) !!}
@endif

<div class="card">
    <div class="card-header ">
        <div class="row">
            <div class="col-lg-9"><h4>
                    My Addresses 
                    <a class="btn btn-primary btn-sm" id="addNew" data-toggle="modal" data-addOrEdit="add" data-target="#editModel">Add</a>
                </h4></div>
            @if (Session::get('session_type_user') == "super" && $recCount > 10)

                @include('common.table_controls')

            @endif
        </div>
    </div>


    <div class="card-block p-a-0">
        <table class="table table-responsive m-b-0">
            @if (Session::get('session_type_user') == "super" && $recCount > 10)

                <thead>
                <tr>
                    @if($recCount > 1)

                    <th>
                        ID
                    </th>
@endif
                    <th>
                        <!--a class="sortOrder" data-meta="location" data-order="ASC" data-title="Location" title="Sort [Location] ASC"><i class="fa fa-caret-down"></i></a-->
                        Location
                        <!--a class="sortOrder" data-meta="location" data-order="DESC" data-title="Location" title="Sort [Location] DESC"><i class="fa fa-caret-up"></i></a>
                    </th>

                    <th class="">
                        <!--a class="sortOrder" data-meta="address" data-order="ASC" data-title="Address" title="Sort [Address] ASC"><i class="fa fa-caret-down"></i></a-->
                        Address
                        <!--a class="sortOrder" data-meta="address" data-order="DESC" data-title="Address" title="Sort [Address] DESC"><i class="fa fa-caret-up"></i></a-->
                    </th>

                    <th>Action</th>

                </tr>
                </thead>
            @endif
            <tbody>
            @if($recCount > 0)
                @foreach($Query as $key => $value)
                    <tr class="rows" data-id="{{ $value->id }}" data-order="{{ $key }}">
                        @if($recCount > 1)

                        <td style="min-width: 100px;">{{ $key+1 }}
                                <div class="btn-group-vertical">
                                    <a class="btn btn-secondary-outline up btn-sm"><i class="fa fa-arrow-up"></i></a>
                                    <a class="btn btn-secondary-outline down btn-sm"><i
                                                class="fa fa-arrow-down"></i></a>
                                </div>

                        </td>
                        @endif


                        <?php

                        (isset($value->apartment) && strlen($value->apartment) > 0) ? $aptV = "Apt " . $value->apartment . ", " : $aptV = "";
                        
                        ?>

                        <td>

                            <?php
                            if (isset($value->notes) && $value->notes!='') {
                                echo '<b>' . $value->notes . '</b><br>';
                            }
                            ?>

                            {{ $value->address . ', ' . $aptV . $value->city . ', ' . $value->province . ', ' . $value->postal_code }}</td>

                        <td>
                            <a data-id="{{ $value->id }}" data-user_id="{{ $value->user_id }}" data-addOrEdit="edit" class="btn btn-info-outline editRow btn-sm" data-toggle="modal"
                               data-target="#editModel">Edit</a>
                            <a href="{{ url('user/addresses/delete/'.$value->id) }}"
                               class="btn btn-danger-outline btn-sm"
                               onclick="return confirm('Are you sure you want to delete {{ addslashes($value->location) }}?');"><i class="fa fa-times"></i></a>
                        </td>

                    </tr>
                @endforeach
            @else
                <tr>
                    <td><span class="text-muted">No Addresses Yet</span></td>
                </tr>
            @endif
            </tbody>
        </table>


    </div>


</div>