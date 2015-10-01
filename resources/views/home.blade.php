@extends('layouts.default')
@section('content')

<div class="margin-bottom-40 index-page clearfix">
    <!-- BEGIN CONTENT -->
    <div class="col-md-12 col-sm-12 col-xs-12">
        <link rel="stylesheet" href="/Foodie/css/popstyle.css"/>

        <div id="postswrapper">
            <div class="margin-bottom-10 clearfix">
                
                @foreach($menus_list as $value)
                <div class="col-md-3 col-sm-6 col-xs-12 margin-bottom-20">
                    <a href="{{ url('restaurants/'.select_field('restaurants', 'ID', $value->restaurantId, 'Slug').'/menus') }}">
                        <div class="product-item">
                            <div class="pi-img-wrapper">
                                <img src="{{ url('assets/images/products') }}/{{ ($value->image)?$value->image:'default.jpg' }}" class="img-responsive" alt="Menu6"/>
                            </div>
                            <h3><a href="{{ url('restaurants/'.select_field('restaurants', 'ID', $value->restaurantId, 'Slug').'/menus') }}">{{ $value->menu_item }}</a></h3>
                            <div class="pi-price">${{ $value->price }}</div>
                            <!--<a href="#" class="btn btn-default add2cart">Add to cart</a-->
                            <div class="sticker sticker-new"></div>
                        </div>
                    </a>
                </div>
                @endforeach
                
            </div> 
        </div>
        
        <div class="clearfix"></div>
        <div class="col-md-12  margin-bottom-10">
            <button align="center" class="loadmore btn btn-primary">Load More</button>
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- END CONTENT -->
</div>

@stop