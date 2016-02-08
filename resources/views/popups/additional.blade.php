<div class="menuwrapper subber" id="sub{{ (isset($child))? $child->id : 0 }}">
    <?php
    printfile("views/popups/additional.blade.php");
    $r1 = rand('1000000', '999999999');
    $r2 = rand('1000000', '999999999');
    ?>


    <div class=" row">


        <div class="col-md-12 ">
            <input class="form-control ctitle " type="text" placeholder="Addon Name"
                   value="{{ (isset($child->menu_item))? $child->menu_item : '' }}"/>

            <textarea class="form-control cdescription "
                      placeholder="Description">{{ (isset($child->description))? $child->description : "" }}</textarea>
        </div>


        <div class="additionalitems  ">


            <div class="aitems ">

                <div class="addmore " id="addmore{{ (isset($child))? $child->id : 0 }}">
                    @if(isset($child->id))
                        <?php
                        $mod = new \App\Http\Controllers\RestaurantController();
                        $more = $mod->getMore($child->id);
                        if($more){
                        $i = 0;
                        foreach($more as $cc){
                        $i++;
                        ?>
                        <div class="cmore " id="cmore{{ $cc->id }}">

                            <div class=" ">
                                <div class="col-md-6 "><input class="form-control cctitle" type="text"
                                                              placeholder="Item" value="{{ $cc->menu_item }}"/></div>
                                <div class="col-md-2  "><input class="form-control ccprice pricechk margin-left-10"
                                                               type="text" placeholder="Price"
                                                               value="{{ $cc->price }}"/></div>
                            </div>
                            <div class="col-md-2">


                                <a href="javascript:void(0);" class="btn btn-secondary-outline btn-sm"
                                   onclick="$(this).parent().parent().remove();" style="">
                                    x</a>

                            </div>
                            <div class="col-md-2">

                                <div class="resturant-arrows">
                                    <a href="javascript:void(0)" id="child_up_{{ $cc->id }}"
                                       class="btn btn-xs btn-secondary sorting_child"><i class="fa fa-angle-up"></i></a>
                                    <a href="javascript:void(0)" id="child_down_{{ $cc->id }}"
                                       class="btn btn-xs btn-secondary sorting_child"><i
                                                class="fa fa-angle-down"></i></a>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                        <?php }
                        } ?>
                    @else
                        <div class="cmore">
                            <div class="col-md-6  "><input class="form-control cctitle" type="text" placeholder="Item"/>
                            </div>
                            <div class="col-md-4   "><input class="form-control ccprice" type="text"
                                                            placeholder="Additional Price"/></div>


                            <div class="col-md-2">
                                <a href="javascript:void(0);" class="pull-right btn btn-sm  btn-secondary-outline"
                                   onclick="$(this).parent().parent().remove();" style="">x</a>
                                <!--div class="resturant-arrows">
                                <a href="javascript:void(0)" id="child_up_{{ (isset($cc))? $cc->id : 0 }}" class="btn btn-sm btn-secondary sorting_child"><i class="fa fa-angle-up"></i></a>
                                <a href="javascript:void(0)" id="child_down_{{ (isset($cc))? $cc->id : 0 }}" class="btn btn-sm btn-secondary sorting_child"><i class="fa fa-angle-down"></i></a>
                            </div-->
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    @endif
                </div>

                <div class="col-md-12">
                    <a href="javascript:void(0);" class="btn btn-sm btn-success btn-small addmorebtn">Add More</a>
                </div>
                <div class="clearfix"></div>
                <br class=""/>

                <div class="radios col-md-12">
                    <div class="">
                        <div class="">
                            <div class=""><strong class="">These items are:</strong></div>
                            <div class="infolist">
                                <label><input type="radio" onclick="$(this).closest('.radios').find('.is_req').val(0);"
                                              class="is_required" value="0" name="{{ $r1 }}"
                                              @if(!isset($child->req_opt) || (isset($child->req_opt) && $child->req_opt == 0)) checked="checked" @endif>
                                    Optional</label>
                                &nbsp; OR &nbsp;
                                <label><input type="radio" value="1"
                                              onclick="$(this).closest('.radios').find('.is_req').val(1);"
                                              class="is_required" name="{{ $r1 }}"
                                              @if(isset($child->req_opt) && $child->req_opt == 1) checked="checked" @endif>
                                    Required</label>
                                <input type="hidden" class="is_req"
                                       @if(!isset($child->req_opt) || (isset($child->req_opt) && $child->req_opt == 0)) value="0"
                                       @else value="1" @endif />
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class=" padleft0">
                            <div class=" padleft0"><strong class="">Customer can select:</strong></div>

                            <div class="infolist">
                                <LABEL><input type="radio" onclick="$(this).closest('.radios').find('.is_mul').val(1);"
                                              class="is_multiple" value="1" name="{{ $r2 }}"
                                              @if(!isset($child->sing_mul) || (isset($child->sing_mul) && $child->sing_mul == 1)) checked="checked" @endif>
                                    Single Item</LABEL>
                                &nbsp; OR &nbsp;
                                <LABEL><input type="radio" value="0" class="is_multiple"
                                              onclick="$(this).closest('.radios').find('.is_mul').val(0);"
                                              name="{{ $r2 }}"
                                              @if((isset($child->sing_mul) && $child->sing_mul == 0)) checked="checked" @endif>
                                    Multiple Items</LABEL>
                                <input type="hidden" class="is_mul"
                                       @if(!isset($child->sing_mul) || (isset($child->sing_mul) && $child->sing_mul == 1)) value="1"
                                       @else value="0" @endif />
                            </div>
                        </div>
                    </div>

                    <div @if(!isset($child->sing_mul) || (isset($child->sing_mul) && $child->sing_mul == 1)) style="display: none;"
                         @endif class="infolist exact">

                        <div class="">

                            <div class=" ">
                                <strong class="">Enter # of items</strong>
                            </div>
                            <div class="">
                                <?php $r3 = rand('1000000', '999999999'); ?>
                                <input type="hidden" class="up_t"
                                       @if(!isset($child->exact_upto) || (isset($child->exact_upto) && $child->exact_upto == 0)) value="0"
                                       @else value="1" @endif />

                                    <input type="radio"
                                                                       onclick="$(this).parent().find('.up_t').val(0);"
                                                                       @if(!isset($child->exact_upto) || (isset($child->exact_upto) && $child->exact_upto == 0)) checked="checked"
                                                                       @endif class="up_to up_to_selected" value="0"
                                                                       name="{{ $r3 }}">

                                    Up to


                                    <input
                                        type="radio" onclick="$(this).parent().find('.up_t').val(1);" class="up_to"
                                        value="1" name="{{ $r3 }}"
                                        @if(isset($child->exact_upto) && $child->exact_upto == 1) checked="checked" @endif>
                                Exactly

                            <input placeholder="How many?" type="number" id="itemno{{ $r3 }}" class="itemno form-control col-md-4"
                                   value="{{ (isset($child->exact_upto_qty) && $child->exact_upto_qty)? $child->exact_upto_qty : '' }}">
                        </div>
                        </div>
                    </div>
                </div>
                <div class=" col-md-12">
                    <div class="newaction_wrap ">
                        @if(!isset($cmodel) || (isset($ccount) && $ccount == $k))
                            <?php if (!isset($menu_id)) {
                                $menu_id = 0;
                            }
                            if (isset($_GET['menu_id']))
                                $menu_id = $_GET['menu_id'];
                            ?>

                        @endif

                        <a href="javascript:void(0)" class="btn btn-sm btn-danger removelast" onclick="">Remove
                            Addon</a>
                    </div>
                    <?php
                    if(isset($cmodel) && count($cmodel) > 1)
                    {
                    ?>

                    <div class="resturant-arrows ">
                        <a href="javascript:void(0)" class="btn btn-sm btn-secondary addon_sorting"
                           id="addon_up_{{ (isset($child)) ? $child->id : 0 }}"><i class="fa fa-angle-up"></i></a>
                        <a href="javascript:void(0)" class="btn btn-sm btn-secondary addon_sorting"
                           id="addon_down_{{ (isset($child)) ? $child->id : 0 }}"><i class="fa fa-angle-down"></i></a>
                    </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="clearfix"></div>
            </div>


        </div>


    </div>


</div>
