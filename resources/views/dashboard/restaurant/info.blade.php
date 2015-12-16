@extends('layouts.default')
@section('content')
<meta name="_token" content="{{ csrf_token() }}"/>
<script src="{{ url("assets/global/scripts/provinces.js") }}" type="text/javascript"></script>
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
                    {!! Form::open(array('url' => 'restaurant/info', 'id'=>'resturantForm', 'class'=>'horizontal-form','method'=>'post','role'=>'form', 'enctype'=>'multipart/form-data')) !!}
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="box-shadow">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-long-arrow-right"></i> ABOUT RESTAURANT
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label">Restaurant Name <span class="required">*</span></label>
                                                <input type="text" name="name" class="form-control" placeholder="Restaurant Name" value="{{ (isset($resturant->name))?$resturant->name:'' }}" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label">Email <span class="required">*</span></label>
                                                <input type="text" name="email" class="form-control" placeholder="Email Address" value="{{ (isset($resturant->email))?$resturant->email:'' }}" required>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label">Description</label>
                                                <textarea name="description" class="form-control" placeholder="Description">{{ (isset($resturant->description))?$resturant->description:'' }}</textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label>Cuisine Type</label>
                                                <select name="cuisine" id="cuisine" class="form-control">
                                                    <option value="">-Select One-</option>
                                                    @foreach($cuisine_list as $value)
                                                        <option value="{{ $value->id }}" @if(isset($resturant->cuisine) && $resturant->cuisine == $value->id) selected @endif>{{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label">Tags</label>
                                                <textarea id="demo4"></textarea>
                                                <input type="hidden" name="tags" id="responseTags" value="{!! (isset($resturant->tags))?$resturant->tags:'' !!}" />
                                                <p>e.g: Candian, Italian, Chinese, FastFood</p>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <h3 class="form-section">Delivery</h3>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label"><input type="checkbox" name="is_pickup" id="is_pickup" value="1" {{ (isset($resturant->is_pickup) && $resturant->is_pickup > 0)?'checked':'' }} /> Allow pickup</label> <br />
                                                <label class="control-label"><input type="checkbox" name="is_delivery" id="is_delivery" value="1" {{ (isset($resturant->is_delivery) && $resturant->is_delivery > 0)?'checked':'' }} /> Allow home delivery</label>
                                            </div>
                                        </div>
                                        <div id="is_delivery_options" style="display: {{ (isset($resturant->is_delivery) && $resturant->is_delivery > 0)?'block':'none' }};">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label">Max Delivery Distance </label>
                                                    <select name="max_delivery_distance" id="max_delivery_distance" class="form-control">
                                                        <option value="10">Between 1 and 10 km</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <div class="form-group">
                                                    <label class="control-label">Delivery Fee </label>
                                                    <input type="number" name="delivery_fee" class="form-control" placeholder="Delivery Fee" value="{{ (isset($resturant->delivery_fee))?$resturant->delivery_fee:'' }}" />
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <div class="form-group">
                                                    <label class="control-label">Min. Subtotal before Delivery</label>
                                                    <input type="number" name="minimum" class="form-control" placeholder="Minimum Subtotal For Delivery" value="{{ (isset($resturant->minimum))?$resturant->minimum:'' }}" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <h3 class="form-section">Logo</h3>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                @if(isset($resturant->logo) && $resturant->logo != "")
                                                    <img id="picture" class="margin-bottom-10 full-width" src="{{ asset('assets/images/restaurants/'. ((isset($resturant->id))?$resturant->id:'') .'/thumb_'. ((isset($resturant->logo))?$resturant->logo:'')). '?'.mt_rand() }}" title="" />
                                                @else
                                                    <img id="picture" class="margin-bottom-10 full-width" src="{{ asset('assets/images/default.png') }}" title="" />
                                                @endif
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <a href="javascript:void(0);" id="uploadbtn" class="btn btn-success red">Change Image</a>
                                            </div>
                                            <input type="hidden" name="logo" id="hiddenLogo"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <input type="hidden" name="id" value="{{ ((isset($resturant->id))?$resturant->id:'') }}"/>
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
                                                <label>Address</label>
                                                <input type="text" name="address" class="form-control" placeholder="Street Address" value="{{ ((isset($resturant->address))?$resturant->address:'') }}" required>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label>Country</label>
                                                <select name="country" id="country" class="form-control" onchange="provinces('{{ addslashes(url("ajax")) }}', {{ (isset($resturant->province))?$resturant->province:'ON' }});" required>
                                                    <option value="">-Select One-</option>
                                                    @foreach($countries_list as $value)
                                                        <option value="{{ $value->id }}" @if((isset($resturant->country)) && $resturant->country == $value->id) selected @endif>{{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label">Province <span class="required">*</span></label>
                                                <select name="province" class="form-control" required id="province"></select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label>City</label>
                                                <input type="text" name="city" class="form-control" value="{{ ((isset($resturant->city))?$resturant->city:'') }}" required id="city" >
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <div class="form-group">
                                                <label>Postal Code</label>
                                                <input type="text" name="postal_code" class="form-control" placeholder="Postal Code" value="{{ ((isset($resturant->postal_code))?$resturant->postal_code:'') }}" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <div class="form-group">
                                                <label class="control-label">Phone Number</label>
                                                <input type="text" name="phone" class="form-control" placeholder="Phone Number" value="{{ ((isset($resturant->phone))?$resturant->phone:'') }}">
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <input type="hidden" name="id" value="{{ ((isset($resturant->id))?$resturant->id:0) }}" />
                                    <button type="submit" class="btn red"><i class="fa fa-check"></i> SAVE</button>
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
                                        $open[$key] = select_field_where('hours', array('restaurant_id' => ((isset($resturant->id))?$resturant->id:0), 'day_of_week' => $value), 'open');
                                        $close[$key] = select_field_where('hours', array('restaurant_id' => ((isset($resturant->id))?$resturant->id:0), 'day_of_week' => $value), 'close');
                                        $ID[$key] = select_field_where('hours', array('restaurant_id' => ((isset($resturant->id))?$resturant->id:0), 'day_of_week' => $value), 'id');
                                    ?>
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-3">{{ $value }}</label>
                                            <div class=" col-md-3 col-sm-3 col-xs-3">
                                                <input type="text" name="open[{{ $key }}]" value="{{ (isset($open[$key]))?$open[$key]:getTime($open[$key]) }}" class="form-control time" />
                                            </div>
                                            <div class="col-md-3 col-sm-3 col-xs-3" id="hour-to-style">to</div>
                                            <div class=" col-md-3 col-sm-3 col-xs-3">
                                                <input type="text" name="close[{{ $key }}]" value="{{ (isset($close[$key]))?$close[$key]:getTime($close[$key]) }}" class="form-control time"/>
                                                <input type="hidden" name="day_of_week[{{ $key }}]" value="{{ $value }}"/>
                                                <input type="hidden" name="idd[{{ $key }}]" value="{{ $ID[$key] }}"/>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>

                                <div class="form-actions">
                                    <input type="hidden" name="id" value="{{ ((isset($resturant->id))?$resturant->id:0) }}" />
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
</div>


<script type="text/javascript" src="{{ asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/global/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('assets/global/scripts/demo.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/scripts/form-validation.js') }}"></script>
<script src="{{ asset('assets/global/scripts/jquery.timepicker.js') }}"></script>
<script>
    $(document).ready(function(){
        $('body').on('change', '#is_delivery', function(){
            if($(this).is(':checked')){
                $('#is_delivery_options').show();
            } else {
                $('#is_delivery_options').hide();
            }
        });

        $('#demo4').tagEditor({
            //{!! (isset($resturant->tags))?strToTagsConversion($resturant->tags):'' !!}
            initialTags: [{!! (isset($resturant->tags))?strToTagsConversion($resturant->tags):'' !!}],
            placeholder: 'Enter tags ...',
            //beforeTagSave: function(field, editor, tags, tag, val) { $('#response').prepend('Tag <i>'+val+'</i> saved'+(tag ? ' over <i>'+tag+'</i>' : '')+'.<hr>'); },
            //onChange: function(field, editor, tags) { $('#response').prepend('Tags changed to: <i>'+(tags.length ? tags.join(', ') : '----')+'</i><hr>'); },
            onChange: function(field, editor, tags) { $('#responseTags').val((tags.length ? tags.join(', ') : '')); },
            beforeTagDelete: function(field, editor, tags, val){
                var q = confirm('Remove tag "'+val+'"?');
                //if (q) $('#responseTags').prepend('Tag <i>'+val+'</i> deleted.<hr>');
                //else $('#responseTags').prepend('Removal of <i>'+val+'</i> discarded.<hr>');
                return q;
            }
        });
    });
    
    @if(isset($resturant->city))
        $(document).ready(function(){
                //cities("{{ url('ajax') }}", {{ (isset($resturant->city))?$resturant->city:0 }});
        });
    @endif
    
    function ajaxuploadbtn(button_id) {
        var button = $('#' + button_id), interval;
        var token = $('#resturantForm input[name=_token]').val();
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
                var resp = response.split('___');
                var path = resp[0];
                var img = resp[1];
                button.html('Change Image');

                window.clearInterval(interval);
                this.enable();
                $('#picture').attr('src', path);
                $('#hiddenLogo').val(img);
            }
        });
    }

    jQuery(document).ready(function () {        
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