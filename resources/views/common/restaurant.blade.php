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
<meta name="_token" content="{{ csrf_token() }}"/>
<script src="<?= url("assets/global/scripts/provinces.js"); ?>" type="text/javascript"></script>
<div class="col-md-4 col-sm-12 col-xs-12 ">
    <div class="box-shadow">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-long-arrow-right"></i>RESTAURANT INFO
            </div>
        </div>
        <div class="portlet-body form">

            <div class="form-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="control-label">Restaurant Name <span class="required">*</span></label>
                            <input type="text" name="restname" class="form-control" placeholder="Restaurant Name" value="{{ old('restname') }}" required>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label>Cuisine Type</label>
                            <select name="genre" id="genre" class="form-control">
                                <option value="">-Select One-</option>
                                @foreach($genre_list as $value)
                                    <option value="{{ $value->id }}" @if(old('genre') == $value->id) selected @endif>{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="control-label">Description</label>
                            <textarea name="description" class="form-control" placeholder="Description">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <h3 class="form-section">Delivery</h3>
                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="form-group">
                            <label class="control-label">Delivery Fee <span class="required">*</span></label>
                            <input type="number" name="delivery_fee" class="form-control" placeholder="Delivery Fee" value="{{ old('delivery_fee') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="form-group">
                            <label class="control-label">Min. Subtotal before Delivery <span class="required">*</span></label>
                            <input type="number" name="minimum" class="form-control" placeholder="Minimum Subtotal For Delivery" value="{{ old('minimum') }}" required>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <h3 class="form-section">Logo</h3>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <img id="picture" class="margin-bottom-10 full-width" src="<?php
                            if(isset($resturant->logo) && $resturant->logo){
                                echo asset('assets/images/restaurants/'.$resturant->logo);
                            } else {
                                echo asset('assets/images/default.png');
                            }
                        echo '?'.mt_rand(); ?>" />
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <a href="javascript:void(0);" id="uploadbtn" class="btn btn-success red">Change Image</a>
                        </div>
                        <input type="hidden" name="logo" id="hiddenLogo" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="col-md-4 col-sm-12 col-xs-12 ">
    <div class="box-shadow">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-long-arrow-right"></i> ADDRESS
            </div>
        </div>
        <div class="portlet-body form">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="control-label">Address <span class="required">*</span></label>
                            <input type="text" name="address" class="form-control" placeholder="Street Address" value="{{ old('address') }}" required>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="control-label">City <span class="required">*</span></label>
                            <input type="text" name="city" class="form-control" placeholder="City" value="{{ old('city') }}" required>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="control-label">Postal Code <span class="required">*</span></label>
                            <input type="text" name="postal_code" class="form-control" placeholder="Postal Code" value="{{ old('postal_code') }}" required>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="control-label">Phone Number <span class="required">*</span></label>
                            <input type="text" name="phone" class="form-control" placeholder="Phone Number" value="{{ old('phone') }}" required>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="control-label">Province <span class="required">*</span></label>
                            <select name="province" id="province" class="form-control" id="province" required>
                                <option value="">-Select One-</option>
                                @foreach($states_list as $value)
                                    <option value="{{ $value->id }}" @if(old('province') == $value->id) selected @endif>{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="control-label">Country <span class="required">*</span></label>
                            <select name="country" id="country" class="form-control" required onchange="provinces('<?= addslashes(url("ajax")); ?>', '<?= old('province'); ?>');">
                                <option value="">-Select One-</option>
                                @foreach($countries_list as $value)
                                    <option value="{{ $value->id }}" @if(old('country') == $value->id) selected @endif>{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-4 col-sm-12 col-xs-12">
    <div class="box-shadow">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-long-arrow-right"></i> HOURS
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
                            <input type="text" name="open[<?= $key; ?>]" value="<?= getTime($open[$key]); ?>" class="form-control time"/>
                        </div>
                        <div class="  col-md-3 col-sm-3 col-xs-3" id="hour-to-style"> to </div>
                        <div class=" col-md-3 col-sm-3 col-xs-3">
                            <input type="text" name="close[<?= $key; ?>]" value="<?= getTime($close[$key]); ?>" class="form-control time"/>
                            <input type="hidden" name="day_of_week[<?= $key; ?>]" value="<?= $value; ?>"/>
                            <?php
                            if (isset($ID)){
                                echo '<input type="hidden" name="idd[' . $key . ']" value="' . $ID[$key] . '"/>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>


<div class="col-md-4 col-sm-12 col-xs-12">
    <div class=" box-shadow">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-long-arrow-right"></i>CREATE USERNAME & PASSWORD
            </div>
        </div>
        <div class="portlet-body form">
            <DIV CLASS="form-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group clearfix">
                            <label for="name" class="col-md-12 col-sm-12 col-xs-12 control-label">Full Name <span class="required">*</span></label>

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="input-icon">
                                    <input type="text" name="full_name" class="form-control" id="name" placeholder="Full Name" value="{{ old('full_name') }}" required="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group clearfix">
                            <label for="email" class="col-md-12 col-sm-12 col-xs-12 control-label">Email <span class="required">*</span></label>

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="input-icon">
                                    <input type="email" name="email" class="form-control" id="email" placeholder="Email Address" value="{{ old('email') }}" required="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-long-arrow-right"></i> Choose Password
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group clearfix">
                            <label for="password" class="col-md-12 col-sm-12 col-xs-12 control-label">Password <span class="required">*</span></label>

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="input-icon">
                                    <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group clearfix">
                            <label for="confirm_password" class="col-md-12 col-sm-12 col-xs-12 control-label">Re-type Password <span class="required">*</span></label>

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="input-icon">
                                    <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Re-type Password" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group clearfix">
                            <label for="subscribed" class="col-md-12 col-sm-12 col-xs-12 control-label">&nbsp;</label>

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label>
                                    <input type="checkbox" name="subscribed" id="subscribed" value="1" />
                                    Sign up for our Newsletter
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <input type="submit" class="btn btn-primary red" value="Save Changes">
                    </div>
                </div>
            </div>
        </div>
    </div>
</DIV>

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
            var resp = response.split('___');
            var path = resp[0];
            var img = resp[1];
            button.html('Change Image');

            window.clearInterval(interval);
            this.enable();
            $('#picture').attr('src',path);
            $('#hiddenLogo').val(img);
        }
    });
}
$(function(){
    ajaxuploadbtn('uploadbtn');
});
</script>
