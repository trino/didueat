<?php printfile("views/dashboard/restaurant/load_addon.blade.php"); ?>
@extends('layouts.blank')
@section('content')

@if($child)
    <?php
        $i = 0;
        $alts = array(
                "remove" => "Remove this item",
                "sort_up" => "Sort ascending",
                "sort_down" => "Sort descending"
        );
        foreach($child as $cc){
            $i++;
            ?>
            <div class="cmore ignore ignore1" id="cmore{{ $cc->id }}">
                @if($i != 1)
                    <p class="addon_ignore ignore ignore2 ignore1">&nbsp;</p>
                @endif
                <div class="col-md-8 col-sm-10 col-xs-10 ignore ignore2 ignore1">
                    <input class="form-control cctitle ignore ignore2 ignore1" type="text" placeholder="Item" value="{{ $cc->menu_item }}"/>
                    <input class="form-control ccprice ignore ignore2 ignore1 pricechk" type="text" placeholder="Price" value="{{ $cc->price }}" />
                </div>
                <div class="col-md-2 col-sm-2 col-xs-2 ignore no-padding ignore2" <?php if($i == 1){?>style="display: none;"<?php } ?>>
                    <a href="javascript:void(0);" class="btn ignore btn-danger btn-small ignore2" onclick="$(this).parent().parent().remove();" title="{{ $alts["remove"] }}">
                        <span class="fa fa-close ignore ignore2 ignore1"></span>
                    </a>
                </div>
                <div class="resturant-arrows col-md-2 col-sm-2 col-xs-12">
                    <a href="javascript:void(0)" id="child_up_{{ $cc->id }}" class="sorting_child"><i class="fa fa-angle-up" title="{{ $alts["sort_up"] }}"></i></a>
                    <a href="javascript:void(0)" id="child_down_{{ $cc->id }}" class="sorting_child"><i class="fa fa-angle-down" title="{{ $alts["sort_down"] }}"></i></a>
                </div>
                <div class="clearfix ignore ignore2 ignore1"></div>
            </div>
        <?php } ?>
@endif

@stop