@if(!$menu_id)
    <style> .resturant-arrows {
            display: none;
        } </style>
@endif















<div class="newmenu ignore" id="newmenu0">
    <?php printfile("views/dashboard/restaurant/menu_form.blade.php"); ?>
    <p>&nbsp;</p>

    <div class="col-md-12 col-sm-12 col-xs-12 ignore">
        <div class="col-sm-2 col-xs-12 nopadd ignore">
            <div class="menuimg ignore menuimg{{ $menu_id }}_1"
                 @if(isset($model) && $model->image) style="min-height:0;" @endif>
                @if(isset($model) && $model->image)
                    <img src="{{ asset('assets/images/restaurants/' . $model->restaurant_id . "/menus/" . $model->id . '/thumb_' . $model->image) }}"
                         class="ignore" style="max-width:100%;"/>
                    <input type="hidden" class="hiddenimg ignore" value="{{ $model->image }}"/>
                @endif
            </div>
            <br class="ignore"/>
            <a href="javascript:void(0)" class="btn btn-sm btn-success blue newbrowse ignore" id="newbrowse{{ $menu_id }}_1">Image</a>
        </div>

        <div class="col-sm-10 col-xs-12 lowheight ignore par_wrap">
            @if(count($category))
                <select class="cat_id form-control">
                    <option value="">Choose Category</option>
                    
                    
                    @foreach($category as $cat)
                        <option value="{{ $cat->id }}"
                                @if(isset($model->cat_id) && $cat->id == $model->cat_id) selected="selected" @endif>{{ $cat->title }}</option>
                    @endforeach
                    
                </select><br />
                <input <?php if(isset($model->has_discount) && $model->has_discount == 1){?>checked="checked"<?php }?> type="checkbox" class="allow_dis" onclick="if($(this).is(':checked'))$('.allow_discount<?php echo $menu_id;?>').show();else $('.allow_discount<?php echo $menu_id;?>').hide();" /> &nbsp;&nbsp;<strong>Allow Discount</strong> &nbsp;&nbsp;&nbsp; <input <?php if(isset($model->is_active) && $model->is_active == 1){?>checked="checked"<?php }?> type="checkbox" class="allow_dis" onclick="check_enable($(this),<?php echo $menu_id?>);" /> &nbsp;&nbsp;<strong>Enable Item</strong> <span class="enabled" style="display: none;">Enabled</span> <span class="disabled" style="display: none;">Disabled</span> 
                
                <div class="allow_discount<?php echo $menu_id;?>" style="<?php if(!isset($model->has_discount) || (isset($model->has_discount) && $model->has_discount == 0)){?>display: none;<?php }?>">
                <br />
                <select class="disc_per">
                <option>Choose Discount Percentage: </option> 
                <?php for($i=0;$i<101;$i=$i+5){ ?>
                        <option value="{{ $i }}"
                                <?php if(isset($model->discount_per) && $i == $model->discount_per){?> selected="selected"<?php }?>>{{ $i }}</option>
                  <?php }?>
                </select>
                <br />
                <strong>Discount Applied for:</strong><br />
                <?php
                $days = array();
                if(isset($model->days_discount) && $model->days_discount)
                {
                    $days = explode(',',$model->days_discount);
                }
                ?>
                <input type="checkbox" class="days_discount_all"/> Select All<br />
                <input type="checkbox" class="days_discount" <?php if(in_array('Sunday',$days)){?>checked="checked"<?php }?> value="Sunday"/> Sunday<br />
                <input type="checkbox" class="days_discount" <?php if(in_array('Monday',$days)){?>checked="checked"<?php }?> value="Monday"/> Monday<br />
                <input type="checkbox" class="days_discount" <?php if(in_array('Tuesday',$days)){?>checked="checked"<?php }?> value="Tuesday"/> Tuesday<br />
                <input type="checkbox" class="days_discount" <?php if(in_array('Wednesday',$days)){?>checked="checked"<?php }?> value="Wednesday"/> Wednesday<br />
                <input type="checkbox" class="days_discount" <?php if(in_array('Thursday',$days)){?>checked="checked"<?php }?> value="Thursday"/> Thursday<br />
                <input type="checkbox" class="days_discount" <?php if(in_array('Friday',$days)){?>checked="checked"<?php }?> value="Friday"/> Friday<br />
                <input type="checkbox" class="days_discount" <?php if(in_array('Saturday',$days)){?>checked="checked"<?php }?> value="Saturday"/> Saturday<br /><br />
                
                </div>
                <!--<strong>&nbsp; &nbsp; OR</strong> &nbsp; &nbsp;
                <a href="javascript:void(0);" onclick="$('.catblock').toggle();">Create New</a><br/>-->
                <div class="catblock" style="display: none;">
                    <input type="text" class="form-control cat_title" placeholder="Add new category"/>
                    <a href="javascript:void(0);" class="btn btn-sm btn-primary" id="save_cat">Create</a>

                    <div class="clearfix"></div>
                </div>
            @else
                <input type="text" placeholder="Add new category" class="form-control cat_id"/>
            @endif
            <input class="form-control newtitle ignore" type="text" placeholder="Title"
                   value="{{ (isset($model->menu_item))? $model->menu_item : "" }}"/><br class="ignore"/>
            <input class="form-control newprice pricechk ignore" type="text" placeholder="$"
                   value="{{ (isset($model->price))? $model->price : "" }}"/><br class="ignore"/>
            <textarea class="form-control newdesc ignore"
                      placeholder="Description">{{ (isset($model->description))? $model->description : "" }}</textarea>
            <input type="hidden" id="res_slug" value="{{ $res_slug }}"/>
        </div>
        <div class="clearfix ignore"></div>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12 ignore">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ignore">
                @if(!isset($ccount) || (isset($ccount) && $ccount == 0))
                    <div class="newaction ignore">
                        <a href="javascript:void(0)" class="btn btn-sm btn-info add_additional ignore blue"
                           id="add_additional{{ $menu_id }}">Add Addons</a>
                        <a href="javascript:void(0)" id="save{{ $menu_id }}" data-id="{{ $menu_id }}"
                           class="btn btn-sm btn-info blue savebtn ignore">Save</a>
                    </div>
                @endif
            </div>
        </div>
    </div>


    <div class="clearfix ignore"></div>


    <hr class=" ignore"/>


    <div class="additional additional{{ $menu_id }} ignore"
         style="@if(isset($cmodel) && $cmodel) display:block; @endif">
        <div class="col-md-12 ignore"><h2 class="ignore">Addons</h2></div>
        <div class="clearfix ignore"></div>
        <?php
        $k = 0;
        if(isset($cmodel)){
            
        if (isset($_GET['menu_id'])) {
            $menu_id = $_GET['menu_id'];
        }
        //var_dump($cmodel);
        foreach($cmodel as $child){
        $k++;
        if ($k == 1)
            echo "<div class='ignore' id='subcat" . $menu_id . "'>";

        ?>
        @include('common.additional')
        <?php
        }
        if ($k > 0)
            echo "</div>";
        ?>
        <script class="ignore ignore2 ignore1">
            $(function () {
                $(".sorting_child").live('click', function () {
                    // alert('test');
                    var pid = $(this).attr('id').replace('child_up_', '').replace('child_down_', '');
                    var sort = 'down';
                    if ($(this).attr('id') == 'child_up_' + pid) {
                        sort = 'up';
                    }

                    var order = '';// array to hold the id of all the child li of the selected parent
                    $('#subcat{{ $menu_id }} .cmore').each(function (index) {
                        var val = $(this).attr('id').replace('cmore', '');
                        //var val=item[1];
                        if (order == '') {
                            order = val;
                        } else {
                            order = order + ',' + val;
                        }
                    });
                    $.ajax({
                        url: "{{ url('restaurant/orderCat') }}/" + pid + '/' + sort,
                        data: 'ids=' + order + '&_token={{ csrf_token() }}',
                        type: 'post',
                        success: function (res) {
                            $('#addmore' + res).load("{{ url('restaurant/loadChild') }}/" + res + '/0');
                        }
                    });
                });
            });
        </script>
        <?php } ?>


    </div>
    <div class="clearfix ignore"></div>


