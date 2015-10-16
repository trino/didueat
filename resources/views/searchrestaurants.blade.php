@extends('layouts.default')
@section('content')


    <div class="margin-bottom-40">

        <div class="content-page">
            <div class="row margin-bottom-10">
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <h1 class="">
                        [{{ $count }}] Local Restaurants Founds
                    </h1>

                    {!! Form::open(array('url' => '/search/restaurants', 'id'=>'searchRestaurantForm2','class'=>'form-horizontal','method'=>'get','role'=>'form')) !!}
                    <div class="input-group" valign="center">
                        <input type="text" name="search_term" placeholder="Search Restaurants" class="form-control" value="{{ $term }}" />
                        <span class="input-group-btn">
                            <button class="btn btn-primary red" type="submit">Search</button>
                        </span>
                    </div>
                    {!! Form::close() !!}
                    <br />

                    <div class="row margin-bottom-20 resturant-grid" id="postswrapper">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <table id="tableRestuarant" class="table table-bordered table-hover">
                                <tbody id="restuarant_bar">
                                @include('ajax.search_restaurants')
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <button type="button" class="btn btn-primary btn-lg loadMoreRestaurants margin-bottom-15">Load more</button>
                    <img id="loadingbar" src="{{ asset('assets/images/loader.gif') }}" style="display: none;" />
                    {!! csrf_field() !!}
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


<script type="text/javascript">
    $('body').on('click', '.loadMoreRestaurants', function(){
        var search = "{{ $term }}";
        var offset = $('#tableRestuarant tr:last').attr('id');
        var token = $('input[name=_token]').val();

        $('.loadingbar').show();
        $.post("{{ url('/search/restaurants/ajax') }}", {start:offset, term:search, _token:token}, function(result){
            $('.loadingbar').hide();
            $('#restuarant_bar').append(result);
            if(!result){
                $('.loadMoreRestaurants').remove();
            }
        });
    });
</script>

@stop