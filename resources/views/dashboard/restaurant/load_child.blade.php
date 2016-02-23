<?php printfile("views/dashboard/restaurant/load_child.blade.php"); ?>
@extends('layouts.blank')
@section('content')

@if($child)



    <?php
        $i = 0;
        foreach($child as $cc){
            $i++;
            ?>
            <div class="cmore ignore ignore1" id="cmore{{ $cc->id }}">

                    <div class="">
                        <div class="col-md-6 ">
                            <input class="form-control cctitle ignore ignore2 ignore1" type="text" placeholder="Item" value="{{ $cc->menu_item }}" />
                        </div>
                        <div class="col-md-2">
                            <input class="form-control ccprice ignore ignore2 ignore1 pricechk" type="text" placeholder="Price" value="{{ $cc->price }}" />
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2 ignore top-padd ignore2">
                        <a href="javascript:void(0);" class="btn btn-secondary-outline btn-sm" onclick="$(this).parent().parent().remove();">
                        <span class="fa fa-close ignore ignore2 ignore1"></span>
                    </a>
                    </div>
                    <div class="resturant-arrows col-md-2 col-sm-2 col-xs-12">
                        <a id="child_up_{{ $cc->id }}"  class="btn btn-sm btn-secondary sorting_child" href="javascript:void(0)">
                            <i class="fa fa-angle-up"></i>
                        </a>
                        <a id="child_down_{{ $cc->id }}" class="btn btn-sm btn-secondary sorting_child" href="javascript:void(0)">
                            <i class="fa fa-angle-down"></i>
                        </a>
                    </div>
                    <div class="clearfix ignore ignore2 ignore1"></div>
                
            </div>
        <?php } ?>



@endif
@stop