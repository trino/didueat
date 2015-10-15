<?php //$Manager->fileinclude(__FILE__); 
if(!$menu_id)
{
    
    ?>
    <style>.resturant-arrows{display:none;}</style>
    <?php
}
?>
<script src="{{ url('assets/global/scripts/additional.js') }}" class="ignore"></script>

<div class="newmenu ignore" id="newmenu0">
    
    <p>&nbsp;</p>
    <div class="col-md-6 col-sm-12 col-xs-12 ignore">
        <div class="col-sm-3 col-xs-12 nopadd ignore">
            <div class="menuimg ignore menuimg<?php echo $menu_id?>_1" <?php if(isset($model) && $model->image){?>style="min-height:0;"<?php }?>>
                <?php if(isset($model) && $model->image){?>
                    <img src="<?php echo url('assets/images/restaurants/'.$model->restaurant_id."/menus/".$model->id.'/thumb_'.$model->image) ?>" class="ignore" />
                <input type="hidden" class="hiddenimg ignore" value="<?php echo $model->image;?>" /><?php }?>
            </div>
            <br class="ignore" />
            <a href="javascript:void(0)" class="btn btn-success blue newbrowse ignore" id="newbrowse<?php echo $menu_id?>_1">Image</a>
        </div>

        <div class="col-sm-9 col-xs-12 lowheight ignore">
            <select class="cat_id">
                <option value="">Choose Category</option>
                <?php
                foreach($category as $cat)
                {
                    ?>
                    <option value="<?php echo $cat->id?>" <?php if(isset($model->cat_id) && $cat->id == $model->cat_id){?>selected="selected"<?php }?>><?php echo $cat->title;?></option>
                    <?php
                }
                ?>
            </select>
            <input class="form-control newtitle ignore" type="text" placeholder="Title" value="<?php if(isset($model->menu_item)){echo $model->menu_item; }?>" /><br class="ignore" />
            <input class="form-control newprice pricechk ignore" type="text" placeholder="$" value="<?php if(isset($model->price)){echo $model->price; }?>" /><br class="ignore" />
            <textarea class="form-control newdesc ignore" placeholder="Description"><?php if(isset($model->description)){echo $model->description; }?></textarea>
        </div> 
        <div class="clearfix ignore"></div>   
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 ignore">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 ignore">
            <?php if(!isset($ccount) || (isset($ccount) && $ccount==0)){ ?>
            <div class="newaction ignore">
                <a href="javascript:void(0)" class="btn btn-info add_additional ignore blue" id="add_additional<?php echo $menu_id;?>">Add Addons</a>
                <a href="javascript:void(0)" id="save0" data-id="<?php echo $menu_id;?>" class="btn btn-info blue savebtn ignore">Save</a>
            </div>
            
           
            
            <?php } ?>
        </div>
    </div>
    </div>
    <div class="clearfix ignore"></div> 
    
    <hr class=" ignore" />
    
    <div class="additional additional<?php echo $menu_id;?> ignore" style="<?php if(isset($cmodel)&& $cmodel){?>display:block;<?php }?>">
        <div class="col-md-12 ignore"><h2 class="ignore">Addons</h2></div>
        <div class="clearfix ignore"></div>
        <?php
        $k=0;
            if(isset($cmodel)){
                if (isset($_GET['menu_id'])) {
                        $menu_id = $_GET['menu_id'];
                    }
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
                ?>
                <script class="ignore ignore2 ignore1">
                        $(function () {
                            
                            $(".sorting_child").live('click',function(){
                           // alert('test');
                            var pid = $(this).attr('id').replace('child_up_','').replace('child_down_','');
                            if($(this).attr('id') == 'child_up_'+pid)
                            {
                                var sort = 'up';
                            }
                            else
                            var sort = 'down';
                            
                                var order = '';// array to hold the id of all the child li of the selected parent
                                $('#subcat<?php echo $menu_id?> .cmore').each(function (index) {
                                        var val = $(this).attr('id').replace('cmore', '');
                                        //var val=item[1];
                                        if (order == '') {
                                            order = val;
                                        } else {
                                            order = order + ',' + val;
                                        }
                                    });
                                $.ajax({
                                    url: '<?php echo url('restaurant/orderCat/');?>/'+pid+'/'+sort,
                                    data: 'ids=' + order +'&_token=<?php echo csrf_token();?>',
                                    type: 'post',
                                    success: function(res) {
                                        $('#addmore'+res).load('<?php echo url('restaurant/loadChild/');?>/'+res+'/0');
                                    }
                                });
                            
                        });
                        
                        
                        
                        
                        
                        
                        
                        
                        

                            
                        });
                    </script>
                <?php
            }
        ?>
    </div>
    <div class="clearfix ignore"></div>
</div>
<script>
$(function(){
    
    $(".addon_sorting").live('click',function(){
                           // alert('test');
                            var pid = $(this).attr('id').replace('addon_up_','').replace('addon_down_','');
                            if($(this).attr('id') == 'child_up_'+pid)
                            {
                                var sort = 'up';
                            }
                            else
                            var sort = 'down';
                            
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
                                    url: '<?php echo url('restaurant/orderCat/');?>/'+pid+'/'+sort,
                                    data: 'ids=' + order +'&_token=<?php echo csrf_token();?>',
                                    type: 'post',
                                    success: function(res) {
                                        $('#parent'+res).load(base_url+'restaurant/menu_form/'+res,function(){
                                            ajaxuploadbtn('newbrowse'+res+'_1');
                                          }); 
                                    }
                                });
                            
                        });
    
    
    
    
    
    
    
    
    
    
        
        
    })
</script>

