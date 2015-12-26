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

            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#addAddressModal">
                Add Address
            </button>


            <h1>MY ADDRESSES</h1>

            <table class="table table-striped table-bordered table-hover" id="sample_1">
                <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="15%">User Name</th>
                    <th width="15%">Address Name</th>
                    <th width="15%">Mobile #</th>
                    <th width="25%">Address</th>
                    <th width="20%">Action</th>
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



                            <!--a href="#editNewUser" class="btn nomargin btn-info fancybox-fast-view editRow"
                               data-id="{{ $value->id }}">Edit</a-->


                            <button   data-id="{{ $value->id }}" type="button" class="btn btn-danger editRow" data-toggle="modal" data-target="#editNewUser" >
                                Edit
                            </button>

                            <a href="{{ url('user/addresses/delete/'.$value->id) }}" class="btn red"
                               onclick="return confirm('Are you sure you want to delete {{ addslashes($value->location) }}?');">Delete</a>
                            <a class="btn nomargin btn-info up"><i class="fa fa-arrow-up"></i></a>
                            <a class="btn nomargin btn-info down"><i class="fa fa-arrow-down"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>


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
                    <label>Location Name</label>
                    <input type="text" name="location" class="form-control"
                           placeholder="Location Name"
                           value="">
                    <label>Street Address <span
                                class="required">*</span></label>
                    <input type="text" name="address" class="form-control"
                           placeholder="Street address"
                           value="" required>
                    <label>Postal Code</label>
                    <input type="text" name="post_code" class="form-control"
                           placeholder="Postal Code"
                           value="">
                    <label>Phone Number</label>
                    <input type="text" name="phone_no" class="form-control"
                           placeholder="Phone Number"
                           value="">
                    <label>Country <span
                                class="required">*</span></label>
                    <select name="country" class="form-control" required id="country"
                            onchange="provinces('{{ addslashes(url("ajax")) }}', 'ON');">
                        <option value="">-Select One-</option>
                        @foreach($countries_list as $value)
                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                        @endforeach
                    </select>

                    <label>Province <span
                                class="required">*</span></label>
                    <select name="province" class="form-control" id="province" required
                            onchange="cities('{{ addslashes(url("ajax")) }}', 'ON');">
                        <option value="">-Select One-</option>

                    </select>
                    <label>City <span
                                class="required">*</span></label>
                    <input type="text" name="city" id="city" class="form-control" required>
                    <label>Apartment <span
                               class="required">*</span></label>
                    <input type="text" name="apartment" class="form-control" placeholder="Street address" value=""
                           required>
                    <label>Buzz Code <span
                                class="required">*</span></label>
                    <input type="text" name="buzz" class="form-control" placeholder="Postal Code" value="" required>
                    <button type="submit" class="btn red">Submit</button>
                    <input type="hidden" name="id" value="{{ (isset($addresse_detail->id))?$addresse_detail->id:'' }}"/>
                    {!! Form::close() !!}


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>


    <!--div id="editNewUser" class="col-md-12 col-sm-12 col-xs-12 popup-dialog-900" style="display: none;">
        <div id="loading" class="center" style="display: none;">
            <img src="{{ asset('assets/images/loader.gif') }}"/>
        </div>
        <div id="message" class="alert alert-danger" style="display: none;">
            <h1 class="block">Error</h1>

            <p></p>
        </div>
        <div id="contents"></div>
    </div-->




    <div class="modal  fade clearfix" id="editNewUser" tabindex="-1" role="dialog" aria-labelledby="editNewUserLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="editNewUserLabel">Add Addresss</h4>
                </div>
                <div class="modal-body">
                    <div id="loading" class="center" style="display: none;">
                        <img src="{{ asset('assets/images/loader.gif') }}"/>
                    </div>
                    <div id="message" class="alert alert-danger" style="display: none;">
                        <h1 class="block">Error</h1>

                        <p></p>
                    </div>
                    <div id="contents"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
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
@stop