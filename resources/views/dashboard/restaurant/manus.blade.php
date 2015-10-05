@extends('layouts.default')
@section('content')

<div class="margin-bottom-40">
    <!-- BEGIN CONTENT -->
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="row content-page">

            <div class="col-md-12 col-sm-12 col-xs-12 no-padding">
            <div class="row">
                @include('layouts.includes.leftsidebar')

                <div class="col-md-10 col-sm-8 col-xs-12 no-padding">
                    @if(Session::has('message'))
                    <div class="alert alert-info">
                        <strong>Alert!</strong> &nbsp; {!! Session::get('message') !!}
                    </div>
                    @endif

                    <div class="dashboard">
                        <div class="menu-manager">
                            <h1>Menu Manager</h1>
                            <hr>
                            <a class="btn btn-primary red add_item" id="add_item0" href="javascript:void(0)">Add New Menu Item</a>
                            <div class="addnew" style="display: none;"></div>
                            <hr>
                            <ul class="parentinfo ui-sortable" id="sortable">
                                @foreach($menus_list as $value)
                                
                                <li class="infolistwhite row marbot newmenus ui-sortable-handle" id="parent{{ $value->ID }}">
                                    <div class="col-md-4 menu_item col-sm-4 col-xs-12">
                                        <div class="col-sm-4 col-xs-12" style="padding: 0;">
                                            <img class="itemimg4 itemimg" src="{{ asset('assets/images/products') }}/<?php echo ($value->image) ? $value->image : 'default.jpg'; ?>" />
                                        </div>
                                        <div class="col-sm-8 col-xs-12">
                                            <h4>{{ $value->menu_item }}</h4>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <a href="javascript:void(0)" id="add_item{{ $value->ID }}" class="btn btn-success green add_item">Edit Item</a>
                                        <a href="<?php echo url();?>/restaurant/deleteMenu/<?php echo $value->ID;?>" onclick="return confirm('Are you sure you want to delete this item?');" id="deleteitem{{ $value->ID }}" class="deletecat btn red">Delete</a>
                                        <div style="clear: both;"></div>
                                    </div>
                                    <div class="clearfix"></div>
                                </li>
                                <hr class="blog-post-sep ui-sortable-handle">
                                @endforeach
                            </ul>
                        </div>

                    </div>
                    <div class="clearfix  hidden-xs"></div>
                </div>

            </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
</div>


<script type="text/javascript" src="{{ asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}"></script>
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ asset('assets/global/scripts/metronic.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/layout/scripts/demo.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/pages/scripts/form-validation.js') }}"></script>
<script>
jQuery(document).ready(function() {
    Metronic.init();
    Demo.init();
    $("#menuForm").validate();
});
</script>
<script>
    $(function() {
        
        $("#sortable").sortable({
            update: function(event, ui) {
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
                    url: '<?php echo url('restaurant/orderCat/');?>',
                    data: 'ids=' + order +'&_token=<?php echo csrf_token();?>',
                    type: 'post',
                    success: function() {
                        //
                    }
                });
            }
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