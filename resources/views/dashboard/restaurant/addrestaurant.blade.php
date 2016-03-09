@if(false){
@extends('layouts.default')
@section('content')
    <meta name="_token" class="csrftoken" content="{{ csrf_token() }}"/>
    <script src="<?= url("assets/global/scripts/provinces.js"); ?>" type="text/javascript"></script>
    <!--link href="{{ asset('assets/global/css/components.css') }}" id="style_components" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/global/css/plugins.css') }}" rel="stylesheet" type="text/css"/-->


    <div class="row">

        @include('layouts.includes.leftsidebar')

        <div class="col-lg-9">
            <?php printfile("views/dashboard/restaurant/addrestaurant.blade.php"); ?>
            <div class="row">
                {!! Form::open(array('url' => 'restaurant/add/new', 'id'=>'resturantForm', 'class'=>'horizontal-form','method'=>'post','role'=>'form', 'enctype'=>'multipart/form-data')) !!}

                <?php  echo view('dashboard.restaurant.restaurant', array('cuisine_list' => $cuisine_list, "new" => true)); ?>

                <div class="col-md-6">
                    <i class="fa fa-long-arrow-right"></i> ADDRESS
                    @include("common.editaddress", array("new" => true))
                </div>

                <!--div class="col-md-12 ">
                    <i class="fa fa-long-arrow-right"></i> HOURS
                    @include("dashboard.restaurant.hours", array("new" => true, "layout" => true))
                </div-->

                <DIV>
                    <div class="form-actions">
                        <button type="submit" class="btn"><i class="fa fa-check"></i> SAVE</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>

        </div>
    </div>

    <script type="text/javascript" src="{{ asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/global/plugins/select2/select2.min.js') }}"></script>
    <!--script src="{{ asset('assets/global/scripts/demo.js') }}" type="text/javascript"></script-->
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

        //handle image uploading (duplicate code)
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
            /*$('#demo4').tagEditor({
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
*/
            $("#resturantForm").validate();
            ajaxuploadbtn('uploadbtn');
        });
    </script>

@stop
@endif