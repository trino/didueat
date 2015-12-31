@extends('layouts.default')
@section('content')

    <meta name="_token" content="{{ csrf_token() }}"/>
    <script src="{{ url("assets/global/scripts/provinces.js") }}" type="text/javascript"></script>
    
    <div class="row">
        @include('layouts.includes.leftsidebar')

        <div class="col-lg-9">

            <?php printfile("views/dashboard/user/addresses.blade.php"); ?>

            @if(\Session::has('message'))
                <div class="alert {!! Session::get('message-type') !!}">
                    <strong>{!! Session::get('message-short') !!}</strong>
                    &nbsp; {!! Session::get('message') !!}
                </div>
            @endif


            <div class="card">
                <div class="card-header ">
                    My Addresses
                    <a class="btn btn-primary   btn-sm" data-toggle="modal" data-target="#addAddressModal">Add</a>
                </div>
                <div class="card-block p-a-0">
                    <table class="table table-responsive" id="sample_111">
                        <thead>
                        <tr>
                            <th width="5%">ID</th>
                            <th width="15%">Name</th>
                            <th width="15%">Address</th>
                            <th width="10%">Phone</th>
                            <th width="20%">Address</th>
                            <th width="20%">Action</th>
                            <th width="10%">Order</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($addresses_list as $key => $value)
                            <tr class="rows" data-id="{{ $value->id }}" data-order="{{ $key }}">
                                <td>{{ $key+1 }}</td>
                                <td>{{ select_field('profiles', 'id', $value->user_id, 'name') }}</td>
                                <td>{{ $value->location }}</td>
                                <td>{{ $value->phone_no }}</td>
                                <td>{{ $value->address.', '. select_field('cities', 'id', $value->city, 'city') .', '. select_field('states', 'id', $value->province, 'name') .', '.$value->post_code.', '.select_field('countries', 'id', $value->country, 'name') }}</td>
                                <td>


                                    <a data-id="{{ $value->id }}" class="btn btn-info editRow btn-sm"
                                       data-toggle="modal"
                                       data-target="#editNewUser">
                                        Edit
                                    </a>

                                    <a href="{{ url('user/addresses/delete/'.$value->id) }}"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Are you sure you want to delete {{ addslashes($value->location) }}?');">Delete</a>

                                </td>
                                <td>


                                    <div class="btn-group-vertical" role="group" aria-label="Basic example">

                                        <a class="btn btn-secondary-outline  up btn-sm"><i class="fa fa-arrow-up"></i></a>
                                        <a class="btn btn-secondary-outline  down btn-sm"><i class="fa fa-arrow-down"></i></a>
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



    <div class="modal fade clearfix" id="addAddressModal" tabindex="-1" role="dialog" aria-labelledby="addAddressLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="addAddressLabel">Add Address</h4>
                </div>
                <div class="modal-body">


                    {!! Form::open(array('url' => 'user/addresses', 'id'=>'addressesForm', 'class'=>'form-horizontal','method'=>'post','role'=>'form')) !!}


                    <div class="form-group row">

                        <label class="col-sm-3">Location Name</label>

                        <div class="col-sm-9">

                            <input class="form-control" type="text" name="location"
                                   placeholder="Location Name"
                                   value="">

                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-3">Street Address </label>

                        <div class="col-sm-9">

                            <input class="form-control" type="text" name="address"
                                   placeholder="Street address"
                                   value="" required>
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-3" l>Postal Code</label>

                        <div class="col-sm-9">

                            <input class="form-control" type="text" name="post_code"
                                   placeholder="Postal Code"
                                   value=""></div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-3">Phone Number</label>

                        <div class="col-sm-9">

                            <input class="form-control" type="text" name="phone_no"
                                   placeholder="Phone Number"
                                   value=""></div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-3">Country </label>

                        <div class="col-sm-9">

                            <select name="country" class="form-control" required id="country"
                                    onchange="provinces('{{ addslashes(url("ajax")) }}', 'ON');">
                                <option value="">-Select One-</option>
                                @foreach($countries_list as $value)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-3">Province </label>

                        <div class="col-sm-9">

                            <select name="province" class="form-control" id="province" required
                                    onchange="cities('{{ addslashes(url("ajax")) }}', 'ON');">
                                <option value="">-Select One-</option>

                            </select></div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-3">City </label>

                        <div class="col-sm-9">

                            <input type="text" name="city" id="city" class="form-control" required></div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-3">Apartment </label>

                        <div class="col-sm-9">

                            <input type="text" name="apartment" class="form-control" placeholder="Street address"
                                   value=""
                                   required></div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-3">Buzz Code </label>

                        <div class="col-sm-9">

                            <input type="text" name="buzz" class="form-control" placeholder="Postal Code" value=""
                                   required>


                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>


                    <button type="submit" class="btn btn-primary">Save</button>
                    <input type="hidden" name="id" value="{{ (isset($addresse_detail->id))?$addresse_detail->id:'' }}"/>
                    {!! Form::close() !!}


                </div>
            </div>
        </div>
    </div>



    <div class="modal fade clearfix" id="editNewUser" tabindex="-1" role="dialog" aria-labelledby="editNewUserLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="editNewUserLabel">Update Address</h4>
                </div>
                <div class="modal-body" id="contents">

                </div>
            </div>
        </div>
    </div>



    @include('common.tabletools')


    <script type="text/javascript">
        $('body').on('click', '.editRow', function () {
            var id = $(this).attr('data-id');
            $('#editNewUser #loading').show();
            $('#editNewUser #contents').html('');
            $.get("{{ url('user/addresses/edit') }}/" + id, {}, function (result) {
                try {
                    if (jQuery.parseJSON(result).type == "error") {
                        var json = jQuery.parseJSON(result);
                        $('#editNewUser #message').show();
                        $('#editNewUser #message p').html(json.message);
                        $('#editNewUser #contents').html('');
                    }
                } catch (e) {
                    $('#editNewUser #message').hide();
                    $('#editNewUser #contents').html(result);
                }
                $('#editNewUser #loading').hide();
            });
        });

        $('body').on('click', '.up, .down', function () {
            var row = $(this).parents("tr:first");
            var token = $('#addressesForm input[name=_token]').val();
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

            $.post("{{ url('user/addresses/sequence') }}", {
                id: data_id.join('|'),
                order: data_order.join('|'),
                _token: token
            }, function (result) {
                if (result) {
                    alert(result);
                }
            });
        });
    </script>

    <script src="{{ url("assets/global/scripts/provinces.js") }}" type="text/javascript"></script>

    <!--
    <script src="https://maps.googleapis.com/maps/api/js?signed_in=true&libraries=places&callback=initAutocomplete" async defer></script>
    <SCRIPT>
        $(document).ready(function () {
            cities("{{ url('ajax') }}", '{{ (isset($addresse_detail->city))?$addresse_detail->city:0 }}');
        });
    </SCRIPT>
    -->
@stop