<?php
if (!isset($restaurant)) {
    $restaurant = "";
}
$Genre = priority2($restaurant, "genre");
$RestID = "";
$Country = "";
$Field = "restname";
if (isset($restaurant->id)) {
    $RestID = '<input type="hidden" name="id" value="' . $restaurant->id . '"/>';
    $Country = $restaurant->country;
    $Field = "name";
}
$restaurant_logo = asset('assets/images/default.png');
if (isset($restaurant->logo) && $restaurant->logo) {
    $restaurant_logo = asset('assets/images/restaurants/' . $restaurant->logo);
}

if(Session::get('session_type_user') != "restaurant"){
// means they are logged in and have already registered as a restaurant
?>


<meta name="_token" content="{{ csrf_token() }}"/>
<?php printfile("views/common/restaurant.blade.php"); ?>

<div class="col-md-8  col-md-offset-2">


    <div class="card">
        <div class="card-header ">

                    <h3>Your Restaurant</h3>

        </div>

        <div class="card-block ">


            @include('dashboard.restaurant.restaurant', array('cuisine_list' => $cuisine_list, "new" => false, "email" => false, "minimum" => $minimum))

            @include("common.editaddress", array("new" => false, "required" => true, "restSignUp" => true))
</div>

        <div class="card-header ">

            <h3>Your Profile</h3>

        </div>
        <div class="card-block ">

        @include("common.contactinfo", array("new"=>false, "mobile" => true))


        </div>

        <div class="card-footer clearfix">

            <input type="submit" class="btn btn-primary pull-right" value="Signup">


        </div>
    </div>


</div>



@if(false)
    @if(!isset($hours))
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="box-shadow">
                <div class="portlet-title">
                    <div class="caption">
                        HOURS
                    </div>
                </div>
                <div class="portlet-body form">
                    <div class="form-body">
                        <?php echo view("dashboard.restaurant.hours", array("layout" => true, "new" => true, "restaurant" => $restaurant)); ?>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif


<?php
}
?>

