<?php
    printfile("views/dashboard/restaurant/restaurant.blade.php");

    echo newrow($new, "Restaurant Name", "", true);
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
       {{ $is_disabled }} placeholder=""
       value="{{ (isset($restaurant->name) && $restaurant->name)?$restaurant->name: old("restname") }}" required>
</div></div>

<?php if($minimum){
echo newrow($new, "Description", "", false); ?>
    <textarea required name="description" class="form-control" {{ $is_disabled }} placeholder="">{{ (isset($restaurant->description))?$restaurant->description: old('description') }}</textarea>
</div></div>
<?php }

if(!isset($email)){
echo newrow($new, "Phone", "", true); ?>
<input type="text" name="phone" class="form-control" {{ $is_disabled }} placeholder=""
       value="{{ (isset($restaurant->phone))?$restaurant->phone: old("phone")}}" required>
</div></div>
<?php }

$brTag="<br/>";
$brTag2="";
if(isset($restSignUpPg)){
 $brTag="";
 $brTag2="<br/>";
}

echo newrow($new, "Restaurant Cuisine (Select up to 3)", "", true, 9, '<div class="row">');

echo '<input name="cuisines" type="hidden" />';
$cuisineExpl = "";
if (isset($restaurant->cuisine)) {
    $cuisineExpl = explode(",", $restaurant->cuisine);
}

$cnt = 0; 
$cuisinesChkd = 0;
$cuisineListA = array();
foreach ($cuisine_list as $value) {
    $cuisineListA[] = $value;
}

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
    echo newrow($new, "Tags"); ?>
        <a name="setlogo"></a>
        <textarea id="demo4"></textarea>
        <input type="hidden" name="tags" id="responseTags" value="{!! (isset($restaurant->tags))?$restaurant->tags:old('tags') !!}"/>
        <p>Separate tags by commas (e.g: Canadian, Italian, Chinese, Fast Food)</p>
    </div></div>
    
    <?= newrow($new, "Description", "", true, 8); ?>
        <textarea required name="description" class="form-control" {{ $is_disabled }} placeholder="">{{ (isset($restaurant->description))?$restaurant->description: old('description') }}</textarea>
        <?php
            echo newrow();
            echo newrow($new, "Logo", "", "", 7);
        ?>
        <a href="javascript:void(0);" id="uploadbtn" class="btn btn-success pull-left rightmarg">Upload New Logo</a>

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