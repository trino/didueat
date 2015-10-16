@extends('layouts.default')
@section('content')



<div class="content-page">
    <div class="row">

        @include('layouts.includes.leftsidebar')

        <div class="col-xs-12 col-md-10 col-sm-8">
            @if(\Session::has('message'))
            <div class="alert {!! Session::get('message-type') !!}">
                <strong>{!! Session::get('message-short') !!}</strong> &nbsp; {!! Session::get('message') !!}
            </div>
            @endif

            <div class="deleteme">

                <div class="btn_wrapper margin-bottom-20 clearfix">

                    <a type="button" href="#addAddressForm" class="btn red pull-right fancybox-fast-view">Add address</a>

                </div>

                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box red">
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
                                    <th width="15%">Mobile #</th>
                                    <th width="20%">Apartment/Unit/Room</th>
                                    <th width="20%">Buzz code/doorbell number</th>
                                    <th width="25%">Address</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($addresses_list as $value)
                                <tr>
                                    <td>{{ $value->id }}</td>
                                    <td>{{ $value->number }}</td>
                                    <td>{{ $value->apt }}</td>
                                    <td>{{ $value->buzz }}</td>
                                    <td>{{ $value->street.', '.$value->city.', '.$value->province.', '.$value->post_code.', '.select_field('countries', 'id', $value->country, 'name') }}</td>
                                    <td>
                                        <a href="#editNewUser" class="btn red fancybox-fast-view editRow" data-id="{{ $value->id }}">Edit</a>
                                        <a href="{{ url('user/addresses/delete/'.$value->id) }}" class="btn red" onclick="return confirm(' Are you sure you want to delete this ? ');">Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->


                <div class="portlet box red" style="display: none;">
                    <div class="portlet-title" >
                        <div class="caption">
                            <i class="fa fa-gift"></i> ADD ADDRESS
                        </div>
                    </div>
                    <div class="portlet-body form" id="addAddressForm">
                        <!-- BEGIN FORM-->
                        {!! Form::open(array('url' => 'user/addresses', 'id'=>'addressesForm', 'class'=>'form-horizontal','method'=>'post','role'=>'form')) !!}
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-5 col-sm-5 col-xs-12">Street Address <span class="required">*</span></label>
                                        <div class="col-md-7 col-sm-7 col-xs-12">
                                            <input type="text" name="street" class="form-control" placeholder="Street address" value="{{ (isset($addresse_detail->street))?$addresse_detail->street:'' }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-5 col-sm-5 col-xs-12">Postal Code</label>
                                        <div class="col-md-7 col-sm-7 col-xs-12">
                                            <input type="text" name="post_code" class="form-control" placeholder="Postal Code" value="{{ (isset($addresse_detail->post_code))?$addresse_detail->post_code:'' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-5 col-sm-5 col-xs-12">Apartment/Unit/ Room <span class="required">*</span></label>
                                        <div class="col-md-7 col-sm-7 col-xs-12">
                                            <input type="text" name="apt" class="form-control" placeholder="Name of the address" value="{{ (isset($addresse_detail->apt))?$addresse_detail->apt:'' }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-5 col-sm-5 col-xs-12">Buzz code/door bell number</label>
                                        <div class="col-md-7 col-sm-7 col-xs-12">
                                            <input type="text" name="buzz" class="form-control" placeholder="Buzz code or door bell number" value="{{ (isset($addresse_detail->buzz))?$addresse_detail->buzz:'' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-5 col-sm-5 col-xs-12">Mobile Number</label>
                                        <div class="col-md-7 col-sm-7 col-xs-12">
                                            <input type="text" name="number" class="form-control" placeholder="Mobile Number" value="{{ (isset($addresse_detail->number))?$addresse_detail->number:'' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-5 col-sm-5 col-xs-12">Phone Number</label>
                                        <div class="col-md-7 col-sm-7 col-xs-12">
                                            <input type="text" name="phone_no" class="form-control" placeholder="Phone Number" value="{{ (isset($addresse_detail->phone_no))?$addresse_detail->phone_no:'' }}">
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
                                            <input type="text" name="city" class="form-control" placeholder="City" value="{{ (isset($addresse_detail->city))?$addresse_detail->city:'' }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-5 col-sm-5 col-xs-12">Province <span class="required">*</span></label>
                                        <div class="col-md-7 col-sm-7 col-xs-12">
                                            <input type="text" name="province" class="form-control" placeholder="Province" value="{{ (isset($addresse_detail->province))?$addresse_detail->province:'' }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-5 col-sm-5 col-xs-12">Country <span class="required">*</span></label>
                                        <div class="col-md-7 col-sm-7 col-xs-12">
                                            <select name="country" class="form-control" required>
                                                <option value="">-Select One-</option>
                                                @foreach($countries_list as $value)
                                                <option value="{{ $value->id }}" {{ (isset($addresse_detail->country) && $addresse_detail->country == $value->id)? 'selected' :'' }}>{{ $value->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-5 col-sm-5 col-xs-12">Notes</label>
                                        <div class="col-md-7 col-sm-7 col-xs-12">
                                            <input type="text" name="notes" class="form-control" placeholder="Notes" value="{{ (isset($addresse_detail->notes))?$addresse_detail->notes:'' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/row-->
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9 col-sm-9 col-xs-12">
                                            <button type="submit" class="btn red">Submit</button>
                                            <input type="hidden" name="id" value="{{ (isset($addresse_detail->id))?$addresse_detail->id:'' }}" />
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


<div id="editNewUser" class="col-md-12 col-sm-12 col-xs-12" style="display: none; width: 630px;">
    <div id="loading" style="display: none; text-align: center;">
        <img src="{{ asset('assets/images/loader.gif') }}" />
    </div>
    <div id="message" class="alert alert-danger" style="display: none;">
        <h1 class="block">Error</h1>
        <p></p>
    </div>
    <div id="contents"></div>
</div>

@include('common.tabletools')

<script type="text/javascript">    
    $('body').on('click', '.editRow', function(){
        var id = $(this).attr('data-id');
        $('#editNewUser #loading').show();
        $('#editNewUser #contents').html('');
        $.get("{{ url('user/addresses/edit') }}/"+id, {}, function(result){
            try {
                if(jQuery.parseJSON(result).type == "error"){
                    var json = jQuery.parseJSON(result);
                    $('#editNewUser #message').show();
                    $('#editNewUser #message p').html(json.message);
                    $('#editNewUser #contents').html('');
                }
             } catch(e) {
                $('#editNewUser #message').hide();
                $('#editNewUser #contents').html(result);
             }
            $('#editNewUser #loading').hide();
        });
    });
</script>
@stop