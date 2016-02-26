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

        ?>
<?

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
}
echo '<DIV id="cuisinelist">';
echo newrow($new, "Genres", "", true, 9, ' (Select up to 3)');
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
    echo "<div class='cuisineCB col-sm-4'><LABEL class='c-input c-checkbox'><input name='cuisine" . $cnt . "' type='checkbox' onclick='this.checked=chkCBs(this.checked)' value='" . $name . "'";
    if (isset($restaurant->cuisine)) {
        if (in_array($name, $cuisineExpl)) {
            echo " checked";
            $cuisinesChkd++;
        }
    }
    echo " />" . $name . "<span class='c-indicator'></span></LABEL></div>";
    $cnt++;
}

echo '</div><DIV STYLE="color: red; display: none;" ID="cousine-error">You must select at least one genre in order to continue. You may make adjustments later.</DIV><script>var cuisineCnt = ' . $cnt . '; var cbchkd = ' . $cuisinesChkd . ';</script></div></div></div>';

if(!$minimum && isset($restaurant->id)){
        echo newrow($new, "Logo", "", "", 7);
        $logoname = 'assets/images/restaurants/'. $restaurant->id .'/small-' . $restaurant->logo;
        ?>
        <a href="javascript:void(0);" id="uploadbtn" class="btn btn-success pull-left rightmarg">Browse</a><div id="browseMsg" class="label smRd"></div>

        <div class="clearfix pull-left">
            <input type="hidden" name="logo" id="hiddenLogo"/>

            <img id="picture" class="logopic" align=""
                @if(isset($restaurant->logo) && $restaurant->logo != "")
                    title="{{ $logoname }}"
                    src="{{ asset($logoname) ."?" . date('U') }}"/>
                @else
                    src="{{ asset('assets/images/small-smiley-logo.png') }}"/>

                @endif
                    <span id="fullSize" class="smallT"></span>
        </div>
    </div></div>

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

@if(!$minimum && isset($restaurant->id))

           var pictureW=parseInt(document.getElementById('picture').clientWidth);
           if(pictureW > 450){
              var pictureH=parseInt(document.getElementById('picture').clientHeight);
              var new_pictureH=450/pictureW*pictureH;
              document.getElementById('picture').style.width=450+"px"
              document.getElementById('picture').style.height=new_pictureH+"px";
              document.getElementById('fullSize').innerHTML="Full size image is "+pictureW+" x "+pictureH+" pixels";
           }
@endif

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
                        var imgV = new Image();
                        imgV.src = path;
                        var imgW=0;
                        imgV.onload = function() {
                        var imgW=this.width;
                        var imgH=this.height;
	                       if(imgW > 500){
	                         document.getElementById('picture').style.width="100%";
                          document.getElementById('fullSize').innerHTML="Full size image is "+imgW+" x "+imgH+" pixels";
	                        }
	                        else{
                          document.getElementById('fullSize').innerHTML="";
	                         document.getElementById('picture').style.width=imgW+"px";
	                         document.getElementById('picture').style.height=imgH+"px";
	                        }
                        }

                document.getElementById('restLogoTemp').value = path;
                button.html('Browse');
                document.getElementById('browseMsg').innerHTML="&nbsp;<span class='instruct bd'>&#8594; </span>Remember to Click Save to Finish Uploading";
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