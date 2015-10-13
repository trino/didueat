@extends('layouts.default')
@section('content')

<div class="content-page">
    <div class="row">

        <div class="col-md-9 col-sm-8 col-xs-12 no-padding">

            <div id="postswrapper">
                @include('menus')

                <!--div class="margin-bottom-10 row clearfix">
                
                @foreach($menus_list as $value)
                <div class="col-md-3 col-sm-6 col-xs-12 margin-bottom-20">
                <a href="{{ url('restaurants/'.select_field('restaurants', 'ID', $value->restaurantId, 'Slug').'/menus') }}">
                <div class="product-item">
                <div class="pi-img-wrapper">
                <img src="{{ url('assets/images/products') }}/{{ ($value->image)?$value->image:'default.jpg' }}" class="img-responsive" alt="Menu6"/>
                </div>
                <h3><a href="{{ url('restaurants/'.select_field('restaurants', 'ID', $value->restaurantId, 'Slug').'/menus') }}">{{ $value->menu_item }}</a></h3>
                <div class="pi-price">${{ $value->price }}</div>
                
                <div class="sticker sticker-new"></div>
                </div>
                </a>
                </div>
                @endforeach
                
                </div-->
            </div>

            <div class="clearfix"></div>
            <div id="loadmoreajaxloader" style="display:none;">
                <center><img src="{{ asset('assets/images/ajax-loader.gif') }}"></center>
            </div>
            <div class="clearfix"></div>
            <?php if ($menus_list->hasMorePages()) { ?>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12  margin-bottom-10" style="margin-left: 15px;">
                        <button align="center" class="loadmore btn btn-primary">Load More</button>
                    </div>
                </div>
            <?php } ?>
            <div class="clearfix"></div>
        </div>

        <div class="col-md-3 col-sm-4 col-xs-12">

            <div class="portlet box red">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i>Logs List
                    </div>
                    <div class="tools">
                    </div>
                </div>
                <div class="portlet-body">
                    456<br>
                    456<br>
                    456<br>456<br>456<br>456<br>456<br>456<br>456<br>456<br>456<br>456<br>456<br>456<br>456<br>456<br>456<br>456<br>
                </div>
            </div>
        </div>

        <!-- END CONTENT -->
    </div>
</div>

@stop