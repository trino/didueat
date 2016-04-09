<div class="row  menuwrapper subber" style="padding: 0 !important; border:0 !important;"
     id="sub{{ (isset($child))? $child->id : 0 }}">
    <?php
    printfile("views/popups/additional.blade.php");
    $r1 = rand('1000000', '999999999');
    $r2 = rand('1000000', '999999999');
    $alts = array(
            "addmorebtn" => "Add more",
            "child_up" => "Move up",
            "child_down" => "Move down",
            "delete" => "Delete this item"
    );

    ?>

    <div class="">
        <div class=" card">

            <div class="card-header">
                <input class="form-control ctitle " type="text" placeholder="Addon (e.g. Pizza Toppings, Sides)"
                       value="{{ (isset($child->menu_item))? $child->menu_item : '' }}"/>

                <div class="clearfix"></div>
            </div>

            <div class="card-block">
                <div class="row">
                    <div class="form-group" style="display: none;">
                        <textarea class="form-control cdescription" style="display: none;"
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
                                    <div class="cmore m-b-1" id="cmore{{ $cc->id }}">

                                        <div class=" ">
                                            <div class="col-md-4">
                                                <input class="form-control cctitle" type="text" placeholder="Item"
                                                       value="{{ $cc->menu_item }}"/>
                                            </div>
                                            <div class="col-md-4">
                                                <input class="form-control ccprice pricechk margin-left-10"
                                                       type="number" placeholder="Optional Price"
                                                       value="{{ $cc->price }}" step="0.10" min="0"
                                                        /></div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="btn-group pull-right" role="group" aria-label="Basic example">
                                                <button href="javascript:void(0)" id="child_up_{{ $cc->id }}"
                                                        title="{{ $alts["child_up"] }}"
                                                        class="btn btn-sm btn-secondary sorting_child moveup"
                                                        <?php if($i == 1){?>disabled=""<?php }?>><i
                                                            class="fa fa-arrow-up"></i>
                                                </button>
                                                <button href="javascript:void(0)"
                                                        <?php if($i == count($more)){?>disabled=""
                                                        <?php }?> id="child_down_{{ $cc->id }}"
                                                        title="{{ $alts["child_down"] }}"
                                                        class="btn btn-sm btn-secondary sorting_child movedown"><i
                                                            class="fa fa-arrow-down"></i>
                                                </button>
                                                <button href="javascript:void(0);"
                                                        class="btn btn-sm btn-secondary delcmore"
                                                        title="{{ $alts["delete"] }}">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>
                                    </div>
                                    <?php
                                    }
                                    }
                                    ?>
                                @else

                                    <div class="cmore m-b-1">
                                        <div class="col-md-4  "><input class="form-control cctitle" type="text"
                                                                       placeholder="Item Name"/>
                                        </div>
                                        <div class="col-md-4   "><input class="form-control ccprice" type="number"
                                                                        step="0.10" min="0"
                                                                        placeholder="Optional Price"/></div>


                                        <div class="col-md-4">
                                            <div class="btn-group pull-right" role="group" aria-label="Basic example">
                                                <button href="javascript:void(0)" id="child_up_0"
                                                        title="{{ $alts["child_up"] }}"
                                                        class="btn btn-sm btn-secondary sorting_child moveup"
                                                        disabled=""><i class="fa fa-arrow-up"></i></button>
                                                <button href="javascript:void(0)" disabled="" id="child_down_0"
                                                        title="{{ $alts["child_down"] }}"
                                                        class="btn btn-sm btn-secondary sorting_child movedown"><i
                                                            class="fa fa-arrow-down"></i></button>
                                                <button href="javascript:void(0);"
                                                        class="btn btn-sm btn-secondary delcmore"
                                                        title="{{ $alts["delete"] }}">
                                                    <i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-12">
                                <a href="javascript:void(0);" class="m-t-1 btn btn-sm btn-success btn-small addmorebtn"
                                   title="{{ $alts["addmorebtn"] }}">Add More</a>
                            </div>
                            <div class="clearfix"></div>
                            <br class=""/>

                            <div class="radios col-md-12">
                                <div class="">
                                    <div class="">
                                        <div class=""><strong class="">These items are</strong></div>
                                        <div class="infolist">

                                            <label class="c-input c-radio"><input type="radio" value="1"
                                                                                  onclick="$(this).closest('.radios').find('.is_req').val(1);"
                                                                                  class="is_required" name="{{ $r1 }}"
                                                                                  @if(!isset($child->req_opt) || (isset($child->req_opt) && $child->req_opt == 1)) checked="checked" @endif>
                                                Required
                                                <span class="c-indicator"></span>
                                            </label>

                                            <label class="c-input c-radio"><input type="radio"
                                                                                  onclick="$(this).closest('.radios').find('.is_req').val(0);"
                                                                                  class="is_required" value="0"
                                                                                  name="{{ $r1 }}"
                                                                                  @if((isset($child->req_opt) && $child->req_opt == 0)) checked="checked" @endif>
                                                Optional
                                                <span class="c-indicator"></span>
                                            </label>
                                            <input type="hidden" class="is_req"
                                                   @if(!isset($child->req_opt) || (isset($child->req_opt) && $child->req_opt == 1))
                                                   value="1"
                                                   @else
                                                   value="0"
                                                    @endif
                                                    />
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>
                                    <br>

                                    <div>
                                        <div class=""><strong class="">Customer can select</strong></div>

                                        <div class="infolist">
                                            <LABEL class="c-input c-radio"><input type="radio"
                                                                                  onclick="$(this).closest('.radios').find('.is_mul').val(1);"
                                                                                  class="is_multiple" value="1"
                                                                                  name="{{ $r2 }}"
                                                                                  @if(!isset($child->sing_mul) || (isset($child->sing_mul) && $child->sing_mul == 1)) checked="checked" @endif>
                                                Single Item
                                                <span class="c-indicator"></span>
                                            </LABEL>

                                            <LABEL class="c-input c-radio"><input type="radio" value="0"
                                                                                  class="is_multiple mul_ch"
                                                                                  onclick="$(this).closest('.radios').find('.is_mul').val(0);"
                                                                                  name="{{ $r2 }}"
                                                                                  @if((isset($child->sing_mul) && $child->sing_mul == 0)) checked="checked" @endif>
                                                Multiple Items
                                                <span class="c-indicator"></span>
                                            </LABEL>

                                            <input type="hidden" class="is_mul"
                                                   @if(!isset($child->sing_mul) || (isset($child->sing_mul) && $child->sing_mul == 1))
                                                   value="1"
                                                   @else
                                                   value="0"
                                                    @endif
                                                    />
                                        </div>
                                    </div>
                                </div>
                                <br>

                                <div @if(!isset($child->sing_mul) || (isset($child->sing_mul) && $child->sing_mul == 1)) style="display: none;"
                                     @endif class="infolist exact">
                                    <div class="">

                                        <div class="">
                                            <strong class="">Enter # of items</strong>
                                        </div>
                                        <div class="multiplepart">
                                            <?php $r3 = rand('1000000', '999999999'); ?>
                                            <input type="hidden" class="up_t"
                                                   <?php if(!isset($child->exact_upto) || (isset($child->exact_upto) && $child->exact_upto == 0)){?> value="0"
                                                   <?php }elseif(isset($child->exact_upto) && $child->exact_upto == 2){?> value="2"
                                                   <?php }else{?> value="1"<?php }?> />

                                            <LABEL class="c-input c-radio">
                                                <input type="radio"
                                                       onclick="$(this).closest('.multiplepart').find('.up_t').val(0);$(this).closest('.multiplepart').find('.howmany').show();"
                                                       @if(!isset($child->exact_upto) || (isset($child->exact_upto) && $child->exact_upto == 0)) checked="checked"
                                                       @endif class="up_to up_to_selected" value="0"
                                                       name="{{ $r3 }}">
                                                Up to
                                                <span class="c-indicator"></span>
                                            </LABEL>

                                            <LABEL class="c-input c-radio">
                                                <input
                                                        type="radio"
                                                        onclick="$(this).closest('.multiplepart').parent().find('.up_t').val(1);$(this).closest('.multiplepart').find('.howmany').show();"
                                                        class="up_to"
                                                        value="1" name="{{ $r3 }}"
                                                        @if(isset($child->exact_upto) && $child->exact_upto == 1) checked="checked" @endif>
                                                Exactly
                                                <span class="c-indicator"></span>
                                            </LABEL>

                                            <LABEL class="c-input c-radio">
                                                <input
                                                        type="radio"
                                                        onclick="$(this).closest('.multiplepart').parent().find('.up_t').val(2);$(this).closest('.multiplepart').find('.howmany').hide();"
                                                        class="up_to"
                                                        value="1" name="{{ $r3 }}"
                                                        <?php if(isset($child->exact_upto) && $child->exact_upto == 2){$two = 1;?> checked="checked"<?php }else {
                                                    $two = 0;
                                                }?> />
                                                Unlimited
                                                <span class="c-indicator"></span>
                                            </LABEL>

                                            <div class="row">
                                                <div class=" col-md-4 howmany"
                                                     <?php if($two == 1){?>style="display:none;"<?php }?>>
                                                    <input placeholder="How many?" min="0" type="number"
                                                           id="itemno{{ $r3 }}"
                                                           class="itemno form-control"
                                                           value="{{ (isset($child->exact_upto_qty) && $child->exact_upto_qty)? $child->exact_upto_qty : '' }}">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class=" col-md-12">
                                <div class="newaction_wrap ">
                                    @if(!isset($cmodel) || (isset($ccount) && $ccount == $k))
                                        <?php
                                        if (!isset($menu_id)) {
                                            $menu_id = 0;
                                        }
                                        if (isset($_GET['menu_id'])) {
                                            $menu_id = $_GET['menu_id'];
                                        }
                                        ?>
                                    @endif
                                </div>

                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                </div>
            </div>


            <div class=" card-footer">
                <div class=" pull-right">
                    <?php if(isset($cmodel) && count($cmodel) > 1){ ?>
                    <button href="javascript:void(0)" class="btn btn-sm btn-secondary addon_sorting"
                            id="addon_up_{{ (isset($child)) ? $child->id : 0 }}" title="{{ $alts["child_up"] }}">
                        <i class="fa fa-arrow-up"></i>
                    </button>
                    <button href="javascript:void(0)" class="btn btn-sm btn-secondary addon_sorting"
                            id="addon_down_{{ (isset($child)) ? $child->id : 0 }}" title="{{ $alts["child_down"] }}">
                        <i class="fa fa-arrow-down"></i>
                    </button>
                    <?php } ?>
                    <button href="javascript:void(0)" class="btn btn-sm btn-secondary removelast pull-right" onclick="">
                        Delete Addon
                    </button>

                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>

