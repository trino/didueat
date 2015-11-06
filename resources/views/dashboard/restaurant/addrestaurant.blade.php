@extends('layouts.default')
@section('content')
<meta name="_token" content="{{ csrf_token() }}"/>
<script src="<?= url("assets/global/scripts/provinces.js"); ?>" type="text/javascript"></script>
<!-- BEGIN THEME STYLES -->
<link href="{{ asset('assets/global/css/components.css') }}" id="style_components" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/global/css/plugins.css') }}" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->

<div class="content-page">
    <div class="container-fluid">
        <div class="row">

            @include('layouts.includes.leftsidebar')

            <div class="col-md-10 col-sm-8 col-xs-12 ">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        @if(\Session::has('message'))
                            <div class="alert {!! Session::get('message-type') !!}">
                                <strong>{!! Session::get('message-short') !!}</strong>
                                &nbsp; {!! Session::get('message') !!}
                            </div>
                        @endif
                    </div>


                    <div class="col-md-12  col-sm-12 col-xs-12">
                        <p>
                            <strong>Scroll is hidden</strong><br>
                            Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec
                            elit. Cras
                            mattis consectetur purus sit amet fermentum. Duis mollis, est non commodo luctus, nisi erat
                            porttitor
                            ligula, eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum.
                            Duis mollis,
                            est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras
                            mattis
                            consectetur purus sit amet fermentum. Duis mollis, est non commodo luctus, nisi erat
                            porttitor ligula,
                            eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum.
                        </p>
                    </div>

                    <!-- BEGIN FORM-->
                    {!! Form::open(array('url' => 'restaurant/add/new', 'id'=>'resturantForm', 'class'=>'horizontal-form','method'=>'post','role'=>'form', 'enctype'=>'multipart/form-data')) !!}
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="box-shadow">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-long-arrow-right"></i>ABOUT RESTAURANT
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label">Restaurant Name <span class="required">*</span></label>
                                                <input type="text" name="restname" class="form-control" placeholder="Restaurant Name" value="{{ old('name') }}" required>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label>Cuisine Type</label>
                                                <select name="genre" id="genre" class="form-control">
                                                    <option value="">-Select One-</option>
                                                    @foreach($genre_list as $value)
                                                        <option value="{{ $value->id }}" @if(old('genre') == $value->id) selected @endif>{{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label">Description</label>
                                                <textarea name="description" class="form-control" placeholder="Description">{{ old('description') }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <h3 class="form-section">Delivery</h3>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <div class="form-group">
                                                <label class="control-label">Delivery Fee <span class="required">*</span></label>
                                                <input type="number" name="delivery_fee" class="form-control" placeholder="Delivery Fee" value="{{ old('delivery_fee') }}" required />
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <div class="form-group">
                                                <label class="control-label">Min. Subtotal before Delivery <span class="required">*</span></label>
                                                <input type="number" name="minimum" class="form-control" placeholder="Minimum Subtotal For Delivery" value="{{ old('minimum') }}" required />
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <h3 class="form-section">Logo</h3>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <img id="picture" class="margin-bottom-10" src="{{ asset('assets/images/default.png') }}" title="" style="width: 100%;">
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <a href="javascript:void(0);" id="uploadbtn" class="btn btn-success red">Change Image</a>
                                            </div>
                                            <input type="hidden" name="logo" id="hiddenLogo"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button type="submit" class="btn red"><i class="fa fa-check"></i> SAVE</button>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="box-shadow">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-long-arrow-right"></i> ADDRESS
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label>Address <span class="required" aria-required="true">*</span></label>
                                                <input type="text" name="address" class="form-control" placeholder="Street Address" value="{{ old('address') }}" required>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label>City <span class="required" aria-required="true">*</span></label>
                                                <input type="text" name="city" class="form-control" placeholder="City" value="{{ old('city') }}" required>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label">Province <span class="required">*</span></label>
                                                <SELECT name="province" id="province"></SELECT>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label>Postal Code <span class="required" aria-required="true">*</span></label>
                                                <input type="text" name="postal_code" class="form-control" placeholder="Postal Code" value="{{ old('postal_code') }}" required>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label">Phone Number <span class="required" aria-required="true">*</span></label>
                                                <input type="text" name="phone" class="form-control" placeholder="Phone Number" value="{{ old('phone') }}">
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label>Country <span class="required" aria-required="true">*</span></label>
                                                <select name="country" id="country" class="form-control" required onchange="provinces('<?= addslashes(url("ajax")); ?>', 'ON');">
                                                    <option value="">-Select One-</option>
                                                    @foreach($countries_list as $value)
                                                        <option value="{{ $value->id }}" @if(old('country') == $value->id) selected @endif>{{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-4 ">

                        <div class="box-shadow">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-long-arrow-right"></i> HOURS
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <div class="form-body">
                                    <?php
                                        $day_of_week = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
                                        foreach ($day_of_week as $key => $value) {
                                        $open[$key] = select_field_where('hours', array('restaurant_id' => 0, 'day_of_week' => $value), 'open');
                                        $close[$key] = select_field_where('hours', array('restaurant_id' => 0, 'day_of_week' => $value), 'close');
                                        $ID[$key] = select_field_where('hours', array('restaurant_id' => 0, 'day_of_week' => $value), 'id');
                                    ?>
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-3"><?php echo $value; ?></label>
                                            <div class=" col-md-3 col-sm-3 col-xs-3">
                                                <input type="text" name="open[<?php echo $key; ?>]" value="<?php echo getTime($open[$key]); ?>" class="form-control time"/>
                                            </div>

                                            <div class="col-md-3 col-sm-3 col-xs-3" style="vertical-align: bottom;text-align: center;font-size: 14px;">to</div>

                                            <div class="col-md-3 col-sm-3 col-xs-3">
                                                <input type="text" name="close[<?php echo $key; ?>]" value="<?php echo getTime($close[$key]); ?>" class="form-control time"/>
                                                <input type="hidden" name="day_of_week[<?php echo $key; ?>]" value="<?php echo $value; ?>"/>
                                                <input type="hidden" name="idd[<?php echo $key; ?>]" value="<?php echo $ID[$key]; ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>

                            </div>
                        </div>
                    </div>

                    {!! Form::close() !!}
                </div>

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
    function ajaxuploadbtn(button_id) {
        var button = $('#' + button_id), interval;
        act = base_url + 'restaurant/uploadimg/restaurant';
        new AjaxUpload(button, {
            action: act,
            name: 'myfile',
            data: {'_token': token},
            onSubmit: function (file, ext) {
                button.text('Uploading...');
                this.disable();
                interval = window.setInterval(function () {
                    var text = button.text();
                    if (text.length < 13) {
                        button.text(text + '.');
                    } else {
                        button.text('Uploading...');
                    }
                }, 200);
            },
            onComplete: function (file, response) {
                //alert(response);return;
                //alert(response);
                var resp = response.split('___');
                var path = resp[0];
                var img = resp[1];
                button.html('Change Image');

                window.clearInterval(interval);
                this.enable();
                $('#picture').attr('src', path);
                $('#hiddenLogo').val(img);
                //$("."+button_id.replace('newbrowse','menuimg')).html('<img src="'+path+'" /><input type="hidden" class="hiddenimg" value="'+img+'" />');
                //$("."+button_id.replace('newbrowse','menuimg')).attr('style','min-height:0px!important;')
                //$('#client_img').val(response);

//$('.flashimg').show();
            }
        });
    }

    jQuery(document).ready(function () {
        //ComponentsPickers.init();
        $("#resturantForm").validate();
        ajaxuploadbtn('uploadbtn');

        $('.time').timepicker();
        $('.time').click(function () {
            $('.ui-timepicker-hour-cell .ui-state-default').each(function () {
                var t = parseFloat($(this).text());
                if (t > 12) {
                    if (t < 22)
                        $(this).text('0' + (t - 12));
                    else
                        $(this).text(t - 12);
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
                    if (t != 12)
                        var ho = '0' + (t - 12);
                    else
                        var ho = 12;
                }
                else {
                    var ho = t - 12;
                }
            }
            else {
                var ho = arr[0];
                var format = 'AM';
                if (arr[0] == '00')
                    var ho = '12';
            }
            var tm = ho + ':' + arr[1] + ' ' + format;
            $(this).val(tm);
        });
    });
</script>

<?php
function getTime($time)
{
    if (!$time)
        return $time;
    else
        $arr = explode(':', $time);
    $hour = $arr[0];
    $min = $arr[1];
    $sec = $arr[2];
    if ($hour >= 12) {
        $hour = $hour - 12;
        $suffix = 'PM';

    } else
        $suffix = 'AM';
    if (strlen($hour) == 1)
        $hour = '0' . $hour;
    return $hour . ':' . $min . ' ' . $suffix;
}
?>
@stop