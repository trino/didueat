<?php
    if(!isset($resturant)){$resturant = "";}
    $Genre = priority2($resturant, "genre");
    $RestID = "";
    $Country = "";
    $Field = "restname";
    if(isset($resturant->id)){
        $RestID = '<input type="hidden" name="id" value="' . $resturant->id . '"/>';
        $Country = $resturant->country;
        $Field = "name";
    }
    $restaurant_logo = asset('assets/images/default.png');
    if(isset($resturant->logo) && $resturant->logo){
        $restaurant_logo = asset('assets/images/restaurants/'.$resturant->logo);
    }
?>
<meta name="_token" content="{{ csrf_token() }}"/>

<div class="col-md-4 col-sm-12 col-xs-12 ">
    <?php printfile("views/common/restaurant.blade.php"); ?>
    <div class="box-shadow">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-long-arrow-right"></i> RESTAURANT INFO
            </div>
        </div>
        <div class="portlet-body form">

            <div class="form-body">
                <div class="row">
                    <?php echo view('dashboard.restaurant.restaurant', array('cuisine_list' => $cuisine_list, "new" => true)); ?>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="col-md-4 col-sm-12 col-xs-12 ">
    <div class="box-shadow">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-long-arrow-right"></i> ADDRESS
            </div>
        </div>
        <div class="portlet-body form">
            <div class="form-body">
                <div class="row">
                    <?php echo view("common.editaddress", array("new" => true)); ?>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="control-label">Mobile Number (Optional)</label>
                            <input type="text" name="mobile" class="form-control" placeholder="Mobile Number" value="{{ old('mobile') }}" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-4 col-sm-12 col-xs-12">
    <div class="box-shadow">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-long-arrow-right"></i> HOURS
            </div>
        </div>
        <div class="portlet-body form">
            <div class="form-body">
                @include("dashboard.restaurant.hours", array("layout" => true))
            </div>
        </div>
    </div>
</div>


<div class="col-md-4 col-sm-12 col-xs-12">
    <div class=" box-shadow">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-long-arrow-right"></i> CREATE USERNAME & PASSWORD
            </div>
        </div>
        <div class="portlet-body form">
            <DIV CLASS="form-body">
                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group clearfix">
                            <label for="name" class="col-md-12 col-sm-12 col-xs-12 control-label">Full Name </label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="input-icon">
                                    <input type="text" name="full_name" class="form-control" id="name" placeholder="Full Name" value="{{ old('full_name') }}" required="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group clearfix">
                            <label for="email" class="col-md-12 col-sm-12 col-xs-12 control-label">Email </label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="input-icon">
                                    <input type="email" name="email" class="form-control" id="email" placeholder="Email Address" value="{{ old('email') }}" required="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-long-arrow-right"></i> Choose Password
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group clearfix">
                            <label for="password" class="col-md-12 col-sm-12 col-xs-12 control-label">Password </label>

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="input-icon">
                                    <input type="password" name="password1" class="form-control" id="password1" placeholder="Password" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group clearfix">
                            <label for="confirm_password" class="col-md-12 col-sm-12 col-xs-12 control-label">Re-type Password </label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="input-icon">
                                    <input type="password" name="confirm_password1" class="form-control" id="confirm_password1" placeholder="Re-type Password" required>
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
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <input type="submit" class="btn btn-primary red" value="Save Changes">
                    </div>
                </div>
            </div>
        </div>
    </div>
</DIV>
<!--
<script src="{{ url("assets/global/scripts/provinces.js") }}" type="text/javascript"></script>
<script src="https://maps.googleapis.com/maps/api/js?signed_in=true&libraries=places&callback=initAutocomplete" async defer></script>
<SCRIPT>
    $(document).ready(function () {
        cities("{{ url('ajax') }}", '{{ (isset($addresse_detail->city))?$addresse_detail->city:0 }}');
    });
</SCRIPT>
-->