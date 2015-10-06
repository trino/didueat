@extends('layouts.default')
@section('content')

<div class="margin-bottom-40 index-page clearfix">
    <!-- BEGIN CONTENT -->
    <div class="col-md-12 col-sm-12 col-xs-12">
        <link rel="stylesheet" href="/Foodie/css/popstyle.css"/>

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
        <?php if($menus_list->hasMorePages()){?>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12  margin-bottom-10" style="margin-left: 15px;">
                    <button align="center" class="loadmore btn btn-primary">Load More</button>
                </div>
            </div>
        <?php }?>
        <div class="clearfix"></div>
    </div>
    <!-- END CONTENT -->
</div>

@stop