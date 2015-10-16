@extends('layouts.default')
@section('content')

    <div class="content-page">

        <div class="row default_page_padd">

            <div class="col-md-9 col-sm-8 col-xs-12">


                <h1 class="">
                    Local Meals
                </h1>
                {!! Form::open(array('url' => '/search/menus', 'id'=>'searchMenuForm2','class'=>'form-horizontal','method'=>'get','role'=>'form')) !!}
                <div class="input-group col-md-3" valign="center">
                    <input type="text" name="search_term" placeholder="Search Meals" class="form-control"/>
                                <span class="input-group-btn">
                                    <button class="btn btn-primary red" type="submit">Search</button>
                                </span>
                </div>
                {!! Form::close() !!}
                <br/>

                <div id="postswrapper" class="margin-bottom-10 clearfix">
                    @include('menus')
                </div>

                <div class="clearfix"></div>
                <div id="loadmoreajaxloader" style="display:none;">
                    <center><img src="{{ asset('assets/images/ajax-loader.gif') }}"></center>
                </div>
                <div class="clearfix"></div>
                <?php if ($menus_list->hasMorePages()) { ?>
                <div class="row margin-bottom-15">
                    <div class="col-md-12 col-sm-12 col-xs-12" style="">
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
                            <i class="fa fa-globe"></i>Filter Meals
                        </div>
                        <div class="tools">
                        </div>
                    </div>
                    <div class="portlet-body">
                        Filter by type<br>
                        Filter by type<br>
                        Filter by type<br>
                        Filter by type<br>
                        Filter by type<br>
                        Filter by type<br>
                        Filter by type<br>
                        Filter by type<br>
                        Filter by type<br>             Filter by type<br>
                        Filter by type<br>
                        Filter by type<br>
                        Filter by type<br>
                        Filter by type<br>
                        Filter by type<br>
                        Filter by type<br>
                        Filter by type<br>
                        Filter by type<br>             Filter by type<br>
                        Filter by type<br>
                        Filter by type<br>
                        Filter by type<br>
                        Filter by type<br>
                        Filter by type<br>
                        Filter by type<br>
                        Filter by type<br>
                        Filter by type<br>

                    </div>
                </div>
            </div>
        </div>
    </div>

@stop