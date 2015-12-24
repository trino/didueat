@extends('layouts.default')
@section('content')


            <div class="row">
                @include('layouts.includes.leftsidebar')

                <div class="col-lg-9">
                    <?php printfile("views/dashboard/restaurant/addresses.blade.php"); ?>
                    @if(\Session::has('message'))
                        <div class="alert {!! Session::get('message-type') !!}">
                            <strong>{!! Session::get('message-short') !!}</strong>
                            &nbsp; {!! Session::get('message') !!}
                        </div>
                    @endif

                    <div class="btn_wrapper margin-bottom-20 clearfix">
                        <a class="btn btn-danger red pull-right fancybox-fast-view" href="#addNewUser">Add New</a>
                    </div>

                    <div class="deleteme">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="box-shadow">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-globe"></i>MY NOTIFICATION ADDRESSES
                                </div>
                                <div class="tools"></div>
                            </div>
                            <div class="portlet-body">
                                <table class="table table-striped table-bordered table-hover" id="sample_1">
                                    <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="60%">Phone Number/Email Address</th>
                                        <th width="10%">Type</th>
                                        <th width="5%">Enabled</th>
                                        {{--<th width="15%">Status</th>--}}
                                        <th width="20%">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($addresses_list as $key => $value)
                                        <?php $status = "<a href='". url('restaurant/addresses/default/'.$value->id) ."' class='btn btn-danger red'>Make Default</a>"; ?>
                                        <tr class="rows" data-id="{{ $value->id }}" data-order="{{ $key }}">
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $value->address }}</td>
                                            <td>{{ $value->type }}</td>
                                            <TD><INPUT TYPE="CHECKBOX" ID="add_enable_{{ $value->id }}" CLASS="fullcheck" <?php if($value->enabled ){echo "CHECKED";} ?> ONCLICK="add_enable({{ $value->id }});"></TD>
                                            {{--<td>{!! ($value->is_default == 1)?'Default':$status !!}</td>--}}
                                            <td>
                                                <a href="{{ url('restaurant/addresses/delete/'.$value->id) }}" class="btn btn-danger red" onclick="return confirm('Are you sure you want to delete {{ addslashes($value->address) }} ?');">Delete</a>
                                                <a href="#editAddress" class="btn nomargin btn-info editAddress fancybox-fast-view" data-id="{{ $value->id }}">Edit</a>
                                                <a class="btn nomargin btn-info up"><i class="fa fa-arrow-up"></i></a>
                                                <a class="btn nomargin btn-info down"><i class="fa fa-arrow-down"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- END EXAMPLE TABLE PORTLET-->

                    </div>
                </div>

            </div>


    <div id="addNewUser" class="col-md-12" style="display: none;">
        <div class="modal-dialog">
            <div class="fancy-modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New</h4>
                </div>
                {!! Form::open(array('url' => '/restaurant/addresses', 'id'=>'addNewForm', 'class'=>'form-horizontal form-restaurants','method'=>'post','role'=>'form')) !!}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label col-md-3">Phone / Email</label>
                                <div class="col-md-9">
                                    <input type="text" name="address" class="form-control address" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">&nbsp;</label>
                                <div class="col-md-9 reach_type" style="display: none;">
                                    <label><input type="checkbox" name="is_call" value="1" checked> Call</label> &nbsp;
                                    <label><input type="checkbox" name="is_sms" value="1" checked> SMS</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="is_contact_type" class="is_contact_type" value="" />
                    <button type="submit" class="btn custom-default-btn saveNewBtn" disabled>Save changes</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div id="editAddress" class="col-md-12" style="display: none;">
        <div class="modal-dialog">
            <div class="fancy-modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update</h4>
                </div>
                {!! Form::open(array('url' => '/restaurant/addresses', 'name'=>'editForm', 'id'=>'editForm', 'class'=>'form-horizontal form-restaurants','method'=>'post','role'=>'form')) !!}
                <div id="editContents"></div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    @include('common.tabletools')

    <script>
        var ignore1 = false;
        function add_enable(ID){
            if(ignore1){
                ignore1=false;
                return;
            }
            var Value = 0;
            var element = document.getElementById('add_enable_' + ID);
            if(element.checked){Value = 1;}
            $.ajax({
                url: '{{addslashes(url('ajax'))}}',
                type: "post",
                dataType: "HTML",
                data: "type=add_enable&id=" + ID + "&value=" + Value,
                success: function(msg) {
                    if(msg){
                        ignore1 = true;
                        $(element).trigger("click");
                        alert(msg);
                    }
                }
            });
        }

        $('body').on('click', '.editAddress', function(){
            var id = $(this).attr('data-id');
            $.get("{{ url("restaurant/addresses/edit") }}/"+id, {}, function(result){
                $('#editForm #editContents').html(result);
            });
        });
        
        $('body').on('keyup', '.address', function(){
            var ep_emailval = $(this).val();
            var intRegex = /[0-9 -()+]+$/;
            if(intRegex.test(ep_emailval)) {
               $('.reach_type').show();
               $('.is_contact_type').val(1);
            } else {
               $('.reach_type').hide();
               $('.is_contact_type').val(0);
            }
            if(ep_emailval){
                $('.saveNewBtn').attr('disabled', false);
            } else {
                $('.saveNewBtn').attr('disabled', true);
            }
        });
        
        $('body').on('click', '.up, .down', function(){
            var row = $(this).parents("tr:first");
            var token = $('#addNewForm input[name=_token]').val();
            var order = $(this).parents("tr:first").attr('data-order');

            if ($(this).is(".up")) {
                row.insertBefore(row.prev());
            } else {
                row.insertAfter(row.next());
            }

            $( ".rows" ).each(function( index ) {
                $(this).attr("data-order", index);
            });

            var data_id = $(".rows").map(function() {
                return $(this).attr("data-id");
            }).get();
            var data_order = $(".rows").map(function() {
                return $(this).attr("data-order");
            }).get();

            $.post("{{ url('restaurant/addresses/sequence') }}", {id:data_id.join('|'), order:data_order.join('|'), _token:token}, function(result){
                if(result){
                    alert(result);
                }
            });
        });
    </script>

@stop
