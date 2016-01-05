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
                @include("dashboard.restaurant.hours", array("layout" => true, "new" => true))
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
                    @include("common.contactinfo", array("new"=>true))

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