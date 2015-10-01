@extends('layouts.default')
@section('content')

<div class="margin-bottom-40">
    <!-- BEGIN CONTENT -->
    <div class="col-md-12 col-xs-12">
        <div class="row content-page">

            <div class="col-md-12 no-padding">
            <div class="row">
                @include('layouts.includes.leftsidebar')

                <div class="col-md-9 col-sm-8 col-xs-12 no-padding">
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
                                        <a href="javascript:void(0)" onclick="return confirm('Are you sure you want to delete this item?');" id="deleteitem{{ $value->ID }}" class="deletecat btn red">Delete</a>
                                        <a href="javascript:void(0)" class="expandbtn expand{{ $value->ID }}"><span class="expand"></span></a>
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
        function makeid(){
            var text = "";
            var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

            for( var i=0; i < 5; i++ ){
                text += possible.charAt(Math.floor(Math.random() * possible.length));
            }
            return text;
        }

        $('body').on('click', '.add_additional', function() {
            if (!$('.menuwrapper').is(':visible')) {
                $('.menuwrapper').show();
            } else {
                var addons = '<div class="menuwrapper">' + $('#menuRapperContents').html() + '</div>';
                $('#menu_addons_wrapper').append(addons);
                $('.menuwrapper:last').find('.removeAddonBtn').show();
            }
            var numItems = parseInt($('.addmore').length)-1;
            $('.addmore:last').find('.sub_menu_item').attr('name', 'sub_menu_item['+numItems+'][]');
            $('.addmore:last').find('.sub_price').attr('name', 'sub_price['+numItems+'][]');
            
            var number1 = makeid();
            var number2 = makeid();
            var number3 = makeid();
            $('.radio_req_opt:last').find('input[type=radio]').attr('name', number1);
            $('.radio_sing_mul:last').find('input[type=radio]').attr('name', number2);
            $('.radio_exact_upto:last').find('input[type=radio]').attr('name', number3);
        });

        $('body').on('click', '.removeAddonBtn', function() {
            if (confirm('Are you sure, you want to remove this addon?')) {
                $(this).parent().parent().remove();
            }
        });

        $('body').on('change', '.is_multiple', function() {
            if ($(this).val() == 0) {
                $(this).parent().parent().find('.exact').show();
            } else {
                $(this).parent().parent().find('.exact').hide();
            }
        });

        $('body').on('click', '.addmorebtn', function() {
            var content = $(this).parent().siblings('.addmore').children('#addmorerow').html();
            //alert(content)
            var row = '<div class="cmore">' + content + '</div>';
            $(this).parent().siblings('.addmore').append(row);
            $(this).parent().siblings('.addmore').children('.cmore:last').find('.no-padding').show();
        });

        $('body').on('click', '.itemRemove', function() {
            if (confirm('Are you sure, you want to remove this item?')) {
                $(this).parent().remove();
            }
        });

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
                    url: 'menus/orderCat/',
                    data: 'ids=' + order,
                    type: 'post',
                    success: function() {
                        //
                    }
                });
            }
        });
        //$( "#sortable" ).disableSelection();
    });

    function clear_all(cat_id) {
        $('#addopt' + cat_id + ' .addopt').each(function() {
            $(this).remove();
        });
        $('#addopt' + cat_id).hide();
        $('.hasopt' + cat_id).val(0);
    }
</script>
@stop