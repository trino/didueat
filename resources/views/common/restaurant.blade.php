<?php
    //restaurant signup page
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
    $alts = array(
        "terms" => "Terms and conditions"
    );
    // means they are logged in and have already registered as a restaurant
    if(Session::get('session_type_user') != "restaurant"){ ?>
        <meta name="_token" class="csrftoken" content="{{ csrf_token() }}"/>
        <?php printfile("views/common/restaurant.blade.php"); ?>

        <div class="col-md-8  col-md-offset-2">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Your Restaurant</h4>
                </div>

                <div class="card-block">
                    <div class="row">
                        <?php echo view('dashboard.restaurant.restaurant', array('cuisine_list' => $cuisine_list, "new" => true, "email" => false, "minimum" => $minimum, "restSignUpPg" => true)); ?>
                    </div>
                </div>

                <hr class="m-a-0" />

                <div class="card-block " ID="common_editaddress">
                    @include("common.editaddress", array("new" => false, "required" => true, "restSignUp" => true))
                </div>
            </div>

            <div class="card">
                <div class="card-header ">
                    <h4 class="card-title">Your Profile</h4>
                </div>
                <div class="card-block ">
                    @include("common.contactinfo", array("new"=>false, "ismobile" => true))
                </div>
                <div class="card-block p-t-0 ">
                    <p class="text-muted  "  align="center" >
                        By signing up, you agree to the <a href="#" title="{{ $alts["terms"] }}" data-toggle="modal" data-target="#allergyModal" data-id="popups.terms" class="simplemodal">Terms & Conditions</a>.
                    </p>

                    <input type="submit" class="btn btn-primary btn-block" value="Sign up">
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

            </div>
        </div>

<?php } ?>