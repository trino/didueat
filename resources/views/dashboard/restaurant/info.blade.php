@extends('layouts.default')
@section('content')

    <meta name="_token" class="csrftoken" content="{{ csrf_token() }}"/>

    <div class="container">
        <div class="row">

            @include('layouts.includes.leftsidebar')

            <div class="col-lg-9 ">
                <?php
                    printfile("views/dashboard/restaurant/info.blade.php");

                    $is_disabled = false;
                    if (isset($route) && $route == "restaurant/view/{view}") {
                        $is_disabled = " DISABLED";
                    }
                ?>

                {!! Form::open(array('url' => 'restaurant/info', 'onsubmit' => 'return validateFn(this)', 'id'=>'resturantForm', 'class'=>'horizontal-form','method'=>'post','role'=>'form', 'enctype'=>'multipart/form-data')) !!}

                    <input type="hidden" name="id" value="{{ ((isset($resturant->id))?$resturant->id:0) }}"/>

                    <div class="card">
                        <div class="card-header"><a name="PickupAndDelivery"></a>
                            <h4 class="card-title">Hours & Delivery</h4>
                        </div>
                        <div class="card-block">
                            @include("dashboard.restaurant.hours", array("new" => false, "restaurant" => $resturant, "is_disabled" => $is_disabled, "style" => 2, "showDeliveryOptions" => true))
                            <div class="clearfix"></div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Payment methods</h4>
                        </div>
                        <div class="card-block">
                            @include("dashboard.restaurant.payment", array("edit" => true, "restaurant" => $resturant))
                            <div class="clearfix"></div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Restaurant Settings</h4>
                        </div>

                        <div class="card-block">
                            <!--div class="row">
                                <div class="col-md-12">
                                    <label class="c-input c-radio">
                                        <input id="radio1" name="radio" type="radio">
                                        <span class="c-indicator"></span>
                                        Restaurant Live (Accept Orders)
                                    </label>
                                    <label class="c-input c-radio">
                                        <input id="radio2" name="radio" type="radio">
                                        <span class="c-indicator"></span>
                                        Restaurant Offline (Closed)
                                    </label>
                                    </div>
                            </div-->
                            <?= view('dashboard.restaurant.restaurant', array("restaurant" => $resturant, 'cuisine_list' => $cuisine_list, "new" => false, "is_disabled" => $is_disabled));  ?>
                        </div>
                    </div>

                    {!! Form::close() !!}

                    <div class="card"><a name="RestaurantAddress"></a>
                        <div class="card-header">
                            <h4 class="card-title">Restaurant Address</h4>
                        </div>
                        <div class="card-block ">
                            <div class="row">
                                <?= view('common.editaddress', array("addresse_detail" => $resturant, "is_disabled" => $is_disabled, "restSignUp" => false, "restEdit" => true, "mini" => true)); ?>
                            </div>
                        </div>
                    </div>


                @if($is_disabled && debugmode())
                    <div class="card-footer">
                        Can not edit
                    </div>
                @endif

            </div>
        </div>
    </div>

    <script type="text/javascript" src="{{ asset('assets/global/plugins/select2/select2.min.js') }}"></script>
    <!--script src="{{ asset('assets/global/scripts/demo.js') }}" type="text/javascript"></script-->
    <script src="{{ asset('assets/global/scripts/form-validation.js') }}"></script>
    <link href="{{ asset('assets/global/css/timepicker.css') }}" rel="stylesheet"/>
    <script src="{{ asset('assets/global/scripts/jquery.timepicker.js') }}"></script>

    <SCRIPT>
        validateform("resturantForm", {phone: "phone required"});
    </SCRIPT>
@stop