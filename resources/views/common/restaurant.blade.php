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
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="control-label">Restaurant Name </label>
                            <input type="text" name="restname" class="form-control" placeholder="Restaurant Name" value="{{ old('restname') }}" required>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="control-label">Description</label>
                            <textarea name="description" class="form-control" placeholder="Description">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label>Cuisine Type</label>
                            <select name="cuisine" id="cuisine" class="form-control">
                                <option value="">-Select One-</option>
                                @foreach($cuisine_list as $value)
                                    <option value="{{ $value->id }}" @if(old('cuisine') == $value->id) selected @endif>{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="control-label">Tags</label>
                            <textarea id="demo4"></textarea>
                            <input type="hidden" name="tags" id="responseTags" value="" />
                            <p>e.g: Candian, Italian, Chinese, FastFood</p>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <h3 class="form-section">Delivery</h3>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="control-label"><input type="checkbox" name="is_pickup" id="is_pickup" value="1" {{ (old('is_pickup') && old('is_pickup') > 0)?'checked':'' }} /> Allow pickup</label> <br />
                            <label class="control-label"><input type="checkbox" name="is_delivery" id="is_delivery" value="1" {{ (old('is_delivery') && old('is_delivery') > 0)?'checked':'' }} /> Allow home delivery</label>
                        </div>
                    </div>

                    <div id="is_delivery_options" style="display: {{ (old('is_delivery') && old('is_delivery') > 0)?'block':'none' }};">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label">Max Delivery Distance </label>
                                <select name="max_delivery_distance" id="max_delivery_distance" class="form-control">
                                    <option value="10">Between 1 and 10 km</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label class="control-label">Delivery Fee </label>
                                <input type="number" name="delivery_fee" class="form-control" placeholder="Delivery Fee" value="{{ old('delivery_fee') }}" >
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label class="control-label">Min. Subtotal before Delivery </label>
                                <input type="number" name="minimum" class="form-control" placeholder="Minimum Subtotal For Delivery" value="{{ old('minimum') }}" >
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <h3 class="form-section">Logo</h3>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <img id="picture" class="margin-bottom-10" style="max-width: 100%" src="{{ $restaurant_logo.'?'.mt_rand() }}" />
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12" align="center">
                            <a href="javascript:void(0);" id="uploadbtn" class="btn btn-success red">Change Image</a>
                        </div>
                        <input type="hidden" name="logo" id="hiddenLogo" />
                    </div>
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