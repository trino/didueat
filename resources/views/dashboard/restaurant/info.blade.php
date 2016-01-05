@extends('layouts.default')
@section('content')
    <meta name="_token" content="{{ csrf_token() }}"/>
    <!--link href="{{ asset('assets/global/css/components.css') }}" id="style_components" rel="stylesheet"
type="text/css"/-->
    <link href="{{ asset('assets/global/css/plugins.css') }}" rel="stylesheet" type="text/css"/>

    <div class="row">

        @include('layouts.includes.leftsidebar')

        <div class="col-lg-9 ">
            <?php printfile("views/dashboard/restaurant/info.blade.php"); ?>

            <div class="card">
                <div class="card-header">
                    Restaurant Info
                </div>
                <div class="card-block">

                    <!-- BEGIN FORM-->
                    {!! Form::open(array('url' => 'restaurant/info', 'id'=>'resturantForm', 'class'=>'horizontal-form','method'=>'post','role'=>'form', 'enctype'=>'multipart/form-data')) !!}

                    <?php
                        echo view('dashboard.restaurant.restaurant', array("restaurant" => $resturant, 'cuisine_list' => $cuisine_list, "new" => false));
                        echo view('common.editaddress', array("addresse_detail" => $resturant));
                    ?>

                    <div class="form-group row">
                        <label class="col-sm-3">Hours</label>
                        <div class="col-sm-9">
                            @include("dashboard.restaurant.hours", array("new" => false))
                        </div>
                    </div>
                </div>


                <div class="card-footer">
                    <input type="hidden" name="id" value="{{ ((isset($resturant->id))?$resturant->id:0) }}"/>
                    <button type="submit" class="btn btn-primary pull-right">Save</button>
                    {!! Form::close() !!}
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="{{ asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/global/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/global/scripts/demo.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/scripts/form-validation.js') }}"></script>
    <script src="{{ asset('assets/global/scripts/jquery.timepicker.js') }}"></script>

    <!--
    <script src="{{ url("assets/global/scripts/provinces.js") }}" type="text/javascript"></script>
    <script src="https://maps.googleapis.com/maps/api/js?signed_in=true&libraries=places&callback=initAutocomplete" async defer></script>
    <SCRIPT>
        $(document).ready(function () {
            cities("{{ url('ajax') }}", '{{ (isset($addresse_detail->city))?$addresse_detail->city:0 }}');
        });
    </SCRIPT>
    -->
@stop