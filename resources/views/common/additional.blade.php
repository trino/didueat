<?php //$Manager->fileinclude(__FILE__); ?>
    <div class="menuwrapper" id="sub<?php if(isset($child))echo $child->ID;else echo '0';?>">
    <div class="col-md-7 col-sm-7 col-xs-12">
        
        <div class="col-sm-12 lowheight row">
            <input class="form-control ctitle" type="text" placeholder="Title" value="<?php if(isset($child->menu_item)){echo $child->menu_item;}?>" /><br />
            <textarea class="form-control cdescription" placeholder="description"><?php if(isset($child->description)){echo $child->description;}?></textarea>    
        </div> 
        <div class="col-sm-12 additionalitems">
        <div class="aitems row">
            
            
            <div class="addmore">
            <?php
            if(isset($_GET['menu_id']))
            $menu_id = $_GET['menu_id'];
            if(isset($child->ID)){
                $mod  = new \App\Http\Controllers\RestaurantController;
                                $more = $mod->getMore($child->ID);
                                //var_dump($sub);
            //$more = $this->requestAction('menus/getMore/'.$child->ID);
            if($more)
            {
                $i=0;
                foreach($more as $cc)
                {
                    $i++;
                    ?>
                    <div class="cmore">
                    <?php if($i!=1){?>
                    	<p style="margin-bottom:0;height:7px;">&nbsp;</p>
                    <?php }?>
                        <div class="col-md-10 col-sm-10 col-xs-10 nopadd">
                        	<input class="form-control cctitle" type="text" placeholder="Item" value="<?php echo $cc->menu_item;?>" />
                        	<input class="form-control ccprice pricechk" type="text" placeholder="Price" value="<?php echo $cc->price;?>" style="margin-left:10px;" />  
                        </div>
                    <div class="col-md-2 col-sm-2 col-xs-2 no-padding" <?php if($i==1){?>style="display: none;"<?php }?>>
                        <a href="javascript:void(0);" class="btn btn-danger btn-small" onclick="$(this).parent().parent().remove();"><span class="fa fa-close"></span></a> 
                    </div>
                    <div class="clearfix"></div>
                    </div>
                    <?php
                }
            }
            }
            else
            {
                ?>
                
                <div class="cmore">
                <div class="col-md-10 col-sm-10 col-xs-10 nopadd">
                    <input class="form-control cctitle" type="text" placeholder="Item" />
                    <input class="form-control ccprice" type="text" placeholder="Price" style="margin-left:10px;" />   
                </div> 
                <div class="col-md-2 col-sm-2 col-xs-2 no-padding" style="display: none;">
                    <a href="javascript:void(0);" class="btn btn-danger btn-small"><span class="fa fa-close"></span></a>  
                </div>
                 
                <div class="clearfix"></div> 
                </div>
            <?php
            }
            ?>
            </div>
            
            <div class="col-md-12 col-sm-12 col-xs-12 nopadd">
                <br />
                <a href="javascript:void(0);" class="btn btn-success btn-small addmorebtn">Add more</a>  
            </div>
            <div class="clearfix"></div> 
            <br />
            <div class="radios">
                <strong>These items are:</strong>
                <div class="infolist">
                <?php
                        $r1 = rand('1000000','999999999');
                        ?>
                    <input type="radio" onclick="$(this).parent().find('.is_req').val(0);" class="is_required" value="0" name="<?php echo $r1;?>" <?php if(!isset($child->req_opt) || (isset($child->req_opt) && $child->req_opt==0)){?> checked="checked"<?php }?>> Optional&nbsp; &nbsp; OR&nbsp; &nbsp; <input type="radio" value="1" onclick="$(this).parent().find('.is_req').val(1);" class="is_required" name="<?php echo $r1;?>" <?php if(isset($child->req_opt) && $child->req_opt==1){?> checked="checked"<?php }?>> Required
                    <input type="hidden" class="is_req" <?php if(!isset($child->req_opt) || (isset($child->req_opt) && $child->req_opt==0)){?>value="0"<?php }else{?>value="1"<?php }?> />
                </div>
                <br />
                <strong>Customer can select:</strong>
                <div class="infolist">
                <?php
                        $r2 = rand('1000000','999999999');
                        ?>
                    <input type="radio" onclick="$(this).parent().find('.is_mul').val(1);" class="is_multiple" value="1" name="<?php echo $r2;?>" <?php if(!isset($child->sing_mul) || (isset($child->sing_mul) && $child->sing_mul==1)){?> checked="checked"<?php }?>> Single&nbsp; &nbsp; OR&nbsp; &nbsp; <input type="radio" value="0" class="is_multiple" onclick="$(this).parent().find('.is_mul').val(0);" name="<?php echo $r2;?>"  <?php if((isset($child->sing_mul) && $child->sing_mul==0)){?> checked="checked"<?php }?>> Multiple
                    <input type="hidden" class="is_mul" <?php if(!isset($child->sing_mul) || (isset($child->sing_mul) && $child->sing_mul==1)){?> value="1"<?php }else{?>value="0"<?php }?> />
                </div>    
                <div <?php if(!isset($child->sing_mul) || (isset($child->sing_mul) && $child->sing_mul==1)){?>style="display: none;"<?php }?> class="infolist exact">
                <br />
                    <div>
                        <div style="padding-left:0;" class="col-xs-12 col-sm-4"><strong>Enter # of items</strong></div>
                        <div class="col-xs-12 col-sm-8">
                        <?php
                        $r3 = rand('1000000','999999999');
                        ?>
                            <input type="hidden" class="up_t" <?php if(!isset($child->exact_upto) || (isset($child->exact_upto) && $child->exact_upto==0)){?> value="0"<?php }else{?>value="1"<?php }?> /><input type="radio" onclick="$(this).parent().find('.up_t').val(0);" <?php if(!isset($child->exact_upto) || (isset($child->exact_upto) && $child->exact_upto==0)){?> checked="checked"<?php }?> class="up_to up_to_selected" value="0" name="<?php echo $r3;?>"> Up to &nbsp; <input type="radio" onclick="$(this).parent().find('.up_t').val(1);" class="up_to" value="1" name="<?php echo $r3;?>" <?php if(isset($child->exact_upto) && $child->exact_upto==1){?> checked="checked"<?php }?>> Exactly</div><div style="clear:both;">
                            
                        </div>
                        <div class="clearfix"></div> 
                        
                    </div>
                    
                    
                    <input type="text" id="itemno<?php echo $r3;?>" class="itemno form-control" value="<?php if(isset($child->exact_upto_qty) && $child->exact_upto_qty)echo $child->exact_upto_qty;?>">
                </div>
    
            </div>
            
            <div class="clearfix"></div> 
        </div>
        </div>
        <div class="clearfix"></div>   
    </div>
    <div class="col-md-5 col-sm-5 col-xs-12">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="newaction">
                <?php if(!isset($cmodel) || (isset($ccount) && $ccount==$k)){ 
                    
                    if(!isset($menu_id))
                {
                    $menu_id = 0;
                }
                //echo $menu_id;?>
                    <a href="javascript:void(0)" class="btn btn-info add_additional" id="add_additional<?php echo $menu_id;?>">Add Addons</a> 
                    <a href="javascript:void(0)" <?php if(!isset($menu_id) || (isset($menu_id) && !$menu_id)){?>id="save0"<?php }else{?>id="save<?php echo $menu_id;}?>" class="btn btn-info savebtn">Save</a> 
                    <?php if(isset($k) && $k!=1){?><a href="javascript:void(0)" class="btn btn-danger removelast" onclick="">Remove</a><?php }?>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>  
    
    
    </div>
    
