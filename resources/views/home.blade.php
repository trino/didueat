@extends('layouts.default')
@section('content')

<div class="content-page">

    <div class="row">

        <div class="col-md-9 col-sm-8 col-xs-12 no-padding">
            {!! Form::open(array('url' => '/search/menus', 'id'=>'searchMenuForm2','class'=>'form-horizontal','method'=>'get','role'=>'form')) !!}
            <div class="input-group" valign="center">
                <input type="text" name="search_term" placeholder="Search Menus" class="form-control" />
                                <span class="input-group-btn">
                                    <button class="btn btn-primary red" type="submit">Search</button>
                                </span>
            </div>
            {!! Form::close() !!}
            <br />

            <div id="postswrapper" class="margin-bottom-20 clearfix">
                @include('menus')
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