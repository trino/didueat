@extends('layouts.default')
@section('content')

<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/clockface/css/clockface.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/bootstrap-datepicker/css/datepicker3.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/bootstrap-colorpicker/css/colorpicker.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}"/>
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN THEME STYLES -->
<link href="{{ asset('assets/global/css/components.css') }}" id="style_components" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/global/css/plugins.css') }}" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->

<div class="margin-bottom-40">
    <div class="slide">
        <div class="text">
            We'll bring the customers to you    
            <h3>Put your menu online. Average revenue increase ranging 15-25% a year!</h3>
        </div>
    </div>

    <div class="heading">
        <div class="text"><b>How</b> It Works</div>
    </div>

    <div class="intro">
        <div class="text">
            Did U Eat is dedicated to connecting local restaurants to hungry customers. Instead of having an exhausting menu for customers to look through, we do things a bit differently. Our restaurants feature a meal of the day for each day of the week. The customer simply selects the food category they feel like having, choose the meal that appeals to them, place their order through the site, pick up/wait for delivery, and enjoy. That's it!
            We pride ourselves on our easy ordering system so customers spend less time ordering and enjoy more time eating. What are you waiting for? Sign up now and let the Did U Eat team bring the customers to you.
            By putting your restaurant online with Did U Eat, you'll be getting more business from hungry customers in your local area
            Diners on our sites browse your menu and place an order from their computer or web app. Once that's done, our system sends you the order to be made and delivered just like you do now.
            You'll only pay on orders we send you
            <button class="btn-3">Sign Up Now </button>
        </div>
    </div>

    <div class="heading">
        <div class="text"><b>Receive Orders</b> In 10 Mins</div>
    </div>

    <div class="grid">
        <div class="col-1-3">
            <div class="module">
                <img src="{{ url('assets/images/click.png') }}">
                <h3>Sign Up</h3>
                <p>Sign up or contact us today to book an appointment with one of our team members.</p>
            </div>
        </div>
        <div class="col-1-3">
            <div class="module">
                <img src="{{ url('assets/images/clip.png') }}">
                <h3>Create Menu</h3>
                <p>Do it yourself menu creation, update anytime.</p>
            </div>
        </div>
        <div class="col-1-3">
            <div class="module">
                <img src="{{ url('assets/images/box.png') }}">
                <h3>Receive Orders</h3>
                <p>Start receiving orders in as little as 10 minutes.</p>
            </div>
        </div>
    </div>


    <div class="services">
        <div class="eyes">
            <div class="texted"><b>Our</b> Services</div>
        </div>

        <div class="row margin-bottom-40" style="margin-top: 50px; padding: 30px;">
            <!-- Pricing -->

            <div class="col-md-3">
                <div class="pricing pricing-active hover-effect">
                    <div class="pricing-head pricing-head-active">
                        <h3>Expert
                            <span>
                                Officia deserunt mollitia
                            </span>
                        </h3>
                        <h4><i>$</i>13<i>.99</i>
                            <span>
                                Per Month
                            </span>
                        </h4>
                    </div>
                    <ul class="pricing-content list-unstyled">
                        <li>
                            <i class="fa fa-tags"></i> At vero eos
                        </li>
                        <li>
                            <i class="fa fa-asterisk"></i> No Support
                        </li>
                        <li>
                            <i class="fa fa-heart"></i> Fusce condimentum
                        </li>
                        <li>
                            <i class="fa fa-star"></i> Ut non libero
                        </li>
                        <li>
                            <i class="fa fa-shopping-cart"></i> Consecte adiping elit
                        </li>
                    </ul>
                    <div class="pricing-footer">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero magna psum olor .
                        </p>
                        <a href="#" class="btn btn-primary">
                            Sign Up <i class="m-icon-swapright m-icon-white"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                @if(Session::has('message'))
                        <div class="alert alert-danger">
                            <strong>Alert!</strong> &nbsp; {!! Session::get('message') !!}
                        </div>
                @endif
                
                {!! Form::open(array('url' => '/restaurants/signup', 'id'=>'signupForm', 'class'=>'form-horizontal form-restaurants','method'=>'post','role'=>'form', 'enctype'=>'multipart/form-data')) !!}
                <div class="row margin-bottom-20">
                    <div class="col-md-4 col-sm-4 profilepic">
                        <h3 class="form-section">Restaurant Image</h3>
                        <img id="picture" src="{{ asset('assets/images/default.png') }}" title="" style="width: 100%;"><br>
                        <a href="javascript:void(0);" id="uploadbtn" class="btn btn-success" onclick="document.getElementById('hiddenLogo').click(); return false">Change Image</a>
                        <input type="file" name="logo" id="hiddenLogo" style="display: none;" />
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <div class="col-md-12 col-sm-12 col-xs-12 no-padding">
                            <h3 class="form-section">Restaurant Info</h3>
                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <div class="row">
                                    <label class="col-lg-12 col-sm-12 control-label col-xs-12 margin-bottom-10" for="Name">Restaurant Name <span class="require">*</span></label>
                                    <div class="col-lg-12 col-sm-12 col-xs-12">
                                        <input type="text" name="Name" class="form-control" value="{{ old('Name') }}" placeholder="i.e. Pho" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <div class="row">
                                    <label class="col-lg-12 col-sm-12 control-label col-xs-12 margin-bottom-10" for="Email">Restaurant Email <span class="require">*</span></label>
                                    <div class="col-lg-12 col-sm-12 col-xs-12">
                                        <input type="text" name="Email" class="form-control" value="{{ old('Email') }}" placeholder="i.e. Pho@didueat.com" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <div class="row">
                                    <label class="col-lg-12 col-sm-12 control-label col-xs-12 margin-bottom-10" for="Phone">Phone Number</label>
                                    <div class="col-lg-12 col-sm-12 col-xs-12">
                                        <input type="text" name="Phone" class="form-control" value="{{ old('Phone') }}" placeholder="i.e.905 555 5555">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <div class="row">
                                    <p class="inputs">
                                        <label class="col-lg-12 col-sm-12 control-label col-xs-12 margin-bottom-10" for="desc">Description </label>
                                    </p>
                                    <div class="col-lg-12 col-sm-12 col-xs-12">
                                        <textarea name="Description" placeholder="Description" title="Description">{{ old('Description') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <h3 class="form-section">Address</h3>
                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <div class="row">
                                    <label class="col-lg-12 col-md-12 col-sm-12 control-label col-xs-12 margin-bottom-10" for="Postal_Code">Country <span class="require">*</span></label>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <select name="Country" class="form-control" required>
                                            <option value="">-Select One-</option>
                                            @foreach($countries_list as $value)
                                                <option value="{{ $value->id }}" @if(old('Country') == $value->id) selected @endif>{{ $value->name }}</option>
                                            @endforeach
                                        </select>                        
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <div class="row">
                                    <label class="col-lg-12 col-md-12 col-sm-12 control-label col-xs-12 margin-bottom-10" for="Postal_Code">Province <span class="require">*</span></label>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <input type="text" name="Province" class="form-control" placeholder="Province Name" value="{{ old('Province') }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <div class="row">
                                    <label class="col-lg-12 col-sm-12 col-md-12 control-label col-xs-12 margin-bottom-10" for="Street_Address">Street Address <span class="require">*</span></label>
                                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                        <input type="text" name="Address" class="form-control" value="{{ old('Address') }}" placeholder="i.e. 1230 Main Street East" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <div class="row">
                                    <label class="col-lg-12 col-md-12 col-sm-12 control-label col-xs-12 margin-bottom-10" for="City">City <span class="require">*</span></label>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <input type="text" name="City" class="form-control" placeholder="i.e. Hamilton" value="{{ old('City') }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <div class="row">
                                    <label class="col-lg-12 col-md-12 col-sm-12 control-label col-xs-12 margin-bottom-10" for="Postal_Code">Postal Code <span class="require">*</span></label>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <input type="text" name="PostalCode" class="form-control" value="{{ old('PostalCode') }}" placeholder="i.e. L9A 1V7" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <div class="row">
                                    <label class="col-lg-12 col-md-12 col-sm-12 control-label col-xs-12 margin-bottom-10" for="Postal_Code">Genre</label>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <select name="Genre" class="form-control">
                                            <option value="">-Select One-</option>
                                            @foreach($genre_list as $value)
                                            <option value="{{ $value->ID }}" @if(old('Genre') == $value->ID) selected @endif>{{ $value->Name }}</option>
                                            @endforeach
                                        </select>                      
                                    </div>
                                </div>
                            </div>
                            <!--</p>-->
                        </div>

                        <h3 class="form-section">Hours of Operation</h3>
                        <?php
                        $dayofweek = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
                        foreach ($dayofweek as $key => $value) {
                            $open[$key] = select_field_where('hours', array('RestaurantID' => \Session::get('session_restaurantId'), 'DayOfWeek' => $value), 'Open');
                            $close[$key] = select_field_where('hours', array('RestaurantID' => \Session::get('session_restaurantId'), 'DayOfWeek' => $value), 'Close');
                            ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-2 padding-top-5"><?php echo $value; ?></label>
                                        <div class="col-md-4">
                                            <input type="text" name="Open[<?php echo $key; ?>]" value="" data-format="hh:mm A" class="form-control clockface_1"/>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="Close[<?php echo $key; ?>]" value="" data-format="hh:mm A" class="form-control clockface_1"/>
                                            <input type="hidden" name="DayOfWeek[<?php echo $key; ?>]" value="<?php echo $value; ?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="shop__divider">
                        <?php } ?>

                        <h3 class="form-section">Delivery</h3>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="control-label">Delivery Fee <span class="required">*</span></label>
                                <input type="text" name="DeliveryFee" class="form-control" placeholder="Delivery Fee" value="{{ old('DeliveryFee') }}" required>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="control-label">Minimum Sub Total For Delivery <span class="required">*</span></label>
                                <input type="text" name="Minimum" class="form-control" placeholder="Minimum Sub Total For Delivery" value="{{ old('Minimum') }}" required>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr class="shop__divider">
                        <input type="submit" class="btn btn-primary" value="Save Changes">
                    </div>
                    <br><br>
                </div>
                {!! Form::close() !!}
                <!--//End Pricing -->
            </div>
        </div>
        <div class="clearfix"></div>
    </div>            
</div>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{ asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/global/plugins/select2/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/clockface/js/clockface.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap-daterangepicker/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ asset('assets/global/scripts/metronic.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/layout/scripts/demo.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/pages/scripts/components-pickers.js') }}"></script>
<script src="{{ asset('assets/admin/pages/scripts/table-advanced.js') }}"></script>
<script src="{{ asset('assets/admin/pages/scripts/form-samples.js') }}"></script>
<script src="{{ asset('assets/admin/pages/scripts/form-validation.js') }}"></script>

<script type="text/javascript">
$(document).ready(function() {
    Metronic.init();
    Demo.init();
    ComponentsPickers.init();
    $("#signupForm").validate();
    FormSamples.init();
});
</script>
@stop