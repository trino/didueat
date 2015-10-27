@extends('layouts.default')
@section('content')

    <div class="content-page">
        <div class="container-fluid">
            <div class="row">

                @include('layouts.includes.leftsidebar')

                <div class="col-xs-12 col-md-10 col-sm-8">
                    @if(\Session::has('message'))
                        <div class="alert {!! Session::get('message-type') !!}">
                            <strong>{!! Session::get('message-short') !!}</strong>
                            &nbsp; {!! Session::get('message') !!}
                        </div>
                    @endif

                    <div class="container-fluid">

                        <div class="btn_wrapper margin-bottom-20 clearfix">
                            <a type="button" href="#addAddressForm" class="btn red pull-right fancybox-fast-view">Add address</a>
                        </div>

                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="box-shadow">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-globe"></i>MY ADDRESSES
                                </div>
                                <div class="tools">
                                </div>
                            </div>
                            <div class="portlet-body">
                                <table class="table table-striped table-bordered table-hover" id="sample_1">
                                    <thead>
                                    <tr>
                                        <th width="5%">ID</th>
                                        <th width="15%">Name</th>
                                        <th width="20%">Mobile #</th>
                                        <th width="25%">Address</th>
                                        <th width="15%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($addresses_list as $value)
                                        <tr>
                                            <td>{{ $value->id }}</td>
                                            <td>{{ select_field('profiles', 'id', $value->user_id, 'name') }}</td>
                                            <td>{{ $value->phone_no }}</td>
                                            <td>{{ $value->address.', '.$value->city.', '.$value->province.', '.$value->post_code.', '.select_field('countries', 'id', $value->country, 'name') }}</td>
                                            <td>
                                                <a href="#editNewUser" class="btn red fancybox-fast-view editRow"
                                                   data-id="{{ $value->id }}">Edit</a>
                                                <a href="{{ url('user/addresses/delete/'.$value->id) }}" class="btn red"
                                                   onclick="return confirm(' Are you sure you want to delete this ? ');">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- END EXAMPLE TABLE PORTLET-->

                        <div id="addAddressForm" class="col-md-12 col-sm-12 col-xs-12" style="display: none; width:900px;">
                            <div class="portlet-body form add_address_form">
                                <div class="portlet-title margin-bottom-10">
                                    <div class="caption">
                                        ADD ADDRESS
                                    </div>
                                </div>
                                <br />
                                <!-- BEGIN FORM-->
                                {!! Form::open(array('url' => 'user/addresses', 'id'=>'addressesForm', 'class'=>'form-horizontal','method'=>'post','role'=>'form')) !!}
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-5 col-sm-5 col-xs-12">Street Address <span class="required">*</span></label>

                                                <div class="col-md-7 col-sm-7 col-xs-12">
                                                    <input type="text" name="address" class="form-control" placeholder="Street address" value="" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-5 col-sm-5 col-xs-12">Postal Code</label>

                                                <div class="col-md-7 col-sm-7 col-xs-12">
                                                    <input type="text" name="post_code" class="form-control" placeholder="Postal Code" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/row-->

                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-5 col-sm-5 col-xs-12">City <span class="required">*</span></label>

                                                <div class="col-md-7 col-sm-7 col-xs-12">
                                                    <input type="text" name="city" class="form-control" placeholder="City" value="" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-5 col-sm-5 col-xs-12">Phone Number</label>

                                                <div class="col-md-7 col-sm-7 col-xs-12">
                                                    <input type="text" name="phone_no" class="form-control" placeholder="Phone Number" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-5 col-sm-5 col-xs-12">Province <span class="required">*</span></label>

                                                <div class="col-md-7 col-sm-7 col-xs-12">
                                                    <input type="text" name="province" class="form-control" placeholder="Province" value="" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-5 col-sm-5 col-xs-12">Country <span class="required">*</span></label>

                                                <div class="col-md-7 col-sm-7 col-xs-12">
                                                    <select name="country" class="form-control" required>
                                                        <option value="">-Select One-</option>
                                                        @foreach($countries_list as $value)
                                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/row-->
                                </div>
                                <br /><br />
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="row">
                                                <div class="col-md-offset-3 col-md-9 col-sm-9 col-xs-12">
                                                    <button type="submit" class="btn red">Submit</button>
                                                    <input type="hidden" name="id"
                                                           value="{{ (isset($addresse_detail->id))?$addresse_detail->id:'' }}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                        </div>
                                    </div>
                                </div>
                                {!! Form::close() !!}
                                        <!-- END FORM-->
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="editNewUser" class="col-md-12 col-sm-12 col-xs-12" style="display: none; width:900px;">
        <div id="loading" style="display: none; text-align: center;">
            <img src="{{ asset('assets/images/loader.gif') }}"/>
        </div>
        <div id="message" class="alert alert-danger" style="display: none;">
            <h1 class="block">Error</h1>

            <p></p>
        </div>
        <div id="contents"></div>
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
    </script>
@stop