<?php //$Manager->fileinclude(__FILE__); ?>
<script src="<?php echo $this->request->webroot;?>scripts/additional.js"></script>

<div class="newmenu" id="newmenu0">
    
    <p>&nbsp;</p>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="col-sm-5 col-xs-12 nopadd">
            <div class="menuimg menuimg<?php echo $menu_id?>_1" <?php if(isset($model) && $model->image){?>style="min-height:0;"<?php }?>><?php if(isset($model) && $model->image){?><img src="<?php echo $this->request->webroot;?>img/products/<?php echo $model->image;?>" /><input type="hidden" class="hiddenimg" value="<?php echo $model->image;?>" /><?php }?></div>
            <br />
            <a href="javascript:void(0)" class="btn btn-success newbrowse" id="newbrowse<?php echo $menu_id?>_1">Image</a>
        </div>
        <div class="col-sm-7 col-xs-12 lowheight">
            <input class="form-control newtitle" type="text" placeholder="Title" value="<?php if(isset($model->menu_item)){echo $model->menu_item; }?>" /><br />
            <input class="form-control newprice" type="text" placeholder="$" value="<?php if(isset($model->price)){echo $model->price; }?>" /><br />
            <textarea class="form-control newdesc" placeholder="Description"><?php if(isset($model->description)){echo $model->description; }?></textarea>
        </div> 
        <div class="clearfix"></div>   
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <?php if(!isset($ccount) || (isset($ccount) && $ccount==0)){ ?>
            <div class="newaction">
                <a href="javascript:void(0)" class="btn btn-info add_additional" id="add_additional<?php echo $menu_id;?>">Add Addons</a>
                <a href="javascript:void(0)" id="save0" data-id="<?php echo $menu_id;?>" class="btn btn-info savebtn">Save</a>
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="clearfix"></div> 
    
    <hr />
    
    <div class="additional additional<?php echo $menu_id;?>" style="<?php if(isset($cmodel)&& $cmodel){?>display:block;<?php }?>">
        <div class="col-md-12"><h2>Addons</h2></div>
        <div class="clearfix"></div>
        <?php
            if(isset($cmodel)){
                $k=0;
                foreach($cmodel as $child){
                    $k++;
                    include('common/additional.php');
                }
            }
        ?>
    </div>
    <div class="clearfix"></div>
</div>

