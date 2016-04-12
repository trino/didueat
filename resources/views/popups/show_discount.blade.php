<div class="col-md-12">


    <label style="visibility: hidden" class="c-input c-checkbox p-r-1">

        <input <?php if(!isset($model) || (isset($model->is_active) && $model->is_active == 1)){?>checked="checked"
               <?php }?> type="checkbox" class="is_active"/>Enable Item


        <span class="c-indicator"></span>
    </label>


    <span class="enabled" style="display: none;">Enabled</span>
    <span class="disabled" style="display: none;">Disabled</span>


    <!--label class="c-input c-checkbox">

        <input <?php if(isset($model->has_discount) && $model->has_discount == 1){?>checked="checked"
               <?php }?> type="checkbox" class="allow_dis"
               onclick="if($(this).is(':checked'))$('.allow_discount<?php echo $menu_id;?>').show();else $('.allow_discount<?php echo $menu_id;?>').hide();"/>Enable
        Discount


        <span class="c-indicator"></span>
    </label-->


</div>


<div class="allow_discount<?php echo $menu_id;?>"
     style="<?php if(!isset($model) || (isset($model->has_discount) && $model->has_discount == 0)){?>display: none;<?php }?>">



        <div class="col-md-6 ">
            <select class="disc_per form-control">
                <?php for($i = 5;$i < 96;$i = $i + 5){ ?>
                <option value="{{ $i }}"
                        <?php if(isset($model->discount_per) && $i == $model->discount_per){?> selected="selected"<?php }?>>{{ $i }}% off</option>
                <?php }?>
            </select>

        </div>


        <div class="col-md-12 ">
            <label class="clearfix  c-input c-checkbox p-r-1">


                <input type="checkbox" class="days_discount_all"/> Select All

                <span class="c-indicator"></span>
            </label>


            <?php

            $days = array();
            if (isset($model->days_discount) && $model->days_discount) {
                $days = explode(',', $model->days_discount);
            }
            $weekdays = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");

            foreach ($weekdays as $k => $weekday) {

                $shortday = left($weekday, 3);

                echo '

<label class="clearfix c-input c-checkbox p-r-1"><input type="checkbox" class="days_discount" ';
                if (in_array($shortday, $days)) {
                    echo 'checked="checked"';
                }

                echo 'value="' . $shortday . '"/> ' . $weekday . '


                                    <span class="c-indicator"></span>
</LABEL>';

            }
            ?>
        </div>

</div>
            
            