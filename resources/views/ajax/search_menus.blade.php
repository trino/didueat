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


<button type="button" class="btn btn-primary btn-lg loadMoreMenus" data-offset="{{ $start }}">Load more</button>
<img id="loadingbar" src="{{ asset('assets/images/loader.gif') }}" style="display: none;" />
