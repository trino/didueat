@extends('layouts.default')
@section('content')
    <meta name="_token" content="{{ csrf_token() }}"/>


    <link href="{{ asset('assets/global/css/plugins.css') }}" rel="stylesheet" type="text/css"/>

    <div class="row">

        @include('layouts.includes.leftsidebar')

        <div class="col-lg-9 ">
            <?php printfile("views/dashboard/restaurant/info.blade.php"); ?>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Restaurant Info</h4>
                </div>
                <div class="card-block">

                    {!! Form::open(array('url' => 'restaurant/info', 'id'=>'resturantForm', 'class'=>'horizontal-form','method'=>'post','role'=>'form', 'enctype'=>'multipart/form-data')) !!}

                    <?php
                    $is_disabled = false;
                    if (isset($route) && $route == "restaurant/view/{view}") {
                        $is_disabled = " DISABLED";
                    }
                    ?>
                    <?php
                    echo view('dashboard.restaurant.restaurant', array("restaurant" => $resturant, 'cuisine_list' => $cuisine_list, "new" => false, "is_disabled" => $is_disabled));
                    ?>


                </div>
            </div>


            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Restaurant Address</h4>
                </div>
                <div class="card-block">


                    <?php
                    echo view('common.editaddress', array("addresse_detail" => $resturant, "is_disabled" => $is_disabled));
                    ?>


                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Restaurant Hours</h4>
                    </div>
                    <div class="card-block">


                        <div class="form-group row">
                            <label class="col-sm-3">Hours</label>

                            <div class="col-sm-9">
                                @include("dashboard.restaurant.hours", array("new" => false, "restaurant" => $resturant, "is_disabled" => $is_disabled))
                            </div>
                        </div>
                    </div>


                    @if(!$is_disabled)
                        <div class="card-footer">
                            <input type="hidden" name="id" value="{{ ((isset($resturant->id))?$resturant->id:0) }}"/>
                            <button type="submit" class="btn btn-primary pull-right">Save</button>


                            {!! Form::close() !!}


                            <div class="clearfix"></div>
                        </div>
                    @endif
                </div>
            </div>
        </div>


        <script type="text/javascript"
                src="{{ asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/global/plugins/select2/select2.min.js') }}"></script>
        <script src="{{ asset('assets/global/scripts/demo.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/global/scripts/form-validation.js') }}"></script>
        <script src="{{ asset('assets/global/scripts/jquery.timepicker.js') }}"></script>

@stop