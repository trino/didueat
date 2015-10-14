@extends('layouts.default')
@section('content')

<div id="menus_bar">
@foreach($query as $value) 
<?php 
$image = ($value->image)?$value->image:'default.jpg';
?>
<article class="col-md-12">
    <div class="entry-inner">
        <div class="entry-media">
            <a class="menu-thumb ht-lightbox" href="#" title="Delirium Tremens">
                <img width="71" src="{{ asset('assets/images/products/'.$image) }}" class="attachment-square wp-post-image" alt="qz">
            </a>
        </div>
        <div class="entry-content">
            <div>
                <h4 class="entry-title"><span><span>{{ $value->menu_item }}</span></span></h4>
            </div>
            <div class="entry-excerpt">{{ $value->description }}</div>
            <div class="entry-price">${{ $value->price }}</div>
        </div>
    </div>
</article>
@endforeach
</div>

<button type="button" class="btn btn-primary btn-lg loadMoreMenus" data-offset="{{ $start }}">Load more</button>
<img id="loadingbar" src="{{ asset('assets/images/loader.gif') }}" style="display: none;" />
{!! csrf_field() !!}


<script type="text/javascript">
    $('body').on('click', '.loadMoreMenus', function(){
            var search = "{{ $term }}";
            var offset = $(this).attr('data-offset');
            var token = $('input[name=_token]').val();
            
            $('.loadMoreMenus').remove();
            $('.loadingbar').show();
            $.post("{{ url('/search/menus/ajax') }}", {start:offset, term:search, _token:token}, function(result){
                $('.loadingbar').remove();
                $('#menus_bar').append(result);
            });
        });
</script>
@stop