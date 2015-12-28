@extends('layouts.default')
@section('content')
    <meta name="_token" content="{{ csrf_token() }}"/>
    <script src="{{ url("assets/global/scripts/provinces.js") }}" type="text/javascript"></script>
    <!--link href="{{ asset('assets/global/css/components.css') }}" id="style_components" rel="stylesheet"
type="text/css"/-->
    <link href="{{ asset('assets/global/css/plugins.css') }}" rel="stylesheet" type="text/css"/>

    <div class="row">

        @include('layouts.includes.leftsidebar')

        <div class="col-lg-9 ">
            <?php printfile("views/dashboard/restaurant/info.blade.php"); ?>

            @if(\Session::has('message'))
                <div class="alert {!! Session::get('message-type') !!}">
                    <strong>{!! Session::get('message-short') !!}</strong>
                    &nbsp; {!! Session::get('message') !!}
                </div>
            @endif


            <div class="card">
                <div class="card-header">
                    Restaurant Info
                </div>
                <div class="card-block">

                    <!-- BEGIN FORM-->
                    {!! Form::open(array('url' => 'restaurant/info', 'id'=>'resturantForm', 'class'=>'horizontal-form','method'=>'post','role'=>'form', 'enctype'=>'multipart/form-data')) !!}

                    <div class="form-group row">

                        <label class="col-sm-3">Restaurant Name </label>
                        <div class="col-sm-9">
                            <input type="text" name="name" class="form-control" placeholder="Restaurant Name" value="{{ (isset($resturant->name))?$resturant->name:'' }}" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3">Email </label>
                        <div class="col-sm-9">
                            <input type="text" name="email" class="form-control" placeholder="Email Address" value="{{ (isset($resturant->email))?$resturant->email:'' }}" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3">Description</label>
                        <div class="col-sm-9">
                            <textarea name="description" class="form-control" placeholder="Description">{{ (isset($resturant->description))?$resturant->description:'' }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3">Cuisine Type</label>
                        <div class="col-sm-9">
                            <select name="cuisine" id="cuisine" class="form-control">
                                <option value="">-Select One-</option>
                                @foreach($cuisine_list as $value)
                                    <option value="{{ $value->id }}"
                                            @if(isset($resturant->cuisine) && $resturant->cuisine == $value->id) selected @endif>{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3">Tags</label>
                        <div class="col-sm-9">
                            <textarea id="demo4"></textarea>
                            <input type="hidden" name="tags" id="responseTags" value="{!! (isset($resturant->tags))?$resturant->tags:'' !!}"/>
                            <p>e.g: Canadian, Italian, Chinese, Fast Food</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3">Delivery</label>
                        <div class="col-sm-9">
                            <input type="checkbox" name="is_pickup" id="is_pickup" value="1" {{ (isset($resturant->is_pickup) && $resturant->is_pickup > 0)?'checked':'' }} />
                            Allow pickup
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3">
                            I Offer Delivery
                        </label>
                        <div class="col-sm-9">
                            <input type="checkbox" name="is_delivery" id="is_delivery" value="1" {{ (isset($resturant->is_delivery) && $resturant->is_delivery > 0)?'checked':'' }} />
                        </div>
                    </div>

                    <div id="is_delivery_options"
                         style="display: {{ (isset($resturant->is_delivery) && $resturant->is_delivery > 0)?'block':'none' }};">
                        <div class="form-group row">
                            <label class="col-sm-3">Delivery Fee </label>
                            <div class="col-sm-9">
                                <input type="number" name="delivery_fee" class="form-control" placeholder="Delivery Fee" value="{{ (isset($resturant->delivery_fee))?$resturant->delivery_fee:'' }}"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3">Min. Subtotal Before Delivery</label>
                            <div class="col-sm-9">
                                <input type="number" name="minimum" class="form-control" placeholder="Minimum Subtotal For Delivery" value="{{ (isset($resturant->minimum))?$resturant->minimum:'' }}"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3">Max Delivery Distance </label>
                            <div class="col-sm-9">
                                <select name="max_delivery_distance" id="max_delivery_distance" class="form-control">
                                    <option value="10">Between 1 and 10 km</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3">Logo</label>
                        <div class="col-sm-9">
                            <a href="javascript:void(0);" id="uploadbtn" class="btn btn-success red">Change
                                Image</a>
                            <input type="hidden" name="logo" id="hiddenLogo"/>

                            @if(isset($resturant->logo) && $resturant->logo != "")
                                <img id="picture" class="" src="{{ asset('assets/images/restaurants/'. ((isset($resturant->id))?$resturant->id:'') .'/thumb_'. ((isset($resturant->logo))?$resturant->logo:'')). '?'.mt_rand() }}" title=""/>
                            @else
                                <img id="picture" class="" src="{{ asset('assets/images/default.png') }}" title=""/>
                            @endif

                        </div>
                    </div>

                    <?php
                        echo view('common.editaddress');
                    ?>

                    <div class="form-group row">
                        <label class="col-sm-3">Hours</label>
                        <div class="col-sm-9">
                            <?php
                            $day_of_week = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', "Offset");

                            foreach ($day_of_week as $key => $value) {
                                $open[$key] = select_field_where('hours', array('restaurant_id' => ((isset($resturant->id)) ? $resturant->id : 0), 'day_of_week' => $value), 'open');
                                $close[$key] = select_field_where('hours', array('restaurant_id' => ((isset($resturant->id)) ? $resturant->id : 0), 'day_of_week' => $value), 'close');
                                $ID[$key] = select_field_where('hours', array('restaurant_id' => ((isset($resturant->id)) ? $resturant->id : 0), 'day_of_week' => $value), 'id');

                                $opentime = (isset($open[$key])) ? $open[$key] : getTime($open[$key]);
                                $closetime = (isset($close[$key])) ? $close[$key] : getTime($close[$key]);
                                ?>
                                    <div class="row">
                                        <label class="col-sm-4">{{ $value }}</label>
                                        <div class="col-sm-4">
                                            <input type="hidden" name="day_of_week[{{ $key }}]" value="{{ $value }}"/>
                                            <input type="hidden" name="idd[{{ $key }}]" value="{{ $ID[$key] }}"/>
                                            <input type="text" name="open[{{ $key }}]" value="{{ $opentime }}" title="Open" class="form-control time"/>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" name="close[{{ $key }}]" value="{{ $closetime }}" title="Close" class="form-control time"/>
                                        </div>
                                    </div>
                            <?php } ?>
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

    <script>
        $(document).ready(function () {
            $('body').on('change', '#is_delivery', function () {
                if ($(this).is(':checked')) {
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
                onChange: function (field, editor, tags) {
                    $('#responseTags').val((tags.length ? tags.join(', ') : ''));
                },
                beforeTagDelete: function (field, editor, tags, val) {
                    var q = confirm('Remove tag "' + val + '"?');
//if (q) $('#responseTags').prepend('Tag <i>'+val+'</i> deleted.<hr>');
//else $('#responseTags').prepend('Removal of <i>'+val+'</i> discarded.<hr>');
                    return q;
                }
            });
        });

        @if(isset($resturant->city))
        $(document).ready(function () {
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
                        if (t < 22) {
                            $(this).text('0' + (t - 12));
                        }else {
                            $(this).text(t - 12);
                        }
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
                        if (t != 12) {
                            var ho = '0' + (t - 12);
                        } else {
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