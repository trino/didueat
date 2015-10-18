@extends('layouts.default')
@section('content')


    <div class="content-page">
        <div class="row">


                @include('layouts.includes.leftsidebar')





            <div class="col-xs-12 col-sm-8 col-md-10 menu_managers_edits">
                <div class="btn_wrapper margin-bottom-20 clearfix">
                <a class="btn btn-primary red add_item pull-right" id="add_item0" href="javascript:void(0)">Add Menu Item</a>
                </div>
            <div class="">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i> MENU MANAGER
                    </div>
                </div>
                <div class="portlet-body form">




                    <div class="form-body">



                @if(\Session::has('message'))
                        <div class="alert {!! Session::get('message-type') !!}">
                            <strong>{!! Session::get('message-short') !!}</strong> &nbsp; {!! Session::get('message') !!}
                        </div>
                    @endif

                    <div class="dashboard">
                        <div class="menu-manager">



                            <div class="addnew" style="display: none;"></div>




                            <ul class="parentinfo" id="sortable" style="padding-left: 0;">
                                @foreach($menus_list as $value)

                                <li class="infolistwhite marbot newmenus no-margin" id="parent{{ $value->id }}" style="">
                                    <div class="col-md-4 menu_item col-sm-4 col-xs-12 ignore">
                                    <div class="row">
                                        <div class="col-sm-1 col-xs-12 ignore" style="padding: 0;">
                                            
                                             @if(!empty($value->image))
                                                    <img class="itemimg4 itemimg ignore" alt=""
                                                         src="{{ url('assets/images/restaurants/'.$value->restaurant_id.'/menus/'.$value->id.'/thumb_'.$value->image) }}">
                                                @else
                                                    <img class="itemimg4 itemimg ignore" alt="" src="{{ url('assets/images/default.png') }}">
                                                @endif
                                            <!--
<img class="itemimg4 itemimg ignore" src="{{ asset('assets/images/products') }}/<?php echo ($value->image) ? $value->image : 'default.jpg'; ?>" />
-->
                                        </div>
                                        <div class="col-sm-8 col-xs-12 ignore">
                                            <h4 class="ignore">{{ $value->menu_item }}</h4>
                                        </div>
                                        <div class="clearfix ignore"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-sm-8 col-xs-12 ignore" style="padding-right: 0px;">
                                    <div class="row">
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <a href="javascript:void(0)" id="add_item{{ $value->id }}" class="btn ignore btn-success green add_item">Edit Item</a>
                                        <a href="<?php echo url();?>/restaurant/deleteMenu/<?php echo $value->id;?>" onclick="return confirm('Are you sure you want to delete this item?');" id="deleteitem{{ $value->id }}" class="deletecat btn red ignore">Delete</a>
                                        <div style="clear: both;" class="ignore"></div>
                                        </div>
                                        <div class="resturant-arrows col-md-3 col-sm-3 col-xs-12">
                                        <a href="javascript:void(0);" id="up_parent_<?php echo $value->id;?>" class="sorting_parent"><i class="fa fa-angle-up"></i></a>
                                        <a href="javascript:void(0);" id="down_parent_<?php echo $value->id;?>" class="sorting_parent"><i class="fa fa-angle-down"></i></a>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="clearfix ignore"></div>
                                </li>
                                @endforeach
                            </ul>



                        </div>

                    </div>

                </div>

            </div>
            </div>
            </div>
            </div>
            </div>





<script type="text/javascript" src="{{ asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}"></script>
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ asset('assets/global/scripts/metronic.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/scripts/demo.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/scripts/form-validation.js') }}"></script>
<script>
jQuery(document).ready(function() {
    //Metronic.init();
    Demo.init();
    $("#menuForm").validate();
});
</script>
<script>
    $(function() {

        $(".sorting_parent").live('click',function(){
            //alert('test');
            var pid = $(this).attr('id').replace('up_parent_','').replace('down_parent_','');
            if($(this).attr('id') == 'up_parent_'+pid)
            {
                var sort = 'up';
            }
            else
            var sort = 'down';
            
                var order = '';// array to hold the id of all the child li of the selected parent
                $('.parentinfo li').each(function(index) {
                    var val = $(this).attr('id').replace('parent', '');
                    //var val=item[1];
                    if (order == '') {
                        order = val;
                    } else {
                        order = order + ',' + val;
                    }
                });
                $.ajax({
                    url: '<?php echo url('restaurant/orderCat/');?>/'+pid+'/'+sort,
                    data: 'ids=' + order +'&_token=<?php echo csrf_token();?>',
                    type: 'post',
                    success: function() {
                        location.reload();
                    }
                });
            
        });
        //$( "#sortable" ).disableSelection();
    });
/*
    function clear_all(cat_id) {
        $('#addopt' + cat_id + ' .addopt').each(function() {
            $(this).remove();
        });
        $('#addopt' + cat_id).hide();
        $('.hasopt' + cat_id).val(0);
    }*/
</script>
@stop