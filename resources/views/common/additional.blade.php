<div class="menuwrapper" id="sub<?php if (isset($child)) echo $child->id; else echo '0';?>" class="ignore ignore1">
    <div class="col-md-12 col-sm-12 col-xs-12 ignore ignore1">

        <div class="col-sm-12 lowheight row ignore ignore1">
            <input class="form-control ctitle ignore ignore1" type="text" placeholder="Title"
                   value="<?php if (isset($child->menu_item)) {
                       echo $child->menu_item;
                   }?>"/>
            <br class="ignore"/>

            <textarea class="form-control cdescription ignore ignore1"
                      placeholder="description"><?php if (isset($child->description)) {
                    echo $child->description;
                }?>
            </textarea>

        </div>
        <div class="col-sm-12 additionalitems ignore ignore1">
            <div class="aitems row ignore ignore1">

                <div class="addmore ignore ignore1"
                     id="addmore<?php if (isset($child)) echo $child->id; else echo '0';?>">
                    <?php
                    if (isset($_GET['menu_id'])) {
                        $menu_id = $_GET['menu_id'];
                    }
                    if(isset($child->id)){
                    $mod = new \App\Http\Controllers\RestaurantController;
                    $more = $mod->getMore($child->id);
                    //var_dump($sub);
                    //$more = $this->requestAction('menus/getMore/'.$child->id);
                    if($more){
                    $i = 0;
                    foreach($more as $cc){
                    $i++;
                    ?>
                    <div class="cmore ignore ignore1" id="cmore<?php echo $cc->id;?>">
                        <?php if($i != 1){?>
                        <p style="margin-bottom:0;height:7px;" class="ignore ignore2 ignore1">&nbsp;</p>
                        <?php }?>
                        <div class="col-md-10 col-sm-10 col-xs-10 nopadd ignore ignore2 ignore1">
                            <input class="form-control cctitle ignore ignore2 ignore1" type="text" placeholder="Item"
                                   value="<?php echo $cc->menu_item;?>"/>
                            <input class="form-control ccprice ignore ignore2 ignore1 pricechk" type="text"
                                   placeholder="Price" value="<?php echo $cc->price;?>" style="margin-left:10px;"/>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2 ignore no-padding ignore2"
                             <?php if($i == 1){?>style="display: none;"<?php }?>>
                            <a href="javascript:void(0);" class="btn ignore btn-danger btn-small ignore2"
                               onclick="$(this).parent().parent().remove();"><span
                                        class="fa fa-close ignore ignore2 ignore1"></span></a>
                        </div>
                         <div class="resturant-arrows col-md-3 col-sm-3 col-xs-12">
                                        <a href=""><i class="fa fa-angle-up"></i></a>
                                        <a href=""><i class="fa fa-angle-down"></i></a>
                                        </div>
                        <div class="clearfix ignore ignore2 ignore1"></div>
                    </div>
                    <?php
                    }
                    }
                    }
                        else {
                    ?>
                    <div class="cmore ignore ignore2 ignore1">
                        <div class="col-md-8 col-sm-8 col-xs-8 nopadd ignore ignore2 ignore1">
                            <input class="form-control cctitle ignore ignore2 ignore1" type="text" placeholder="Item"/>
                            <input class="form-control ccprice ignore ignore2 ignore1" type="text" placeholder="Price"
                                   style="margin-left:10px;"/>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2 no-padding ignore ignore2 ignore1"
                             style="display: none;">
                            <a href="javascript:void(0);" class="btn btn-danger btn-small ignore ignore2 ignore1"><span
                                        class="fa fa-close ignore"></span></a>
                        </div>
                             <div class="resturant-arrows col-md-2 col-sm-2 col-xs-2">
                                        <a href=""><i class="fa fa-angle-up"></i></a>
                                        <a href=""><i class="fa fa-angle-down"></i></a>
                                        </div>
                        <div class="clearfix ignore ignore2 ignore1"></div>
                    </div>
                    <?php
                    }
                    ?>
                    <script class="ignore ignore2 ignore1">
                        $(function () {

                            $('#addmore<?php if(isset($child))echo $child->id;else echo '0';?>').sortable({
                                update: function (event, ui) {
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
                                        url: '<?php echo url('restaurant/orderCat/');?>',
                                        data: 'ids=' + order + '&_token=<?php echo csrf_token();?>',
                                        type: 'post',
                                        success: function () {
                                            //
                                        }
                                    });
                                },
                                items: ':not(.ignore2)',

                            });
                        });
                    </script>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12 nopadd ignore ignore2 ignore1">
                    <br/>
                    <a href="javascript:void(0);" class="btn btn-success btn-small addmorebtn ignore ignore2 ignore1">Add
                        more</a>
                </div>
                <div class="clearfix ignore ignore2 ignore1"></div>
                <br class="ignore ignore2 ignore1"/>

                <div class="radios ignore ignore2 ignore1">
                    <strong class="ignore ignore2 ignore1">These items are:</strong>

                    <div class="infolist ignore ignore2 ignore1">
                        <?php
                        $r1 = rand('1000000', '999999999');
                        ?>
                        <input type="radio" onclick="$(this).parent().find('.is_req').val(0);"
                               class="is_required ignore ignore2 ignore1" value="0" name="<?php echo $r1;?>"
                               <?php if(!isset($child->req_opt) || (isset($child->req_opt) && $child->req_opt == 0)){?> checked="checked"<?php }?>>
                        Optional&nbsp; &nbsp; OR&nbsp; &nbsp; <input type="radio" value="1"
                                                                     onclick="$(this).parent().find('.is_req').val(1);"
                                                                     class="is_required ignore" name="<?php echo $r1;?>"
                                                                     <?php if(isset($child->req_opt) && $child->req_opt == 1){?> checked="checked"<?php }?>>
                        Required
                        <input type="hidden" class="is_req ignore ignore2 ignore1"
                               <?php if(!isset($child->req_opt) || (isset($child->req_opt) && $child->req_opt == 0)){?>value="0"
                               <?php }else{?>value="1"<?php }?> />
                    </div>
                    <br class="ignore ignore2 ignore1"/>
                    <strong class="ignore ignore2 ignore1">Customer can select:</strong>

                    <div class="infolist ignore2 ignore1 ignore">
                        <?php
                        $r2 = rand('1000000', '999999999');
                        ?>
                        <input type="radio" onclick="$(this).parent().find('.is_mul').val(1);"
                               class="is_multiple ignore ignore2 ignore1" value="1" name="<?php echo $r2;?>"
                               <?php if(!isset($child->sing_mul) || (isset($child->sing_mul) && $child->sing_mul == 1)){?> checked="checked"<?php }?>>
                        Single&nbsp; &nbsp; OR&nbsp; &nbsp; <input type="radio" value="0"
                                                                   class="is_multiple ignore ignore2 ignore1"
                                                                   onclick="$(this).parent().find('.is_mul').val(0);"
                                                                   name="<?php echo $r2;?>"
                                                                   <?php if((isset($child->sing_mul) && $child->sing_mul == 0)){?> checked="checked"<?php }?>>
                        Multiple
                        <input type="hidden" class="is_mul ignore ignore2 ignore1"
                               <?php if(!isset($child->sing_mul) || (isset($child->sing_mul) && $child->sing_mul == 1)){?> value="1"
                               <?php }else{?>value="0"<?php }?> />
                    </div>
                    <div <?php if(!isset($child->sing_mul) || (isset($child->sing_mul) && $child->sing_mul == 1)){?>style="display: none;"
                         <?php }?> class="infolist exact ignore ignore2 ignore1">
                        <br/>

                        <div class="ignore ignore2 ignore1">
                            <div style="padding-left:0;" class="col-xs-12 col-sm-4 ignore ignore2 ignore1"><strong
                                        class="ignore ignore2 ignore1">Enter # of items</strong></div>
                            <div class="col-xs-12 col-sm-8 ignore ignore2 ignore1">
                                <?php
                                $r3 = rand('1000000', '999999999');
                                ?>
                                <input type="hidden" class="up_t ignore ignore2 ignore1"
                                       <?php if(!isset($child->exact_upto) || (isset($child->exact_upto) && $child->exact_upto == 0)){?> value="0"
                                       <?php }else{?>value="1"<?php }?> /><input type="radio"
                                                                                 onclick="$(this).parent().find('.up_t').val(0);"
                                                                                 <?php if(!isset($child->exact_upto) || (isset($child->exact_upto) && $child->exact_upto == 0)){?> checked="checked"
                                                                                 <?php }?> class="up_to up_to_selected ignore ignore2 ignore1"
                                                                                 value="0" name="<?php echo $r3;?>"> Up
                                to &nbsp; <input type="radio" onclick="$(this).parent().find('.up_t').val(1);"
                                                 class="up_to ignore ignore2 ignore1" value="1" name="<?php echo $r3;?>"
                                                 <?php if(isset($child->exact_upto) && $child->exact_upto == 1){?> checked="checked"<?php }?>>
                                Exactly
                            </div>
                            <div style="clear:both;" class="ignore ignore2 ignore1">

                            </div>
                            <div class="clearfix ignore ignore2 ignore1"></div>

                        </div>


                        <input type="text" id="itemno<?php echo $r3;?>"
                               class="itemno form-control ignore ignore2 ignore1"
                               value="<?php if (isset($child->exact_upto_qty) && $child->exact_upto_qty) echo $child->exact_upto_qty;?>">
                    </div>

                </div>

                <div class="clearfix ignore ignore2 ignore1"></div>
            </div>
        </div>
        <div class="clearfix ignore ignore2 ignore1"></div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 ignore ignore2 ignore1">
        <div class="col-md-12 col-sm-12 col-xs-12 ignore ignore2 ignore1">
            <div class="newaction ignore ignore2 ignore1">
                <div class="newaction_wrap col-md-9 col-sm-9 col-xs-12"><?php if(!isset($cmodel) || (isset($ccount) && $ccount == $k)){
                if (!isset($menu_id)) {
                    $menu_id = 0;
                }
                ?>
                <a href="javascript:void(0)" class="btn btn-info add_additional ignore ignore2 ignore1"
                   id="add_additional<?= $menu_id;?>">Add Addons</a>
                <a href="javascript:void(0)" <?php if (!isset($menu_id) || (isset($menu_id) && !$menu_id)) {
                    echo 'id="save0"';
                } else {
                    echo 'id="save' . $menu_id . '"';
                } ?> class="btn btn-info savebtn ignore ignore2 ignore1">Save</a>
                <?php if (isset($k) && $k != 1) {
                    echo '<a href="javascript:void(0)" class="btn btn-danger removelast ignore ignore2 ignore1" onclick="">Remove</a>';
                }
                } ?>
                </div>
                 <div class="resturant-arrows col-md-3 col-sm-3 col-xs-12">
                                        <a href=""><i class="fa fa-angle-up"></i></a>
                                        <a href=""><i class="fa fa-angle-down"></i></a>
                                        </div>
            </div>
        </div>
    </div>
    <div class="clearfix ignore ignore2 ignore1"></div>

</div>