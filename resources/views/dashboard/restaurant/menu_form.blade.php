<?php //$Manager->fileinclude(__FILE__); ?>
<script src="{{ url('assets/global/scripts/additional.js') }}" class="ignore ignore1"></script>

<div class="newmenu ignore ignore1" id="newmenu0">
    
    <p>&nbsp;</p>
    <div class="col-md-6 col-sm-6 col-xs-12 ignore ignore1">
        <div class="col-sm-5 col-xs-12 nopadd ignore ignore1">
            <div class="menuimg ignore ignore1 menuimg<?php echo $menu_id?>_1" <?php if(isset($model) && $model->image){?>style="min-height:0;"<?php }?>><?php if(isset($model) && $model->image){?><img src="<?php echo url('assets/images/products/'.$model->image) ?>" class="ignore ignore1" /><input type="hidden" class="hiddenimg ignore ignore1" value="<?php echo $model->image;?>" /><?php }?></div>
            <br class="ignore ignore1" />
            <a href="javascript:void(0)" class="btn btn-success newbrowse ignore ignore1" id="newbrowse<?php echo $menu_id?>_1">Image</a>
        </div>
        <div class="col-sm-7 col-xs-12 lowheight ignore ignore1">
            <input class="form-control newtitle ignore ignore1" type="text" placeholder="Title" value="<?php if(isset($model->menu_item)){echo $model->menu_item; }?>" /><br class="ignore ignore1" />
            <input class="form-control newprice pricechk ignore ignore1" type="text" placeholder="$" value="<?php if(isset($model->price)){echo $model->price; }?>" /><br class="ignore ignore1" />
            <textarea class="form-control newdesc ignore ignore1" placeholder="Description"><?php if(isset($model->description)){echo $model->description; }?></textarea>
        </div> 
        <div class="clearfix ignore ignore1"></div>   
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12 ignore ignore1">
        <div class="col-md-12 col-sm-12 col-xs-12 ignore ignore1">
            <?php if(!isset($ccount) || (isset($ccount) && $ccount==0)){ ?>
            <div class="newaction ignore ignore1">
                <a href="javascript:void(0)" class="btn btn-info add_additional ignore ignore1" id="add_additional<?php echo $menu_id;?>">Add Addons</a>
                <a href="javascript:void(0)" id="save0" data-id="<?php echo $menu_id;?>" class="btn btn-info savebtn ignore ignore1">Save</a>
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="clearfix ignore ignore1"></div> 
    
    <hr class=" ignore ignore1" />
    
    <div class="additional additional<?php echo $menu_id;?> ignore ignore1" style="<?php if(isset($cmodel)&& $cmodel){?>display:block;<?php }?>">
        <div class="col-md-12 ignore ignore1"><h2 class="ignore ignore1">Addons</h2></div>
        <div class="clearfix ignore ignore1"></div>
        <?php
        $k=0;
            if(isset($cmodel)){
                
                foreach($cmodel as $child){
                    $k++;
                    if($k==1)
                    echo "<div class='ignore' id='subcat".$menu_id."'>";
                    ?>
                    @include('common.additional')
                    <?php
                }
                if($k>0)
                echo "</div>";
            }
        ?>
    </div>
    <div class="clearfix ignore ignore1"></div>
</div>
<script>
$(function(){
        $('#subcat<?php echo $menu_id;?>').sortable({
            update: function(event, ui) {
                var order = '';// array to hold the id of all the child li of the selected parent
                $('#subcat<?php echo $menu_id?> .menuwrapper').each(function(index) {
                    var val = $(this).attr('id').replace('sub', '');
                    //var val=item[1];
                    if (order == '') {
                        order = val;
                    } else {
                        order = order + ',' + val;
                    }
                });
                $.ajax({
                    url: '<?php echo url('restaurant/orderCat/');?>',
                    data: 'ids=' + order +'&_token=<?php echo csrf_token();?>',
                    type: 'post',
                    success: function() {
                        //
                    }
                });
            },
            items : ':not(.ignore ignore11)',
            
        });
        
    })
</script>

