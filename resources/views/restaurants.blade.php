@extends('layouts.default')
@section('content')

    <div class="margin-bottom-40">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="content-page">
                <div class="row margin-bottom-10">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <h1 class="">
                            <a href="#"></a> Local Restaurants
                        </h1>

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
                        <?php }?>






                    </div>

                    <div class="col-md-4 col-sm-4 col-xs-12">

                    </div>
                </div>
            </div>
        </div>

    </div>
    <script>

    </script>

@stop