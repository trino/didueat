@extends('layouts.default')
@section('content')

    <div class="margin-bottom-40">

            <div class="content-page">
                <div class="row margin-bottom-10">
                    <div class="col-md-9 col-sm-9 col-xs-9">
                        <h1 class="">
                            Local Restaurants
                        </h1>

                        {!! Form::open(array('url' => '/search/restaurants', 'id'=>'searchRestaurantForm2','class'=>'form-horizontal','method'=>'get','role'=>'form')) !!}
                        <div class="input-group" valign="center">
                            <input type="text" name="search_term" placeholder="Search Restaurants" class="form-control" />
                                <span class="input-group-btn">
                                    <button class="btn btn-primary red" type="submit">Search</button>
                                </span>
                        </div>
                        {!! Form::close() !!}
                        <br />

                        <div class="row margin-bottom-20 resturant-grid" id="postswrapper">
                            @include('loadrestaurants')
                        </div>

                        <div class="clearfix"></div>
                        <div id="loadmoreajaxloader" style="display:none;">
                            <img src="{{ asset('assets/images/ajax-loader.gif') }}">
                        </div>
                        <div class="clearfix"></div>
                        <?php if($restaurants_list->hasMorePages()){?>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12  margin-bottom-10">
                                <button align="" class="loadmore btn btn-primary">Load More</button>
                            </div>
                        </div>
                        <?php } ?>
                    </div>

                    <div class="col-md-3 col-sm-3 col-xs-12">

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
                </div>
            </div>

    </div>

@stop