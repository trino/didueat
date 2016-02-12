@extends('layouts.default')
@section('content')

DELETE THIS PAGE
    <?php printfile("views/dashboard/restaurant/manus.blade.php"); ?>


@if(false)








            <div class="row">
                @include('layouts.includes.leftsidebar')

                <div class="col-xs-12 col-sm-8 col-md-10 menu_managers_edits">
                    <?php printfile("views/dashboard/restaurant/manus.blade.php"); ?>
                    <div class="btn_wrapper margin-bottom-20 clearfix">
                        <a class="btn btn-primary add_item pull-right" id="add_item0" href="javascript:void(0)">Add Menu Item</a>
                    </div>
                    <div class="box-shadow">
                        <div class="portlet-title">
                            <div class="caption">
                                MENU MANAGER
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <div class="form-body">
                                <div class="dashboard">
                                    <div class="menu-manager">
                                        <div class="addnew" style="display: none;"></div>
                                        <ul class="parentinfo padding-left-0" id="sortable">

                                            @foreach($menus_list as $value)
                                                <li class="infolistwhite marbot newmenus no-margin"
                                                    id="parent{{ $value->id }}" style="">
                                                    <div class="col-md-4 menu_item col-sm-4 col-xs-12 ignore">
                                                        <div class="row">
                                                            <div class="col-sm-1 col-xs-12 ignore padding-0">
                                                                @if(!empty($value->image))
                                                                    <img class="itemimg4 itemimg ignore" alt="" src="{{ asset('assets/images/restaurants/'.$value->restaurant_id.'/menus/'.$value->id.'/thumb_'.$value->image) }}">
                                                                @else
                                                                    <img class="itemimg4 itemimg ignore" alt="" src="{{ asset('assets/images/default.png') }}">
                                                                @endif
                                                            </div>
                                                            <div class="col-sm-8 col-xs-12 ignore">
                                                                <h4 class="ignore">{{ $value->menu_item }}</h4>
                                                            </div>
                                                            <div class="clearfix ignore"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 col-sm-8 col-xs-12 ignore padding-right-0">
                                                        <div class="row">
                                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                                <a href="javascript:void(0)" id="add_item{{ $value->id }}" class="btn ignore btn-success green add_item">Edit Item</a>
                                                                <a href="{{ url('/restaurant/deleteMenu/'.$value->id) }}" onclick="return confirm('Are you sure you want to delete {{ addslashes("'" . $value->menu_item . "'") }} ?');" id="deleteitem{{ $value->id }}" class="deletecat btn ignore"><i class="fa fa-times"></a>
                                                                <div style="clear: both;" class="ignore"></div>
                                                            </div>
                                                            <div class="resturant-arrows col-md-3 col-sm-3 col-xs-12">
                                                                <a href="javascript:void(0);" id="up_parent_{{ $value->id }}" class="sorting_parent"><i class="fa fa-angle-up"></i></a>
                                                                <a href="javascript:void(0);" id="down_parent_{{ $value->id }}" class="sorting_parent"><i class="fa fa-angle-down"></i></a>
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



    <script type="text/javascript" src="{{ asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}"></script>
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{ asset('assets/global/scripts/metronic.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/scripts/demo.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/scripts/form-validation.js') }}"></script>
    <script>
        jQuery(document).ready(function () {
            $("#menuForm").validate();

            $(".sorting_parent").live('click', function () {
                //alert('test');
                var pid = $(this).attr('id').replace('up_parent_', '').replace('down_parent_', '');
                var sort = 'down';
                if ($(this).attr('id') == 'up_parent_' + pid) {
                    sort = 'up';
                }

                var order = '';// array to hold the id of all the child li of the selected parent
                $('.parentinfo li').each(function (index) {
                    var val = $(this).attr('id').replace('parent', '');
                    //var val=item[1];
                    if (order == '') {
                        order = val;
                    } else {
                        order = order + ',' + val;
                    }
                });
                $.ajax({
                    url: "{{ url('restaurant/orderCat') }}/" + pid + '/' + sort,
                    data: 'ids=' + order + "&_token={{ csrf_token() }}",
                    type: 'post',
                    success: function () {
                        location.reload();
                    }
                });

            });
            //$( "#sortable" ).disableSelection();
        });
    </script>

    @endif
@stop