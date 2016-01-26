<?php
printfile("views/dashboard/restaurant/restaurant.blade.php");
echo newrow($new, "Restaurant Name", "", true, 6);
$name = iif($new, "restname", "name");//why does it change to restname?
if (!isset($is_disabled)) {
    $is_disabled = false;
}
if (!isset($minimum)) {
    $minimum = false;
}
?>
<input name="initialRestSignup" type="hidden" value="1" />
<input type="text" name="restname" class="form-control" style="width:90%"
       {{ $is_disabled }} placeholder="Restaurant Name"
       value="My Resto {{ (isset($restaurant->name) && $restaurant->name)?$restaurant->name: old("restname") }}" required>
<?php echo newrow();

if(!isset($email)){
echo newrow($new, "Email", "", true, 7); ?>
<input type="text" name="email" class="form-control" {{ $is_disabled }} placeholder="Email Address"
       value="{{ (isset($restaurant->email))?$restaurant->email: old("email")}}" required>
</div></div>
<?php }

echo newrow($new, "Restaurant Cuisine", "", true, 9); 
echo '<input name="cuisines" type="hidden" />';
$cuisineExpl="";
if(isset($restaurant->cuisine)){
    $cuisineExpl = explode(",",$restaurant->cuisine);
}

$cnt=0;
$cuisineListA=array();
foreach($cuisine_list as $value){
    $cuisineListA[$value->id] = $value->name;
}

sort($cuisineListA);
foreach($cuisineListA as $value => $name){
    echo "<div class='cuisineCB'><LABEL><input name='cuisine" . $cnt . "' type='checkbox' value='" . $name . "'";
    if(isset($restaurant->cuisine)){
        if(in_array($name, $cuisineExpl)){
            echo " checked";
        }
    }
    echo " />&nbsp;" . $name . " &nbsp; &nbsp; &nbsp;</LABEL></div>";
    $cnt++;
}

echo '<script>var cuisineCnt = ' . $cnt . ';</script></div></div>';

if(!$minimum){
    echo newrow($new, "Description", "", true, 8); ?>
        <textarea name="description" class="form-control" {{ $is_disabled }} placeholder="Description">{{ (isset($restaurant->description))?$restaurant->description: old('description') }}</textarea>
    <?php echo newrow();

    echo newrow($new, "Tags"); ?>
        <textarea id="demo4"></textarea>
        <input type="hidden" name="tags" id="responseTags" value="{!! (isset($restaurant->tags))?$restaurant->tags:old('tags') !!}"/>
        <p>Separate tags by commas (e.g: Canadian, Italian, Chinese, Fast Food)</p>
    </div></div>
    <!--?php echo newrow();
    echo newrow($new, "Logo", "", false, 9, '<a href="#" id="uploadbtn" class="btn btn-success red">Change Logo</a>'); ?-->

    <?php echo newrow($new, "Logo","","",7); ?>

    @if(!$is_disabled)
        <a href="javascript:void(0);" id="uploadbtn" class="btn btn-success red">Click to Change Image</a> &nbsp;
    @endif

    <input type="hidden" name="logo" id="hiddenLogo"/>

    <img id="picture" class="logopic" align="right"
    @if(isset($restaurant->logo) && $restaurant->logo != "")
         src="{{ asset('assets/images/restaurants/'. ((isset($restaurant->id))?$restaurant->id:'') .'/thumb_'. ((isset($restaurant->logo))?$restaurant->logo:'')). '?'.mt_rand() }}" />
    @else
        src="{{ asset('assets/images/didueatdefault.png') }}" />
        <script>
            document.getElementById('uploadbtn').innerHTML="Click to Set Your Own Logo";
        </script>
    @endif

    </div>
    </div>

    <?php
     echo newrow($new,"Save","","",12,true);
    ?>

    <hr width="100%" align="center" />
    <button type="submit" class="btn btn-primary" style="margin-left:auto;margin-right:auto;">Save</button>

    <?php
     echo newrow();
}
?>



<script>
    $(document).ready(function () {
        @if(!$minimum)
            is_delivery_change();
        $('body').on('change', '#is_delivery', function () {
            is_delivery_change();
        });
        @endif

        $('#demo4').tagEditor({
                    //{!! (isset($resturant->tags))?strToTagsConversion($resturant->tags):'' !!}
            initialTags: [{!! (isset($restaurant->tags))?strToTagsConversion($restaurant->tags):'' !!}],
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

    @if(!$minimum)
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
    @endif

    jQuery(document).ready(function () {
                $("#resturantForm").validate();
                @if(!$minimum)
                    ajaxuploadbtn('uploadbtn');
                @endif


            });
</script>