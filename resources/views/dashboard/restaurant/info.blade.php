@extends('layouts.default')
@section('content')

<!-- BEGIN PAGE LEVEL STYLES -->
<?php /*<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/clockface/css/clockface.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/bootstrap-datepicker/css/datepicker3.css') }}"/>
<!--<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/bootstrap-colorpicker/css/colorpicker.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}"/><?php */?>
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN THEME STYLES -->
<link href="{{ asset('assets/global/css/components.css') }}" id="style_components" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/global/css/plugins.css') }}" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->

<div class="margin-bottom-40">
    <!-- BEGIN CONTENT -->
    <div class="col-md-12 col-xs-12">
        <div class="row content-page">

            <div class="col-md-12 no-padding">
            <div class="row">
                @include('layouts.includes.leftsidebar')

                <div class="col-xs-12 col-sm-9 col-md-10">

                    <div class="portlet box red">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i> Restaurant Detail
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <!-- BEGIN FORM-->
                            {!! Form::open(array('url' => 'restaurant/info', 'id'=>'resturantForm', 'class'=>'horizontal-form','method'=>'post','role'=>'form', 'enctype'=>'multipart/form-data')) !!}
                                <div class="form-body">
                                    
                                    @if(Session::has('message'))
                                           <div class="alert alert-info">
                                               <strong>Alert!</strong> &nbsp; {!! Session::get('message') !!}
                                           </div>
                                     @endif
                                    <h3 class="form-section">Restaurant Info</h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Restaurant Name <span class="required">*</span></label>
                                                <input type="text" name="Name" class="form-control" placeholder="Restaurant Name" value="{{ $resturant->Name }}" required>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Restaurant Email <span class="required">*</span></label>
                                                <input type="email" name="Email" class="form-control" placeholder="Restaurant Email" value="{{ $resturant->Email }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Phone Number</label>
                                                <input type="text" name="Phone" class="form-control" placeholder="Phone Number" value="{{ $resturant->Phone }}">
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Description</label>
                                                <input type="text" name="Description" class="form-control" placeholder="Description" value="{{ $resturant->Description }}">
                                            </div>
                                        </div>
                                    </div>
                                    <!--/row-->

                                    <h3 class="form-section">Address</h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Country <span class="required">*</span></label>
                                                <select name="Country" class="form-control" required>
                                                    <option value="">-Select One-</option>
                                                            @foreach($countries_list as $value)
                                                                <option value="{{ $value->id }}" @if($resturant->Country == $value->id) selected @endif>{{ $value->name }}</option>
                                                            @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Genre</label>
                                                <select name="Genre" class="form-control">
                                                     <option value="">-Select One-</option>
                                                            @foreach($genre_list as $value)
                                                                <option value="{{ $value->ID }}" @if($resturant->Genre == $value->ID) selected @endif>{{ $value->Name }}</option>
                                                            @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>        
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Province <span class="required">*</span></label>
                                                <input type="text" class="form-control" name="Province" placeholder="Province Name" value="{{ $resturant->Province }}" required>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Street Address <span class="required">*</span></label>
                                                <input type="text" name="Address" class="form-control" placeholder="Street Address" value="{{ $resturant->Address }}" required>
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>City <span class="required">*</span></label>
                                                <input type="text" name="City" class="form-control" placeholder="City" value="{{ $resturant->City }}" required>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Postal Code <span class="required">*</span></label>
                                                <input type="text" name="PostalCode" class="form-control" placeholder="Postal Code" value="{{ $resturant->PostalCode }}" required>
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    
                                    
                                    <h3 class="form-section">Hours of Operation</h3>
                                    <?php
                                        $dayofweek = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
                                        foreach ($dayofweek as $key => $value) {
                                            $open[$key] = select_field_where('hours', array('RestaurantID' => $resturant->ID, 'DayOfWeek' => $value), 'Open');
                                            $close[$key] = select_field_where('hours', array('RestaurantID' => $resturant->ID, 'DayOfWeek' => $value), 'Close');
                                            $ID[$key] = select_field_where('hours', array('RestaurantID' => $resturant->ID, 'DayOfWeek' => $value), 'ID');
                                    ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-2 padding-top-5"><?php echo $value; ?></label>
                                                <div class="col-md-4">
                                                    <input type="text" name="Open[<?php echo $key; ?>]" value="<?php echo $open[$key]; ?>" class="form-control time"/>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="Close[<?php echo $key; ?>]" value="<?php echo $close[$key]; ?>" class="form-control time"/>
                                                    <input type="hidden" name="DayOfWeek[<?php echo $key; ?>]" value="<?php echo $value; ?>" />
                                                    <input type="hidden" name="IDD[<?php echo $key; ?>]" value="<?php echo $ID[$key]; ?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="shop__divider">
                                    <?php } ?>
                                    
                                    <h3 class="form-section">Delivery</h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Delivery Fee <span class="required">*</span></label>
                                                <input type="text" name="DeliveryFee" class="form-control" placeholder="Delivery Fee" value="{{ $resturant->DeliveryFee }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Minimum Sub Total For Delivery <span class="required">*</span></label>
                                                <input type="text" name="Minimum" class="form-control" placeholder="Minimum Sub Total For Delivery" value="{{ $resturant->Minimum }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/row-->
                                    <h3 class="form-section">Restaurant Image</h3>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-4 col-sm-4 profilepic">
                                                <strong>Restaurant Image</strong><br><br>
                                                @if($resturant->Logo)
                                                <img id="picture" src="{{ asset('assets/images/restaurants/'.$resturant->Logo) }}" title="" style="width: 100%;">
                                                @else
                                                <img id="picture" src="{{ asset('assets/images/default.png') }}" title="" style="width: 100%;">
                                                @endif
                                                <br>
                                                <a href="javascript:void(0);" id="uploadbtn" class="btn btn-success blue" onclick="document.getElementById('hiddenLogo').click(); return false">Change Image</a>
                                                <input type="file" name="logo" id="hiddenLogo" style="display: none;" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <input type="hidden" name="ID" value="{{ $resturant->ID }}" />
                                    <button type="submit" class="btn red"><i class="fa fa-check"></i> Save Changes </button>
                                </div>
                            </form>
                            <!-- END FORM-->
                        </div>
                    </div>
                </div>

            </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
