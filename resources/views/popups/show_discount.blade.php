

<div class="">
    <LABEL class="nomar">
        <input <?php if(isset($model->has_discount) && $model->has_discount == 1){?>checked="checked"<?php }?> type="checkbox" class="allow_dis" onclick="if($(this).is(':checked'))$('.allow_discount<?php echo $menu_id;?>').show();else $('.allow_discount<?php echo $menu_id;?>').hide();" /> &nbsp;&nbsp;<strong>Allow Discount</strong>
    </LABEL>

</div>


<div class="allow_discount<?php echo $menu_id;?>" style="<?php if(!isset($model)|| (isset($model->has_discount) && $model->has_discount == 0)){?>display: none;<?php }?>">
    <br />
    <div class="form-group">
        <label class="col-md-6 "><strong>Discount %</strong></label>
        <div class="col-md-6 ">
            <select class="disc_per form-control">
                <option>Discount Percentage</option>
                <?php for($i=5;$i<96;$i=$i+5){ ?>
                    <option value="{{ $i }}"
                        <?php if(isset($model->discount_per) && $i == $model->discount_per){?> selected="selected"<?php }?>>{{ $i }}</option>
                <?php }?>
            </select>

        </div>
        <div class="clearfix"></div>
    </div>
    <div class="form-group">
        <div class="col-md-6 ">
            <strong>Discount Applied for:</strong>
        </div>
        <div class="col-md-6  alldays">
            <LABEL><input type="checkbox" class="days_discount_all"/> Select All<br /></LABEL><BR />
            <?php
                $days = array();
                if(isset($model->days_discount) && $model->days_discount) {
                    $days = explode(',',$model->days_discount);
                }
                $weekdays = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
                foreach($weekdays as $k=>$weekday){
                    $shortday = left($weekday, 3);
                    if($k==0 || $k==4)
                    {
                        ?>
                        <div class="col-md-6 ">
                        <?php
                    }
                    echo '<LABEL style="font-weight:normal;"><input type="checkbox" class="days_discount" ';
                    if(in_array($shortday,$days)){echo 'checked="checked"';}
                    echo 'value="' . $shortday . '"/> ' . $weekday . '</LABEL><br />';
                    if($k==3 || $k==6)
                    {
                        ?>
                        </div>
                        <?php
                    }
                }
            ?>
        </div>
        <div class="clearfix"></div>
        <br />
    </div>
</div>
            
            