@extends('layouts.default')
@section('content')

<div class="margin-bottom-40">
    <!-- BEGIN CONTENT -->
    <div class="col-md-12 col-xs-12">
        <div class="row content-page">

            <div class="col-md-12 no-padding">
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
                            <a class="btn btn-primary add_item" id="add_item0" data-toggle="modal" href="#basic">Add New Menu Item</a>
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
                                        <a href="#" id="add_item1" class="btn btn-success add_item">Edit Item</a>
                                        <a href="#" onclick="return confirm('Are you sure you want to delete this item?');" id="deleteitem1" class="deletecat btn btn-danger">Delete</a>
                                        <a href="javascript:void(0)" class="expandbtn expand1"><span class="expand"></span></a>
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
    <!-- END CONTENT -->
</div>


<div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Add Menu</h4>
            </div>
            <!-- BEGIN FORM-->
            {!! Form::open(array('url' => '/restaurant/menus-manager', 'class'=>'form-horizontal form-row-seperated', 'id'=>'menuForm','method'=>'post','role'=>'form', 'enctype'=>'multipart/form-data')) !!}
            <div class="modal-body menu-model-max-height">
                <div class="portlet">
                    <div class="portlet-body form">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">Menu Title <span class="required">*</span></label>
                                <div class="col-md-9">
                                    <input type="text" name="menu_item" placeholder="Menu Title" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Price <span class="required">*</span></label>
                                <div class="col-md-9">
                                    <input type="text" name="price" placeholder="Price" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Description <span class="required">*</span></label>
                                <div class="col-md-9">
                                    <input type="text" name="description" placeholder="Description" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Image <span class="required">*</span></label>
                                <div class="col-md-9">
                                    <input type="file" name="menu_image" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12">

                                    <div id="menu_addons_wrapper">
                                        <div class="menuwrapper" id="menuRapperContents" style="display: none;">
                                            <div class="col-sm-12 lowheight row">
                                                <a href="javascript:void(0)" class="btn btn-danger removeAddonBtn right" style="display: none;">Remove</a>
                                            </div>
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="col-sm-12 lowheight row">
                                                    <input type="text" name="addon_menu_item[]" placeholder="Title" class="form-control ctitle"><br>
                                                    <textarea name="addon_description[]" placeholder="Description" class="form-control cdescription"></textarea>    
                                                </div>
                                                <div class="col-sm-12 additionalitems">
                                                    <div class="aitems row">
                                                        <div class="addmore">
                                                            <div class="cmore" id="addmorerow">
                                                                <div class="col-md-10 col-sm-10 col-xs-10 nopadd">
                                                                    <input name="sub_menu_item[0][]" class="form-control sub_menu_item" type="text" placeholder="Item">
                                                                    <input name="sub_price[0][]" class="form-control sub_price" type="text" placeholder="Price" style="margin-left:10px;">   
                                                                </div> 
                                                                <div class="col-md-2 col-sm-2 col-xs-2 no-padding itemRemove" style="display: none;">
                                                                    <a href="javascript:void(0);" class="btn btn-danger btn-small"><span class="fa fa-close"></span></a>  
                                                                </div>
                                                                <div class="clearfix"></div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 col-sm-12 col-xs-12 nopadd">
                                                            <br>
                                                            <a href="javascript:void(0);" class="btn btn-success btn-small addmorebtn">Add more</a>  
                                                        </div>
                                                        <div class="clearfix"></div> 
                                                        <br>
                                                        <div class="radios">
                                                            <strong>These items are:</strong>
                                                            <div class="infolist radio_req_opt">
                                                                <input type="radio" value="0" class="is_required" checked onclick="$(this).parent().find('.req_opt').val(0);"> Optional
                                                                &nbsp; &nbsp; OR&nbsp; &nbsp; 
                                                                <input type="radio" value="1" class="is_required" onclick="$(this).parent().find('.req_opt').val(1);"> Required
                                                                <input type="hidden" name="req_opt[]" class="req_opt" value="0" />
                                                            </div>
                                                            <br>
                                                            <strong>Customer can select:</strong>
                                                            <div class="infolist radio_sing_mul">
                                                                <input type="radio" value="1" class="is_multiple" checked onclick="$(this).parent().find('.sing_mul').val(1);"> Single
                                                                &nbsp; &nbsp; OR&nbsp; &nbsp; 
                                                                <input type="radio" value="0" class="is_multiple" onclick="$(this).parent().find('.sing_mul').val(0);"> Multiple
                                                                <input type="hidden" name="sing_mul[]" class="sing_mul" value="1" />
                                                            </div>
                                                            <div style="display: none;" class="infolist exact">
                                                                <br>
                                                                <div>
                                                                    <div style="padding-left:0;" class="col-xs-12 col-sm-4"><strong>Enter # of items</strong></div>
                                                                    <div class="col-xs-12 col-sm-8 radio_exact_upto">
                                                                        <input type="radio" value="0" class="up_to up_to_selected" checked onclick="$(this).parent().find('.exact_upto').val(0);"> Up to 
                                                                        &nbsp;
                                                                        <input type="radio" value="1" class="up_to" onclick="$(this).parent().find('.exact_upto').val(1);"> Exactly
                                                                        <input type="hidden" name="exact_upto[]" class="exact_upto" value="0" />
                                                                    </div>
                                                                    <div style="clear:both;"></div>
                                                                    <div class="clearfix"></div>
                                                                </div>
                                                                <input type="text"name="exact_upto_qty[]" class="itemno form-control">
                                                            </div>
                                                        </div>

                                                        <div class="clearfix"></div> 
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>   
                                            </div>
                                            <div class="clearfix"></div>    
                                        </div>
                                    </div>

                                    <a class="btn green right add_additional"><i class="fa fa-adn"></i> Add Addon</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn blue">Save changes</button>
            </div>
            {!! Form::close() !!}
            <!-- END FORM-->
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

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