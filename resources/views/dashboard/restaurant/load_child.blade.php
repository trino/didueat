<?php printfile("views/dashboard/restaurant/load_child.blade.php"); ?>
@extends('layouts.blank')
@section('content')

@if($child)
    <?php
        $i = 0;
        $alts = array(
                "child_up" => "Move up",
                "child_down" => "Move down",
                "delete" => "Delete"
        );
        foreach($child as $cc){
            $i++;
            ?>
            <div class="cmore ignore ignore1 m-b-1" id="cmore{{ $cc->id }}">
                <div class="">
                    <div class="col-md-5 ">
                        <input class="form-control cctitle ignore ignore2 ignore1" type="text" placeholder="Item" value="{{ $cc->menu_item }}" />
                    </div>
                    <div class="col-md-3">
                        <input class="form-control ccprice ignore ignore2 ignore1 pricechk" type="text" placeholder="Price" value="{{ $cc->price }}" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="btn-group pull-right" role="group" aria-label="Basic example">
                        <button href="javascript:void(0)" id="child_up_{{ $cc->id }}" class="btn btn-sm btn-secondary sorting_child" title="{{ $alts["child_up"] }}"><i class="fa fa-arrow-up"></i></button>
                        <button href="javascript:void(0)" id="child_down_{{ $cc->id }}" class="btn btn-sm btn-secondary sorting_child" title="{{ $alts["child_down"] }}"><i class="fa fa-arrow-down"></i></button>
                        <button href="javascript:void(0);" class="btn btn-sm btn-secondary" onclick="$(this).closest('.cmore').remove();" title="{{ $alts["delete"] }}"><i class="fa fa-times"></i> </button>
                    </div>
                </div>
                <div class="clearfix ignore ignore2 ignore1"></div>
            </div>
        <?php } ?>
@endif
@stop