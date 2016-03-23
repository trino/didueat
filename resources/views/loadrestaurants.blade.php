<div class="col-md-12 col-sm-12 col-xs-12">
    <?php
        printfile("views/loadrestaurants.blade.php");
        $alts = array(
                "restaurants/menu" => "View menu",
                "nextpage" => "Next Page",
                "logo" => "Your restaurant's logo"
        );
    ?>
    <table class="table table-bordered table-hover">
        <tbody>
        @foreach ($restaurants_list as $value)
            <tr>
                <td width="10%">
                    <a href="{{ url('restaurants/'.$value->slug.'/menu') }}" title="{{ $alts["restaurants/menu"] }}">
                        <img class="img-responsive full-width" alt="{{ $alts["logo"] }}"
                        @if(!empty($value->logo))
                            src="{{ asset('assets/images/restaurants/'.$value->id.'/thumb_'.$value->logo) }}">
                        @else
                            src="{{ asset('assets/images/default.png') }}">
                        @endif
                    </a>
                </td>
                <td width="80%">
                    <h2>
                        <a href="{{ url('restaurants/'.$value->slug.'/menu') }}" title="{{ $alts["restaurants/menu"] }}">{!! $value->name !!} </a>
                    </h2>
                    <ul class="blog-info">
                        <li>
                            <i class="fa fa-map-marker"></i>{!! $value->address.' , '.$value->city.' , '.$value->province.' , '. select_field("countries", 'id', $value->country, 'name') !!}
                            <i class="fa fa-truck"></i>{!!  $value->delivery_fee.' , '.$value->minimum !!}<i class="fa fa-tags"></i>{!! $value->phone !!}
                        </li>
                    </ul>
                <td width="10%">
                    <a href="{{ url('restaurants/'.$value->slug.'/menu') }}" class=" btn btn-success" title="{{ $alts["restaurants/menu"] }}">Order Online</a></td>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div style="display: none;" class="nxtpage">
    <li class="next"><a href="{{ $restaurants_list->nextPageUrl() }}" title="{{ $alts["nextpage"] }}">Next &gt;&gt;</a></li>
</div>