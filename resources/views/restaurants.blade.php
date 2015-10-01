@extends('layouts.default')
@section('content')

<div class="margin-bottom-40">
    <!-- BEGIN CONTENT -->
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="content-page">
            <div class="row margin-bottom-10">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <h1 class="">
                        <a href="#"></a> Local Restaurants
                    </h1>

                    <div class="margin-bottom-15">
                        <h4>Pick your cuisine type:</h4>
                        <a href="#" clicked="">All</a> | 
                        <a href="#1"><strong>Asian</strong></a> |
                    </div>

                    <div class="row margin-bottom-20 resturant-grid">
                        @foreach ($restaurants_list as $value) 
                        
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <h2>
                                <a href="{{ url('restaurants/'.$value->Slug.'/menus') }}">{!! $value->Name !!} </a>
                            </h2>
                            <div class="clearfix"></div>
                            <div class="resturants-items margin-bottom-20">
                                <div class="margin-bottom-15">
                                    <a href="{{ url('restaurants/'.$value->Slug.'/menus') }}">
                                        @if(!empty($value->Logo)) 
                                        <img class="img-responsive" alt="" src="{{ url('assets/images/restaurants/'.$value->Logo) }}">
                                        @else 
                                        <img class="img-responsive" alt="" src="{{ url('assets/images/default.png') }}">    
                                        @endif
                                     </a>
                                </div>
                                <div class="rating-details">
                                    <strong>{!! $value->Address !!}</strong>
                                    <ul class="blog-info">
                                        <li><i class="fa fa-map-marker"></i>{!! $value->Address.' , '.$value->City.' , '.$value->Province.' , '.$value->Country !!}</li>
                                        <li><i class="fa fa-truck"></i>{!!  $value->DeliveryFee.' , '.$value->Minimum !!}</li>
                                        <li><i class="fa fa-tags"></i>{!! $value->Phone !!}</li>
                                    </ul>
                                    <a href="{{ url('restaurants/'.$value->Slug.'/menus') }}" class=" btn btn-success">Order Online</a>
                                </div>
                            </div>
                        </div>
                        @endforeach 
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12  margin-bottom-10">
                            <button align="" class="loadmore btn btn-primary">Load More</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-4 col-xs-12">

                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
</div>

@stop