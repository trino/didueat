<?php
    printfile("views/dashboard/restaurant/restaurant.blade.php");
    echo newrow($new, "Restaurant Name");
    $name = iif($new, "restname", "name");//why does it change to restname?
?>
    <input type="text" name="{{ $name }}" class="form-control" placeholder="Restaurant Name" value="{{ (isset($restaurant->name))?$restaurant->name: old($name) }}" required>
<?php echo newrow();

echo newrow($new, "Email"); ?>
    <input type="text" name="email" class="form-control" placeholder="Email Address" value="{{ (isset($restaurant->email))?$restaurant->email: old("email")}}" required>
<?php echo newrow();

echo newrow($new, "Description"); ?>
    <textarea name="description" class="form-control" placeholder="Description">{{ (isset($restaurant->description))?$restaurant->description: old('description') }}</textarea>
<?php echo newrow();

echo newrow($new, "Cuisine Type"); ?>
    <select name="cuisine" id="cuisine" class="form-control">
        <option value="">-Select One-</option>
        @foreach($cuisine_list as $value)
            <option value="{{ $value->id }}"
                    @if(old('cuisine') == $value->id || (isset($restaurant->cuisine) && $restaurant->cuisine == $value->id)) selected @endif>{{ $value->name }}</option>
        @endforeach
    </select>
<?php echo newrow();

echo newrow($new, "Tags"); ?>
    <textarea id="demo4"></textarea>
    <input type="hidden" name="tags" id="responseTags" value="{!! (isset($restaurant->tags))?$restaurant->tags:old('tags') !!}"/>
    <p>e.g: Canadian, Italian, Chinese, Fast Food</p>
<?php echo newrow();

echo newrow($new, "Logo"); ?>
    <a href="javascript:void(0);" id="uploadbtn" class="btn btn-success red">ChangeImage</a>
    <input type="hidden" name="logo" id="hiddenLogo"/>

    @if(isset($restaurant->logo) && $restaurant->logo != "")
        <img id="picture" class="" src="{{ asset('assets/images/restaurants/'. ((isset($restaurant->id))?$restaurant->id:'') .'/thumb_'. ((isset($restaurant->logo))?$restaurant->logo:'')). '?'.mt_rand() }}" title=""/>
    @else
        <img id="picture" class="" src="{{ asset('assets/images/default.png') }}" title=""/>
    @endif
<?php echo newrow(); ?>

<script>
    $(document).ready(function () {
        is_delivery_change();
        $('body').on('change', '#is_delivery', function () {
            is_delivery_change();
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
//cities("{{ url('ajax') }}", '{{ (isset($resturant->city))?$resturant->city:0 }}');
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