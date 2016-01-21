<?php
    if(!isset($restaurant)){$restaurant = "";}
    $Genre = priority2($restaurant, "genre");
    $RestID = "";
    $Country = "";
    $Field = "restname";
    if(isset($restaurant->id)){
        $RestID = '<input type="hidden" name="id" value="' . $restaurant->id . '"/>';
        $Country = $restaurant->country;
        $Field = "name";
    }
    $restaurant_logo = asset('assets/images/default.png');
    if(isset($restaurant->logo) && $restaurant->logo){
        $restaurant_logo = asset('assets/images/restaurants/'.$restaurant->logo);
    }
    if(!isset($cols)){$cols=3;}
    if(!isset($minimum)){$minimum=false;}
    $cols = 12/$cols;
?>

<meta name="_token" content="{{ csrf_token() }}"/>

<div class="col-md-{{ $cols }} col-sm-12 col-xs-12 ">
    <?php printfile("views/common/restaurant.blade.php"); ?>
    <div class="box-shadow">
        <div class="portlet-body form">
            <DIV CLASS="form-body row">

                <div class="row">
        <div class="portlet-title">
            <div class="caption">
                <b><u>CREATE USERNAME & PASSWORD</u></b>
            </div>
        </div>
                
                    <?php echo view('dashboard.restaurant.restaurant', array('cuisine_list' => $cuisine_list, "new" => true, "email" => false, "minimum" => $minimum)); ?>
                </div>
        
                <div class="row">
        <div class="portlet-title">
            <div class="caption">
                <u><b>NAME, EMAIL & PASSWORD</b></u>
            </div>
        </div>
                    @include("common.contactinfo", array("new"=>true, "mobile" => true))
                    <div class="col-md-12 col-sm-12 col-xs-12" style="text-align:right">
                        <input type="submit" class="btn btn-primary red" value="Save Changes">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="col-md-{{ $cols }} col-sm-12 col-xs-12 ">
    <div class="box-shadow">
        <div class="portlet-title">
            <div class="caption">
                <u><b>RESTAURANT ADDRESS</b></u>
            </div>
        </div>
        <div class="portlet-body form">
            <div class="form-body">
                <div class="row">
                    <?php echo view("common.editaddress", array("new" => true, "required" => true)); ?>
                </div>
            </div>
        </div>
    </div>
</div>

@if(!isset($hours))
    <div class="col-md-{{ $cols }} col-sm-12 col-xs-12">
        <div class="box-shadow">
            <div class="portlet-title">
                <div class="caption">
                    HOURS
                </div>
            </div>
            <div class="portlet-body form">
                <div class="form-body">
                    @include("dashboard.restaurant.hours", array("layout" => true, "new" => true, "restaurant" => $restaurant))
                </div>
            </div>
        </div>
    </div>
@endif

<!--
<script src="{{ url("assets/global/scripts/provinces.js") }}" type="text/javascript"></script>
<script src="https://maps.googleapis.com/maps/api/js?signed_in=true&libraries=places&callback=initAutocomplete" async defer></script>
<SCRIPT>
    $(document).ready(function () {
        cities("{{ url('ajax') }}", '{{ (isset($addresse_detail->city))?$addresse_detail->city:0 }}');
    });
</SCRIPT>
-->