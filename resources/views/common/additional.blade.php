<div class="menuwrapper" id="sub{{ (isset($child))? $child->id : 0 }}" class="ignore ignore1">
    <?php
        printfile("views/common/additional.blade.php");
        $r1 = rand('1000000', '999999999');
        $r2 = rand('1000000', '999999999');
    ?>
    <div class="col-md-12 col-sm-12 col-xs-12 ignore ignore1">
        <div class="col-sm-12 lowheight row ignore ignore1">
            <input class="form-control ctitle ignore ignore1" type="text" placeholder="Title" value="{{ (isset($child->menu_item))? $child->menu_item : '' }}"/>
            <br class="ignore"/>
            <textarea class="form-control cdescription ignore ignore1" placeholder="description">{{ (isset($child->description))? $child->description : "" }}</textarea>
        </div>
        <div class="col-sm-12 additionalitems ignore ignore1">
            <div class="aitems row ignore ignore1">
                <div class="addmore ignore ignore1" id="addmore{{ (isset($child))? $child->id : 0 }}">
                    @if(isset($child->id))
                    <?php
                        $mod = new \App\Http\Controllers\RestaurantController();
                        $more = $mod->getMore($child->id);
                        if($more){
                            $i = 0;
                            foreach($more as $cc){
                                $i++;
                                ?>
                                <div class="cmore ignore ignore1" id="cmore{{ $cc->id }}">
                                    @if($i != 1)
                                        <p class="addon_ignore ignore ignore2 ignore1">&nbsp;</p>
                                    @endif
                                    <div class="col-md-8 col-sm-10 col-xs-10 nopadd ignore ignore2 ignore1">
                                        <div class="col-md-6 padding-left-0"><input class="form-control cctitle ignore ignore2 ignore1" type="text" placeholder="Item" value="{{ $cc->menu_item }}"/></div>
                                        <div class="col-md-6 padding-left-0"><input class="form-control ccprice ignore ignore2 ignore1 pricechk margin-left-10" type="text" placeholder="Price" value="{{ $cc->price }}" /></div>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-2 ignore top-padd ignore2">
                                        <a href="javascript:void(0);" class="btn ignore btn-danger btn-sm ignore2" onclick="$(this).parent().parent().remove();"><span class="fa fa-close ignore ignore2 ignore1"></span></a>
                                    </div>
                                    <div class="resturant-arrows col-md-2 col-sm-2 col-xs-12">
                                        <a href="javascript:void(0)" id="child_up_{{ $cc->id }}" class="btn btn-sm btn-secondary sorting_child"><i class="fa fa-angle-up"></i></a>
                                        <a href="javascript:void(0)" id="child_down_{{ $cc->id }}" class="btn btn-sm btn-secondary sorting_child"><i class="fa fa-angle-down"></i></a>
                                    </div>
                                    <div class="clearfix ignore ignore2 ignore1"></div>
                                </div>
                                <?php }
                        } ?>
                    @else
                    <div class="cmore ignore ignore2 ignore1">
                        <div class="col-md-8 col-sm-8 col-xs-8 nopadd ignore ignore2 ignore1">
                            <div class="col-md-6 padding-left-0"><input class="form-control cctitle ignore ignore2 ignore1" type="text" placeholder="Item"/></div>
                            <div class="col-md-6 padding-left-0"><input class="form-control ccprice ignore ignore2 ignore1 margin-left-10" type="text" placeholder="Price" /></div>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2 no-padding ignore ignore2 ignore1" style="display: none;">
                            <a href="javascript:void(0);" class="btn btn-sm btn-danger btn-small ignore ignore2 ignore1"><span class="fa fa-close ignore"></span></a>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2 ignore top-padd ignore2">
                            <a href="javascript:void(0);" class="btn btn-sm ignore btn-danger btn-small ignore2" onclick="$(this).parent().parent().remove();"><span class="fa fa-close ignore ignore2 ignore1"></span></a>
                        </div>
                        <div class="resturant-arrows col-md-2 col-sm-2 col-xs-2">
                            <a href="javascript:void(0)" id="child_up_{{ (isset($cc))? $cc->id : 0 }}" class="btn btn-sm btn-secondary sorting_child"><i class="fa fa-angle-up"></i></a>
                            <a href="javascript:void(0)" id="child_down_{{ (isset($cc))? $cc->id : 0 }}" class="btn btn-sm btn-secondary sorting_child"><i class="fa fa-angle-down"></i></a>
                        </div>
                        <div class="clearfix ignore ignore2 ignore1"></div>
                    </div>
                    @endif
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12 nopadd ignore ignore2 ignore1 padding-left-0">
                    <br/> <a href="javascript:void(0);" class="btn btn-sm btn-success btn-small addmorebtn ignore ignore2 ignore1">Add more</a>
                </div>
                <div class="clearfix ignore ignore2 ignore1"></div>
                <br class="ignore ignore2 ignore1"/>

                <div class="radios ignore ignore2 ignore1">
                    <div class="form-group">
                        <div class="col-md-6 padding-left-0">
                            <strong class="ignore ignore2 ignore1">These items are:</strong>
                            <div class="infolist ignore ignore2 ignore1">
                                <label><input type="radio" onclick="$(this).closest('.radios').find('.is_req').val(0);" class="is_required ignore ignore2 ignore1" value="0" name="{{ $r1 }}" @if(!isset($child->req_opt) || (isset($child->req_opt) && $child->req_opt == 0)) checked="checked" @endif> Optional</label>
                                    &nbsp; &nbsp; OR&nbsp; &nbsp;
                                <label><input type="radio" value="1" onclick="$(this).closest('.radios').find('.is_req').val(1);" class="is_required ignore" name="{{ $r1 }}" @if(isset($child->req_opt) && $child->req_opt == 1) checked="checked" @endif> Required</label>
                                <input type="hidden" class="is_req ignore ignore2 ignore1" @if(!isset($child->req_opt) || (isset($child->req_opt) && $child->req_opt == 0)) value="0" @else value="1" @endif />
                            </div>
                         </div>
                         <div class="col-md-6 padding-left-0">
                            <strong class="ignore ignore2 ignore1">Customer can select:</strong>
        
                            <div class="infolist ignore2 ignore1 ignore">
                                <LABEL><input type="radio" onclick="$(this).closest('.radios').find('.is_mul').val(1);" class="is_multiple ignore ignore2 ignore1" value="1" name="{{ $r2 }}" @if(!isset($child->sing_mul) || (isset($child->sing_mul) && $child->sing_mul == 1)) checked="checked" @endif> Single</LABEL>
                                    &nbsp; &nbsp; OR&nbsp; &nbsp;
                                <LABEL><input type="radio" value="0" class="is_multiple ignore ignore2 ignore1" onclick="$(this).closest('.radios').find('.is_mul').val(0);" name="{{ $r2 }}" @if((isset($child->sing_mul) && $child->sing_mul == 0)) checked="checked" @endif> Multiple</LABEL>
                                <input type="hidden" class="is_mul ignore ignore2 ignore1" @if(!isset($child->sing_mul) || (isset($child->sing_mul) && $child->sing_mul == 1)) value="1" @else value="0" @endif />
                            </div>
                         </div>
                     </div>
                    <div @if(!isset($child->sing_mul) || (isset($child->sing_mul) && $child->sing_mul == 1)) style="display: none;" @endif class="infolist exact ignore ignore2 ignore1">
                        <br/>
                        <div class="ignore ignore2 ignore1">
                        <br/><br/>
                            <div class="col-xs-12 col-sm-12 ignore ignore2 ignore1 padding-left-0">
                                <strong class="ignore ignore2 ignore1">Enter # of items</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 ignore ignore2 ignore1 padding-left-0">
                                <?php $r3 = rand('1000000', '999999999'); ?>
                                <input type="hidden" class="up_t ignore ignore2 ignore1" @if(!isset($child->exact_upto) || (isset($child->exact_upto) && $child->exact_upto == 0)) value="0" @else value="1" @endif /><input type="radio" onclick="$(this).parent().find('.up_t').val(0);" @if(!isset($child->exact_upto) || (isset($child->exact_upto) && $child->exact_upto == 0)) checked="checked" @endif class="up_to up_to_selected ignore ignore2 ignore1" value="0" name="{{ $r3 }}"> Up to &nbsp; <input type="radio" onclick="$(this).parent().find('.up_t').val(1);" class="up_to ignore ignore2 ignore1" value="1" name="{{ $r3 }}" @if(isset($child->exact_upto) && $child->exact_upto == 1) checked="checked" @endif> Exactly
                            </div>
                            <div class="ignore ignore2 ignore1 clearfix">
                            </div>
                            <div class="clearfix ignore ignore2 ignore1"></div>
                        </div>

                        <input type="number" id="itemno{{ $r3 }}" class="itemno form-control ignore ignore2 ignore1" value="{{ (isset($child->exact_upto_qty) && $child->exact_upto_qty)? $child->exact_upto_qty : '' }}">
                    </div>
                </div>

                <div class="clearfix ignore ignore2 ignore1"></div>
            </div>
        </div>
        <div class="clearfix ignore ignore2 ignore1"></div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 ignore ignore2 ignore1 padding-left-0">
        <div class="col-md-12 col-sm-12 col-xs-12 ignore ignore2 ignore1">
            <div class="newaction ignore ignore2 ignore1">
                <div class="newaction_wrap col-md-9 col-sm-9 col-xs-12 padding-left-0">
                    @if(!isset($cmodel) || (isset($ccount) && $ccount == $k))
                    <?php if (!isset($menu_id)) { $menu_id = 0; }
                    if(isset($_GET['menu_id']))
                    $menu_id = $_GET['menu_id'];
                     ?>
                        <a href="javascript:void(0)" class="btn btn-sm red btn-info add_additional ignore ignore2 ignore1" id="add_additional{{ $menu_id }}">Add Addons</a>
                        <a href="javascript:void(0)" @if(!isset($menu_id) || (isset($menu_id) && !$menu_id)) id="save0" @else id="save{{ $menu_id }}" @endif class="btn btn-sm red btn-info savebtn ignore ignore2 ignore1">Save</a>
                    @endif
                    <br /><br />
                    <a href="javascript:void(0)" class="btn btn-sm red btn-danger removelast ignore ignore2 ignore1" onclick="">Remove</a>
                </div>
                <div class="resturant-arrows col-md-3 col-sm-3 col-xs-12">
                    <a href="javascript:void(0)" class="btn btn-sm btn-secondary addon_sorting" id="addon_up_{{ (isset($child)) ? $child->id : 0 }}"><i class="fa fa-angle-up"></i></a>
                    <a href="javascript:void(0)" class="btn btn-sm btn-secondary addon_sorting" id="addon_down_{{ (isset($child)) ? $child->id : 0 }}"><i class="fa fa-angle-down"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix ignore ignore2 ignore1"></div>
</div>