</div>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{ asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/global/plugins/select2/select2.min.js') }}"></script>
<!--
<script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/clockface/js/clockface.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap-daterangepicker/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>-->
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ asset('assets/global/scripts/metronic.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/layout/scripts/demo.js') }}" type="text/javascript"></script>
<!--<script src="{{ asset('assets/admin/pages/scripts/components-pickers.js') }}"></script>-->
<script src="{{ asset('assets/admin/pages/scripts/table-advanced.js') }}"></script>
<script src="{{ asset('assets/admin/pages/scripts/form-samples.js') }}"></script>
<script src="{{ asset('assets/admin/pages/scripts/form-validation.js') }}"></script>
<script src="{{ asset('assets/global/scripts/jquery.timepicker.js') }}"></script>
<script>
jQuery(document).ready(function() {
    Metronic.init();
    Demo.init();
    //ComponentsPickers.init();
    $("#resturantForm").validate();
    FormSamples.init();
    $('.time').timepicker();
    $('.time').click(function(){
    $('.ui-timepicker-hour-cell .ui-state-default').each(function(){
        var t = parseFloat($(this).text());
       if(t>12)
       {
        if(t<22)
        $(this).text('0'+(t-12));
        else
        $(this).text(t-12);
       } 
    });
    });
    $('.time').change(function(){
       //$('.time_real').val($(this).val());
       var t = $(this).val();
       var arr = t.split(':');
       var h = arr[0];
       var t = parseFloat(h);
       if(t>11)
       {
        var format = 'PM';
        if(t<22){
            if(t!=12)
        var ho = '0'+(t-12);
        else
        var ho = 12;
        }
        else{
            
        var ho = t-12;
        
        }
       } 
       else
       {
        var ho = arr[0];
        var format = 'AM';
        if(arr[0] == '00')
        var ho = '12';
       }
       var tm = ho+':'+arr[1]+' '+format;
       $(this).val(tm);        
    });
});
</script>

@stop