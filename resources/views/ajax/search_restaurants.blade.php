@foreach($query as $value) 
<?php 
$logo = ($value->logo)?'restaurants/'.$value->logo:'default.png';
?>
<article class="col-md-12">
    <div class="entry-inner">
        <div class="entry-media">
            <a class="menu-thumb ht-lightbox" href="{{ url('restaurants/'.$value->slug.'/menus') }}" title="{{ $value->name }}">
                <img width="100" src="{{ asset('assets/images/'.$logo) }}" class="attachment-square wp-post-image" alt="{{ $value->name }}">
            </a>
        </div>
        <div class="entry-content">
            <div>
                <h4 class="entry-title"><span><span>{{ $value->name }}</span></span></h4>
            </div>
            <div class="entry-excerpt">{{ $value->description }}</div>
            <div class="entry-delivery-price">Delivery Fee: ${{ $value->delivery_fee }}</div>
            <div class="entry-min-delivery">Minimum Fee: ${{ $value->minimum }}</div>
            <div class="entry-min-delivery">Phone: {{ $value->phone }}</div>
        </div>
    </div>
</article>
@endforeach


<button type="button" class="btn btn-primary btn-lg loadMoreRestaurants" data-offset="{{ $start }}">Load more</button>
<img id="loadingbar" src="{{ asset('assets/images/loader.gif') }}" style="display: none;" />
