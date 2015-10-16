<?php
    //$Layout
    if(!isset($resturant)){$resturant = "";}
    function priority2($resturant, $Field, $Old = ""){
        if(!$Old){$Old = $Field;}
        if(isset($resturant->$Field)){
            return $resturant->$Field;
        }
        return old($Old);
    }

    $Genre = priority2($resturant, "genre");
    $RestID = "";
    $Country = "";
    $Field = "restname";
    if(isset($resturant->id)){
        $RestID = '<input type="hidden" name="id" value="' . $resturant->id . '"/>';
        $Country = $resturant->country;
        $Field = "name";
    }

    function getTime($time) {
        if (strpos($time, "AM") !== false || strpos($time, "PM") !== false){
            return $time;
        }
        return "12:00 AM";
        if (!$time){
            return $time;
        }else {
            $arr = explode(':', $time);
        }
        $hour = $arr[0];
        $min = $arr[1];
        $sec = $arr[2];
        $suffix = 'AM';
        if ($hour >= 12) {
            $hour = $hour - 12;
            $suffix = 'PM';
        }
        if (strlen($hour) == 1){
            $hour = '0' . $hour;
        }
        return $hour . ':' . $min . ' ' . $suffix;
    }
?>

<div class="col-md-4 col-sm-12 col-xs-12 ">


    <div class="portlet box red ">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i>RESTAURANT INFO
            </div>
        </div>
        <div class="portlet-body form">


            <div class="form-body">

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="control-label">Restaurant Name <span class="required">*</span></label>
                            <input type="text" name="<?=$Field; ?>" class="form-control"
                                   placeholder="Restaurant Name"
                                   value="<?= priority2($resturant, "name", $Field); ?>" required>
                        </div>
                    </div>


                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label>Cusine Type</label>
                            <select name="genre" id="genre" class="form-control">
                                <option value="">-Select One-</option>
                                @foreach($genre_list as $value)
                                    <option value="{{ $value->id }}"
                                            @if($Genre == $value->id) selected @endif>{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="control-label">Phone Number</label>
                            <input type="text" name="phone" class="form-control"
                                   placeholder="Phone Number"
                                   value="<?= priority2($resturant, "phone"); ?>">
                        </div>
                    </div>


                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="control-label">Restaurant Email <span
                                        class="required">*</span></label>
                            <input type="email" name="email" class="form-control"
                                   placeholder="Restaurant Email"
                                   value="<?= priority2($resturant, "email"); ?>" required>
                        </div>
                    </div>


                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="control-label">Description</label>
                                            <textarea name="description" class="form-control"
                                                      placeholder="Description"><?= priority2($resturant, "description"); ?></textarea>
                        </div>
                    </div>




                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <h3 class="form-section">Delivery</h3>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="control-label">Delivery Fee <span
                                        class="required">*</span></label>
                            <input type="text" name="delivery_fee" class="form-control"
                                   placeholder="Delivery Fee" value="<?= priority2($resturant, "delivery_fee"); ?>"
                                   required>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="control-label">Min. Subtotal before Delivery <span
                                        class="required">*</span></label>
                            <input type="text" name="minimum" class="form-control"
                                   placeholder="Minimum Subtotal For Delivery"
                                   value="<?= priority2($resturant, "minimum");?>" required>
                        </div>
                    </div>



                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <h3 class="form-section">Logo</h3>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-6 col-sm-6 col-xs-12"><img id="picture" class="margin-bottom-10" style="width: 100%;" src="<?php
                            if(isset($resturant->logo) && $resturant->logo){
                                echo asset('assets/images/restaurants/'.$resturant->logo);
                            } else {
                                echo asset('assets/images/default.png');
                            }
                        ?>">
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                       <a href="javascript:void(0);" id="uploadbtn" class="btn btn-success red"
                                           >Change
                                            Image</a></div>
                                        <input type="hidden" name="logo" id="hiddenLogo" />

                    </div>






                </div>


            </div>


            <?php if($RestID){
                echo '<div class="form-actions">' . $RestID . '<button type="submit" class="btn red"><i class="fa fa-check"></i> SAVE</button></div>';
            } ?>


        </div>
    </div>
</div>


<div class="col-md-4 col-sm-12 col-xs-12 ">


    <div class="portlet box red">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i> ADDRESS
            </div>
        </div>
        <div class="portlet-body form">


            <div class="form-body">

                <div class="row">




                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" name="address" class="form-control"
                                   placeholder="Street Address"
                                   value="<?= priority2($resturant, "address"); ?>" required>
                        </div>
                    </div>




                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" name="city" class="form-control" placeholder="City"
                                   value="<?= priority2($resturant, "city"); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="control-label">Province <span
                                        class="required">*</span></label>
                            <input type="text" class="form-control" name="province"
                                   placeholder="Province Name"
                                   value="<?= priority2($resturant, "province"); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label>Postal Code</label>
                            <input type="text" name="postal_code" class="form-control"
                                   placeholder="Postal Code"
                                   value="<?= priority2($resturant, "postal_code"); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label>Country</label>
                            <select name="country" id="country" class="form-control" required>
                                <option value="">-Select One-</option>
                                @foreach($countries_list as $value)
                                    <option value="{{ $value->id }}"
                                            @if($Country == $value->id) selected @endif>{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>



                </div>
            </div>


            <?php if($RestID){
                echo '<div class="form-actions">' . $RestID . '<button type="submit" class="btn red"><i class="fa fa-check"></i> SAVE</button></DIV>';
            } ?>

        </div>
    </div>
</div>


<div class="col-md-4  col-sm-12 col-xs-12">

    <div class="portlet box red">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i> HOURS
            </div>
        </div>
        <div class="portlet-body form">


            <div class="form-body">

                <?php
                $day_of_week = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
                foreach ($day_of_week as $key => $value) {
                    if(isset($resturant->id)){
                        $open[$key] = select_field_where('hours', array('restaurant_id' => $resturant->id, 'day_of_week' => $value), 'open');
                        $close[$key] = select_field_where('hours', array('restaurant_id' => $resturant->id, 'day_of_week' => $value), 'close');
                        $ID[$key] = select_field_where('hours', array('restaurant_id' => $resturant->id, 'day_of_week' => $value), 'id');
                    } else {
                        $open[$key] = select_field_where('hours', array('restaurant_id' => \Session::get('session_restaurant_id'), 'day_of_week' => $value), 'open');
                        $close[$key] = select_field_where('hours', array('restaurant_id' => \Session::get('session_restaurant_id'), 'day_of_week' => $value), 'close');
                    }
                    ?>
                        <div class="row">
                            <div class="form-group">


                                <label class="control-label col-md-3 col-sm-3 col-xs-3"><?php echo $value; ?></label>


                                <div class=" col-md-3 col-sm-3 col-xs-3">
                                    <input type="text" name="open[<?= $key; ?>]"
                                           value="<?= getTime($open[$key]); ?>"
                                           class="form-control time"/>
                                </div>


                                <div class="  col-md-3 col-sm-3 col-xs-3"
                                     style="vertical-align: bottom;text-align: center;font-size: 14px;">
                                    to
                                </div>

                                <div class=" col-md-3 col-sm-3 col-xs-3">
                                    <input type="text" name="close[<?= $key; ?>]"
                                           value="<?= getTime($close[$key]); ?>"
                                           class="form-control time"/>
                                    <input type="hidden" name="day_of_week[<?= $key; ?>]"
                                           value="<?= $value; ?>"/>
                                    <?php if (isset($ID)){
                                        echo '<input type="hidden" name="idd[' . $key . ']" value="' . $ID[$key] . '"/>';
                                    } ?>
                                </div>


                            </div>

                        </div>
                <?php } ?>
            </div>

            <?php if($RestID){
                echo '<div class="form-actions">' . $RestID . '<button type="submit" class="btn red"><i class="fa fa-check"></i> SAVE</button></div>';
            } ?>


        </div>
    </div>
</div>
<?php if(!$RestID){ ?>
<div class="col-md-4 col-sm-12 col-xs-12">
    <div class="portlet box red ">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i>CREATE USERNAME & PASSWORD
            </div>
        </div>
        <div class="portlet-body form">
            <DIV CLASS="form-body">
                <div class="row">
                    @include('common.signupform')
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <input type="submit" class="btn btn-primary red" value="Save Changes">
                    </div>
                </div>
            </div>
        </div>
    </div>
</DIV>
<?php } ?>

<script>
function ajaxuploadbtn(button_id) {
            var button = $('#' + button_id), interval;
            act = base_url+'uploadimg/restaurant';
            new AjaxUpload(button, {
                action: act,
                name: 'myfile',
                data:{'_token':'{{csrf_token()}}'},
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
                    //alert(response);return;
                        //alert(response);
                        var resp = response.split('___');
                        var path = resp[0];
                        var img = resp[1];
                        button.html('Change Image');
                    
                    window.clearInterval(interval);
                    this.enable();
                        $('#picture').attr('src',path);
                        $('#hiddenLogo').val(img);
                        //$("."+button_id.replace('newbrowse','menuimg')).html('<img src="'+path+'" /><input type="hidden" class="hiddenimg" value="'+img+'" />');
                        //$("."+button_id.replace('newbrowse','menuimg')).attr('style','min-height:0px!important;')
                        //$('#client_img').val(response);
                    
//$('.flashimg').show();
                }
            });
        }
$(function(){
    ajaxuploadbtn('uploadbtn');
})

</script>
