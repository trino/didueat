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

    if(!isset($new) || !$new){
        $new = false;
        $searchcode= "";
    } else {
        $searchcode = ' ONKEYUP="restsearch(event);"';
    }
    
    if(isset($restaurant->name)){
         $GLOBALS['thisIdentity']="Restaurant%20Name:%20%20%20".$restaurant->name."%20%20(Restaurant ID:%20".Session::get('session_restaurant_id').",%20Profile ID:%20".Session::get('session_ID').")";
    }

    $alts = array(
            "browse" => "Browse for a picture to upload",
            "logo" => "The restaurant's current picture"
    );

echo newrow($new, "Restaurant Name", "",true); ?>
    <input name="initialRestSignup" type="hidden" value="1" />
    <input type="text" name="restname" id="restname" class="form-control" {{ $is_disabled }} value="{{ (isset($restaurant->name) && $restaurant->name)?$restaurant->name: old("restname") }}" required
    <?= $searchcode; ?>>
    @if($new)
        <DIV ID="restsearch" CLASS=""></DIV>
        <INPUT TYPE="hidden" name="claim" id="claim">

    @endif
<? echo newrow(); ?>

<?= newrow($new, "Restaurant Phone Number", "", true); ?>
    <input type="text" name="phone" id="phone" class="form-control" {{ $is_disabled }} value="{{ (isset($restaurant->phone))?$restaurant->phone: old("phone")}}" required>
</div></div>

<?php if(!$new){
    echo newrow($new, "Description", "", false, 9);
    echo '<textarea name="description" class="form-control"' . $is_disabled . '>';
    if (isset($restaurant->description)){ echo $restaurant->description; } else { echo old('description');}
    echo '</textarea>' . newrow();

    if($restaurant->is_complete){
        echo newrow($new, "Accept Online Orders", "", false, 9) . '<label class="c-input c-checkbox"><input name="open" type="checkbox" value="1"';
        if($restaurant->open){echo " CHECKED";}
        echo '>Yes<span class="c-indicator"></span></label></DIV></DIV>';
    }
}
echo '<DIV id="cuisinelist">';
echo newrow($new, "Cuisine", "", true, 9, '<br>(Select up to 3)');
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
    echo "<div class='cuisineCB col-sm-4 col-xs-6'><LABEL class='c-input c-checkbox'><input name='cuisine" . $cnt . "' type='checkbox' onclick='this.checked=chkCBs(this.checked)' value='" . $name . "'";
    if (isset($restaurant->cuisine)) {
        if (in_array($name, $cuisineExpl)) {
            echo " checked";
            $cuisinesChkd++;
        }
    }
    echo " />" . $name . "<span class='c-indicator'></span></LABEL></div>";
    $cnt++;
}

echo '</div><DIV STYLE="color: red; display: none;" ID="cousine-error">You must select at least one cuisine in order to continue. You may make adjustments later.</DIV><script>var cuisineCnt = ' . $cnt . '; var cbchkd = ' . $cuisinesChkd . ';</script></div></div></div>';

if(!$minimum && isset($restaurant->id)){
        echo newrow($new, "Logo", "", "", 7);
        $logoname = 'assets/images/restaurants/'. $restaurant->id .'/small-' . $restaurant->logo;
        ?>
        <a href="javascript:void(0);" id="uploadbtn" class="btn btn-success pull-left rightmarg" title="{{ $alts["browse"] }}">Browse</a><div id="browseMsg" class="label smRd"></div>

        <div class="clearfix pull-left">
            <input type="hidden" name="logo" id="hiddenLogo"/>

            <img id="picture" class="logopic" alt="{{ $alts["logo"] }}"
                @if(isset($restaurant->logo) && $restaurant->logo != "")
                    title="{{ $logoname }}"
                    src="{{ asset($logoname) ."?" . date('U') }}"/>
                @else
                    src="{{ asset('assets/images/small-smiley-logo.png') }}"/>
                @endif
                    <!-- <span id="fullSize" class="smallT"></span> -->
        </div>
    </div></div>
    <div class="form-group row editaddress ">
        <label id="import_csv" class="col-md-3 text-md-right">Import Menu CSV</label>
        <div class="col-md-7">
            <input type="file" name="import_csv" class="form-control" />
        </div>
    </div>
 
    <?= newrow($new, "", "", "", 12, true);?>
        <hr class="m-y-1" align="center"/>
        <input name="restLogoTemp" type="hidden" id="restLogoTemp"/>
        <button type="submit" class="btn btn-primary pull-right">Save</button>
    <?= newrow();
}
?>


<script>
    function validateFn(f) {
        var cuisinesStr = "";
        var noneChkd = true;
        var comma = "";

        if ($("#restid").is(":visible")) {
            var id = $('#restid option:selected').val();
            if (id) {
                noneChkd = false;
            }
        }

        for (var i = 0; i < cuisineCnt; i++) {
            if (f.elements["cuisine" + i].checked) {
                noneChkd = false;
                if (cuisinesStr != "") {
                    comma = ",";
                }
                cuisinesStr += comma + f.elements["cuisine" + i].value
            }
        }
        f.cuisines.value = cuisinesStr;

        $("#cousine-error").hide();
        if (noneChkd) {
            $("#cousine-error").show();
            f.description.focus(); // bring user to cuisine list
            
            return false;
        }
    }

    function claimrestaurant(){
        var id = $('#restid option:selected').val();
        if(id){
            $("#restname").val( $("#restname" + id).attr("TITLE") );

            $("#cuisinelist").hide();
            $("#common_editaddress").hide();
            $("#claim").val("true");
        } else {
            $("#cuisinelist").show();
            $("#common_editaddress").show();
            $("#claim").val("");
        }
    }

    function finishclaim(){
        if(!$("#restemail-error").is(":visible") && $("#restemail").val()) {
            alert("Done");
        } else {
            alert("Please enter a valid email address");
        }
    }

    function restsearch(event){
        return false;
        var RestaurantName = $("#restname").val();
        var PhoneNumber = $("#phone").val();
        RestaurantName = encodeURIComponent(RestaurantName.trim());
        PhoneNumber = PhoneNumber.replace(/\D/g,'');
        if(RestaurantName){// && PhoneNumber.length == 10) {
            $.ajax({
                url: "{{ url('/ajax') }}",
                type: "post",
                dataType: "HTML",
                data: "type=restsearch&name=" + RestaurantName + "&phone=" + PhoneNumber,
                success: function (msg) {
                    $("#restsearch").html(msg);
                }
            });
        }
    }

    $(document).ready(function () {

        @if(!$minimum){
            is_delivery_change();
        }
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
            data: {'_token': token, 'setSize': 'No'},
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
                window.clearInterval(interval);
                        document.getElementById(button_id).style.display="none";
                        $('#picture').attr('src', "{{ asset('assets/images/spacer.gif') }}");
                        document.getElementById('browseMsg').innerHTML="<img src='{{ asset('assets/images/uploaded-checkbox.png') }}' border='0' />&nbsp;<span class='instruct bd'>Click Save to Finish Uploading</span>";
                this.enable();
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