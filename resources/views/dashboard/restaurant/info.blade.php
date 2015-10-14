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



                <div class="col-md-4 ">


                    <div class="portlet box red ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i>ABOUT RESTAURANT
                            </div>
                        </div>
                        <div class="portlet-body form">


                            <div class="form-body">

                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label">Restaurant Name <span
                                                        class="required">*</span></label>
                                            <input type="text" name="name" class="form-control"
                                                   placeholder="Restaurant Name"
                                                   value="{{ $resturant->name }}" required>
                                        </div>
                                    </div>


                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label>Cusine Type</label>
                                            <select name="genre" id="genre" class="form-control">
                                                <option value="">-Select One-</option>
                                                @foreach($genre_list as $value)
                                                    <option value="{{ $value->id }}"
                                                            @if($resturant->genre == $value->id) selected @endif>{{ $value->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label">Phone Number</label>
                                            <input type="text" name="phone" class="form-control"
                                                   placeholder="Phone Number"
                                                   value="{{ $resturant->phone }}">
                                        </div>
                                    </div>


                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label">Restaurant Email <span
                                                        class="required">*</span></label>
                                            <input type="email" name="email" class="form-control"
                                                   placeholder="Restaurant Email"
                                                   value="{{ $resturant->email }}" required>
                                        </div>
                                    </div>


                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label">Description</label>
                                            <textarea name="description" class="form-control"
                                                   placeholder="Description">{{ $resturant->description }}</textarea>
                                        </div>
                                    </div>




                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h3 class="form-section">Delivery</h3>
                                    </div>

                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label">Delivery Fee <span
                                                        class="required">*</span></label>
                                            <input type="text" name="delivery_fee" class="form-control"
                                                   placeholder="Delivery Fee" value="{{ $resturant->delivery_fee }}"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label">Min. Subtotal before Delivery <span
                                                        class="required">*</span></label>
                                            <input type="text" name="minimum" class="form-control"
                                                   placeholder="Minimum Subtotal For Delivery"
                                                   value="{{ $resturant->minimum }}" required>
                                        </div>
                                    </div>



                                    <div class="col-md-12">
                                        <h3 class="form-section">Logo</h3>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-12">


                                        @if($resturant->logo)
                                            <img id="picture" class="margin-bottom-10"
                                                 src="{{ asset('assets/images/restaurants/'.$resturant->id.'/thumb_'.$resturant->logo) }}"
                                                 title=""
                                                 style="width: 100%;">
                                        @else
                                            <img id="picture" class="margin-bottom-10" src="{{ asset('assets/images/default.png') }}" title=""
                                                 style="width: 100%;">
                                        @endif


                                        <br/>
                                        <a href="javascript:void(0);" id="uploadbtn" class="btn btn-success red"
                                           onclick="document.getElementById('hiddenLogo').click(); return false">Change
                                            Image</a>
                                        <input type="file" name="logo" id="hiddenLogo" style="display: none;"/>


                                    </div>






                                </div>


                            </div>


                            <div class="form-actions">
                                <input type="hidden" name="id" value="{{ $resturant->id }}"/>
                                <button type="submit" class="btn red"><i class="fa fa-check"></i> SAVE</button>
                            </div>


                        </div>
                    </div>
                </div>


                <div class="col-md-4 ">


                    <div class="portlet box red">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i> ADDRESS
                            </div>
                        </div>
                        <div class="portlet-body form">


                            <div class="form-body">

                                <div class="row">




                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input type="text" name="address" class="form-control"
                                                   placeholder="Street Address"
                                                   value="{{ $resturant->address }}" required>
                                        </div>
                                    </div>




                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label>City</label>
                                            <input type="text" name="city" class="form-control" placeholder="City"
                                                   value="{{ $resturant->city }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label">Province <span
                                                        class="required">*</span></label>
                                            <input type="text" class="form-control" name="province"
                                                   placeholder="Province Name"
                                                   value="{{ $resturant->province }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label>Postal Code</label>
                                            <input type="text" name="postal_code" class="form-control"
                                                   placeholder="Postal Code"
                                                   value="{{ $resturant->postal_code }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label>Country</label>
                                            <select name="country" id="country" class="form-control" required>
                                                <option value="">-Select One-</option>
                                                @foreach($countries_list as $value)
                                                    <option value="{{ $value->id }}"
                                                            @if($resturant->country == $value->id) selected @endif>{{ $value->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>



                                </div>
                            </div>


                            <div class="form-actions">
                                <input type="hidden" name="id" value="{{ $resturant->id }}"/>
                                <button type="submit" class="btn red"><i class="fa fa-check"></i> SAVE</button>
                            </div>

                        </div>
                    </div>
                </div>


                <div class="col-md-4 ">

                    <div class="portlet box red">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i> HOURS
                            </div>
                        </div>
                        <div class="portlet-body form">


                            <div class="form-body">

                                <?php
                                $day_of_week = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
                                foreach ($day_of_week as $key => $value) {
                                $open[$key] = select_field_where('hours', array('restaurant_id' => $resturant->id, 'day_of_week' => $value), 'open');
                                $close[$key] = select_field_where('hours', array('restaurant_id' => $resturant->id, 'day_of_week' => $value), 'close');
                                $ID[$key] = select_field_where('hours', array('restaurant_id' => $resturant->id, 'day_of_week' => $value), 'id');
                                ?>
                                <div class="row">
                                    <div class="form-group">


                                        <label class="control-label col-md-3 col-sm-3 col-xs-3"><?php echo $value; ?></label>


                                        <div class=" col-md-3 col-sm-3 col-xs-3">
                                            <input type="text" name="open[<?php echo $key; ?>]"
                                                   value="<?php echo getTime($open[$key]); ?>"
                                                   class="form-control time"/>
                                        </div>


                                        <div class="  col-md-3 col-sm-3 col-xs-3"
                                             style="vertical-align: bottom;text-align: center;font-size: 14px;">
                                            to
                                        </div>

                                        <div class=" col-md-3 col-sm-3 col-xs-3">
                                            <input type="text" name="close[<?php echo $key; ?>]"
                                                   value="<?php echo getTime($close[$key]); ?>"
                                                   class="form-control time"/>
                                            <input type="hidden" name="day_of_week[<?php echo $key; ?>]"
                                                   value="<?php echo $value; ?>"/>
                                            <input type="hidden" name="idd[<?php echo $key; ?>]"
                                                   value="<?php echo $ID[$key]; ?>"/>
                                        </div>


                                    </div>

                                </div>

                                <?php } ?>
                            </div>


                            <div class="form-actions">
                                <input type="hidden" name="id" value="{{ $resturant->id }}"/>
                                <button type="submit" class="btn red"><i class="fa fa-check"></i> SAVE</button>
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


@stop


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