</div>















<script>
    $(function () {
        $(".addon_sorting").live('click', function () {
            // alert('test');
            var pid = $(this).attr('id').replace('addon_up_', '').replace('addon_down_', '');
            if ($(this).attr('id') == 'child_up_' + pid) {
                var sort = 'up';
            }
            else
                var sort = 'down';

            var order = '';// array to hold the id of all the child li of the selected parent
            $('#subcat{{ $menu_id }} .menuwrapper').each(function (index) {
                var val = $(this).attr('id').replace('sub', '');
                //var val=item[1];
                if (order == '') {
                    order = val;
                } else {
                    order = order + ',' + val;
                }
            });

            $.ajax({
                url: "{{ url('restaurant/orderCat/') }}/" + pid + '/' + sort,
                data: 'ids=' + order + "&_token={{ csrf_token() }}",
                type: 'post',
                success: function (res) {
                    $('#parent' + res).load(base_url + 'restaurant/menu_form/' + res, function () {
                        ajaxuploadbtn('newbrowse' + res + '_1');
                    });
                }
            });

        });

        $('#save_cat').live('click', function () {
            $('.overlay_loader').show();
            var cat = $('.cat_title').val();
            if (cat == '') {
                $('.overlay_loader').hide();
                alert('Please enter category title');
                return false;
            } else {
                $.ajax({
                    url: "{{ url('restaurant/saveCat/') }}",
                    data: 'title=' + cat + "&_token={{ csrf_token() }}&res_id={{ (isset($restaurant->id))? $restaurant->id : $res_id }}",
                    type: 'post',
                    success: function (res) {
                        $('.overlay_loader').hide();
                        alert('Category added successfully');
                        $('.cat_id').append('<option value="' + res + '" selected="selected">' + cat + '</option>');
                        $('.cat_title').val('');
                        $('.catblock').fadeOut('slow');
                    }
                });
            }
        });

    });
</script>

<style>
    .cat_id {
        display: inline-block !important;
        width: 60%;
    }
</style>