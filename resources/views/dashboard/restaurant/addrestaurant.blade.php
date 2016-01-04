@extends('layouts.default')
@section('content')
    <meta name="_token" content="{{ csrf_token() }}"/>
    <script src="<?= url("assets/global/scripts/provinces.js"); ?>" type="text/javascript"></script>
    <link href="{{ asset('assets/global/css/components.css') }}" id="style_components" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/global/css/plugins.css') }}" rel="stylesheet" type="text/css"/>


    <div class="row">

        @include('layouts.includes.leftsidebar')

        <div class="col-lg-9">
            <?php printfile("views/dashboard/restaurant/addrestaurant.blade.php"); ?>
            <div class="row">
                {!! Form::open(array('url' => 'restaurant/add/new', 'id'=>'resturantForm', 'class'=>'horizontal-form','method'=>'post','role'=>'form', 'enctype'=>'multipart/form-data')) !!}


                <div class="col-md-6">

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label">Restaurant Name </label>
                                <input type="text" name="restname" class="form-control"
                                       placeholder="Restaurant Name" value="{{ old('name') }}" required>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label">Email </label>
                                <input type="text" name="email" class="form-control"
                                       placeholder="Email Address" value="{{ old('email') }}" required>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label">Description</label>
                                            <textarea name="description" class="form-control"
                                                      placeholder="Description">{{ old('description') }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label>Cuisine Type</label>
                                <select name="cuisine" id="cuisine" class="form-control">
                                    <option value="">-Select One-</option>
                                    @foreach($cuisine_list as $value)
                                        <option value="{{ $value->id }}"
                                                @if(old('cuisine') == $value->id) selected @endif>{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label">Tags</label>
                                <textarea id="demo4"></textarea>
                                <input type="hidden" name="tags" id="responseTags" value=""/>

                                <p>e.g: Candian, Italian, Chinese, FastFood</p>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <h3 class="form-section">Delivery</h3>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label"><input type="checkbox" name="is_pickup"
                                                                    id="is_pickup"
                                                                    value="1" {{ (old('is_pickup') && old('is_pickup') > 0)?'checked':'' }} />
                                    Allow pickup</label> <br/>
                                <label class="control-label"><input type="checkbox" name="is_delivery"
                                                                    id="is_delivery"
                                                                    value="1" {{ (old('is_delivery') && old('is_delivery') > 0)?'checked':'' }} />
                                    Allow home delivery</label>
                            </div>
                        </div>

                        <div id="is_delivery_options"
                             style="display: {{ (old('is_delivery') && old('is_delivery') > 0)?'block':'none' }};">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label">Max Delivery Distance </label>
                                    <select name="max_delivery_distance" id="max_delivery_distance"
                                            class="form-control">
                                        <option value="10">Between 1 and 10 km</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="form-group">
                                    <label class="control-label">Delivery Fee </label>
                                    <input type="number" name="delivery_fee" class="form-control"
                                           placeholder="Delivery Fee" value="{{ old('delivery_fee') }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="form-group">
                                    <label class="control-label">Min. Subtotal before Delivery </label>
                                    <input type="number" name="minimum" class="form-control"
                                           placeholder="Minimum Subtotal For Delivery"
                                           value="{{ old('minimum') }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <h3 class="form-section">Logo</h3>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <img id="picture" class="margin-bottom-10 full-width"
                                     src="{{ asset('assets/images/default.png') }}" title="">
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <a href="javascript:void(0);" id="uploadbtn" class="btn btn-success red">Change
                                    Image</a>
                            </div>
                            <input type="hidden" name="logo" id="hiddenLogo"/>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn red"><i class="fa fa-check"></i> SAVE</button>
                    </div>

                </div>


                <div class="col-md-6">
                    <i class="fa fa-long-arrow-right"></i> ADDRESS

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label>Address </label>
                                <input type="text" name="address" class="form-control"
                                       placeholder="Street Address" value="{{ old('address') }}" required>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label>Postal Code <span class="required"
                                                         aria-required="true">*</span></label>
                                <input type="text" name="postal_code" class="form-control"
                                       placeholder="Postal Code" value="{{ old('postal_code') }}" required>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label">Phone Number </label>
                                <input type="text" name="phone" class="form-control"
                                       placeholder="Phone Number" value="{{ old('phone') }}">
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label>Country <span class="required" aria-required="true">*</span></label>
                                <select name="country" id="country" class="form-control" required
                                        onchange="provinces('{{ addslashes(url("ajax")) }}', 'ON');">
                                    <option value="">-Select One-</option>
                                    @foreach($countries_list as $value)
                                        <option value="{{ $value->id }}"
                                                @if(old('country') == $value->id) selected
                                                @elseif($value->id == 40) selected @endif>{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label>Province </label>
                                <SELECT name="province" id="province" class="form-control"></SELECT>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label>City</label>
                                <input type="text" name="city" class="form-control" placeholder="City"
                                       value="{{ old('city') }}" required>
                            </div>
                        </div>

                    </div>

                </div>


                <div class="col-md-12 ">

                    <i class="fa fa-long-arrow-right"></i> HOURS

                    @include("dashboard.restaurant.hours")

                </div>

                {!! Form::close() !!}
            </div>

        </div>
    </div>

    </div>


    <script type="text/javascript"
            src="{{ asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/global/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/global/scripts/demo.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/scripts/form-validation.js') }}"></script>
    <script src="{{ asset('assets/global/scripts/jquery.timepicker.js') }}"></script>
    <script>
        $('body').on('change', '#is_delivery', function () {
            if ($(this).is(':checked')) {
                $('#is_delivery_options').show();
            } else {
                $('#is_delivery_options').hide();
            }
        });

        function ajaxuploadbtn(button_id) {
            var button = $('#' + button_id), interval;
            act = base_url + 'restaurant/uploadimg/restaurant';
            var token = $('#resturantForm input[name=_token]').val();
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
            $('#demo4').tagEditor({
                initialTags: [],
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

@stop