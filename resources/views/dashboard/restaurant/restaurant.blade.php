<?php
    printfile("views/dashboard/restaurant/restaurant.blade.php");
    //var_dump(get_defined_vars());

    $name = iif($new, "restname", "name");//why does it change to restname?
    if (!isset($is_disabled)) {
        $is_disabled = false;
    }
    if (!isset($minimum)) {
        $minimum = false;
    }
        
    $brTag="<br/>";
    $brTag2="";
    if(isset($restSignUpPg)){
        $brTag="";
        $brTag2="<br/>";
    }

echo newrow($new, "Restaurant Name", "", true); ?>
    <input name="initialRestSignup" type="hidden" value="1" />
    <input type="text" name="restname" class="form-control" {{ $is_disabled }} value="{{ (isset($restaurant->name) && $restaurant->name)?$restaurant->name: old("restname") }}" required>
</div></div>

<?= newrow($new, "Phone", "", true); ?>
    <input type="text" name="phone" class="form-control" {{ $is_disabled }} value="{{ (isset($restaurant->phone))?$restaurant->phone: old("phone")}}" required>
</div></div>

<?php if(!isset($new) || !$new){
    echo newrow($new, "Description", "", true, 9);
    echo '<textarea required name="description" class="form-control"' . $is_disabled . '>';
    if (isset($restaurant->description)){ echo $restaurant->description; } else { echo old('description');}
    echo '</textarea>' . newrow();
}


echo newrow($new, "Cuisine", "", true, 9, '<BR>(Select up to 3)');
echo '<input name="cuisines" type="hidden" /><div class="row">';
$cuisineExpl = "";
if (isset($restaurant->cuisine)) {
    $cuisineExpl = explode(",", $restaurant->cuisine);
}

$cnt = 0; 
$cuisinesChkd = 0;
$cuisineListA = $cuisine_list;
sort($cuisineListA);
foreach ($cuisineListA as $name) {
    echo "<div class='cuisineCB col-sm-3'><LABEL class='c-input c-checkbox'><input name='cuisine" . $cnt . "' type='checkbox' onclick='this.checked=chkCBs(this.checked)' value='" . $name . "'";
    if (isset($restaurant->cuisine)) {
        if (in_array($name, $cuisineExpl)) {
            echo " checked";
            $cuisinesChkd++;
        }
    }
    echo " />" . $name . "<span class='c-indicator'></span></LABEL></div>";
    $cnt++;
}

echo '</div><script>var cuisineCnt = ' . $cnt . '; var cbchkd = ' . $cuisinesChkd . ';</script></div></div>';

if(!$minimum){
        echo newrow($new, "Logo", "", "", 7);
        ?>
        <a href="javascript:void(0);" id="uploadbtn" class="btn btn-success pull-left rightmarg">Upload</a>

        <div class="clearfix pull-left">
            <input type="hidden" name="logo" id="hiddenLogo"/>

            <img id="picture" class="logopic" align=""
                 @if(isset($restaurant->logo) && $restaurant->logo != "")
                 src="{{ asset('assets/images/restaurants/'. ((isset($restaurant->id))?$restaurant->id:'') .'/thumb_'. ((isset($restaurant->logo))?$restaurant->logo:'')). '?'.mt_rand() }}"/>
            @else
                src="{{ asset('assets/images/didueatdefault.png') }}" />
                <script>
                    document.getElementById('uploadbtn').innerHTML = "Update";
                </script>
            @endif
        </div>
    </div></div>

    <?= newrow($new, "", "", "", 12, true);?>
        <hr width="100%" align="center"/>
        <input name="restLogoTemp" type="hidden" id="restLogoTemp"/>
        <button type="submit" class="btn btn-primary pull-right">Save</button>
    <?= newrow();
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
            initialTags: [{!! (isset($restaurant->tags))?strToTagsConversion($restaurant->tags):'' !!}],
            placeholder: 'Enter tags ...',

            onChange: function (field, editor, tags) {
                $('#responseTags').val((tags.length ? tags.join(', ') : ''));
            },
            beforeTagDelete: function (field, editor, tags, val) {
                var q = confirm('Remove tag "' + val + '"?');

                return q;
            }
        });
    });

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
                document.getElementById('restLogoTemp').value = path;
                button.html('Upload');
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