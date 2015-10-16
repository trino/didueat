@extends('layouts.default')
@section('content')
    <link rel="stylesheet" href="<?php echo url('assets');?>/global/css/popstyle.css">

    <div class="content-page">
        <div class="row">

            <div class="col-md-9 col-sm-8 col-xs-12">
                {!! Form::open(array('url' => '/search/menus', 'id'=>'searchMenuForm2','class'=>'form-horizontal','method'=>'get','role'=>'form')) !!}
                <div class="input-group" valign="center">
                    <input type="text" name="search_term" placeholder="Search Meals" class="form-control" value="{{ $term }}" />
                    <span class="input-group-btn">
                        <button class="btn btn-primary red" type="submit">Search</button>
                    </span>
                </div>
                {!! Form::close() !!}

                <br /><h1>[{{ $count }}] Meals Found</h1><br />

                <div id="menus_bar" class="margin-bottom-20 clearfix">
                    @include('ajax.search_menus')
                </div>

                <div class="clearfix"></div>
                <button type="button" class="btn btn-primary btn-lg loadMoreMenus margin-bottom-15" data-offset="{{ $start }}">Load more</button>
                <img id="loadingbar" src="{{ asset('assets/images/loader.gif') }}" style="display: none;" />
                {!! csrf_field() !!}
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



<script type="text/javascript">
    $('body').on('click', '.loadMoreMenus', function(){
            var search = "{{ $term }}";
            var offset = $('#menus_bar .parentDiv:last').attr('id');
            var token = $('input[name=_token]').val();

            $('.loadingbar').show();
            $.post("{{ url('/search/menus/ajax') }}", {start:offset, term:search, _token:token}, function(result){
                $('.loadingbar').hide();
                $('#menus_bar').append(result);
                if(!result){
                    $('.loadMoreMenus').remove();
                }
            });
        });
</script>
@stop