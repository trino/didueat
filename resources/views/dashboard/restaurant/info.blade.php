@extends('layouts.default')
@section('content')

        <!-- BEGIN THEME STYLES -->
<link href="{{ asset('assets/global/css/components.css') }}" id="style_components" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/global/css/plugins.css') }}" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->


<div class="content-page">
    <div class="row">

        @include('layouts.includes.leftsidebar')

        <div class="col-md-10 col-sm-8 col-xs-12 ">


            <div class="row ">



                <div class="col-md-12 ">


                    @if(\Session::has('message'))
                        <div class="alert {!! Session::get('message-type') !!}">
                            <strong>{!! Session::get('message-short') !!}</strong>
                            &nbsp; {!! Session::get('message') !!}
                        </div>
                    @endif

                </div>


                <div class="col-md-12 ">

                <p>
                    <strong>Scroll is hidden</strong><br>
                    Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras
                    mattis consectetur purus sit amet fermentum. Duis mollis, est non commodo luctus, nisi erat porttitor
                    ligula, eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum. Duis mollis,
                    est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras mattis
                    consectetur purus sit amet fermentum. Duis mollis, est non commodo luctus, nisi erat porttitor ligula,
                    eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum.
                </p>
</div>



                <!-- BEGIN FORM-->
                {!! Form::open(array('url' => 'restaurant/info', 'id'=>'resturantForm', 'class'=>'horizontal-form','method'=>'post','role'=>'form', 'enctype'=>'multipart/form-data')) !!}

                <?php $Layout = "columns"; ?>
                @include('common.restaurant')

                {!! Form::close() !!}
            </div>

        </div>
    </div>
</div>
</div>







<script type="text/javascript" src="{{ asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('assets/global/scripts/demo.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/scripts/form-validation.js') }}"></script>
<script src="{{ asset('assets/global/scripts/jquery.timepicker.js') }}"></script>




<script>
    jQuery(document).ready(function () {
        //ComponentsPickers.init();
        $("#resturantForm").validate();

        $('.time').timepicker();
        $('.time').click(function () {
            $('.ui-timepicker-hour-cell .ui-state-default').each(function () {
                var t = parseFloat($(this).text());
                if (t > 12) {
                    if (t < 22) {
                        $(this).text('0' + (t - 12));
                    } else {
                        $(this).text(t - 12);
                    }
                }
            });
        });
        $('.time').change(function () {
            //$('.time_real').val($(this).val());
            var t = $(this).val();
            var arr = t.split(':');
            var h = arr[0];
            var t = parseFloat(h);
            if (t > 11) {
                var format = 'PM';
                if (t < 22) {
                    if (t != 12) {
                        var ho = '0' + (t - 12);
                    }else {
                        var ho = 12;
                    }
                } else {
                    var ho = t - 12;
                }
            } else {
                var ho = arr[0];
                var format = 'AM';
                if (arr[0] == '00') {
                    var ho = '12';
                }
            }
            var tm = ho + ':' + arr[1] + ' ' + format;
            $(this).val(tm);
        });
    });
</script>


@stop