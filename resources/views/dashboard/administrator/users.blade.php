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
                    <a class="btn red pull-right fancybox-fast-view" href="#addNewUser">Add New</a>

                    <div class="clearfix"></div>
                    <hr class="shop__divider">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="box-shadow">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-globe"></i>Users List
                            </div>
                            <div class="tools">
                            </div>
                        </div>
                        <div class="portlet-body">
                            <table class="table table-striped table-bordered table-hover" id="sample_1">
                                <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="25%">Name</th>
                                    <th width="25%">Email</th>
                                    <th width="15%">Phone</th>
                                    <th width="10%">Type</th>
                                    <th width="20%">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users_list as $value)
                                    <tr>
                                        <td>{{ $value->id }}</td>
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->email }}</td>
                                        <td>{{ $value->phone }}</td>
                                        <td>{{ select_field('profiletypes', 'id', $value->profile_type, 'name') }}</td>
                                        <td>
                                            <a href="{{ url('restaurant/users/action/user_fire/'.$value->id) }}"
                                               class="btn red"
                                               onclick="return confirm('Are you sure you want to fire <?= addslashes($value->name); ?>?');">Fire</a>
                                            <a href="{{ url('restaurant/users/action/user_possess/'.$value->id) }}"
                                               class="btn blue"
                                               onclick="return confirm('Are you sure you want to possess <?= addslashes($value->name); ?>?');">Possess</a>
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
    </div>
    <!-- END CONTENT -->



    <div id="addNewUser" class="col-md-12 col-sm-12 col-xs-12" style="display: none; width:500px;">
        <div class="modal-dialog2">
            <div class="fancy-modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New</h4>
                </div>
                {!! Form::open(array('url' => '/restaurant/users', 'id'=>'addNewForm', 'class'=>'form-horizontal form-restaurants','method'=>'post','role'=>'form')) !!}

                <div class="form-group">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <select name="profile_type" class="form-control">
                            <option value="1">Super</option>
                            <option value="2">User</option>
                            <option value="3">Owner</option>
                            <option value="4">Employee</option>
                        </select>
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group clearfix">
                        <label for="name" class="col-md-12 col-sm-12 col-xs-12 control-label">Name<span class="require">*</span></label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="input-icon">
                                <i class="fa fa-user"></i>
                                <input type="text" name="name" class="form-control" id="name" placeholder="Full Name" value="" required="">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group clearfix">
                        <label for="phone" class="col-md-12 col-sm-12 col-xs-12 control-label">Phone<span class="require">*</span></label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="input-icon">
                                <i class="fa fa-phone"></i>
                                <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone number" value="" required="">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group clearfix">
                        <label for="email" class="col-md-12 col-sm-12 col-xs-12 control-label">Email<span class="require">*</span></label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="input-icon">
                                <i class="fa fa-envelope"></i>
                                <input type="email" name="email" class="form-control" id="email" placeholder="Email Address" value="" required="">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="modal-header">
                    <h4 class="modal-title">Change Password</h4>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group clearfix">
                        <label for="password" class="col-md-12 col-sm-12 col-xs-12 control-label">New Password<span class="require">*</span></label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="input-icon">
                                <i class="fa fa-key"></i>
                                <input type="password" name="password" class="form-control" id="password" placeholder="Password" required="">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group clearfix">
                        <label for="confirm_password" class="col-md-12 col-sm-12 col-xs-12 control-label">Re-type Password<span class="require">*</span></label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="input-icon">
                                <i class="fa fa-key"></i>
                                <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Re-type Password" required="">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group clearfix">
                        <label for="subscribed" class="col-md-12 col-sm-12 col-xs-12 control-label">&nbsp;</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label>
                                <input type="checkbox" name="subscribed" id="subscribed" value="1" checked />
                                Sign up for our Newsletter
                            </label>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="modal-footer">
                    <button type="submit" class="btn red">Save changes</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <!-- /.modal-content -->






    @include('common.tabletools')


@stop