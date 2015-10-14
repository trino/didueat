@extends('layouts.blank')
@section('content')
<?php
if($child){
                    $i = 0;
                    foreach($child as $cc){
                    $i++;
                    ?>
                    <div class="cmore ignore ignore1" id="cmore<?php echo $cc->id;?>">
                        <?php if($i != 1){?>
                        <p style="margin-bottom:0;height:7px;" class="ignore ignore2 ignore1">&nbsp;</p>
                        <?php }?>
                        <div class="col-md-8 col-sm-10 col-xs-10 nopadd ignore ignore2 ignore1">
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
                         <div class="resturant-arrows col-md-2 col-sm-2 col-xs-12">
                                        <a href="javascript:void(0)" id="child_up_<?php echo $cc->id;?>" class="sorting_child"><i class="fa fa-angle-up"></i></a>
                                        <a href="javascript:void(0)" id="child_down_<?php echo $cc->id;?>" class="sorting_child"><i class="fa fa-angle-down"></i></a>
                                        </div>
                        <div class="clearfix ignore ignore2 ignore1"></div>
                    </div>
                    <?php
                    }
                    }
                    ?>
                    @stop