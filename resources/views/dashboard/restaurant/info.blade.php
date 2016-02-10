@extends('layouts.default')
@section('content')

    <meta name="_token" content="{{ csrf_token() }}"/>

    <script>
        function validateFn(f) {
            var cuisinesStr = "";
            var noneChkd = true;
            var comma = "";
            for (var i = 0; i < cuisineCnt; i++) {
                if (f.elements["cuisine" + i].checked) {
                    noneChkd = false;
                    if (cuisinesStr != "") {
                        comma = ",";
                    }
                    cuisinesStr += comma + f.elements["cuisine" + i].value
                }
            }
            f.cuisines.value = cuisinesStr;

            if (noneChkd) {
                alert("You must select at least one Cuisine in order to continue. You may make adjustments later.");
                f.description.focus(); // bring user to cuisine list
                return false;
            }

        }
    </script>






    <div class="container">


        <div class="row">

        @include('layouts.includes.leftsidebar')

        <div class="col-lg-9 ">
            <?php printfile("views/dashboard/restaurant/info.blade.php"); ?>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Restaurant Info</h4>
                </div>

                <div class="card-block">
                    {!! Form::open(array('url' => 'restaurant/info', 'onsubmit' => 'return validateFn(this)', 'id'=>'resturantForm', 'class'=>'horizontal-form','method'=>'post','role'=>'form', 'enctype'=>'multipart/form-data')) !!}

                    <input type="hidden" name="id" value="{{ ((isset($resturant->id))?$resturant->id:0) }}"/><br/>

                <?php
                    $is_disabled = false;
                    if (isset($route) && $route == "restaurant/view/{view}") {
                        $is_disabled = " DISABLED";
                    }
                    echo view('dashboard.restaurant.restaurant', array("restaurant" => $resturant, 'cuisine_list' => $cuisine_list, "new" => false, "is_disabled" => $is_disabled));
                    ?>
                </div>
            </div>



            <div class="card">
                <div class="card-header"><a name="PickupAndDelivery"></a>
                    <h4 class="card-title">Hours & Delivery</h4>
                </div>
                <div class="card-block">
                    @include("dashboard.restaurant.hours", array("new" => false, "restaurant" => $resturant, "is_disabled" => $is_disabled, "style" => 2, "showDeliveryOptions" => true))
                    <div class="clearfix"></div>
                </div>


                {!! Form::close() !!}



            </div>




                <div class="card"><a name="RestaurantAddress"></a>

                    <div class="card-header">
                        <h4 class="card-title">Restaurant Address</h4>
                    </div>
                    <div class="card-block">
                        <?= view('common.editaddress', array("addresse_detail" => $resturant, "is_disabled" => $is_disabled, "restSignUp" => false, "restEdit" => true)); ?>
                    </div>
                </div>





            @if(!$is_disabled)

            @elseif(debugmode())
                <div class="card-footer">
                    Can not edit
                </div>
            @endif


        </div>
        </div>
        </div>




        <script type="text/javascript" src="{{ asset('assets/global/plugins/select2/select2.min.js') }}"></script>
        <script src="{{ asset('assets/global/scripts/demo.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/global/scripts/form-validation.js') }}"></script>
        <link href="{{ asset('assets/global/css/timepicker.css') }}" rel="stylesheet"/>
        <script src="{{ asset('assets/global/scripts/jquery.timepicker.js') }}"></script>
@stop